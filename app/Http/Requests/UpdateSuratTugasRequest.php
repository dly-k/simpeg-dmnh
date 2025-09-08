<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuratTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_dosen'        => 'sometimes|required|string|max:255',
            'peran'             => 'sometimes|required|string|max:100',
            'diminta_sebagai'   => 'sometimes|nullable|string|max:100',
            'mitra_instansi'    => 'sometimes|nullable|string|max:150',
            'no_surat_instansi' => 'sometimes|nullable|string|max:100',
            'tgl_surat_instansi'=> 'sometimes|nullable|date',
            'no_surat_kadep'    => 'sometimes|nullable|string|max:100',
            'tgl_surat_kadep'   => 'sometimes|nullable|date',
            'tgl_kegiatan'      => 'sometimes|nullable|date',
            'lokasi'            => 'sometimes|nullable|string|max:150',
            'dokumen'           => 'sometimes|nullable|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_dosen.required' => 'Nama dosen wajib diisi.',
            'peran.required'      => 'Peran wajib diisi.',
            'dokumen.mimes'       => 'Dokumen harus berupa pdf, doc, docx',
            'dokumen.max'         => 'Ukuran dokumen maksimal 5MB.',
        ];
    }
}