<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembimbingLama extends Model {
    use HasFactory;
    protected $fillable = [
        'pegawai_id', 'kegiatan', 'tahun_semester', 'nim', 'nama_mahasiswa',
        'departemen', 'lokasi', 'nama_dokumen', 'file_path',
    ];
    public function pegawai(): BelongsTo {
        return $this->belongsTo(Pegawai::class);
    }
}