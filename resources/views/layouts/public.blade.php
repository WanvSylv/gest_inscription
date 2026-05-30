<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HOREB ACADEMY') — HOREB ACADEMY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .nav-blur { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); background: rgba(255,255,255,0.92); }
        @yield('styles')
    </style>
    @stack('head')
</head>
<body class="bg-gray-50 antialiased min-h-screen flex flex-col">

    {{-- ═══════ NAVBAR ═══════ --}}
    <nav class="nav-blur fixed top-0 left-0 right-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" class="h-16 w-auto">
            </a>

            {{-- Liens nav --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}#programmes"
                   class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-gray-500 hover:text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">
                    Programmes
                </a>
                <a href="{{ route('home') }}#pourquoi"
                   class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                    Pourquoi nous
                </a>
                <a href="{{ route('home') }}#galerie"
                   class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">
                    Campus
                </a>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                @auth
                <a href="{{ route('dashboard') }}"
                   class="text-sm font-semibold text-sigan-blue hover:text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-50 flex items-center gap-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Administration
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                    Connexion
                </a>
                @endauth

                @unless(request()->routeIs('preinscription.*'))
                <a href="{{ route('preinscription.verify-email') }}"
                   class="text-sm font-semibold text-white bg-sigan-blue hover:bg-blue-700 px-5 py-2.5 rounded-xl shadow-sm transition-colors">
                    S'inscrire
                </a>
                @endunless
            </div>
        </div>
    </nav>

    {{-- ═══════ CONTENU ═══════ --}}
    <div class="flex-1 pt-16">
        @yield('content')
    </div>

    {{-- ═══════ FOOTER ═══════ --}}
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" class="h-8 w-auto opacity-60">
                <p class="text-sm text-center">© {{ date('Y') }} HOREB ACADEMY. Tous droits réservés.</p>
                <a href="{{ route('login') }}" class="text-sm hover:text-white transition-colors">Espace administration</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
