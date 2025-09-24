<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenaikanGajiBerkala extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'golongan', 'nomor_sk', 'tanggal_sk', 
        'tmt_gaji', 'gaji_pokok', 'file_path'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}