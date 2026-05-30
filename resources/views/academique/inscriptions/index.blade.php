@extends('layouts.app')
@section('title', 'Gestion des Inscriptions')

@section('content')

{{-- Page Header --}}
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Gestion des Inscriptions</h1>
    <p class="text-sm text-gray-500 mt-1.5">Consultez, validez ou rejetez les dossiers soumis par les étudiants.</p>
</div>

{{-- ───────── Stat Cards ───────── --}}
@php
$cardsConfig = [
    [
        'key'    => 'en_attente',
        'label'  => 'En attente',
        'icon'   => '⏳',
        'bg'     => 'bg-yellow-50',
        'border' => 'border-yellow-200',
        'text'   => 'text-yellow-700',
        'ring'   => 'ring-yellow-300',
    ],
    [
        'key'    => 'valide_academique',
        'label'  => 'Validés',
        'icon'   => '✅',
        'bg'     => 'bg-blue-50',
        'border' => 'border-blue-200',
        'text'   => 'text-blue-700',
        'ring'   => 'ring-blue-300',
    ],
    [
        'key'    => 'rejete_modifiable',
        'label'  => 'Rej. modif.',
        'icon'   => '✏️',
        'bg'     => 'bg-orange-50',
        'border' => 'border-orange-200',
        'text'   => 'text-orange-700',
        'ring'   => 'ring-orange-300',
    ],
    [
        'key'    => 'rejete_definitif',
        'label'  => 'Rejetés',
        'icon'   => '❌',
        'bg'     => 'bg-red-50',
        'border' => 'border-red-200',
        'text'   => 'text-red-700',
        'ring'   => 'ring-red-300',
    ],
    [
        'key'    => 'paye',
        'label'  => 'Payés',
        'icon'   => '💳',
        'bg'     => 'bg-purple-50',
        'border' => 'border-purple-200',
        'text'   => 'text-purple-700',
        'ring'   => 'ring-purple-300',
    ],
    [
        'key'    => 'inscrit',
        'label'  => 'Inscrits',
        'icon'   => '🎓',
        'bg'     => 'bg-green-50',
        'border' => 'border-green-200',
        'text'   => 'text-green-700',
        'ring'   => 'ring-green-300',
    ],
];
@endphp

<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-5 mb-8">
    @foreach($cardsConfig as $card)
    <a href="{{ route('academique.inscriptions.index', ['statut' => $card['key']]) }}"
       class="group relative block {{ $card['bg'] }} border {{ $card['border'] }} rounded-2xl p-5 text-center
              hover:shadow-md hover:scale-[1.02] transition-all duration-200
              {{ $statut === $card['key'] ? 'ring-2 ring-sigan-blue shadow-md' : '' }}">
        {{-- Active indicator dot --}}
        @if($statut === $card['key'])
        <span class="absolute top-2.5 right-2.5 w-2 h-2 rounded-full bg-sigan-blue animate-pulse"></span>
        @endif

        <div class="text-3xl mb-2 group-hover:scale-110 transition-transform duration-200">{{ $card['icon'] }}</div>
        <div class="text-3xl font-extrabold {{ $card['text'] }} leading-none">{{ $stats[$card['key']] ?? 0 }}</div>
        <div class="text-xs font-semibold text-gray-500 mt-2 uppercase tracking-wide">{{ $card['label'] }}</div>
    </a>
    @endforeach
</div>

{{-- ───────── Main Card: Filters + Table ───────── --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

    {{-- Filter Tabs --}}
    <div class="border-b border-gray-100 px-6 py-4">
        <div class="flex flex-wrap items-center gap-2">
            @php
            $tabs = [
                'en_attente'        => 'En attente',
                'valide_academique' => 'Validés',
                'rejete_modifiable' => 'Rejetés (modif.)',
                'rejete_definitif'  => 'Rejetés (définitif)',
                'paye'              => 'Payés',
                'inscrit'           => 'Inscrits',
                'tous'              => 'Tous',
            ];
            @endphp

            @foreach($tabs as $key => $label)
            <a href="{{ route('academique.inscriptions.index', ['statut' => $key]) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200
                      {{ $statut === $key
                          ? 'bg-sigan-blue text-white shadow-sm shadow-sigan-blue/25'
                          : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:text-gray-800' }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Data Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50/80 text-left">
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Étudiant</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Filière</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Niveau</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Année</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Statut</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400">Date</th>
                    <th class="px-6 py-3.5 text-xs font-semibold uppercase tracking-wider text-gray-400 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inscriptions as $inscription)
                <tr class="hover:bg-gray-50/60 transition-colors duration-150">
                    {{-- Étudiant --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-sigan-blue/10 flex items-center justify-center font-bold text-sigan-blue text-xs flex-shrink-0 uppercase">
                                {{ substr($inscription->etudiant->prenom, 0, 1) }}{{ substr($inscription->etudiant->nom, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-800 truncate">{{ $inscription->etudiant->full_name }}</div>
                                <div class="text-xs text-gray-400 truncate">{{ $inscription->etudiant->email_personnel }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Filière --}}
                    <td class="px-6 py-4 text-gray-600">{{ $inscription->filiere->nom ?? '—' }}</td>

                    {{-- Niveau --}}
                    <td class="px-6 py-4">
                        <span class="font-bold text-sigan-blue">{{ $inscription->niveau }}</span>
                    </td>

                    {{-- Année --}}
                    <td class="px-6 py-4 text-gray-600">{{ $inscription->annee_academique }}</td>

                    {{-- Statut Badge --}}
                    <td class="px-6 py-4">
                        @php
                            $statutInfo = \App\Models\Inscription::STATUTS[$inscription->statut]
                                ?? ['label' => $inscription->statut, 'color' => 'gray'];
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ match($statutInfo['color']) {
                                'yellow' => 'bg-yellow-100 text-yellow-800',
                                'blue'   => 'bg-blue-100 text-blue-800',
                                'orange' => 'bg-orange-100 text-orange-800',
                                'red'    => 'bg-red-100 text-red-800',
                                'purple' => 'bg-purple-100 text-purple-800',
                                'green'  => 'bg-green-100 text-green-800',
                                default  => 'bg-gray-100 text-gray-800',
                            } }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ match($statutInfo['color']) {
                                    'yellow' => 'bg-yellow-500',
                                    'blue'   => 'bg-blue-500',
                                    'orange' => 'bg-orange-500',
                                    'red'    => 'bg-red-500',
                                    'purple' => 'bg-purple-500',
                                    'green'  => 'bg-green-500',
                                    default  => 'bg-gray-500',
                                } }}"></span>
                            {{ $statutInfo['label'] }}
                        </span>
                    </td>

                    {{-- Date --}}
                    <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">{{ $inscription->created_at->format('d/m/Y H:i') }}</td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('academique.inscriptions.show', $inscription) }}"
                           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-sigan-blue text-white text-xs font-semibold rounded-lg hover:bg-blue-700 active:bg-blue-800 transition-colors duration-150 shadow-sm shadow-sigan-blue/20">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Examiner
                        </a>
                    </td>
                </tr>
                @empty
                {{-- Empty State --}}
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <p class="font-semibold text-gray-500">Aucun dossier trouvé</p>
                            <p class="text-xs text-gray-400 mt-1 max-w-xs">Il n'y a aucun dossier correspondant à ce filtre pour le moment.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($inscriptions->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
        {{ $inscriptions->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
