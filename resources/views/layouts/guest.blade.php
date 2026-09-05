<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Monitoring Progres') }}</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .auth-shell { min-height: 100vh; display: grid; place-items: center; padding: 2rem 1rem; background: linear-gradient(180deg, #f8fbff 0%, #eef4fa 100%); }
            .auth-layout { display: grid; grid-template-columns: minmax(260px, 0.9fr) minmax(320px, 1.1fr); width: min(920px, 100%); overflow: hidden; border: 1px solid #dbe4ef; border-radius: 12px; background: #ffffff; box-shadow: 0 26px 70px rgba(15, 23, 42, 0.12); }
            .auth-aside { display: flex; flex-direction: column; justify-content: space-between; padding: 2.5rem; background: #111827; color: #ffffff; }
            .auth-brand { display: inline-flex; align-items: center; gap: 0.8rem; color: #ffffff; }
            .auth-brand:hover { color: #ffffff; }
            .auth-brand img { width: 58px; height: 58px; object-fit: contain; }
            .auth-brand-title { display: block; font-size: 1.1rem; font-weight: 800; }
            .auth-brand-subtitle { display: block; color: #9ca3af; font-size: 0.8rem; }
            .auth-aside-copy { max-width: 250px; }
            .auth-aside-copy h1 { margin-bottom: 0.8rem; font-size: 2rem; font-weight: 800; line-height: 1.15; }
            .auth-aside-copy p { margin: 0; color: #cbd5e1; line-height: 1.65; }
            .auth-aside-footer { color: #9ca3af; font-size: 0.85rem; }
            .auth-form-panel { padding: 2.5rem; }
            .auth-form-panel h2 { color: #1f2937; font-weight: 800; }
            .auth-form-panel .form-control { min-height: 46px; border-color: #dbe4ef; }
            .auth-form-panel .form-control:focus { border-color: #2563eb; box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12); }
            .auth-form-panel .btn-primary { min-height: 46px; }
            @media (max-width: 767.98px) {
                .auth-layout { grid-template-columns: 1fr; }
                .auth-aside { gap: 2rem; padding: 1.75rem; }
                .auth-aside-copy h1 { font-size: 1.65rem; }
                .auth-form-panel { padding: 1.75rem; }
            }
        </style>
    </head>
    <body>
        <main class="auth-shell">
            <div class="auth-layout">
                <section class="auth-aside">
                    <a class="auth-brand" href="{{ url('/') }}">
                        <img src="{{ asset('logo-pupr.png') }}" alt="Logo Kementerian Pekerjaan Umum">
                        <span>
                            <span class="auth-brand-title">KEMENTERIAN PEKERJAAN UMUM</span>
                            <span class="auth-brand-subtitle">Monitoring Progres</span>
                        </span>
                    </a>
                    <div class="auth-aside-copy">
                        <h1>Monitoring progres kegiatan lebih terarah.</h1>
                        <p>Kelola kegiatan, progres fisik, dan progres keuangan dalam satu dashboard.</p>
                    </div>
                    <div class="auth-aside-footer">Sistem Monitoring Progres</div>
                </section>
                <section class="auth-form-panel">
                    {{ $slot }}
                </section>
            </div>
        </main>
    </body>
</html>
