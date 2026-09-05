@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Profil</p>
                <h1 class="h3 mb-1">Profil Saya</h1>
                <p class="text-muted mb-0">Kelola nama dan alamat email yang tampil di aplikasi.</p>
            </div>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success" role="alert"><i class="bi bi-check-circle me-2"></i>Informasi profil berhasil diperbarui.</div>
    @endif

    <div class="row g-3">
        <div class="col-12 col-xl-8">
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-person-lines-fill" aria-hidden="true"></i><span>Informasi Profil</span></h2>
                        <p class="text-muted mb-0">Perbarui informasi personal Anda.</p>
                    </div>
                </div>
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">@csrf</form>
                @endif
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required autofocus autocomplete="name">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="alert alert-warning py-2" role="alert">
                            Email Anda belum diverifikasi.
                            <button form="send-verification" class="btn btn-link btn-sm p-0 align-baseline">Kirim ulang email verifikasi</button>
                        </div>
                    @endif
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg" aria-hidden="true"></i> Simpan Profil</button>
                </form>
            </section>
        </div>

        <div class="col-12 col-xl-4">
            <section class="panel profile-summary h-100">
                <div class="profile-summary-avatar">{{ strtoupper(substr($user->nama, 0, 2)) }}</div>
                <h2 class="h5 mb-1">{{ $user->nama }}</h2>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge text-bg-success"><i class="bi bi-check-circle" aria-hidden="true"></i> {{ ucfirst($user->status) }}</span>
                <dl class="row w-100 text-start small mt-4 mb-0">
                    <dt class="col-5 text-muted">Username</dt>
                    <dd class="col-7 mb-2">{{ $user->username }}</dd>
                    <dt class="col-5 text-muted">Peran</dt>
                    <dd class="col-7 mb-0 text-capitalize">{{ $user->role }}</dd>
                </dl>
            </section>
        </div>
    </div>

    <style>
        .profile-summary { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .profile-summary-avatar { display: grid; width: 76px; height: 76px; place-items: center; margin-bottom: 1rem; border-radius: 50%; background: #dbeafe; color: #1d4ed8; font-size: 1.4rem; font-weight: 800; }
        html[data-theme="dark"] .profile-summary-avatar { background: #1e3a5f; color: #bfdbfe; }
    </style>
@endsection
