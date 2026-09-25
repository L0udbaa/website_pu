@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- Catatan: Pindahkan logika mapping $summaryRows di bawah ini ke Controller untuk praktik terbaik --}}
    @php
        $summaryRows = $kegiatan->take(5)->map(function ($item) {
            $latestFisik = $item->progresFisik->sortByDesc('id')->first();
            $latestKeuangan = $item->progresKeuangan->sortByDesc('id')->first();

            $rencana = $latestFisik ? (float) $latestFisik->rencana_fisik : 0;
            $kemajuan = $latestFisik ? (float) $latestFisik->realisasi_fisik : 0;
            $deviasi = $kemajuan - $rencana;
            $nilai = $latestKeuangan ? (float) $latestKeuangan->realisasi_keuangan : 0;

            return [
                'nama' => $item->nama_kegiatan,
                'kode' => $item->kode_kegiatan ?: 'PKG',
                'rencana' => $rencana,
                'kemajuan' => $kemajuan,
                'deviasi' => $deviasi,
                'nilai' => $nilai,
                'detail_url' => route('kegiatan.edit', $item),
            ];
        });
    @endphp

    <div class="dashboard-ux-page container mx-auto max-w-7xl px-4 py-6">
        
       <!-- BANNER HEADER SESUAI HALAMAN PROGRES FISIK -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white mb-6 shadow-lg flex items-center justify-between">
    <div class="flex items-center gap-4">
        <!-- Ikon Banner -->
        <div class="p-3 bg-white/20 backdrop-blur-md rounded-xl">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
        </div>
        <div>
            <span class="text-xs font-bold tracking-wider uppercase opacity-80">MONITORING</span>
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p class="text-xs opacity-90 mt-0.5">Ringkasan indikator dan progres kegiatan.</p>
        </div>
    </div>

    <!-- Tombol Edit Dashboard -->
    <a href=" route('#') " class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white border border-white/30 rounded-xl text-xs font-semibold backdrop-blur-md transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
        <span>Edit Dashboard</span>
    </a>
</div>

        <div class="dashboard-ux-layout dashboard-ux-layout-simple w-full">
            <main class="dashboard-ux-main w-full">
                <!-- KPI Section -->
                <section class="dashboard-ux-kpis grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8" aria-label="Ringkasan indikator">
                    <article class="dashboard-ux-kpi-card card p-4 flex flex-col justify-between">
                        <span class="dashboard-ux-kpi-label text-xs uppercase tracking-wider opacity-75">Jumlah Paket</span>
                        <strong class="text-3xl font-extrabold my-1">{{ number_format($jumlahKegiatan, 0, ',', '.') }}</strong>
                        <small class="text-xs opacity-60">paket</small>
                    </article>

                    <article class="dashboard-ux-kpi-card primary card p-4 flex flex-col justify-between">
                        <span class="dashboard-ux-kpi-label text-xs uppercase tracking-wider opacity-75">% Progress Fisik</span>
                        <strong class="text-3xl font-extrabold my-1">{{ number_format($persentaseFisik, 1, ',', '.') }}%</strong>
                        <small class="text-xs opacity-60">Target Fisik</small>
                    </article>

                    <article class="dashboard-ux-kpi-card success card p-4 flex flex-col justify-between">
                        <span class="dashboard-ux-kpi-label text-xs uppercase tracking-wider opacity-75">% Keuangan</span>
                        <strong class="text-3xl font-extrabold my-1">{{ number_format($persentaseKeuangan, 1, ',', '.') }}%</strong>
                        <small class="text-xs opacity-60">Realisasi Keuangan</small>
                    </article>

                    <a href="{{ route('rekapitulasi.index') }}" class="dashboard-ux-kpi-card link-card card p-4 flex flex-col justify-between hover:scale-[1.02] transition-transform" target="_blank" rel="noopener noreferrer">
                        <span class="dashboard-ux-kpi-label text-xs uppercase tracking-wider opacity-75">Nilai Uang Muka / Progres</span>
                        <strong class="text-xl font-bold my-1 text-emerald-400">Rp {{ number_format($totalRealisasiKeuangan, 0, ',', '.') }}</strong>
                        <small class="text-xs opacity-60">Detail per paket</small>
                    </a>

                    <article class="dashboard-ux-kpi-card muted card p-4 flex flex-col justify-between">
                        <span class="dashboard-ux-kpi-label text-xs uppercase tracking-wider opacity-75">Ringkasan Tambahan</span>
                        <strong class="text-3xl font-extrabold my-1">{{ number_format($kegiatan->count(), 0, ',', '.') }}</strong>
                        <small class="text-xs opacity-60">kegiatan aktif</small>
                    </article>
                </section>

                <!-- Bottom Section: Chart & Table -->
                <section class="dashboard-ux-bottom-grid grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    <!-- Chart Panel -->
                    <article class="dashboard-ux-chart-panel card p-5 lg:col-span-5">
                        <div class="dashboard-ux-panel-head flex justify-between items-center mb-4">
                            <div>
                                <p class="eyebrow text-xs uppercase text-indigo-400 font-semibold">Target vs Realisasi</p>
                                <h3 class="text-lg font-bold">Kurva</h3>
                            </div>
                            <div class="dashboard-ux-chart-legend flex gap-3 text-xs">
                                <span class="flex items-center gap-1"><i class="legend-dot target w-2 h-2 rounded-full bg-indigo-500 inline-block"></i>Target</span>
                                <span class="flex items-center gap-1"><i class="legend-dot actual w-2 h-2 rounded-full bg-emerald-400 inline-block"></i>Aktual</span>
                            </div>
                        </div>

                        <div class="dashboard-ux-chart-wrap w-full overflow-hidden" role="img" aria-label="Grafik kurva-S target dan realisasi paket 1 sampai 7">
                            <svg viewBox="0 0 600 260" preserveAspectRatio="none" class="w-full h-auto" aria-hidden="true">
                                <defs>
                                    <linearGradient id="actualLineGradient" x1="0%" x2="100%" y1="0%" y2="0%">
                                        <stop offset="0%" stop-color="#60a5fa"/>
                                        <stop offset="100%" stop-color="#34d399"/>
                                    </linearGradient>
                                </defs>
                                <g class="dashboard-ux-grid-lines stroke-slate-700/40" stroke-width="1">
                                    <line x1="32" y1="20" x2="570" y2="20"/>
                                    <line x1="32" y1="78" x2="570" y2="78"/>
                                    <line x1="32" y1="136" x2="570" y2="136"/>
                                    <line x1="32" y1="194" x2="570" y2="194"/>
                                    <line x1="32" y1="240" x2="570" y2="240"/>
                                </g>
                                <path d="M32 210 C110 180, 150 168, 200 140 S290 80, 340 90 S420 100, 470 74 S540 40, 570 28" fill="none" stroke="#818cf8" stroke-width="3" class="dashboard-ux-target-line"/>
                                <path d="M32 215 C110 200, 150 192, 200 170 S290 120, 340 120 S420 98, 470 62 S540 44, 570 32" fill="none" stroke="url(#actualLineGradient)" stroke-width="3" class="dashboard-ux-actual-line"/>
                                <g class="dashboard-ux-points fill-emerald-400">
                                    <circle cx="32" cy="215" r="4"/>
                                    <circle cx="122" cy="198" r="4"/>
                                    <circle cx="198" cy="170" r="4"/>
                                    <circle cx="310" cy="118" r="4"/>
                                    <circle cx="395" cy="100" r="4"/>
                                    <circle cx="470" cy="62" r="4"/>
                                    <circle cx="570" cy="32" r="4"/>
                                </g>
                                <g class="dashboard-ux-axis-labels fill-slate-400 text-xs">
                                    <text x="32" y="258">1</text>
                                    <text x="122" y="258">2</text>
                                    <text x="198" y="258">3</text>
                                    <text x="310" y="258">4</text>
                                    <text x="395" y="258">5</text>
                                    <text x="470" y="258">6</text>
                                    <text x="570" y="258">7</text>
                                </g>
                            </svg>
                        </div>
                    </article>

                    <!-- Table Panel -->
                    <article class="dashboard-ux-table-panel card p-5 lg:col-span-7">
                        <div class="dashboard-ux-panel-head table-head mb-4">
                            <div>
                                <p class="eyebrow text-xs uppercase text-indigo-400 font-semibold">Progress paket</p>
                                <h3 class="text-lg font-bold">Rekapan Progress</h3>
                            </div>
                        </div>

                        <div class="dashboard-ux-table-wrap overflow-x-auto">
                            <table class="table w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-700/50 text-xs uppercase tracking-wider text-slate-400">
                                        <th class="py-3 px-2">Kegiatan</th>
                                        <th class="py-3 px-2">Rencana</th>
                                        <th class="py-3 px-2">Kemajuan</th>
                                        <th class="py-3 px-2">Deviasi</th>
                                        <th class="py-3 px-2">Uang / Nilai</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/30 text-sm">
                                    @forelse ($summaryRows as $row)
                                        <tr class="hover:bg-slate-800/40 transition-colors">
                                            <td class="py-3 px-2">
                                                <a href="{{ $row['detail_url'] }}" target="_blank" rel="noopener noreferrer" class="row-link font-medium hover:underline">
                                                    {{ $row['nama'] }}
                                                </a>
                                            </td>
                                            <td class="py-3 px-2">{{ number_format($row['rencana'], 1, ',', '.') }}%</td>
                                            <td class="py-3 px-2">{{ number_format($row['kemajuan'], 1, ',', '.') }}%</td>
                                            <td class="py-3 px-2 font-semibold {{ $row['deviasi'] >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ $row['deviasi'] >= 0 ? '+' : '' }}{{ number_format($row['deviasi'], 1, ',', '.') }}%
                                            </td>
                                            <td class="py-3 px-2">Rp {{ number_format($row['nilai'], 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-6 text-slate-400">Belum ada data kegiatan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </article>
                </section>
            </main>
        </div>
    </div>
@endsection