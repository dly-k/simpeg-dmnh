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
        Schema::create('penghargaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pegawai'); // Diubah dari foreign key menjadi input teks
            $table->string('kegiatan');     // Diubah dari foreign key menjadi input teks
            $table->string('nama_penghargaan');
            $table->string('nomor_sk');
            $table->date('tanggal_perolehan');
            $table->string('lingkup');
            $table->string('negara');
            $table->string('instansi_pemberi');
            $table->string('jenis_dokumen');
            $table->string('file_path');
            $table->string('nama_dokumen');
            $table->string('nomor_dokumen')->nullable();
            $table->string('tautan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penghargaan');
    }
};