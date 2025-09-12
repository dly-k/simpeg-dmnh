<?php

namespace App\Exports;

use App\Models\Kerjasama;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KerjasamaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithEvents
{
    protected $search;
    protected $jenis;
    private $rowNumber = 0;

    public function __construct($search = null, $jenis = null)
    {
        $this->search = $search;
        $this->jenis = $jenis;
    }

    public function collection()
    {
        return Kerjasama::when($this->search, function ($query) {
                $query->where('judul', 'like', "%{$this->search}%")
                      ->orWhere('mitra', 'like', "%{$this->search}%");
            })
            ->when($this->jenis && $this->jenis !== 'Semua', function ($query) {
                $query->where('jenis_kerjasama', $this->jenis);
            })
            ->select(
                'judul',
                'mitra',
                'no_surat_mitra',
                'no_surat_departemen',
                'tmt',
                'tst',
                'departemen_penanggung_jawab',
                'lokasi',
                'besaran_dana',
                'jenis_kerjasama'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul Kerjasama',
            'Mitra',
            'No. Surat Mitra',
            'No. Surat Departemen',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Departemen Penanggung Jawab',
            'Lokasi',
            'Besaran Dana (Rp)',
            'Jenis Kerjasama',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->judul,
            $row->mitra,
            $row->no_surat_mitra,
            $row->no_surat_departemen,
            $row->tmt ? date('d-m-Y', strtotime($row->tmt)) : '-',
            $row->tst ? date('d-m-Y', strtotime($row->tst)) : '-',
            $row->departemen_penanggung_jawab,
            $row->lokasi,
            number_format($row->besaran_dana, 0, ',', '.'),
            $row->jenis_kerjasama,
        ];
    }

    public function title(): string
    {
        return 'Arsip Kerjasama';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tambah 2 baris di atas
                $sheet->insertNewRowBefore(1, 2);

                // Judul besar di baris 1
                $sheet->setCellValue('A1', 'ARSIP KERJASAMA DEPARTEMEN MANAJEMEN HUTAN');
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Heading kolom (baris ke-3)
                $sheet->getStyle('A3:K3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9D9D9'], // abu-abu muda
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Dapatkan jumlah baris terakhir
                $lastRow = $sheet->getHighestRow();

                // Border semua isi data (mulai baris 4 sampai terakhir)
                $sheet->getStyle("A4:K{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'font' => [
                        'bold' => false, // pastikan isi tabel tidak bold
                    ],
                ]);

                // Kolom "No" (A) rata tengah
                $sheet->getStyle("A4:A{$lastRow}")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Kolom tanggal (F & G) rata tengah
                $sheet->getStyle("F4:G{$lastRow}")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Kolom "Lokasi" (I) rata tengah
                $sheet->getStyle("I4:I{$lastRow}")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                // Kolom "Jenis Kerjasama" (K) rata tengah
                $sheet->getStyle("K4:K{$lastRow}")->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}