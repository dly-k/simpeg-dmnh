<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class DokumenPengelolaJurnal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // [FIX 3] Tambahkan properti ini
    protected $fillable = [
        'pengelola_jurnal_id',
        'jenis_dokumen',
        'nama_dokumen',
        'nomor_dokumen',
        'tautan_dokumen',
        'path_file',
    ];

    /**
     * Definisikan relasi ke PengelolaJurnal
     */
    public function pengelolaJurnal(): BelongsTo
    {
        return $this->belongsTo(PengelolaJurnal::class);
    }
}