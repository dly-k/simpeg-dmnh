<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSuratTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pegawai_id'        => 'sometimes|required|integer|exists:pegawais,id',
            'peran'             => 'required|string|max:100',
            'diminta_sebagai'   => 'required|string|max:100',
            'mitra_instansi'    => 'required|string|max:150',
            'no_surat_instansi' => 'required|string|max:100',
            'tgl_surat_instansi'=> 'required|date',
            'no_surat_kadep'    => 'required|string|max:100',
            'tgl_surat_kadep'   => 'required|date',
            'tgl_kegiatan'      => 'required|date',
            'lokasi'            => 'required|string|max:150',
            'dokumen'           => 'required|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'pegawai_id.required' => 'Nama dosen wajib diisi.', // Diubah
            'pegawai_id.exists'   => 'Dosen yang dipilih tidak valid.', // Ditambah
            'peran.required'             => 'Peran wajib diisi.',
            'diminta_sebagai.required'   => 'Pemohon / menjadi wajib diisi.',
            'mitra_instansi.required'    => 'Mitra / instansi wajib diisi.',
            'no_surat_instansi.required' => 'Nomor surat instansi wajib diisi.',
            'tgl_surat_instansi.required'=> 'Tanggal surat instansi wajib diisi.',
            'no_surat_kadep.required'    => 'Nomor surat kadep wajib diisi.',
            'tgl_surat_kadep.required'   => 'Tanggal surat kadep wajib diisi.',
            'tgl_kegiatan.required'      => 'Tanggal kegiatan wajib diisi.',
            'lokasi.required'            => 'Lokasi wajib diisi.',
            'dokumen.required'           => 'File dokumen wajib diupload.',
            'dokumen.mimes'              => 'Dokumen harus berupa file pdf, doc, docx',
            'dokumen.max'                => 'Ukuran dokumen maksimal 5MB.',
        ];
    }
}