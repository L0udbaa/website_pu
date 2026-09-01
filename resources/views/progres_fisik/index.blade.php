@extends('layouts.app')

@section('title', 'Progres Fisik')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-tools" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Monitoring</p>
                <h1 class="h3 mb-1">Progres Fisik</h1>
                <p class="text-muted mb-0">Rencana dan realisasi progres fisik setiap kegiatan.</p>
            </div>
        </div>
        <div class="heading-actions">
            <a class="btn btn-primary btn-sm" href="{{ route('progres-fisik.create') }}">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Progres Fisik
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
                <h2 class="h5 mb-1 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Daftar Progres Fisik</span></h2>
                <p class="text-muted mb-0">Total {{ $progresFisik->total() }} data.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Kegiatan</th>
                        <th scope="col">Tgl. Rencana</th>
                        <th scope="col">Rencana (%)</th>
                        <th scope="col">Tgl. Realisasi</th>
                        <th scope="col">Realisasi (%)</th>
                        <th scope="col">Deviasi (%)</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($progresFisik as $item)
                        <tr>
                            <td>
                                <p class="fw-semibold mb-0">{{ $item->kegiatan?->nama_kegiatan ?? '-' }}</p>
                                <p class="text-muted small mb-0">{{ $item->kegiatan?->kode_kegiatan }}</p>
                            </td>
                            <td>{{ $item->tanggal_rencana?->format('d M Y') ?? '-' }}</td>
                            <td>{{ number_format($item->rencana_fisik, 2) }}%</td>
                            <td>{{ $item->tanggal_realisasi?->format('d M Y') ?? '-' }}</td>
                            <td>{{ number_format($item->realisasi_fisik, 2) }}%</td>
                            <td>
                                <span class="badge {{ $item->deviasi_fisik < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                    {{ number_format($item->deviasi_fisik, 2) }}%
                                </span>
                            </td>
                            <td class="text-end">
                                <a class="btn btn-light btn-sm" href="{{ route('progres-fisik.edit', $item) }}">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('progres-fisik.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus data progres fisik ini?');">
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
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data progres fisik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($progresFisik->hasPages())
            <div class="p-3">
                {{ $progresFisik->links() }}
            </div>
        @endif
    </section>
@endsection
