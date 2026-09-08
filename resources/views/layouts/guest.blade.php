<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Monitoring Progres Kementerian Pekerjaan Umum">
    <title>{{ config('app.name', 'Monitoring Progres') }} | Kementerian Pekerjaan Umum</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        /* Ambient Floating Glow matching Template Theme */
        .auth-ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.55;
            will-change: transform;
        }

        .auth-glow-1 {
            top: -80px;
            left: -80px;
            width: 440px;
            height: 440px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.22) 0%, transparent 70%);
            animation: floatGlow 14s ease-in-out infinite alternate;
        }

        .auth-glow-2 {
            bottom: -80px;
            right: -80px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.16) 0%, transparent 70%);
            animation: floatGlow 18s ease-in-out infinite alternate-reverse;
        }

        @keyframes floatGlow {
            0% { transform: translate(0, 0); }
            100% { transform: translate(35px, 35px); }
        }

        /* Card Animation */
        .auth-card {
            position: relative;
            z-index: 1;
            animation: authCardFadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes authCardFadeIn {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.99);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Input Group Focus Styling */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--admin-primary) !important;
        }

        .btn-toggle-pw {
            cursor: pointer;
            transition: color 0.18s ease;
        }

        .btn-toggle-pw:hover {
            color: var(--admin-text) !important;
        }

        /* Animated Submit Button */
        .btn-animated-submit {
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-animated-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35);
        }

        .btn-animated-submit:active {
            transform: translateY(0);
        }

        .btn-animated-submit::after {
            content: "";
            position: absolute;
            top: -50%;
            left: -60%;
            width: 40%;
            height: 200%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
            transform: rotate(25deg);
            transition: none;
        }

        .btn-animated-submit:hover::after {
            left: 120%;
            transition: left 0.75s ease-in-out;
        }

        /* Alert Shake */
        @keyframes alertShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }

        .alert-shake {
            animation: alertShake 0.4s ease;
        }

        /* Prefers-reduced-motion */
        @media (prefers-reduced-motion: reduce) {
            .auth-card,
            .auth-ambient-glow,
            .alert-shake,
            .btn-animated-submit::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="auth-body">
    {{-- THEME TOGGLE (From Template) --}}
    <div class="auth-theme-toggle">
        <button
            class="icon-button theme-toggle"
            type="button"
            data-theme-toggle
            aria-label="Switch color theme"
            title="Switch color theme">
            <i class="bi bi-moon-stars"
                data-theme-icon
                aria-hidden="true"></i>
        </button>
    </div>

    {{-- AMBIENT ANIMATED GLOW --}}
    <div class="auth-ambient-glow auth-glow-1" aria-hidden="true"></div>
    <div class="auth-ambient-glow auth-glow-2" aria-hidden="true"></div>

    {{-- MAIN AUTH PAGE (From Template) --}}
    <main class="auth-page">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </main>

    <!-- Template JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
