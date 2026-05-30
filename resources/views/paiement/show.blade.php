<!DOCTYPE html>
<html lang="fr" class="antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Sécurisé - HOREB ACADEMY</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen selection:bg-sigan-blue selection:text-white">

    <div class="flex-grow flex items-center justify-center p-4 sm:p-6 lg:p-8">
        <div class="w-full max-w-lg">
            
            <!-- Logo / Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-sigan-blue/10 mb-5 shadow-sm border border-sigan-blue/20">
                    <svg class="w-8 h-8 text-sigan-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">HOREB ACADEMY</h1>
                <p class="text-sm text-gray-500 mt-2 font-medium">Portail de Paiement Sécurisé</p>
            </div>

            <!-- Alerts -->
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold">Erreur de paiement</h3>
                        <p class="text-sm mt-1 opacity-90">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-5 py-4 rounded-xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold">Information</h3>
                        <p class="text-sm mt-1 opacity-90">{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Amount Section -->
                <div class="p-8 text-center border-b border-gray-100 bg-gray-50/50">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Montant à régler</p>
                    <div class="flex items-center justify-center text-4xl sm:text-5xl font-bold text-gray-900 tracking-tight">
                        {{ number_format($inscription->filiere->montant_scolarite ?? 0, 0, ',', ' ') }} 
                        <span class="text-2xl sm:text-3xl ml-2 text-gray-400 font-medium">XOF</span>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="p-8">
                    <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-5">Détails de l'étudiant</h2>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Nom & Prénoms</span>
                            <span class="text-sm font-semibold text-gray-900 text-right">{{ $inscription->nom }} {{ $inscription->prenom }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Email</span>
                            <span class="text-sm font-medium text-gray-900 text-right">{{ $inscription->email }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-50">
                            <span class="text-sm text-gray-500">Téléphone</span>
                            <span class="text-sm font-medium text-gray-900 text-right">{{ $inscription->telephone }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Filière</span>
                            <span class="text-sm font-semibold text-sigan-blue text-right">{{ $inscription->filiere->nom ?? 'Non définie' }}</span>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <form action="{{ route('paiement.payer', ['token' => $inscription->token_paiement]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-sigan-blue text-white font-semibold rounded-lg px-5 py-4 hover:bg-blue-700 transition-colors flex items-center justify-center group shadow-md shadow-sigan-blue/20">
                            <span class="text-base">Procéder au paiement (FedaPay)</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Trust Indicators -->
                    <div class="mt-6 flex flex-col items-center justify-center gap-2">
                        <div class="flex items-center text-gray-600 text-xs font-medium">
                            <svg class="w-4 h-4 text-emerald-500 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Paiement 100% sécurisé
                        </div>
                        <div class="text-[11px] text-gray-400 font-medium">
                            Mobile Money & Cartes Bancaires acceptées
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-xs text-gray-400 font-medium">
                    &copy; {{ date('Y') }} HOREB ACADEMY. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>

</body>
</html>
