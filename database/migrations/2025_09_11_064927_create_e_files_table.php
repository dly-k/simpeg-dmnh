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
public function up(): void
{
    Schema::create('e_files', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
        $table->string('kategori_dokumen');
        $table->string('nama_dokumen');
        $table->string('keaslian_dokumen');
        $table->date('tanggal_dokumen');
        $table->string('file_path')->nullable(); // Nullable jika user pilih Link
        $table->text('link_url')->nullable();    // Kolom baru untuk Link Cloud
        $table->boolean('is_link')->default(false); // Penanda jenis input
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
