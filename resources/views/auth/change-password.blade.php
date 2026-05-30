<x-guest-layout>
    <div class="mb-8">
        <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center mb-5">
            <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Première connexion</h2>
        <p class="text-gray-500 text-sm leading-relaxed">
            Pour des raisons de sécurité, veuillez définir votre mot de passe définitif avant de continuer.
        </p>
    </div>

    <form method="POST" action="{{ route('password.change.store') }}" class="space-y-5">
        @csrf

        <!-- Current Password -->
        <div>
            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe provisoire</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <input id="current_password" type="password" name="current_password" required autofocus
                       placeholder="Mot de passe reçu par email"
                       class="login-input">
            </div>
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Nouveau mot de passe</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       placeholder="Minimum 8 caractères"
                       class="login-input">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmer le nouveau mot de passe</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       placeholder="Retapez le nouveau mot de passe"
                       class="login-input">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-3.5 px-4 bg-sigan-blue text-white text-sm font-bold rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigan-blue transition-all shadow-lg shadow-sigan-blue/25">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                Enregistrer et continuer
            </button>
        </div>
    </form>
</x-guest-layout>
