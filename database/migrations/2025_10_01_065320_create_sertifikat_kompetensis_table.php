<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat_kompetensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('kegiatan');
            $table->string('judul_kegiatan');
            $table->string('no_reg_pendidik')->nullable();
            $table->string('no_sk_sertifikasi');
            $table->year('tahun_sertifikasi');
            $table->date('tmt_sertifikasi');
            $table->date('tst_sertifikasi')->nullable();
            $table->string('bidang_studi');
            $table->string('lembaga_sertifikasi');
            $table->string('dokumen')->nullable();
            $table->enum('verifikasi', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])->default('Belum Diverifikasi');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat_kompetensis');
    }
};
