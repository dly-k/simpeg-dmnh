<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'nama_jabatan', 'jenis_sk', 'nomor_sk', 
        'tanggal_sk', 'tmt_jabatan', 'file_path'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}