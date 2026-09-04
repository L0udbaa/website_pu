<?php

namespace App\Notifications;

use App\Models\ProgresFisik;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProgresFisikNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ProgresFisik $progres
    ) {
    }

    /**
     * Tentukan channel notifikasi.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data yang disimpan ke database.
     */
    public function toArray(object $notifiable): array
    {
        $deviasi = (float) ($this->progres->deviasi_fisik ?? 0);

        $namaKegiatan = $this->progres->kegiatan->nama_kegiatan
            ?? 'Kegiatan';

        /*
         * Jika deviasi negatif,
         * berarti realisasi masih di bawah rencana.
         */
        if ($deviasi < 0) {

            $judul = 'Peringatan Progres Fisik';

            $pesan = 'Progres "' .
                $namaKegiatan .
                '" tertinggal ' .
                number_format(
                    abs($deviasi),
                    2,
                    ',',
                    '.'
                ) .
                '%.';

            $jenis = 'warning';

            $icon = 'bi-exclamation-triangle';

        } else {

            $judul = 'Progres Fisik Diperbarui';

            $pesan = 'Realisasi progres "' .
                $namaKegiatan .
                '" sebesar ' .
                number_format(
                    (float) $this->progres->realisasi_fisik,
                    2,
                    ',',
                    '.'
                ) .
                '%.';

            $jenis = 'success';

            $icon = 'bi-graph-up';
        }

        return [

            'jenis' => $jenis,

            'icon' => $icon,

            'judul' => $judul,

            'pesan' => $pesan,

            'kegiatan_id' => $this->progres->kegiatan_id,

            'progres_id' => $this->progres->id,

            'url' => route('progres-fisik.index'),

        ];
    }
}