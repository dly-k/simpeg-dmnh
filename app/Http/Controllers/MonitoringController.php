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
    $divisi = ['perencanaan', 'kebijakan', 'pemanenan'];
    $data = [];

    foreach ($divisi as $div) {
        $pegawais = Pegawai::where('divisi', $div)->get();

        foreach ($pegawais as $pegawai) {
            // Panggil logika syarat dokumen yang sama dengan yang ada di detailAdmin
            $docTypes = $this->getRequirementsFor($pegawai->jabatan_tujuan);
            $totalSyarat = count($docTypes);

            // Hitung dokumen milik pegawai ini yang statusnya 'Disetujui'
            $totalVerified = \App\Models\EFile::where('pegawai_id', $pegawai->id)
                ->whereIn('nama_dokumen', $docTypes)
                ->where('status_verifikasi', 'Disetujui')
                ->count();

            // Simpan hasil perhitungan ke objek pegawai secara temporary
            $pegawai->total_syarat = $totalSyarat;
            $pegawai->total_verified = $totalVerified;
            $pegawai->progres_persen = $totalSyarat > 0 ? ($totalVerified / $totalSyarat) * 100 : 0;
        }
        $data[$div] = $pegawais;
    }

    return view('pages.monitoring.admin.index', [
        'perencanaan' => $data['perencanaan'],
        'kebijakan' => $data['kebijakan'],
        'pemanenan' => $data['pemanenan']
    ]);
}
private function getRequirementsFor($target)
{
    $docTypes = ['SK Jabatan Fungsional Terakhir', 'PAK Terakhir', 'Ijazah Pendidikan Terakhir', 'SKP 2 Tahun Terakhir'];

    if (\Illuminate\Support\Str::contains($target, 'Lektor Kepala', true)) {
        $docTypes = array_merge($docTypes, ['Bukti Publikasi Jurnal Nasional Terakreditasi', 'Surat Pernyataan Keabsahan Karya Ilmiah', 'Lembar Hasil Penilaian Peer Review']);
    } elseif (\Illuminate\Support\Str::contains($target, 'Guru Besar', true)) {
        $docTypes = array_merge($docTypes, ['Bukti Publikasi Jurnal Internasional Bereputasi', 'Ijazah Doktor (S3)', 'Surat Pernyataan Pemenuhan Persyaratan Khusus', 'Lembar Hasil Penilaian Peer Review (GB)']);
    }
    return $docTypes;
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
            'path' => $file ? ($file->is_link ? $file->link_url : $file->file_path) : null,
            'id_file' => $file ? $file->id : null, // ID ini yang digunakan untuk route
            'status' => $file ? 'Tersedia' : 'Kosong',
            'is_link' => $file ? $file->is_link : false,
            // TAMBAHKAN BARIS DI BAWAH INI
            'status_verifikasi' => $file ? $file->status_verifikasi : 'Menunggu Verifikasi',
            'catatan_verifikator' => $file ? $file->catatan_verifikator : null,
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
    // 1. Ambil ID pegawai dari user yang sedang login
    $id = auth()->user()->pegawai_id;

    if (!$id) {
        return redirect()->back()->with('error', 'Akun Anda belum terhubung dengan data Pegawai.');
    }

    // 2. Gunakan logika yang sama dengan detailAdmin untuk mengambil data asli
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
    
    // --- LOGIKA BERKAS ---
    $docTypes = [
        'SK Jabatan Fungsional Terakhir',
        'PAK Terakhir (Integrasi)',
        'Ijazah Pendidikan Terakhir',
        'SKP 2 Tahun Terakhir'
    ];

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
            'path' => $file ? ($file->is_link ? $file->link_url : $file->file_path) : null,
            'id_file' => $file ? $file->id : null, // ID ini yang digunakan untuk route
            'status' => $file ? 'Tersedia' : 'Kosong',
            'is_link' => $file ? $file->is_link : false,
            // TAMBAHKAN BARIS DI BAWAH INI
            'status_verifikasi' => $file ? $file->status_verifikasi : 'Menunggu Verifikasi',
            'catatan_verifikator' => $file ? $file->catatan_verifikator : null,
        ];
    }

    // 3. Kirim ke view khusus dosen dengan variabel yang sama seperti detailAdmin
    return view('pages.monitoring.dosen.index', compact('pegawai', 'currentKUM', 'targetKUM', 'requirements'));
}

}