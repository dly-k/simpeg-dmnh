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
        Schema::table('e_files', function (Blueprint $table) {
            $table->string('status_verifikasi')->default('Menunggu Verifikasi'); // Menunggu, Disetujui, Perlu Revisi
            $table->text('catatan_verifikator')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('e_files', function (Blueprint $table) {
            //
        });
    }
};
