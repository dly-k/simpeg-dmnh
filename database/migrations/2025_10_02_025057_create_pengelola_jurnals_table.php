<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pengelola_jurnals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
        $table->text('kegiatan');
        $table->string('media_publikasi');
        $table->string('peran');
        $table->string('no_sk');
        $table->date('tanggal_mulai');
        $table->date('tanggal_selesai');
        $table->string('status');
        
        // [PERBAIKAN] Hapus .change() dari akhir baris ini
        $table->enum('status_verifikasi', ['Belum Diverifikasi', 'Sudah Diverifikasi', 'Ditolak'])
              ->default('Belum Diverifikasi');
              
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengelola_jurnals');
    }
};
