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
use Illuminate\Support\Facades\Storage;

class PembimbingLuarExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
                $item->tahun_semester ?? '-',
                $item->nim ?? '-',
                $item->nama_mahasiswa ?? '-',
                $item->universitas ?? '-',
                $item->program_studi ?? '-',
                ucfirst($item->insidental ?? 'Tidak'),
                ucfirst($item->lebih_dari_1_semester ?? 'Tidak'),
                ucfirst($item->status_verifikasi ?? 'Menunggu'),
                $item->file_path ? url(Storage::url($item->file_path)) : '-',
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
            'Tahun Semester',
            'NIM',
            'Nama Mahasiswa',
            'Universitas',
            'Program Studi',
            'Insidental',
            'Lebih Dari 1 Semester',
            'Status Verifikasi',
            'Link Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambahkan judul di baris paling atas
        $sheet->insertNewRowBefore(1, 2);

        $judul = 'Data Pembimbing Luar';
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

                // Border semua sel
                $sheet->getStyle("A3:L{$rowCount}")
                    ->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah vertikal
                $sheet->getStyle("A3:L{$rowCount}")
                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                // Rata kiri untuk teks panjang
                $sheet->getStyle("B4:H{$rowCount}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);

                // Lebar kolom
                $columnWidths = [
                    'A' => 5,  'B' => 45, 'C' => 25, 'D' => 20, 'E' => 15, 
                    'F' => 25, 'G' => 25, 'H' => 25, 'I' => 15, 'J' => 22,
                    'K' => 20, 'L' => 50,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Row height
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

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