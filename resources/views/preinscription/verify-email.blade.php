@extends('layouts.public')
@section('title', 'Vérification email')

@section('content')

<div style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1a56db 100%);" class="py-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-blue-200/70 text-xs font-semibold uppercase tracking-widest mb-2">Étape préliminaire</p>
        <h1 class="text-3xl font-black text-white mb-2">Vérification de votre email</h1>
        <p class="text-blue-100/60 text-sm">Confirmez votre adresse email avant de commencer votre pré-inscription.</p>
    </div>
</div>

<div class="flex items-center justify-center px-6 py-12">
    <div class="w-full max-w-md">

        @if(session('error'))
        <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-2xl text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-8">
                <div class="w-14 h-14 bg-sigan-blue/10 rounded-2xl flex items-center justify-center mb-6">
                    <svg class="w-7 h-7 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                </div>
                <h2 class="text-xl font-black text-gray-900 mb-1">Saisissez votre email</h2>
                <p class="text-sm text-gray-400 mb-6">Nous vous enverrons un code à 6 chiffres pour vérifier que cette adresse vous appartient.</p>

                <form action="{{ route('preinscription.send-otp') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="votre@email.com" autofocus
                               value="{{ old('email') }}"
                               class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm text-gray-900 focus:outline-none focus:border-sigan-blue focus:ring-2 focus:ring-sigan-blue/10 transition-all">
                        @error('email')
                        <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 bg-sigan-blue text-white font-bold text-sm py-3.5 rounded-xl hover:bg-blue-700 transition-all shadow-sm active:scale-95">
                        Recevoir mon code
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </button>
                </form>
            </div>
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400">Déjà inscrit ? <a href="{{ route('login') }}" class="text-sigan-blue font-semibold hover:underline">Connectez-vous</a></p>
            </div>
        </div>

    </div>
</div>
@endsection
