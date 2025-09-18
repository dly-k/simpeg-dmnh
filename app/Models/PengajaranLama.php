<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajaranLama extends Model {
    use HasFactory;
    protected $fillable = [
        'pegawai_id', 'tahun_semester', 'kode_mk', 'nama_mk', 'sks_kuliah',
        'sks_praktikum', 'pengampu', 'jenis', 'kelas_paralel', 'jumlah_pertemuan', 'file_path',
    ];
    public function pegawai(): BelongsTo {
        return $this->belongsTo(Pegawai::class);
    }
}