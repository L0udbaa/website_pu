<?php

use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgresFisikController;
use App\Http\Controllers\ProgresKeuanganController;
use App\Http\Controllers\RekapitulasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // =====================================================
    // PROFILE
    // =====================================================

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::get('/settings', [ProfileController::class, 'settings'])
        ->name('settings');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =====================================================
    // PROGRES FISIK
    // =====================================================

    Route::resource('progres-fisik', ProgresFisikController::class)
        ->except(['show']);


    // =====================================================
    // KEGIATAN
    // =====================================================

    Route::resource('kegiatan', KegiatanController::class)
        ->except(['show']);


    // =====================================================
    // PROGRES KEUANGAN
    // =====================================================

    Route::name('progres-keuangan.')
        ->prefix('progres-keuangan')
        ->group(function () {

            // Create
            Route::get('/create/{kegiatan?}', [
                ProgresKeuanganController::class,
                'create'
            ])->name('create');

            // Edit
            Route::get('/{progresKeuangan}/edit/{kegiatan?}', [
                ProgresKeuanganController::class,
                'edit'
            ])->name('edit');

            // Index
            Route::get('/{kegiatan?}', [
                ProgresKeuanganController::class,
                'index'
            ])->name('index');

            // Store
            Route::post('/', [
                ProgresKeuanganController::class,
                'store'
            ])->name('store');

            // Update
            Route::put('/{progresKeuangan}', [
                ProgresKeuanganController::class,
                'update'
            ])->name('update');

            // Delete
            Route::delete('/{progresKeuangan}', [
                ProgresKeuanganController::class,
                'destroy'
            ])->name('destroy');
        });


    // =====================================================
    // REKAPITULASI
    // =====================================================

    Route::get('/rekapitulasi', [
        RekapitulasiController::class,
        'index'
    ])->name('rekapitulasi.index');


    // =====================================================
    // NOTIFIKASI
    // =====================================================

    // -----------------------------------------------------
    // Semua notifikasi
    // -----------------------------------------------------

    Route::get('/notifikasi', function () {

        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view(
            'notifikasi.index',
            compact('notifications')
        );

    })->name('notifikasi.index');


    // -----------------------------------------------------
    // Tandai satu notifikasi sudah dibaca
    // -----------------------------------------------------

    Route::post('/notifikasi/{notification}/read', function ($notification) {

        $notification = auth()->user()
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        $notification->markAsRead();

        return back();

    })->name('notifikasi.read');


    // -----------------------------------------------------
    // Tandai semua notifikasi sudah dibaca
    // -----------------------------------------------------

    Route::post('/notifikasi/read-all', function () {

        auth()->user()
            ->unreadNotifications
            ->markAsRead();

        return back();

    })->name('notifikasi.read-all');

});


require __DIR__ . '/auth.php';