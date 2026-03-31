<?php

namespace App\Exports;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonitoringExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;
    protected $rowNumber = 0;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

public function collection()
    {
        $query = Pegawai::query();

        // Terapkan filter jabatan jika ada
        if ($this->request->filled('jabatan')) {
            $query->where('jabatan_fungsional', $this->request->jabatan);
        }

        // Terapkan filter usia jika ada
        if ($this->request->filled('age_range') && str_contains($this->request->age_range, '-')) {
            [$minUsia, $maxUsia] = explode('-', $this->request->age_range);
            $startDate = Carbon::today()->subYears($maxUsia + 1)->addDay()->format('Y-m-d');
            $endDate = Carbon::today()->subYears($minUsia)->format('Y-m-d');
            
            $query->whereNotNull('tanggal_lahir')
                  ->whereBetween('tanggal_lahir', [$startDate, $endDate]);
        }

        // TAMBAHKAN INI: Terapkan filter divisi berdasarkan tab yang aktif
        if ($this->request->filled('divisi')) {
            $query->where('divisi', $this->request->divisi);
        }

        // Urutkan berdasarkan divisi atau nama agar rapi
        return $query->orderBy('divisi')->orderBy('nama_lengkap')->get();
    }
    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'NIP',
            'Usia',
            'Estimasi Pensiun',
            'Jabatan Terakhir',
            'Jabatan Tujuan',
            'Nilai KUM',       // Tambahkan ini
            'Nilai Konversi'   // Kolom ini tetap ada
        ];
    }

    public function map($pegawai): array
    {
        $this->rowNumber++;

        // Hitung Usia
        $usia = $pegawai->tanggal_lahir ? Carbon::parse($pegawai->tanggal_lahir)->age . ' Tahun' : '-';

        // Hitung Estimasi Pensiun (69 Tahun)
        if ($pegawai->estimasi_pensiun_manual) {
            $pensiun = Carbon::parse($pegawai->estimasi_pensiun_manual)->isoFormat('D MMMM YYYY');
        } elseif ($pegawai->tanggal_lahir) {
            $pensiun = Carbon::parse($pegawai->tanggal_lahir)->addYears(69)->isoFormat('D MMMM YYYY');
        } else {
            $pensiun = '-';
        }

        return [
            $this->rowNumber,
            $pegawai->nama_lengkap ?? '-',
            $pegawai->nip ?? '-',
            $usia,
            $pensiun,
            $pegawai->jabatan_fungsional ?? '-',
            $pegawai->jabatan_tujuan ?? 'Belum Diset',
            $pegawai->ak_lama ?? '0', // Nilai KUM (berasal dari ak_lama)
            $pegawai->ak_baru ?? '0'  // Nilai Konversi (berasal dari ak_baru)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold untuk baris pertama (Heading)
            1 => ['font' => ['bold' => true]],
        ];
    }
}