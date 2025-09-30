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
        Schema::create('dokumen_pembicaras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembicara_id')->constrained('pembicaras')->onDelete('cascade');
            $table->string('jenis_dokumen');
            $table->string('nama_dokumen')->nullable();
            $table->string('nomor')->nullable();
            $table->string('tautan')->nullable();
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pembicaras');
    }
};