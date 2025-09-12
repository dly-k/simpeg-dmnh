<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerjasama', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('mitra');
            $table->string('no_surat_mitra')->nullable();
            $table->string('no_surat_departemen')->nullable();
            $table->date('tgl_dokumen')->nullable();
            $table->string('departemen_penanggung_jawab'); // sementara string
            $table->date('tmt')->nullable(); // tanggal mulai
            $table->date('tst')->nullable(); // tanggal selesai
            $table->string('lokasi')->nullable();
            $table->decimal('besaran_dana', 15, 2)->nullable(); // misalnya 1.000.000,00
            $table->string('jenis_kerjasama')->nullable();
            $table->string('jenis_usulan')->nullable();
            $table->string('file_dokumen')->nullable(); // path file upload
            $table->string('file_laporan')->nullable(); // path file upload
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerjasama');
    }
};