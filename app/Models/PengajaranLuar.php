<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajaranLuar extends Model {
    use HasFactory;
    protected $fillable = [
        'pegawai_id', 'tahun_semester', 'kode_mk', 'nama_mk', 'sks_kuliah', 'sks_praktikum',
        'universitas', 'strata', 'program_studi', 'jenis', 'kelas_paralel',
        'jumlah_pertemuan', 'is_insidental', 'is_lebih_satu_semester', 'file_path',
    ];
    public function pegawai(): BelongsTo {
        return $this->belongsTo(Pegawai::class);
    }
}