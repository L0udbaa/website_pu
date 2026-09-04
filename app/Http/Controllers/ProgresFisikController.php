<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\ProgresFisik;
use App\Models\User;
use App\Notifications\ProgresFisikNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgresFisikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $progresFisik = ProgresFisik::with('kegiatan')
            ->latest('id')
            ->paginate(10);

        return view('progres_fisik.index', compact('progresFisik'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $kegiatanList = Kegiatan::orderBy('nama_kegiatan')->get();

        return view('progres_fisik.create', compact('kegiatanList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $validated['deviasi_fisik'] = $validated['realisasi_fisik'] - $validated['rencana_fisik'];

        // Simpan progres fisik
        $progresFisik = ProgresFisik::create($validated);

        // Ambil data kegiatan untuk notifikasi
        $progresFisik->load('kegiatan');

        // Kirim notifikasi ke semua user
        User::all()->each(function ($user) use ($progresFisik) {
            $user->notify(new ProgresFisikNotification($progresFisik));
        });

        return redirect()
            ->route('progres-fisik.index')
            ->with('success', 'Progres fisik berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgresFisik $progresFisik): View
    {
        $kegiatanList = Kegiatan::orderBy('nama_kegiatan')->get();

        return view('progres_fisik.edit', compact('progresFisik', 'kegiatanList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgresFisik $progresFisik): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $validated['deviasi_fisik'] = $validated['realisasi_fisik'] - $validated['rencana_fisik'];

        $progresFisik->update($validated);

        // Ambil data kegiatan untuk notifikasi
        $progresFisik->load('kegiatan');

        // Kirim notifikasi ke semua user
        User::all()->each(function ($user) use ($progresFisik) {
            $user->notify(new ProgresFisikNotification($progresFisik));
        });

        return redirect()
            ->route('progres-fisik.index')
            ->with('success', 'Progres fisik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgresFisik $progresFisik): RedirectResponse
    {
        $progresFisik->delete();

        return redirect()
            ->route('progres-fisik.index')
            ->with('success', 'Progres fisik berhasil dihapus.');
    }

    /**
     * Validate the incoming request data.
     */
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'kegiatan_id' => ['required', 'exists:kegiatan,id'],
            'tanggal_rencana' => ['nullable', 'date'],
            'rencana_fisik' => ['required', 'numeric', 'min:0', 'max:100'],
            'tanggal_realisasi' => ['nullable', 'date'],
            'realisasi_fisik' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);
    }
}