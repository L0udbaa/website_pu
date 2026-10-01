<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\ProgresFisik;
use App\Models\ProgresKeuangan;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $progresFisik = ProgresFisik::query();
        $totalRencanaFisik = (clone $progresFisik)->sum('rencana_fisik');
        $totalRealisasiFisik = (clone $progresFisik)->sum('realisasi_fisik');
        $progresKeuangan = ProgresKeuangan::query();
        $totalRencanaKeuangan = (clone $progresKeuangan)->sum('rencana_keuangan');
        $totalRealisasiKeuangan = (clone $progresKeuangan)->sum('realisasi_keuangan');

        $kegiatan = Kegiatan::with(['progresFisik', 'progresKeuangan'])
            ->latest('id')
            ->get();

        $rataRataFisikPerKegiatan = $kegiatan
            ->map(function (Kegiatan $item) {
                return $item->progresFisik->isNotEmpty()
                    ? $item->progresFisik->sum(fn ($progres) => (float) $progres->realisasi_fisik)
                    : null;
            })
            ->filter(fn ($nilai) => $nilai !== null)
            ->map(fn ($nilai) => (float) $nilai);

        $rataRataKeuanganPerKegiatan = $kegiatan
            ->map(function (Kegiatan $item) {
                return $item->progresKeuangan->isNotEmpty()
                    ? $item->progresKeuangan->sum(fn ($progres) => (float) $progres->realisasi_persen)
                    : null;
            })
            ->filter(fn ($nilai) => $nilai !== null)
            ->map(fn ($nilai) => (float) $nilai);

        $persentaseFisik = min(100, round($rataRataFisikPerKegiatan->avg() ?? 0, 1));
        $persentaseKeuangan = min(100, round($rataRataKeuanganPerKegiatan->avg() ?? 0, 1));

        $kegiatanBelumLengkap = Kegiatan::withCount(['progresFisik', 'progresKeuangan'])
            ->where(function ($query) {
                $query->whereNull('kode_kegiatan')
                    ->orWhere('kode_kegiatan', '')
                    ->orWhereNull('nama_kegiatan')
                    ->orWhere('nama_kegiatan', '')
                    ->orWhereNull('lokasi')
                    ->orWhere('lokasi', '')
                    ->orWhereNull('tahun')
                    ->orWhere('tahun', 0)
                    ->orWhereNull('anggaran')
                    ->orWhere('anggaran', 0)
                    ->orWhereNull('user_id')
                    ->orWhereDoesntHave('progresFisik')
                    ->orWhereDoesntHave('progresKeuangan');
            })
            ->orderBy('nama_kegiatan')
            ->get();

        $kegiatanBelumLengkap->each(function (Kegiatan $item) {
            $missingForms = [];

            if (blank($item->kode_kegiatan) || blank($item->nama_kegiatan)) {
                $missingForms[] = 'Data Utama';
            }
            if (blank($item->lokasi)) {
                $missingForms[] = 'Lokasi';
            }
            if (blank($item->tahun) || (int) $item->tahun === 0) {
                $missingForms[] = 'Tahun';
            }
            if (blank($item->anggaran) || (float) $item->anggaran === 0.0) {
                $missingForms[] = 'Anggaran';
            }
            if (is_null($item->user_id)) {
                $missingForms[] = 'PJ';
            }
            if ($item->progres_fisik_count === 0) {
                $missingForms[] = 'Fisik';
            }
            if ($item->progres_keuangan_count === 0) {
                $missingForms[] = 'Keuangan';
            }

            $item->setAttribute('missing_forms', $missingForms);
        });

        return view('dashboard', [
            'jumlahKegiatan' => Kegiatan::count(),
            'jumlahProgresFisik' => ProgresFisik::count(),
            'jumlahProgresKeuangan' => ProgresKeuangan::count(),
            'kegiatanBelumLengkap' => $kegiatanBelumLengkap,
            'persentaseFisik' => $persentaseFisik,
            'persentaseKeuangan' => $persentaseKeuangan,
            'totalRencanaFisik' => $totalRencanaFisik,
            'totalRealisasiFisik' => $totalRealisasiFisik,
            'deviasiFisik' => $totalRealisasiFisik - $totalRencanaFisik,
            'totalRencanaKeuangan' => $totalRencanaKeuangan,
            'totalRealisasiKeuangan' => $totalRealisasiKeuangan,
            'deviasiKeuangan' => $totalRealisasiKeuangan - $totalRencanaKeuangan,
            'kegiatan' => $kegiatan,
        ]);
    }
}