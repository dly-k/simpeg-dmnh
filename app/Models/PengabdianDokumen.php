<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class PengabdianDokumen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Menambahkan atribut 'file_url' ke output JSON secara otomatis
    protected $appends = ['file_url'];

    public function pengabdian()
    {
        return $this->belongsTo(Pengabdian::class);
    }

    // Accessor ini akan membuat URL lengkap ke file
    public function getFileUrlAttribute()
    {
        // Jika ada file_path, buat URL-nya, jika tidak, kembalikan null
        return $this->file_path ? Storage::url($this->file_path) : null;
    }
}