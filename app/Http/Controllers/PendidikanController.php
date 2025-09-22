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
use Illuminate\Support\Collection;

class PendidikanController extends Controller
{
    // Method untuk mengambil dan memfilter data secara dinamis
    private function getFilteredData(Request $request, $modelClass, array $searchableFields, $pageName)
    {
        $query = $modelClass::query()->with('pegawai');

        // Filter Pencarian
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search, $searchableFields) {
                // Pencarian pada relasi pegawai (nama dosen)
                $q->whereHas('pegawai', function ($subq) use ($search) {
                    $subq->where('nama_lengkap', 'like', "%{$search}%");
                });

                // Pencarian pada kolom-kolom lain di tabel utama
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        // Filter Tahun Akademik (Semester)
        if ($tahunAkademik = $request->input('tahun_akademik')) {
            $query->where('tahun_semester', $tahunAkademik);
        }

        // Filter Status
        if ($status = $request->input('status')) {
            $query->where('status_verifikasi', $status);
        }

        return $query->latest()->paginate(10, ['*'], $pageName)->withQueryString();
    }

    // Method untuk mendapatkan semua opsi tahun akademik yang unik dari semua tabel
    private function getTahunAkademikOptions(): Collection
    {
        $models = [
            PengajaranLama::class, PengajaranLuar::class, PengujianLama::class,
            PembimbingLama::class, PengujiLuar::class, PembimbingLuar::class,
        ];
        
        $allTahun = new Collection();

        foreach ($models as $model) {
            $allTahun = $allTahun->merge($model::select('tahun_semester')->distinct()->pluck('tahun_semester'));
        }

        return $allTahun->unique()->sort()->values();
    }

    public function index(Request $request) {
        $dosenAktif = Pegawai::where('status_pegawai', 'Aktif')->orderBy('nama_lengkap')->get();
        $tahunAkademikOptions = $this->getTahunAkademikOptions();

        return view('pages.pendidikan', [
            'dosenAktif' => $dosenAktif,
            'tahunAkademikOptions' => $tahunAkademikOptions,
            
            'dataPengajaranLama' => $this->getFilteredData($request, PengajaranLama::class, ['nama_mk', 'kode_mk'], 'pengajaran_lama_page'),
            'dataPengajaranLuar' => $this->getFilteredData($request, PengajaranLuar::class, ['universitas', 'nama_mk'], 'pengajaran_luar_page'),
            'dataPengujianLama' => $this->getFilteredData($request, PengujianLama::class, ['nama_mahasiswa', 'nim', 'departemen'], 'pengujian_lama_page'),
            'dataPembimbingLama' => $this->getFilteredData($request, PembimbingLama::class, ['kegiatan', 'nama_mahasiswa'], 'pembimbing_lama_page'),
            'dataPengujiLuar' => $this->getFilteredData($request, PengujiLuar::class, ['nama_mahasiswa', 'universitas'], 'penguji_luar_page'),
            'dataPembimbingLuar' => $this->getFilteredData($request, PembimbingLuar::class, ['nama_mahasiswa', 'universitas'], 'pembimbing_luar_page'),
        ]);
    }

    // Fungsi untuk meng-handle upload file
    private function handleFileUpload(Request $request, $fieldName, $directory, $existingPath = null) {
        if ($request->hasFile($fieldName)) {
            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }
            return $request->file($fieldName)->store($directory, 'public');
        }
        return $existingPath;
    }

    private function storeData(Request $request, $modelClass, $validationRules, $directory) {
        $validationRules['pegawai_id'] = 'required|exists:pegawais,id';
        $validationRules['file'] = 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:5120';
        
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except(['file', 'id']);
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
        
        $data = $request->except(['file', 'id', '_method']);
        $data['file_path'] = $this->handleFileUpload($request, 'file', $directory, $dataModel->file_path);

        $dataModel->update($data);
        return response()->json(['success' => 'Data berhasil diperbarui.']);
    }

    public function storePengajaranLama(Request $request) {
        return $this->storeData($request, PengajaranLama::class, ['tahun_semester' => 'required', 'nama_mk' => 'required', 'kode_mk' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer'], 'pendidikan/pengajaran-lama');
    }
    public function editPengajaranLama($id) { return $this->editData(PengajaranLama::class, $id); }
    public function updatePengajaranLama(Request $request, $id) {
        return $this->updateData($request, $id, PengajaranLama::class, ['tahun_semester' => 'required', 'nama_mk' => 'required', 'kode_mk' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer'], 'pendidikan/pengajaran-lama');
    }
    public function showPengajaranLama($id) { return $this->showDetail(PengajaranLama::class, $id); }

    public function storePengajaranLuar(Request $request) {
        return $this->storeData($request, PengajaranLuar::class, ['tahun_semester' => 'required', 'kode_mk' => 'required', 'nama_mk' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pengajaran-luar');
    }
    public function editPengajaranLuar($id) { return $this->editData(PengajaranLuar::class, $id); }
    public function updatePengajaranLuar(Request $request, $id) {
        return $this->updateData($request, $id, PengajaranLuar::class, ['tahun_semester' => 'required', 'kode_mk' => 'required', 'nama_mk' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'jenis' => 'required', 'kelas_paralel' => 'required', 'jumlah_pertemuan' => 'required|integer', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pengajaran-luar');
    }
    public function showPengajaranLuar($id) { return $this->showDetail(PengajaranLuar::class, $id); }

    public function storePengujianLama(Request $request) {
        return $this->storeData($request, PengujianLama::class, ['kegiatan' => 'required', 'strata' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pengujian-lama');
    }
    public function editPengujianLama($id) { return $this->editData(PengujianLama::class, $id); }
    public function updatePengujianLama(Request $request, $id) {
        return $this->updateData($request, $id, PengujianLama::class, ['kegiatan' => 'required', 'strata' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pengujian-lama');
    }
    public function showPengujianLama($id) { return $this->showDetail(PengujianLama::class, $id); }

    public function storePembimbingLama(Request $request) {
        return $this->storeData($request, PembimbingLama::class, ['kegiatan' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pembimbing-lama');
    }
    public function editPembimbingLama($id) { return $this->editData(PembimbingLama::class, $id); }
    public function updatePembimbingLama(Request $request, $id) {
        return $this->updateData($request, $id, PembimbingLama::class, ['kegiatan' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'departemen' => 'required'], 'pendidikan/pembimbing-lama');
    }
    public function showPembimbingLama($id) { return $this->showDetail(PembimbingLama::class, $id); }

    public function storePengujiLuar(Request $request) {
        return $this->storeData($request, PengujiLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/penguji-luar');
    }
    public function editPengujiLuar($id) { return $this->editData(PengujiLuar::class, $id); }
    public function updatePengujiLuar(Request $request, $id) {
        return $this->updateData($request, $id, PengujiLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'strata' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/penguji-luar');
    }
    public function showPengujiLuar($id) { return $this->showDetail(PengujiLuar::class, $id); }

    public function storePembimbingLuar(Request $request) {
        return $this->storeData($request, PembimbingLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pembimbing-luar');
    }
    public function editPembimbingLuar($id) { return $this->editData(PembimbingLuar::class, $id); }
    public function updatePembimbingLuar(Request $request, $id) {
        return $this->updateData($request, $id, PembimbingLuar::class, ['kegiatan' => 'required', 'status' => 'required', 'tahun_semester' => 'required', 'nim' => 'required', 'nama_mahasiswa' => 'required', 'universitas' => 'required', 'program_studi' => 'required', 'is_insidental' => 'required', 'is_lebih_satu_semester' => 'required'], 'pendidikan/pembimbing-luar');
    }
    public function showPembimbingLuar($id) { return $this->showDetail(PembimbingLuar::class, $id); }

    private function showDetail($model, $id) {
        $data = $model::with('pegawai')->find($id);
        return $data ? response()->json($data) : response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

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
            'pengajaran-lama' => PengajaranLama::class, 'pengajaran-luar' => PengajaranLuar::class,
            'pengujian-lama' => PengujianLama::class, 'pembimbing-lama' => PembimbingLama::class,
            'penguji-luar' => PengujiLuar::class, 'pembimbing-luar' => PembimbingLuar::class,
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

    public function hapus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'type' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Data tidak valid.'], 422);
        }

        $modelMapping = [
            'pengajaran-lama' => PengajaranLama::class, 'pengajaran-luar' => PengajaranLuar::class,
            'pengujian-lama' => PengujianLama::class, 'pembimbing-lama' => PembimbingLama::class,
            'penguji-luar' => PengujiLuar::class, 'pembimbing-luar' => PembimbingLuar::class,
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

        if ($record->file_path) {
            Storage::disk('public')->delete($record->file_path);
        }

        $record->delete();

        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}