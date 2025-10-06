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

    public function pegawai()
    {
        return $this->hasManyThrough(
            Pegawai::class,
            PengabdianAnggota::class,
            'pengabdian_id', // Foreign key di tabel pengabdian_anggotas
            'id',             // Foreign key di tabel pegawais
            'id',             // Local key di tabel pengabdians
            'pegawai_id'      // Local key di tabel pengabdian_anggotas
        );
    }
}