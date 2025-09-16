<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenunjangAnggota extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    public function penunjang() {
        return $this->belongsTo(Penunjang::class);
    }
    public function pegawai() {
        return $this->belongsTo(Pegawai::class);
    }
}