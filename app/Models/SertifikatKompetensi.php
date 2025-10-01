<?php

// app/Models/SertifikatKompetensi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikatKompetensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id',
        'kegiatan',
        'judul_kegiatan',
        'no_reg_pendidik',
        'no_sk_sertifikasi',
        'tahun_sertifikasi',
        'tmt_sertifikasi',
        'tst_sertifikasi',
        'bidang_studi',
        'lembaga_sertifikasi',
        'dokumen',
        'verifikasi',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
