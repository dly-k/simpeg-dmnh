<?php

namespace App\Exports;

use App\Models\Pegawai;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MonitoringPegawaiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    private $rowNumber = 0;

    public function collection()
    {
        return Pegawai::where('status_pegawai', 'Aktif')
            ->orderBy('status_kepegawaian', 'asc') // Urutkan Dosen dulu baru Tendik
            ->orderBy('nama_lengkap', 'asc')
            ->get();
    }

    public function map($pegawai): array
    {
        $this->rowNumber++;
        
        // Perhitungan Umur & Format Tanggal
        $umur = $pegawai->tanggal_lahir ? Carbon::parse($pegawai->tanggal_lahir)->age : '-';
        $tgl_lahir = $pegawai->tanggal_lahir ? Carbon::parse($pegawai->tanggal_lahir)->format('d-m-Y') : '-';
        
        // Trik spasi agar NIP dibaca Teks
        $nip = $pegawai->nip ? ' ' . $pegawai->nip : '-';

        return [
            $this->rowNumber,
            $pegawai->nama_lengkap,
            $pegawai->jenis_kelamin,
            $nip,
            $pegawai->tempat_lahir ?? '-',
            $tgl_lahir,
            $umur,
            $pegawai->pangkat_golongan ?? '-',
            $pegawai->pendidikan_terakhir ?? '-',
            $pegawai->jabatan_fungsional ?? '-',
            $pegawai->status_kepegawaian ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'No.',
            'N A M A',
            'JK',
            'NIP / NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Umur',
            'Pangkat Terakhir/ Gol',
            'Pend. Terakhir',
            'Jabatan',
            'Status / Kategori',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Menyisipkan 3 Baris Kosong di Atas untuk Kop
                $sheet->insertNewRowBefore(1, 3);

                // Menulis Judul di Atas Tabel
                $sheet->setCellValue('A1', 'DATA MONITORING PEGAWAI (DOSEN DAN TENDIK)');
                $sheet->setCellValue('A2', 'DEPARTEMEN MANAJEMEN HUTAN - TAHUN ' . date('Y'));

                // Merge Cell untuk Judul
                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:K2');

                // Styling Judul Laporan
                $sheet->getStyle('A1:A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Styling Header Tabel (Baris ke-4)
                $sheet->getStyle('A4:K4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE0E0E0']],
                ]);

                // Styling Data & Border (Mulai Baris ke-5 sampai bawah)
                $highestRow = $sheet->getHighestRow();
                $sheet->getStyle('A5:K' . $highestRow)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                ]);

                // Memaksa Rata Tengah untuk No, JK, Umur, Pend. Terakhir
                $sheet->getStyle('A5:A' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('C5:C' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('G5:G' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('I5:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // --- MEMBUAT BARIS TOTAL DI PALING BAWAH ---
                $totalRow = $highestRow + 1; 

                // Merge semua kolom A sampai K untuk baris total
                $sheet->mergeCells('A' . $totalRow . ':K' . $totalRow);
                $sheet->setCellValue('A' . $totalRow, 'TOTAL KESELURUHAN PEGAWAI = ' . $this->rowNumber . ' ORANG');

                // Styling Baris Total
                $sheet->getStyle('A' . $totalRow . ':K' . $totalRow)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFFF00']],
                ]);

            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [];
    }
}