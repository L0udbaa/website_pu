@csrf

<div class="row g-3">
    <div class="col-12 col-md-6">
        <label for="kode_kegiatan" class="form-label">Kode Kegiatan</label>
        <input type="text" name="kode_kegiatan" id="kode_kegiatan"
            class="form-control @error('kode_kegiatan') is-invalid @enderror"
            value="{{ old('kode_kegiatan', $kegiatan->kode_kegiatan ?? '') }}" placeholder="Mis. KGT-010">
        @error('kode_kegiatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="tahun" class="form-label">Tahun</label>
        <input type="number" name="tahun" id="tahun" min="2000" max="2100"
            class="form-control @error('tahun') is-invalid @enderror"
            value="{{ old('tahun', $kegiatan->tahun ?? date('Y')) }}">
        @error('tahun')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
        <input type="text" name="nama_kegiatan" id="nama_kegiatan"
            class="form-control @error('nama_kegiatan') is-invalid @enderror"
            value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan ?? '') }}">
        @error('nama_kegiatan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="lokasi" class="form-label">Lokasi</label>
        <input type="text" name="lokasi" id="lokasi"
            class="form-control @error('lokasi') is-invalid @enderror"
            value="{{ old('lokasi', $kegiatan->lokasi ?? '') }}">
        @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 col-md-6">
        <label for="anggaran" class="form-label">Anggaran (Rp)</label>
        <input type="number" step="0.01" min="0" name="anggaran" id="anggaran"
            class="form-control @error('anggaran') is-invalid @enderror"
            value="{{ old('anggaran', $kegiatan->anggaran ?? '') }}">
        @error('anggaran')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="user_id" class="form-label">Penanggung Jawab</label>
        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror">
            <option value="">-- Tidak ditentukan --</option>
            @foreach ($userList as $user)
                <option value="{{ $user->id }}"
                    @selected(old('user_id', $kegiatan->user_id ?? '') == $user->id)>
                    {{ $user->nama }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg" aria-hidden="true"></i> Simpan
    </button>
    <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>
