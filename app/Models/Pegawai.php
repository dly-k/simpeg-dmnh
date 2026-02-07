<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip', 'nama_lengkap', 'status_kepegawaian', 'jabatan_fungsional','divisi',
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

    // --- RELASI BAWAAN ---
        public function user()
    {
        return $this->hasOne(User::class);
    }
    
    public function penelitian()
    {
        return $this->belongsToMany(Penelitian::class, 'penulis_penelitian');
    }

    public function pengabdian()
    {
        return $this->belongsToMany(Pengabdian::class, 'pengabdian_anggotas');
    }

    public function penghargaan()
    {
        return $this->hasMany(Penghargaan::class);
    }

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class);
    }

    public function suratTugas()
    {
        return $this->hasMany(SuratTugas::class);
    }
    
    public function efiles()
    {
        return $this->hasMany(EFile::class)->orderBy('created_at', 'desc');
    }

    // --- RELASI UNTUK MENU SK (SURAT KEPUTUSAN) ---
    
    public function skNonPns()
    {
        return $this->hasMany(SkNonPns::class)->orderBy('tanggal_mulai', 'desc');
    }
    
    public function penetapanPangkats()
    {
        return $this->hasMany(PenetapanPangkat::class)->orderBy('tmt_pangkat', 'desc');
    }

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class)->orderBy('tmt_jabatan', 'desc');
    }

    public function jabatanSaatInis()
    {
        return $this->hasMany(JabatanSaatIni::class)->orderBy('created_at', 'desc');
    }

    public function pensiuns()
    {
        return $this->hasMany(Pensiun::class)->orderBy('tmt_pensiun', 'desc');
    }

    public function kenaikanGajiBerkalas()
    {
        return $this->hasMany(KenaikanGajiBerkala::class)->orderBy('tmt_gaji', 'desc');
    }

    public function tugasBelajars()
    {
        return $this->hasMany(TugasBelajar::class)->orderBy('tanggal_mulai', 'desc');
    }
    public function praktisis(): HasMany
    {
        return $this->hasMany(Praktisi::class);
    }
        public function pembicara(): HasMany
    {
        return $this->hasMany(Pembicara::class);
    }
        public function orasiIlmiahs()
    {
        return $this->hasMany(OrasiIlmiah::class, 'pegawai_id');
    }
}