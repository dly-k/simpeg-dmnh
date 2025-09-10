<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Tampilkan daftar pegawai.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil data pegawai yang statusnya 'Aktif' dengan pagination
        // Parameter ketiga 'aktifPage' digunakan agar query string pagination tidak bentrok
        $pegawaiAktif = Pegawai::where('status_pegawai', 'Aktif')
                               ->paginate(10, ['*'], 'aktifPage');

        // Ambil data pegawai yang statusnya BUKAN 'Aktif' untuk tab riwayat
        $pegawaiRiwayat = Pegawai::where('status_pegawai', '!=', 'Aktif')
                                 ->paginate(10, ['*'], 'riwayatPage');

        // Kirim kedua variabel ke view
        return view('pages.pegawai.daftar-pegawai', compact('pegawaiAktif', 'pegawaiRiwayat'));
    }

    /**
     * Tampilkan form untuk menambah pegawai baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pages.pegawai.tambah-pegawai');
    }

    /**
     * Simpan data pegawai baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'required|string|max:255|unique:pegawais,nip',
            'nama_lengkap' => 'required|string|max:255',
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'bidang_ilmu' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status_kepegawaian' => 'required|string|max:255',
            'status_pegawai' => 'required|string|max:255',
            'nomor_arsip' => 'nullable|string|max:255',
            'jabatan_fungsional' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'tmt_pangkat' => 'nullable|date',
            'jabatan_struktural' => 'nullable|string|max:255',
            'periode_jabatan_mulai' => 'nullable|date',
            'periode_jabatan_selesai' => 'nullable|date',
            'finger_print_id' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'nuptk' => 'nullable|string|max:255',
            'sinta_id' => 'nullable|string|max:255',
            'nidn' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'no_sertifikasi_dosen' => 'nullable|string|max:255',
            'orchid_id' => 'nullable|string|max:255',
            'tgl_sertifikasi_dosen' => 'nullable|date',
            'google_scholar_id' => 'nullable|string|max:255',
            'provinsi_domisili' => 'nullable|string|max:255',
            'alamat_domisili' => 'nullable|string',
            'kota_domisili' => 'nullable|string|max:255',
            'kode_pos_domisili' => 'nullable|string|max:255',
            'kecamatan_domisili' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:255',
            'kelurahan_domisili' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'nomor_ktp' => 'nullable|string|max:255',
            'kecamatan_ktp' => 'nullable|string|max:255',
            'nomor_kk' => 'nullable|string|max:255',
            'kelurahan_ktp' => 'nullable|string|max:255',
            'warga_negara' => 'nullable|string|max:255',
            'kode_pos_ktp' => 'nullable|string|max:255',
            'provinsi_ktp' => 'nullable|string|max:255',
            'kabupaten_ktp' => 'nullable|string|max:255',
            'alamat_ktp' => 'nullable|string',
        ]);

        Pegawai::create($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    /**
     * PERUBAHAN: Tambahkan method `show` di bawah ini.
     * Tampilkan detail data pegawai.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\View\View
     */
    public function show(Pegawai $pegawai)
    {
        // Laravel secara otomatis mengambil data pegawai berdasarkan ID dari URL (Route Model Binding).
        // Kemudian, kirim data tersebut ke view 'detail-pegawai'.
        return view('pages.pegawai.detail-pegawai', compact('pegawai'));
    }
    
    /**
     * Tampilkan form untuk mengedit data pegawai.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\View\View
     */
    public function edit(Pegawai $pegawai)
    {
        // Menggunakan Route Model Binding, Laravel otomatis mencari data Pegawai berdasarkan ID
        return view('pages.pegawai.edit-pegawai', compact('pegawai'));
    }

    /**
     * Update data pegawai di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            // Validasi NIP diubah agar mengabaikan NIP milik pegawai yang sedang diedit
            'nip' => 'required|string|max:255|unique:pegawais,nip,' . $pegawai->id,
            'nama_lengkap' => 'required|string|max:255',
            // ... (validasi lainnya sama seperti di method store)
            'agama' => 'nullable|string|max:255',
            'status_pernikahan' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'bidang_ilmu' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'status_kepegawaian' => 'required|string|max:255',
            'status_pegawai' => 'required|string|max:255',
            'nomor_arsip' => 'nullable|string|max:255',
            'jabatan_fungsional' => 'required|string|max:255',
            'pangkat_golongan' => 'required|string|max:255',
            'tmt_pangkat' => 'nullable|date',
            'jabatan_struktural' => 'nullable|string|max:255',
            'periode_jabatan_mulai' => 'nullable|date',
            'periode_jabatan_selesai' => 'nullable|date',
            'finger_print_id' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:255',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'nuptk' => 'nullable|string|max:255',
            'sinta_id' => 'nullable|string|max:255',
            'nidn' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'no_sertifikasi_dosen' => 'nullable|string|max:255',
            'orchid_id' => 'nullable|string|max:255',
            'tgl_sertifikasi_dosen' => 'nullable|date',
            'google_scholar_id' => 'nullable|string|max:255',
            'provinsi_domisili' => 'nullable|string|max:255',
            'alamat_domisili' => 'nullable|string',
            'kota_domisili' => 'nullable|string|max:255',
            'kode_pos_domisili' => 'nullable|string|max:255',
            'kecamatan_domisili' => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:255',
            'kelurahan_domisili' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'nomor_ktp' => 'nullable|string|max:255',
            'kecamatan_ktp' => 'nullable|string|max:255',
            'nomor_kk' => 'nullable|string|max:255',
            'kelurahan_ktp' => 'nullable|string|max:255',
            'warga_negara' => 'nullable|string|max:255',
            'kode_pos_ktp' => 'nullable|string|max:255',
            'provinsi_ktp' => 'nullable|string|max:255',
            'kabupaten_ktp' => 'nullable|string|max:255',
            'alamat_ktp' => 'nullable|string',
        ]);

        $pegawai->update($validatedData);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }
}
