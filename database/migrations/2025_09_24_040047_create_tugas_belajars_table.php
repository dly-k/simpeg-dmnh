<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tugas_belajars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('jenis_tugas_belajar');
            $table->string('nomor_sk');
            $table->date('tanggal_sk');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas_belajars');
    }
};