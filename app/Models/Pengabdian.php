<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengabdian extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function anggota()
    {
        return $this->hasMany(PengabdianAnggota::class);
    }

    public function dokumen()
    {
        return $this->hasMany(PengabdianDokumen::class);
    }
}