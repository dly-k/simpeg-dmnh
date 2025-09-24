<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasBelajar extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'jenis_tugas_belajar', 'nomor_sk', 'tanggal_sk', 
        'tanggal_mulai', 'tanggal_selesai', 'file_path'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}