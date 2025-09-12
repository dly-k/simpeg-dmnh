<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KerjasamaTim extends Model
{
    use HasFactory;

    protected $table = 'kerjasama_tim';

    protected $fillable = [
        'kerjasama_id',
        'nama',
        'departemen',
        'jabatan',
    ];

    // Relasi balik ke kerjasama
    public function kerjasama()
    {
        return $this->belongsTo(Kerjasama::class, 'kerjasama_id');
    }
}