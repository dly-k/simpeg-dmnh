<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kenaikan_gaji_berkalas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('golongan');
            $table->string('nomor_sk');
            $table->date('tanggal_sk');
            $table->date('tmt_gaji');
            $table->integer('gaji_pokok');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kenaikan_gaji_berkalas');
    }
};