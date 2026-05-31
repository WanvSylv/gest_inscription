@extends('layouts.app')
@section('title', 'Gestion des filières')

@section('content')
<div class="pt-6 space-y-6">

    {{-- En-tête --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-gray-900">Gestion des filières</h2>
            <p class="text-sm text-gray-400 mt-0.5">Configurez les filières et leurs frais d'inscription respectifs.</p>
        </div>
        <a href="{{ route('academique.filieres.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-sigan-blue text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span class="hidden sm:inline">Ajouter une filière</span>
            <span class="sm:hidden">Ajouter</span>
        </a>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        
        {{-- Total --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-sigan-blue/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Filières</span>
            </div>
            <p class="text-3xl font-black text-gray-900">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Filières enregistrées</p>
        </div>

        {{-- Actives --}}
        <div class="bg-white rounded-2xl border border-green-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Actives</span>
            </div>
            <p class="text-3xl font-black text-green-600">{{ $stats['actives'] }}</p>
            <p class="text-xs text-gray-400 font-medium mt-1">Disponibles pour inscription</p>
        </div>

        {{-- Moyenne frais --}}
        <div class="bg-white rounded-2xl border border-purple-100 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs text-gray-400 font-medium">Moyenne</span>
            </div>
            <p class="text-2xl font-black text-purple-600">{{ number_format($stats['moyenne_frais'], 0, ',', ' ') }}<span class="text-sm font-medium text-gray-400 ml-1">FCFA</span></p>
            <p class="text-xs text-gray-400 font-medium mt-1">Frais d'inscription moyen</p>
        </div>
    </div>

    {{-- Liste Tabulaire --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Code</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Filière</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Niveau</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Frais d'inscription</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Dossiers rattachés</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Statut</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($filieres as $filiere)
                    <tr class="hover:bg-gray-50/30 transition-colors duration-100">
                        {{-- Code --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 text-gray-800 text-xs font-bold rounded-lg uppercase">
                                {{ $filiere->code }}
                            </span>
                        </td>
                        
                        {{-- Nom --}}
                        <td class="px-5 py-4">
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 text-sm leading-tight">{{ $filiere->nom }}</p>
                                @if($filiere->description)
                                <p class="text-xs text-gray-400 truncate max-w-sm mt-0.5 font-light">{{ $filiere->description }}</p>
                                @endif
                            </div>
                        </td>

                        {{-- Niveau --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-gray-600 font-semibold text-sm">{{ $filiere->niveau }}</span>
                        </td>

                        {{-- Frais --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="font-black text-sigan-blue text-sm">{{ number_format($filiere->frais_inscription, 0, ',', ' ') }} FCFA</span>
                        </td>

                        {{-- Inscriptions rattachées --}}
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                            {{ $filiere->inscriptions_count }}
                        </td>

                        {{-- Statut --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($filiere->actif)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                Active
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 flex-shrink-0"></span>
                                Inactive
                            </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="px-5 py-4 whitespace-nowrap text-right text-xs">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('academique.filieres.edit', $filiere) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/></svg>
                                    Modifier
                                </a>

                                <form method="POST" action="{{ route('academique.filieres.destroy', $filiere) }}" id="form-delete-{{ $filiere->id }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            @if($filiere->inscriptions_count > 0)
                                            disabled
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 text-red-300 text-xs font-bold rounded-lg cursor-not-allowed opacity-50"
                                            title="Des dossiers d'inscription sont rattachés à cette filière"
                                            @else
                                            @click="$dispatch('confirm-modal', {
                                                title: 'Supprimer la filière',
                                                message: 'Confirmez-vous la suppression définitive de la filière {{ $filiere->nom }} ? Cette action est irréversible.',
                                                confirmText: 'Oui, supprimer',
                                                type: 'danger',
                                                formId: 'form-delete-{{ $filiere->id }}'
                                            })"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg transition-colors"
                                            @endif>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <p class="font-bold text-gray-500 text-sm">Aucune filière</p>
                                <p class="text-xs text-gray-400 mt-1">Créez votre première filière pour commencer à recevoir des inscriptions.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($filieres->hasPages())
        <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50/50">
            {{ $filieres->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
