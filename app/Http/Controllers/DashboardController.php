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
        $totalRencanaFisik = ProgresFisik::sum('rencana_fisik');
        $totalRealisasiFisik = ProgresFisik::sum('realisasi_fisik');
        $totalRencanaKeuangan = ProgresKeuangan::sum('rencana_keuangan');
        $totalRealisasiKeuangan = ProgresKeuangan::sum('realisasi_keuangan');

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

        return view('dashboard', [
            'jumlahKegiatan' => Kegiatan::count(),
            'jumlahProgresFisik' => ProgresFisik::count(),
            'jumlahProgresKeuangan' => ProgresKeuangan::count(),
            'kegiatanTanpaProgres' => Kegiatan::whereDoesntHave('progresFisik')
                ->whereDoesntHave('progresKeuangan')
                ->count(),
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