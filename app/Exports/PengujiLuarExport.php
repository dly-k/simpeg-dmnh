<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
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

class PengujiLuarExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
                $item->pegawai->nama_lengkap ?? '-',        // Nama Dosen
                $item->tahun_semester ?? '-',
                $item->kegiatan ?? '-',
                $item->nim ?? '-',
                $item->nama_mahasiswa ?? '-',
                $item->universitas ?? '-',
                $item->program_studi ?? '-',
                $item->is_insidental ?? '-',
                $item->is_lebih_satu_semester ?? '-',
                $item->file_path ? Storage::url($item->file_path) : '-',
                ucfirst($item->status_verifikasi ?? 'Menunggu'),
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Dosen',
            'Tahun Semester',
            'Kegiatan',
            'NIM',
            'Nama Mahasiswa',
            'Universitas',
            'Program Studi',
            'Insidental',
            'Lebih Dari 1 Semester',
            'Link Dokumen',
            'Status Verifikasi',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah baris judul di atas header
        $sheet->insertNewRowBefore(1, 2);

        $judul = 'Data Penguji Luar IPB';
        if (!empty($this->semester)) $judul .= ' - ' . $this->semester;
        if (!empty($this->status)) $judul .= ' - Status ' . ucfirst($this->status);
        if (!empty($this->search)) $judul .= ' (Filter: ' . $this->search . ')';

        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:L1');

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

                // Border
                $sheet->getStyle("A3:L{$rowCount}")
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Alignment umum
                $sheet->getStyle("A3:L{$rowCount}")
                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom teks rata kiri
                $sheet->getStyle("B4:K{$rowCount}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Row height
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom optimal
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 18, 'D' => 35,
                    'E' => 15, 'F' => 25, 'G' => 25, 'H' => 25,
                    'I' => 15, 'J' => 20, 'K' => 40, 'L' => 20,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter('A3:L3');

                // Zebra striping
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:L{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'color' => ['rgb' => 'F9F9F9']
                            ]
                        ]);
                    }
                }
            },
        ];
    }
}