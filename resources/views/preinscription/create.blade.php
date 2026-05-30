<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pré-inscription — HOREB ACADEMY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col antialiased text-gray-900" x-data="inscriptionForm()">

    {{-- ═══════════ HEADER ═══════════ --}}
    <header class="bg-sigan-blue shadow-md sticky top-0 z-40 backdrop-blur bg-opacity-95">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/horeb_logo.png') }}" alt="HOREB Academy" class="h-9"><!-- Place your logo at public/images/horeb_logo.png -->                </div>
                <span class="text-white font-bold text-lg tracking-wider">HOREB <span class="font-light opacity-90">academy</span></span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                   class="text-sm font-semibold text-white/95 border border-white/30 rounded-xl px-4 py-2 hover:bg-white hover:text-sigan-blue transition-all duration-200">
                    Connexion
                </a>
            </div>
        </div>
    </header>

    {{-- ═══════════ STEPPER BAR (SIGAN STYLE) ═══════════ --}}
    <div class="bg-white border-b border-gray-100 py-5 sticky top-16 z-30 shadow-sm">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-gray-100/70 p-1.5 rounded-[22px] flex items-center justify-between gap-1.5 overflow-x-auto select-none no-scrollbar">
                
                {{-- Step 1: Infos --}}
                <button type="button" @click="goToStep(1)"
                    class="flex-1 min-w-[140px] flex items-center justify-center gap-2.5 py-3 px-4 rounded-[16px] text-xs sm:text-sm font-semibold transition-all duration-300 transform"
                    :class="step === 1 ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20 scale-[1.02]' : 'text-gray-500 hover:bg-gray-200/50 hover:text-gray-800'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                          :class="step === 1 ? 'bg-white/25 text-white' : 'bg-gray-200 text-gray-600'">1</span>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Civil</span>
                </button>

                {{-- Step 2: Diplômes --}}
                <button type="button" @click="goToStep(2)"
                    class="flex-1 min-w-[140px] flex items-center justify-center gap-2.5 py-3 px-4 rounded-[16px] text-xs sm:text-sm font-semibold transition-all duration-300 transform"
                    :class="step === 2 ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20 scale-[1.02]' : 'text-gray-500 hover:bg-gray-200/50 hover:text-gray-800'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                          :class="step === 2 ? 'bg-white/25 text-white' : 'bg-gray-200 text-gray-600'">2</span>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    <span>Diplômes</span>
                </button>

                {{-- Step 3: Spécialité --}}
                <button type="button" @click="goToStep(3)"
                    class="flex-1 min-w-[140px] flex items-center justify-center gap-2.5 py-3 px-4 rounded-[16px] text-xs sm:text-sm font-semibold transition-all duration-300 transform"
                    :class="step === 3 ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20 scale-[1.02]' : 'text-gray-500 hover:bg-gray-200/50 hover:text-gray-800'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                          :class="step === 3 ? 'bg-white/25 text-white' : 'bg-gray-200 text-gray-600'">3</span>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Spécialité</span>
                </button>

                {{-- Step 4: Relevés --}}
                <button type="button" @click="goToStep(4)"
                    class="flex-1 min-w-[140px] flex items-center justify-center gap-2.5 py-3 px-4 rounded-[16px] text-xs sm:text-sm font-semibold transition-all duration-300 transform"
                    :class="step === 4 ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20 scale-[1.02]' : 'text-gray-500 hover:bg-gray-200/50 hover:text-gray-800'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                          :class="step === 4 ? 'bg-white/25 text-white' : 'bg-gray-200 text-gray-600'">4</span>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Relevés</span>
                </button>

                {{-- Step 5: Compléments --}}
                <button type="button" @click="goToStep(5)"
                    class="flex-1 min-w-[140px] flex items-center justify-center gap-2.5 py-3 px-4 rounded-[16px] text-xs sm:text-sm font-semibold transition-all duration-300 transform"
                    :class="step === 5 ? 'bg-sigan-blue text-white shadow-md shadow-sigan-blue/20 scale-[1.02]' : 'text-gray-500 hover:bg-gray-200/50 hover:text-gray-800'">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                          :class="step === 5 ? 'bg-white/25 text-white' : 'bg-gray-200 text-gray-600'">5</span>
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                    <span>Pièces Complémentaires</span>
                </button>

            </div>
        </div>
    </div>

    {{-- ═══════════ MAIN CONTENT AREA ═══════════ --}}
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-sigan-blue via-indigo-600 to-purple-700 p-4"><main class="flex-grow max-w-2xl w-full bg-white rounded-2xl shadow-lg p-6 mx-auto">

        {{-- Errors alert --}}
        @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-red-800">Erreurs lors de la soumission</h4>
                    <p class="text-xs text-red-600 mt-0.5">Veuillez corriger les informations suivantes :</p>
                    <ul class="list-disc list-inside text-xs text-red-600 mt-2 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('preinscription.store') }}" method="POST" enctype="multipart/form-data" @submit="onSubmitForm($event)">
            @csrf

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- ───────── ÉTAPE 1 : Informations Personnelles ───────── --}}
                <div x-show="step === 1" x-transition.opacity.duration.300>
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight">Informations Personnelles</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Renseignez votre état civil et vos informations de contact</p>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        {{-- Nom --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de famille <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="nom" value="{{ old('nom') }}" required placeholder="Ex: DOSSOU"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Prenom --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <input type="text" name="prenom" value="{{ old('prenom') }}" required placeholder="Ex: Jean"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Date Naissance --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date de naissance <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Lieu Naissance --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Lieu de naissance <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}" required placeholder="Ex: Cotonou"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Nationalite --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nationalité <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2a2.5 2.5 0 002.5-2.5V8a2 2 0 00-2-2h-.5A2 2 0 0115 4V3.065M12 21a9 9 0 100-18 9 9 0 000 18z"/></svg>
                                </div>
                                <input type="text" name="nationalite" value="{{ old('nationalite') }}" required placeholder="Ex: Béninoise"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Telephone --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Numéro de téléphone <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <input type="tel" name="telephone" value="{{ old('telephone') }}" required placeholder="Ex: +229 01 97 00 00 00"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Email Personnel --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email personnel <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="email" name="email_personnel" value="{{ old('email_personnel') }}" required placeholder="Ex: jean@gmail.com"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Adresse --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Adresse de résidence <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <input type="text" name="adresse" value="{{ old('adresse') }}" required placeholder="Ex: Quartier Cadjehoun, Cotonou"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ───────── ÉTAPE 2 : Diplômes / Attestations ───────── --}}
                <div x-show="step === 2" x-cloak x-transition.opacity.duration.300>
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight">Diplômes & Scolarité</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Renseignez votre dernier diplôme obtenu et votre parcours académique</p>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Dernier diplome --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dernier diplôme obtenu <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 z-10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                </div>
                                <select name="dernier_diplome" required x-model="dernier_diplome"
                                        class="block w-full pl-11 pr-10 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 text-sm transition-all duration-200 bg-white appearance-none cursor-pointer">
                                    <option value="BAC">Baccalauréat (ou équivalent)</option>
                                    <option value="LICENCE">Attestation de Licence (Bac + 3)</option>
                                    <option value="AUTRE">Autre Diplôme supérieur</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Année obtention --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Année d'obtention <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="number" name="annee_diplome" value="{{ old('annee_diplome', date('Y')) }}" required min="1990" max="{{ date('Y') + 1 }}"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Etablissement --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Établissement d'obtention <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <input type="text" name="etablissement_diplome" value="{{ old('etablissement_diplome') }}" required placeholder="Ex: Lycée Béhanzin"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>

                        {{-- Serie/Spécialité --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Série ou Spécialité <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                                </div>
                                <input type="text" name="specialite_diplome" value="{{ old('specialite_diplome') }}" required placeholder="Ex: Série D ou Sciences Physiques"
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 placeholder-gray-400 text-sm transition-all duration-200 bg-white">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ───────── ÉTAPE 3 : Choix de la Spécialité ───────── --}}
                <div x-show="step === 3" x-cloak x-transition.opacity.duration.300>
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight">Choix de la Spécialité</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Sélectionnez la filière et le niveau d'entrée souhaités</p>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Filiere --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Filière souhaitée <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 z-10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <select name="filiere_id" required
                                        class="block w-full pl-11 pr-10 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 text-sm transition-all duration-200 bg-white appearance-none cursor-pointer">
                                    <option value="">-- Sélectionnez une filière --</option>
                                    @foreach($filieres as $filiere)
                                        <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                            {{ $filiere->nom }}
                                            @if($filiere->frais_inscription)
                                                — {{ number_format($filiere->frais_inscription, 0, ',', ' ') }} FCFA
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Niveau entree --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Niveau d'entrée souhaité <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400 z-10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                </div>
                                <select name="niveau_entree" x-model="niveau_entree" required
                                        class="block w-full pl-11 pr-10 py-3.5 text-gray-900 border border-gray-200 rounded-[14px] focus:outline-none focus:border-sigan-blue focus:ring-4 focus:ring-sigan-blue/10 text-sm transition-all duration-200 bg-white appearance-none cursor-pointer">
                                    <option value="L1">Licence 1 (L1) — Niveau Bac</option>
                                    <option value="L2">Licence 2 (L2) — Niveau Bac + L1</option>
                                    <option value="L3">Licence 3 (L3) — Niveau Bac + L1 + L2</option>
                                    <option value="M1">Master 1 (M1) — Niveau Attestation Licence</option>
                                    <option value="M2">Master 2 (M2) — Niveau Attestation Licence + M1</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Annee academique --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Année académique</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <input type="text" name="annee_academique" value="2026-2027" readonly
                                       class="block w-full pl-11 pr-5 py-3.5 text-gray-400 border border-gray-100 rounded-[14px] bg-gray-50 cursor-not-allowed font-medium text-sm">
                            </div>
                        </div>

                        {{-- Info Box sur les pièces requises --}}
                        <div class="md:col-span-2 mt-2">
                            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 text-sm text-blue-900 shadow-sm flex items-start gap-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-blue-800 text-sm">📋 Pièces justificatives requises pour <span class="text-blue-900 font-extrabold" x-text="'Niveau ' + niveau_entree"></span> :</p>
                                    <ul class="mt-2 space-y-1.5 list-disc list-inside text-xs text-blue-700 font-medium">
                                        <li x-show="['L1','L2','L3'].includes(niveau_entree)">Relevé de notes officiel du Baccalauréat</li>
                                        <li x-show="['L2','L3'].includes(niveau_entree)">Relevés de notes L1 (Semestres 1 et 2)</li>
                                        <li x-show="niveau_entree === 'L3'">Relevés de notes L2 (Semestres 1 et 2)</li>
                                        <li x-show="['M1','M2'].includes(niveau_entree)">Copie certifiée de l'Attestation de Licence</li>
                                        <li x-show="niveau_entree === 'M2'">Relevés de notes Master 1 (Semestres 1 et 2)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ───────── ÉTAPE 4 : Relevés de notes (Uploads) ───────── --}}
                <div x-show="step === 4" x-cloak x-transition.opacity.duration.300>
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight">Relevés de Notes & Attestations</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Téléversez les documents requis en format PDF, JPG ou PNG (2 Mo max par fichier)</p>
                    </div>

                    <div class="p-8 space-y-6">

                        {{-- Relevé Bac --}}
                        <div x-show="['L1','L2','L3'].includes(niveau_entree)" class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Relevé de notes du Bac <span class="text-red-500">*</span></label>
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-[20px] p-6 bg-gray-50/50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                <svg class="w-10 h-10 text-sigan-blue mb-2.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-xs font-bold text-gray-700 text-center" id="label-releve_bac">Cliquez pour téléverser votre relevé du Bac</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Fichiers acceptés: PDF, JPG, PNG — Max 2 Mo</span>
                                <input type="file" name="releve_bac" id="file-releve_bac" :required="['L1','L2','L3'].includes(niveau_entree)" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'releve_bac')">
                            </label>
                        </div>

                        {{-- Relevés L1 --}}
                        <div x-show="['L2','L3'].includes(niveau_entree)" class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Relevés de notes L1 (S1 + S2) <span class="text-red-500">*</span></label>
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-[20px] p-6 bg-gray-50/50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                <svg class="w-10 h-10 text-sigan-blue mb-2.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-xs font-bold text-gray-700 text-center" id="label-releves_l1">Cliquez pour téléverser vos relevés L1</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Fichiers acceptés: PDF, JPG, PNG — Max 2 Mo</span>
                                <input type="file" name="releves_l1" id="file-releves_l1" :required="['L2','L3'].includes(niveau_entree)" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'releves_l1')">
                            </label>
                        </div>

                        {{-- Relevés L2 --}}
                        <div x-show="niveau_entree === 'L3'" class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Relevés de notes L2 (S1 + S2) <span class="text-red-500">*</span></label>
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-[20px] p-6 bg-gray-50/50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                <svg class="w-10 h-10 text-sigan-blue mb-2.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-xs font-bold text-gray-700 text-center" id="label-releves_l2">Cliquez pour téléverser vos relevés L2</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Fichiers acceptés: PDF, JPG, PNG — Max 2 Mo</span>
                                <input type="file" name="releves_l2" id="file-releves_l2" :required="niveau_entree === 'L3'" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'releves_l2')">
                            </label>
                        </div>

                        {{-- Attestation Licence --}}
                        <div x-show="['M1','M2'].includes(niveau_entree)" class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Attestation de Licence <span class="text-red-500">*</span></label>
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-[20px] p-6 bg-gray-50/50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                <svg class="w-10 h-10 text-sigan-blue mb-2.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-xs font-bold text-gray-700 text-center" id="label-attestation_licence">Cliquez pour téléverser votre attestation de Licence</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Fichiers acceptés: PDF, JPG, PNG — Max 2 Mo</span>
                                <input type="file" name="attestation_licence" id="file-attestation_licence" :required="['M1','M2'].includes(niveau_entree)" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'attestation_licence')">
                            </label>
                        </div>

                        {{-- Relevés M1 --}}
                        <div x-show="niveau_entree === 'M2'" class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Relevés de notes Master 1 <span class="text-red-500">*</span></label>
                            <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-[20px] p-6 bg-gray-50/50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                <svg class="w-10 h-10 text-sigan-blue mb-2.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-xs font-bold text-gray-700 text-center" id="label-releves_m1">Cliquez pour téléverser vos relevés M1</span>
                                <span class="text-[10px] text-gray-400 mt-0.5">Fichiers acceptés: PDF, JPG, PNG — Max 2 Mo</span>
                                <input type="file" name="releves_m1" id="file-releves_m1" :required="niveau_entree === 'M2'" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'releves_m1')">
                            </label>
                        </div>

                    </div>
                </div>

                {{-- ───────── ÉTAPE 5 : Pièces complémentaires & Soumission ───────── --}}
                <div x-show="step === 5" x-cloak x-transition.opacity.duration.300>
                    <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-xl font-bold text-gray-900 leading-tight">Pièces Complémentaires & Soumission</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Joignez vos pièces d'état civil complémentaires et validez votre dossier</p>
                    </div>

                    <div class="p-8 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Photo d'identité --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Photo d'identité <span class="text-xs text-gray-400 font-medium">(Optionnel)</span></label>
                                <label class="flex flex-col items-center justify-center border border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                    <svg class="w-8 h-8 text-sigan-blue mb-1.5 group-hover:scale-105 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/></svg>
                                    <span class="text-xs font-bold text-gray-700 text-center" id="label-photo">Cliquez pour téléverser votre photo</span>
                                    <input type="file" name="photo" id="file-photo" accept=".jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'photo')">
                                </label>
                            </div>

                            {{-- Pièce d'identité --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Pièce d'identité (CNI / Passeport) <span class="text-xs text-gray-400 font-medium">(Optionnel)</span></label>
                                <label class="flex flex-col items-center justify-center border border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                    <svg class="w-8 h-8 text-sigan-blue mb-1.5 group-hover:scale-105 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z"/></svg>
                                    <span class="text-xs font-bold text-gray-700 text-center" id="label-carte_identite">Cliquez pour téléverser votre pièce d'identité</span>
                                    <input type="file" name="carte_identite" id="file-carte_identite" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'carte_identite')">
                                </label>
                            </div>

                            {{-- Acte de naissance --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Acte de naissance <span class="text-xs text-gray-400 font-medium">(Optionnel)</span></label>
                                <label class="flex flex-col items-center justify-center border border-dashed border-gray-200 rounded-2xl p-4 bg-gray-50 hover:bg-blue-50/40 hover:border-sigan-blue transition-all duration-200 cursor-pointer group relative">
                                    <svg class="w-8 h-8 text-sigan-blue mb-1.5 group-hover:scale-105 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span class="text-xs font-bold text-gray-700 text-center" id="label-acte_naissance">Cliquez pour téléverser votre acte de naissance</span>
                                    <input type="file" name="acte_naissance" id="file-acte_naissance" accept=".pdf,.jpg,.jpeg,.png" class="sr-only" @change="onFileSelected($event, 'acte_naissance')">
                                </label>
                            </div>
                        </div>

                        {{-- Notice Importante --}}
                        <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5 shadow-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-yellow-100 rounded-lg flex items-center justify-center flex-shrink-0 text-yellow-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-yellow-800">⚠️ Recommandations importantes avant soumission</h4>
                                    <ul class="mt-2 list-disc list-inside text-xs text-yellow-700 font-medium space-y-1">
                                        <li>Assurez-vous que l'ensemble des relevés de notes téléversés sont parfaitement lisibles.</li>
                                        <li>En cas d'acceptation du dossier par la direction académique, vous aurez <strong class="font-extrabold">72 heures</strong> pour finaliser vos frais de scolarité.</li>
                                        <li>Toute déclaration frauduleuse entraînera l'annulation immédiate de votre pré-inscription.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- CGU Checkbox --}}
                        <div class="flex items-start gap-3.5 bg-gray-50/70 p-4 rounded-xl border border-gray-100">
                            <input type="checkbox" id="cgu" required
                                   class="mt-1 w-5 h-5 rounded-[6px] border-gray-300 text-sigan-blue focus:ring-sigan-blue focus:ring-2 transition-all cursor-pointer">
                            <label for="cgu" class="text-xs sm:text-sm text-gray-600 font-medium cursor-pointer leading-relaxed select-none">
                                Je certifie sur l'honneur l'exactitude des informations renseignées et des documents fournis. J'accepte les <a href="#" class="text-sigan-blue font-bold hover:underline">conditions générales d'inscription</a> d'HOREB ACADEMY.
                            </label>
                        </div>

                    </div>
                </div>

                {{-- ───────── BUTTONS BAR ───────── --}}
                <div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex justify-between items-center">
                    <button type="button" x-show="step > 1" @click="prevStep()"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 border border-gray-200 text-gray-700 bg-white hover:bg-gray-50 text-sm font-bold rounded-[14px] shadow-sm active:scale-95 transition-all duration-150">
                        ← Précédent
                    </button>
                    <div x-show="step === 1"></div>

                    <div class="flex items-center gap-4">
                        <span class="text-xs text-gray-400 font-bold hidden sm:inline" x-text="'Étape ' + step + ' sur 5'"></span>
                        <button type="button" x-show="step < 5" @click="nextStep()"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-sigan-blue text-white hover:bg-blue-700 text-sm font-bold rounded-[14px] shadow-md shadow-sigan-blue/15 active:scale-95 transition-all duration-150">
                            Suivant →
                        </button>
                        <button type="submit" x-show="step === 5"
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 text-white hover:bg-emerald-700 text-sm font-bold rounded-[14px] shadow-md shadow-emerald-600/15 active:scale-95 transition-all duration-150">
                            🚀 Soumettre mon dossier
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </main></div>

    {{-- Footer --}}
    <footer class="py-6 border-t border-gray-100 bg-white mt-12">
        <p class="text-center text-xs text-gray-400">
            © {{ date('Y') }} HOREB ACADEMY — Tous droits réservés.
        </p>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('inscriptionForm', () => ({
                step: 1,
                niveau_entree: '{{ old('niveau_entree', 'L1') }}',
                dernier_diplome: '{{ old('dernier_diplome', 'BAC') }}',

                nextStep() {
                    if (this.validateStep(this.step)) {
                        if (this.step < 5) {
                            this.step++;
                            this.scrollToTop();
                        }
                    } else {
                        alert("Veuillez remplir correctement tous les champs obligatoires de cette étape.");
                    }
                },

                prevStep() {
                    if (this.step > 1) {
                        this.step--;
                        this.scrollToTop();
                    }
                },

                goToStep(targetStep) {
                    // Only allow jumps if previous steps are fully validated
                    for (let s = 1; s < targetStep; s++) {
                        if (!this.validateStep(s)) {
                            alert("Veuillez d'abord compléter l'étape " + s + ".");
                            return;
                        }
                    }
                    this.step = targetStep;
                    this.scrollToTop();
                },

                validateStep(s) {
                    if (s === 1) {
                        const requiredFields = ['prenom', 'nom', 'date_naissance', 'lieu_naissance', 'nationalite', 'telephone', 'email_personnel', 'adresse'];
                        return this.checkFieldsValidity(requiredFields);
                    }
                    if (s === 2) {
                        const requiredFields = ['dernier_diplome', 'annee_diplome', 'etablissement_diplome', 'specialite_diplome'];
                        return this.checkFieldsValidity(requiredFields);
                    }
                    if (s === 3) {
                        const requiredFields = ['filiere_id', 'niveau_entree'];
                        return this.checkFieldsValidity(requiredFields);
                    }
                    if (s === 4) {
                        // Check files based on level
                        const level = this.niveau_entree;
                        if (['L1','L2','L3'].includes(level) && !this.checkFileSelected('releve_bac')) return false;
                        if (['L2','L3'].includes(level) && !this.checkFileSelected('releves_l1')) return false;
                        if (level === 'L3' && !this.checkFileSelected('releves_l2')) return false;
                        if (['M1','M2'].includes(level) && !this.checkFileSelected('attestation_licence')) return false;
                        if (level === 'M2' && !this.checkFileSelected('releves_m1')) return false;
                        return true;
                    }
                    return true;
                },

                checkFieldsValidity(fieldNames) {
                    let isValid = true;
                    fieldNames.forEach(name => {
                        const input = document.querySelector(`[name="${name}"]`);
                        if (input) {
                            if (!input.checkValidity()) {
                                isValid = false;
                                // Add a subtle visual red border highlight
                                input.classList.add('border-red-400', 'focus:ring-red-200');
                                input.classList.remove('border-gray-200', 'focus:ring-sigan-blue/10');
                            } else {
                                input.classList.remove('border-red-400', 'focus:ring-red-200');
                                input.classList.add('border-gray-200', 'focus:ring-sigan-blue/10');
                            }
                        }
                    });
                    return isValid;
                },

                checkFileSelected(inputName) {
                    const input = document.getElementById('file-' + inputName);
                    return input && input.files.length > 0;
                },

                scrollToTop() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                onFileSelected(event, name) {
                    const file = event.target.files[0];
                    const label = document.getElementById('label-' + name);
                    if (file && label) {
                        label.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-700 rounded-full font-bold border border-green-200 text-xs">✓ ${file.name}</span>`;
                        // Change container border and bg color
                        const container = event.target.closest('label');
                        if (container) {
                            container.classList.add('border-green-400', 'bg-green-50/10');
                            container.classList.remove('border-gray-200', 'bg-gray-50/50');
                        }
                    }
                },

                onSubmitForm(event) {
                    if (!this.validateStep(1) || !this.validateStep(2) || !this.validateStep(3) || !this.validateStep(4)) {
                        event.preventDefault();
                        alert("Des erreurs persistent dans votre formulaire. Veuillez vérifier toutes les étapes.");
                        return;
                    }
                    const cgu = document.getElementById('cgu');
                    if (cgu && !cgu.checked) {
                        event.preventDefault();
                        alert("Veuillez accepter les conditions d'inscription.");
                    }
                }
            }))
        })
    </script>
</body>
</html>
