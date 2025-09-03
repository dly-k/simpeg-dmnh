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
        'nama_pegawai', // DIUBAH
        'nama_unit',    // DIUBAH
        'tanggal_mulai',
        'tanggal_selesai',
        'nomor_sk',
        'tanggal_sk',
        'jenis_sk',
        'dokumen_path',
    ];
}