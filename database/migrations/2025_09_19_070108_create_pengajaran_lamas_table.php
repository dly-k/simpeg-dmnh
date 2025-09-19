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
        Schema::create('pengajaran_lamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('tahun_semester');
            $table->string('nama_mk');
            $table->string('kode_mk');
            $table->integer('sks_kuliah')->nullable();
            $table->integer('sks_praktikum')->nullable();
            $table->string('pengampu')->nullable();
            $table->string('jenis');
            $table->string('kelas_paralel');
            $table->integer('jumlah_pertemuan');
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
        Schema::dropIfExists('pengajaran_lamas');
    }
};