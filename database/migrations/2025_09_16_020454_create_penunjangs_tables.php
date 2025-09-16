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
        Schema::create('penunjangs', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan');
            $table->string('jenis_kegiatan');
            $table->string('lingkup');
            $table->string('nama_kegiatan');
            $table->string('instansi');
            $table->string('nomor_sk');
            $table->date('tmt_mulai');
            $table->date('tmt_selesai');
            $table->enum('status', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])->default('Belum Diverifikasi');
            $table->timestamps();
        });

        Schema::create('penunjang_anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penunjang_id')->constrained()->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->string('peran');
            $table->timestamps();
        });

        Schema::create('penunjang_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penunjang_id')->constrained()->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('nama_dokumen');
            $table->string('nomor_dokumen')->nullable();
            $table->string('tautan')->nullable();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penunjang_dokumens');
        Schema::dropIfExists('penunjang_anggotas');
        Schema::dropIfExists('penunjangs');
    }
};