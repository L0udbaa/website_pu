@php
    $item = $item ?? null;
    $selectedKegiatan = $kegiatan ?? null;
    $currentKegiatanId = old('kegiatan_id', $item->kegiatan_id ?? $selectedKegiatan?->id);
@endphp

<div class="row g-3">
    {{-- Kegiatan --}}
    <div class="col-12">
        <label class="form-label" for="kegiatan_id">Kegiatan</label>
        <select name="kegiatan_id" id="kegiatan_id" class="form-select @error('kegiatan_id') is-invalid @enderror"
            {{ $selectedKegiatan && !$item ? 'disabled' : '' }} required>
            <option value="">-- Pilih Kegiatan --</option>
            @foreach ($kegiatanList as $kg)
                <option value="{{ $kg->id }}" {{ (int) $currentKegiatanId === $kg->id ? 'selected' : '' }}>
                    {{ $kg->kode_kegiatan }} — {{ $kg->nama_kegiatan }}
                </option>
            @endforeach
        </select>
        @if ($selectedKegiatan && !$item)
            <input type="hidden" name="kegiatan_id" value="{{ $selectedKegiatan->id }}">
        @endif
        @error('kegiatan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Nilai Kontrak | Rencana % | Rencana Rp (readonly) --}}
    <div class="col-md-4">
        <label class="form-label" for="nilai_kontrak">Nilai Kontrak</label>
        <input type="number" step="0.01" name="nilai_kontrak" id="nilai_kontrak"
            class="form-control @error('nilai_kontrak') is-invalid @enderror" placeholder="Contoh: 100.000.000"
            value="{{ old('nilai_kontrak', $item->nilai_kontrak ?? '') }}" required>
        @error('nilai_kontrak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="rencana_persen">Rencana (%)</label>
        <div class="input-group">
            <input type="number" step="0.01" min="0" max="100" name="rencana_persen" id="rencana_persen"
                class="form-control @error('rencana_persen') is-invalid @enderror" placeholder="Contoh: 40"
                value="{{ old('rencana_persen', $item->rencana_persen ?? '') }}" required>
            <span class="input-group-text">%</span>
        </div>
        @error('rencana_persen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="rencana_keuangan_display">Rencana (Rp)</label>
        <input type="text" id="rencana_keuangan_display" class="form-control bg-light" value="Rp 0" readonly
            tabindex="-1">
    </div>

    {{-- Tanggal Rencana | Tanggal Realisasi --}}
    <div class="col-md-6">
        <label class="form-label" for="tanggal_rencana">Tanggal Rencana</label>
        <input type="date" name="tanggal_rencana" id="tanggal_rencana"
            class="form-control @error('tanggal_rencana') is-invalid @enderror"
            value="{{ old('tanggal_rencana', $item?->tanggal_rencana ? \Carbon\Carbon::parse($item->tanggal_rencana)->format('Y-m-d') : '') }}"
            required>
        @error('tanggal_rencana')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="tanggal_realisasi">Tanggal Realisasi</label>
        <input type="date" name="tanggal_realisasi" id="tanggal_realisasi"
            class="form-control @error('tanggal_realisasi') is-invalid @enderror"
            value="{{ old('tanggal_realisasi', $item?->tanggal_realisasi ? \Carbon\Carbon::parse($item->tanggal_realisasi)->format('Y-m-d') : '') }}">
        @error('tanggal_realisasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Realisasi % | Realisasi Rp | Deviasi Rp (readonly) --}}
    <div class="col-md-4">
        <label class="form-label" for="realisasi_persen">Realisasi (%)</label>
        <div class="input-group">
            <input type="number" step="0.01" min="0" max="100" name="realisasi_persen"
                id="realisasi_persen" class="form-control @error('realisasi_persen') is-invalid @enderror"
                placeholder="Contoh: 35" value="{{ old('realisasi_persen', $item->realisasi_persen ?? '') }}">
            <span class="input-group-text">%</span>
        </div>
        @error('realisasi_persen')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="realisasi_keuangan">Realisasi (Rp)</label>
        <input type="number" step="0.01" name="realisasi_keuangan" id="realisasi_keuangan"
            class="form-control @error('realisasi_keuangan') is-invalid @enderror" placeholder="Contoh: 35.000.000"
            value="{{ old('realisasi_keuangan', $item->realisasi_keuangan ?? '') }}">
        @error('realisasi_keuangan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="deviasi_keuangan_display">Deviasi (Rp)</label>
        <input type="text" id="deviasi_keuangan_display" class="form-control bg-light" value="Rp 0" readonly
            tabindex="-1">
    </div>
</div>

{{-- Catatan rumus --}}
<div class="alert alert-info mt-4 mb-0" role="note">
    <div class="fw-semibold mb-2"><i class="bi bi-calculator" aria-hidden="true"></i> Perhitungan otomatis</div>
    <ul class="mb-2 ps-3 small">
        <li>Rencana (Rp) = Nilai Kontrak × Rencana (%) ÷ 100</li>
        <li>Deviasi = Realisasi (Rp) − Rencana (Rp)</li>
    </ul>
    <div class="small">
        Rencana: <strong id="preview_rencana">Rp 0</strong>
        &nbsp;|&nbsp;
        Deviasi: <strong id="preview_deviasi">Rp 0</strong>
    </div>
</div>

<script>
    (function() {
        const nilaiKontrak = document.getElementById('nilai_kontrak');
        const rencanaPersen = document.getElementById('rencana_persen');
        const realisasiKeuangan = document.getElementById('realisasi_keuangan');

        const rencanaDisplay = document.getElementById('rencana_keuangan_display');
        const deviasiDisplay = document.getElementById('deviasi_keuangan_display');
        const previewRencana = document.getElementById('preview_rencana');
        const previewDeviasi = document.getElementById('preview_deviasi');

        function formatRupiah(angka) {
            const bulat = Math.round(angka || 0);
            return 'Rp ' + bulat.toLocaleString('id-ID');
        }

        function hitungPreview() {
            const kontrak = parseFloat(nilaiKontrak.value) || 0;
            const persen = parseFloat(rencanaPersen.value) || 0;
            const realisasi = parseFloat(realisasiKeuangan.value) || 0;

            const rencana = (kontrak * persen) / 100;
            const deviasi = realisasi - rencana;

            const rencanaText = formatRupiah(rencana);
            const deviasiText = formatRupiah(deviasi);

            rencanaDisplay.value = rencanaText;
            deviasiDisplay.value = deviasiText;
            previewRencana.textContent = rencanaText;
            previewDeviasi.textContent = deviasiText;

            [deviasiDisplay, previewDeviasi].forEach(function(el) {
                el.classList.toggle('text-danger', deviasi < 0);
                el.classList.toggle('text-success', deviasi >= 0);
            });
        }

        [nilaiKontrak, rencanaPersen, realisasiKeuangan].forEach(function(el) {
            el.addEventListener('input', hitungPreview);
        });

        hitungPreview();
    })();
</script>
