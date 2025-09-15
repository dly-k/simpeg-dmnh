<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PegawaiExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithEvents
{
    protected $type;
    protected $search;
    protected $filter;
    private $rowNumber = 0;

    /**
     * PERUBAHAN DI SINI:
     * Constructor sekarang menerima parameter search dan filter.
     */
    public function __construct(string $type, $search = null, $filter = null)
    {
        $this->type = $type;
        $this->search = $search;
        $this->filter = $filter;
    }

    /**
     * PERUBAHAN DI SINI:
     * Query sekarang menerapkan filter dan pencarian.
     */
    public function collection()
    {
        $query = Pegawai::query();

        // Terapkan filter berdasarkan tipe (Aktif / Riwayat)
        if ($this->type === 'aktif') {
            $query->where('status_pegawai', 'Aktif');
            // Terapkan filter dropdown (Status Kepegawaian)
            $query->when($this->filter, function ($q) {
                return $q->where('status_kepegawaian', $this->filter);
            });
        } else {
            $query->where('status_pegawai', '!=', 'Aktif');
            // Terapkan filter dropdown (Status Riwayat)
            $query->when($this->filter, function ($q) {
                return $q->where('status_pegawai', $this->filter);
            });
        }

        // Terapkan filter pencarian (Nama / NIP)
        $query->when($this->search, function ($q) {
            return $q->where(function ($query) {
                $query->where('nama_lengkap', 'like', "%{$this->search}%")
                      ->orWhere('nip', 'like', "%{$this->search}%");
            });
        });

        // Pilih hanya kolom yang dibutuhkan untuk ekspor
        return $query->select([
            'nama_lengkap', 'nip', 'jabatan_struktural', 'jabatan_fungsional',
            'pangkat_golongan', 'alamat_domisili', 'no_telepon'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Lengkap', 'NIP', 'Jabatan Struktural', 'Jabatan Fungsional',
            'Pangkat/Golongan', 'Alamat', 'No. Telp',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->nama_lengkap,
            $row->nip,
            $row->jabatan_struktural ?? '-',
            $row->jabatan_fungsional,
            $row->pangkat_golongan,
            $row->alamat_domisili ?? '-',
            $row->no_telepon ?? '-',
        ];
    }

    public function title(): string
    {
        return $this->type === 'aktif' ? 'Daftar Pegawai Aktif' : 'Riwayat Pegawai';
    }
    
    public function registerEvents(): array
    {
        // ... (Kode styling tidak ada perubahan) ...
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $title = $this->type === 'aktif' ? 'DAFTAR PEGAWAI AKTIF' : 'RIWAYAT PEGAWAI';
                $lastColumn = 'H';
                $range = 'A1:' . $lastColumn . '1';
                $headerRange = 'A3:' . $lastColumn . '3';

                $sheet->insertNewRowBefore(1, 2);
                $sheet->setCellValue('A1', $title . ' DEPARTEMEN MANAJENEN HUTAN');
                $sheet->mergeCells($range);
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A4:{$lastColumn}{$lastRow}")->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);
                $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C4:{$lastColumn}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}