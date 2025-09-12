<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkNonPns extends Model
{
    use HasFactory;

    protected $table = 'sk_non_pns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pegawai_id', // DIUBAH
        'nama_unit',
        'tanggal_mulai',
        'tanggal_selesai',
        'nomor_sk',
        'tanggal_sk',
        'jenis_sk',
        'dokumen_path',
    ];

    /**
     * Mendefinisikan relasi ke model Pegawai.
     * Setiap SK Non PNS dimiliki oleh satu Pegawai.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}