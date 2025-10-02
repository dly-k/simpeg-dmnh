<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat 3 data pegawai sesuai dengan semua kolom yang wajib diisi
        $pegawai1 = Pegawai::create([
            'nama_lengkap' => 'Admin Utama',
            'nip' => '111111111111111111',
            'nidn' => '11111111',
            'status_pegawai' => 'PNS',
            'status_kepegawaian' => 'Aktif', // <-- PENAMBAHAN KOLOM INI
        ]);

        $pegawai2 = Pegawai::create([
            'nama_lengkap' => 'Verifikator Handal',
            'nip' => '222222222222222222',
            'nidn' => '22222222',
            'status_pegawai' => 'PNS',
            'status_kepegawaian' => 'Aktif', // <-- PENAMBAHAN KOLOM INI
        ]);

        $pegawai3 = Pegawai::create([
            'nama_lengkap' => 'Staf Tata Usaha',
            'nip' => '333333333333333333',
            'nidn' => '33333333',
            'status_pegawai' => 'Non-PNS',
            'status_kepegawaian' => 'Aktif', // <-- PENAMBAHAN KOLOM INI
        ]);

        // 2. Buat user dan tautkan ke pegawai yang baru dibuat
        User::create([
            'pegawai_id' => $pegawai1->id,
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'pegawai_id' => $pegawai2->id,
            'username' => 'verifikator',
            'password' => Hash::make('password'),
            'role' => 'admin_verifikator',
        ]);

        User::create([
            'pegawai_id' => $pegawai3->id,
            'username' => 'tatausaha',
            'password' => Hash::make('password'),
            'role' => 'tata_usaha',
        ]);
    }
}