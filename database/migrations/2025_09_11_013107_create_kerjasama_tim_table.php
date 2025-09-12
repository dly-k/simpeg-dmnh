<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kerjasama_tim', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kerjasama_id')->constrained('kerjasama')->onDelete('cascade');
            $table->string('nama');
            $table->string('departemen');
            $table->enum('jabatan', ['ketua', 'anggota']); // bisa pilih ketua atau anggota
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kerjasama_tim');
    }
};