<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengujian_lamas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('kegiatan');
            $table->string('strata');
            $table->string('tahun_semester');
            $table->string('nim');
            $table->string('nama_mahasiswa');
            $table->string('departemen');
            $table->string('file_path')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pengujian_lamas');
    }
};