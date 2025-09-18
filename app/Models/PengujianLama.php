<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengujianLama extends Model {
    use HasFactory;
    protected $fillable = [
        'pegawai_id', 'kegiatan', 'strata', 'tahun_semester', 'nim',
        'nama_mahasiswa', 'departemen', 'file_path',
    ];
    public function pegawai(): BelongsTo {
        return $this->belongsTo(Pegawai::class);
    }
}