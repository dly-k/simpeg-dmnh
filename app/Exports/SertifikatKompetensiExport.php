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

class SertifikatKompetensiExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $tahun;
    protected $status;
    protected $search;

    public function __construct(Collection $data, $tahun = null, $status = null, $search = null)
    {
        $this->data = $data;
        $this->tahun = $tahun;
        $this->status = $status;
        $this->search = $search;
    }

    /** Isi data utama untuk diexport ke Excel */
    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            $rows[] = [
                $no++,
                $item->pegawai?->nama_lengkap ?? '-',
                $item->kegiatan ?? '-',
                $item->judul_kegiatan ?? '-',
                $item->lembaga_sertifikasi ?? '-',
                $item->tahun_sertifikasi ?? '-',
                $item->no_reg_pendidik ?? '-',
                $item->no_sk_sertifikasi ?? '-',
                $item->tmt_sertifikasi ? Carbon::parse($item->tmt_sertifikasi)->format('d-m-Y') : '-',
                $item->tst_sertifikasi ? Carbon::parse($item->tst_sertifikasi)->format('d-m-Y') : '-',
                $item->bidang_studi ?? '-',
                $item->verifikasi ?? '-',
                $item->dokumen ? asset('storage/'.$item->dokumen) : '-',
            ];
        }

        return $rows;
    }

    /** Header kolom tabel Excel */
    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Kegiatan',
            'Judul Kegiatan',
            'Lembaga Sertifikasi',
            'Tahun Sertifikasi',
            'No. Registrasi Pendidik',
            'No. SK Sertifikasi',
            'TMT Sertifikasi',
            'TST Sertifikasi',
            'Bidang Studi',
            'Status Verifikasi',
            'Dokumen',
        ];
    }

    /** Style awal lembar kerja (judul dan format umum) */
    public function styles(Worksheet $sheet)
    {
        // Tambahkan 2 baris kosong di atas
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis berdasarkan filter
        $judul = 'Data Sertifikat Kompetensi Pegawai';
        if (!empty($this->tahun)) {
            $judul .= ' - Tahun ' . $this->tahun;
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }
        if (!empty($this->search)) {
            $judul .= ' - Pencarian: "' . $this->search . '"';
        }

        // Ambil kolom terakhir
        $lastCol = $sheet->getHighestColumn();

        // Set judul dan merge cell
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastCol}1");

        // Style judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [];
    }

    /** Event styling setelah data dimasukkan */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Baris total (judul + spasi + header)
                $rowCount = $this->data->count() + 3;

                // Border seluruh tabel
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah semua isi tabel
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom teks panjang rata kiri dan wrap text
                $sheet->getStyle("C4:D{$rowCount}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);
                $sheet->getStyle("E4:G{$rowCount}")
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)->setWrapText(true);

                // Lebar kolom
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 25, 'D' => 30, 'E' => 25,
                    'F' => 15, 'G' => 25, 'H' => 25, 'I' => 18, 'J' => 18,
                    'K' => 20, 'L' => 20, 'M' => 35,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Header & judul tinggi
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Freeze header
                $sheet->freezePane('A4');

                // Auto filter
                $sheet->setAutoFilter("A3:M3");

                // Warna zebra
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