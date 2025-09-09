<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip', 'nama_lengkap', 'agama', 'status_pernikahan', 'jenis_kelamin',
        'pendidikan_terakhir', 'tempat_lahir', 'bidang_ilmu', 'tanggal_lahir', 'foto_profil',
        'status_kepegawaian', 'status_pegawai', 'nomor_arsip', 'jabatan_fungsional',
        'pangkat_golongan', 'tmt_pangkat', 'jabatan_struktural', 'periode_jabatan_mulai',
        'periode_jabatan_selesai', 'finger_print_id', 'npwp', 'nama_bank', 'nomor_rekening',
        'nuptk', 'sinta_id', 'nidn', 'scopus_id', 'no_sertifikasi_dosen', 'orchid_id',
        'tgl_sertifikasi_dosen', 'google_scholar_id', 'provinsi_domisili', 'alamat_domisili',
        'kota_domisili', 'kode_pos_domisili', 'kecamatan_domisili', 'no_telepon',
        'kelurahan_domisili', 'email', 'nomor_ktp', 'kecamatan_ktp', 'nomor_kk',
        'kelurahan_ktp', 'warga_negara', 'kode_pos_ktp', 'provinsi_ktp', 'kabupaten_ktp',
        'alamat_ktp'
    ];
    
}
