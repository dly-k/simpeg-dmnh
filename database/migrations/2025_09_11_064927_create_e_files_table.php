<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('kategori_dokumen'); // e.g., biodata, pendidikan, sk
            $table->string('nama_dokumen');     // e.g., KTP, Ijazah S1, SK CPNS
            
            // Kolom keaslian dokumen (misalnya: asli, legalisir, scan)
            $table->enum('keaslian_dokumen', ['asli', 'legalisir', 'scan'])->default('scan');

            $table->date('tanggal_dokumen')->nullable();
            $table->string('file_path'); // Path file di storage
            $table->string('file_name'); // Nama asli file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_files');
    }
};
