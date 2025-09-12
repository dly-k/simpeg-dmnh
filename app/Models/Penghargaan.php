<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    use HasFactory;

    protected $table = 'penghargaan';

    protected $fillable = [
        'pegawai_id', // DIUBAH
        'kegiatan',
        'nama_penghargaan',
        'nomor_sk',
        'tanggal_perolehan',
        'lingkup',
        'negara',
        'instansi_pemberi',
        'jenis_dokumen',
        'file_path',
        'nama_dokumen',
        'nomor_dokumen',
        'tautan',
    ];

    /**
     * Mendefinisikan relasi ke model Pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}