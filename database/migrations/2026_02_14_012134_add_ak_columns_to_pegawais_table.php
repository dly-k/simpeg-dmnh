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
    Schema::table('pegawais', function (Blueprint $table) {
        $table->decimal('ak_lama', 10, 3)->default(0)->after('jabatan_tujuan');
        $table->decimal('ak_baru', 10, 3)->default(0)->after('ak_lama');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            //
        });
    }
};
