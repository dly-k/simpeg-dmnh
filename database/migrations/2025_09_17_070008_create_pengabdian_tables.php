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
        // Tabel Utama Pengabdian
        Schema::create('pengabdians', function (Blueprint $table) {
            $table->id();
            $table->string('kegiatan');
            $table->string('nama_kegiatan');
            $table->string('afiliasi_non_pt')->nullable();
            $table->string('lokasi')->nullable(); // Termasuk kolom lokasi
            $table->string('jenis_pengabdian');
            $table->year('tahun_usulan')->nullable();
            $table->year('tahun_kegiatan')->nullable();
            $table->year('tahun_pelaksanaan')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->string('lama_kegiatan')->nullable();
            $table->text('in_kind')->nullable();
            $table->string('no_sk_penugasan')->nullable();
            $table->date('tgl_sk_penugasan')->nullable();
            $table->string('litabmas')->nullable();
            $table->decimal('dana_dikti', 15, 2)->nullable();
            $table->decimal('dana_pt', 15, 2)->nullable();
            $table->decimal('dana_institusi_lain', 15, 2)->nullable();
            $table->enum('status', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])->default('Belum Diverifikasi');
            $table->timestamps();
        });

        // Tabel Anggota
        Schema::create('pengabdian_anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengabdian_id')->constrained()->onDelete('cascade');
            $table->enum('jenis', ['dosen', 'mahasiswa', 'kolaborator']);
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->string('nama')->nullable(); 
            $table->string('strata')->nullable();
            $table->string('jabatan');
            $table->string('status_aktif');
            $table->timestamps();
        });

        // Tabel Dokumen
        Schema::create('pengabdian_dokumens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengabdian_id')->constrained()->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('file_path');
            $table->string('nama_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengabdian_dokumens');
        Schema::dropIfExists('pengabdian_anggotas');
        Schema::dropIfExists('pengabdians');
    }
};