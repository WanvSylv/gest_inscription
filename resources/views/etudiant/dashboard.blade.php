@extends('layouts.public')
@section('title', 'Mon espace étudiant')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-10">

    {{-- En-tête bienvenue --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-xs font-bold text-sigan-blue uppercase tracking-widest mb-1">Espace étudiant</p>
            <h1 class="text-2xl font-black text-gray-900">
                Bonjour, {{ $etudiant?->prenom ?? Auth::user()->name }} 👋
            </h1>
            @if($etudiant?->matricule)
            <p class="text-sm text-gray-400 mt-0.5">Matricule : <span class="font-mono font-bold text-gray-700">{{ $etudiant->matricule }}</span></p>
            @endif
        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 px-4 py-2 rounded-xl border border-gray-200 hover:border-red-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Se déconnecter
            </button>
        </form>
    </div>

    @if(!$etudiant || !$inscription)
    {{-- Aucun dossier trouvé --}}
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-8 text-center">
        <svg class="w-12 h-12 text-amber-400 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
        <p class="text-sm font-bold text-amber-800 mb-1">Aucun dossier associé à votre compte</p>
        <p class="text-xs text-amber-700">Contactez l'administration : <a href="mailto:horebacademy@manosphone.com" class="underline">horebacademy@manosphone.com</a></p>
    </div>
    @else

    {{-- ══ STATUT DU DOSSIER ══ --}}
    @php
    $statuts = [
        'en_attente'        => ['label' => 'Dossier en cours d\'examen',     'color' => 'amber',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',   'desc' => 'Votre dossier est en cours d\'examen par notre direction académique. Vous serez notifié par email sous 72h.'],
        'valide_academique' => ['label' => 'Dossier validé — Paiement requis','color' => 'blue',   'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Votre candidature a été acceptée ! Procédez au paiement pour finaliser votre inscription.'],
        'rejete_modifiable' => ['label' => 'Dossier à corriger',              'color' => 'orange', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z', 'desc' => 'Des corrections sont nécessaires. Consultez le motif ci-dessous et soumettez à nouveau.'],
        'rejete_definitif'  => ['label' => 'Candidature non retenue',         'color' => 'red',    'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Votre candidature n\'a pas été retenue cette année. Contactez l\'administration pour plus d\'informations.'],
        'paye'              => ['label' => 'Paiement reçu — Traitement',      'color' => 'purple', 'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'desc' => 'Votre paiement a bien été reçu. Votre inscription est en cours de finalisation.'],
        'inscrit'           => ['label' => 'Inscription confirmée ✓',         'color' => 'green',  'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'desc' => 'Félicitations ! Vous êtes officiellement inscrit(e) à HOREB ACADEMY.'],
    ];
    $s = $statuts[$inscription->statut] ?? ['label' => $inscription->statut, 'color' => 'gray', 'icon' => '', 'desc' => ''];
    $colors = [
        'amber'  => ['bg' => 'bg-amber-50',  'border' => 'border-amber-200', 'icon_bg' => 'bg-amber-100',  'icon_c' => 'text-amber-600',  'text' => 'text-amber-800',  'sub' => 'text-amber-700'],
        'blue'   => ['bg' => 'bg-blue-50',   'border' => 'border-blue-200',  'icon_bg' => 'bg-blue-100',   'icon_c' => 'text-blue-600',   'text' => 'text-blue-800',   'sub' => 'text-blue-700'],
        'orange' => ['bg' => 'bg-orange-50', 'border' => 'border-orange-200','icon_bg' => 'bg-orange-100', 'icon_c' => 'text-orange-600', 'text' => 'text-orange-800', 'sub' => 'text-orange-700'],
        'red'    => ['bg' => 'bg-red-50',    'border' => 'border-red-200',   'icon_bg' => 'bg-red-100',    'icon_c' => 'text-red-600',    'text' => 'text-red-800',    'sub' => 'text-red-700'],
        'purple' => ['bg' => 'bg-purple-50', 'border' => 'border-purple-200','icon_bg' => 'bg-purple-100', 'icon_c' => 'text-purple-600', 'text' => 'text-purple-800', 'sub' => 'text-purple-700'],
        'green'  => ['bg' => 'bg-green-50',  'border' => 'border-green-200', 'icon_bg' => 'bg-green-100',  'icon_c' => 'text-green-600',  'text' => 'text-green-800',  'sub' => 'text-green-700'],
        'gray'   => ['bg' => 'bg-gray-50',   'border' => 'border-gray-200',  'icon_bg' => 'bg-gray-100',   'icon_c' => 'text-gray-600',   'text' => 'text-gray-800',   'sub' => 'text-gray-600'],
    ];
    $c = $colors[$s['color']];
    @endphp

    <div class="{{ $c['bg'] }} {{ $c['border'] }} border rounded-2xl p-6 mb-6 flex items-start gap-4">
        <div class="{{ $c['icon_bg'] }} rounded-xl w-12 h-12 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 {{ $c['icon_c'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-black {{ $c['text'] }} text-base mb-1">{{ $s['label'] }}</p>
            <p class="{{ $c['sub'] }} text-sm leading-relaxed">{{ $s['desc'] }}</p>

            {{-- Motif rejet --}}
            @if($inscription->motif_rejet && in_array($inscription->statut, ['rejete_modifiable', 'rejete_definitif']))
            <div class="mt-3 bg-white/60 border border-red-200 rounded-xl p-3">
                <p class="text-xs font-bold text-red-700 mb-0.5">Motif communiqué :</p>
                <p class="text-sm text-red-600">{{ $inscription->motif_rejet }}</p>
            </div>
            @endif

            {{-- Bouton paiement si validé --}}
            @if($inscription->statut === 'valide_academique' && $inscription->token_paiement)
            <div class="mt-4">
                <a href="{{ route('paiement.show', ['token' => $inscription->token_paiement]) }}"
                   class="inline-flex items-center gap-2 bg-sigan-blue text-white text-sm font-bold px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Procéder au paiement
                </a>
                @if($inscription->limite_paiement)
                <p class="text-xs text-blue-600 mt-2">⏰ Limite : {{ $inscription->limite_paiement->format('d/m/Y à H:i') }}</p>
                @endif
            </div>
            @endif
        </div>
    </div>

    {{-- ══ GRILLE INFOS ══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Détails inscription --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Votre inscription</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Filière</span>
                    <span class="text-sm font-bold text-sigan-blue">{{ $inscription->filiere->nom ?? '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Niveau</span>
                    <span class="text-sm font-bold text-gray-800">{{ $inscription->niveau }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Année académique</span>
                    <span class="text-sm font-bold text-gray-800">{{ $inscription->annee_academique }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Dossier déposé le</span>
                    <span class="text-sm font-semibold text-gray-600">{{ $inscription->created_at->format('d/m/Y') }}</span>
                </div>
                @if($inscription->frais_validation && $inscription->frais_validation > 0)
                <div class="flex justify-between items-center border-t border-gray-50 pt-4">
                    <span class="text-sm text-gray-400">Frais d'inscription</span>
                    <span class="text-base font-black text-sigan-blue">{{ number_format($inscription->frais_validation, 0, ',', ' ') }} XOF</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Informations personnelles --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-50">
                <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Vos informations</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Nom complet</span>
                    <span class="text-sm font-bold text-gray-800">{{ $etudiant->prenom }} {{ $etudiant->nom }}</span>
                </div>
                <div class="flex justify-between items-start">
                    <span class="text-sm text-gray-400">Email personnel</span>
                    <span class="text-sm font-semibold text-gray-700 text-right max-w-[60%] break-all">{{ $etudiant->email_personnel }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Téléphone</span>
                    <span class="text-sm font-semibold text-gray-700">{{ $etudiant->telephone }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Nationalité</span>
                    <span class="text-sm font-semibold text-gray-700">{{ $etudiant->nationalite }}</span>
                </div>
                @if($etudiant->matricule)
                <div class="flex justify-between items-center border-t border-gray-50 pt-4">
                    <span class="text-sm text-gray-400">Matricule</span>
                    <span class="font-mono text-sm font-black text-sigan-blue">{{ $etudiant->matricule }}</span>
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- ══ PAIEMENT ══ --}}
    @if($paiement)
    <div class="bg-white rounded-2xl border border-green-100 shadow-sm overflow-hidden mb-5">
        <div class="px-6 py-4 border-b border-green-50 flex items-center justify-between">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Paiement</p>
            <span class="text-xs font-bold bg-green-100 text-green-700 px-3 py-1 rounded-full">Confirmé ✓</span>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-2xl font-black text-green-600">{{ number_format($paiement->montant, 0, ',', ' ') }} <span class="text-sm font-medium text-gray-400">XOF</span></p>
                    <p class="text-xs text-gray-400 mt-0.5">Payé le {{ $paiement->paye_le?->format('d/m/Y à H:i') }}</p>
                </div>
                @if($paiement->recu_chemin)
                <a href="{{ Storage::url($paiement->recu_chemin) }}" target="_blank"
                   class="flex items-center gap-2 text-sm font-bold text-sigan-blue border border-sigan-blue/30 px-4 py-2.5 rounded-xl hover:bg-blue-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Télécharger le reçu PDF
                </a>
                @endif
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-0.5">N° Transaction</p>
                    <p class="text-xs font-mono font-bold text-gray-700 break-all">{{ $paiement->transaction_id }}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Moyen de paiement</p>
                    <p class="text-sm font-bold text-gray-700">{{ ucfirst(str_replace('_', ' ', $paiement->methode ?? 'Mobile Money')) }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ══ DOCUMENTS SOUMIS ══ --}}
    @if($inscription->piecesJustificatives->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
        <div class="px-6 py-4 border-b border-gray-50">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Documents soumis</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @php
                $labels = [
                    'releve_bac'          => 'Relevé BAC',
                    'releves_l1'          => 'Relevés L1',
                    'releves_l2'          => 'Relevés L2',
                    'attestation_licence' => 'Attestation Licence',
                    'releves_m1'          => 'Relevés M1',
                    'photo'               => 'Photo d\'identité',
                    'carte_identite'      => 'Carte d\'identité',
                    'acte_naissance'      => 'Acte de naissance',
                ];
                @endphp
                @foreach($inscription->piecesJustificatives as $piece)
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-8 h-8 bg-sigan-blue/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-700 truncate">{{ $labels[$piece->type_piece] ?? $piece->type_piece }}</p>
                        <p class="text-[10px] text-gray-400">{{ $piece->created_at->format('d/m/Y') }}</p>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $piece->statut_verification === 'valide' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $piece->statut_verification === 'valide' ? 'Vérifié' : 'En attente' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ CONTACT ══ --}}
    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5 text-center">
        <p class="text-sm text-gray-600 mb-1">Besoin d'aide ou d'informations ?</p>
        <a href="mailto:horebacademy@manosphone.com" class="text-sigan-blue font-bold text-sm hover:underline">horebacademy@manosphone.com</a>
    </div>

    @endif {{-- fin @if(!$etudiant) --}}
</div>
@endsection
