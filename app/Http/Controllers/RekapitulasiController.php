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
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // ==========================================
        // REKAP PROGRES FISIK
        // ==========================================

        // Query Rencana Fisik
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

        // Query Realisasi Fisik
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

        // Total Rencana Fisik
        $totalRencanaFisik = $rencanaFisikQuery->sum('rencana_fisik');

        // Total Realisasi Fisik
        $totalRealisasiFisik = $realisasiFisikQuery->sum('realisasi_fisik');

        // Deviasi Fisik
        $deviasiFisik = round($totalRealisasiFisik - $totalRencanaFisik, 2);

        // ==========================================
        // REKAP PROGRES KEUANGAN
        // ==========================================

        // Query Rencana Keuangan
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

        // Query Realisasi Keuangan
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

        // Total Rencana Keuangan
        $totalRencanaKeuangan = $rencanaKeuanganQuery->sum('rencana_keuangan');

        // Total Realisasi Keuangan
        $totalRealisasiKeuangan = $realisasiKeuanganQuery->sum('realisasi_keuangan');

        // Deviasi Keuangan
        $deviasiKeuangan = round($totalRealisasiKeuangan - $totalRencanaKeuangan, 2);

        // ==========================================
        // DAFTAR KEGIATAN
        // ==========================================

        $kegiatanList = Kegiatan::orderBy('nama_kegiatan')->get();

        // ==========================================
        // KIRIM DATA KE VIEW
        // ==========================================

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
                'tanggalAwal',
                'tanggalAkhir',
            ),
        );
    }
}
