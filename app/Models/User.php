<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'pegawai_id',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
    
    public function isStaff()
    {
        // Kelompok yang memiliki akses administratif ke data pegawai lain
        return in_array($this->role, ['admin', 'admin_verifikator', 'tata_usaha']);
    }
}