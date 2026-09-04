<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\ProgresKeuangan;
use App\Models\User;
use App\Notifications\ProgresKeuanganNotification;
use Illuminate\Http\Request;

class ProgresKeuanganController extends Controller
{
    public function index(Request $request, ?Kegiatan $kegiatan = null)
    {
        $progres = ProgresKeuangan::with('kegiatan')
            ->when($kegiatan, fn ($query, $kegiatan) => $query->where('kegiatan_id', $kegiatan->id))
            ->when($request->search, function ($query, $search) {
                $query->whereHas('kegiatan', function ($q) use ($search) {
                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                        ->orWhere('kode_kegiatan', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('tanggal_realisasi')
            ->paginate(10)
            ->withQueryString();

        return view('progres-keuangan.index', compact('progres', 'kegiatan'));
    }

    public function create(?Kegiatan $kegiatan = null)
    {
        $kegiatanList = Kegiatan::orderBy('nama_kegiatan')->get();

        return view('progres-keuangan.create', compact('kegiatanList', 'kegiatan'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $validated = $this->hitungOtomatis($validated);

        /*
        |--------------------------------------------------------------------------
        | Simpan progres keuangan
        |--------------------------------------------------------------------------
        */

        $progresKeuangan = ProgresKeuangan::create($validated);

        /*
        |--------------------------------------------------------------------------
        | Ambil data kegiatan untuk notifikasi
        |--------------------------------------------------------------------------
        */

        $progresKeuangan->load('kegiatan');

        /*
        |--------------------------------------------------------------------------
        | Kirim notifikasi ke semua user
        |--------------------------------------------------------------------------
        */

        User::all()->each(function ($user) use ($progresKeuangan) {
            $user->notify(
                new ProgresKeuanganNotification($progresKeuangan)
            );
        });

        return redirect()
            ->route(
                'progres-keuangan.index',
                $request->input('kegiatan_id')
                    ? Kegiatan::find($request->input('kegiatan_id'))
                    : null
            )
            ->with(
                'success',
                'Progres keuangan berhasil ditambahkan.'
            );
    }

    public function edit(
        ProgresKeuangan $progresKeuangan,
        ?Kegiatan $kegiatan = null
    )
    {
        $kegiatanList = Kegiatan::orderBy('nama_kegiatan')->get();

        return view(
            'progres-keuangan.edit',
            compact(
                'progresKeuangan',
                'kegiatanList',
                'kegiatan'
            )
        );
    }

    public function update(
        Request $request,
        ProgresKeuangan $progresKeuangan
    )
    {
        $validated = $this->validateData($request);

        $validated = $this->hitungOtomatis($validated);

        /*
        |--------------------------------------------------------------------------
        | Update progres keuangan
        |--------------------------------------------------------------------------
        */

        $progresKeuangan->update($validated);

        /*
        |--------------------------------------------------------------------------
        | Ambil kembali relasi kegiatan
        |--------------------------------------------------------------------------
        */

        $progresKeuangan->load('kegiatan');

        /*
        |--------------------------------------------------------------------------
        | Kirim notifikasi
        |--------------------------------------------------------------------------
        */

        User::all()->each(function ($user) use ($progresKeuangan) {
            $user->notify(
                new ProgresKeuanganNotification($progresKeuangan)
            );
        });

        return redirect()
            ->route(
                'progres-keuangan.index',
                $progresKeuangan->kegiatan
            )
            ->with(
                'success',
                'Progres keuangan berhasil diperbarui.'
            );
    }

    public function destroy(ProgresKeuangan $progresKeuangan)
    {
        $kegiatan = $progresKeuangan->kegiatan;

        $progresKeuangan->delete();

        return redirect()
            ->route(
                'progres-keuangan.index',
                $kegiatan
            )
            ->with(
                'success',
                'Progres keuangan berhasil dihapus.'
            );
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'kegiatan_id'         => ['required', 'exists:kegiatan,id'],
            'rencana_persen'      => ['required', 'numeric', 'min:0', 'max:100'],
            'tanggal_rencana'     => ['required', 'date'],
            'realisasi_persen'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'tanggal_realisasi'   => ['nullable', 'date'],
            'realisasi_keuangan'  => ['nullable', 'numeric', 'min:0'],
            'proses_keuangan'     => ['nullable', 'numeric', 'min:0'],

            // rencana_keuangan dan deviasi_keuangan
            // dihitung otomatis oleh server.
        ]);

        $data['nilai_kontrak'] = Kegiatan::findOrFail($data['kegiatan_id'])->anggaran;

        return $data;
    }

    /**
     * Rumus:
     *
     * Rencana (Rp)
     * = Nilai Kontrak × Rencana (%) ÷ 100
     *
     * Deviasi (Rp)
     * = Realisasi (Rp) − Rencana (Rp)
     */
    private function hitungOtomatis(array $data): array
    {
        $nilaiKontrak = (float) (
            $data['nilai_kontrak'] ?? 0
        );

        $rencanaPersen = (float) (
            $data['rencana_persen'] ?? 0
        );

        $realisasiKeuangan = (float) (
            $data['realisasi_keuangan'] ?? 0
        );

        $realisasiPersen = (float) (
            $data['realisasi_persen'] ?? 0
        );

        /*
        |--------------------------------------------------------------------------
        | Hitung rencana keuangan
        |--------------------------------------------------------------------------
        */

        $rencanaKeuangan = round(
            $nilaiKontrak * $rencanaPersen / 100,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Hitung deviasi
        |--------------------------------------------------------------------------
        */

        $deviasiKeuangan = round(
            $realisasiKeuangan - $rencanaKeuangan,
            2
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan hasil perhitungan
        |--------------------------------------------------------------------------
        */

        $data['rencana_keuangan'] = $rencanaKeuangan;

        $data['deviasi_keuangan'] = $deviasiKeuangan;

        $data['progres_keuangan'] = $realisasiPersen;

        return $data;
    }
}