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

class PenunjangExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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
        // Ambil nama dosen (bisa lebih dari satu)
        $namaPegawai = '-';
        if ($item->anggota && $item->anggota->count() > 0) {
            $namaPegawai = $item->anggota->map(function ($a) {
                return $a->pegawai->nama_lengkap ?? '-';
            })->implode(', ');
        }

            // Ambil daftar dokumen
            $dokumen = $item->dokumen->map(function ($d) {
                return ($d->nama_dokumen ?? '-') . ' (' . ($d->jenis_dokumen ?? '-') . ')';
            })->implode("\n");

            $rows[] = [
                $no++,
                $item->kegiatan ?? '-',
                $item->jenis_kegiatan ?? '-',
                $item->lingkup ?? '-',
                $item->nama_kegiatan ?? '-',
                $item->instansi ?? '-',
                $item->nomor_sk ?? '-',
                $item->tmt_mulai ? Carbon::parse($item->tmt_mulai)->format('d-m-Y') : '-',
                $item->tmt_selesai ? Carbon::parse($item->tmt_selesai)->format('d-m-Y') : '-',
                $item->status ?? '-',
                $namaPegawai ?: '-',
                $dokumen ?: '-',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kegiatan',
            'Jenis Kegiatan',
            'Lingkup',
            'Nama Kegiatan',
            'Instansi',
            'Nomor SK',
            'TMT Mulai',
            'TMT Selesai',
            'Status',
            'Anggota',
            'Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambahkan 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        $judul = 'Data Kegiatan Penunjang';
        if (!empty($this->semester)) {
            $judul .= ' - Semester ' . $this->semester;
        }
        if (!empty($this->status)) {
            $judul .= ' (' . $this->status . ')';
        }
        if (!empty($this->search)) {
            $judul .= ' [Filter: ' . $this->search . ']';
        }

        // Set judul
        $lastCol = 'L'; // Kolom terakhir
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
                $sheet->getStyle("A3:L{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah semua isi
                $sheet->getStyle("A3:L{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom Anggota & Dokumen rata kiri + wrap text
                $sheet->getStyle("K4:L{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom manual
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 25, 'D' => 20,
                    'E' => 30, 'F' => 25, 'G' => 25, 'H' => 15,
                    'I' => 15, 'J' => 20, 'K' => 35, 'L' => 35,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:L3");

                // Zebra row
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