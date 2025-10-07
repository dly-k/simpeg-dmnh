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

class PenelitianExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $periode;
    protected $jenis;
    protected $status;
    protected $search;

    public function __construct(Collection $data, $periode = null, $jenis = null, $status = null, $search = null)
    {
        $this->data = $data;
        $this->periode = $periode;
        $this->jenis = $jenis;
        $this->status = $status;
        $this->search = $search;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            // Gabungkan nama penulis internal dan eksternal
            $penulis = $item->penulis->map(fn($p) => $p->pegawai->nama_lengkap ?? $p->nama_penulis)->implode(', ');

            // Format tanggal terbit
            $tanggal_terbit = $item->tanggal_terbit
                ? Carbon::parse($item->tanggal_terbit)->format('d-m-Y')
                : '-';

            // Kolom verifikasi
            $verifikasi = match ($item->verifikasi) {
                'diterima' => 'Diterima',
                'ditolak' => 'Ditolak',
                'menunggu' => 'Menunggu Verifikasi',
                default => '-',
            };

            $rows[] = [
                $no++,
                $item->judul ?? '-',
                $penulis ?: '-',
                $item->jenis_karya ?? '-',
                $item->volume ?? '-',
                $item->jumlah_halaman ?? '-',
                $tanggal_terbit,
                $item->is_publik ? 'Ya' : 'Tidak',
                $item->isbn ?? '-',
                $item->issn ?? '-',
                $item->doi ?? '-',
                $item->url ?? '-',
                $verifikasi,
                $item->periode ?? '-',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul Penelitian',
            'Penulis',
            'Jenis Karya',
            'Volume / Issue',
            'Jumlah Halaman',
            'Tanggal Terbit',
            'Publik',
            'ISBN',
            'ISSN',
            'DOI',
            'URL',
            'Status Verifikasi',
            'Periode',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambahkan dua baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        $judul = 'Data Penelitian';
        if (!empty($this->periode)) {
            $judul .= ' - ' . $this->periode;
        }
        if (!empty($this->jenis)) {
            $judul .= ' (' . ucfirst($this->jenis) . ')';
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }
        if (!empty($this->search)) {
            $judul .= ' - Pencarian: "' . $this->search . '"';
        }

        $lastCol = 'N'; // Kolom terakhir sekarang N (bukan O)
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
                $sheet = $event->sheet->getDelegate();
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

                // Rata kiri dan wrap text untuk kolom teks panjang
                $sheet->getStyle("B4:B{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);
                $sheet->getStyle("C4:C{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);
                $sheet->getStyle("I4:N{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom manual
                $columnWidths = [
                    'A' => 5,
                    'B' => 50,
                    'C' => 30,
                    'D' => 20,
                    'E' => 15,
                    'F' => 15,
                    'G' => 15,
                    'H' => 10,
                    'I' => 15,
                    'J' => 15,
                    'K' => 20,
                    'L' => 30,
                    'M' => 20,
                    'N' => 20,
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