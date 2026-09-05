@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <div class="page-heading">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-person-gear" aria-hidden="true"></i></span>
            <div>
                <p class="eyebrow mb-1">Account Settings</p>
                <h1 class="h3 mb-1">Pengaturan Akun</h1>
                <p class="text-muted mb-0">Atur keamanan dan akses akun Anda.</p>
            </div>
        </div>
    </div>

    @if (session('status') === 'password-updated')
        <div class="alert alert-success" role="alert"><i class="bi bi-check-circle me-2"></i>Password berhasil diperbarui.</div>
    @endif

    <div class="row g-4 account-settings-grid">
        <div class="col-12 col-xl-8">
            <section class="panel h-100">
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
            <section class="panel h-100 account-status-panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title"><i class="bi bi-info-circle" aria-hidden="true"></i><span>Status Akun</span></h2>
                        <p class="text-muted mb-0">Ringkasan akses akun saat ini.</p>
                    </div>
                </div>
                <dl class="small mb-0 account-status-list">
                    <div class="account-status-item">
                        <dt class="text-muted">Username</dt>
                        <dd>{{ $user->username }}</dd>
                    </div>
                    <div class="account-status-item">
                        <dt class="text-muted">Peran</dt>
                        <dd class="text-capitalize">{{ $user->role }}</dd>
                    </div>
                    <div class="account-status-item">
                        <dt class="text-muted">Status</dt>
                        <dd><span class="badge text-bg-success">{{ ucfirst($user->status) }}</span></dd>
                    </div>
                </dl>
            </section>
        </div>

        <div class="col-12">
            <section class="panel border-danger-subtle account-danger-panel">
                <div class="account-danger-content">
                    <div class="panel-header mb-0">
                        <h2 class="h5 mb-1 section-title text-danger"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i><span>Zona Berbahaya</span></h2>
                        <p class="text-muted mb-0">Menghapus akun bersifat permanen dan tidak dapat dibatalkan.</p>
                    </div>
                    <button type="button" class="btn btn-outline-danger flex-shrink-0" data-bs-toggle="modal" data-bs-target="#deleteAccountModal"><i class="bi bi-trash" aria-hidden="true"></i> Hapus Akun</button>
                </div>
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
        .account-settings-grid .panel { height: 100%; }
        .account-status-panel { display: flex; flex-direction: column; }
        .account-status-list { margin-top: 0.35rem; }
        .account-status-item { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.7rem 0; border-bottom: 1px solid var(--admin-border); }
        .account-status-item:last-child { border-bottom: 0; }
        .account-status-item dt,
        .account-status-item dd { margin: 0; }
        .account-status-item dd { color: var(--admin-text); font-weight: 700; text-align: right; }
        .account-danger-content { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; }
        @media (max-width: 767.98px) {
            .account-danger-content { align-items: stretch; flex-direction: column; gap: 1rem; }
            .account-danger-content .btn { align-self: flex-start; }
        }
    </style>
@endsection
