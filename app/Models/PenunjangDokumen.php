<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenunjangDokumen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function penunjang() {
        return $this->belongsTo(Penunjang::class);
    }
}