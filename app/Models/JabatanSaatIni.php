<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JabatanSaatIni extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id', 'nama_jabatan', 'jenis_jabatan', 'nomor_sk', 'file_path'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}