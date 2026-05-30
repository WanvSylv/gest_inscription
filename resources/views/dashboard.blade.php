@extends('layouts.app')
@section('title', 'Tableau de bord')

@section('content')
@php
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Etudiant;

$stats = [
    'total'             => Inscription::count(),
    'en_attente'        => Inscription::where('statut', 'en_attente')->count(),
    'valide_academique' => Inscription::where('statut', 'valide_academique')->count(),
    'inscrit'           => Inscription::where('statut', 'inscrit')->count(),
    'rejete'            => Inscription::whereIn('statut', ['rejete_definitif', 'rejete_modifiable'])->count(),
    'paye'              => Inscription::where('statut', 'paye')->count(),
];
$totalRevenu = Paiement::where('statut', 'approved')->sum('montant');
$recents = Inscription::with(['etudiant', 'filiere'])->latest()->limit(6)->get();
$parFiliere = \App\Models\Filiere::withCount('inscriptions')->orderByDesc('inscriptions_count')->limit(5)->get();
@endphp

<div class="pt-6 space-y-6">

    {{-- Bonjour --}}
    <div>
        <h2 class="text-xl font-black text-gray-900">Bonjour, {{ Auth::user()->name }} 👋</h2>
        <p class="text-sm text-gray-400 mt-0.5">Voici un aperçu de l'activité de HOREB ACADEMY — {{ now()->format('d F Y') }}</p>
    </div>

    {{-- ═══ KPI CARDS ═══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-sigan-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Total</span>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Dossiers soumis</p>
        </div>

        <div class="bg-white rounded-2xl border border-amber-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                @if($stats['en_attente'] > 0)
                <span class="text-xs bg-amber-100 text-amber-700 font-bold px-2 py-0.5 rounded-full animate-pulse">Urgent</span>
                @endif
            </div>
            <p class="text-3xl font-black text-amber-600">{{ $stats['en_attente'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">En attente de traitement</p>
        </div>

        <div class="bg-white rounded-2xl border border-green-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Inscrits</span>
            </div>
            <p class="text-3xl font-black text-green-600">{{ $stats['inscrit'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Étudiants confirmés</p>
        </div>

        <div class="bg-white rounded-2xl border border-purple-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Revenus</span>
            </div>
            <p class="text-2xl font-black text-purple-600">{{ number_format($totalRevenu, 0, ',', ' ') }}<span class="text-sm font-medium text-gray-400 ml-1">FCFA</span></p>
            <p class="text-xs text-gray-400 font-medium mt-1">Total encaissé</p>
        </div>
    </div>

    {{-- ═══ LIGNE 2 ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Statut breakdown --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Répartition par statut</h3>
            <div class="space-y-3">
                @php
                $breakdown = [
                    ['label' => 'En attente',   'val' => $stats['en_attente'],        'color' => 'bg-amber-400'],
                    ['label' => 'Validés',       'val' => $stats['valide_academique'], 'color' => 'bg-blue-500'],
                    ['label' => 'Payés',         'val' => $stats['paye'],              'color' => 'bg-purple-500'],
                    ['label' => 'Inscrits',      'val' => $stats['inscrit'],           'color' => 'bg-green-500'],
                    ['label' => 'Rejetés',       'val' => $stats['rejete'],            'color' => 'bg-red-400'],
                ];
                $total = max($stats['total'], 1);
                @endphp
                @foreach($breakdown as $item)
                <div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="text-gray-600 font-medium">{{ $item['label'] }}</span>
                        <span class="text-gray-900 font-bold">{{ $item['val'] }}</span>
                    </div>
                    <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="{{ $item['color'] }} h-full rounded-full transition-all duration-700" style="width: {{ $total > 0 ? round($item['val'] / $total * 100) : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Top filières --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Top filières</h3>
            <div class="space-y-3">
                @forelse($parFiliere as $filiere)
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 bg-sigan-blue/10 rounded-lg flex items-center justify-center flex-shrink-0">
                        <span class="text-sigan-blue text-xs font-black">{{ $loop->iteration }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $filiere->nom }}</p>
                    </div>
                    <span class="text-xs font-black text-gray-500">{{ $filiere->inscriptions_count }}</span>
                </div>
                @empty
                <p class="text-xs text-gray-400">Aucune filière</p>
                @endforelse
            </div>
        </div>

        {{-- Actions rapides --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Actions rapides</h3>
            <div class="space-y-2">
                <a href="{{ route('academique.inscriptions.index', ['statut' => 'en_attente']) }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-amber-50 transition-colors group">
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-800">Traiter les dossiers</p>
                        <p class="text-[10px] text-gray-400">{{ $stats['en_attente'] }} en attente</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('academique.inscriptions.index', ['statut' => 'valide_academique']) }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors group">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-800">Dossiers validés</p>
                        <p class="text-[10px] text-gray-400">{{ $stats['valide_academique'] }} en attente de paiement</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>

                <a href="{{ route('academique.inscriptions.index', ['statut' => 'inscrit']) }}"
                   class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 transition-colors group">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-800">Étudiants inscrits</p>
                        <p class="text-[10px] text-gray-400">{{ $stats['inscrit'] }} confirmés</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    {{-- ═══ DERNIERS DOSSIERS ═══ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800">Derniers dossiers reçus</h3>
            <a href="{{ route('academique.inscriptions.index') }}" class="text-xs text-sigan-blue font-semibold hover:underline">Voir tout →</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recents as $ins)
            <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-gray-50/50 transition-colors">
                <div class="w-9 h-9 rounded-full bg-sigan-blue/10 flex items-center justify-center font-bold text-sigan-blue text-xs flex-shrink-0">
                    {{ strtoupper(substr($ins->etudiant->prenom, 0, 1) . substr($ins->etudiant->nom, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $ins->etudiant->full_name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $ins->filiere->nom ?? '—' }} · {{ $ins->niveau }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    @php
                    $badge = [
                        'en_attente'        => ['Attente',  'bg-amber-100 text-amber-700'],
                        'valide_academique' => ['Validé',   'bg-blue-100 text-blue-700'],
                        'rejete_modifiable' => ['Rej. mod', 'bg-orange-100 text-orange-700'],
                        'rejete_definitif'  => ['Rejeté',   'bg-red-100 text-red-700'],
                        'paye'              => ['Payé',     'bg-purple-100 text-purple-700'],
                        'inscrit'           => ['Inscrit',  'bg-green-100 text-green-700'],
                    ][$ins->statut] ?? ['—', 'bg-gray-100 text-gray-500'];
                    @endphp
                    <span class="inline-block text-[10px] font-bold px-2 py-0.5 rounded-full {{ $badge[1] }}">{{ $badge[0] }}</span>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $ins->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('academique.inscriptions.show', $ins) }}" class="flex-shrink-0 text-gray-300 hover:text-sigan-blue transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @empty
            <div class="px-6 py-12 text-center text-sm text-gray-400">Aucun dossier reçu pour le moment.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
