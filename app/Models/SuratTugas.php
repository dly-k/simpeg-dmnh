<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';

    protected $fillable = [
        'pegawai_id', // Ganti dari 'nama_dosen'
        'peran',
        'diminta_sebagai',
        'mitra_instansi',
        'no_surat_instansi',
        'tgl_surat_instansi',
        'no_surat_kadep',
        'tgl_surat_kadep',
        'tgl_kegiatan',
        'lokasi',
        'dokumen',
    ];

    protected $casts = [
        'tgl_surat_instansi' => 'date',
        'tgl_surat_kadep'    => 'date',
        'tgl_kegiatan'       => 'date',
    ];

    /**
     * Definisikan relasi one-to-many (inverse) / belongsTo.
     * Satu surat tugas dimiliki oleh satu pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}