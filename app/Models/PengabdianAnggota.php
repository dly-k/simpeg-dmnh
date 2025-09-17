<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengabdianAnggota extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}