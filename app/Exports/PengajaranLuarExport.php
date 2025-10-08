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

class PengajaranLuarExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
                $item->universitas ?? '-',
                $item->kode_mk ?? '-',
                $item->nama_mk ?? '-',
                $item->program_studi ?? '-',
                $item->sks_kuliah ?? '-',
                $item->sks_praktikum ?? '-',
                $item->jenis ?? '-',
                $item->kelas_paralel ?? '-',
                $item->jumlah_pertemuan ?? '-',
                $item->insidental ? 'Ya' : 'Tidak',
                $item->lebih_satu_semester ? 'Ya' : 'Tidak',
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
            'Universitas',
            'Kode MK',
            'Nama Mata Kuliah',
            'Program Studi',
            'SKS Perkuliahan',
            'SKS Praktikum',
            'Jenis',
            'Kelas Paralel',
            'Jumlah Pertemuan',
            'Insidental',
            'Lebih Dari 1 Semester',
            'Status Verifikasi',
            'Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        $judul = 'Data Pengajaran Luar IPB';
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
        $lastCol = 'P';
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
                $sheet->getStyle("A3:P{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah umum
                $sheet->getStyle("A3:P{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom Nama MK & Program Studi rata kiri + wrap
                $sheet->getStyle("F4:F{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);
                $sheet->getStyle("G4:G{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Header tinggi
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 15, 'D' => 25,
                    'E' => 15, 'F' => 30, 'G' => 25, 'H' => 12,
                    'I' => 12, 'J' => 12, 'K' => 15, 'L' => 18,
                    'M' => 15, 'N' => 20, 'O' => 20, 'P' => 20,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:P3");

                // Zebra striping
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:P{$row}")->applyFromArray([
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