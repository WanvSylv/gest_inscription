@extends('layouts.app')
@section('title', 'Mon profil')

@section('content')
<div class="pt-6 space-y-5">

    {{-- En-tête --}}
    <div>
        <h2 class="text-xl font-black text-gray-900">Mon profil</h2>
        <p class="text-sm text-gray-400 mt-0.5">Gérez vos informations personnelles et la sécurité de votre compte.</p>
    </div>

    {{-- Avatar + infos --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-sigan-blue flex items-center justify-center font-black text-white text-xl flex-shrink-0">
            {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-lg font-black text-gray-900">{{ $user->name }}</p>
            <p class="text-sm text-gray-400">{{ $user->email }}</p>
            <span class="inline-block mt-1.5 text-xs font-bold px-2.5 py-0.5 rounded-full bg-sigan-blue/10 text-sigan-blue">
                @if(Auth::user()->hasRole('admin')) Administrateur
                @elseif(Auth::user()->hasRole('academique')) Directeur Académique
                @elseif(Auth::user()->hasRole('comptable')) Comptable
                @else Utilisateur @endif
            </span>
        </div>
        <div class="hidden sm:flex items-center gap-4 text-right flex-shrink-0">
            <div>
                <p class="text-xs text-gray-400">Membre depuis</p>
                <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->created_at->format('M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Grille 2 colonnes --}}
    <div class="grid lg:grid-cols-2 gap-5">

        {{-- Informations du compte --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800">Informations du compte</h3>
                <p class="text-xs text-gray-400 mt-0.5">Modifiez votre nom et votre adresse e-mail.</p>
            </div>
            <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-5">
                @csrf
                @method('patch')
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nom complet</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:border-sigan-blue focus:ring-2 focus:ring-sigan-blue/10 transition-all">
                    @error('name')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse e-mail</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:border-sigan-blue focus:ring-2 focus:ring-sigan-blue/10 transition-all">
                    @error('email')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-3 pt-1">
                    <button type="submit" class="px-5 py-2.5 bg-sigan-blue text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                        Enregistrer
                    </button>
                    @if(session('status') === 'profile-updated')
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)" class="text-xs text-green-600 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Sauvegardé
                    </span>
                    @endif
                </div>
            </form>
        </div>

        {{-- Mot de passe --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800">Changer le mot de passe</h3>
                <p class="text-xs text-gray-400 mt-0.5">Utilisez un mot de passe long et aléatoire.</p>
            </div>
            <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-5">
                @csrf
                @method('put')
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe actuel</label>
                    <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:border-sigan-blue focus:ring-2 focus:ring-sigan-blue/10 transition-all">
                    @error('current_password', 'updatePassword')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Nouveau mot de passe</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:border-sigan-blue focus:ring-2 focus:ring-sigan-blue/10 transition-all">
                    @error('password', 'updatePassword')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:border-sigan-blue focus:ring-2 focus:ring-sigan-blue/10 transition-all">
                    @error('password_confirmation', 'updatePassword')<p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-3 pt-1">
                    <button type="submit" class="px-5 py-2.5 bg-sigan-blue text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                        Mettre à jour
                    </button>
                    @if(session('status') === 'password-updated')
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 2500)" class="text-xs text-green-600 font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Mis à jour
                    </span>
                    @endif
                </div>
            </form>
        </div>

    </div>

    {{-- Zone danger --}}
    <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-red-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-red-700">Zone dangereuse</h3>
                <p class="text-xs text-gray-400 mt-0.5">La suppression de votre compte est irréversible et permanente.</p>
            </div>
            <button type="button" x-data @click="$dispatch('open-delete-modal')"
                    class="px-5 py-2.5 border border-red-200 text-red-600 text-sm font-bold rounded-xl hover:bg-red-50 transition-colors flex-shrink-0">
                Supprimer mon compte
            </button>
        </div>
    </div>

</div>

{{-- Modal suppression --}}
<div x-data="{ open: false }" @open-delete-modal.window="open = true">
    <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" style="display:none">
        <div @click.stop class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-base font-black text-gray-900 mb-1">Supprimer le compte</h3>
            <p class="text-sm text-gray-500 mb-5">Cette action est permanente. Entrez votre mot de passe pour confirmer.</p>
            <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                @csrf
                @method('delete')
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Mot de passe</label>
                    <input type="password" name="password" required placeholder="••••••••"
                           class="block w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 transition-all">
                    @error('password', 'userDeletion')
                    <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit" class="flex-1 py-2.5 bg-red-600 text-white text-sm font-bold rounded-xl hover:bg-red-700 transition-colors">
                        Supprimer définitivement
                    </button>
                    <button type="button" @click="open = false" class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-sm font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
