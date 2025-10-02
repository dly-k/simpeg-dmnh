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
        Schema::create('dokumen_pengelola_jurnals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengelola_jurnal_id')->constrained('pengelola_jurnals')->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('nama_dokumen')->nullable();
            $table->string('nomor_dokumen')->nullable();
            $table->string('tautan_dokumen')->nullable();
            $table->string('path_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pengelola_jurnals');
    }
};
