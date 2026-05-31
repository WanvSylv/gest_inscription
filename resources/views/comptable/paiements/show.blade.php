@extends('layouts.app')
@section('title', 'Détails du paiement — ' . $paiement->transaction_id)

@section('content')
@php
$badgeColors = [
    'approved'  => 'bg-green-100 text-green-700 border-green-200',
    'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
    'declined'  => 'bg-red-100 text-red-700 border-red-200',
    'cancelled' => 'bg-gray-100 text-gray-700 border-gray-200',
];
$dotColors = [
    'approved'  => 'bg-green-500',
    'pending'   => 'bg-amber-500',
    'declined'  => 'bg-red-500',
    'cancelled' => 'bg-gray-500',
];
$statutLabels = [
    'approved'  => 'Validé',
    'pending'   => 'En attente',
    'declined'  => 'Échoué',
    'cancelled' => 'Annulé',
];
@endphp

<div class="pt-6 space-y-6">

    {{-- Breadcrumbs & Retour --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <nav class="flex items-center text-sm text-gray-500 gap-1.5">
            <a href="{{ route('comptable.paiements.index') }}" class="hover:text-sigan-blue transition-colors flex items-center gap-1 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Paiements
            </a>
            <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-800 font-bold truncate">Détails de la transaction</span>
        </nav>

        <a href="{{ route('comptable.paiements.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
            Retour au suivi
        </a>
    </div>

    {{-- Session notifications if any --}}
    @if(session('error'))
    <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl text-sm font-semibold flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Receipt Mockup (Takes 2 cols on lg) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden relative">
                
                {{-- Decorative premium colored bar --}}
                <div class="h-2 bg-gradient-to-r from-sigan-blue via-indigo-500 to-purple-600"></div>

                <div class="p-6 sm:p-8 space-y-8">
                    {{-- Logo & Receipt title --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-gray-100">
                        <div>
                            <div class="text-xl font-black text-sigan-blue tracking-tight">HOREB ACADEMY</div>
                            <p class="text-xs text-gray-400 mt-0.5">L'excellence au service de votre avenir</p>
                        </div>
                        <div class="text-right sm:text-right">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 border rounded-full text-xs font-bold {{ $badgeColors[$paiement->statut] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dotColors[$paiement->statut] ?? 'bg-gray-400' }}"></span>
                                {{ $statutLabels[$paiement->statut] ?? $paiement->statut }}
                            </span>
                            <p class="text-[10px] text-gray-400 font-bold mt-1.5 uppercase tracking-wider">Transaction : {{ $paiement->transaction_id }}</p>
                        </div>
                    </div>

                    {{-- Receipt Mockup Main Info --}}
                    <div class="bg-gray-50/50 rounded-2xl border border-gray-100 p-6 flex flex-col items-center text-center relative overflow-hidden">
                        {{-- Watermark background --}}
                        <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none select-none">
                            <svg class="w-48 h-48 text-sigan-blue" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/></svg>
                        </div>

                        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-2">Montant du Paiement</span>
                        <h1 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-tight">
                            {{ number_format($paiement->montant, 0, ',', ' ') }}
                            <span class="text-lg font-extrabold text-sigan-blue ml-1">{{ $paiement->devise }}</span>
                        </h1>
                        <p class="text-xs text-gray-400 mt-1">Frais d'inscription académique</p>
                    </div>

                    {{-- Transaction Metadata Grid --}}
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Informations de Transaction</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-sm">
                            
                            {{-- ID Transaction --}}
                            <div class="flex justify-between py-2 border-b border-gray-50 sm:border-0 sm:py-0">
                                <span class="text-gray-400 font-medium">Référence FedaPay :</span>
                                <span class="font-bold text-gray-800 break-all select-all">{{ $paiement->transaction_id }}</span>
                            </div>

                            {{-- Mode de paiement --}}
                            <div class="flex justify-between py-2 border-b border-gray-50 sm:border-0 sm:py-0">
                                <span class="text-gray-400 font-medium">Moyen de paiement :</span>
                                <span class="font-bold text-gray-800">{{ $paiement->methode ? ucfirst(str_replace('_', ' ', $paiement->methode)) : 'Non spécifié' }}</span>
                            </div>

                            {{-- Date & Heure --}}
                            <div class="flex justify-between py-2 border-b border-gray-50 sm:border-0 sm:py-0">
                                <span class="text-gray-400 font-medium">Date & Heure :</span>
                                <span class="font-bold text-gray-800">
                                    {{ $paiement->paye_le ? $paiement->paye_le->format('d/m/Y H:i:s') : $paiement->created_at->format('d/m/Y H:i:s') }}
                                </span>
                            </div>

                            {{-- Devise originale --}}
                            <div class="flex justify-between py-2 border-b border-gray-50 sm:border-0 sm:py-0">
                                <span class="text-gray-400 font-medium">Devise :</span>
                                <span class="font-bold text-gray-800">{{ $paiement->devise }}</span>
                            </div>

                        </div>
                    </div>

                    {{-- Recu Status Detail --}}
                    @if($paiement->statut === 'approved')
                    <div class="p-4 bg-green-50/50 rounded-2xl border border-green-100 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-green-800">Paiement certifié & validé</h5>
                            <p class="text-xs text-green-700/80 mt-0.5">Ce paiement a été confirmé par la passerelle de paiement FedaPay. Le reçu officiel est disponible pour téléchargement.</p>
                        </div>
                    </div>
                    @else
                    <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-100 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h5 class="text-xs font-bold text-amber-800">Paiement non finalisé</h5>
                            <p class="text-xs text-amber-700/80 mt-0.5">Le statut actuel de cette transaction est <strong>{{ $statutLabels[$paiement->statut] ?? $paiement->statut }}</strong>. Aucun reçu officiel ne peut être émis ou pris en compte tant que la transaction n'est pas validée (`approved`).</p>
                        </div>
                    </div>
                    @endif

                    {{-- Actions block --}}
                    <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        @if($paiement->statut === 'approved')
                        <a href="{{ route('comptable.paiements.recu', $paiement) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-sigan-blue text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Télécharger le reçu PDF officiel
                        </a>
                        @else
                        <button disabled
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 text-gray-400 text-sm font-bold rounded-xl cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            Reçu indisponible
                        </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        {{-- Right: Student Card & Major Card --}}
        <div class="space-y-6">

            {{-- Étudiant Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-sigan-blue/10 flex items-center justify-center text-sigan-blue">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-gray-900">Profil de l'Étudiant</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Identité académique</p>
                    </div>
                </div>

                {{-- Student Identity Block --}}
                <div class="flex items-center gap-4">
                    @if($paiement->etudiant->photo && Storage::disk('public')->exists($paiement->etudiant->photo))
                        <img src="{{ Storage::disk('public')->url($paiement->etudiant->photo) }}" alt="Photo de {{ $paiement->etudiant->full_name }}" class="w-14 h-14 rounded-2xl object-cover border border-gray-100 flex-shrink-0 shadow-sm">
                    @else
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-sigan-blue to-indigo-500 text-white font-black text-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                            {{ strtoupper(substr($paiement->etudiant->prenom, 0, 1) . substr($paiement->etudiant->nom, 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0">
                        <h5 class="text-base font-bold text-gray-900 truncate leading-tight">{{ $paiement->etudiant->full_name }}</h5>
                        <span class="inline-flex items-center px-2 py-0.5 bg-sigan-blue/5 rounded text-[10px] font-extrabold text-sigan-blue mt-1 uppercase">
                            Matricule : {{ $paiement->etudiant->matricule ?? 'Non assigné' }}
                        </span>
                    </div>
                </div>

                {{-- Contact detail lines --}}
                <div class="space-y-3.5 text-xs">
                    
                    {{-- Email --}}
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        <div class="min-w-0 flex-1">
                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Email Personnel</span>
                            <span class="font-semibold text-gray-800 break-all select-all">{{ $paiement->etudiant->email_personnel }}</span>
                        </div>
                    </div>

                    {{-- Telephone --}}
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.14-4.118-6.944-6.94l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        <div class="min-w-0 flex-1">
                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Téléphone</span>
                            <span class="font-semibold text-gray-800">{{ $paiement->etudiant->telephone ?? '—' }}</span>
                        </div>
                    </div>

                    {{-- Nationalité --}}
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l.406.34c.15.126.372.164.559.094l.569-.214a1.125 1.125 0 011.372.406l.31.41a1.125 1.125 0 01-.22 1.488l-.34.289a1.125 1.125 0 00-.332.804v.22c0 .307.12.6.332.812l.34.34a1.125 1.125 0 01.332.812v.22c0 .308-.12.6-.332.812l-.34.34a1.125 1.125 0 01-.812.332h-.22a1.125 1.125 0 00-.812.332l-.34.34a1.125 1.125 0 01-.812.332h-.22a1.125 1.125 0 00-.812.332l-.34.34a1.125 1.125 0 01-.812.332h-.22a1.125 1.125 0 00-.812.332l-.34.34a1.125 1.125 0 01-.812.332h-.22a1.125 1.125 0 00-.812.332l-.34.34a1.125 1.125 0 01-.812.332h-.22a1.125 1.125 0 00-.812.332l-.34.34a1.125 1.125 0 01-.812.332h-.22a1.125 1.125 0 00-.812.332l-.34.34a1.125 1.125 0 01-.812.332H9.75M19 12a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <div class="min-w-0 flex-1">
                            <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Nationalité</span>
                            <span class="font-semibold text-gray-800">{{ $paiement->etudiant->nationalite ?? '—' }}</span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Major / Filière Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-gray-900">Filière d'Inscription</h4>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Cible académique</p>
                    </div>
                </div>

                {{-- Filière details --}}
                <div class="space-y-4">
                    
                    {{-- Nom Filière --}}
                    <div>
                        <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-wider">Libellé</span>
                        <span class="font-bold text-gray-800 leading-tight block mt-0.5">{{ $paiement->inscription->filiere->nom ?? '—' }}</span>
                    </div>

                    {{-- Code & Niveau & Année --}}
                    <div class="grid grid-cols-3 gap-2 pt-2 text-xs">
                        <div class="p-2 bg-gray-50 rounded-xl border border-gray-100/50 text-center">
                            <span class="block text-[8px] text-gray-400 font-bold uppercase">Code</span>
                            <span class="font-extrabold text-gray-700 block mt-0.5 uppercase">{{ $paiement->inscription->filiere->code ?? '—' }}</span>
                        </div>
                        <div class="p-2 bg-gray-50 rounded-xl border border-gray-100/50 text-center">
                            <span class="block text-[8px] text-gray-400 font-bold uppercase">Niveau</span>
                            <span class="font-extrabold text-gray-700 block mt-0.5">{{ $paiement->inscription->niveau ?? '—' }}</span>
                        </div>
                        <div class="p-2 bg-gray-50 rounded-xl border border-gray-100/50 text-center">
                            <span class="block text-[8px] text-gray-400 font-bold uppercase">Année</span>
                            <span class="font-extrabold text-gray-700 block mt-0.5 whitespace-nowrap">{{ $paiement->inscription->annee_academique ?? '—' }}</span>
                        </div>
                    </div>

                    {{-- Break-down or comparison of fees --}}
                    <div class="pt-4 border-t border-dashed border-gray-100">
                        <div class="flex justify-between items-center text-xs font-semibold text-gray-500 mb-2">
                            <span>Frais exigibles filière :</span>
                            <span class="font-extrabold text-gray-700">{{ number_format($paiement->inscription->filiere->frais_inscription ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-semibold text-gray-500 mb-2">
                            <span>Montant versé :</span>
                            <span class="font-extrabold text-sigan-blue">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        @php
                        $ecart = ($paiement->montant) - ($paiement->inscription->filiere->frais_inscription ?? 0);
                        @endphp

                        @if($ecart == 0)
                        <div class="p-2.5 bg-green-50/50 border border-green-100 rounded-xl flex items-center justify-between text-[11px] font-bold text-green-700 mt-3">
                            <span>Statut règlement :</span>
                            <span>Solde exact (100%)</span>
                        </div>
                        @elseif($ecart < 0)
                        <div class="p-2.5 bg-red-50/50 border border-red-100 rounded-xl flex flex-col gap-1 text-[11px] font-bold text-red-700 mt-3">
                            <div class="flex justify-between">
                                <span>Reste à payer :</span>
                                <span>{{ number_format(abs($ecart), 0, ',', ' ') }} FCFA</span>
                            </div>
                            <span class="text-[9px] text-red-500 font-normal">Attention : Le montant réglé est inférieur aux frais requis pour cette filière.</span>
                        </div>
                        @else
                        <div class="p-2.5 bg-blue-50/50 border border-blue-100 rounded-xl flex flex-col gap-1 text-[11px] font-bold text-sigan-blue mt-3">
                            <div class="flex justify-between">
                                <span>Trop-perçu :</span>
                                <span>+{{ number_format($ecart, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <span class="text-[9px] text-blue-500 font-normal">Le montant réglé est supérieur aux frais d'inscription requis.</span>
                        </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection
