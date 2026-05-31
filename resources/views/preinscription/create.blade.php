@extends('layouts.public')
@section('title', 'Pré-inscription')

@push('head')
<style>
    [x-cloak] { display: none !important; }
    .field-input { display:block; width:100%; padding:0.8rem 1rem; border:1.5px solid #e5e7eb; border-radius:12px; font-size:0.875rem; color:#111827; background:#fff; transition:border-color 0.15s,box-shadow 0.15s; }
    .field-input:focus { outline:none; border-color:#1a56db; box-shadow:0 0 0 3px rgba(26,86,219,0.10); }
    .field-input::placeholder { color:#9ca3af; }
    select.field-input { appearance:none; cursor:pointer; }
</style>
@endpush

@section('content')
<div x-data="inscriptionForm()">

    {{-- Hero + Stepper --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1a56db 100%);" class="py-12">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs text-blue-200 font-semibold mb-4">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                Inscriptions ouvertes — 2026-2027
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-white mb-3">Déposez votre candidature</h1>
            <p class="text-blue-100/70 text-base font-light max-w-xl mx-auto">Complétez ce formulaire en 5 étapes. Votre dossier sera examiné par notre direction académique sous 72h.</p>

            <div class="flex items-center justify-center gap-0 mt-8 max-w-lg mx-auto">
                @foreach(['Info', 'Diplômes', 'Filière', 'Documents', 'Finaliser'] as $i => $label)
                <div class="flex items-center @if(!$loop->last) flex-1 @endif">
                    <div class="flex flex-col items-center">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold border-2 transition-all duration-300"
                             :class="{{ $i + 1 }} < step ? 'bg-green-400 border-green-400 text-white' : {{ $i + 1 }} === step ? 'bg-white border-white text-sigan-blue' : 'bg-white/10 border-white/30 text-white/40'">
                            <template x-if="{{ $i + 1 }} < step">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </template>
                            <template x-if="{{ $i + 1 }} >= step">
                                <span>{{ $i + 1 }}</span>
                            </template>
                        </div>
                        <span class="text-[10px] mt-1 font-semibold hidden sm:block transition-colors"
                              :class="{{ $i + 1 }} === step ? 'text-white' : {{ $i + 1 }} < step ? 'text-green-300' : 'text-white/30'">{{ $label }}</span>
                    </div>
                    @if(!$loop->last)
                    <div class="h-0.5 flex-1 mx-1 rounded transition-all duration-500"
                         :class="{{ $i + 1 }} < step ? 'bg-green-400' : 'bg-white/20'"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Formulaire --}}
    <div class="max-w-3xl mx-auto px-6 py-12">

        @if ($errors->any())
        <div class="mb-8 bg-red-50 border border-red-200 rounded-2xl p-5 flex items-start gap-3">
            <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-red-800 mb-1">Veuillez corriger les erreurs</p>
                <ul class="text-xs text-red-600 space-y-0.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data" @submit="onSubmitForm($event)">
                @csrf

                {{-- ÉTAPE 1 --}}
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-8 lg:p-10">
                    <div class="mb-8"><h2 class="text-xl font-black text-gray-900">Informations personnelles</h2><p class="text-gray-400 text-sm mt-1">Votre état civil et vos coordonnées de contact.</p></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Nom de famille <span class="text-red-500">*</span></label><input type="text" name="nom" value="{{ old('nom') }}" required placeholder="DOSSOU" class="field-input"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Prénom <span class="text-red-500">*</span></label><input type="text" name="prenom" value="{{ old('prenom') }}" required placeholder="Jean" class="field-input"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Date de naissance <span class="text-red-500">*</span></label><input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required class="field-input"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Lieu de naissance <span class="text-red-500">*</span></label><input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required placeholder="Cotonou" class="field-input"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Nationalité <span class="text-red-500">*</span></label><input type="text" name="nationalite" value="{{ old('nationalite') }}" required placeholder="Béninoise" class="field-input"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Téléphone <span class="text-red-500">*</span></label><input type="tel" name="telephone" value="{{ old('telephone') }}" required placeholder="+229 01 97 00 00 00" class="field-input"></div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email personnel <span class="text-green-600 text-xs font-bold ml-1">✓ Vérifié</span></label>
                            <input type="email" name="email_personnel" value="{{ $emailVerifie ?? old('email_personnel') }}" required readonly class="field-input bg-green-50 border-green-200 text-green-800 cursor-not-allowed">
                        </div>
                        <div class="sm:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1.5">Adresse de résidence <span class="text-red-500">*</span></label><input type="text" name="adresse" value="{{ old('adresse') }}" required placeholder="Quartier Cadjehoun, Cotonou" class="field-input"></div>
                    </div>
                </div>

                {{-- ÉTAPE 2 --}}
                <div x-show="step === 2" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-8 lg:p-10">
                    <div class="mb-8"><h2 class="text-xl font-black text-gray-900">Diplômes & Scolarité</h2><p class="text-gray-400 text-sm mt-1">Votre dernier diplôme obtenu et votre parcours académique.</p></div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1.5">Dernier diplôme obtenu <span class="text-red-500">*</span></label>
                            <select name="dernier_diplome" required x-model="dernier_diplome" class="field-input">
                                <option value="BAC">Baccalauréat (ou équivalent)</option>
                                <option value="LICENCE">Attestation de Licence (Bac + 3)</option>
                                <option value="AUTRE">Autre diplôme supérieur</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Année d'obtention <span class="text-red-500">*</span></label><input type="number" name="annee_diplome" value="{{ old('annee_diplome', date('Y')) }}" required min="1990" max="{{ date('Y') + 1 }}" class="field-input"></div>
                        <div><label class="block text-sm font-semibold text-gray-700 mb-1.5">Établissement <span class="text-red-500">*</span></label><input type="text" name="etablissement_diplome" value="{{ old('etablissement_diplome') }}" required placeholder="Lycée Béhanzin" class="field-input"></div>
                        <div class="sm:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1.5">Série ou spécialité <span class="text-red-500">*</span></label><input type="text" name="specialite_diplome" value="{{ old('specialite_diplome') }}" required placeholder="Série D ou Sciences Physiques" class="field-input"></div>
                    </div>
                </div>

                {{-- ÉTAPE 3 --}}
                <div x-show="step === 3" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-8 lg:p-10">
                    <div class="mb-8"><h2 class="text-xl font-black text-gray-900">Choix de la filière</h2><p class="text-gray-400 text-sm mt-1">Sélectionnez votre filière et votre niveau d'entrée.</p></div>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Filière souhaitée <span class="text-red-500">*</span></label>
                            <select name="filiere_id" required class="field-input">
                                <option value="">— Sélectionnez une filière —</option>
                                @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>{{ $filiere->nom }}@if($filiere->frais_inscription) — {{ number_format($filiere->frais_inscription, 0, ',', ' ') }} FCFA @endif</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Niveau d'entrée <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-3 sm:grid-cols-5 gap-3">
                                @foreach(['L1' => 'Licence 1', 'L2' => 'Licence 2', 'L3' => 'Licence 3', 'M1' => 'Master 1', 'M2' => 'Master 2'] as $val => $lbl)
                                <label class="cursor-pointer">
                                    <input type="radio" name="niveau_entree" value="{{ $val }}" x-model="niveau_entree" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-xl p-3 text-center peer-checked:border-sigan-blue peer-checked:bg-blue-50 transition-all duration-150 hover:border-gray-300">
                                        <p class="font-black text-gray-900 text-sm">{{ $val }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5 font-medium leading-tight">{{ $lbl }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                            <p class="text-sm font-bold text-blue-800 mb-2">Documents requis pour le niveau <span class="text-sigan-blue" x-text="niveau_entree"></span></p>
                            <ul class="text-xs text-blue-700 space-y-1.5">
                                <li x-show="['L1','L2','L3'].includes(niveau_entree)" class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-sigan-blue flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Relevé de notes du Baccalauréat</li>
                                <li x-show="['L2','L3'].includes(niveau_entree)" class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-sigan-blue flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Relevés L1 (S1 + S2)</li>
                                <li x-show="niveau_entree === 'L3'" class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-sigan-blue flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Relevés L2 (S1 + S2)</li>
                                <li x-show="['M1','M2'].includes(niveau_entree)" class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-sigan-blue flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Attestation de Licence</li>
                                <li x-show="niveau_entree === 'M2'" class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-sigan-blue flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Relevés Master 1</li>
                            </ul>
                        </div>
                        <input type="hidden" name="annee_academique" value="2026-2027">
                    </div>
                </div>

                {{-- ÉTAPE 4 --}}
                <div x-show="step === 4" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-8 lg:p-10">
                    <div class="mb-8"><h2 class="text-xl font-black text-gray-900">Relevés & Attestations</h2><p class="text-gray-400 text-sm mt-1">Téléversez vos documents (PDF, JPG, PNG — 2 Mo max).</p></div>
                    <div class="space-y-4">
                        @foreach([
                            ['releve_bac', 'Relevé de notes du Bac', "['L1','L2','L3'].includes(niveau_entree)"],
                            ['releves_l1', 'Relevés de notes L1 (S1 + S2)', "['L2','L3'].includes(niveau_entree)"],
                            ['releves_l2', 'Relevés de notes L2 (S1 + S2)', "niveau_entree === 'L3'"],
                            ['attestation_licence', 'Attestation de Licence', "['M1','M2'].includes(niveau_entree)"],
                            ['releves_m1', 'Relevés de notes Master 1', "niveau_entree === 'M2'"],
                        ] as [$name, $label, $condition])
                        <div x-show="{{ $condition }}">
                            <p class="text-sm font-semibold text-gray-700 mb-2">{{ $label }} <span class="text-red-500">*</span></p>
                            <label class="group flex items-center gap-4 border-2 border-dashed border-gray-200 rounded-2xl p-5 cursor-pointer hover:border-sigan-blue hover:bg-blue-50/30 transition-all duration-200">
                                <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-sigan-blue/10 transition-colors">
                                    <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-bold text-gray-700" id="label-{{ $name }}">Cliquez pour ajouter le fichier</p>
                                    <p class="text-xs text-gray-400 mt-0.5">PDF, JPG, PNG — 2 Mo max</p>
                                </div>
                                <input type="file" name="{{ $name }}" id="file-{{ $name }}" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, '{{ $name }}')">
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ÉTAPE 5 --}}
                <div x-show="step === 5" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="p-8 lg:p-10">
                    <div class="mb-8"><h2 class="text-xl font-black text-gray-900">Finalisation du dossier</h2><p class="text-gray-400 text-sm mt-1">Pièces complémentaires et validation de votre candidature.</p></div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        @foreach([['photo', "Photo d'identité", '.jpg,.jpeg,.png'], ['carte_identite', 'CNI / Passeport', '.pdf,.jpg,.jpeg,.png'], ['acte_naissance', 'Acte de naissance', '.pdf,.jpg,.jpeg,.png']] as [$name, $label, $accept])
                        <div>
                            <p class="text-sm font-semibold text-gray-700 mb-1.5">{{ $label }} <span class="text-xs text-gray-400 font-normal">(Optionnel)</span></p>
                            <label class="group flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-2xl p-5 cursor-pointer hover:border-sigan-blue hover:bg-blue-50/30 transition-all duration-200 text-center h-28">
                                <svg class="w-6 h-6 text-gray-300 group-hover:text-sigan-blue transition-colors mb-1.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                                <p class="text-xs font-bold text-gray-400 group-hover:text-sigan-blue transition-colors" id="label-{{ $name }}">Ajouter</p>
                                <input type="file" name="{{ $name }}" id="file-{{ $name }}" accept="{{ $accept }}" class="sr-only" @change="onFileSelected($event, '{{ $name }}')">
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="bg-amber-50 border border-amber-100 rounded-2xl p-5 mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm font-bold text-amber-800 mb-1">Avant de soumettre</p>
                                <ul class="text-xs text-amber-700 space-y-1 font-medium">
                                    <li>• Vérifiez que tous vos documents sont lisibles et complets.</li>
                                    <li>• En cas d'acceptation, vous aurez <strong>72 heures</strong> pour régler les frais de scolarité.</li>
                                    <li>• Toute déclaration frauduleuse entraîne l'annulation immédiate du dossier.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <input type="checkbox" id="cgu" x-model="cguChecked" required class="mt-0.5 w-5 h-5 rounded border-gray-300 text-sigan-blue focus:ring-sigan-blue flex-shrink-0">
                        <span class="text-sm text-gray-600 font-medium leading-relaxed select-none">
                            Je certifie l'exactitude de mes informations et j'accepte les
                            <a href="#" class="text-sigan-blue font-bold hover:underline">conditions générales d'inscription</a> de HOREB ACADEMY.
                        </span>
                    </label>
                </div>

                {{-- Boutons --}}
                <div class="flex items-center justify-between px-8 lg:px-10 py-5 bg-gray-50 border-t border-gray-100">
                    <button type="button" x-show="step > 1" @click="prevStep()" :disabled="submitting"
                            class="flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-900 px-4 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                        Précédent
                    </button>
                    <div x-show="step === 1"></div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400 font-medium" x-text="'Étape ' + step + ' sur 5'"></span>
                        <button type="button" x-show="step < 5" @click="nextStep()"
                                class="flex items-center gap-2 text-sm font-bold text-white bg-sigan-blue hover:bg-blue-700 px-6 py-2.5 rounded-xl shadow-sm transition-all active:scale-95">
                            Continuer
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>
                        <button type="submit" x-show="step === 5"
                                :disabled="!cguChecked || submitting"
                                :class="(!cguChecked || submitting) ? 'opacity-50 cursor-not-allowed bg-emerald-600' : 'bg-emerald-600 hover:bg-emerald-700'"
                                class="flex items-center gap-2 text-sm font-bold text-white px-6 py-2.5 rounded-xl shadow-sm transition-all active:scale-95">
                            <svg x-show="submitting" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" x-cloak>
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="submitting ? 'Soumission du dossier...' : 'Soumettre mon dossier'"></span>
                            <svg x-show="!submitting" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('inscriptionForm', () => ({
            step: 1,
            niveau_entree: '{{ old("niveau_entree", "L1") }}',
            dernier_diplome: '{{ old("dernier_diplome", "BAC") }}',
            cguChecked: false,
            submitting: false,
            nextStep() {
                if (this.validateStep(this.step)) {
                    if (this.step < 5) { this.step++; window.scrollTo({ top: 0, behavior: 'smooth' }); }
                } else { alert('Veuillez remplir tous les champs obligatoires.'); }
            },
            prevStep() {
                if (this.step > 1) { this.step--; window.scrollTo({ top: 0, behavior: 'smooth' }); }
            },
            validateStep(s) {
                const req = {
                    1: ['prenom','nom','date_naissance','lieu_naissance','nationalite','telephone','email_personnel','adresse'],
                    2: ['dernier_diplome','annee_diplome','etablissement_diplome','specialite_diplome'],
                    3: ['filiere_id'], 4: [], 5: [],
                };
                let ok = true;
                (req[s] || []).forEach(n => {
                    const el = document.querySelector(`[name="${n}"]`);
                    if (el && !el.checkValidity()) { el.style.borderColor = '#f87171'; ok = false; }
                    else if (el) { el.style.borderColor = ''; }
                });
                if (s === 3 && !document.querySelector('[name="niveau_entree"]:checked')) ok = false;
                if (s === 4) {
                    const lv = this.niveau_entree;
                    if (['L1','L2','L3'].includes(lv) && !this.hasFile('releve_bac')) ok = false;
                    if (['L2','L3'].includes(lv) && !this.hasFile('releves_l1')) ok = false;
                    if (lv === 'L3' && !this.hasFile('releves_l2')) ok = false;
                    if (['M1','M2'].includes(lv) && !this.hasFile('attestation_licence')) ok = false;
                    if (lv === 'M2' && !this.hasFile('releves_m1')) ok = false;
                }
                return ok;
            },
            hasFile(n) { const el = document.getElementById('file-' + n); return el && el.files.length > 0; },
            onFileSelected(e, n) {
                const file = e.target.files[0];
                const lbl = document.getElementById('label-' + n);
                if (file && lbl) { lbl.textContent = '✓ ' + file.name; lbl.style.color = '#1a56db'; }
            },
            onSubmitForm(e) {
                for (let s = 1; s <= 5; s++) {
                    if (!this.validateStep(s)) { e.preventDefault(); alert('Des erreurs persistent dans votre formulaire.'); return; }
                }
                const cgu = document.getElementById('cgu');
                if (cgu && !cgu.checked) { e.preventDefault(); alert("Veuillez accepter les conditions d'inscription."); return; }
                
                this.submitting = true;
            },
        }));
    });
</script>
@endpush
