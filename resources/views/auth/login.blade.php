<x-guest-layout>
    <x-auth-session-status class="mb-5" :status="session('status')" />

    {{-- En-tête --}}
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-gray-900 mb-2" style="font-family:'Playfair Display',serif;">
            Connexion
        </h2>
        <p class="text-sm text-gray-400 leading-relaxed" style="font-weight:300;">
            Accédez à votre espace dédiée.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest mb-1.5">
                Adresse email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       placeholder="votre@email.com"
                       class="login-input">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Mot de passe --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-gray-500 uppercase tracking-widest">
                    Mot de passe
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs font-medium text-sigan-blue hover:underline">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" :type="show ? 'text' : 'password'"
                       name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="login-input !pr-11">
                <button type="button" @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <input type="hidden" name="remember" value="on">

        {{-- Bouton submit --}}
        <div class="pt-1">
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-sigan-blue text-white text-sm font-semibold tracking-wide hover:bg-blue-700 active:scale-[0.99] transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigan-blue shadow-md shadow-blue-600/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Se connecter
            </button>
        </div>

        {{-- Séparateur --}}
        <div class="flex items-center gap-3 py-1">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-xs text-gray-300">ou</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        {{-- Lien inscription --}}
        <p class="text-center text-sm text-gray-400">
            Pas encore inscrit ?
            <a href="{{ route('preinscription.create') }}" class="text-sigan-blue font-semibold hover:underline">
                Faire une pré-inscription
            </a>
        </p>

    </form>
</x-guest-layout>