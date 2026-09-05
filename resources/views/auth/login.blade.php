<x-guest-layout>
    <div class="mb-4">
        <p class="eyebrow mb-1">Selamat datang</p>
        <h2 class="h3 mb-2">Masuk ke akun Anda</h2>
        <p class="text-muted mb-0">Lanjutkan ke dashboard Monitoring Progres.</p>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">Email atau password yang Anda masukkan tidak sesuai.</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
            <div class="form-check">
                <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                <label for="remember_me" class="form-check-label text-muted">Ingat saya</label>
            </div>
            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-2" aria-hidden="true"></i>Masuk
        </button>
    </form>
</x-guest-layout>
