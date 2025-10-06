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

class PembicaraExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
        $no   = 1;
        $rows = [];

        foreach ($this->data as $item) {
            // Gabungkan dokumen
            $dokumen = [];
            if ($item->file_sertifikat) {
                $dokumen[] = "File Sertifikat";
            }
            if ($item->file_sk) {
                $dokumen[] = "File SK/Surat Tugas";
            }
            $dokumenText = count($dokumen) > 0 ? implode("\n", $dokumen) : 'Tidak ada dokumen';

            $rows[] = [
                $no++,
                $item->pegawai->nama_lengkap ?? '-',
                $item->kegiatan === 'lainnya' ? $item->kegiatan_lainnya : ucfirst(str_replace('_', ' ', $item->kegiatan)),
                $item->kategori_capaian ?? '-',
                $item->kategori_pembicara ?? '-',
                $item->judul_makalah ?? '-',
                $item->nama_pertemuan ?? '-',
                $item->tanggal_pelaksana ? Carbon::parse($item->tanggal_pelaksana)->format('d-m-Y') : '-',
                $item->penyelenggara ?? '-',
                $item->tingkat ?? '-',
                $item->bahasa ?? '-',
                $item->litabmas ?? '-',
                $item->status_verifikasi ?? '-',
                $dokumenText,
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Kegiatan',
            'Kategori Capaian',
            'Kategori Pembicara',
            'Judul Makalah',
            'Nama Pertemuan',
            'Tanggal Pelaksanaan',
            'Penyelenggara',
            'Tingkat Pertemuan',
            'Bahasa',
            'Litabmas',
            'Status Verifikasi',
            'Dokumen Terlampir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        $judul = 'Data Pembicara';
        if (!empty($this->pegawai)) {
            $judul .= ' - ' . $this->pegawai;
        }
        if (!empty($this->semester)) {
            $judul .= ' (Semester ' . $this->semester . ')';
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }

        // Set judul
        $lastCol = 'N'; // kolom terakhir (14 kolom)
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastCol}1");

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
                $sheet    = $event->sheet->getDelegate();
                $rowCount = $this->data->count() + 3; // 2 baris judul + header

                // Border tabel
                $sheet->getStyle("A3:N{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah semua isi
                $sheet->getStyle("A3:N{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom teks panjang rata kiri + wrap
                $sheet->getStyle("F4:F{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);
                $sheet->getStyle("M4:N{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom manual
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 20, 'D' => 20,
                    'E' => 20, 'F' => 30, 'G' => 25, 'H' => 15,
                    'I' => 25, 'J' => 20, 'K' => 15, 'L' => 15,
                    'M' => 20, 'N' => 40,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:N3");

                // Zebra row
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:N{$row}")->applyFromArray([
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