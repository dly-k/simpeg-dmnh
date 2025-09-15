<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihans';

    protected $fillable = [
        'pegawai_id',
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
        'file_path',
        'jenis_dokumen',
        'nama_dokumen',
        'nomor_dokumen',
        'tautan_dokumen',
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'struktural' => 'boolean',
        'sertifikasi' => 'boolean',
    ];

    /**
     * Mendefinisikan relasi bahwa satu pelatihan dimiliki oleh satu pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}