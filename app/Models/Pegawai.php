<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip', 'nama_lengkap', 'status_kepegawaian', 'jabatan_fungsional',
        'jabatan_struktural', 'pangkat_golongan', 'status_pegawai', 'agama',
        'status_pernikahan', 'jenis_kelamin', 'pendidikan_terakhir', 'tempat_lahir',
        'bidang_ilmu', 'tanggal_lahir', 'foto_profil', 'nomor_arsip', 'tmt_pangkat',
        'periode_jabatan_mulai', 'periode_jabatan_selesai', 'finger_print_id', 'npwp',
        'nama_bank', 'nomor_rekening', 'nuptk', 'sinta_id', 'nidn', 'scopus_id',
        'no_sertifikasi_dosen', 'orchid_id', 'tgl_sertifikasi_dosen', 'google_scholar_id',
        'provinsi_domisili', 'alamat_domisili', 'kota_domisili', 'kode_pos_domisili',
        'kecamatan_domisili', 'no_telepon', 'kelurahan_domisili', 'email', 'nomor_ktp',
        'kecamatan_ktp', 'nomor_kk', 'kelurahan_ktp', 'warga_negara', 'kode_pos_ktp',
        'provinsi_ktp', 'kabupaten_ktp', 'alamat_ktp',
    ];

    public function efiles()
    {
        return $this->hasMany(EFile::class)->orderBy('created_at', 'desc');
    }

    public function skNonPns()
    {
        return $this->hasMany(SkNonPns::class);
    }
        public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class);
    }
     public function suratTugas()
    {
        return $this->hasMany(SuratTugas::class);
    }
         public function pelatihans()
    {
        return $this->hasMany(Pelatihan::class);
    }
    public function pengabdianAnggota()
    {
        // Seorang Pegawai memiliki banyak (hasMany) data di PengabdianAnggota
        return $this->hasMany(PengabdianAnggota::class);
    }
        public function karyaPenelitian()
    {
        return $this->hasMany(PenulisPenelitian::class, 'pegawai_id');
    }
}