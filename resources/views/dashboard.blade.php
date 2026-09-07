@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-page">
    {{-- Page Heading (Template Standard) --}}
    <div class="page-heading dashboard-hero">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Balai Pelaksanaan Jalan Nasional Maluku Utara</p>
                <h1 class="h3 mb-1">Dashboard Monitoring</h1>
                <p class="text-muted mb-0">Ringkasan capaian fisik, penyerapan keuangan, dan evaluasi kegiatan infrastruktur.</p>
            </div>
        </div>
        <div class="heading-actions">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('rekapitulasi.index') }}">
                <i class="bi bi-clipboard-data me-1" aria-hidden="true"></i> Rekapitulasi
            </a>
            <a class="btn btn-primary btn-sm" href="{{ route('kegiatan.create') }}">
                <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Tambah Kegiatan
            </a>
        </div>
    </div>

    {{-- 4 Metric Cards (Template Standard Grid) --}}
    <section class="row g-3 dashboard-metrics" aria-label="Ringkasan dashboard">
        {{-- Total Kegiatan --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Total Kegiatan</span>
                    <span class="metric-icon"><i class="bi bi-diagram-3" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value fs-2 lh-1">{{ $jumlahKegiatan }}</div>
                <div class="metric-meta">
                    <span class="text-primary fw-semibold">{{ $jumlahKegiatan }} Kegiatan</span>
                    <span>terdaftar aktif</span>
                </div>
            </article>
        </div>

        {{-- Realisasi Fisik --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Realisasi Fisik</span>
                    <span class="metric-icon"><i class="bi bi-tools" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value fs-2 lh-1">{{ number_format($totalRealisasiFisik, 2, ',', '.') }}%</div>
                <div class="metric-meta">
                    @if ($deviasiFisik > 0)
                        <span class="text-success fw-semibold"><i class="bi bi-arrow-up-short"></i>+{{ number_format($deviasiFisik, 2, ',', '.') }}%</span>
                        <span>deviasi positif</span>
                    @elseif ($deviasiFisik < 0)
                        <span class="text-danger fw-semibold"><i class="bi bi-arrow-down-short"></i>{{ number_format($deviasiFisik, 2, ',', '.') }}%</span>
                        <span>deviasi minus</span>
                    @else
                        <span class="text-muted fw-semibold">0,00%</span>
                        <span>sesuai rencana</span>
                    @endif
                </div>
            </article>
        </div>

        {{-- Realisasi Keuangan --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Realisasi Keuangan</span>
                    <span class="metric-icon"><i class="bi bi-cash-stack" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value metric-value-currency fs-4 lh-1">
                    Rp {{ number_format($totalRealisasiKeuangan, 0, ',', '.') }}
                </div>
                <div class="metric-meta">
                    @if ($deviasiKeuangan >= 0)
                        <span class="text-success fw-semibold"><i class="bi bi-arrow-up-short"></i>+Rp {{ number_format($deviasiKeuangan, 0, ',', '.') }}</span>
                        <span>di atas target</span>
                    @else
                        <span class="text-danger fw-semibold"><i class="bi bi-arrow-down-short"></i>-Rp {{ number_format(abs($deviasiKeuangan), 0, ',', '.') }}</span>
                        <span>selisih target</span>
                    @endif
                </div>
            </article>
        </div>

        {{-- Kelengkapan Data Form --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card {{ $kegiatanBelumLengkap->count() > 0 ? 'metric-danger' : 'metric-success' }}">
                <div class="metric-top">
                    <span class="metric-label">Kelengkapan Data</span>
                    <span class="metric-icon">
                        <i class="bi {{ $kegiatanBelumLengkap->count() > 0 ? 'bi-exclamation-triangle' : 'bi-shield-check' }}" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value fs-2 lh-1">{{ $kegiatanBelumLengkap->count() }}</div>
                <div class="metric-meta">
                    @if ($kegiatanBelumLengkap->count() > 0)
                        <span class="text-danger fw-semibold">{{ $kegiatanBelumLengkap->count() }} Kegiatan</span>
                        <span>perlu dilengkapi</span>
                    @else
                        <span class="text-success fw-semibold"><i class="bi bi-check-circle me-1"></i>100%</span>
                        <span>semua data lengkap</span>
                    @endif
                </div>
            </article>
        </div>
    </section>

    {{-- Mid Section: Capaian Progres & Perhatian --}}
    <section class="row g-3 mt-1">
        {{-- Capaian Progres --}}
        <div class="col-12 col-xl-8">
            <div class="panel h-100 dashboard-panel">
                <div class="panel-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="h5 mb-1 section-title">
                            <i class="bi bi-graph-up-arrow me-2 text-primary" aria-hidden="true"></i>
                            <span>Capaian Progres Kumulatif</span>
                        </h2>
                        <p class="text-muted mb-0">Perbandingan realisasi dan rencana progres kegiatan secara terpadu.</p>
                    </div>
                    <a class="btn btn-light btn-sm" href="{{ route('rekapitulasi.index') }}">
                        Buka Rekapitulasi <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                {{-- Progress Summary Bars --}}
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3 bg-body-tertiary dashboard-progress-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold small text-uppercase text-muted">Progres Fisik</span>
                                <span class="badge text-bg-primary fw-bold">{{ number_format($persentaseFisik, 1, ',', '.') }}%</span>
                            </div>
                            <div class="progress mb-2" style="height: 10px;" role="progressbar" aria-valuenow="{{ $persentaseFisik }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-primary" style="width: {{ $persentaseFisik }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Rencana: <strong>{{ number_format($totalRencanaFisik, 2, ',', '.') }}%</strong></span>
                                <span>Realisasi: <strong>{{ number_format($totalRealisasiFisik, 2, ',', '.') }}%</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3 bg-body-tertiary dashboard-progress-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold small text-uppercase text-muted">Realisasi Keuangan</span>
                                <span class="badge text-bg-success fw-bold">{{ number_format($persentaseKeuangan, 1, ',', '.') }}%</span>
                            </div>
                            <div class="progress mb-2" style="height: 10px;" role="progressbar" aria-valuenow="{{ $persentaseKeuangan }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: {{ $persentaseKeuangan }}%"></div>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Rencana: <strong>Rp {{ number_format($totalRencanaKeuangan, 0, ',', '.') }}</strong></span>
                                <span>Realisasi: <strong>Rp {{ number_format($totalRealisasiKeuangan, 0, ',', '.') }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Highlight Metrics Summary --}}
                <div class="row g-3">
                    <div class="col-12 col-sm-4">
                        <div class="p-3 border rounded-3 text-center">
                            <small class="text-muted text-uppercase d-block fw-semibold mb-1">Status Deviasi Fisik</small>
                            <h4 class="fs-5 mb-0 fw-bold {{ $deviasiFisik > 0 ? 'text-success' : ($deviasiFisik < 0 ? 'text-danger' : 'text-muted') }}">
                                {{ $deviasiFisik > 0 ? '+' : '' }}{{ number_format($deviasiFisik, 2, ',', '.') }}%
                            </h4>
                            <small class="text-muted">{{ $deviasiFisik > 0 ? 'Di atas rencana' : ($deviasiFisik < 0 ? 'Perlu percepatan' : 'Sesuai jadwal') }}</small>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="p-3 border rounded-3 text-center">
                            <small class="text-muted text-uppercase d-block fw-semibold mb-1">Status Deviasi Keuangan</small>
                            <h4 class="dashboard-summary-value fs-5 mb-0 fw-bold {{ $deviasiKeuangan >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ $deviasiKeuangan >= 0 ? '+' : '-' }}Rp {{ number_format(abs($deviasiKeuangan), 0, ',', '.') }}
                            </h4>
                            <small class="text-muted">{{ $deviasiKeuangan >= 0 ? 'Optimal' : 'Sisa Alokasi' }}</small>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="p-3 border rounded-3 text-center">
                            <small class="text-muted text-uppercase d-block fw-semibold mb-1">Total Pagu Kegiatan</small>
                            <h4 class="dashboard-summary-value fs-5 mb-0 fw-bold text-primary">
                                Rp {{ number_format($kegiatan->sum('anggaran'), 0, ',', '.') }}
                            </h4>
                            <small class="text-muted">{{ $kegiatan->count() }} dari {{ $jumlahKegiatan }} kegiatan terbaru</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Activity List / Perhatian --}}
        <div class="col-12 col-xl-4">
            <div class="panel h-100 dashboard-panel dashboard-attention-panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title">
                            <i class="bi bi-exclamation-triangle text-warning me-2" aria-hidden="true"></i>
                            <span>Perhatian & Tindak Lanjut</span>
                        </h2>
                        <p class="text-muted mb-0">Form kegiatan atau progres yang belum diisi.</p>
                    </div>
                </div>

                @if ($kegiatanBelumLengkap->isNotEmpty())
                    <div class="activity-list">
                        @foreach ($kegiatanBelumLengkap->take(5) as $item)
                            <div class="activity-item">
                                <span class="activity-dot bg-warning"></span>
                                <div class="w-100 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                                        <strong class="text-truncate small" title="{{ $item->nama_kegiatan }}">{{ $item->nama_kegiatan }}</strong>
                                        <span class="badge dashboard-code-badge text-bg-light border text-muted">{{ $item->kode_kegiatan }}</span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach ($item->missing_forms as $missingForm)
                                            @if (in_array($missingForm, ['Data Utama', 'Lokasi', 'Tahun', 'Anggaran', 'PJ']))
                                               <a href="{{ route('kegiatan.edit', $item) }}" class="badge text-bg-warning text-decoration-none small" title="Lengkapi {{ $missingForm }}">
                                                   <i class="bi bi-pencil-square"></i> {{ $missingForm }}
                                               </a>
                                            @elseif ($missingForm === 'Fisik')
                                               <a href="{{ route('progres-fisik.create') }}" class="badge text-bg-primary text-decoration-none small" title="Isi Progres Fisik">
                                                   <i class="bi bi-bricks"></i> Fisik
                                               </a>
                                            @elseif ($missingForm === 'Keuangan')
                                               <a href="{{ route('progres-keuangan.create', $item) }}" class="badge text-bg-success text-decoration-none small" title="Isi Progres Keuangan">
                                                   <i class="bi bi-cash-coin"></i> Keuangan
                                               </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($kegiatanBelumLengkap->count() > 5)
                        <div class="text-center mt-3 pt-2 border-top">
                            <small class="text-muted">+{{ $kegiatanBelumLengkap->count() - 5 }} kegiatan lainnya memerlukan kelengkapan data.</small>
                        </div>
                    @endif
                @else
                    <div class="activity-list">
                        <div class="activity-item">
                            <span class="activity-dot bg-success"></span>
                            <div>
                                <p class="mb-1 fw-semibold text-success">Seluruh Data Kegiatan Lengkap</p>
                                <p class="text-muted small mb-0">Semua form progres fisik, keuangan, dan data kegiatan telah diisi.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Bottom Table: Kegiatan Infrastruktur Terbaru --}}
    <section class="panel mt-3 dashboard-panel dashboard-table-panel">
        <div class="panel-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h5 mb-1 section-title">
                    <i class="bi bi-list-check me-2 text-primary" aria-hidden="true"></i>
                    <span>Kegiatan Infrastruktur Terbaru</span>
                </h2>
                <p class="text-muted mb-0">Daftar kegiatan pekerjaan jalan dan jembatan yang terakhir ditambahkan.</p>
            </div>
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('kegiatan.index') }}">
                Lihat Semua Kegiatan <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Kode & Nama Kegiatan</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Tahun</th>
                        <th scope="col" class="text-end">Pagu Anggaran</th>
                        <th scope="col" class="text-center">Progres Fisik</th>
                        <th scope="col" class="text-center">Realisasi Keuangan</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kegiatan as $item)
                        @php
                            $latestFisik = $item->progresFisik->sortByDesc('id')->first();
                            $latestKeuangan = $item->progresKeuangan->sortByDesc('id')->first();
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge text-bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">{{ $item->kode_kegiatan }}</span>
                                    <span class="fw-semibold text-truncate" style="max-width: 260px;" title="{{ $item->nama_kegiatan }}">{{ $item->nama_kegiatan }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small">
                                    <i class="bi bi-geo-alt text-danger me-1"></i>{{ $item->lokasi ?: '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge text-bg-light border">{{ $item->tahun }}</span>
                            </td>
                            <td class="text-end fw-bold">
                                Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if ($latestFisik)
                                    <span class="badge dashboard-status-badge dashboard-status-primary text-bg-primary bg-opacity-15 text-primary border border-primary border-opacity-25">
                                        {{ number_format($latestFisik->realisasi_fisik, 1, ',', '.') }}%
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($latestKeuangan)
                                    <span class="badge dashboard-status-badge dashboard-status-success text-bg-success bg-opacity-15 text-success border border-success border-opacity-25">
                                        Rp {{ number_format($latestKeuangan->realisasi_keuangan, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a class="btn btn-light btn-sm" href="{{ route('kegiatan.edit', $item) }}" title="Lihat & Edit">
                                    <i class="bi bi-pencil-square me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada kegiatan yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    </div>
@endsection
