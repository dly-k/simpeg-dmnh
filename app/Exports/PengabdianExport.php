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

class PengabdianExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $semester;
    protected $status;
    protected $search;
    protected $jenis;

    public function __construct(Collection $data, $semester = null, $status = null, $search = null, $jenis = null)
    {
        $this->data = $data;
        $this->semester = $semester;
        $this->status = $status;
        $this->search = $search;
        $this->jenis = $jenis;
    }

    public function array(): array
    {
        $no = 1;
        $rows = [];

        foreach ($this->data as $item) {
            // ===== Dokumen =====
            $dokumen = [];
            if ($item->dokumen && $item->dokumen->isNotEmpty()) {
                foreach ($item->dokumen as $doc) {
                    $dokumen[] = ($doc->jenis_dokumen ?? '-') . ' - ' . basename($doc->file_path ?? '-');
                }
            }
            $dokumenText = count($dokumen) > 0 ? implode("\n", $dokumen) : 'Tidak ada dokumen';

            // ===== Anggota =====
            $ketua = '-';
            $anggotaList = [];

            if ($item->anggota && $item->anggota->isNotEmpty()) {
                foreach ($item->anggota as $anggota) {
                    // Nama bisa berasal dari relasi pegawai (dosen) atau langsung kolom nama (mahasiswa)
                    $namaAnggota = $anggota->pegawai->nama_lengkap ?? $anggota->nama ?? '-';
                    $jabatan = $anggota->jabatan ?? '-';
                    $statusAnggota = $anggota->status_aktif ?? '-';

                    if (strtolower($jabatan) === 'ketua') {
                        $ketua = "{$namaAnggota} ({$statusAnggota})";
                    } else {
                        $anggotaList[] = "{$namaAnggota} ({$jabatan}, {$statusAnggota})";
                    }
                }
            }

            $anggotaText = count($anggotaList) > 0 ? implode("\n", $anggotaList) : '-';

            // ===== Data utama =====
            $rows[] = [
                $no++,
                $item->nama_kegiatan ?? '-', // pakai nama atau judul sesuai kolom di DB
                $item->afiliasi_non_pt ?? '-',
                $item->jenis_pengabdian ?? '-',
                $item->lama_kegiatan ?? '-',
                $item->tahun_pelaksanaan ?? '-',
                $item->no_sk_penugasan ?? '-',
                isset($item->tgl_sk_penugasan)
                    ? Carbon::parse($item->tgl_sk_penugasan)->translatedFormat('d F Y')
                    : '-',
                'Rp ' . number_format($item->dana_dikti ?? 0, 0, ',', '.'),
                'Rp ' . number_format($item->dana_pt ?? 0, 0, ',', '.'),
                'Rp ' . number_format($item->dana_institusi_lain ?? 0, 0, ',', '.'),
                $ketua,
                $anggotaText,
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
            'Judul Kegiatan',
            'Afiliasi Non-PT',
            'Jenis Pengabdian',
            'Lama Kegiatan',
            'Tahun Pelaksanaan',
            'No. SK Penugasan',
            'Tanggal SK',
            'Dana DIKTI',
            'Dana PT',
            'Dana Lain',
            'Ketua',
            'Anggota',
            'Status Verifikasi',
            'Dokumen',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Sisipkan 2 baris di atas untuk judul besar
        $sheet->insertNewRowBefore(1, 2);

        // Buat judul dinamis
        $judul = 'Data Pengabdian';
        if (!empty($this->jenis)) {
            $judul .= ' - ' . ucfirst($this->jenis);
        }
        if (!empty($this->semester)) {
            $judul .= ' (Semester ' . ucfirst($this->semester) . ')';
        }
        if (!empty($this->status)) {
            $judul .= ' - Status ' . ucfirst($this->status);
        }
        if (!empty($this->search)) {
            $judul .= ' - Pencarian: "' . $this->search . '"';
        }

        // Merge & style judul
        $lastCol = 'O'; // 15 kolom (A sampai O)
        $sheet->setCellValue('A1', $judul);
        $sheet->mergeCells("A1:{$lastCol}1");
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $rowCount = $this->data->count() + 3;

                // Border semua sel
                $sheet->getStyle("A3:O{$rowCount}")
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(Border::BORDER_THIN);

                // Rata tengah vertikal
                $sheet->getStyle("A3:O{$rowCount}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Bungkus teks panjang
                $sheet->getStyle("B4:O{$rowCount}")
                    ->getAlignment()
                    ->setWrapText(true);

                // Ukuran baris
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(3)->setRowHeight(25);

                // Lebar kolom
                $columnWidths = [
                    'A' => 5, 'B' => 30, 'C' => 25, 'D' => 20,
                    'E' => 15, 'F' => 15, 'G' => 20, 'H' => 20,
                    'I' => 20, 'J' => 20, 'K' => 20, 'L' => 25,
                    'M' => 25, 'N' => 20, 'O' => 40,
                ];
                foreach ($columnWidths as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                // Freeze dan filter
                $sheet->freezePane('A4');
                $sheet->setAutoFilter("A3:O3");

                // Warna selang-seling
                for ($row = 4; $row <= $rowCount; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A{$row}:O{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'color' => ['rgb' => 'F9F9F9'],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}