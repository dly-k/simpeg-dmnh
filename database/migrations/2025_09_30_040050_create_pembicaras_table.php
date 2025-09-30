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
        Schema::create('pembicaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('kegiatan');
            $table->string('kegiatan_lainnya')->nullable();
            $table->string('kategori_capaian')->nullable();
            $table->string('kategori_capaian_lainnya')->nullable();
            $table->string('litabmas')->nullable();
            $table->string('kategori_pembicara');
            $table->string('judul_makalah');
            $table->string('nama_pertemuan');
            $table->string('tingkat_pertemuan')->nullable();
            $table->string('penyelenggara');
            $table->date('tanggal_pelaksana');
            $table->string('bahasa')->nullable();
            $table->string('no_sk')->nullable();
            $table->date('tanggal_sk')->nullable();
            $table->string('status_verifikasi')->default('belum_diverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembicaras');
    }
};