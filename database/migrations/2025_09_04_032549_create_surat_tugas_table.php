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
    Schema::create('surat_tugas', function (Blueprint $table) {
        $table->id();
        $table->string('nama_dosen');
        $table->string('peran');
        $table->string('diminta_sebagai')->nullable();
        $table->string('mitra_instansi')->nullable();
        $table->string('no_surat_instansi')->nullable();
        $table->date('tgl_surat_instansi')->nullable();
        $table->string('no_surat_kadep')->nullable();
        $table->date('tgl_surat_kadep')->nullable();
        $table->date('tgl_kegiatan')->nullable();
        $table->string('lokasi')->nullable();
        $table->string('dokumen')->nullable(); // simpan nama file dokumen
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_tugas');
    }
};
