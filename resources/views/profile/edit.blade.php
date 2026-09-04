@extends('layouts.app')

<<<<<<< HEAD
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
=======
@section('title', 'Pengaturan Profil')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }
    .input-field {
        transition: all 0.2s ease;
        background-color: #f8fafc;
    }
    .input-field:focus {
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
</style>

<div class="w-full max-w-3xl mx-auto space-y-8 py-6">

    <!-- Pesan Sukses -->
    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div id="status-message" class="p-4 bg-green-500 text-white font-medium rounded-2xl shadow-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Perubahan berhasil disimpan!</span>
            </div>
        </div>
        <script>
            setTimeout(() => { 
                document.getElementById('status-message')?.remove(); 
            }, 4000);
        </script>
    @endif

    <!-- KARTU 1: Informasi Profil & Foto -->
    <div class="glass-card rounded-3xl p-8">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Informasi Profil</h2>
            <p class="text-sm text-gray-500">Perbarui foto, nama, dan alamat email akun Anda.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('patch')

            <!-- Foto Profil / Avatar -->
            <div class="flex items-center gap-6 pb-2">
                <div class="relative">
                    <img id="avatar-preview" 
                         src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=3b82f6&color=fff' }}" 
                         alt="Avatar" 
                         class="w-20 h-20 rounded-full object-cover border-4 border-blue-100 shadow-md">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" name="avatar" id="avatar-input" accept="image/*" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-gray-400 mt-1">PNG, JPG, max 2MB.</p>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
                @error('name') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Alamat Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" required>
                @error('email') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
                
                <!-- Status Verifikasi Email -->
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-amber-50 rounded-xl border border-amber-200 text-sm text-amber-800">
                        Email Anda belum diverifikasi. 
                        <button form="send-verification" class="underline font-semibold hover:text-amber-900">Kirim ulang email verifikasi.</button>
                    </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Simpan Profil</button>
            </div>
        </form>

        <!-- Form tersembunyi untuk resend verifikasi -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
        @endif
    </div>

    <!-- KARTU 2: Ubah Password -->
    <div class="glass-card rounded-3xl p-8">
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Ubah Kata Sandi</h2>
            <p class="text-sm text-gray-500">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi Saat Ini</label>
                <input type="password" id="current_password" name="current_password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                @error('current_password', 'updatePassword') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi Baru</label>
                <input type="password" id="password" name="password" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                @error('password', 'updatePassword') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input-field w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                @error('password_confirmation', 'updatePassword') 
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Update Password</button>
            </div>
        </form>
    </div>

</div>

<!-- Script Preview Gambar -->
<script>
    document.getElementById('avatar-input')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('avatar-preview').src = URL.createObjectURL(file);
        }
    });
</script>
@endsection
>>>>>>> f1b4d53460407e964a4911f002570d9e6b5fa0ba
