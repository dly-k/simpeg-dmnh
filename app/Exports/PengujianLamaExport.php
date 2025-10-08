<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PengujianLamaExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $semester;
    protected $status;
    protected $search;

    public function __construct(Collection $data, $semester = null, $status = null, $search = null)
    {
        $this->data = $data;
        $this->semester = $semester;
        $this->status = $status;
        $this->search = $search;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                $no++,
                $item->kegiatan ?? '-',
                $item->pegawai->nama_lengkap ?? '-',
                $item->nama_mahasiswa ?? '-',
                $item->nim ?? '-',
                $item->departemen ?? '-',
                ucfirst($item->status_verifikasi ?? 'Menunggu'),
                $item->file_path ? 'Terlampir' : 'Tidak ada dokumen',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kegiatan',
            'Nama Dosen',
            'Nama Mahasiswa',
            'NIM',
            'Departemen',
            'Status Verifikasi',
            'Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambahkan 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        $judul = 'Data Pengujian Lama';
        if (!empty($this->semester)) {
            $judul .= ' - Semester ' . $this->semester;
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }
        if (!empty($this->search)) {
            $judul .= ' (Filter: ' . $this->search . ')';
        }

        $lastCol = 'H';
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastCol}1");

        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = $this->data->count() + 3;

                // Border tabel
                $sheet->getStyle("A3:H{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah umum
                $sheet->getStyle("A3:H{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom teks rata kiri
                foreach (['B', 'C', 'E', 'F'] as $col) {
                    $sheet->getStyle("{$col}4:{$col}{$rowCount}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                        ->setWrapText(true);
                }

                // Header dan judul tebal
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom
                $widths = [
                    'A' => 5,  'B' => 25, 'C' => 25, 'D' => 15,
                    'E' => 20, 'F' => 25, 'G' => 20, 'H' => 20,
                ];
                foreach ($widths as $col => $w) {
                    $sheet->getColumnDimension($col)->setWidth($w);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:H3");

                // Zebra striping
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'color' => ['rgb' => 'F9F9F9'],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}