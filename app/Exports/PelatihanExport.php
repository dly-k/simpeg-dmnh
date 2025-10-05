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

class PelatihanExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $tahun;
    protected $peserta;

    public function __construct(Collection $data, $tahun = null, $peserta = null)
    {
        $this->data = $data;
        $this->tahun = $tahun;
        $this->peserta = $peserta;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                $no++,
                $item->pegawai->nama_lengkap ?? '-',
                $item->nama_kegiatan ?? '-',
                $item->posisi === 'Lainnya' ? $item->posisi_lainnya : ($item->posisi ?? '-'),
                $item->kota ?? '-',
                $item->lokasi ?? '-',
                $item->penyelenggara ?? '-',
                $item->jenis_diklat ?? '-',
                optional($item->tgl_mulai)->format('d-m-Y'),
                optional($item->tgl_selesai)->format('d-m-Y'),
                $item->lingkup ?? '-',
                $item->jumlah_jam ?? '-',
                $item->jumlah_hari ?? '-',
                $item->struktural ? 'Ya' : 'Tidak',
                $item->sertifikasi ? 'Ya' : 'Tidak',
                $item->file_path ? asset('storage/' . $item->file_path) : '-',
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Nama Diklat',
            'Posisi Diklat',
            'Kota/Kabupaten',
            'Lokasi',
            'Penyelenggara',
            'Jenis Diklat',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Lingkup',
            'Jumlah Jam',
            'Jumlah Hari',
            'Struktural',
            'Sertifikasi',
            'Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris di atas untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Tentukan judul dinamis
        $judul = 'Data Pelatihan Pegawai';
        if (!empty($this->peserta)) {
            $judul .= ' – ' . ucfirst($this->peserta);
        }
        if (!empty($this->tahun)) {
            $judul .= ' Tahun ' . $this->tahun;
        }

        // Judul besar di atas tabel
        $sheet->mergeCells('A1:P1');
        $sheet->setCellValue('A1', $judul);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Header tabel rata tengah semua
        $sheet->getStyle('A3:P3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_MEDIUM],
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

                // Border seluruh tabel
                $sheet->getStyle("A3:P{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Heading & isi vertikal tengah
                $sheet->getStyle("A3:P{$rowCount}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom No rata tengah
                $sheet->getStyle("A4:A{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Header rata tengah
                $sheet->getStyle('A3:P3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Tinggi baris
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom lebih proporsional
                $columnWidths = [
                    'A' => 5,    // No
                    'B' => 25,   // Nama Pegawai
                    'C' => 30,   // Nama Diklat
                    'D' => 20,   // Posisi
                    'E' => 18,   // Kota
                    'F' => 22,   // Lokasi
                    'G' => 25,   // Penyelenggara
                    'H' => 20,   // Jenis Diklat
                    'I' => 15,   // Tgl Mulai
                    'J' => 15,   // Tgl Selesai
                    'K' => 18,   // Lingkup (lebih lebar)
                    'L' => 14,   // Jumlah Jam (lebih lebar)
                    'M' => 14,   // Jumlah Hari (lebih lebar)
                    'N' => 13,   // Struktural
                    'O' => 13,   // Sertifikasi
                    'P' => 35,   // Dokumen
                ];

                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }
            },
        ];
    }
}