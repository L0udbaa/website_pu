@php
    $selectedKegiatan = $kegiatan ?? null;
@endphp

@extends('layouts.app')

@section('title', 'Progres Keuangan')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
            <div>
                @if ($selectedKegiatan)
                    <p class="eyebrow mb-1">{{ $selectedKegiatan->kode_kegiatan }}</p>
                    <h1 class="h3 mb-1">Progres Keuangan</h1>
                    <p class="text-muted mb-0">{{ $selectedKegiatan->nama_kegiatan }}</p>
                @else
                    <p class="eyebrow mb-1">Semua Kegiatan</p>
                    <h1 class="h3 mb-1">Progres Keuangan</h1>
                    <p class="text-muted mb-0">Daftar riwayat progres keuangan seluruh kegiatan.</p>
                @endif
            </div>
        </div>
        <div class="heading-actions">
            <a class="btn btn-light btn-sm" href="{{ route('kegiatan.index') }}">
                <i class="bi bi-arrow-left" aria-hidden="true"></i> Kembali
            </a>
            <a class="btn btn-primary btn-sm" href="{{ route('progres-keuangan.create', $selectedKegiatan) }}">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Progres
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Riwayat
                        Progres</span></h2>
                <p class="text-muted mb-0">Total {{ $progres->total() }} data.</p>
            </div>
            <form action="{{ route('progres-keuangan.index', $selectedKegiatan) }}" method="GET" class="d-flex"
                role="search">
                <input type="search" name="search" value="{{ request('search') }}" class="form-control search-input"
                    placeholder="Cari kode / nama kegiatan">
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        @unless ($selectedKegiatan)
                            <th scope="col">Kegiatan</th>
                        @endunless
                        <th scope="col">Nilai Kontrak</th>
                        <th scope="col">Rencana (%)</th>
                        <th scope="col">Tgl Rencana</th>
                        <th scope="col">Realisasi (%)</th>
                        <th scope="col">Rencana (Rp)</th>
                        <th scope="col">Tgl Realisasi</th>
                        <th scope="col">Realisasi (Rp)</th>
                        <th scope="col">Deviasi (Rp)</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($progres as $item)
                        <tr>
                            @unless ($selectedKegiatan)
                                <td>
                                    <div class="fw-semibold">{{ $item->kegiatan->nama_kegiatan ?? '-' }}</div>
                                    <div class="text-muted small">{{ $item->kegiatan->kode_kegiatan ?? '-' }}</div>
                                </td>
                            @endunless
                            <td>Rp {{ number_format($item->nilai_kontrak, 0, ',', '.') }}</td>
                            <td>{{ number_format($item->rencana_persen, 2) }}%</td>
                            <td>{{ $item->tanggal_rencana ? \Carbon\Carbon::parse($item->tanggal_rencana)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ number_format($item->realisasi_persen, 2) }}%</td>
                            <td>Rp {{ number_format($item->rencana_keuangan, 0, ',', '.') }}</td>
                            <td>{{ $item->tanggal_realisasi ? \Carbon\Carbon::parse($item->tanggal_realisasi)->format('d-m-Y') : '-' }}
                            </td>
                            <td>Rp {{ number_format($item->realisasi_keuangan, 0, ',', '.') }}</td>
                            <td>
                                <span
                                    class="badge {{ $item->deviasi_keuangan < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                    Rp {{ number_format($item->deviasi_keuangan, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-end">
                                @php
                                    $editRoute = route('progres-keuangan.edit', [$item, $selectedKegiatan]);
                                    $deleteRoute = route('progres-keuangan.destroy', $item);
                                @endphp
                                <a class="btn btn-light btn-sm" href="{{ $editRoute }}">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ $deleteRoute }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data progres keuangan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light btn-sm text-danger">
                                        <i class="bi bi-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $selectedKegiatan ? 9 : 10 }}" class="text-center text-muted py-4">
                                Belum ada data progres keuangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($progres->hasPages())
            <div class="p-3">
                {{ $progres->links() }}
            </div>
        @endif
    </section>
@endsection
