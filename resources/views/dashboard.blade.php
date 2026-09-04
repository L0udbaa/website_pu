@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Monitoring Progres</p>
                <h1 class="h3 mb-1">Dashboard</h1>
                <p class="text-muted mb-0">Ringkasan kegiatan dan capaian progres terbaru.</p>
            </div>
        </div>
        <div class="heading-actions">
            <a class="btn btn-primary btn-sm" href="{{ route('kegiatan.create') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i> Tambah Kegiatan</a>
        </div>
    </div>

    <section class="row g-3 mt-1" aria-label="Ringkasan dashboard">
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-primary">
                <div class="metric-top"><span class="metric-label">Total Kegiatan</span><span class="metric-icon"><i class="bi bi-kanban" aria-hidden="true"></i></span></div>
                <div class="metric-value">{{ $jumlahKegiatan }}</div>
                <div class="metric-meta"><span>proyek terdaftar</span></div>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-success">
                <div class="metric-top"><span class="metric-label">Progres Fisik</span><span class="metric-icon"><i class="bi bi-bricks" aria-hidden="true"></i></span></div>
                <div class="metric-value">{{ number_format($totalRealisasiFisik, 2, ',', '.') }}%</div>
                <div class="metric-meta"><span>realisasi kumulatif</span></div>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-warning">
                <div class="metric-top"><span class="metric-label">Realisasi Keuangan</span><span class="metric-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span></div>
                <div class="metric-value">Rp {{ number_format($totalRealisasiKeuangan, 0, ',', '.') }}</div>
                <div class="metric-meta"><span>realisasi kumulatif</span></div>
            </article>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-danger">
                <div class="metric-top"><span class="metric-label">Deviasi Fisik</span><span class="metric-icon"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i></span></div>
                <div class="metric-value">{{ $deviasiFisik >= 0 ? '+' : '' }}{{ number_format($deviasiFisik, 2, ',', '.') }}%</div>
                <div class="metric-meta"><span>realisasi dibanding rencana</span></div>
            </article>
        </div>
    </section>

    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-speedometer2" aria-hidden="true"></i><span>Capaian Progres</span></h2>
                        <p class="text-muted mb-0">Gambaran cepat pencapaian proyek secara keseluruhan.</p>
                    </div>
                    <a class="btn btn-light btn-sm" href="{{ route('rekapitulasi.index') }}">Buka Rekap</a>
                </div>
                <div class="dashboard-progress-list">
                    <div class="dashboard-progress-item">
                        <div class="d-flex justify-content-between gap-3 mb-2"><span class="fw-semibold">Capaian Fisik</span><strong>{{ number_format($persentaseFisik, 1, ',', '.') }}%</strong></div>
                        <div class="progress" role="progressbar" aria-label="Capaian fisik" aria-valuenow="{{ $persentaseFisik }}" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar bg-primary" style="width: {{ $persentaseFisik }}%"></div></div>
                    </div>
                    <div class="dashboard-progress-item">
                        <div class="d-flex justify-content-between gap-3 mb-2"><span class="fw-semibold">Capaian Keuangan</span><strong class="text-success">{{ number_format($persentaseKeuangan, 1, ',', '.') }}%</strong></div>
                        <div class="progress" role="progressbar" aria-label="Capaian keuangan" aria-valuenow="{{ $persentaseKeuangan }}" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar bg-success" style="width: {{ $persentaseKeuangan }}%"></div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-4">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-lightning-charge" aria-hidden="true"></i><span>Perhatian</span></h2>
                        <p class="text-muted mb-0">Form kegiatan dan progres yang belum diisi.</p>
                    </div>
                </div>
                <div class="dashboard-attention">
                    <div class="dashboard-attention-icon"><i class="bi bi-clipboard-x" aria-hidden="true"></i></div>
                    <strong>{{ $kegiatanBelumLengkap->count() }}</strong>
                    <span>kegiatan memiliki form yang belum lengkap</span>
                </div>
                @if ($kegiatanBelumLengkap->isNotEmpty())
                    <div class="dashboard-missing-list">
                        @foreach ($kegiatanBelumLengkap as $item)
                            <div class="dashboard-missing-item">
                                <div class="min-w-0">
                                    <strong>{{ $item->kode_kegiatan }}</strong>
                                    <span>{{ $item->nama_kegiatan }}</span>
                                </div>
                                <div class="dashboard-missing-actions">
                                    @foreach ($item->missing_forms as $missingForm)
                                        @if (in_array($missingForm, ['Data Utama', 'Lokasi', 'Tahun', 'Anggaran', 'PJ']))
                                            <a href="{{ route('kegiatan.edit', $item) }}" class="badge text-bg-warning">{{ $missingForm }}</a>
                                        @elseif ($missingForm === 'Fisik')
                                            <a href="{{ route('progres-fisik.create') }}" class="badge text-bg-primary">Fisik</a>
                                        @elseif ($missingForm === 'Keuangan')
                                            <a href="{{ route('progres-keuangan.create', $item) }}" class="badge text-bg-success">Keuangan</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-success text-center mb-0"><i class="bi bi-check-circle" aria-hidden="true"></i> Semua form progres sudah diisi.</p>
                @endif
            </div>
        </div>
    </section>

    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-list-check" aria-hidden="true"></i><span>Kegiatan Terbaru</span></h2>
                <p class="text-muted mb-0">Daftar kegiatan yang terakhir ditambahkan.</p>
            </div>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('kegiatan.index') }}">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead><tr><th>Kode</th><th>Kegiatan</th><th>Lokasi</th><th>Tahun</th><th class="text-end">Anggaran</th></tr></thead>
                <tbody>
                    @forelse ($kegiatan as $item)
                        <tr>
                            <td><span class="fw-semibold">{{ $item->kode_kegiatan }}</span></td>
                            <td>{{ $item->nama_kegiatan }}</td>
                            <td>{{ $item->lokasi ?: '-' }}</td>
                            <td>{{ $item->tahun }}</td>
                            <td class="text-end">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kegiatan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <style>
        .dashboard-progress-list { display: grid; gap: 1.25rem; padding-top: .5rem; }
        .dashboard-progress-item strong { color: var(--admin-text); }
        .dashboard-progress-item .progress { height: 10px; background: var(--admin-border); }
        .dashboard-attention { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 155px; text-align: center; }
        .dashboard-attention-icon { display: grid; width: 42px; height: 42px; place-items: center; margin-bottom: .6rem; border-radius: 50%; background: #fef3c7; color: #b45309; }
        .dashboard-attention strong { color: var(--admin-text); font-size: 1.8rem; line-height: 1; }
        .dashboard-attention span { margin-top: .4rem; color: var(--admin-muted); font-size: .85rem; }
        html[data-theme="dark"] .dashboard-attention-icon { background: #422006; color: #fbbf24; }
        .dashboard-missing-list { display: grid; gap: .6rem; margin-top: 1rem; max-height: 220px; overflow-y: auto; }
        .dashboard-missing-item { display: flex; align-items: center; justify-content: space-between; gap: .75rem; padding: .7rem; border: 1px solid var(--admin-border); border-radius: 8px; background: var(--admin-surface-soft); }
        .dashboard-missing-item strong, .dashboard-missing-item span { display: block; }
        .dashboard-missing-item strong { color: var(--admin-text); font-size: .85rem; }
        .dashboard-missing-item span { margin-top: .15rem; overflow: hidden; color: var(--admin-muted); font-size: .75rem; text-overflow: ellipsis; white-space: nowrap; }
        .dashboard-missing-actions { display: flex; flex: 0 0 auto; gap: .3rem; }
        .dashboard-missing-actions .badge { text-decoration: none; }
    </style>
@endsection
