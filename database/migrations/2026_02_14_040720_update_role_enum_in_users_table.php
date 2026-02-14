<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan DB Statement karena Blueprint->change() terkadang bermasalah dengan ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'admin_verifikator', 'tata_usaha', 'dosen') NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan ke asal jika rollback (hapus 'dosen')
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'admin_verifikator', 'tata_usaha') NOT NULL");
    }
};