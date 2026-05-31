@extends('layouts.public')
@section('title', 'Paiement sécurisé')

@section('content')
{{-- override le slot nav droit avec badge sécurisé --}}

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1a56db 100%);" class="py-10">
        <div class="max-w-6xl mx-auto px-6">
            <p class="text-blue-200/70 text-xs font-semibold uppercase tracking-widest mb-2">Finalisation de l'inscription</p>
            <h1 class="text-2xl lg:text-3xl font-black text-white">Paiement des frais de validation d'inscription</h1>
            <p class="text-blue-100/60 text-sm mt-1">Complétez votre paiement pour confirmer votre inscription à HOREB ACADEMY.</p>
        </div>
    </div>

    {{-- Contenu --}}
    <div class="max-w-6xl mx-auto w-full px-6 py-10">

        @if(session('error'))
        <div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-bold">Erreur de paiement</p>
                <p class="text-sm mt-0.5 opacity-90">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if(session('info'))
        <div class="mb-6 flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-700 px-5 py-4 rounded-2xl">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p class="text-sm font-bold">Information</p>
                <p class="text-sm mt-0.5 opacity-90">{{ session('info') }}</p>
            </div>
        </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- Colonne gauche : infos étudiant --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Récapitulatif étudiant --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-gray-800">Informations de l'étudiant</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-sigan-blue/10 flex items-center justify-center font-black text-sigan-blue text-lg flex-shrink-0">
                                {{ strtoupper(substr($inscription->etudiant->prenom, 0, 1) . substr($inscription->etudiant->nom, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-base font-black text-gray-900">{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</p>
                                <p class="text-sm text-gray-400">{{ $inscription->etudiant->email_personnel }}</p>
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-400 font-medium mb-1">Téléphone</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $inscription->etudiant->telephone }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-400 font-medium mb-1">Filière</p>
                                <p class="text-sm font-semibold text-sigan-blue">{{ $inscription->filiere->nom ?? '—' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-400 font-medium mb-1">Niveau</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $inscription->niveau }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-4">
                                <p class="text-xs text-gray-400 font-medium mb-1">Année académique</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $inscription->annee_academique }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modes de paiement acceptés --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-bold text-gray-800 mb-4">Modes de paiement acceptés</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach(['Mobile Money', 'MTN MoMo', 'Moov Money', 'Carte bancaire'] as $mode)
                        <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2.5">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span class="text-xs font-semibold text-gray-600">{{ $mode }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Colonne droite : montant + bouton --}}
            <div class="space-y-5">

                {{-- Montant --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-gray-800">Récapitulatif</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3 text-sm">
                            <span class="text-gray-500">Frais de validation d'inscription</span>
                            <span class="font-semibold text-gray-800">{{ number_format($inscription->filiere->frais_inscription, 0, ',', ' ') }} XOF</span>
                        </div>
                        <div class="flex items-center justify-between mb-5 text-sm">
                            <span class="text-gray-500">Frais de dossier</span>
                            <span class="font-semibold text-gray-800">0 XOF</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                            <span class="text-sm font-bold text-gray-900">Total à payer</span>
                            <span class="text-2xl font-black text-sigan-blue">{{ number_format($inscription->filiere->frais_inscription, 0, ',', ' ') }}<span class="text-sm font-medium text-gray-400 ml-1">XOF</span></span>
                        </div>
                    </div>
                </div>

                {{-- Bouton paiement --}}
                <form action="{{ route('paiement.payer', ['token' => $inscription->token_paiement]) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2.5 bg-sigan-blue text-white font-bold text-sm px-6 py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-sigan-blue/20 hover:shadow-xl hover:scale-[1.01] active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Payer via FedaPay
                    </button>
                </form>

                {{-- Sécurité --}}
                <div class="bg-green-50 border border-green-100 rounded-2xl p-4 space-y-2">
                    <div class="flex items-center gap-2 text-xs text-green-700 font-semibold">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Paiement 100% sécurisé
                    </div>
                    <p class="text-xs text-green-600/80">Vos données sont chiffrées et protégées par FedaPay. HOREB ACADEMY ne stocke aucune information bancaire.</p>
                </div>

            </div>
        </div>
    </div>

@endsection
