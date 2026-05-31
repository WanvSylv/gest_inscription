@extends('layouts.app')
@section('title', 'Suivi des paiements')

@section('content')
@php
$badgeColors = [
    'approved'  => 'bg-green-100 text-green-700',
    'pending'   => 'bg-amber-100 text-amber-700',
    'declined'  => 'bg-red-100 text-red-700',
    'cancelled' => 'bg-gray-100 text-gray-700',
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

    {{-- En-tête --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-gray-900">Suivi des paiements</h2>
            <p class="text-sm text-gray-400 mt-0.5">Consultez l'historique et les reçus de paiement de scolarité.</p>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        {{-- Total Revenu --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-sigan-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Recettes</span>
            </div>
            <p class="text-2xl font-black text-gray-900">{{ number_format($stats['total_revenu'], 0, ',', ' ') }}<span class="text-xs font-semibold text-gray-400 ml-1">FCFA</span></p>
            <p class="text-xs text-gray-400 font-medium mt-1">Total encaissé</p>
        </div>

        {{-- Validés --}}
        <div class="bg-white rounded-2xl border border-green-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Validés</span>
            </div>
            <p class="text-3xl font-black text-green-600">{{ $stats['payes_count'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Transactions réussies</p>
        </div>

        {{-- En attente --}}
        <div class="bg-white rounded-2xl border border-amber-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Attente</span>
            </div>
            <p class="text-3xl font-black text-amber-600">{{ $stats['en_attente_count'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Paiements initiés</p>
        </div>

        {{-- Panier Moyen --}}
        <div class="bg-white rounded-2xl border border-purple-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Moyenne</span>
            </div>
            <p class="text-2xl font-black text-purple-600">{{ number_format($stats['montant_moyen'], 0, ',', ' ') }}<span class="text-xs font-semibold text-gray-400 ml-1">FCFA</span></p>
            <p class="text-xs text-gray-400 font-medium mt-1">Montant moyen perçu</p>
        </div>

    </div>

    {{-- Filtres et Recherche --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <form method="GET" action="{{ route('comptable.paiements.index') }}" class="flex flex-col md:flex-row gap-3">
            {{-- Recherche --}}
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ $search }}"
                       class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all"
                       placeholder="Rechercher par étudiant (nom, email) ou ID de transaction...">
                <svg class="absolute left-3.5 top-3.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Statut --}}
            <div class="w-full md:w-48">
                <select name="statut" onchange="this.form.submit()"
                        class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all bg-white">
                    <option value="">Tous les statuts</option>
                    @foreach($statutLabels as $key => $label)
                    <option value="{{ $key }}" {{ $statut === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Bouton reset/soumission --}}
            <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-sigan-blue text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm whitespace-nowrap">
                    Filtrer
                </button>
                @if($search || $statut)
                <a href="{{ route('comptable.paiements.index') }}" class="px-4 py-2.5 border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors whitespace-nowrap">
                    Réinitialiser
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Liste Tabulaire --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Transaction</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Étudiant</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Filière / Niveau</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Montant</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($paiements as $paiement)
                    <tr class="hover:bg-gray-50/30 transition-colors duration-100">
                        
                        {{-- Transaction ID --}}
                        <td class="px-5 py-4 whitespace-nowrap font-bold text-gray-700">
                            <span class="inline-flex items-center px-2 py-0.5 bg-gray-100 rounded text-xs">
                                {{ strtoupper($paiement->transaction_id) }}
                            </span>
                        </td>

                        {{-- Étudiant --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sigan-blue/10 flex items-center justify-center font-bold text-sigan-blue text-xs flex-shrink-0">
                                    {{ strtoupper(substr($paiement->etudiant->prenom, 0, 1) . substr($paiement->etudiant->nom, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate text-sm leading-tight">{{ $paiement->etudiant->full_name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $paiement->etudiant->email_personnel }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Filiere / Niveau --}}
                        <td class="px-5 py-4">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-gray-700 truncate leading-tight">{{ $paiement->inscription->filiere->nom ?? '—' }}</p>
                                <p class="text-[10px] text-gray-400 font-bold mt-0.5">{{ $paiement->inscription->niveau ?? '—' }}</p>
                            </div>
                        </td>

                        {{-- Montant --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-black text-gray-950 text-sm">{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise }}</span>
                        </td>

                        {{-- Statut --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeColors[$paiement->statut] ?? 'bg-gray-100 text-gray-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dotColors[$paiement->statut] ?? 'bg-gray-400' }}"></span>
                                {{ $statutLabels[$paiement->statut] ?? $paiement->statut }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="px-5 py-4 whitespace-nowrap text-xs text-gray-400 font-semibold">
                            {{ $paiement->paye_le ? $paiement->paye_le->format('d/m/Y H:i') : $paiement->created_at->format('d/m/Y H:i') }}
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4 whitespace-nowrap text-right text-xs">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('comptable.paiements.show', $paiement) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Examiner
                                </a>

                                @if($paiement->statut === 'approved')
                                <a href="{{ route('comptable.paiements.recu', $paiement) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-sigan-blue/10 hover:bg-sigan-blue hover:text-white text-sigan-blue text-xs font-bold rounded-lg transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                                    Reçu
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="font-bold text-gray-500 text-sm">Aucune transaction</p>
                                <p class="text-xs text-gray-400 mt-1">Aucune transaction correspondante n'a été trouvée.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($paiements->hasPages())
        <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50/50">
            {{ $paiements->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
