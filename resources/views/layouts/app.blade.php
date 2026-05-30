<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administration') — HOREB ACADEMY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .nav-item { display:flex; align-items:center; gap:0.75rem; padding:0.6rem 0.75rem; border-radius:0.75rem; font-size:0.875rem; font-weight:500; color:#6b7280; transition:all 0.15s; }
        .nav-item:hover { background:#f3f4f6; color:#111827; }
        .nav-item.active { background:#1a56db; color:#fff; }
        .nav-item.active:hover { background:#1d4ed8; color:#fff; }
        .nav-item.danger { color:#f87171; }
        .nav-item.danger:hover { background:#fef2f2; color:#dc2626; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-900" x-data="{ open: false }">

<div class="flex min-h-screen">

    {{-- ═══════ SIDEBAR ═══════ --}}
    <aside class="sidebar hidden lg:flex flex-col fixed top-0 left-0 h-full bg-white border-r border-gray-100 z-30 py-6">

        {{-- Logo --}}
        <div class="px-5 mb-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" class="h-20 w-auto">
            </a>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 space-y-0.5 overflow-y-auto">

            @hasrole('admin')
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 px-3 pb-2 pt-1">Général</p>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Tableau de bord
            </a>
            @endhasrole

            @hasrole('academique|admin')
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 px-3 pb-2 pt-4">Académique</p>
            <a href="{{ route('academique.inscriptions.index') }}" class="nav-item {{ request()->routeIs('academique.*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Dossiers d'inscription
                @php $pending = \App\Models\Inscription::where('statut','en_attente')->count(); @endphp
                @if($pending > 0)
                <span class="ml-auto bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $pending }}</span>
                @endif
            </a>
            @endhasrole

            @hasrole('comptable|admin')
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 px-3 pb-2 pt-4">Comptabilité</p>
            <a href="#" class="nav-item">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Paiements
            </a>
            @endhasrole

        </nav>

        {{-- Footer sidebar --}}
        <div class="px-3 mt-4 pt-4 border-t border-gray-100">
            <a href="{{ route('profile.edit') }}" class="nav-item">
                <div class="w-7 h-7 rounded-lg bg-sigan-blue/10 flex items-center justify-center flex-shrink-0 font-bold text-sigan-blue text-xs">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-gray-400">
                        @if(Auth::user()->hasRole('admin')) Admin
                        @elseif(Auth::user()->hasRole('academique')) Dir. Académique
                        @elseif(Auth::user()->hasRole('comptable')) Comptable
                        @else Utilisateur @endif
                    </p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" id="form-logout" class="mt-0.5">
                @csrf
                <button type="button"
                        @click="$dispatch('confirm-modal', {
                            title: 'Déconnexion',
                            message: 'Vous allez être déconnecté de votre session. Confirmer ?',
                            confirmText: 'Se déconnecter',
                            type: 'warning',
                            formId: 'form-logout'
                        })"
                        class="nav-item w-full text-left text-red-400 hover:bg-red-50 hover:text-red-600">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══════ MAIN ═══════ --}}
    <div class="flex-1 lg:ml-[240px] flex flex-col min-h-screen">

        {{-- Top bar --}}
        <header class="bg-white border-b border-gray-100 sticky top-0 z-20 h-14 flex items-center px-6 gap-4">
            <button @click="open = !open" class="lg:hidden text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="flex-1">
                <h1 class="text-sm font-semibold text-gray-900">@yield('title', 'Tableau de bord')</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="text-xs text-gray-400 hover:text-gray-600 font-medium flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Site public
                </a>
                <div class="h-4 w-px bg-gray-200"></div>
                <div class="text-xs font-medium text-gray-600">{{ now()->format('d/m/Y') }}</div>
            </div>
        </header>

        {{-- Mobile sidebar --}}
        <div x-show="open" @click="open = false" class="fixed inset-0 bg-black/40 z-20 lg:hidden" x-transition.opacity></div>
        <aside x-show="open" class="fixed top-0 left-0 h-full w-64 bg-white border-r border-gray-100 z-30 lg:hidden flex flex-col py-6 shadow-xl" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
            <div class="px-5 mb-8">
                <span class="font-bold text-gray-900 text-sm">HOREB <span class="text-sigan-blue font-light">academy</span></span>
            </div>
            <nav class="flex-1 px-3 space-y-0.5">
                @hasrole('admin')
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Tableau de bord
                </a>
                @endhasrole
                @hasrole('academique|admin')
                <a href="{{ route('academique.inscriptions.index') }}" class="nav-item {{ request()->routeIs('academique.*') ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Dossiers d'inscription
                </a>
                @endhasrole
            </nav>
        </aside>

        {{-- Alerts --}}
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3 mb-4">
                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl px-4 py-3 mb-4">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm1-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- Content --}}
        <main class="flex-1 px-6 pb-8">
            @yield('content')
        </main>
    </div>
</div>

{{-- ═══ MODAL DE CONFIRMATION RÉUTILISABLE ═══ --}}
<div x-data="confirmModal()" @confirm-modal.window="open($event.detail)" x-cloak>
    <div x-show="show" class="fixed inset-0 z-[999] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="cancel()"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 z-10"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" :class="iconBg">
                    <svg class="w-5 h-5" :class="iconColor" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" x-bind:d="iconPath"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-black text-gray-900" x-text="title"></h3>
                    <p class="text-sm text-gray-400 mt-1 leading-relaxed" x-text="message"></p>
                </div>
            </div>
            <div class="flex gap-3">
                <button @click="cancel()" class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Annuler
                </button>
                <button @click="confirm()" class="flex-1 py-2.5 text-white text-sm font-bold rounded-xl transition-colors" :class="btnClass" x-text="confirmText"></button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('confirmModal', () => ({
        show: false, title: '', message: '', confirmText: 'Confirmer', type: 'warning', formId: null,
        get iconBg()   { return {'danger':'bg-red-100','warning':'bg-amber-100','success':'bg-green-100','info':'bg-blue-100'}[this.type]??'bg-gray-100'; },
        get iconColor(){ return {'danger':'text-red-600','warning':'text-amber-500','success':'text-green-600','info':'text-blue-600'}[this.type]??'text-gray-600'; },
        get iconPath() { return this.type==='success' ? 'M5 13l4 4L19 7' : 'M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'; },
        get btnClass() { return {'danger':'bg-red-600 hover:bg-red-700','warning':'bg-amber-500 hover:bg-amber-600','success':'bg-green-600 hover:bg-green-700','info':'bg-sigan-blue hover:bg-blue-700'}[this.type]??'bg-gray-600'; },
        open(d) { this.title=d.title??'Confirmation'; this.message=d.message??'Continuer ?'; this.confirmText=d.confirmText??'Confirmer'; this.type=d.type??'warning'; this.formId=d.formId??null; this.show=true; },
        confirm() { this.show=false; if(this.formId){ const f=document.getElementById(this.formId); if(f) f.submit(); } },
        cancel()  { this.show=false; },
    }));
});
</script>

</body>
</html>
