<?php

namespace App\Http\Controllers;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
// app/Http/Controllers/MonitoringController.php

public function indexAdmin(\Illuminate\Http\Request $request)
{
    $divisi = ['perencanaan', 'kebijakan', 'pemanenan'];
    $data = [];

    // 1. Ambil input filter dari URL
    $filterJabatan = $request->input('jabatan');
    $filterUsia = $request->input('age_range');

    // 2. Ambil daftar jabatan yang tersedia di database untuk opsi dropdown
    $listJabatan = \App\Models\Pegawai::select('jabatan_fungsional')
                    ->whereNotNull('jabatan_fungsional')
                    ->distinct()
                    ->pluck('jabatan_fungsional');

    foreach ($divisi as $div) {
        // 3. Mulai Query dasar berdasarkan divisi
        $query = \App\Models\Pegawai::where('divisi', $div);

        // --- TERAPKAN FILTER JABATAN ---
        if (!empty($filterJabatan)) {
            $query->where('jabatan_fungsional', $filterJabatan);
        }

        // --- TERAPKAN FILTER USIA ---
        if (!empty($filterUsia) && str_contains($filterUsia, '-')) {
            [$minUsia, $maxUsia] = explode('-', $filterUsia);
            
            // Kalkulasi tanggal lahir berdasarkan usia
            // Contoh: rentang 20-25 berarti lahir antara (hari ini - 26 tahun + 1 hari) hingga (hari ini - 20 tahun)
            $startDate = \Carbon\Carbon::today()->subYears($maxUsia + 1)->addDay()->format('Y-m-d');
            $endDate = \Carbon\Carbon::today()->subYears($minUsia)->format('Y-m-d');
            
            $query->whereNotNull('tanggal_lahir')
                  ->whereBetween('tanggal_lahir', [$startDate, $endDate]);
        }

        // Eksekusi query
        $pegawais = $query->get();

        foreach ($pegawais as $pegawai) {
            // Panggil logika syarat dokumen
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

    // 4. Return view dan kirimkan data filter
    return view('pages.monitoring.admin.index', [
        'perencanaan' => $data['perencanaan'],
        'kebijakan' => $data['kebijakan'],
        'pemanenan' => $data['pemanenan'],
        'listJabatan' => $listJabatan // Kirim ke blade
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

    // --- LOGIKA NILAI KUM & KONVERSI ---
    // 1. Target Angka Kredit (KUM Integrasi)
    $thresholdsKUM = [
        'Asisten Ahli (III/b)' => 150,
        'Lektor (III/c)'       => 200,
        'Lektor (III/d)'       => 300,
        'Lektor Kepala (IV/a)' => 400,
        'Lektor Kepala (IV/b)' => 550,
        'Lektor Kepala (IV/c)' => 700,
        'Guru Besar (IV/d)'    => 850,
        'Guru Besar (IV/e)'    => 1050,
    ];

    // 2. Target Angka Konversi (SKP)
    // Sesuaikan nilai di bawah ini dengan standar peraturan kampus Anda
    $thresholdsKonversi = [
        'Asisten Ahli (III/b)' => 150,
        'Lektor (III/c)'       => 200,
        'Lektor (III/d)'       => 300,
        'Lektor Kepala (IV/a)' => 400,
        'Lektor Kepala (IV/b)' => 550,
        'Lektor Kepala (IV/c)' => 700,
        'Guru Besar (IV/d)'    => 850,
        'Guru Besar (IV/e)'    => 1050,
    ];

    $targetKUM = $thresholdsKUM[$pegawai->jabatan_tujuan] ?? 0;
    $targetKonversi = $thresholdsKonversi[$pegawai->jabatan_tujuan] ?? 0;

    // Memisahkan nilai, ak_lama untuk KUM, ak_baru untuk Konversi
    $currentKUM = $pegawai->ak_lama ?? 0;
    $currentKonversi = $pegawai->ak_baru ?? 0;
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
            'status_verifikasi' => $file ? $file->status_verifikasi : 'Menunggu Verifikasi',
            'catatan_verifikator' => $file ? $file->catatan_verifikator : null,
        ];
    }

    // Tambahkan variabel Konversi ke return view
    return view('pages.monitoring.admin.detail', compact('pegawai', 'currentKUM', 'targetKUM', 'currentKonversi', 'targetKonversi', 'requirements'));
}

// Tambahkan Fungsi Simpan Nilai AK Baru (KUM dan Konversi)
public function updateAK(Request $request, $id)
{
    $request->validate([
        'ak_lama' => 'required|numeric|min:0', // Validasi input KUM
        'ak_baru' => 'required|numeric|min:0', // Validasi input Konversi
    ]);

    $pegawai = \App\Models\Pegawai::findOrFail($id);
    $pegawai->update([
        'ak_lama' => $request->ak_lama, // Menyimpan Angka Kredit
        'ak_baru' => $request->ak_baru, // Menyimpan Angka Konversi
    ]);

    return back()->with('success', 'Nilai Angka Kredit dan Konversi berhasil diperbarui');
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

    // --- LOGIKA NILAI KUM & KONVERSI ---
    $thresholdsKUM = [
        'Asisten Ahli (III/b)' => 150,
        'Lektor (III/c)'       => 200,
        'Lektor (III/d)'       => 300,
        'Lektor Kepala (IV/a)' => 400,
        'Lektor Kepala (IV/b)' => 550,
        'Lektor Kepala (IV/c)' => 700,
        'Guru Besar (IV/d)'    => 850,
        'Guru Besar (IV/e)'    => 1050,
    ];

    $thresholdsKonversi = [
        'Asisten Ahli (III/b)' => 150,
        'Lektor (III/c)'       => 200,
        'Lektor (III/d)'       => 300,
        'Lektor Kepala (IV/a)' => 400,
        'Lektor Kepala (IV/b)' => 550,
        'Lektor Kepala (IV/c)' => 700,
        'Guru Besar (IV/d)'    => 850,
        'Guru Besar (IV/e)'    => 1050,
    ];

    $targetKUM = $thresholdsKUM[$pegawai->jabatan_tujuan] ?? 0;
    $targetKonversi = $thresholdsKonversi[$pegawai->jabatan_tujuan] ?? 0;

    $currentKUM = $pegawai->ak_lama ?? 0;
    $currentKonversi = $pegawai->ak_baru ?? 0;
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
            'status_verifikasi' => $file ? $file->status_verifikasi : 'Menunggu Verifikasi',
            'catatan_verifikator' => $file ? $file->catatan_verifikator : null,
        ];
    }

    // 3. Kirim ke view khusus dosen dengan variabel tambahan konversi
    return view('pages.monitoring.dosen.index', compact('pegawai', 'currentKUM', 'targetKUM', 'currentKonversi', 'targetKonversi', 'requirements'));
}

public function selesaikanKenaikan($id)
{
    $pegawai = \App\Models\Pegawai::findOrFail($id);
    $target = $pegawai->jabatan_tujuan;

    if (!$target) {
        return back()->with('error', 'Jabatan tujuan belum ditentukan.');
    }

    // Menggunakan regex untuk memisahkan Jabatan Fungsional dan Pangkat/Golongan
    // Contoh: "Lektor Kepala (IV/a)" -> $matches[1] = Lektor Kepala, $matches[2] = IV/a
    if (preg_match('/^(.*?)\s*\((.*?)\)$/', $target, $matches)) {
        $jabatanFungsional = trim($matches[1]);
        $pangkatGolongan   = trim($matches[2]);

        // --- LOGIKA PENGOSONGAN BERKAS ---
        // 1. Ambil daftar nama dokumen yang menjadi syarat untuk jabatan target saat ini
        $docTypes = $this->getRequirementsFor($target);

        // 2. Hapus berkas persyaratan tersebut dari database agar statusnya kembali "Kosong"
        // Kita hanya menghapus berkas yang termasuk dalam kategori 'Lain-lain' (berkas kenaikan)
        \App\Models\EFile::where('pegawai_id', $pegawai->id)
            ->whereIn('nama_dokumen', $docTypes)
            ->delete();

        // --- UPDATE DATA PEGAWAI ---
        // 3. Simpan jabatan baru ke profil utama dan reset target serta nilai AK
        $pegawai->update([
            'jabatan_fungsional' => $jabatanFungsional,
            'pangkat_golongan'   => $pangkatGolongan,
            'jabatan_tujuan'     => null, // Reset target
            'ak_lama'            => 0,    // Reset KUM untuk periode berikutnya
            'ak_baru'            => 0     // Reset Konversi untuk periode berikutnya
        ]);

        return redirect()->route('monitoring.admin.index')->with('success', 'Selamat! Kenaikan jabatan berhasil diproses. Data profil telah diperbarui dan berkas persyaratan telah dikosongkan untuk periode audit selanjutnya.');
    }

    return back()->with('error', 'Format nama jabatan tujuan tidak dikenali oleh sistem.');
}

}