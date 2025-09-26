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
        Schema::create('praktisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('instansi');
            $table->string('divisi')->nullable(); // Menambahkan kolom divisi
            $table->string('jenis_pekerjaan');
            $table->string('jabatan');
            $table->string('bidang_usaha');
            $table->text('deskripsi_kerja')->nullable();
            $table->date('tmt'); // Tanggal Mulai Tugas
            $table->date('tst'); // Tanggal Selesai Tugas
            $table->string('area_pekerjaan');
            $table->string('kategori_pekerjaan');
            $table->string('surat_ipb')->nullable();
            $table->string('surat_instansi')->nullable();
            $table->string('cv')->nullable();
            $table->string('profil_perusahaan')->nullable();
            $table->enum('status', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])->default('Belum Diverifikasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praktisis');
    }
};