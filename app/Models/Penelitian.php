<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penelitian extends Model
{
    use HasFactory;
    protected $table = 'penelitian';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_terbit' => 'date',
        'is_publik' => 'boolean'
    ];

    public function penulis()
    {
        return $this->hasMany(PenulisPenelitian::class)->orderBy('id');
    }
}