<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Praktisi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'instansi',
        'divisi',
        'jenis_pekerjaan',
        'jabatan',
        'bidang_usaha',
        'deskripsi_kerja',
        'tmt',
        'tst',
        'area_pekerjaan',
        'kategori_pekerjaan',
        'surat_ipb',
        'surat_instansi',
        'cv',
        'profil_perusahaan',
        'status',
    ];

    /**
     * Mendefinisikan relasi bahwa satu data Praktisi dimiliki oleh satu Pegawai.
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}