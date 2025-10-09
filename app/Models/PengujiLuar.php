<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengujiLuar extends Model {
    use HasFactory;
    protected $fillable = [
        'pegawai_id', 'kegiatan', 'tahun_semester', 'nim', 'nama_mahasiswa',
        'universitas', 'strata', 'program_studi', 'is_insidental',
        'is_lebih_satu_semester', 'file_path',
    ];
    public function pegawai(): BelongsTo {
        return $this->belongsTo(Pegawai::class);
    }
}