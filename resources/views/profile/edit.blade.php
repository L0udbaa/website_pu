@extends('layouts.app')

@section('title', 'Profil')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-person-gear" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Pengaturan Akun</p>
                <h1 class="h3 mb-1">Profil</h1>
                <p class="text-muted mb-0">Kelola informasi akun dan keamanan Anda.</p>
            </div>
        </div>
    </div>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success mt-3" role="alert">Informasi profil berhasil diperbarui.</div>
    @elseif (session('status') === 'password-updated')
        <div class="alert alert-success mt-3" role="alert">Password berhasil diperbarui.</div>
    @endif

    <div class="row g-3 mt-0">
        <div class="col-12 col-xl-8">
            <section class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-person" aria-hidden="true"></i><span>Informasi Profil</span></h2>
                        <p class="text-muted mb-0">Perbarui nama dan alamat email akun Anda.</p>
                    </div>
                </div>
                <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-none">
                    @csrf
                </form>
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg" aria-hidden="true"></i> Simpan Perubahan</button>
                </form>
            </section>
        </div>

        <div class="col-12 col-xl-4">
            <section class="panel profile-summary h-100">
                <div class="profile-summary-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                <h2 class="h5 mb-1">{{ $user->name }}</h2>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                <span class="badge text-bg-success"><i class="bi bi-check-circle" aria-hidden="true"></i> Akun Aktif</span>
            </section>
        </div>

        <div class="col-12 col-xl-8">
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-shield-lock" aria-hidden="true"></i><span>Keamanan Akun</span></h2>
                        <p class="text-muted mb-0">Gunakan password yang panjang dan sulit ditebak.</p>
                    </div>
                </div>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="update_password_current_password" class="form-label">Password Saat Ini</label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-control @if ($errors->updatePassword->has('current_password')) is-invalid @endif" autocomplete="current-password">
                        @if ($errors->updatePassword->has('current_password')) <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div> @endif
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="update_password_password" class="form-label">Password Baru</label>
                            <input id="update_password_password" name="password" type="password" class="form-control @if ($errors->updatePassword->has('password')) is-invalid @endif" autocomplete="new-password">
                            @if ($errors->updatePassword->has('password')) <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div> @endif
                        </div>
                        <div class="col-md-6">
                            <label for="update_password_password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-shield-check" aria-hidden="true"></i> Perbarui Password</button>
                </form>
            </section>
        </div>

        <div class="col-12 col-xl-4">
            <section class="panel border-danger-subtle">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title text-danger"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><span>Zona Berbahaya</span></h2>
                        <p class="text-muted mb-0">Menghapus akun bersifat permanen.</p>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal"><i class="bi bi-trash" aria-hidden="true"></i> Hapus Akun</button>
            </section>
        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h2 class="modal-title h5" id="deleteAccountModalLabel">Hapus akun?</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Semua data akun akan dihapus secara permanen. Masukkan password untuk melanjutkan.</p>
                        <label for="delete_password" class="form-label">Password</label>
                        <input id="delete_password" name="password" type="password" class="form-control @if ($errors->userDeletion->has('password')) is-invalid @endif" required>
                        @if ($errors->userDeletion->has('password')) <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div> @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash" aria-hidden="true"></i> Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .profile-summary { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; }
        .profile-summary-avatar { display: grid; width: 76px; height: 76px; place-items: center; margin-bottom: 1rem; border-radius: 50%; background: #dbeafe; color: #1d4ed8; font-size: 1.4rem; font-weight: 800; }
        html[data-theme="dark"] .profile-summary-avatar { background: #1e3a5f; color: #bfdbfe; }
        html[data-theme="dark"] .border-danger-subtle { border-color: #7f1d1d !important; }
    </style>
@endsection
