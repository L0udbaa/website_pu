@extends('layouts.app')

@section('title', 'Rekap Progres')

@section('content')

    <div class="rekap-dashboard">

        {{-- ==============================
         JUDUL
    =============================== --}}
        <h1 class="h3 mb-3">Rekap Progres</h1>

        {{-- ==============================
         FILTER
    =============================== --}}
        <div class="rekap-card mb-3">

            <div class="rekap-card-title">
                <i class="bi bi-funnel-fill" aria-hidden="true"></i>
                <span>Filter Rekapitulasi</span>
            </div>

            <form action="{{ route('rekapitulasi.index') }}" method="GET" class="row g-3 align-items-end mt-1">

                {{-- Kegiatan --}}
                <div class="col-md-4">

                    <label class="rekap-label" for="kegiatan_id">
                        <i class="bi bi-list-ul" aria-hidden="true"></i>
                        Kegiatan
                    </label>

                    <select name="kegiatan_id" id="kegiatan_id" class="form-select rekap-input" onchange="this.form.submit()">
                        <option value="">Semua Kegiatan</option>

                        @foreach ($kegiatanList as $kg)
                            <option value="{{ $kg->id }}"
                                {{ (string) $kegiatanId === (string) $kg->id ? 'selected' : '' }}>
                                {{ $kg->kode_kegiatan }} — {{ $kg->nama_kegiatan }}
                            </option>
                        @endforeach
                    </select>

                </div>

                {{-- Tanggal Awal --}}
                <div class="col-md-3">

                    <label class="rekap-label" for="tanggal_awal">
                        <i class="bi bi-calendar-event" aria-hidden="true"></i>
                        Tanggal Awal
                    </label>

                    <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control rekap-input"
                        value="{{ $tanggalAwal }}">

                </div>

                {{-- Tanggal Akhir --}}
                <div class="col-md-3">

                    <label class="rekap-label" for="tanggal_akhir">
                        <i class="bi bi-calendar-check" aria-hidden="true"></i>
                        Tanggal Akhir
                    </label>

                    <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control rekap-input"
                        value="{{ $tanggalAkhir }}">

                </div>

                {{-- Tombol --}}
                <div class="col-md-2">

                    <button type="submit" class="btn rekap-btn-primary w-100">
                        <i class="bi bi-search" aria-hidden="true"></i>
                        Tampilkan
                    </button>

                </div>

            </form>

        </div>


        {{-- ==============================
         REKAP PROGRES FISIK
    =============================== --}}
        <div class="rekap-card mb-3">

            <div class="rekap-card-header">

                <div class="rekap-icon-box rekap-icon-purple">
                    <i class="bi bi-bricks" aria-hidden="true"></i>
                </div>

                <div>
                    <div class="rekap-card-heading">
                        Rekap Progres Fisik
                    </div>

                    <div class="rekap-card-subheading">
                        Ringkasan capaian fisik proyek
                    </div>
                </div>

            </div>


            <div class="rekap-stat-table">

                {{-- Header --}}
                <div class="rekap-stat-row rekap-stat-head">

                    <div>
                        <i class="bi bi-bullseye" aria-hidden="true"></i>
                        Total Rencana
                    </div>

                    <div>
                        <i class="bi bi-graph-up" aria-hidden="true"></i>
                        Total Realisasi
                    </div>

                    <div>
                        <i class="bi bi-arrow-left-right" aria-hidden="true"></i>
                        Total Deviasi
                    </div>

                </div>


                {{-- Nilai --}}
                <div class="rekap-stat-row">

                    <div class="rekap-value">
                        {{ number_format($totalRencanaFisik, 2, ',', '.') }}%
                    </div>

                    <div class="rekap-value rekap-value-blue">
                        {{ number_format($totalRealisasiFisik, 2, ',', '.') }}%
                    </div>

                    <div>

                        <span class="rekap-pill {{ $deviasiFisik < 0 ? 'rekap-pill-danger' : 'rekap-pill-success' }}">

                            <i class="bi {{ $deviasiFisik < 0 ? 'bi-graph-down-arrow' : 'bi-graph-up-arrow' }}"
                                aria-hidden="true"></i>

                            {{ $deviasiFisik >= 0 ? '+' : '' }}{{ number_format($deviasiFisik, 2, ',', '.') }}%

                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ==============================
         REKAP PROGRES KEUANGAN
    =============================== --}}
        <div class="rekap-card">

            <div class="rekap-card-header">

                <div class="rekap-icon-box rekap-icon-green">
                    <i class="bi bi-cash-coin" aria-hidden="true"></i>
                </div>

                <div>
                    <div class="rekap-card-heading">
                        Rekap Progres Keuangan
                    </div>

                    <div class="rekap-card-subheading">
                        Ringkasan anggaran dan realisasi keuangan
                    </div>
                </div>

            </div>


            <div class="rekap-stat-table">

                {{-- Header --}}
                <div class="rekap-stat-row rekap-stat-head">

                    <div>
                        <i class="bi bi-wallet2" aria-hidden="true"></i>
                        Total Rencana
                    </div>

                    <div>
                        <i class="bi bi-credit-card" aria-hidden="true"></i>
                        Total Realisasi
                    </div>

                    <div>
                        <i class="bi bi-bar-chart" aria-hidden="true"></i>
                        Total Deviasi
                    </div>

                </div>


                {{-- Nilai --}}
                <div class="rekap-stat-row">

                    <div class="rekap-value">
                        Rp {{ number_format($totalRencanaKeuangan, 0, ',', '.') }}
                    </div>

                    <div class="rekap-value rekap-value-green">
                        Rp {{ number_format($totalRealisasiKeuangan, 0, ',', '.') }}
                    </div>

                    <div>

                        <span class="rekap-pill {{ $deviasiKeuangan < 0 ? 'rekap-pill-danger' : 'rekap-pill-success' }}">

                            <i class="bi {{ $deviasiKeuangan < 0 ? 'bi-dash-circle' : 'bi-plus-circle' }}"
                                aria-hidden="true"></i>

                            {{ $deviasiKeuangan >= 0 ? '+' : '-' }}
                            Rp {{ number_format(abs($deviasiKeuangan), 0, ',', '.') }}

                        </span>

                    </div>

                </div>

            </div>

        </div>

        @if ($selectedKegiatan)
            <div class="rekap-card mb-3 mt-3">
                <div class="rekap-card-header">
                    <div class="rekap-icon-box rekap-icon-purple">
                        <i class="bi bi-activity" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="rekap-card-heading">
                            Detail Progres Fisik: {{ $selectedKegiatan->kode_kegiatan }}
                        </div>
                        <div class="rekap-card-subheading">
                            {{ $selectedKegiatan->nama_kegiatan }}
                        </div>
                    </div>
                </div>

                @if ($detailFisik->isNotEmpty())
                    @php
                        $totalRencanaFisikDetail = $detailFisik->sum('rencana_fisik');
                        $totalRealisasiFisikDetail = $detailFisik->sum('realisasi_fisik');
                        $totalDeviasiFisikDetail = $totalRealisasiFisikDetail - $totalRencanaFisikDetail;
                        $rencanaPersenTotalFisik = $detailFisik->avg('rencana_fisik');
                        $realisasiPersenTotalFisik = $detailFisik->avg('realisasi_fisik');
                        $tanggalRencanaFisikTotal = $detailFisik->max('tanggal_rencana');
                        $tanggalRealisasiFisikTotal = $detailFisik->max('tanggal_realisasi');
                    @endphp
                    <div class="table-responsive mt-3">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal Rencana</th>
                                    <th>Rencana (%)</th>
                                    <th>Tanggal Realisasi</th>
                                    <th>Realisasi (%)</th>
                                    <th>Deviasi (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailFisik as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_rencana ? \Carbon\Carbon::parse($item->tanggal_rencana)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ number_format($item->rencana_fisik, 2, ',', '.') }}%</td>
                                        <td>{{ $item->tanggal_realisasi ? \Carbon\Carbon::parse($item->tanggal_realisasi)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ number_format($item->realisasi_fisik, 2, ',', '.') }}%</td>
                                        <td>
                                            <span class="badge {{ $item->deviasi_fisik < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                                {{ $item->deviasi_fisik >= 0 ? '+' : '' }}{{ number_format($item->deviasi_fisik, 2, ',', '.') }}%
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-total-row">
                                    <td class="fw-bold text-dark">Total</td>
                                    <td class="fw-bold text-dark">{{ number_format($rencanaPersenTotalFisik, 2, ',', '.') }}%</td>
                                    <td class="fw-bold text-dark">{{ $tanggalRencanaFisikTotal ? \Carbon\Carbon::parse($tanggalRencanaFisikTotal)->format('d-m-Y') : '-' }}</td>
                                    <td class="fw-bold text-dark">{{ number_format($realisasiPersenTotalFisik, 2, ',', '.') }}%</td>
                                    <td>
                                        <span class="badge {{ $totalDeviasiFisikDetail < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                            {{ $totalDeviasiFisikDetail >= 0 ? '+' : '' }}{{ number_format($totalDeviasiFisikDetail, 2, ',', '.') }}%
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0 mt-3">Belum ada data progres fisik untuk kegiatan ini.</p>
                @endif
            </div>

            <div class="rekap-card mt-3">
                <div class="rekap-card-header">
                    <div class="rekap-icon-box rekap-icon-green">
                        <i class="bi bi-wallet2" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="rekap-card-heading">
                            Detail Progres Keuangan: {{ $selectedKegiatan->kode_kegiatan }}
                        </div>
                        <div class="rekap-card-subheading">
                            {{ $selectedKegiatan->nama_kegiatan }}
                        </div>
                    </div>
                </div>

                @if ($detailKeuangan->isNotEmpty())
                    @php
                        $totalNilaiKontrakDetail = $detailKeuangan->sum('nilai_kontrak');
                        $totalRencanaKeuanganDetail = $detailKeuangan->sum('rencana_keuangan');
                        $totalRealisasiKeuanganDetail = $detailKeuangan->sum('realisasi_keuangan');
                        $totalDeviasiKeuanganDetail = $totalRealisasiKeuanganDetail - $totalRencanaKeuanganDetail;
                        $rencanaPersenTotalKeuangan = $detailKeuangan->avg('rencana_persen');
                        $realisasiPersenTotalKeuangan = $detailKeuangan->avg('realisasi_persen');
                        $tanggalRencanaKeuanganTotal = $detailKeuangan->max('tanggal_rencana');
                        $tanggalRealisasiKeuanganTotal = $detailKeuangan->max('tanggal_realisasi');
                    @endphp
                    <div class="table-responsive mt-3">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal Rencana</th>
                                    <th>Rencana (%)</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Tanggal Realisasi</th>
                                    <th>Realisasi (%)</th>
                                    <th>Rencana (Rp)</th>
                                    <th>Realisasi (Rp)</th>
                                    <th>Deviasi (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailKeuangan as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_rencana ? \Carbon\Carbon::parse($item->tanggal_rencana)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ number_format($item->rencana_persen, 2, ',', '.') }}%</td>
                                        <td>Rp {{ number_format($item->nilai_kontrak, 0, ',', '.') }}</td>
                                        <td>{{ $item->tanggal_realisasi ? \Carbon\Carbon::parse($item->tanggal_realisasi)->format('d-m-Y') : '-' }}</td>
                                        <td>{{ number_format($item->realisasi_persen, 2, ',', '.') }}%</td>
                                        <td>Rp {{ number_format($item->rencana_keuangan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->realisasi_keuangan, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge {{ $item->deviasi_keuangan < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                                Rp {{ number_format($item->deviasi_keuangan, 0, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="table-total-row">
                                    <td class="fw-bold text-dark">
                                        <span class="total-label">Total</span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ number_format($rencanaPersenTotalKeuangan, 2, ',', '.') }}%</td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($totalNilaiKontrakDetail, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-dark">-</td>
                                    <td class="fw-bold text-dark">{{ number_format($realisasiPersenTotalKeuangan, 2, ',', '.') }}%</td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($totalRencanaKeuanganDetail, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-dark">Rp {{ number_format($totalRealisasiKeuanganDetail, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $totalDeviasiKeuanganDetail < 0 ? 'text-bg-danger' : 'text-bg-success' }}">
                                            Rp {{ number_format($totalDeviasiKeuanganDetail, 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0 mt-3">Belum ada data progres keuangan untuk kegiatan ini.</p>
                @endif
            </div>
        @endif

    </div>


    {{-- ==============================
     STYLE
=============================== --}}
    <style>
        .rekap-dashboard {
            width: 100%;
        }

        .rekap-card {
            background: var(--admin-surface);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 2px rgba(16, 24, 40, .04);
            border: 1px solid var(--admin-border);
        }

        .rekap-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--admin-text);
        }

        .rekap-card-title i {
            color: #4f46e5;
        }

        .rekap-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 600;
            color: var(--admin-muted);
            margin-bottom: 6px;
        }

        .rekap-input {
            border-radius: 10px;
            border-color: var(--admin-border);
            background-color: var(--admin-surface);
            color: var(--admin-text);
            padding: .55rem .75rem;
        }

        .rekap-input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 .2rem rgba(79, 70, 229, .12);
        }

        .rekap-btn-primary {
            background: #4f46e5;
            color: #fff;
            border-radius: 10px;
            padding: .55rem 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: none;
        }

        .rekap-btn-primary:hover {
            background: #4338ca;
            color: #fff;
        }

        .table-total-row {
            background: #edf6ef;
            border-top: 2px solid #cfe7d6;
        }

        .table-total-row td {
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
            font-weight: 700;
            color: #1f2937;
        }

        .total-label {
            display: inline-block;
            margin-bottom: 0.25rem;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #047857;
            font-weight: 800;
        }

        .rekap-card-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .rekap-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .rekap-icon-purple {
            background: #ede9fe;
            color: #6d28d9;
        }

        .rekap-icon-green {
            background: #d1fae5;
            color: #047857;
        }

        .rekap-card-heading {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--admin-text);
        }

        .rekap-card-subheading {
            font-size: .85rem;
            color: var(--admin-muted);
        }

        .rekap-stat-table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--admin-border);
        }

        .rekap-stat-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 14px 18px;
        }

        .rekap-stat-head {
            background: var(--admin-surface-soft);
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: var(--admin-muted);
            border-bottom: 1px solid var(--admin-border);
        }

        .rekap-stat-head div {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rekap-value {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--admin-text);
        }

        .rekap-value-blue {
            color: #2563eb;
        }

        .rekap-value-green {
            color: #059669;
        }

        .rekap-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 999px;
            font-weight: 700;
            font-size: .85rem;
        }

        .rekap-pill-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .rekap-pill-success {
            background: #d1fae5;
            color: #059669;
        }

        @media (max-width: 640px) {

            .rekap-dashboard {
                width: 100%;
            }

            .rekap-card {
                padding: 16px;
            }

            .rekap-stat-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .rekap-stat-head {
                gap: 10px;
            }

            .rekap-stat-head div {
                padding-bottom: 4px;
            }

            .rekap-value {
                margin-bottom: 4px;
            }

        }
    </style>

@endsection
