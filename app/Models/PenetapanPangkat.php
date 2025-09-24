<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenetapanPangkat extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'golongan', 'nomor_bkn', 'tanggal_bkn', 'nomor_sk', 
        'tanggal_sk', 'tmt_pangkat', 'file_path'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}