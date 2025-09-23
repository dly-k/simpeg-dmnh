<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKerjasamaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'mitra' => 'required|string|max:255',
            'no_surat_mitra' => 'required|string|max:255',
            'no_surat_departemen' => 'required|string|max:255',
            'tgl_dokumen' => 'required|date',
            'departemen_penanggung_jawab' => 'required|string|max:255',
            'tmt' => 'required|date|date_format:Y-m-d',
            'tst' => 'required|date|date_format:Y-m-d|after_or_equal:tmt',
            'lokasi' => 'required|string|max:255',
            'besaran_dana' => 'required|numeric|min:0',
            'jenis_kerjasama' => 'required|string|in:MoU,LoA,SPK',
            'jenis_usulan' => 'required|string|in:Baru,Perpanjangan',

            // file
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'file_laporan' => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            // ketua (minimal 1)
            'ketua' => 'required|array|min:1',
            'ketua.*.nama' => 'required|string|max:255',
            'ketua.*.departemen' => 'required|string|max:255',

            // anggota (minimal 1)
            'anggota' => 'required|array|min:1',
            'anggota.*.nama' => 'required|string|max:255',
            'anggota.*.departemen' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            // umum
            'judul.required' => 'Judul kerjasama wajib diisi.',
            'mitra.required' => 'Nama mitra wajib diisi.',
            'no_surat_mitra.required' => 'Nomor surat mitra wajib diisi.',
            'no_surat_departemen.required' => 'Nomor surat departemen wajib diisi.',
            'tgl_dokumen.required' => 'Tanggal dokumen wajib diisi.',
            'tgl_dokumen.date' => 'Tanggal dokumen harus berupa tanggal yang valid.',
            'departemen_penanggung_jawab.required' => 'Departemen penanggung jawab wajib dipilih.',
            'tmt.required' => 'Tanggal mulai (TMT) wajib diisi.',
            'tst.required' => 'Tanggal selesai (TST) wajib diisi.',
            'tst.after_or_equal' => 'Tanggal selesai (TST) harus setelah atau sama dengan TMT.',
            'lokasi.required' => 'Lokasi kerjasama wajib diisi.',
            'besaran_dana.required' => 'Besaran dana wajib diisi.',
            'besaran_dana.numeric' => 'Besaran dana harus berupa angka.',
            'besaran_dana.min' => 'Besaran dana tidak boleh negatif.',
            'jenis_kerjasama.required' => 'Jenis kerjasama wajib dipilih.',
            'jenis_kerjasama.in' => 'Jenis kerjasama harus berupa MoU, LoA, atau SPK.',
            'jenis_usulan.required' => 'Jenis usulan wajib dipilih.',
            'jenis_usulan.in' => 'Jenis usulan harus berupa Baru atau Perpanjangan.',

            // file
            'file_dokumen.required' => 'Dokumen kerjasama wajib diunggah.',
            'file_dokumen.mimes' => 'Format dokumen hanya boleh PDF, DOC, atau DOCX.',
            'file_dokumen.max' => 'Ukuran dokumen maksimal 5 MB.',
            'file_laporan.mimes' => 'Format laporan hanya boleh PDF, DOC, atau DOCX.',
            'file_laporan.max' => 'Ukuran laporan maksimal 5 MB.',

            // ketua
            'ketua.required' => 'Minimal harus ada 1 ketua.',
            'ketua.min' => 'Minimal harus ada 1 ketua.',
            'ketua.*.nama.required' => 'Nama ketua wajib diisi.',
            'ketua.*.departemen.required' => 'Departemen ketua wajib diisi.',

            // anggota
            'anggota.required' => 'Minimal harus ada 1 anggota.',
            'anggota.min' => 'Minimal harus ada 1 anggota.',
            'anggota.*.nama.required' => 'Nama anggota wajib diisi.',
            'anggota.*.departemen.required' => 'Departemen anggota wajib diisi.',
        ];
    }
}