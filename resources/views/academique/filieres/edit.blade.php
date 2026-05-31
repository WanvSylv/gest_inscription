@extends('layouts.app')
@section('title', 'Modifier la filière — ' . $filiere->nom)

@section('content')
<div class="pt-6 max-w-2xl mx-auto space-y-6">

    {{-- Breadcrumb & Retour --}}
    <nav class="flex items-center text-sm text-gray-500 gap-1.5">
        <a href="{{ route('academique.filieres.index') }}" class="hover:text-sigan-blue transition-colors flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Filières
        </a>
        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-800 font-semibold truncate">Modifier la filière</span>
    </nav>

    {{-- Formulaire Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" x-data="{ submitting: false }">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="text-base font-bold text-gray-900">Modifier la filière</h3>
            <p class="text-xs text-gray-400 mt-0.5">Modifiez les informations et les frais d'inscription de la filière.</p>
        </div>

        <form method="POST" action="{{ route('academique.filieres.update', $filiere) }}" class="p-6 space-y-5" @submit="submitting = true">
            @csrf
            @method('PUT')

            {{-- Nom et Code --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                <div class="sm:col-span-2">
                    <label for="nom" class="block text-xs font-semibold uppercase tracking-wide text-gray-700 mb-1.5">Nom de la filière <span class="text-red-500">*</span></label>
                    <input type="text" name="nom" id="nom" required
                           value="{{ old('nom', $filiere->nom) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all"
                           placeholder="Ex: Informatique et Systèmes de Décision">
                    @error('nom') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="code" class="block text-xs font-semibold uppercase tracking-wide text-gray-700 mb-1.5">Code unique <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" required
                           value="{{ old('code', $filiere->code) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all uppercase"
                           placeholder="Ex: INFO">
                    @error('code') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Niveau et Frais --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="niveau" class="block text-xs font-semibold uppercase tracking-wide text-gray-700 mb-1.5">Niveau d'études <span class="text-red-500">*</span></label>
                    <select name="niveau" id="niveau" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all bg-white">
                        <option value="">Sélectionnez un niveau</option>
                        <option value="Licence" {{ old('niveau', $filiere->niveau) === 'Licence' ? 'selected' : '' }}>Licence</option>
                        <option value="Master" {{ old('niveau', $filiere->niveau) === 'Master' ? 'selected' : '' }}>Master</option>
                        <option value="Doctorat" {{ old('niveau', $filiere->niveau) === 'Doctorat' ? 'selected' : '' }}>Doctorat</option>
                    </select>
                    @error('niveau') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="frais_inscription" class="block text-xs font-semibold uppercase tracking-wide text-gray-700 mb-1.5">Frais d'inscription (FCFA) <span class="text-red-500">*</span></label>
                    <input type="number" name="frais_inscription" id="frais_inscription" required min="0" step="1"
                           value="{{ old('frais_inscription', (int)$filiere->frais_inscription) }}"
                           class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all font-bold text-sigan-blue"
                           placeholder="Ex: 150000">
                    @error('frais_inscription') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Etablissement --}}
            <div>
                <label for="etablissement_id" class="block text-xs font-semibold uppercase tracking-wide text-gray-700 mb-1.5">Établissement rattaché <span class="text-red-500">*</span></label>
                <select name="etablissement_id" id="etablissement_id" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all bg-white">
                    @foreach($etablissements as $etab)
                    <option value="{{ $etab->id }}" {{ old('etablissement_id', $filiere->etablissement_id) == $etab->id ? 'selected' : '' }}>
                        {{ $etab->nom }} ({{ $etab->code }})
                    </option>
                    @endforeach
                </select>
                @error('etablissement_id') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wide text-gray-700 mb-1.5">Description (Optionnel)</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-sigan-blue focus:border-sigan-blue outline-none transition-all resize-none"
                          placeholder="Présentation abrégée de la filière, des débouchés, etc.">{{ old('description', $filiere->description) }}</textarea>
                @error('description') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            {{-- Actif checkbox --}}
            <div>
                <label class="inline-flex items-center gap-2.5 cursor-pointer group">
                    <input type="checkbox" name="actif" value="1" {{ old('actif', $filiere->actif) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-sigan-blue focus:ring-sigan-blue transition-colors">
                    <span class="text-xs text-gray-600 font-semibold group-hover:text-gray-800 transition-colors">
                        Filière active (visible pour les pré-inscriptions)
                    </span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('academique.filieres.index') }}"
                   class="px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-50 transition-colors">
                    Annuler
                </a>
                <button type="submit"
                        :disabled="submitting"
                        class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-sigan-blue text-white text-xs font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg x-show="submitting" class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24" x-cloak>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
