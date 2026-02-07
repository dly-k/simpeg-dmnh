<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EFile extends Model
{
    use HasFactory;

protected $fillable = [
    'pegawai_id', 'kategori_dokumen', 'nama_dokumen', 
    'keaslian_dokumen', 'tanggal_dokumen', 'file_path', 
    'link_url', 'is_link'
];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}