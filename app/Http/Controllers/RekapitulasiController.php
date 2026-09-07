<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\ProgresFisik;
use App\Models\ProgresKeuangan;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    public function index(Request $request)
    {
        // ==========================================
        // FILTER
        // ==========================================
        $kegiatanId = $request->input('kegiatan_id');
        $selectedKegiatan = $kegiatanId ? Kegiatan::find($kegiatanId) : null;

        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($selectedKegiatan) {
            $defaultTanggal = $this->getDefaultDateRange($kegiatanId);
            $tanggalAwal ??= $defaultTanggal['awal'];
            $tanggalAkhir ??= $defaultTanggal['akhir'];
        }

        // ==========================================
        // REKAP PROGRES FISIK
        // ==========================================

        $rencanaFisikQuery = ProgresFisik::query()
            ->latestPerKegiatan()
            ->when($kegiatanId, function ($query) use ($kegiatanId) {
                $query->where('kegiatan_id', $kegiatanId);
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal_rencana', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal_rencana', '<=', $tanggalAkhir);
            });

        $realisasiFisikQuery = ProgresFisik::query()
            ->latestPerKegiatan()
            ->when($kegiatanId, function ($query) use ($kegiatanId) {
                $query->where('kegiatan_id', $kegiatanId);
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal_realisasi', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal_realisasi', '<=', $tanggalAkhir);
            });

        $totalRencanaFisik = $rencanaFisikQuery->sum('rencana_fisik');
        $totalRealisasiFisik = $realisasiFisikQuery->sum('realisasi_fisik');
        $deviasiFisik = round($totalRealisasiFisik - $totalRencanaFisik, 2);

        // ==========================================
        // REKAP PROGRES KEUANGAN
        // ==========================================

        $rencanaKeuanganQuery = ProgresKeuangan::query()
            ->latestPerKegiatan()
            ->when($kegiatanId, function ($query) use ($kegiatanId) {
                $query->where('kegiatan_id', $kegiatanId);
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal_rencana', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal_rencana', '<=', $tanggalAkhir);
            });

        $realisasiKeuanganQuery = ProgresKeuangan::query()
            ->latestPerKegiatan()
            ->when($kegiatanId, function ($query) use ($kegiatanId) {
                $query->where('kegiatan_id', $kegiatanId);
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal_realisasi', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal_realisasi', '<=', $tanggalAkhir);
            });

        $totalRencanaKeuangan = $rencanaKeuanganQuery->sum('rencana_keuangan');
        $totalRealisasiKeuangan = $realisasiKeuanganQuery->sum('realisasi_keuangan');
        $deviasiKeuangan = round($totalRealisasiKeuangan - $totalRencanaKeuangan, 2);

        $detailFisik = ProgresFisik::query()
            ->with('kegiatan')
            ->when($kegiatanId, function ($query) use ($kegiatanId) {
                $query->where('kegiatan_id', $kegiatanId);
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal_realisasi', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal_realisasi', '<=', $tanggalAkhir);
            })
            ->orderByDesc('tanggal_realisasi')
            ->orderByDesc('id')
            ->get();

        $detailKeuangan = ProgresKeuangan::query()
            ->with('kegiatan')
            ->when($kegiatanId, function ($query) use ($kegiatanId) {
                $query->where('kegiatan_id', $kegiatanId);
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal_realisasi', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal_realisasi', '<=', $tanggalAkhir);
            })
            ->orderByDesc('tanggal_realisasi')
            ->orderByDesc('id')
            ->get();

        $kegiatanList = Kegiatan::orderBy('nama_kegiatan')->get();

        return view(
            'rekapitulasi.index',
            compact(
                'totalRencanaFisik',
                'totalRealisasiFisik',
                'deviasiFisik',
                'totalRencanaKeuangan',
                'totalRealisasiKeuangan',
                'deviasiKeuangan',
                'kegiatanList',
                'kegiatanId',
                'selectedKegiatan',
                'tanggalAwal',
                'tanggalAkhir',
                'detailFisik',
                'detailKeuangan',
            ),
        );
    }

    private function getDefaultDateRange(int $kegiatanId): array
    {
        $fisikAwal = ProgresFisik::where('kegiatan_id', $kegiatanId)->min('tanggal_realisasi');
        $keuanganAwal = ProgresKeuangan::where('kegiatan_id', $kegiatanId)->min('tanggal_realisasi');
        $fisikAkhir = ProgresFisik::where('kegiatan_id', $kegiatanId)->max('tanggal_realisasi');
        $keuanganAkhir = ProgresKeuangan::where('kegiatan_id', $kegiatanId)->max('tanggal_realisasi');

        $awal = collect([$fisikAwal, $keuanganAwal])
            ->filter()
            ->sort()
            ->first() ?? now()->toDateString();

        $akhir = collect([$fisikAkhir, $keuanganAkhir])
            ->filter()
            ->sortDesc()
            ->first() ?? now()->toDateString();

        return [
            'awal' => $awal,
            'akhir' => $akhir,
        ];
    }
}
