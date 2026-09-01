@extends('layouts.app')

@section('title', 'Kegiatan')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Master Data</p>
                <h1 class="h3 mb-1">Kegiatan</h1>
                <p class="text-muted mb-0">Daftar kegiatan yang dipantau progres fisik dan keuangannya.</p>
            </div>
        </div>
        <div class="heading-actions">
            <a class="btn btn-primary btn-sm" href="{{ route('kegiatan.create') }}">
                <i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Kegiatan
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
                <h2 class="h5 mb-1 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Daftar Kegiatan</span></h2>
                <p class="text-muted mb-0">Total {{ $kegiatan->total() }} kegiatan.</p>
            </div>
            <form action="{{ route('kegiatan.index') }}" method="GET" class="d-flex" role="search">
                <input type="search" name="search" value="{{ request('search') }}"
                    class="form-control search-input" placeholder="Cari kode / nama kegiatan">
            </form>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Kode</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Penanggung Jawab</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kegiatan as $item)
                        <tr>
                            <td>{{ $item->kode_kegiatan }}</td>
                            <td class="fw-semibold">{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->lokasi ?? '-' }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td>Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                            <td>{{ $item->user?->nama ?? '-' }}</td>
                            <td class="text-end">
                                <a class="btn btn-light btn-sm" href="{{ route('kegiatan.edit', $item) }}">
                                    <i class="bi bi-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('kegiatan.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus kegiatan ini? Semua progres fisik & keuangan terkait juga akan terhapus.');">
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
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kegiatan->hasPages())
            <div class="p-3">
                {{ $kegiatan->links() }}
            </div>
        @endif
    </section>
@endsection
