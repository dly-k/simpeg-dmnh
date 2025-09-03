<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sk_non_pns', function (Blueprint $table) {
            $table->id();
            // KOLOM DIUBAH: Tidak lagi terhubung ke tabel lain
            $table->string('nama_pegawai');
            $table->string('nama_unit');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('nomor_sk')->unique();
            $table->date('tanggal_sk');
            $table->string('jenis_sk');
            $table->string('dokumen_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sk_non_pns');
    }
};