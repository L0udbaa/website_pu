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
                <p class="dashboard-description mb-0">Ringkasan capaian fisik, penyerapan keuangan, dan evaluasi kegiatan infrastruktur.</p>
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

    @php
        $activityItems = $kegiatan->take(6)->map(function ($item) {
            $latestFisik = $item->progresFisik->sortByDesc('id')->first();
            $latestKeuangan = $item->progresKeuangan->sortByDesc('id')->first();

            $fisik = $latestFisik ? (float) $latestFisik->realisasi_fisik : 0;
            $keuangan = $latestKeuangan ? (float) $latestKeuangan->realisasi_keuangan : 0;
            $deviasi = $latestKeuangan ? (float) $latestKeuangan->deviasi_keuangan : 0;

            return [
                'nama' => $item->nama_kegiatan,
                'kode' => $item->kode_kegiatan,
                'fisik' => $fisik,
                'keuangan' => $keuangan,
                'deviasi' => $deviasi,
            ];
        });
    @endphp

    <section class="mt-3">
        <div class="rounded-4 border bg-white p-3 p-lg-4 shadow-sm" style="background: #f8f9fc; border-color: #dfe7f1;">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white border" style="width: 38px; height: 38px; color: #4c6ef5; border-color: rgba(76,110,245,.2);">
                        <i class="bi bi-graph-up-arrow"></i>
                    </span>
                    <h2 class="h3 mb-0 fw-semibold text-dark">Capaian Progres Kumulatif</h2>
                </div>
                <a href="{{ route('rekapitulasi.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold" style="border-color: #dfe7f1; color: #1f2937; background: rgba(255,255,255,.85);">
                    Buka Rekapitulasi <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-12 col-xl-6">
                    <div class="rounded-4 border bg-white p-3 h-100" style="border-color: #dfe7f1; min-height: 150px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-uppercase" style="letter-spacing: .08em; color: #4f46e5;">Progres Fisik</span>
                            <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #4f46e5, #5b7cff); color: white;">{{ number_format($persentaseFisik, 1, ',', '.') }}%</span>
                        </div>
                        <div class="progress" style="height: 12px; background: #edf2f9; border-radius: 999px;" role="progressbar" aria-valuenow="{{ $persentaseFisik }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{ $persentaseFisik }}%; background: linear-gradient(90deg, #4f46e5, #6276ff); border-radius: 999px;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-secondary mt-3">
                            <span>Rencana: <strong>{{ number_format($totalRencanaFisik, 2, ',', '.') }}%</strong></span>
                            <span>Realisasi: <strong>{{ number_format($totalRealisasiFisik, 2, ',', '.') }}%</strong></span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="rounded-4 border bg-white p-3 h-100" style="border-color: #dfe7f1; min-height: 150px;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-uppercase" style="letter-spacing: .08em; color: #16a34a;">Realisasi Keuangan</span>
                            <span class="badge rounded-pill px-3 py-2 fw-bold" style="background: linear-gradient(135deg, #16a34a, #30c779); color: white;">{{ number_format($persentaseKeuangan, 1, ',', '.') }}%</span>
                        </div>
                        <div class="progress" style="height: 12px; background: #edf2f9; border-radius: 999px;" role="progressbar" aria-valuenow="{{ $persentaseKeuangan }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{ $persentaseKeuangan }}%; background: linear-gradient(90deg, #16a34a, #30c779); border-radius: 999px;"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-secondary mt-3">
                            <span>Rencana: <strong>Rp {{ number_format($totalRencanaKeuangan, 0, ',', '.') }}</strong></span>
                            <span>Realisasi: <strong>Rp {{ number_format($totalRealisasiKeuangan, 0, ',', '.') }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="rounded-4 border bg-white p-3 text-center h-100" style="border-color: #dfe7f1;">
                        <small class="text-uppercase fw-bold d-block mb-2 text-secondary" style="letter-spacing: .08em;">Status Deviasi Fisik</small>
                        <h3 class="mb-1 fw-bold" style="color: #10b981; font-size: clamp(2rem, 2vw, 2.4rem);">
                            {{ $deviasiFisik > 0 ? '+' : '' }}{{ number_format($deviasiFisik, 2, ',', '.') }}%
                        </h3>
                        <small class="text-secondary">{{ $deviasiFisik > 0 ? 'Di atas rencana' : ($deviasiFisik < 0 ? 'Perlu percepatan' : 'Sesuai jadwal') }}</small>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rounded-4 border bg-white p-3 text-center h-100" style="border-color: #dfe7f1;">
                        <small class="text-uppercase fw-bold d-block mb-2 text-secondary" style="letter-spacing: .08em;">Status Deviasi Keuangan</small>
                        <h3 class="mb-1 fw-bold" style="color: #10b981; font-size: clamp(2rem, 2vw, 2.4rem);">
                            {{ $deviasiKeuangan >= 0 ? '+' : '-' }}Rp {{ number_format(abs($deviasiKeuangan), 0, ',', '.') }}
                        </h3>
                        <small class="text-secondary">{{ $deviasiKeuangan >= 0 ? 'Optimal' : 'Sisa Alokasi' }}</small>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rounded-4 border bg-white p-3 text-center h-100" style="border-color: #dfe7f1;">
                        <small class="text-uppercase fw-bold d-block mb-2 text-secondary" style="letter-spacing: .08em;">Total Pagu Kegiatan</small>
                        <h3 class="mb-1 fw-bold" style="color: #0f172a; font-size: clamp(2rem, 2vw, 2.4rem);">
                            Rp {{ number_format($kegiatan->sum('anggaran'), 0, ',', '.') }}
                        </h3>
                        <small class="text-secondary">{{ $kegiatan->count() }} dari {{ $jumlahKegiatan }} kegiatan terbaru</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-3">
        <div class="row g-3 align-items-stretch">
            <div class="col-12 col-xl-6">
                <div class="rounded-4 border p-3 shadow-sm h-100" style="border-color: var(--border); background: linear-gradient(180deg, var(--surface-solid), var(--surface-soft)); min-height: 220px; overflow: hidden; max-width: 100%;">
                    <div class="d-flex justify-content-between align-items-end mb-2 flex-wrap gap-2">
                        <div>
                            <h3 class="h4 mb-1 fw-semibold" style="color: var(--text);">Grafik Per Kegiatan</h3>
                            <small style="color: var(--muted);">Perbandingan rencana dan realisasi</small>
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-wrap" style="font-size: 11px;">
                            <span class="d-inline-flex align-items-center gap-2 fw-semibold" style="color: var(--muted);">
                                <span class="d-inline-block rounded" style="width: 10px; height: 10px; background: linear-gradient(180deg, #4f46e5, #4338ca);"></span>
                                Biru = Progres Fisik
                            </span>
                            <span class="d-inline-flex align-items-center gap-2 fw-semibold" style="color: var(--muted);">
                                <span class="d-inline-block rounded" style="width: 10px; height: 10px; background: linear-gradient(180deg, #22c55e, #16a34a);"></span>
                                Hijau = Realisasi Keuangan
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-end justify-content-start gap-2" style="height: 150px; overflow: hidden; padding-left: 2px; padding-right: 2px;">
                        @foreach ($activityItems as $activity)
                            @php
                                $barHeight = max(18, min(100, $activity['fisik'] * 0.85));
                                $keuanganHeight = max(18, min(100, $activity['keuangan'] * 0.85));
                            @endphp
                            <div class="d-flex flex-column align-items-center justify-content-end" style="width: 54px; min-width: 54px; flex: 0 0 54px;">
                                <div class="d-flex align-items-end justify-content-center gap-1" style="height: 96px; width: 100%;">
                                    <div style="width: 9px; height: {{ $barHeight }}%; background: linear-gradient(180deg, #4f46e5, #4338ca); opacity: 0.95; box-shadow: 0 6px 12px -8px rgba(79, 70, 229, 0.9); border-radius: 999px 999px 0 0; min-height: 22px;"></div>
                                    <div style="width: 9px; height: {{ $keuanganHeight }}%; background: linear-gradient(180deg, #22c55e, #16a34a); opacity: 0.95; box-shadow: 0 6px 12px -8px rgba(34, 197, 94, 0.9); border-radius: 999px 999px 0 0; min-height: 22px;"></div>
                                </div>
                                <div class="text-center mt-2" style="font-size: 10px; color: var(--muted); line-height: 1.2;">
                                    <div class="fw-semibold mb-1" style="max-width: 100%; word-break: break-word; color: var(--text);">{{ $activity['kode'] }}</div>
                                    <div style="max-width: 100%; word-break: break-word;">{{ $activity['nama'] }}</div>
                                    <div>{{ number_format($activity['fisik'], 0, ',', '.') }}%</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="rounded-4 border p-2 shadow-sm h-100" style="border-color: var(--border); background: linear-gradient(180deg, var(--surface-solid), var(--surface-soft)); min-height: 220px; overflow: hidden; max-width: 100%;">
                    <div class="mb-2">
                        <h3 class="h5 mb-1 fw-semibold" style="color: var(--text);">Ringkasan Per Kegiatan</h3>
                        <small style="color: var(--muted);">Rencana, realisasi, dan deviasi</small>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0" style="font-size: 11px;">
                            <thead>
                                <tr class="text-secondary">
                                    <th class="px-0 pb-2" style="white-space: nowrap;">KEGIATAN</th>
                                    <th class="px-1 pb-2 text-center" style="white-space: nowrap;">RENCANA</th>
                                    <th class="px-1 pb-2 text-center" style="white-space: nowrap;">REALISASI</th>
                                    <th class="px-1 pb-2 text-center" style="white-space: nowrap;">DEVIASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($activityItems as $activity)
                                    <tr>
                                        <td class="px-0 py-1 fw-semibold text-dark" style="white-space: normal; word-break: break-word;">
                                            <div class="fw-bold text-primary small">{{ $activity['kode'] }}</div>
                                            <div>{{ $activity['nama'] }}</div>
                                        </td>
                                        <td class="px-1 py-1 text-center">{{ number_format(min(100, max(0, $activity['fisik'])), 0, ',', '.') }}%</td>
                                        <td class="px-1 py-1 text-center">{{ number_format(min(100, max(0, $activity['keuangan'])), 0, ',', '.') }}%</td>
                                        <td class="px-1 py-1 text-center {{ $activity['deviasi'] >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $activity['deviasi'] >= 0 ? '+' : '' }}{{ number_format($activity['deviasi'], 0, ',', '.') }}%
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
