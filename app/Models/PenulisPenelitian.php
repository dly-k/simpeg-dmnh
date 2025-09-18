<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenulisPenelitian extends Model
{
    use HasFactory;
    protected $table = 'penulis_penelitian';
    protected $guarded = ['id'];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class);
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}