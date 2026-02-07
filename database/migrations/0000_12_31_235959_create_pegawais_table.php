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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            // Kolom yang wajib diisi
            $table->string('nip')->unique();
            $table->string('nama_lengkap');
            $table->string('status_kepegawaian');
            $table->string('jabatan_fungsional')->nullable();
            $table->string('jabatan_struktural')->nullable();
            $table->string('pangkat_golongan')->nullable();
            $table->string('status_pegawai')->default('Aktif');
            $table->enum('divisi', ['perencanaan', 'kebijakan', 'pemanenan'])->nullable();

            // Kolom lainnya yang tidak wajib diisi
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('bidang_ilmu')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('nomor_arsip')->nullable();
            $table->date('tmt_pangkat')->nullable();
            $table->date('periode_jabatan_mulai')->nullable();
            $table->date('periode_jabatan_selesai')->nullable();
            $table->string('finger_print_id')->nullable();
            $table->string('npwp')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nuptk')->nullable();
            $table->string('sinta_id')->nullable();
            $table->string('nidn')->nullable();
            $table->string('scopus_id')->nullable();
            $table->string('no_sertifikasi_dosen')->nullable();
            $table->string('orchid_id')->nullable();
            $table->date('tgl_sertifikasi_dosen')->nullable();
            $table->string('google_scholar_id')->nullable();
            $table->string('provinsi_domisili')->nullable();
            $table->text('alamat_domisili')->nullable();
            $table->string('kota_domisili')->nullable();
            $table->string('kode_pos_domisili')->nullable();
            $table->string('kecamatan_domisili')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('kelurahan_domisili')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('kecamatan_ktp')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->string('kelurahan_ktp')->nullable();
            $table->string('warga_negara')->nullable();
            $table->string('kode_pos_ktp')->nullable();
            $table->string('provinsi_ktp')->nullable();
            $table->string('kabupaten_ktp')->nullable();
            $table->text('alamat_ktp')->nullable();

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
        Schema::dropIfExists('pegawais');
    }
};