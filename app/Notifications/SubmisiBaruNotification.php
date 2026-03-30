<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmisiBaruNotification extends Notification
{
    use Queueable;

    protected $item;
    protected $kategori;
    protected $namaPegawai;
    protected $urlLink;
    protected $jenis_notifikasi;
    protected $pesan_tambahan;

    // 1. Menerima 4 data utama (Item, Kategori, Nama Pegawai, Link)
    public function __construct($item, $kategori, $namaPegawai, $urlLink, $jenis_notifikasi = 'submisi_baru', $pesan_tambahan = '')
    {
        $this->item = $item;
        $this->kategori = $kategori;
        $this->namaPegawai = $namaPegawai;
        $this->urlLink = $urlLink;
        $this->jenis_notifikasi = $jenis_notifikasi;
        $this->pesan_tambahan = $pesan_tambahan;
    }

    // 2. Logika Jalur Pengiriman (Anti-Spam)
    public function via(object $notifiable): array
    {
        if ($this->jenis_notifikasi === 'submisi_baru') {
            return ['database']; // Input harian hanya dikirim ke Lonceng Web
        }
        return ['mail', 'database']; // Peringatan penting dikirim ke Email + Lonceng Web
    }

    // 3. Merakit Isi Email
    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->greeting('Halo, ' . ($notifiable->name ?? 'Pimpinan / Verifikator') . '.');

        $nama_dokumen = $this->item->judul_penelitian 
            ?? $this->item->judul 
            ?? $this->item->nama_kegiatan 
            ?? $this->item->nama_dokumen 
            ?? 'Data Baru';

        if ($this->jenis_notifikasi === 'pending_30_hari') {
            $mail->subject('Peringatan: Dokumen Tertunda 30 Hari a.n ' . $this->namaPegawai)
                ->line('Terdapat dokumen yang sudah diajukan lebih dari 30 hari namun BELUM diverifikasi.')
                ->line('• Nama Pegawai : ' . $this->namaPegawai)
                ->line('• Kategori : ' . $this->kategori)
                ->line('• Judul Dokumen : ' . $nama_dokumen);
        } elseif ($this->jenis_notifikasi === 'kenaikan_pangkat') {
            $mail->subject('Pengingat: Usulan Kenaikan Pangkat - ' . $this->namaPegawai)
                ->line('Sistem mendeteksi jadwal usulan kenaikan pangkat.')
                ->line('• Nama Pegawai : ' . $this->namaPegawai)
                ->line('• Keterangan : ' . $this->pesan_tambahan);
        } elseif ($this->jenis_notifikasi === 'pengingat_berkala') {
            $mail->subject('Pengingat Kedaluwarsa: ' . $nama_dokumen)
                ->line('Pemberitahuan otomatis untuk dokumen dengan masa berlaku yang akan habis.')
                ->line('• Nama Pegawai : ' . $this->namaPegawai)
                ->line('• Nama Dokumen : ' . $nama_dokumen)
                ->line('• Sisa Waktu : ' . $this->pesan_tambahan);
        } else {
            $mail->subject('Notifikasi Baru: ' . $this->kategori)
                ->line('Terdapat notifikasi baru dari sistem.')
                ->line('• Nama Pegawai : ' . $this->namaPegawai)
                ->line('• Kategori : ' . $this->kategori)
                ->line('• Data : ' . $nama_dokumen);
        }

        return $mail->action('Lihat Detail & Verifikasi', $this->urlLink)
            ->line('Terima kasih atas kerja samanya.')
            ->salutation('Hormat kami, Sistem Arsip DMNH');
    }

    // 4. Merakit Isi Lonceng Web
    public function toArray(object $notifiable): array
    {
        $nama_dokumen = $this->item->judul_penelitian 
            ?? $this->item->judul 
            ?? $this->item->nama_kegiatan 
            ?? $this->item->nama_dokumen 
            ?? 'Data Baru';

        $pesan_singkat = '';

        if ($this->jenis_notifikasi === 'submisi_baru') {
            $pesan_singkat = 'Verifikasi ' . $this->kategori . ' a.n ' . $this->namaPegawai;
        } elseif ($this->jenis_notifikasi === 'pending_30_hari') {
            $pesan_singkat = 'Tertunda 30 Hari (' . $this->kategori . ') a.n ' . $this->namaPegawai;
        } elseif ($this->jenis_notifikasi === 'kenaikan_pangkat') {
            $pesan_singkat = 'Kenaikan Pangkat: ' . $this->namaPegawai . ' (' . $this->pesan_tambahan . ')';
        } elseif ($this->jenis_notifikasi === 'pengingat_berkala') {
            $pesan_singkat = 'Akan Habis (' . $this->pesan_tambahan . '): Dokumen a.n ' . $this->namaPegawai;
        } else {
            $pesan_singkat = 'Notifikasi ' . $this->kategori . ' a.n ' . $this->namaPegawai;
        }

        // Kunci array (pesan, keterangan, kategori, url) wajib sesuai dengan di file Header Anda
        return [
            'pesan' => $pesan_singkat,
            'keterangan' => $nama_dokumen,
            'kategori' => $this->kategori,
            'url' => $this->urlLink,
        ];
    }
}