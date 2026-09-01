@php
    $selectedKegiatan = $kegiatan ?? $progresKeuangan?->kegiatan ?? null;
@endphp

@extends('layouts.app')

@section('title', 'Edit Progres Keuangan')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
            <div>
                @if ($selectedKegiatan)
                    <p class="eyebrow mb-1">{{ $selectedKegiatan->kode_kegiatan }}</p>
                    <h1 class="h3 mb-1">Edit Progres Keuangan</h1>
                    <p class="text-muted mb-0">{{ $selectedKegiatan->nama_kegiatan }}</p>
                @else
                    <p class="eyebrow mb-1">Semua Kegiatan</p>
                    <h1 class="h3 mb-1">Edit Progres Keuangan</h1>
                    <p class="text-muted mb-0">Perbarui data progres keuangan.</p>
                @endif
            </div>
        </div>
        <div class="heading-actions">
            <a class="btn btn-light btn-sm" href="{{ $selectedKegiatan ? route('progres-keuangan.index', $selectedKegiatan) : route('progres-keuangan.index') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali
            </a>
        </div>
    </div>

    <section class="panel mt-3">
        <form action="{{ $selectedKegiatan ? route('progres-keuangan.update', [$selectedKegiatan, $progresKeuangan]) : route('progres-keuangan.update', $progresKeuangan) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')
            @include('progres-keuangan._form', ['item' => $progresKeuangan])

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg" aria-hidden="true"></i> Perbarui
                </button>
            </div>
        </form>
    </section>
@endsection