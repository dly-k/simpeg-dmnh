<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class PengelolaJurnal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // [FIX 1] Tambahkan properti ini
    protected $fillable = [
        'pegawai_id',
        'kegiatan',
        'media_publikasi',
        'peran',
        'no_sk',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    /**
     * Definisikan relasi ke Pegawai
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }

    /**
     * Definisikan relasi ke DokumenPengelolaJurnal
     */
    // [FIX 2] Tambahkan method relasi ini
    public function dokumen(): HasMany
    {
        return $this->hasMany(DokumenPengelolaJurnal::class);
    }
}