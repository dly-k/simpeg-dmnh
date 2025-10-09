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
        Schema::create('penguji_luars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('kegiatan');
            $table->string('tahun_semester');
            $table->string('nim');
            $table->string('nama_mahasiswa');
            $table->string('universitas');
            $table->string('strata');
            $table->string('program_studi');
            $table->string('is_insidental');
            $table->string('is_lebih_satu_semester');
            $table->string('status_verifikasi')->default('belum diverifikasi');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penguji_luars');
    }
};