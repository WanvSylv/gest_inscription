<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi - HOREB ACADEMY</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts/Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Animations personnalisées */
        @keyframes scale-in {
            0% { transform: scale(0); opacity: 0; }
            60% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes draw-check {
            0% { stroke-dashoffset: 48; }
            100% { stroke-dashoffset: 0; }
        }
        @keyframes fade-up {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .animate-scale-in {
            animation: scale-in 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }
        .animate-draw-check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: draw-check 0.4s ease-out 0.5s forwards;
        }
        .animate-fade-up {
            opacity: 0;
            animation: fade-up 0.6s ease-out 0.2s forwards;
        }
        .delay-1 { animation-delay: 0.3s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.5s; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-6 antialiased selection:bg-sigan-blue selection:text-white">

    <!-- Card Container -->
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden relative">
        
        <!-- Top decorative bar -->
        <div class="h-2 w-full bg-sigan-blue absolute top-0 left-0"></div>

        <div class="p-8 sm:p-10 flex flex-col items-center text-center space-y-8">
            
            <!-- Animated Icon -->
            <div class="relative flex justify-center items-center w-24 h-24 rounded-full bg-green-50 shadow-sm animate-scale-in">
                <div class="absolute inset-0 rounded-full bg-green-100 animate-ping opacity-20" style="animation-duration: 3s;"></div>
                <svg class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <path class="animate-draw-check" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Header Text -->
            <div class="space-y-3 animate-fade-up delay-1">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">
                    {{ session('info') ?? session('success') ?? 'Paiement Réussi !' }}
                </h1>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Félicitations, votre transaction a été validée avec succès. Vous êtes désormais officiellement inscrit(e) à <span class="font-bold text-gray-900">HOREB ACADEMY</span>.
                </p>
            </div>

            <!-- Info Box -->
            <div class="w-full bg-blue-50/80 border border-blue-100 rounded-xl p-5 flex items-start gap-4 text-left animate-fade-up delay-2">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="w-6 h-6 text-sigan-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900 mb-1">Prochaines étapes</h3>
                    <p class="text-sm text-blue-800 leading-relaxed">
                        Vous recevrez sous peu un e-mail contenant <strong class="font-semibold">vos identifiants de connexion</strong> ainsi que votre <strong class="font-semibold">reçu de paiement PDF</strong> pour vos archives.
                    </p>
                </div>
            </div>

            <!-- Action Button -->
            <div class="w-full animate-fade-up delay-3 pt-2">
                <a href="{{ route('login') }}" class="group flex items-center justify-center w-full gap-2 bg-sigan-blue text-white font-semibold text-lg rounded-xl px-6 py-4 hover:bg-blue-700 transition-all shadow-md hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-100">
                    <span>Aller au portail de connexion</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
            
        </div>

        <!-- Footer Text -->
        <div class="bg-gray-50/80 border-t border-gray-100 py-4 px-8 text-center">
            <p class="text-xs text-gray-500 font-medium">
                Si vous avez des questions, veuillez contacter notre <a href="#" class="text-sigan-blue hover:underline">support technique</a>.
            </p>
        </div>
    </div>

</body>
</html>
