<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use Illuminate\Support\Str;
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
    $pegawai = \App\Models\Pegawai::findOrFail($id);

    // --- LOGIKA NILAI KUM ---
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

    $targetKUM = $thresholds[$pegawai->jabatan_tujuan] ?? 0;
    $currentKUM = $pegawai->ak_lama + $pegawai->ak_baru;
    $target = $pegawai->jabatan_tujuan ?? '';
    
    // 1. Berkas Dasar (Semua Jabatan Wajib Ada)
    $docTypes = [
        'SK Jabatan Fungsional Terakhir',
        'PAK Terakhir (Integrasi)',
        'Ijazah Pendidikan Terakhir',
        'SKP 2 Tahun Terakhir'
    ];

    // 2. Tambah Berkas Khusus (Hanya tambah, jangan didefinisikan ulang di bawah)
    if (\Illuminate\Support\Str::contains($target, 'Lektor Kepala', ignoreCase: true)) {
        $docTypes[] = 'Bukti Publikasi Jurnal Nasional Terakreditasi';
        $docTypes[] = 'Surat Pernyataan Keabsahan Karya Ilmiah';
        $docTypes[] = 'Lembar Hasil Penilaian Peer Review';
    } 
    elseif (\Illuminate\Support\Str::contains($target, 'Guru Besar', ignoreCase: true)) {
        $docTypes[] = 'Bukti Publikasi Jurnal Internasional Bereputasi';
        $docTypes[] = 'Ijazah Doktor (S3)';
        $docTypes[] = 'Surat Pernyataan Pemenuhan Persyaratan Khusus';
        $docTypes[] = 'Lembar Hasil Penilaian Peer Review (GB)';
    }

    // 3. Ambil data dari e_files
    $uploadedFiles = \App\Models\EFile::where('pegawai_id', $id)
        ->where('kategori_dokumen', 'Lain-lain')
        ->get()
        ->keyBy('nama_dokumen'); 

    $requirements = [];
    foreach ($docTypes as $type) {
        $file = $uploadedFiles->get($type);
        $requirements[] = [
            'name' => $type,
            'is_uploaded' => !!$file,
            'path' => $file ? $file->file_path : null,
            'id_file' => $file ? $file->id : null,
            'status' => $file ? 'Tersedia' : 'Kosong',
            'is_link' => $file ? $file->is_link : false 
        ];
    }

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