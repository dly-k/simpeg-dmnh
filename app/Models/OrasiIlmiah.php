<?php
// app/Models/OrasiIlmiah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrasiIlmiah extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'litabmas',
        'kategori_pembicara',
        'lingkup',
        'judul_makalah',
        'nama_pertemuan',
        'penyelenggara',
        'tanggal_pelaksana',
        'bahasa',
        'jenis_dokumen',
        'dokumen',
        'nama_dokumen',
        'nomor_dokumen',
        'tautan_dokumen',
        'verifikasi',
    ];

    /**
     * Mendefinisikan relasi ke model Pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
