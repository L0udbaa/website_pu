@php
    $selectedKegiatan = $kegiatan ?? null;
@endphp

@extends('layouts.app')

@section('title', 'Tambah Progres Keuangan')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
            <div>
                @if ($selectedKegiatan)
                    <p class="eyebrow mb-1">{{ $selectedKegiatan->kode_kegiatan }}</p>
                    <h1 class="h3 mb-1">Tambah Progres Keuangan</h1>
                    <p class="text-muted mb-0">{{ $selectedKegiatan->nama_kegiatan }}</p>
                @else
                    <p class="eyebrow mb-1">Semua Kegiatan</p>
                    <h1 class="h3 mb-1">Tambah Progres Keuangan</h1>
                    <p class="text-muted mb-0">Pilih kegiatan yang ingin dicatat progres keuangannya.</p>
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
        <form action="{{ $selectedKegiatan ? route('progres-keuangan.store', $selectedKegiatan) : route('progres-keuangan.store') }}" method="POST" class="p-3">
            @csrf
            @include('progres-keuangan._form')

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg" aria-hidden="true"></i> Simpan
                </button>
            </div>
        </form>
    </section>
@endsection
