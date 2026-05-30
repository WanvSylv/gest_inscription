@extends('layouts.app')
@section('title', 'Dossiers d\'inscription')

@section('content')
@php
$tabs = [
    'en_attente'        => ['label' => 'En attente',       'color' => 'amber'],
    'valide_academique' => ['label' => 'Validés',           'color' => 'blue'],
    'rejete_modifiable' => ['label' => 'Rejetés (modif.)', 'color' => 'orange'],
    'rejete_definitif'  => ['label' => 'Rejetés (déf.)',   'color' => 'red'],
    'paye'              => ['label' => 'Payés',             'color' => 'purple'],
    'inscrit'           => ['label' => 'Inscrits',          'color' => 'green'],
    'tous'              => ['label' => 'Tous',              'color' => 'gray'],
];
$badgeColors = [
    'en_attente'        => 'bg-amber-100 text-amber-700',
    'valide_academique' => 'bg-blue-100 text-blue-700',
    'rejete_modifiable' => 'bg-orange-100 text-orange-700',
    'rejete_definitif'  => 'bg-red-100 text-red-700',
    'paye'              => 'bg-purple-100 text-purple-700',
    'inscrit'           => 'bg-green-100 text-green-700',
];
$dotColors = [
    'en_attente'        => 'bg-amber-500',
    'valide_academique' => 'bg-blue-500',
    'rejete_modifiable' => 'bg-orange-500',
    'rejete_definitif'  => 'bg-red-500',
    'paye'              => 'bg-purple-500',
    'inscrit'           => 'bg-green-500',
];
@endphp

<div class="pt-6 space-y-5">

    {{-- En-tête --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-black text-gray-900">Dossiers d'inscription</h2>
            <p class="text-sm text-gray-400 mt-0.5">Consultez, validez ou rejetez les candidatures.</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-gray-400 bg-white border border-gray-100 rounded-xl px-4 py-2 shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="font-semibold text-gray-700">{{ array_sum($stats) }}</span> dossiers au total
        </div>
    </div>

    {{-- KPI cards (même design que le dashboard) --}}
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-4">

        <a href="{{ route('academique.inscriptions.index', ['statut' => 'en_attente']) }}"
           class="bg-white rounded-2xl border {{ $statut === 'en_attente' ? 'border-sigan-blue ring-2 ring-sigan-blue/20' : 'border-amber-100' }} p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @if($stats['en_attente'] > 0)
                <span class="text-xs bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded-full animate-pulse">Urgent</span>
                @endif
            </div>
            <p class="text-3xl font-black text-amber-600">{{ $stats['en_attente'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">En attente</p>
        </a>

        <a href="{{ route('academique.inscriptions.index', ['statut' => 'valide_academique']) }}"
           class="bg-white rounded-2xl border {{ $statut === 'valide_academique' ? 'border-sigan-blue ring-2 ring-sigan-blue/20' : 'border-blue-100' }} p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Validés</span>
            </div>
            <p class="text-3xl font-black text-blue-600">{{ $stats['valide_academique'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Dossiers validés</p>
        </a>

        <a href="{{ route('academique.inscriptions.index', ['statut' => 'paye']) }}"
           class="bg-white rounded-2xl border {{ $statut === 'paye' ? 'border-sigan-blue ring-2 ring-sigan-blue/20' : 'border-purple-100' }} p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Payés</span>
            </div>
            <p class="text-3xl font-black text-purple-600">{{ $stats['paye'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Paiements reçus</p>
        </a>

        <a href="{{ route('academique.inscriptions.index', ['statut' => 'inscrit']) }}"
           class="bg-white rounded-2xl border {{ $statut === 'inscrit' ? 'border-sigan-blue ring-2 ring-sigan-blue/20' : 'border-green-100' }} p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Confirmés</span>
            </div>
            <p class="text-3xl font-black text-green-600">{{ $stats['inscrit'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Étudiants inscrits</p>
        </a>

        <a href="{{ route('academique.inscriptions.index', ['statut' => 'rejete_modifiable']) }}"
           class="bg-white rounded-2xl border {{ $statut === 'rejete_modifiable' ? 'border-sigan-blue ring-2 ring-sigan-blue/20' : 'border-orange-100' }} p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Modif.</span>
            </div>
            <p class="text-3xl font-black text-orange-500">{{ $stats['rejete_modifiable'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Rej. modifiables</p>
        </a>

        <a href="{{ route('academique.inscriptions.index', ['statut' => 'rejete_definitif']) }}"
           class="bg-white rounded-2xl border {{ $statut === 'rejete_definitif' ? 'border-sigan-blue ring-2 ring-sigan-blue/20' : 'border-red-100' }} p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Rejetés</span>
            </div>
            <p class="text-3xl font-black text-red-500">{{ $stats['rejete_definitif'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Rejets définitifs</p>
        </a>

    </div>

    {{-- Table card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Onglets filtre --}}
        <div class="flex items-center gap-1.5 px-5 py-3.5 border-b border-gray-100 overflow-x-auto">
            @foreach($tabs as $key => $tab)
            <a href="{{ route('academique.inscriptions.index', ['statut' => $key]) }}"
               class="whitespace-nowrap px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all duration-150
                      {{ $statut === $key
                         ? 'bg-sigan-blue text-white shadow-sm'
                         : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                {{ $tab['label'] }}
                @if($key !== 'tous' && isset($stats[$key]) && $stats[$key] > 0)
                <span class="ml-1 opacity-70">{{ $stats[$key] }}</span>
                @endif
            </a>
            @endforeach
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Étudiant</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Filière</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Niveau</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider hidden lg:table-cell">Année</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider hidden md:table-cell">Date</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($inscriptions as $inscription)
                    <tr class="hover:bg-gray-50/50 transition-colors duration-100">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-sigan-blue/10 flex items-center justify-center font-bold text-sigan-blue text-xs flex-shrink-0">
                                    {{ strtoupper(substr($inscription->etudiant->prenom, 0, 1) . substr($inscription->etudiant->nom, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate text-sm">{{ $inscription->etudiant->full_name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $inscription->etudiant->email_personnel }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-600 max-w-[160px] truncate">{{ $inscription->filiere->nom ?? '—' }}</td>
                        <td class="px-5 py-3.5">
                            <span class="font-bold text-sigan-blue text-sm">{{ $inscription->niveau }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-gray-500 hidden lg:table-cell">{{ $inscription->annee_academique }}</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeColors[$inscription->statut] ?? 'bg-gray-100 text-gray-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $dotColors[$inscription->statut] ?? 'bg-gray-400' }}"></span>
                                {{ $tabs[$inscription->statut]['label'] ?? $inscription->statut }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-xs text-gray-400 hidden md:table-cell whitespace-nowrap">{{ $inscription->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3.5 text-right">
                            <a href="{{ route('academique.inscriptions.show', $inscription) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-sigan-blue text-white text-xs font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Examiner
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <p class="font-semibold text-gray-500 text-sm">Aucun dossier</p>
                                <p class="text-xs text-gray-400 mt-1">Aucun dossier ne correspond à ce filtre.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($inscriptions->hasPages())
        <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50/50">
            {{ $inscriptions->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
