<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class SuratTugasExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithStyles, 
    ShouldAutoSize, 
    WithEvents, 
    WithCustomStartCell,
    WithTitle
{
    protected $data;
    protected $semester;

    public function __construct(Collection $data, ?string $semester = null)
    {
        $this->data = $data;
        $this->semester = $semester;
    }

    public function collection()
    {
        return $this->data;
    }

    public function startCell(): string
    {
        return 'A3'; // tabel mulai dari baris ke-3
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dosen',
            'Peran',
            'Diminta Sebagai',
            'Mitra/Instansi',
            'No & Tgl Surat Instansi',
            'No & Tgl Surat Kadep',
            'Tgl Kegiatan',
            'Lokasi',
            'Dokumen Pendukung',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->nama_dosen,
            $row->peran,
            $row->diminta_sebagai ?? '-',
            $row->mitra_instansi ?? '-',
            ($row->no_surat_instansi ?? '-') . ' | ' . ($row->tgl_surat_instansi?->format('d/m/Y') ?? '-'),
            ($row->no_surat_kadep ?? '-') . ' | ' . ($row->tgl_surat_kadep?->format('d/m/Y') ?? '-'),
            $row->tgl_kegiatan?->format('d/m/Y') ?? '-',
            $row->lokasi ?? '-',
            $row->dokumen 
                ? 'Lihat Dokumen'
                : 'Tidak ada dokumen (bukan surat tugas)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();

        // Header tabel (baris ke-3)
        $sheet->getStyle('A3:J3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => 'solid',
                'color' => ['rgb' => 'D9D9D9'],
            ],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
        ]);

        // Border semua isi
        $sheet->getStyle("A3:J{$lastRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
            'alignment' => ['vertical' => 'top', 'wrapText' => true],
        ]);

        // Kolom tertentu rata tengah
        $sheet->getStyle("A4:A{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("H4:H{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("I4:I{$lastRow}")->getAlignment()->setHorizontal('center');
        $sheet->getStyle("J4:J{$lastRow}")->getAlignment()->setHorizontal('center');

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Tambahin judul di baris 1
                $judul = "Laporan Surat Tugas";
                if ($this->semester) {
                    // ubah underscore ke spasi biar rapi di Excel
                    $judul .= " - Semester " . str_replace('_', ' ', ucfirst($this->semester));
                }

                $sheet->setCellValue('A1', $judul);
                $sheet->mergeCells('A1:J1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);

                // Auto-size kolom
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Tambahin hyperlink / styling untuk kolom Dokumen Pendukung (J)
                $rowIndex = 4; // data mulai dari baris ke-4
                foreach ($this->data as $item) {
                    $cell = "J{$rowIndex}";

                    if ($item->dokumen) {
                        $url = asset('storage/'.$item->dokumen);
                        $sheet->getCell($cell)->getHyperlink()->setUrl($url);
                        $sheet->getStyle($cell)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '0563C1'],
                                'underline' => 'single'
                            ]
                        ]);
                    } else {
                        // Kalau tidak ada dokumen → merah + bold
                        $sheet->getStyle($cell)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => 'FF0000'],
                                'bold' => true
                            ]
                        ]);
                    }

                    $rowIndex++;
                }
            },
        ];
    }

    public function title(): string
    {
        return $this->semester 
            ? "Surat Tugas " . ucfirst($this->semester)
            : "Surat Tugas";
    }
}