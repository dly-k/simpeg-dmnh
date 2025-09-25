<?php

namespace App\Exports;

use App\Models\TugasBelajar;
use App\Models\Pegawai;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Font;

class TugasBelajarExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle, WithEvents
{
    protected $pegawai;
    protected $search;
    protected $tahun;
    private $rowNumber = 0;

    public function __construct(Pegawai $pegawai, $search = null, $tahun = null)
    {
        $this->pegawai = $pegawai;
        $this->search = $search;
        $this->tahun = $tahun;
    }
    
    public function collection()
    {
        return TugasBelajar::where('pegawai_id', $this->pegawai->id)
            ->when($this->search, function ($query, $search) {
                $query->where('nomor_sk', 'like', "%{$search}%")
                      ->orWhere('jenis_tugas_belajar', 'like', "%{$search}%");
            })
            ->when($this->tahun, function ($query, $tahun) {
                $query->whereYear('tanggal_sk', $tahun);
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['No', 'Jenis Tugas Belajar', 'Nomor SK', 'Tanggal SK', 'Tanggal Mulai', 'Tanggal Selesai', 'Link Berkas'];
    }

    public function map($row): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $row->jenis_tugas_belajar,
            $row->nomor_sk,
            Carbon::parse($row->tanggal_sk)->isoFormat('D MMMM YYYY'),
            Carbon::parse($row->tanggal_mulai)->isoFormat('D MMMM YYYY'),
            Carbon::parse($row->tanggal_selesai)->isoFormat('D MMMM YYYY'),
            $row->file_path ? '=HYPERLINK("' . url('storage/' . $row->file_path) . '", "Dokumen")' : '-',
        ];
    }

    public function title(): string
    {
        return 'Riwayat Tugas Belajar';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = 'G';
                
                $sheet->insertNewRowBefore(1, 2);
                $sheet->setCellValue('A1', 'RIWAYAT TUGAS BELAJAR - ' . strtoupper($this->pegawai->nama_lengkap));
                $sheet->mergeCells('A1:'.$lastColumn.'1');
                $sheet->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 14], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]]);
                
                $sheet->getStyle('A3:'.$lastColumn.'3')->applyFromArray(['font' => ['bold' => true], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9D9D9']], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]);
                
                $lastRow = $sheet->getHighestRow();
                $sheet->getStyle("A4:".$lastColumn."{$lastRow}")->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]);
                
                for ($row = 4; $row <= $lastRow; $row++) {
                    $cellCoordinate = $lastColumn . $row;
                    if (strpos($sheet->getCell($cellCoordinate)->getValue(), '=HYPERLINK') === 0) {
                        $sheet->getStyle($cellCoordinate)->getFont()->applyFromArray([
                            'color' => ['rgb' => '0000FF'],
                            'underline' => Font::UNDERLINE_SINGLE,
                        ]);
                    }
                }
            },
        ];
    }
}