<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kerjasama extends Model
{
    use HasFactory;

    protected $table = 'kerjasama';

    protected $fillable = [
        'judul',
        'mitra',
        'no_surat_mitra',
        'no_surat_departemen',
        'tgl_dokumen',
        'departemen_penanggung_jawab',
        'tmt',
        'tst',
        'lokasi',
        'besaran_dana',
        'jenis_kerjasama',
        'jenis_usulan',
        'file_dokumen',
        'file_laporan',
    ];

    protected $casts = [
        'tgl_dokumen' => 'date',
        'tmt' => 'date',
        'tst' => 'date',
    ];

    // Custom validation for date relationships
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->tmt && $model->tst && $model->tst < $model->tmt) {
                throw new \Exception('Tanggal selesai tidak boleh sebelum tanggal mulai');
            }
        });
    }

    // Relasi ke tim
    public function tim()
    {
        return $this->hasMany(KerjasamaTim::class, 'kerjasama_id');
    }

    // Relasi khusus ketua
    public function ketua()
    {
        return $this->hasMany(KerjasamaTim::class, 'kerjasama_id')
                    ->where('jabatan', 'ketua');
    }

    // Relasi khusus anggota
    public function anggota()
    {
        return $this->hasMany(KerjasamaTim::class, 'kerjasama_id')
                    ->where('jabatan', 'anggota');
    }
}