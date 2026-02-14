<?php

namespace App\Http\Controllers;
use App\Models\Pegawai; // Tambahkan ini

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
// app/Http/Controllers/MonitoringController.php

public function indexAdmin()
{
    // Mengambil data dosen berdasarkan divisinya masing-masing
    $perencanaan = Pegawai::where('divisi', 'perencanaan')->get();
    $kebijakan = Pegawai::where('divisi', 'kebijakan')->get();
    $pemanenan = Pegawai::where('divisi', 'pemanenan')->get();

    return view('pages.monitoring.admin.index', compact('perencanaan', 'kebijakan', 'pemanenan'));
}

public function updateTarget(Request $request, $id)
{
    $request->validate([
        'jabatan_tujuan' => 'required',
        'estimasi_pensiun_manual' => 'required|date',
    ]);

    $pegawai = \App\Models\Pegawai::findOrFail($id);
    $pegawai->update([
        'jabatan_tujuan' => $request->jabatan_tujuan,
        'estimasi_pensiun_manual' => $request->estimasi_pensiun_manual,
    ]);

    return back()->with('success', 'Data target berhasil diperbarui');
}

public function detailAdmin($id)
{
    $pegawai = Pegawai::findOrFail($id);

    // Definisi Ambang Batas KUM (Threshold)
    $thresholds = [
        'Asisten Ahli (III/b)' => 150,
        'Lektor (III/c)'       => 200,
        'Lektor (III/d)'       => 300,
        'Lektor Kepala (IV/a)' => 400,
        'Lektor Kepala (IV/b)' => 550,
        'Lektor Kepala (IV/c)' => 700,
        'Guru Besar (IV/d)'    => 850,
        'Guru Besar (IV/e)'    => 1050,
    ];

    // Ambil target KUM berdasarkan string jabatan_tujuan yang tersimpan di DB
    $targetKUM = $thresholds[$pegawai->jabatan_tujuan] ?? 0;
    
    // Perhitungan Total KUM Saat Ini
    $currentKUM = $pegawai->ak_lama + $pegawai->ak_baru;

    // Data requirements tetap dikirim agar tidak error
    $requirements = [
        ['name' => 'SK Jabatan Terakhir', 'is_uploaded' => true, 'is_link' => false, 'path' => '#', 'status' => 'Valid'],
        ['name' => 'PAK Terakhir', 'is_uploaded' => true, 'is_link' => false, 'path' => '#', 'status' => 'Valid'],
    ];

    return view('pages.monitoring.admin.detail', compact('pegawai', 'currentKUM', 'targetKUM', 'requirements'));
}

// Tambahkan Fungsi Simpan Nilai AK Baru
public function updateAK(Request $request, $id)
{
    $request->validate([
        'ak_baru' => 'required|numeric|min:0',
    ]);

    $pegawai = Pegawai::findOrFail($id);
    $pegawai->update([
        'ak_baru' => $request->ak_baru,
    ]);

    return back()->with('success', 'Nilai Angka Kredit SKP berhasil diperbarui');
}
public function indexDosen()
{
    $data = [
        'nama' => 'Dr. Fadly Akademisi',
        'target_jabatan' => 'Lektor Kepala (IV/a)',
        'current_kum' => 385.5,
        'target_kum' => 400,
        'tgl_pensiun' => '12 Des 2035',
        'requirements' => [
            ['name' => 'SK Jabatan Terakhir', 'status' => 'Valid', 'is_uploaded' => true, 'path' => 'sk.pdf', 'note' => ''],
            ['name' => 'PAK Terakhir', 'status' => 'Perlu Revisi', 'is_uploaded' => true, 'path' => 'pak_lama.pdf', 'note' => 'File tidak terbaca, mohon scan ulang'],
            ['name' => 'Ijazah Pendidikan Terakhir', 'status' => 'Kosong', 'is_uploaded' => false, 'path' => '', 'note' => ''],
        ]
    ];
    return view('pages.monitoring.dosen.index', compact('data'));
}

}