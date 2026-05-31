<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HOREB ACADEMY') }} — Connexion</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Wrapper principal ── */
        .auth-wrap {
            display: flex;
            width: 100vw;
            height: 100vh;
        }

        /* ── Colonne gauche : image ── */
        .auth-left {
            position: relative;
            width: 62%;
            flex-shrink: 0;
            overflow: hidden;
            background: #071428;
        }

        .auth-left img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .auth-left .overlay-1 {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(7,20,40,0.82) 0%, rgba(13,34,86,0.55) 55%, rgba(7,20,40,0.10) 100%);
        }

        .auth-left .overlay-2 {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(3,13,31,0.78) 0%, transparent 55%);
        }

        .auth-left .left-content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            padding: 2.5rem;
        }

        /* Brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-icon span {
            color: white;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 0.05em;
        }
        .brand-name {
            color: white;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }
        .brand-name em {
            font-style: normal;
            font-weight: 300;
            opacity: 0.65;
        }

        /* Hero text */
        .hero-block { padding-bottom: 1rem; }

        .hero-title {
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 3.2rem;
            font-weight: 600;
            line-height: 1.13;
            margin-bottom: 1.25rem;
        }
        .hero-title .accent { color: #93c5fd; font-weight: 400; }

        .hero-desc {
            color: rgba(255,255,255,0.52);
            font-size: 13.5px;
            line-height: 1.7;
            max-width: 340px;
            font-weight: 300;
            margin-bottom: 2rem;
        }

        .hero-features {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem 2rem;
            margin-bottom: 2.5rem;
        }
        .hero-feat {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.58);
            font-size: 12.5px;
        }
        .hero-feat-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #60a5fa;
            flex-shrink: 0;
        }

        .hero-copy {
            color: rgba(255,255,255,0.22);
            font-size: 11px;
        }

        /* ── Colonne droite : formulaire ── */
        .auth-right {
            width: 38%;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #fff;
            overflow-y: auto;
            padding: 3rem 3rem;
        }

        .form-inner {
            width: 100%;
            max-width: 360px;
        }

        /* Inputs */
        .login-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1e293b;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .login-input:focus {
            border-color: #1a52d0;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26,82,208,0.10);
        }
        .login-input::placeholder { color: #94a3b8; }

        /* Responsive : mobile cache la colonne gauche */
        @media (max-width: 1023px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 2rem 1.5rem; }
        }
    </style>
</head>

<body>
    <div class="auth-wrap">

        {{-- ════ GAUCHE — Image 62% ════ --}}
        <div class="auth-left">
            <img src="{{ asset('images/login-bg.png') }}" alt="Campus HOREB ACADEMY">
            <div class="overlay-1"></div>
            <div class="overlay-2"></div>

            <div class="left-content">
                {{-- Logo --}}
                <div class="brand">
                    <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" style="height:48px;width:auto;filter:brightness(0) invert(1);">
                    <span class="brand-name">HOREB <em>academy</em></span>
                </div>

                {{-- Héro --}}
                <div class="hero-block">
                    <h1 class="hero-title">
                        Améliorez votre<br>
                        <span class="accent">expérience</span><br>
                        universitaire
                    </h1>
                    <p class="hero-desc">
                        Plateforme académique pour la gestion des inscriptions,
                        de paiement des frais d'inscription et de suivi.
                    </p>
                    <div class="hero-features">
                        <div class="hero-feat"><div class="hero-feat-dot"></div>Inscriptions en ligne</div>
                        <div class="hero-feat"><div class="hero-feat-dot"></div>Paiement sécurisé</div>
                        <div class="hero-feat"><div class="hero-feat-dot"></div>Suivi en temps réel</div>
                    </div>
                    <p class="hero-copy">© {{ date('Y') }} HOREB ACADEMY — Tous droits réservés</p>
                </div>
            </div>
        </div>

        {{-- ════ DROITE — Formulaire 38% ════ --}}
        <div class="auth-right">
            <div class="form-inner">
                {{ $slot }}
            </div>
            <p style="font-size:11.5px; color:#94a3b8; margin-top:2rem; text-align:center;">
                Besoin d'aide ?
                <a href="mailto:support@horeb.academy"
                   style="color:#1a52d0; font-weight:500; text-decoration:none;">
                    support@horeb.academy
                </a>
            </p>
        </div>

    </div>
</body>
</html>