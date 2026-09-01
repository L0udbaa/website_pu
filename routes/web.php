<?php

use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgresFisikController;
use App\Http\Controllers\ProgresKeuanganController;
use App\Http\Controllers\RekapitulasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('progres-fisik', ProgresFisikController::class)->except(['show']);
    // Tambahkan baris ini ke routes/web.php (di dalam middleware auth jika ada)
    Route::resource('kegiatan', KegiatanController::class)->except(['show']);

    Route::name('progres-keuangan.')
        ->prefix('progres-keuangan')
        ->group(function () {
            // Rute spesifik didaftarkan lebih dulu supaya tidak bentrok dengan {kegiatan?}
            Route::get('/create/{kegiatan?}', [ProgresKeuanganController::class, 'create'])->name('create');
            Route::get('/{progresKeuangan}/edit/{kegiatan?}', [ProgresKeuanganController::class, 'edit'])->name('edit');

            Route::get('/{kegiatan?}', [ProgresKeuanganController::class, 'index'])->name('index');
            Route::post('/', [ProgresKeuanganController::class, 'store'])->name('store');
            Route::put('/{progresKeuangan}', [ProgresKeuanganController::class, 'update'])->name('update');
            Route::delete('/{progresKeuangan}', [ProgresKeuanganController::class, 'destroy'])->name('destroy');
        });

        Route::get('/rekapitulasi', [RekapitulasiController::class, 'index'])->name('rekapitulasi.index');
});

require __DIR__ . '/auth.php';
