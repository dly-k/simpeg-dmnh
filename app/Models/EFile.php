<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'kategori_dokumen',
        'nama_dokumen',
        'nomor_dokumen', // Pastikan kolom ini juga ada jika digunakan
        'keaslian_dokumen', // TAMBAHKAN INI
        'tanggal_dokumen',
        'file_path',
        'file_name',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}