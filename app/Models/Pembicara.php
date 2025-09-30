<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembicara extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'kegiatan',
        'kegiatan_lainnya',
        'kategori_capaian',
        'kategori_capaian_lainnya',
        'litabmas',
        'kategori_pembicara',
        'judul_makalah',
        'nama_pertemuan',
        'tingkat_pertemuan',
        'penyelenggara',
        'tanggal_pelaksana',
        'bahasa',
        'no_sk',
        'tanggal_sk',
        'status_verifikasi',
    ];

    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPembicara::class);
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}