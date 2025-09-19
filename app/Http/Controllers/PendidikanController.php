<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Pegawai;
use App\Models\PengajaranLama;
use App\Models\PengajaranLuar;
use App\Models\PengujianLama;
use App\Models\PembimbingLama;
use App\Models\PengujiLuar;
use App\Models\PembimbingLuar;

class PendidikanController extends Controller
{
    private function handleFileUpload(Request $request, $fieldName, $directory) {
        if ($request->hasFile($fieldName)) {
            $path = $request->file($fieldName)->store($directory, 'public');
            return $path;
        }
        return null;
    }

    public function index() {
        $dosenAktif = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();
        
        // Tentukan jumlah item per halaman
        $perPage = 10;

        return view('pages.pendidikan', [
            'dosenAktif' => $dosenAktif,
            'dataPengajaranLama' => PengajaranLama::with('pegawai')->latest()->paginate($perPage, ['*'], 'pengajaran_lama_page'),
            'dataPengajaranLuar' => PengajaranLuar::with('pegawai')->latest()->paginate($perPage, ['*'], 'pengajaran_luar_page'),
            'dataPengujianLama' => PengujianLama::with('pegawai')->latest()->paginate($perPage, ['*'], 'pengujian_lama_page'),
            'dataPembimbingLama' => PembimbingLama::with('pegawai')->latest()->paginate($perPage, ['*'], 'pembimbing_lama_page'),
            'dataPengujiLuar' => PengujiLuar::with('pegawai')->latest()->paginate($perPage, ['*'], 'penguji_luar_page'),
            'dataPembimbingLuar' => PembimbingLuar::with('pegawai')->latest()->paginate($perPage, ['*'], 'pembimbing_luar_page'),
        ]);
    }

    private function storeData(Request $request, $modelClass, $validationRules, $directory) {
        $validationRules['pegawai_id'] = 'required|exists:pegawais,id';
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $request->except('file');
        $data['file_path'] = $this->handleFileUpload($request, 'file', $directory);
        $modelClass::create($data);
        return response()->json(['success' => 'Data berhasil ditambahkan.']);
    }

    public function storePengajaranLama(Request $request) {
        return $this->storeData($request, PengajaranLama::class, [
            'tahun_semester' => 'required|string',
            'nama_mk' => 'required|string',
            'kode_mk' => 'required|string',
            'sks_kuliah' => 'nullable|integer',
            'sks_praktikum' => 'nullable|integer',
            'pengampu' => 'nullable|string',
            'jenis' => 'required|string',
            'kelas_paralel' => 'required|string',
            'jumlah_pertemuan' => 'required|integer|min:1',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        ], 'pendidikan/pengajaran-lama');
    }

    public function storePengajaranLuar(Request $request) {
        return $this->storeData($request, PengajaranLuar::class, [
            'tahun_semester' => 'required|string',
            'kode_mk' => 'required|string',
            'nama_mk' => 'required|string',
            'sks_kuliah' => 'nullable|integer',
            'sks_praktikum' => 'nullable|integer',
            'universitas' => 'required|string',
            'strata' => 'required|string',
            'program_studi' => 'required|string',
            'jenis' => 'required|string',
            'kelas_paralel' => 'required|string',
            'jumlah_pertemuan' => 'required|integer|min:1',
            'is_insidental' => 'required|string',
            'is_lebih_satu_semester' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        ], 'pendidikan/pengajaran-luar');
    }

    public function storePengujianLama(Request $request) {
        return $this->storeData($request, PengujianLama::class, [
            'kegiatan' => 'required|string',
            'strata' => 'required|string',
            'tahun_semester' => 'required|string',
            'nim' => 'required|string',
            'nama_mahasiswa' => 'required|string',
            'departemen' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        ], 'pendidikan/pengujian-lama');
    }

    public function storePembimbingLama(Request $request) {
        return $this->storeData($request, PembimbingLama::class, [
            'kegiatan' => 'required|string',
            'tahun_semester' => 'required|string',
            'nim' => 'required|string',
            'nama_mahasiswa' => 'required|string',
            'departemen' => 'required|string',
            'lokasi' => 'nullable|string',
            'nama_dokumen' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        ], 'pendidikan/pembimbing-lama');
    }

    public function storePengujiLuar(Request $request) {
        return $this->storeData($request, PengujiLuar::class, [
            'kegiatan' => 'required|string',
            'status' => 'required|string',
            'tahun_semester' => 'required|string',
            'nim' => 'required|string',
            'nama_mahasiswa' => 'required|string',
            'universitas' => 'required|string',
            'strata' => 'required|string',
            'program_studi' => 'required|string',
            'is_insidental' => 'required|string',
            'is_lebih_satu_semester' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        ], 'pendidikan/penguji-luar');
    }

    public function storePembimbingLuar(Request $request) {
        return $this->storeData($request, PembimbingLuar::class, [
            'kegiatan' => 'required|string',
            'status' => 'required|string',
            'tahun_semester' => 'required|string',
            'nim' => 'required|string',
            'nama_mahasiswa' => 'required|string',
            'universitas' => 'required|string',
            'program_studi' => 'required|string',
            'is_insidental' => 'required|string',
            'is_lebih_satu_semester' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120',
        ], 'pendidikan/pembimbing-luar');
    }

    // == METHOD BARU UNTUK MENGAMBIL DETAIL DATA ==
    private function showDetail($model, $id) {
        $data = $model::with('pegawai')->find($id);
        return $data ? response()->json($data) : response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    public function showPengajaranLama($id) { return $this->showDetail(PengajaranLama::class, $id); }
    public function showPengajaranLuar($id) { return $this->showDetail(PengajaranLuar::class, $id); }
    public function showPengujianLama($id) { return $this->showDetail(PengujianLama::class, $id); }
    public function showPembimbingLama($id) { return $this->showDetail(PembimbingLama::class, $id); }
    public function showPengujiLuar($id) { return $this->showDetail(PengujiLuar::class, $id); }
    public function showPembimbingLuar($id) { return $this->showDetail(PembimbingLuar::class, $id); }
}