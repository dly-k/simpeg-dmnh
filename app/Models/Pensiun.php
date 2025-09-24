<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensiun extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'jenis_pensiun', 'nomor_sk', 'tanggal_sk', 
        'tmt_pensiun', 'file_path'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}