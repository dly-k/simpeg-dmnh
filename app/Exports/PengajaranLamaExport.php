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
use Carbon\Carbon;

class PengajaranLamaExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $semester;
    protected $status;
    protected $pegawai;

    public function __construct(Collection $data, $semester = null, $status = null, $pegawai = null)
    {
        $this->data     = $data;
        $this->semester = $semester;
        $this->status   = $status;
        $this->pegawai  = $pegawai;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                $no++,
                $item->pegawai->nama_lengkap ?? '-',
                $item->tahun_semester ?? '-',
                $item->kode_mk ?? '-',
                $item->nama_mk ?? '-',
                $item->pengampu ?? '-',
                $item->sks_kuliah ?? '-',
                $item->sks_praktikum ?? '-',
                $item->jenis ?? '-',
                $item->kelas_paralel ?? '-',
                $item->jumlah_pertemuan ?? '-',
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
            'Nama Dosen',
            'Tahun Semester',
            'Kode MK',
            'Nama Mata Kuliah',
            'Pengampu',
            'SKS Perkuliahan',
            'SKS Praktikum',
            'Jenis',
            'Kelas Paralel',
            'Jumlah Pertemuan',
            'Status Verifikasi',
            'Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        $judul = 'Data Pengajaran Lama';
        if (!empty($this->pegawai)) {
            $judul .= ' - ' . $this->pegawai;
        }
        if (!empty($this->semester)) {
            $judul .= ' (Semester ' . $this->semester . ')';
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }

        // Kolom terakhir
        $lastCol = 'M';
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastCol}1");

        // Style judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
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
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah umum
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom Nama MK dan Pengampu rata kiri + wrap
                $sheet->getStyle("E4:E{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);
                $sheet->getStyle("F4:F{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Header tinggi
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 15, 'D' => 15,
                    'E' => 30, 'F' => 25, 'G' => 15, 'H' => 15,
                    'I' => 15, 'J' => 15, 'K' => 18, 'L' => 20,
                    'M' => 20,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:M3");

                // Zebra striping
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
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