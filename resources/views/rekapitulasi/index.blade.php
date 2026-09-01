@extends('layouts.app')

@section('title', 'Dashboard Rekapitulasi')

@section('content')

    <div class="rekap-dashboard">

        {{-- ==============================
         JUDUL
    =============================== --}}
        <h1 class="h3 mb-3">Dashboard Rekapitulasi</h1>

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

                    <select name="kegiatan_id" id="kegiatan_id" class="form-select rekap-input">
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

    </div>


    {{-- ==============================
     STYLE
=============================== --}}
    <style>
        .rekap-dashboard {
            max-width: 1100px;
        }

        .rekap-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 2px rgba(16, 24, 40, .04);
            border: 1px solid #eef0f4;
        }

        .rekap-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 1.05rem;
            color: #1f2937;
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
            color: #6b7280;
            margin-bottom: 6px;
        }

        .rekap-input {
            border-radius: 10px;
            border-color: #e5e7eb;
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
            color: #111827;
        }

        .rekap-card-subheading {
            font-size: .85rem;
            color: #6b7280;
        }

        .rekap-stat-table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #eef0f4;
        }

        .rekap-stat-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding: 14px 18px;
        }

        .rekap-stat-head {
            background: #f9fafb;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #eef0f4;
        }

        .rekap-stat-head div {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .rekap-value {
            font-size: 1.15rem;
            font-weight: 700;
            color: #111827;
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
