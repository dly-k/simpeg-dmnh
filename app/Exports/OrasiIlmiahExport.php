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

class OrasiIlmiahExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
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

    /**
     * Isi data utama untuk diexport ke Excel.
     */
    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                $no++,
                $item->pegawai?->nama_lengkap ?? '-',
                $item->litabmas ?? '-',
                $item->kategori_pembicara ?? '-',
                $item->lingkup ?? '-',
                $item->judul_makalah ?? '-',
                $item->nama_pertemuan ?? '-',
                $item->penyelenggara ?? '-',
                $item->tanggal_pelaksana ? Carbon::parse($item->tanggal_pelaksana)->format('d-m-Y') : '-',
                $item->bahasa ?? '-',
                $item->jenis_dokumen ?? '-',
                $item->nama_dokumen ?? '-',
                $item->nomor_dokumen ?? '-',
                $item->tautan_dokumen ?? '-',
                $item->verifikasi ?? '-',
            ];
        }

        return $rows;
    }

    /**
     * Header kolom tabel Excel.
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Litabmas',
            'Kategori Pembicara',
            'Lingkup',
            'Judul Makalah',
            'Nama Pertemuan',
            'Penyelenggara',
            'Tanggal Pelaksanaan',
            'Bahasa',
            'Jenis Dokumen',
            'Nama Dokumen',
            'Nomor Dokumen',
            'Tautan Dokumen',
            'Status Verifikasi',
        ];
    }

    /**
     * Style awal lembar kerja (judul dan format umum).
     */
    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris kosong di atas (judul + spasi)
        $sheet->insertNewRowBefore(1, 2);

        // Buat judul dinamis berdasarkan filter
        $judul = 'Data Orasi Ilmiah Dosen';
        if (!empty($this->semester)) {
            $judul .= ' - Semester ' . $this->semester;
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }
        if (!empty($this->search)) {
            $judul .= ' - Pencarian: "' . $this->search . '"';
        }

        // Ambil kolom terakhir secara dinamis
        $lastCol = $sheet->getHighestColumn();

        // Set judul dan merge cell
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
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [];
    }

    /**
     * Event styling setelah semua data dimasukkan.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Baris total (1 baris judul + 1 spasi + header)
                $rowCount = $this->data->count() + 3;

                // Border seluruh tabel
                $sheet->getStyle("A3:O{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah semua isi tabel
                $sheet->getStyle("A3:O{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom teks panjang rata kiri dan wrap text
                $sheet->getStyle("F4:H{$rowCount}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                $sheet->getStyle("K4:O{$rowCount}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);

                // Atur tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom manual
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 20, 'D' => 25, 'E' => 20,
                    'F' => 35, 'G' => 30, 'H' => 25, 'I' => 18, 'J' => 15,
                    'K' => 20, 'L' => 25, 'M' => 20, 'N' => 35, 'O' => 20,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze header (mulai baris data)
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:O3");

                // Warna zebra (selang-seling)
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
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