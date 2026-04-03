<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SubmisiBaruNotification;
use App\Notifications\DokumenMandekNotification;

class PengingatDokumenMandek extends Command
{
    protected $signature = 'pengingat:dokumen-mandek';
    protected $description = 'Kirim lonceng (a.n Nama Dosen akurat) & 1 email rekap';

    public function handle()
    {
        // TESTING 1 JAM
        $batasWaktu = Carbon::now()->subHours(1); 
        $totalMandek = 0;

        $modelsToCheck = [
            \App\Models\Penelitian::class => ['kolom' => 'status', 'kategori' => 'Penelitian', 'path' => 'penelitian'],
            \App\Models\Pengabdian::class => ['kolom' => 'status', 'kategori' => 'Pengabdian', 'path' => 'pengabdian'],
            \App\Models\PengelolaJurnal::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pengelola Jurnal', 'path' => 'pengelola-jurnal'],
            \App\Models\Pembicara::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pembicara', 'path' => 'pembicara'],
            \App\Models\PengajaranLama::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pengajaran', 'path' => 'pendidikan'],
            \App\Models\PengajaranLuar::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pengajaran Luar', 'path' => 'pendidikan'],
            \App\Models\PengujianLama::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pengujian', 'path' => 'pendidikan'],
            \App\Models\PembimbingLama::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pembimbingan', 'path' => 'pendidikan'],
            \App\Models\PengujiLuar::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pengujian Luar', 'path' => 'pendidikan'],
            \App\Models\PembimbingLuar::class => ['kolom' => 'status_verifikasi', 'kategori' => 'Pembimbingan Luar', 'path' => 'pendidikan'],
            \App\Models\SertifikatKompetensi::class => ['kolom' => 'verifikasi', 'kategori' => 'Sertifikat Kompetensi', 'path' => 'sertifikat-kompetensi'],
            \App\Models\Praktisi::class => ['kolom' => 'status', 'kategori' => 'Praktisi Industri', 'path' => 'praktisi-dunia-industri'],
            \App\Models\Penunjang::class => ['kolom' => 'status', 'kategori' => 'Penunjang', 'path' => 'penunjang'],
        ];

        $verifikators = User::where('role', 'admin_verifikator')->get();

        foreach ($modelsToCheck as $model => $config) {
            $dokumens = $model::where($config['kolom'], 'LIKE', '%belum%')
                              ->where('created_at', '<', $batasWaktu)
                              ->get();
            
            foreach ($dokumens as $dok) {
                $totalMandek++;
                
                // ========================================================
                // LOGIKA PENCARIAN NAMA DOSEN SUPER CERDAS
                // ========================================================
                $namaDosen = 'Dosen';
                
                // 1. Cek apakah ini model Penelitian (punya relasi 'penulis')
                if (method_exists($dok, 'penulis') && $dok->penulis->count() > 0) {
                    $penulis = $dok->penulis->first();
                    $namaDosen = $penulis->pegawai->nama ?? $penulis->nama_penulis ?? 'Dosen';
                }
                // 2. Cek apakah ini model Pengabdian (punya relasi 'anggota' atau 'pengabdianAnggota')
                elseif (method_exists($dok, 'anggota') && $dok->anggota->count() > 0) {
                    $anggota = $dok->anggota->first();
                    $namaDosen = $anggota->pegawai->nama ?? $anggota->nama_anggota ?? 'Dosen';
                }
                // 3. Cek apakah ini punya kolom pegawai_id langsung
                elseif (isset($dok->pegawai)) {
                    $namaDosen = $dok->pegawai->nama ?? 'Dosen';
                }
                // 4. Jika datanya terhubung ke users (contoh: sertifikat)
                elseif (isset($dok->user) && isset($dok->user->pegawai)) {
                    $namaDosen = $dok->user->pegawai->nama ?? 'Dosen';
                }

                $urlLink = url('/' . $config['path']); 

                // Kirim Lonceng Web (SATUAN)
                Notification::send($verifikators, new SubmisiBaruNotification(
                    $dok, 
                    $config['kategori'], 
                    $namaDosen, // Sekarang nama yang masuk ke lonceng sudah 100% akurat dari database!
                    $urlLink, 
                    'pending_30_hari'
                ));
            }
        }

        // Kirim 1 EMAIL REKAP SAJA di akhir (Pastikan Anda sudah mengubah file SubmisiBaruNotification.php seperti chat sebelumnya)
        if ($totalMandek > 0) {
            Notification::send($verifikators, new DokumenMandekNotification($totalMandek));
            $this->info("Berhasil! Lonceng a.n {$namaDosen} dll berhasil masuk, dan 1 email rekap terkirim.");
        } else {
            $this->info("Tidak ada dokumen mandek.");
        }
    }
}