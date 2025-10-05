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

class PenghargaanExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $tahun;
    protected $lingkup;
    protected $pegawai;

    public function __construct(Collection $data, $tahun = null, $lingkup = null, $pegawai = null)
    {
        $this->data = $data;
        $this->tahun = $tahun;
        $this->lingkup = $lingkup;
        $this->pegawai = $pegawai;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                $no++,
                $item->pegawai->nama_lengkap ?? '-',
                $item->kegiatan ?? '-',
                $item->nama_penghargaan ?? '-',
                $item->nomor_sk ?? '-',
                optional($item->tanggal_perolehan)->format('d-m-Y'),
                $item->lingkup ?? '-',
                $item->negara ?? '-',
                $item->instansi_pemberi ?? '-',
                $item->jenis_dokumen ?? '-',
                $item->nama_dokumen ?? '-',
                $item->nomor_dokumen ?? '-',
                $item->tautan ?? '-',
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
            'Nama Penghargaan',
            'Nomor SK',
            'Tanggal Perolehan',
            'Lingkup',
            'Negara',
            'Instansi Pemberi',
            'Jenis Dokumen',
            'Nama Dokumen',
            'Nomor Dokumen',
            'Tautan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        if (!empty($this->pegawai)) {
            $judul = 'Data Penghargaan Pegawai ' . $this->pegawai;
        } else {
            $judul = 'Data Penghargaan Pegawai';
        }

        if (!empty($this->tahun)) {
            $judul .= ' Tahun ' . $this->tahun;
        }
        if (!empty($this->lingkup)) {
            $judul .= ' – Lingkup ' . $this->lingkup;
        }

        // Set judul
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells('A1:M1');

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

                // Rata tengah vertikal
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // No rata tengah
                $sheet->getStyle("A4:A{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Tinggi baris
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom manual
                $columnWidths = [
                    'A' => 5, 'B' => 25, 'C' => 30, 'D' => 30,
                    'E' => 20, 'F' => 18, 'G' => 18, 'H' => 20,
                    'I' => 25, 'J' => 20, 'K' => 25, 'L' => 20, 'M' => 35,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:M3");

                // Zebra row
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