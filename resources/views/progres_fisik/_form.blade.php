@csrf

<div class="row g-3">
    <div class="col-12">
        <label for="kegiatan_id" class="form-label">Kegiatan</label>
        <select name="kegiatan_id" id="kegiatan_id"
            class="form-select @error('kegiatan_id') is-invalid @enderror">
            <option value="">-- Pilih Kegiatan --</option>
            @foreach ($kegiatanList as $kegiatan)
                <option value="{{ $kegiatan->id }}"
                    @selected(old('kegiatan_id', $progresFisik->kegiatan_id ?? '') == $kegiatan->id)>
                    {{ $kegiatan->kode_kegiatan }} — {{ $kegiatan->nama_kegiatan }}
                </option>
            @endforeach
        </select>
        @error('kegiatan_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="tanggal_rencana" class="form-label">Tanggal Rencana</label>
        <input type="date" name="tanggal_rencana" id="tanggal_rencana"
            class="form-control @error('tanggal_rencana') is-invalid @enderror"
            value="{{ old('tanggal_rencana', optional($progresFisik->tanggal_rencana ?? null)->format('Y-m-d')) }}">
        @error('tanggal_rencana')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="rencana_fisik" class="form-label">Rencana Fisik (%)</label>
        <input type="number" step="0.01" min="0" max="100" name="rencana_fisik" id="rencana_fisik"
            class="form-control @error('rencana_fisik') is-invalid @enderror"
            value="{{ old('rencana_fisik', $progresFisik->rencana_fisik ?? '') }}">
        @error('rencana_fisik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="tanggal_realisasi" class="form-label">Tanggal Realisasi</label>
        <input type="date" name="tanggal_realisasi" id="tanggal_realisasi"
            class="form-control @error('tanggal_realisasi') is-invalid @enderror"
            value="{{ old('tanggal_realisasi', optional($progresFisik->tanggal_realisasi ?? null)->format('Y-m-d')) }}">
        @error('tanggal_realisasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="realisasi_fisik" class="form-label">Realisasi Fisik (%)</label>
        <input type="number" step="0.01" min="0" max="100" name="realisasi_fisik" id="realisasi_fisik"
            class="form-control @error('realisasi_fisik') is-invalid @enderror"
            value="{{ old('realisasi_fisik', $progresFisik->realisasi_fisik ?? '') }}">
        @error('realisasi_fisik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg" aria-hidden="true"></i> Simpan
    </button>
    <a href="{{ route('progres-fisik.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
