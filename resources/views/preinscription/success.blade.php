<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Soumise — HOREB ACADEMY</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Checkmark scale-in animation */
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            60% {
                transform: scale(1.15);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes drawCheck {
            0% {
                stroke-dashoffset: 60;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        @keyframes fadeInUp {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-scale-in {
            animation: scaleIn 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .animate-draw-check {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
            animation: drawCheck 0.5s 0.4s ease-out forwards;
        }

        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .animate-delay-1 { animation-delay: 0.3s; }
        .animate-delay-2 { animation-delay: 0.5s; }
        .animate-delay-3 { animation-delay: 0.7s; }
        .animate-delay-4 { animation-delay: 0.9s; }
        .animate-delay-5 { animation-delay: 1.1s; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col">

    {{-- ========== HEADER BAR ========== --}}
    <header class="bg-sigan-blue shadow-md">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center gap-4">
            {{-- Logo --}}
            <div class="flex-shrink-0 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30">
                <span class="text-white font-extrabold text-sm tracking-tight">HA</span>
            </div>
            {{-- Title --}}
            <div>
                <h1 class="text-white font-bold text-lg tracking-wide leading-tight">HOREB ACADEMY</h1>
                <p class="text-blue-200 text-xs font-medium tracking-wider">E-SERVICES</p>
            </div>
        </div>
    </header>

    {{-- ========== MAIN CONTENT ========== --}}
    <main class="flex-1 flex items-center justify-center px-4 py-10 sm:py-16">
        <div class="w-full max-w-xl">

            {{-- Success Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                {{-- Top green gradient strip --}}
                <div class="h-1.5 bg-gradient-to-r from-green-400 via-emerald-500 to-teal-500"></div>

                <div class="px-6 sm:px-10 py-10">

                    {{-- Animated Checkmark --}}
                    <div class="flex justify-center mb-6">
                        <div class="animate-scale-in w-20 h-20 rounded-full bg-green-50 border-4 border-green-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 12 10 16 18 8" class="animate-draw-check"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Title --}}
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-2 animate-fade-in-up animate-delay-1">
                        Inscription Soumise avec Succès !
                    </h2>

                    {{-- Subtitle --}}
                    <p class="text-gray-500 text-center text-sm sm:text-base leading-relaxed mb-8 animate-fade-in-up animate-delay-2">
                        Votre dossier de pré-inscription a été enregistré. Voici les prochaines étapes de votre processus d'inscription.
                    </p>

                    {{-- Steps Card --}}
                    <div class="bg-gray-50 rounded-xl border border-gray-100 p-5 sm:p-6 mb-6 animate-fade-in-up animate-delay-3">
                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Prochaines étapes</h3>

                        <div class="space-y-5">
                            {{-- Step 1 --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-sigan-blue text-white text-sm font-bold flex items-center justify-center shadow-sm">
                                    1
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-semibold text-gray-800">Examen du dossier</p>
                                    <p class="text-sm text-gray-500 mt-0.5">La Direction Académique examine votre dossier de pré-inscription et vos pièces jointes.</p>
                                </div>
                            </div>

                            {{-- Connector line --}}
                            <div class="flex items-center pl-4">
                                <div class="w-px h-3 bg-gray-200"></div>
                            </div>

                            {{-- Step 2 --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-sigan-blue text-white text-sm font-bold flex items-center justify-center shadow-sm">
                                    2
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-semibold text-gray-800">Notification par email</p>
                                    <p class="text-sm text-gray-500 mt-0.5">Vous recevrez un email vous informant de la décision (validation ou demande de complément).</p>
                                </div>
                            </div>

                            {{-- Connector line --}}
                            <div class="flex items-center pl-4">
                                <div class="w-px h-3 bg-gray-200"></div>
                            </div>

                            {{-- Step 3 --}}
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-sigan-blue text-white text-sm font-bold flex items-center justify-center shadow-sm">
                                    3
                                </div>
                                <div class="pt-0.5">
                                    <p class="text-sm font-semibold text-gray-800">Paiement sous 72h</p>
                                    <p class="text-sm text-gray-500 mt-0.5">Si votre dossier est validé, vous disposerez de <span class="font-semibold text-gray-700">72 heures</span> pour effectuer le paiement des frais d'inscription.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div class="bg-blue-50 rounded-xl border border-blue-100 p-5 mb-8 animate-fade-in-up animate-delay-4">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-sigan-blue" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-sigan-blue mb-1">Informations importantes</p>
                                <ul class="text-sm text-blue-700 space-y-1.5">
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 w-1 h-1 rounded-full bg-blue-400 flex-shrink-0"></span>
                                        Vérifiez régulièrement votre boîte email (y compris les spams).
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 w-1 h-1 rounded-full bg-blue-400 flex-shrink-0"></span>
                                        Conservez bien votre adresse email utilisée lors de l'inscription.
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="mt-1.5 w-1 h-1 rounded-full bg-blue-400 flex-shrink-0"></span>
                                        Le non-paiement dans les 72h après validation entraîne l'annulation du dossier.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Button --}}
                    <div class="text-center animate-fade-in-up animate-delay-5">
                        <a href="/"
                           class="inline-flex items-center justify-center gap-2 bg-sigan-blue text-white font-semibold rounded-lg px-8 py-3 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sigan-blue transition-colors shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Retour à l'accueil
                        </a>
                    </div>

                </div>
            </div>

            {{-- Footer text --}}
            <p class="text-center text-xs text-gray-400 mt-6">
                © {{ date('Y') }} HOREB ACADEMY — Tous droits réservés
            </p>

        </div>
    </main>

</body>
</html>
