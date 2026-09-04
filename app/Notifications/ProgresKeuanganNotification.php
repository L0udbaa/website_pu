<?php

namespace App\Notifications;

use App\Models\ProgresKeuangan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProgresKeuanganNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ProgresKeuangan $progres
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $deviasi = (float) ($this->progres->deviasi_keuangan ?? 0);

        $realisasiPersen = (float) (
            $this->progres->realisasi_persen ?? 0
        );

        $namaKegiatan = $this->progres->kegiatan->nama_kegiatan
            ?? 'Kegiatan';

        /*
        |--------------------------------------------------------------------------
        | Jika deviasi negatif
        |--------------------------------------------------------------------------
        */

        if ($deviasi < 0) {

            $judul = 'Peringatan Progres Keuangan';

            $pesan = 'Progres keuangan "' .
                $namaKegiatan .
                '" masih di bawah rencana sebesar Rp ' .
                number_format(
                    abs($deviasi),
                    2,
                    ',',
                    '.'
                ) .
                '.';

            $jenis = 'warning';

            $icon = 'bi-exclamation-triangle';

        } else {

            /*
            |--------------------------------------------------------------------------
            | Jika progres sesuai / di atas rencana
            |--------------------------------------------------------------------------
            */

            $judul = 'Progres Keuangan Diperbarui';

            $pesan = 'Progres keuangan "' .
                $namaKegiatan .
                '" telah diperbarui dengan realisasi ' .
                number_format(
                    $realisasiPersen,
                    2,
                    ',',
                    '.'
                ) .
                '%.';

            $jenis = 'success';

            $icon = 'bi-cash-stack';
        }

        return [
            'jenis' => $jenis,
            'icon' => $icon,
            'judul' => $judul,
            'pesan' => $pesan,

            'kegiatan_id' => $this->progres->kegiatan_id,

            'progres_id' => $this->progres->id,

            'url' => route('progres-keuangan.index'),
        ];
    }
}