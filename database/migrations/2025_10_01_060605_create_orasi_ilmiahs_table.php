<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_orasi_ilmiahs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orasi_ilmiahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('litabmas')->nullable();
            $table->string('kategori_pembicara');
            $table->string('lingkup');
            $table->string('judul_makalah');
            $table->string('nama_pertemuan');
            $table->string('penyelenggara');
            $table->date('tanggal_pelaksana');
            $table->string('bahasa')->nullable();
            $table->string('jenis_dokumen');
            $table->string('dokumen')->nullable(); // Path ke file
            $table->string('nama_dokumen')->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->string('tautan_dokumen')->nullable();
            $table->enum('verifikasi', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])->default('Belum Diverifikasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orasi_ilmiahs');
    }
};