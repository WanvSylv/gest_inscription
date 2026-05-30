@extends('layouts.app')
@section('title', 'Dossier — ' . $inscription->etudiant->full_name)

@section('content')

@php
    $statutInfo = \App\Models\Inscription::STATUTS[$inscription->statut] ?? ['label' => $inscription->statut, 'color' => 'gray'];
    $statutClasses = match($statutInfo['color']) {
        'yellow' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20',
        'blue'   => 'bg-blue-100 text-blue-800 ring-blue-600/20',
        'orange' => 'bg-orange-100 text-orange-800 ring-orange-600/20',
        'red'    => 'bg-red-100 text-red-800 ring-red-600/20',
        'purple' => 'bg-purple-100 text-purple-800 ring-purple-600/20',
        'green'  => 'bg-green-100 text-green-800 ring-green-600/20',
        default  => 'bg-gray-100 text-gray-800 ring-gray-600/20',
    };
@endphp

{{-- Breadcrumb --}}
<nav class="mb-6 flex items-center text-sm text-gray-500">
    <a href="{{ route('academique.inscriptions.index') }}" class="hover:text-sigan-blue transition-colors flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Dossiers
    </a>
    <svg class="w-4 h-4 mx-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-800 font-semibold">{{ $inscription->etudiant->full_name }}</span>
</nav>

{{-- Main Grid --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    {{-- ═══════════════════════════════════════════ --}}
    {{-- LEFT COLUMN (2/3)                          --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="xl:col-span-2 space-y-6">

        {{-- ───── Student Info Card ───── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            {{-- Header --}}
            <div class="px-6 pt-6 pb-5 flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-sigan-blue/10 flex items-center justify-center font-bold text-sigan-blue text-xl tracking-tight flex-shrink-0 ring-2 ring-sigan-blue/20">
                        {{ strtoupper(substr($inscription->etudiant->prenom, 0, 1)) }}{{ strtoupper(substr($inscription->etudiant->nom, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 leading-tight">{{ $inscription->etudiant->full_name }}</h1>
                        <p class="text-sm text-gray-500 mt-0.5">{{ $inscription->etudiant->email_personnel }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ring-1 ring-inset {{ $statutClasses }}">
                    {{ $statutInfo['label'] }}
                </span>
            </div>

            {{-- Info Fields --}}
            <div class="border-t border-gray-100 px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Informations personnelles</p>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1">Date de naissance</p>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($inscription->etudiant->date_naissance)->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1">Lieu de naissance</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $inscription->etudiant->lieu_naissance }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1">Nationalité</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $inscription->etudiant->nationalite }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1">Téléphone</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $inscription->etudiant->telephone }}</p>
                    </div>
                    <div class="lg:col-span-2">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1">Adresse</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $inscription->etudiant->adresse }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ───── Inscription Details Card ───── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Détails de la demande</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1.5">Filière</p>
                    <p class="text-sm font-bold text-gray-800 leading-snug">{{ $inscription->filiere->nom ?? '—' }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1.5">Niveau</p>
                    <p class="text-lg font-bold text-sigan-blue leading-snug">{{ $inscription->niveau }}</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-400 mb-1.5">Année académique</p>
                    <p class="text-sm font-bold text-gray-800 leading-snug">{{ $inscription->annee_academique }}</p>
                </div>
            </div>

            @if($inscription->motif_rejet)
            <div class="mt-5 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-red-700 mb-0.5">Motif de rejet précédent</p>
                    <p class="text-sm text-red-600 leading-relaxed">{{ $inscription->motif_rejet }}</p>
                </div>
            </div>
            @endif
        </div>

        {{-- ───── Pièces Justificatives Card ───── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Pièces justificatives</p>

            @if($inscription->piecesJustificatives->isEmpty())
                <div class="text-center py-8">
                    <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <p class="text-sm text-gray-400 italic">Aucune pièce jointe pour ce dossier.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($inscription->piecesJustificatives as $piece)
                    <div class="flex items-center justify-between p-3.5 bg-gray-50 rounded-lg border border-gray-200 hover:border-gray-300 hover:shadow-sm transition-all group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-red-200 transition-colors">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $libelles[$piece->type_piece] ?? $piece->type_piece }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ basename($piece->chemin_fichier) }}</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($piece->chemin_fichier) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-sigan-blue/10 text-sigan-blue text-xs font-semibold rounded-lg hover:bg-sigan-blue hover:text-white transition-colors flex-shrink-0 ml-3">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Voir
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ═══════════════════════════════════════════ --}}
    {{-- RIGHT COLUMN (1/3)                         --}}
    {{-- ═══════════════════════════════════════════ --}}
    <div class="space-y-5">

        @if($inscription->statut === 'en_attente')
        {{-- ───── Validate Card ───── --}}
        <div class="bg-white rounded-xl shadow-sm border border-green-200 p-6">
            <div class="flex items-center gap-2.5 mb-2">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h3 class="font-bold text-green-700 text-sm">Valider le dossier</h3>
            </div>
            <p class="text-xs text-gray-500 leading-relaxed mb-4">Cela génèrera un lien de paiement valable 72 h et notifiera l'étudiant par email.</p>
            <form method="POST" action="{{ route('academique.inscriptions.valider', $inscription) }}">
                @csrf
                @method('PATCH')
                <button type="submit"
                        onclick="return confirm('Êtes-vous sûr de vouloir valider ce dossier ? Un lien de paiement sera envoyé à l\'étudiant.')"
                        class="w-full py-2.5 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 active:bg-green-800 transition-colors flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Valider le dossier
                </button>
            </form>
        </div>

        {{-- ───── Reject Card ───── --}}
        <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6" x-data="{ open: false }">
            <div class="flex items-center gap-2.5 mb-2">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h3 class="font-bold text-red-700 text-sm">Rejeter le dossier</h3>
            </div>

            <button @click="open = !open"
                    class="w-full py-2.5 bg-red-50 text-red-700 border border-red-200 text-sm font-bold rounded-lg hover:bg-red-100 active:bg-red-200 transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                <span x-text="open ? 'Masquer le formulaire' : 'Rejeter ce dossier'"></span>
            </button>

            <div x-show="open" x-collapse x-cloak class="mt-4 pt-4 border-t border-red-100">
                <form method="POST" action="{{ route('academique.inscriptions.rejeter', $inscription) }}">
                    @csrf
                    @method('PATCH')

                    <div class="mb-3">
                        <label for="motif_rejet" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Motif du rejet <span class="text-red-500">*</span>
                        </label>
                        <textarea name="motif_rejet" id="motif_rejet" rows="4" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue transition-colors outline-none resize-none"
                                  placeholder="Expliquez clairement le motif du rejet pour permettre à l'étudiant de comprendre la décision..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-start gap-2.5 cursor-pointer group">
                            <input type="checkbox" name="autoriser_modif" value="1"
                                   class="mt-0.5 rounded border-gray-300 text-sigan-blue focus:ring-sigan-blue transition-colors">
                            <span class="text-xs text-gray-600 font-medium leading-relaxed group-hover:text-gray-800 transition-colors">
                                Autoriser l'étudiant à modifier et resoumettre son dossier
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                            class="w-full py-2.5 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 active:bg-red-800 transition-colors flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Confirmer le rejet
                    </button>
                </form>
            </div>
        </div>
        @endif

        {{-- ───── Info Box ───── --}}
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p class="text-xs font-bold text-blue-800 uppercase tracking-wide">Informations</p>
            </div>

            <div class="space-y-2.5 text-xs text-blue-700">
                <div class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>Soumis le <strong class="font-semibold">{{ $inscription->created_at->format('d/m/Y à H:i') }}</strong></p>
                </div>

                @if($inscription->date_validation)
                <div class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Validé le <strong class="font-semibold">{{ $inscription->date_validation->format('d/m/Y à H:i') }}</strong></p>
                </div>
                @endif

                @if($inscription->limite_paiement)
                <div class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p>Limite paiement : <strong class="font-semibold">{{ $inscription->limite_paiement->format('d/m/Y à H:i') }}</strong></p>
                </div>
                @endif

                <div class="flex items-start gap-2">
                    <svg class="w-3.5 h-3.5 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <p>Resoumissions : <strong class="font-semibold">{{ $inscription->nombre_resoumissions }}</strong></p>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
