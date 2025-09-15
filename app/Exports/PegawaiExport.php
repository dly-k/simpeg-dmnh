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
    private $rowNumber = 0;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * PERUBAHAN DI SINI:
     * Mengambil kolom spesifik dari database sesuai permintaan.
     */
    public function collection()
    {
        $query = Pegawai::select([
            'nama_lengkap',
            'nip',
            'jabatan_struktural',
            'jabatan_fungsional',
            'pangkat_golongan',
            'alamat_domisili', // Kolom untuk alamat
            'no_telepon'       // Kolom untuk no telp
        ]);

        if ($this->type === 'aktif') {
            return $query->where('status_pegawai', 'Aktif')->get();
        } else {
            return $query->where('status_pegawai', '!=', 'Aktif')->get();
        }
    }

    /**
     * PERUBAHAN DI SINI:
     * Menyesuaikan judul header kolom di Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'NIP',
            'Jabatan Struktural',
            'Jabatan Fungsional',
            'Pangkat/Golongan',
            'Alamat',
            'No. Telp',
        ];
    }

    /**
     * PERUBAHAN DI SINI:
     * Memetakan data ke setiap kolom Excel.
     */
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

    /**
     * PERUBAHAN DI SINI:
     * Menyesuaikan styling untuk 8 kolom (A sampai H).
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $title = $this->type === 'aktif' ? 'DAFTAR PEGAWAI AKTIF' : 'RIWAYAT PEGAWAI';
                $lastColumn = 'H'; // Kolom terakhir sekarang H
                $range = 'A1:' . $lastColumn . '1';
                $headerRange = 'A3:' . $lastColumn . '3';

                $sheet->insertNewRowBefore(1, 2);
                $sheet->setCellValue('A1', $title . ' DEPARTEMEN MANAJEMEN HUTAN');
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

                // Pusatkan kolom No, NIP, dan seterusnya
                $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C4:{$lastColumn}{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}