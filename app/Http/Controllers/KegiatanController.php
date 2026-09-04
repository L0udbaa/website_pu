<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\User;
use App\Notifications\KegiatanNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $kegiatan = Kegiatan::with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_kegiatan', 'like', '%' . $request->search . '%')
                        ->orWhere('kode_kegiatan', 'like', '%' . $request->search . '%');
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('kegiatan.index', compact('kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $userList = User::orderBy('nama')->get();

        return view('kegiatan.create', compact('userList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        // Simpan kegiatan
        $kegiatan = Kegiatan::create($validated);

        // Kirim notifikasi ke semua user
        User::all()->each(function ($user) use ($kegiatan) {
            $user->notify(new KegiatanNotification($kegiatan));
        });

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kegiatan $kegiatan): View
    {
        $userList = User::orderBy('nama')->get();

        return view('kegiatan.edit', compact('kegiatan', 'userList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kegiatan $kegiatan): RedirectResponse
    {
        $validated = $this->validateRequest($request, $kegiatan->id);

        $kegiatan->update($validated);

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kegiatan $kegiatan): RedirectResponse
    {
        $kegiatan->delete();

        return redirect()
            ->route('kegiatan.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Validate the incoming request data.
     */
    private function validateRequest(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'user_id' => ['nullable', 'exists:users,id'],
            'kode_kegiatan' => [
                'required',
                'string',
                'max:50',
                'unique:kegiatan,kode_kegiatan' . ($ignoreId ? ',' . $ignoreId : ''),
            ],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'tahun' => ['required', 'digits:4', 'integer', 'min:2000', 'max:2100'],
            'anggaran' => ['required', 'numeric', 'min:0'],
        ]);
    }
}