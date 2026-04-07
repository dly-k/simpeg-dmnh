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
    protected $description = 'Kirim lonceng (a.n Nama Lengkap Akurat) & 1 email rekapitulasi';

    public function handle()
    {
        // WAKTU TESTING 1 JAM (Jika pengujian skripsi selesai, ubah subHours(1) menjadi subDays(30))
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
                $namaDosen = ''; 

                try {
                    // 1. CEK PENGABDIAN
                    if ($config['kategori'] === 'Pengabdian') {
                        // Cari anggota yang berstatus 'dosen' (Mengikuti Controller)
                        $anggotaDosen = \App\Models\PengabdianAnggota::with('pegawai')
                                            ->where('pengabdian_id', $dok->id)
                                            ->where('jenis', 'dosen')
                                            ->orderBy('id', 'asc')
                                            ->first();
                                            
                        if ($anggotaDosen) {
                            if ($anggotaDosen->pegawai) {
                                // MENGGUNAKAN nama_lengkap!
                                $namaDosen = $anggotaDosen->pegawai->nama_lengkap ?? $anggotaDosen->pegawai->nama;
                            } else {
                                $namaDosen = $anggotaDosen->nama ?? '';
                            }
                        }
                    }
                    // 2. CEK PENELITIAN
                    elseif ($config['kategori'] === 'Penelitian') {
                        $penulisDosen = \App\Models\PenulisPenelitian::with('pegawai')
                                            ->where('penelitian_id', $dok->id)
                                            ->orderBy('id', 'asc')
                                            ->first();
                        if ($penulisDosen) {
                            if ($penulisDosen->pegawai) {
                                $namaDosen = $penulisDosen->pegawai->nama_lengkap ?? $penulisDosen->pegawai->nama;
                            } else {
                                $namaDosen = $penulisDosen->nama_penulis ?? $penulisDosen->nama ?? '';
                            }
                        }
                    }
                    // 3. CEK PENUNJANG
                    elseif ($config['kategori'] === 'Penunjang') {
                        $anggotaPenunjang = \App\Models\PenunjangAnggota::with('pegawai')->where('penunjang_id', $dok->id)->orderBy('id', 'asc')->first();
                        if ($anggotaPenunjang && $anggotaPenunjang->pegawai) {
                            $namaDosen = $anggotaPenunjang->pegawai->nama_lengkap ?? $anggotaPenunjang->pegawai->nama;
                        }
                    }
                    // 4. CEK PENDIDIKAN (ARRAY BANYAK DOSEN)
                    elseif (isset($dok->pegawai) && $dok->pegawai instanceof \Illuminate\Support\Collection) {
                        $peg = $dok->pegawai->first(); 
                        if ($peg) $namaDosen = $peg->nama_lengkap ?? $peg->nama;
                    }
                    // 5. CEK TABEL STANDAR (Punya pegawai_id)
                    elseif (!empty($dok->pegawai_id)) {
                        $rawId = $dok->pegawai_id;
                        if (is_string($rawId) && str_starts_with(trim($rawId), '[')) {
                            $arr = json_decode($rawId, true);
                            if (is_array($arr) && count($arr) > 0) {
                                $peg = \App\Models\Pegawai::find($arr[0]);
                                if ($peg) $namaDosen = $peg->nama_lengkap ?? $peg->nama;
                            }
                        } else {
                            $peg = \App\Models\Pegawai::find($rawId);
                            if ($peg) $namaDosen = $peg->nama_lengkap ?? $peg->nama;
                        }
                    }
                    // 6. CEK TABEL YANG PAKAI user_id
                    elseif (!empty($dok->user_id)) {
                        $user = \App\Models\User::with('pegawai')->find($dok->user_id);
                        if ($user && $user->pegawai) {
                            $namaDosen = $user->pegawai->nama_lengkap ?? $user->pegawai->nama;
                        }
                    }
                    
                } catch (\Exception $e) {
                    Log::error("Error mendeteksi nama: " . $e->getMessage());
                }

                // Hapus spasi berlebih
                $namaDosen = trim($namaDosen);

                // Jaring pengaman super darurat 
                if (empty($namaDosen)) {
                    $namaDosen = 'Sistem'; 
                }

                $urlLink = url('/' . $config['path'] . '?search=' . urlencode($namaDosen)); 

                // Kirim Lonceng!
                Notification::send($verifikators, new SubmisiBaruNotification(
                    $dok, 
                    $config['kategori'], 
                    $namaDosen, 
                    $urlLink, 
                    'pending_30_hari'
                ));
            }
        }

        // Kirim 1 Email Rekap
        if ($totalMandek > 0) {
            Notification::send($verifikators, new DokumenMandekNotification($totalMandek));
            $this->info("Bagus! {$totalMandek} data masuk, dan 1 email rekap masuk.");
        } else {
            $this->info("Tidak ada dokumen mandek.");
        }
    }
}