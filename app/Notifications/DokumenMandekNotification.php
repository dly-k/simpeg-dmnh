<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage; // Wajib dipanggil untuk desain Email
use Illuminate\Notifications\Notification;

class DokumenMandekNotification extends Notification
{
    use Queueable;

    protected $totalMandek;

    // Menangkap jumlah dokumen dari robot
    public function __construct($totalMandek)
    {
        $this->totalMandek = $totalMandek;
    }

    // 1. TAMBAHKAN 'mail' DI SINI AGAR DIKIRIM KE EMAIL JUGA
    public function via(object $notifiable): array
    {
        // HANYA MAIL. Jangan ada 'database' di sini.
        return ['mail'];
    }

    // 2. FUNGSI BARU: Merakit Desain Isi Email
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🚨 Peringatan: Dokumen Tertunda (Lebih dari 30 Hari)')
            ->greeting('Halo, ' . ($notifiable->nama ?? 'Verifikator') . '.')
            ->line("Sistem mendeteksi terdapat {$this->totalMandek} dokumen Tri Dharma yang sudah diajukan oleh Tata Usaha, namun BELUM diverifikasi selama lebih dari 30 hari.")
            ->line('Mohon kesediaannya untuk segera melakukan pengecekan dan verifikasi dokumen tersebut agar proses rekapitulasi kinerja tidak terhambat.')
            ->action('Cek Dokumen Sekarang', url('/dashboard'))
            ->line('Terima kasih atas waktu dan kerja samanya.')
            ->salutation('Hormat kami, Sistem Arsip DMNH');
    }

    // 3. Merakit Tampilan untuk Lonceng Web (Tetap sama seperti tadi)
    public function toArray(object $notifiable): array
    {
        return [
            'item_id'    => null, 
            'pesan'      => 'Peringatan Sistem: Dokumen Mandek',
            'keterangan' => "Terdapat {$this->totalMandek} dokumen Tri Dharma & Penunjang yang tertahan (Belum Diverifikasi) lebih dari 30 hari.",
            'kategori'   => 'Peringatan Sistem',
            'url'        => url('/dashboard'),
        ];
    }
}