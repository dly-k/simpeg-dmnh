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
        Schema::create('pelatihans', function (Blueprint $table) {
            $table->id();
            
            // Informasi Dasar Pelatihan
            $table->string('nama_kegiatan');
            $table->string('posisi');
            $table->string('posisi_lainnya')->nullable();
            $table->string('penyelenggara');
            $table->string('kota')->nullable();
            $table->string('lokasi')->nullable();
            
            // Waktu Pelaksanaan
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->integer('jumlah_jam')->nullable();
            $table->integer('jumlah_hari')->nullable();
            
            // Detail Tambahan
            $table->string('jenis_diklat')->nullable();
            $table->string('lingkup')->nullable();
            $table->boolean('struktural')->default(false);
            $table->boolean('sertifikasi')->default(false);
            
            // Informasi Dokumen Pendukung
            $table->string('file_path'); // Path ke file yang diunggah
            $table->string('jenis_dokumen')->nullable();
            $table->string('nama_dokumen');
            $table->string('nomor_dokumen')->nullable();
            $table->string('tautan_dokumen')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihans');
    }
};