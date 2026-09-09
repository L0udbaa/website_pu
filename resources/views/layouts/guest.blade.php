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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --auth-bg-1: rgba(99, 102, 241, 0.14);
            --auth-bg-2: rgba(56, 189, 248, 0.1);
            --auth-bg-3: rgba(199, 210, 254, 0.4);
            --auth-card-bg: rgba(255, 255, 255, 0.78);
            --auth-card-border: rgba(148, 163, 184, 0.28);
            --auth-input-border: rgba(148, 163, 184, 0.4);
            --auth-primary: #6366f1;
            --auth-primary-strong: #4338ca;
            --auth-text: #0f172a;
            --auth-muted: #475569;
        }

        body.auth-body {
            position: relative;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', Inter, system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background:
                linear-gradient(rgba(15, 23, 42, 0.18), rgba(15, 23, 42, 0.28)),
                url('{{ asset('images/gambar.jpg') }}') center center / cover no-repeat fixed,
                radial-gradient(circle at top left, rgba(96, 165, 250, 0.18) 0%, transparent 30%),
                radial-gradient(circle at bottom right, rgba(168, 85, 247, 0.14) 0%, transparent 35%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: var(--auth-text);
            overflow: hidden;
        }

        .auth-body,
        .auth-body button,
        .auth-body input,
        .auth-body label,
        .auth-body a,
        .auth-body p,
        .auth-body small,
        .auth-body strong,
        .auth-body h1 {
            font-family: inherit;
        }

        .auth-body h1 {
            font-weight: 800;
            letter-spacing: 0;
        }

        .auth-body .auth-brand strong {
            font-size: 0.9rem !important;
            font-weight: 800;
            letter-spacing: 0.04em !important;
        }

        .auth-body .auth-brand small,
        .auth-body .auth-brand span:last-child {
            letter-spacing: 0;
        }

        .auth-body .form-label,
        .auth-body .form-check-label,
        .auth-body .auth-card a,
        .auth-body .auth-footer {
            font-weight: 600;
        }

        .auth-body::before,
        .auth-body::after {
            content: "";
            position: fixed;
            width: 26rem;
            height: 26rem;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            pointer-events: none;
            z-index: 0;
        }

        .auth-body::before {
            top: -8rem;
            left: -6rem;
            background: rgba(96, 165, 250, 0.18);
        }

        .auth-body::after {
            right: -7rem;
            bottom: -8rem;
            background: rgba(168, 85, 247, 0.18);
        }

        .auth-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            position: relative;
            z-index: 1;
            width: min(100%, 490px);
            padding: 2rem 1.5rem 1.5rem;
            background: rgba(15, 23, 42, 0.62);
            border: 1px solid rgba(148, 163, 184, 0.26);
            border-radius: 28px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            animation: authCardFadeIn 0.5s ease-out;
        }

        @keyframes authCardFadeIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            margin-bottom: 1.35rem;
            color: var(--auth-text);
        }

        .auth-brand strong,
        .auth-brand .text-secondary,
        .auth-brand small,
        .auth-brand .text-muted,
        .auth-brand span {
            color: var(--auth-text) !important;
        }

        .auth-brand img {
            width: 56px;
            height: 56px;
            padding: 0.5rem;
            object-fit: contain;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(56, 189, 248, 0.16);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.14), rgba(56, 189, 248, 0.12));
            border: 1px solid rgba(148, 163, 184, 0.28);
        }

        .auth-brand small,
        .auth-card .text-muted,
        .auth-card .small,
        .form-check-label,
        .auth-card label,
        .auth-card a,
        .auth-footer,
        .auth-footer small,
        .text-secondary {
            color: var(--auth-muted) !important;
        }

        .auth-card .form-label,
        .auth-card input,
        .auth-card .form-check-label,
        .auth-card label {
            color: var(--auth-text) !important;
        }

        .auth-card h1 {
            color: #ffffff;
        }

        html[data-theme="light"] .auth-body {
            background:
                linear-gradient(rgba(15, 23, 42, 0.2), rgba(15, 23, 42, 0.16)),
                url('{{ asset('images/gambar.jpg') }}') center center / cover no-repeat fixed,
                radial-gradient(circle at 8% 8%, rgba(96, 165, 250, 0.24) 0%, transparent 30%),
                radial-gradient(circle at 92% 88%, rgba(129, 140, 248, 0.2) 0%, transparent 34%),
                linear-gradient(135deg, #eef5ff 0%, #f8fbff 52%, #edf0ff 100%);
        }

        html[data-theme="light"] .auth-card {
            overflow: hidden;
            background: rgba(255, 255, 255, 0.72);
            border-color: rgba(148, 163, 184, 0.3);
            box-shadow: 0 28px 70px rgba(30, 64, 175, 0.14), inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }

        html[data-theme="light"] .auth-card::after {
            content: "";
            position: absolute;
            top: -9rem;
            right: -8rem;
            width: 18rem;
            height: 18rem;
            border: 1px solid rgba(96, 165, 250, 0.14);
            border-radius: 50%;
            box-shadow: 0 0 0 24px rgba(96, 165, 250, 0.035), 0 0 0 48px rgba(184, 137, 60, 0.025);
            pointer-events: none;
        }

        html[data-theme="light"] .auth-brand {
            position: relative;
            padding-bottom: 1rem;
        }

        html[data-theme="light"] .auth-brand strong {
            color: #0f172a !important;
        }

        html[data-theme="light"] .auth-brand img {
            border-color: rgba(184, 137, 60, 0.5);
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.12), 0 0 0 4px rgba(184, 137, 60, 0.08);
        }

        html[data-theme="light"] .auth-brand small,
        html[data-theme="light"] .auth-brand span:last-child {
            color: #475569 !important;
        }

        html[data-theme="light"] .auth-card h1 {
            color: #0f172a;
        }

        html[data-theme="light"] .auth-card .text-muted,
        html[data-theme="light"] .auth-card .small,
        html[data-theme="light"] .auth-card label,
        html[data-theme="light"] .auth-footer,
        html[data-theme="light"] .auth-footer small {
            color: #52647d !important;
        }

        html[data-theme="light"] .input-group {
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9), 0 8px 18px -16px rgba(30, 64, 175, 0.5);
        }

        html[data-theme="light"] .input-group-text,
        html[data-theme="light"] .form-control {
            background: rgba(255, 255, 255, 0.84);
            border-color: rgba(148, 163, 184, 0.34);
            color: #0f172a;
        }

        html[data-theme="light"] .input-group-text {
            background: rgba(239, 246, 255, 0.92);
            color: #475569;
        }

        html[data-theme="light"] .auth-card .form-label {
            color: #334155 !important;
            letter-spacing: 0.02em;
        }

        html[data-theme="light"] .form-control::placeholder {
            color: #8291a6;
        }

        html[data-theme="light"] .input-group:focus-within {
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.16), 0 10px 24px -18px rgba(30, 64, 175, 0.6);
        }

        html[data-theme="light"] .theme-toggle {
            color: #334155;
            background: rgba(255, 255, 255, 0.66);
            border-color: rgba(148, 163, 184, 0.32);
            box-shadow: 0 10px 22px -16px rgba(30, 64, 175, 0.55);
        }

        html[data-theme="light"] .btn-animated-submit {
            background: linear-gradient(135deg, #5266d8 0%, #4f46a5 52%, #293276 100%);
            box-shadow: 0 18px 32px -16px rgba(30, 64, 175, 0.62), 0 1px 0 rgba(255, 255, 255, 0.28) inset;
        }

        html[data-theme="light"] .auth-glow-1 {
            background: rgba(56, 189, 248, 0.2);
        }

        html[data-theme="light"] .auth-glow-2 {
            background: rgba(129, 140, 248, 0.18);
        }

        .auth-card .text-muted {
            color: var(--auth-muted) !important;
        }

        .input-group {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        .input-group-text,
        .form-control {
            min-height: 50px;
            background: rgba(255, 255, 255, 0.76);
            border: 1px solid var(--auth-input-border);
            color: var(--auth-text);
            backdrop-filter: blur(8px);
        }

        .input-group-text {
            border-right: 0;
            color: var(--auth-muted);
            background: rgba(241, 245, 249, 0.88);
        }

        .form-control {
            border-radius: 0 16px 16px 0 !important;
            border-left: 0;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.12);
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control,
        .form-control:focus {
            border-color: rgba(96, 165, 250, 0.7) !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .btn-toggle-pw {
            cursor: pointer;
            border-radius: 0 16px 16px 0 !important;
            transition: color 0.2s ease, background 0.2s ease;
        }

        .btn-toggle-pw:hover {
            background: rgba(96, 165, 250, 0.12);
            color: var(--auth-text) !important;
        }

        .btn-primary,
        .btn-animated-submit {
            position: relative;
            overflow: hidden;
            min-height: 50px;
            border: none;
            border-radius: 16px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 48%, #312e81 100%);
            box-shadow: 0 18px 30px -14px rgba(79, 70, 229, 0.7);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        .btn-primary:hover,
        .btn-animated-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 36px -16px rgba(79, 70, 229, 0.7);
            filter: brightness(1.02);
        }

        .btn-animated-submit::after {
            content: "";
            position: absolute;
            top: -55%;
            left: -60%;
            width: 38%;
            height: 210%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
            transform: rotate(24deg);
            transition: left 0.7s ease;
        }

        .btn-animated-submit:hover::after {
            left: 125%;
        }

        .alert {
            border-radius: 14px;
            backdrop-filter: blur(10px);
        }

        .alert-shake {
            animation: alertShake 0.38s ease;
        }

        @keyframes alertShake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }

        .auth-theme-toggle {
            position: fixed;
            top: 1.2rem;
            right: 1.2rem;
            z-index: 2;
        }

        .theme-toggle {
            width: 42px;
            height: 42px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.25);
            color: var(--auth-text);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
        }

        .auth-ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.8;
            pointer-events: none;
            z-index: 0;
            animation: floatGlow 12s ease-in-out infinite alternate;
        }

        .auth-glow-1 {
            width: 20rem;
            height: 20rem;
            top: -6rem;
            left: -5rem;
            background: rgba(96, 165, 250, 0.18);
        }

        .auth-glow-2 {
            width: 18rem;
            height: 18rem;
            right: -4rem;
            bottom: -4rem;
            background: rgba(168, 85, 247, 0.18);
            animation-duration: 15s;
        }

        html[data-theme="dark"] {
            --auth-bg-1: rgba(99, 102, 241, 0.22);
            --auth-bg-2: rgba(56, 189, 248, 0.14);
            --auth-bg-3: rgba(30, 27, 75, 0.5);
            --auth-card-bg: rgba(15, 23, 42, 0.82);
            --auth-card-border: rgba(148, 163, 184, 0.2);
            --auth-input-border: rgba(148, 163, 184, 0.22);
            --auth-text: #f8fafc;
            --auth-muted: #a4b4cc;
        }

        html[data-theme="dark"] body.auth-body {
            background:
                linear-gradient(rgba(2, 6, 23, 0.52), rgba(2, 6, 23, 0.38)),
                url('{{ asset('images/gambar.jpg') }}') center center / cover no-repeat fixed,
                radial-gradient(circle at top left, var(--auth-bg-1) 0%, transparent 30%),
                radial-gradient(circle at bottom right, var(--auth-bg-3) 0%, transparent 35%),
                linear-gradient(135deg, #090d16 0%, #0f172a 58%, #1e1b4b 100%);
        }

        html[data-theme="dark"] .auth-card {
            box-shadow: 0 24px 60px rgba(2, 6, 23, 0.48), inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        html[data-theme="dark"] .input-group-text,
        html[data-theme="dark"] .form-control {
            background: rgba(17, 28, 47, 0.9);
        }

        html[data-theme="dark"] .input-group-text {
            background: rgba(23, 35, 56, 0.9);
        }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(22px, 18px) scale(1.08); }
        }

        @media (prefers-reduced-motion: reduce) {
            .auth-card,
            .alert-shake,
            .auth-ambient-glow,
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
