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
        $latestProgresFisik = ProgresFisik::latestPerKegiatan();
        $totalRencanaFisik = (clone $latestProgresFisik)->sum('rencana_fisik');
        $totalRealisasiFisik = (clone $latestProgresFisik)->sum('realisasi_fisik');
        $latestProgresKeuangan = ProgresKeuangan::latestPerKegiatan();
        $totalRencanaKeuangan = (clone $latestProgresKeuangan)->sum('rencana_keuangan');
        $totalRealisasiKeuangan = (clone $latestProgresKeuangan)->sum('realisasi_keuangan');

        $persentaseFisik = $totalRencanaFisik > 0
            ? min(100, round(($totalRealisasiFisik / $totalRencanaFisik) * 100, 1))
            : 0;
        $persentaseKeuangan = $totalRencanaKeuangan > 0
            ? min(100, round(($totalRealisasiKeuangan / $totalRencanaKeuangan) * 100, 1))
            : 0;

        $kegiatan = Kegiatan::with(['progresFisik', 'progresKeuangan'])
            ->latest('id')
            ->take(6)
            ->get();

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