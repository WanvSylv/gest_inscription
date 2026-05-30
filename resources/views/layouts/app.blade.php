<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tableau de bord') — HOREB ACADEMY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900" x-data="{ sidebarOpen: false }">

    {{-- ═══════ TOP NAV BAR ═══════ --}}
    <header class="bg-sigan-blue text-white h-16 fixed top-0 left-0 right-0 z-30 flex items-center px-6 shadow-lg shadow-sigan-blue/15">
        {{-- Mobile burger --}}
        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden mr-4 text-white/80 hover:text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>

        {{-- Logo --}}
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center border border-white/10">
                <span class="text-white font-extrabold text-xs">HA</span>
            </div>
            <span class="text-lg font-bold tracking-wider hidden sm:block">HOREB <span class="font-light opacity-90">academy</span></span>
        </div>

        {{-- Right side --}}
        <div class="ml-auto flex items-center gap-4">
            {{-- User info --}}
            <div class="hidden sm:flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-white/60 font-medium">
                        @if(Auth::user()->hasRole('admin')) Administrateur
                        @elseif(Auth::user()->hasRole('academique')) Dir. Académique
                        @elseif(Auth::user()->hasRole('comptable')) Comptable
                        @else Utilisateur
                        @endif
                    </p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center font-bold text-sm border border-white/10">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
            </div>
            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 text-sm text-white/60 hover:text-white transition-colors px-3 py-1.5 rounded-lg hover:bg-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span class="hidden sm:inline">Déconnexion</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex pt-16 min-h-screen">

        {{-- ═══════ SIDEBAR ═══════ --}}
        <aside class="fixed top-16 left-0 bottom-0 w-[260px] bg-white border-r border-gray-100 z-20 transform transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto shadow-sm"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <nav class="p-5 space-y-1">

                @hasrole('academique|admin')
                <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 px-3 pt-3 pb-2">Direction Académique</p>

                <a href="{{ route('academique.inscriptions.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('academique.*') ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                {{ request()->routeIs('academique.*') ? 'bg-white/20' : 'bg-gray-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    Dossiers d'inscription
                </a>
                @endhasrole

                @hasrole('admin')
                <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 px-3 pt-5 pb-2">Administration</p>

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                          {{ request()->routeIs('dashboard') ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0
                                {{ request()->routeIs('dashboard') ? 'bg-white/20' : 'bg-gray-100' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    Tableau de bord
                </a>
                @endhasrole

                @hasrole('comptable')
                <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-gray-400 px-3 pt-5 pb-2">Comptabilité</p>

                <a href="#"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    Paiements
                </a>
                @endhasrole

            </nav>

            {{-- Sidebar footer --}}
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-gray-50/50">
                <div class="flex items-center gap-2 text-[11px] text-gray-400">
                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    HOREB Academy v1.0
                </div>
            </div>
        </aside>

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             class="fixed inset-0 bg-black/40 backdrop-blur-sm z-10 lg:hidden" x-transition.opacity></div>

        {{-- ═══════ MAIN CONTENT ═══════ --}}
        <main class="flex-1 lg:ml-[260px] p-6 lg:p-8">

            @if(session('success'))
            <div class="mb-6 flex items-center bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-5 py-4 shadow-sm">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                </div>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 flex items-center bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl px-5 py-4 shadow-sm">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                </div>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
