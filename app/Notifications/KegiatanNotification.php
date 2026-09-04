<?php

namespace App\Notifications;

use App\Models\Kegiatan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class KegiatanNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Kegiatan $kegiatan,
        public string $jenis = 'kegiatan'
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'jenis' => $this->jenis,
            'judul' => 'Kegiatan baru ditambahkan',
            'pesan' => $this->kegiatan->nama_kegiatan,
            'kegiatan_id' => $this->kegiatan->id,
            'kode_kegiatan' => $this->kegiatan->kode_kegiatan,
            'url' => route('kegiatan.index'),
        ];
    }
}