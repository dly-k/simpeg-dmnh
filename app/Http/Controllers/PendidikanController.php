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
use Illuminate\Validation\Rule;

class PendidikanController extends Controller
{
    // Fungsi untuk meng-handle upload file
    private function handleFileUpload(Request $request, $fieldName, $directory, $existingPath = null) {
        if ($request->hasFile($fieldName)) {
            // Hapus file lama jika ada
            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }
            // Simpan file baru
            return $request->file($fieldName)->store($directory, 'public');
        }
        return $existingPath; // Kembalikan path lama jika tidak ada file baru
    }

    public function index() {
        $dosenAktif = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();
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

    // =================================================================================
    // == FUNGSI-FUNGSI GENERIC UNTUK STORE, EDIT, DAN UPDATE ==
    // =================================================================================

    private function storeData(Request $request, $modelClass, $validationRules, $directory) {
        $validationRules['pegawai_id'] = 'required|exists:pegawais,id';
        $validationRules['file'] = 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120';
        
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['file', 'id']); // id dikecualikan untuk store
        $data['file_path'] = $this->handleFileUpload($request, 'file', $directory);
        
        $modelClass::create($data);
        return response()->json(['success' => 'Data berhasil ditambahkan.']);
    }

    private function editData($modelClass, $id) {
        $data = $modelClass::find($id);
        return $data ? response()->json($data) : response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }
    
    private function updateData(Request $request, $id, $modelClass, $validationRules, $directory) {
        $dataModel = $modelClass::find($id);
        if (!$dataModel) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $validationRules['pegawai_id'] = 'required|exists:pegawais,id';
        $validationRules['file'] = 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120';

        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        $data = $request->except(['file', 'id', '_method']); // Tambahkan _method untuk dikecualikan
        $data['file_path'] = $this->handleFileUpload($request, 'file', $directory, $dataModel->file_path);

        $dataModel->update($data);
        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    // =================================================================================
    // == IMPLEMENTASI UNTUK SETIAP MODEL ==
    // =================================================================================

    // --- Pengajaran Lama ---
    public function storePengajaranLama(Request $request) {
        return $this->storeData($request, PengajaranLama::class, ['tahun_semester' => 'required', 'nama_mk' => 'required', 'kode_mk' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer'], 'pendidikan/pengajaran-lama');
    }
    public function editPengajaranLama($id) { return $this->editData(PengajaranLama::class, $id); }
    public function updatePengajaranLama(Request $request, $id) {
        return $this->updateData($request, $id, PengajaranLama::class, ['tahun_semester' => 'required', 'nama_mk' => 'required', 'kode_mk' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer'], 'pendidikan/pengajaran-lama');
    }
    public function showPengajaranLama($id) { return $this->showDetail(PengajaranLama::class, $id); }

    // --- Pengajaran Luar ---
    public function storePengajaranLuar(Request $request) {
        return $this->storeData($request, PengajaranLuar::class, ['tahun_semester' => 'required', 'kode_mk' => 'required', 'nama_mk' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pengajaran-luar');
    }
    public function editPengajaranLuar($id) { return $this->editData(PengajaranLuar::class, $id); }
    public function updatePengajaranLuar(Request $request, $id) {
        return $this->updateData($request, $id, PengajaranLuar::class, ['tahun_semester' => 'required', 'kode_mk' => 'required', 'nama_mk' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pengajaran-luar');
    }
    public function showPengajaranLuar($id) { return $this->showDetail(PengajaranLuar::class, $id); }

    // --- Pengujian Lama ---
    public function storePengujianLama(Request $request) {
        return $this->storeData($request, PengujianLama::class, ['kegiatan' => 'required', 'strata' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pengujian-lama');
    }
    public function editPengujianLama($id) { return $this->editData(PengujianLama::class, $id); }
    public function updatePengujianLama(Request $request, $id) {
        return $this->updateData($request, $id, PengujianLama::class, ['kegiatan' => 'required', 'strata' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pengujian-lama');
    }
    public function showPengujianLama($id) { return $this->showDetail(PengujianLama::class, $id); }

    // --- Pembimbing Lama ---
    public function storePembimbingLama(Request $request) {
        return $this->storeData($request, PembimbingLama::class, ['kegiatan' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pembimbing-lama');
    }
    public function editPembimbingLama($id) { return $this->editData(PembimbingLama::class, $id); }
    public function updatePembimbingLama(Request $request, $id) {
        return $this->updateData($request, $id, PembimbingLama::class, ['kegiatan' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pembimbing-lama');
    }
    public function showPembimbingLama($id) { return $this->showDetail(PembimbingLama::class, $id); }

    // --- Penguji Luar ---
    public function storePengujiLuar(Request $request) {
        return $this->storeData($request, PengujiLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/penguji-luar');
    }
    public function editPengujiLuar($id) { return $this->editData(PengujiLuar::class, $id); }
    public function updatePengujiLuar(Request $request, $id) {
        return $this->updateData($request, $id, PengujiLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/penguji-luar');
    }
    public function showPengujiLuar($id) { return $this->showDetail(PengujiLuar::class, $id); }

    // --- Pembimbing Luar ---
    public function storePembimbingLuar(Request $request) {
        return $this->storeData($request, PembimbingLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pembimbing-luar');
    }
    public function editPembimbingLuar($id) { return $this->editData(PembimbingLuar::class, $id); }
    public function updatePembimbingLuar(Request $request, $id) {
        return $this->updateData($request, $id, PembimbingLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pembimbing-luar');
    }
    public function showPembimbingLuar($id) { return $this->showDetail(PembimbingLuar::class, $id); }

    // --- Method showDetail ---
    private function showDetail($model, $id) {
        $data = $model::with('pegawai')->find($id);
        return $data ? response()->json($data) : response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    // --- Method Verifikasi ---
    public function verifikasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|string',
            'status' => 'required|in:diverifikasi,ditolak',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Data tidak valid.'], 422);
        }

        $modelMapping = [
            'pengajaran-lama' => PengajaranLama::class,
            'pengajaran-luar' => PengajaranLuar::class,
            'pengujian-lama' => PengujianLama::class,
            'pembimbing-lama' => PembimbingLama::class,
            'penguji-luar' => PengujiLuar::class,
            'pembimbing-luar' => PembimbingLuar::class,
        ];

        $type = $request->input('type');
        if (!isset($modelMapping[$type])) {
            return response()->json(['error' => 'Tipe data tidak valid.'], 400);
        }

        $modelClass = $modelMapping[$type];
        $record = $modelClass::find($request->input('id'));

        if (!$record) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $record->status_verifikasi = $request->input('status');
        $record->save();

        return response()->json(['success' => 'Status verifikasi berhasil diperbarui.']);
    }
}