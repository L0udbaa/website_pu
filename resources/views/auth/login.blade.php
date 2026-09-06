<x-guest-layout>

    {{-- Brand Header (Template Standard) --}}
    <a class="auth-brand mb-3" href="{{ url('/') }}">
        <img src="{{ asset('logo-pupr.png') }}" width="48" height="48" style="object-fit: contain; flex-shrink: 0;" alt="Logo Kementerian Pekerjaan Umum">
        <span>
            <strong style="font-size: 0.95rem; letter-spacing: 0.02em; line-height: 1.2;">KEMENTERIAN PEKERJAAN UMUM</strong>
            <span class="fw-semibold text-secondary" style="font-size: 0.82rem; line-height: 1.25; margin-top: 2px;">Badan Pelaksanaan Jalan Nasional Maluku Utara</span>
            <small class="text-muted" style="font-size: 0.76rem; margin-top: 2px;">Monitoring Progres</small>
        </span>
    </a>

    {{-- Page Heading --}}
    <div class="mb-3">
        <h1 class="h5 fw-bold mb-1">Masuk ke Akun</h1>
        <p class="text-muted small mb-0">Lanjutkan ke dashboard Monitoring Progres kegiatan.</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="alert alert-success d-flex align-items-center gap-2 alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle-fill text-success fs-5"></i>
            <div>{{ session('status') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation Error Alert with Shake Animation --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-shake d-flex align-items-center gap-2 alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill text-danger fs-5 flex-shrink-0"></i>
            <div class="small">
                <strong>Autentikasi Gagal!</strong><br>
                Email atau kata sandi yang Anda masukkan tidak sesuai.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Form Login --}}
    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label small fw-semibold">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 text-muted">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" 
                       class="form-control border-start-0 ps-1 @error('email') is-invalid @enderror" 
                       type="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="nama@pu.go.id">
            </div>
            @error('email') 
                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> 
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label small fw-semibold mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a class="small text-decoration-none" href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 text-muted">
                    <i class="bi bi-lock"></i>
                </span>
                <input id="password" 
                       class="form-control border-start-0 border-end-0 px-1 @error('password') is-invalid @enderror" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="current-password"
                       placeholder="••••••••">
                <button type="button" 
                        class="input-group-text bg-transparent border-start-0 text-muted btn-toggle-pw" 
                        id="togglePasswordBtn" 
                        title="Tampilkan / Sembunyikan Password"
                        aria-label="Toggle password visibility">
                    <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
            </div>
            @error('password') 
                <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> 
            @enderror
        </div>

        {{-- Remember Me --}}
        <div class="form-check mb-3">
            <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
            <label for="remember_me" class="form-check-label text-muted small">Ingat saya</label>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary w-100 btn-animated-submit" id="submitBtn">
            <span id="btnText" class="d-inline-flex align-items-center justify-content-center">
                <i class="bi bi-box-arrow-in-right me-2" aria-hidden="true"></i>Masuk
            </span>
            <span id="btnLoading" class="d-none align-items-center justify-content-center">
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Memverifikasi...
            </span>
        </button>
    </form>

    {{-- Footer (Template Standard) --}}
    <div class="auth-footer">
        <small class="text-muted d-block">&copy; {{ date('Y') }} Kementerian Pekerjaan Umum</small>
        <small class="text-muted" style="font-size: 0.78rem;">Badan Pelaksanaan Jalan Nasional Maluku Utara</small>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Toggle Password
            const togglePasswordBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (togglePasswordBtn && passwordInput && togglePasswordIcon) {
                togglePasswordBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    
                    if (isPassword) {
                        togglePasswordIcon.classList.remove('bi-eye');
                        togglePasswordIcon.classList.add('bi-eye-slash');
                        togglePasswordBtn.setAttribute('title', 'Sembunyikan Password');
                    } else {
                        togglePasswordIcon.classList.remove('bi-eye-slash');
                        togglePasswordIcon.classList.add('bi-eye');
                        togglePasswordBtn.setAttribute('title', 'Tampilkan Password');
                    }
                    passwordInput.focus();
                });
            }

            // Submit Button Loading State
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');

            if (loginForm && submitBtn && btnText && btnLoading) {
                loginForm.addEventListener('submit', function () {
                    if (loginForm.checkValidity()) {
                        submitBtn.disabled = true;
                        btnText.classList.remove('d-inline-flex');
                        btnText.classList.add('d-none');
                        btnLoading.classList.remove('d-none');
                        btnLoading.classList.add('d-inline-flex');
                    }
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>
