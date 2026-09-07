<x-guest-layout>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 shadow-sm" :status="session('status')" />

    <div class="max-w-md mx-auto bg-white/80 backdrop-blur-md p-8 rounded-2xl shadow-xl border border-gray-100">
        <!-- Optional Decorative Header -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="email" 
                    class="block mt-1.5 w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-gray-800 shadow-sm transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="nama@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-500" />
            </div>

            <!-- Password -->
            <div class="mt-5">
                <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />

                <x-text-input id="password" 
                    class="block mt-1.5 w-full rounded-xl border-gray-200 bg-gray-50/50 px-4 py-3 text-gray-800 shadow-sm transition-all duration-200 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-500/20"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                    placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mt-5">
                <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0 transition-colors duration-200 cursor-pointer" name="remember">
                    <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors duration-200">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-800 hover:underline transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <x-primary-button class="w-full justify-center py-3 px-4 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 active:scale-[0.98] text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/35 transition-all duration-200 border-none">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
=======

    {{-- Brand Header (Template Standard) --}}
    <a class="auth-brand mb-3" href="{{ url('/') }}">
        <img src="{{ asset('logo-pupr.png') }}" width="48" height="48" style="object-fit: contain; flex-shrink: 0;" alt="Logo Kementerian Pekerjaan Umum">
        <span>
            <strong style="font-size: 0.95rem; letter-spacing: 0.02em; line-height: 1.2;">KEMENTERIAN PEKERJAAN UMUM</strong>
            <small class="text-muted" style="font-size: 0.76rem; margin-top: 2px;">Monitoring Progres</small>
            <span class="fw-semibold text-secondary" style="font-size: 0.82rem; line-height: 1.25; margin-top: 2px;">Balai Pelaksanaan Jalan Nasional Maluku Utara</span>
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
        <small class="text-muted" style="font-size: 0.78rem;">Balai Pelaksanaan Jalan Nasional Maluku Utara</small>
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

