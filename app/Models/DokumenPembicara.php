<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenPembicara extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembicara_id',
        'jenis_dokumen',
        'nama_dokumen',
        'nomor',
        'tautan',
        'file_path',
    ];

    public function pembicara(): BelongsTo
    {
        return $this->belongsTo(Pembicara::class);
    }
}