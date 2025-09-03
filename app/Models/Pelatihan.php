<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kegiatan',
        'posisi',
        'posisi_lainnya',
        'penyelenggara',
        'kota',
        'lokasi',
        'tgl_mulai',
        'tgl_selesai',
        'jumlah_jam',
        'jumlah_hari',
        'jenis_diklat',
        'lingkup',
        'struktural',
        'sertifikasi',
        'file_path',       // <-- Pastikan ini ada
        'jenis_dokumen',   // <-- Pastikan ini ada
        'nama_dokumen',    // <-- Pastikan ini ada
        'nomor_dokumen',   // <-- Pastikan ini ada
        'tautan_dokumen',  // <-- Pastikan ini ada
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tgl_mulai'   => 'date',
        'tgl_selesai' => 'date',
        'struktural'  => 'boolean',
        'sertifikasi' => 'boolean',
    ];
}