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
        // Tabel utama untuk data penelitian
        Schema::create('penelitian', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('jenis_karya');
            $table->string('volume')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->boolean('is_publik')->default(false);
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->string('dokumen_path')->nullable();
            $table->enum('status', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])->default('Belum Diverifikasi');
            $table->timestamps();
        });

        // Tabel untuk menyimpan data penulis yang berelasi dengan penelitian
        Schema::create('penulis_penelitian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penelitian_id')->constrained('penelitian')->onDelete('cascade');
            $table->foreignId('pegawai_id')->nullable()->constrained('pegawais')->onDelete('set null');
            $table->string('nama_penulis')->nullable();
            $table->string('afiliasi')->nullable();
            $table->enum('tipe_penulis', ['IPB', 'Luar IPB', 'Mahasiswa']);
            $table->string('sk_penugasan_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus tabel dalam urutan terbalik untuk menjaga foreign key constraints
        Schema::dropIfExists('penulis_penelitian');
        Schema::dropIfExists('penelitian');
    }
};