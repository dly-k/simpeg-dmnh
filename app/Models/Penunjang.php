<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Penunjang.php
class Penunjang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function anggota() {
        return $this->hasMany(PenunjangAnggota::class);
    }
    public function dokumen() {
        return $this->hasMany(PenunjangDokumen::class);
    }
}