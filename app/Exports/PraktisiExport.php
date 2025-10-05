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

class PraktisiExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $semester;
    protected $status;
    protected $pegawai;

    public function __construct(Collection $data, $semester = null, $status = null, $pegawai = null)
    {
        $this->data    = $data;
        $this->semester = $semester;
        $this->status   = $status;
        $this->pegawai  = $pegawai;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            // Gabungkan dokumen
            $dokumen = [];
            if ($item->surat_ipb) {
                $dokumen[] = "Surat Tugas IPB";
            }
            if ($item->surat_instansi) {
                $dokumen[] = "Surat Tugas Instansi";
            }
            if ($item->cv) {
                $dokumen[] = "Curriculum Vitae";
            }
            if ($item->profil) {
                $dokumen[] = "Profil Perusahaan";
            }

            $dokumenText = count($dokumen) > 0 ? implode("\n", $dokumen) : 'Tidak ada dokumen';

            $rows[] = [
                $no++,
                $item->pegawai->nama_lengkap ?? '-',
                $item->bidang_usaha ?? '-',
                $item->jenis_pekerjaan ?? '-',
                $item->jabatan ?? '-',
                $item->instansi ?? '-',
                $item->divisi ?? '-',
                $item->tmt ? Carbon::parse($item->tmt)->format('d-m-Y') : '-',
                $item->tst ? Carbon::parse($item->tst)->format('d-m-Y') : '-',
                $item->area ?? '-',
                $item->kategori ?? '-',
                $item->deskripsi ?? '-',
                $dokumenText, // gabungan dokumen
            ];
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Bidang Usaha',
            'Jenis Pekerjaan',
            'Jabatan',
            'Instansi',
            'Divisi',
            'Mulai Bekerja',
            'Selesai Bekerja',
            'Area Pekerjaan',
            'Kategori Pekerjaan',
            'Deskripsi Kerja',
            'Dokumen Terlampir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tambah 2 baris untuk judul
        $sheet->insertNewRowBefore(1, 2);

        // Judul dinamis
        $judul = 'Data Praktisi Dunia Industri';
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
        $lastCol = 'M'; // Kolom terakhir setelah digabung
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
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah semua isi
                $sheet->getStyle("A3:M{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Kolom Deskripsi & Dokumen rata kiri + wrap text
                $sheet->getStyle("L4:L{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);
                $sheet->getStyle("M4:M{$rowCount}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setWrapText(true);

                // Tinggi baris header
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom manual
                $columnWidths = [
                    'A' => 5,  'B' => 25, 'C' => 20, 'D' => 20,
                    'E' => 20, 'F' => 25, 'G' => 20, 'H' => 15,
                    'I' => 15, 'J' => 20, 'K' => 20, 'L' => 40,
                    'M' => 40,
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