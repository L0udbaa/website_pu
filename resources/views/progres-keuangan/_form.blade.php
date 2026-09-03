@php
    $item = $item ?? null;
    $selectedKegiatan = $kegiatan ?? null;
    $currentKegiatanId = old('kegiatan_id', $item->kegiatan_id ?? $selectedKegiatan?->id);

    // Nilai awal untuk input uang
    $nilaiKontrakAwal = old('nilai_kontrak', $item->nilai_kontrak ?? '');
    $realisasiKeuanganAwal = old('realisasi_keuangan', $item->realisasi_keuangan ?? '');

    // Format angka uang Indonesia
    $formatInputUang = function ($nilai) {
        if ($nilai === null || $nilai === '') {
            return '';
        }

        $nilai = (float) $nilai;

        if (floor($nilai) == $nilai) {
            return number_format($nilai, 0, ',', '.');
        }

        return number_format($nilai, 2, ',', '.');
    };
@endphp

<div class="row g-3">

    {{-- Kegiatan --}}
    <div class="col-12">
        <label class="form-label" for="kegiatan_id">Kegiatan</label>

        <select name="kegiatan_id"
            id="kegiatan_id"
            class="form-select @error('kegiatan_id') is-invalid @enderror"
            {{ $selectedKegiatan && !$item ? 'disabled' : '' }}
            required>

            <option value="">-- Pilih Kegiatan --</option>

            @foreach ($kegiatanList as $kg)
                <option value="{{ $kg->id }}"
                    {{ (int) $currentKegiatanId === $kg->id ? 'selected' : '' }}>
                    {{ $kg->kode_kegiatan }} — {{ $kg->nama_kegiatan }}
                </option>
            @endforeach
        </select>

        @if ($selectedKegiatan && !$item)
            <input type="hidden"
                name="kegiatan_id"
                value="{{ $selectedKegiatan->id }}">
        @endif

        @error('kegiatan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Nilai Kontrak | Rencana % | Rencana Rp --}}
    <div class="col-md-4">

        <label class="form-label" for="nilai_kontrak">
            Nilai Kontrak
        </label>

        <input type="text"
            name="nilai_kontrak"
            id="nilai_kontrak"
            class="form-control @error('nilai_kontrak') is-invalid @enderror"
            placeholder="Contoh: 100.000.000"
            inputmode="decimal"
            autocomplete="off"
            value="{{ $formatInputUang($nilaiKontrakAwal) }}"
            required>

        @error('nilai_kontrak')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-4">

        <label class="form-label" for="rencana_persen">
            Rencana (%)
        </label>

        <div class="input-group">

            <input type="number"
                step="0.01"
                min="0"
                max="100"
                name="rencana_persen"
                id="rencana_persen"
                class="form-control @error('rencana_persen') is-invalid @enderror"
                placeholder="Contoh: 40"
                value="{{ old('rencana_persen', $item->rencana_persen ?? '') }}"
                required>

            <span class="input-group-text">%</span>

        </div>

        @error('rencana_persen')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-4">

        <label class="form-label" for="rencana_keuangan_display">
            Rencana (Rp)
        </label>

        <input type="text"
            id="rencana_keuangan_display"
            class="form-control bg-light"
            value="Rp 0"
            readonly
            tabindex="-1">

    </div>


    {{-- Tanggal Rencana | Tanggal Realisasi --}}
    <div class="col-md-6">

        <label class="form-label" for="tanggal_rencana">
            Tanggal Rencana
        </label>

        <input type="date"
            name="tanggal_rencana"
            id="tanggal_rencana"
            class="form-control @error('tanggal_rencana') is-invalid @enderror"
            value="{{ old('tanggal_rencana', $item?->tanggal_rencana ? \Carbon\Carbon::parse($item->tanggal_rencana)->format('Y-m-d') : '') }}"
            required>

        @error('tanggal_rencana')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-6">

        <label class="form-label" for="tanggal_realisasi">
            Tanggal Realisasi
        </label>

        <input type="date"
            name="tanggal_realisasi"
            id="tanggal_realisasi"
            class="form-control @error('tanggal_realisasi') is-invalid @enderror"
            value="{{ old('tanggal_realisasi', $item?->tanggal_realisasi ? \Carbon\Carbon::parse($item->tanggal_realisasi)->format('Y-m-d') : '') }}">

        @error('tanggal_realisasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- Realisasi % | Realisasi Rp | Deviasi Rp --}}
    <div class="col-md-4">

        <label class="form-label" for="realisasi_persen">
            Realisasi (%)
        </label>

        <div class="input-group">

            <input type="number"
                step="0.01"
                min="0"
                max="100"
                name="realisasi_persen"
                id="realisasi_persen"
                class="form-control @error('realisasi_persen') is-invalid @enderror"
                placeholder="Contoh: 35"
                value="{{ old('realisasi_persen', $item->realisasi_persen ?? '') }}">

            <span class="input-group-text">%</span>

        </div>

        @error('realisasi_persen')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-4">

        <label class="form-label" for="realisasi_keuangan">
            Realisasi (Rp)
        </label>

        <input type="text"
            name="realisasi_keuangan"
            id="realisasi_keuangan"
            class="form-control @error('realisasi_keuangan') is-invalid @enderror"
            placeholder="Contoh: 35.000.000"
            inputmode="decimal"
            autocomplete="off"
            value="{{ $formatInputUang($realisasiKeuanganAwal) }}">

        @error('realisasi_keuangan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    <div class="col-md-4">

        <label class="form-label" for="deviasi_keuangan_display">
            Deviasi (Rp)
        </label>

        <input type="text"
            id="deviasi_keuangan_display"
            class="form-control bg-light"
            value="Rp 0"
            readonly
            tabindex="-1">

    </div>

</div>


{{-- Catatan rumus --}}
<div class="alert alert-info mt-4 mb-0" role="note">

    <div class="fw-semibold mb-2">
        <i class="bi bi-calculator" aria-hidden="true"></i>
        Perhitungan otomatis
    </div>

    <ul class="mb-2 ps-3 small">
        <li>
            Rencana (Rp) = Nilai Kontrak × Rencana (%) ÷ 100
        </li>

        <li>
            Deviasi = Realisasi (Rp) − Rencana (Rp)
        </li>
    </ul>

    <div class="small">

        Rencana:
        <strong id="preview_rencana">Rp 0</strong>

        &nbsp;|&nbsp;

        Deviasi:
        <strong id="preview_deviasi">Rp 0</strong>

    </div>

</div>


<script>
(function () {

    const nilaiKontrak = document.getElementById('nilai_kontrak');
    const rencanaPersen = document.getElementById('rencana_persen');
    const realisasiKeuangan = document.getElementById('realisasi_keuangan');

    const rencanaDisplay = document.getElementById('rencana_keuangan_display');
    const deviasiDisplay = document.getElementById('deviasi_keuangan_display');

    const previewRencana = document.getElementById('preview_rencana');
    const previewDeviasi = document.getElementById('preview_deviasi');


    /*
     * Mengubah:
     * 1000000
     * menjadi:
     * 1.000.000
     *
     * Dan:
     * 1500000,50
     * menjadi:
     * 1.500.000,50
     */
    function formatUangInput(value) {

        if (!value) {
            return '';
        }

        // Hapus karakter selain angka dan koma
        value = value.toString().replace(/[^\d,]/g, '');

        if (!value) {
            return '';
        }

        // Pisahkan angka dan desimal
        const bagian = value.split(',');

        let angka = bagian[0];

        let desimal = bagian[1] ?? '';

        // Batasi desimal maksimal 2 angka
        desimal = desimal.substring(0, 2);

        // Hapus angka nol di depan
        angka = angka.replace(/^0+(?=\d)/, '');

        // Tambahkan titik setiap 3 angka
        angka = angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        if (desimal.length > 0) {
            return angka + ',' + desimal;
        }

        return angka;
    }


    /*
     * Mengubah angka tampilan Indonesia menjadi angka
     * yang bisa dihitung JavaScript.
     *
     * 1.000.000     -> 1000000
     * 1.500.000,50  -> 1500000.50
     */
    function parseUang(value) {

        if (!value) {
            return 0;
        }

        value = value.toString().trim();

        // Hapus titik pemisah ribuan
        value = value.replace(/\./g, '');

        // Ubah koma desimal menjadi titik
        value = value.replace(',', '.');

        const angka = parseFloat(value);

        return isNaN(angka) ? 0 : angka;
    }


    /*
     * Format hasil perhitungan menjadi Rupiah
     */
    function formatRupiah(angka) {

        angka = Number(angka) || 0;

        return 'Rp ' + angka.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });

    }


    /*
     * Perhitungan otomatis
     */
    function hitungPreview() {

        const kontrak = parseUang(nilaiKontrak.value);

        const persen = parseFloat(rencanaPersen.value) || 0;

        const realisasi = parseUang(realisasiKeuangan.value);


        // Rencana
        const rencana = (kontrak * persen) / 100;


        // Deviasi
        const deviasi = realisasi - rencana;


        const rencanaText = formatRupiah(rencana);

        const deviasiText = formatRupiah(deviasi);


        rencanaDisplay.value = rencanaText;

        deviasiDisplay.value = deviasiText;

        previewRencana.textContent = rencanaText;

        previewDeviasi.textContent = deviasiText;


        // Warna deviasi
        [deviasiDisplay, previewDeviasi].forEach(function (el) {

            el.classList.toggle('text-danger', deviasi < 0);

            el.classList.toggle('text-success', deviasi >= 0);

        });

    }


    /*
     * Format otomatis Nilai Kontrak
     */
    nilaiKontrak.addEventListener('input', function () {

        this.value = formatUangInput(this.value);

        hitungPreview();

    });


    /*
     * Format otomatis Realisasi Keuangan
     */
    realisasiKeuangan.addEventListener('input', function () {

        this.value = formatUangInput(this.value);

        hitungPreview();

    });


    /*
     * Rencana %
     */
    rencanaPersen.addEventListener('input', function () {

        hitungPreview();

    });


    /*
     * Sebelum form dikirim:
     *
     * 1.000.000.000
     * menjadi
     * 1000000000
     *
     * sehingga Laravel/MySQL menerima angka yang benar.
     */
    const form = nilaiKontrak.closest('form');

    if (form) {

        form.addEventListener('submit', function () {

            nilaiKontrak.value = parseUang(nilaiKontrak.value);

            realisasiKeuangan.value = parseUang(realisasiKeuangan.value);

        });

    }


    // Jalankan perhitungan pertama kali
    hitungPreview();

})();
</script>