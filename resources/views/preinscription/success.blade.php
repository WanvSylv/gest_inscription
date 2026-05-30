@extends('layouts.public')
@section('title', 'Dossier soumis')

@push('head')
<style>
    @keyframes scaleIn { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    @keyframes fadeUp { from { transform: translateY(16px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .animate-scale { animation: scaleIn 0.5s cubic-bezier(0.34,1.56,0.64,1) forwards; }
    .animate-up-1 { opacity:0; animation: fadeUp 0.5s ease forwards 0.2s; }
    .animate-up-2 { opacity:0; animation: fadeUp 0.5s ease forwards 0.4s; }
    .animate-up-3 { opacity:0; animation: fadeUp 0.5s ease forwards 0.6s; }
    .animate-up-4 { opacity:0; animation: fadeUp 0.5s ease forwards 0.8s; }
</style>
@endpush

@section('content')
<div class="flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-lg">

        <div class="flex justify-center mb-8 animate-scale">
            <div class="w-20 h-20 bg-green-50 border-4 border-green-100 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
        </div>

        <div class="text-center mb-10 animate-up-1">
            <h1 class="text-3xl font-black text-gray-900 mb-3">Dossier soumis !</h1>
            <p class="text-gray-400 text-base font-light leading-relaxed">
                Votre dossier de pré-inscription a bien été enregistré.<br>
                Surveillez votre boîte email pour la suite.
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5 animate-up-2">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Prochaines étapes</p>
            <div class="space-y-5">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-sigan-blue text-white text-xs font-black flex items-center justify-center flex-shrink-0">1</div>
                    <div class="pt-0.5">
                        <p class="text-sm font-bold text-gray-800">Examen du dossier</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">La Direction Académique examine votre candidature et vos pièces jointes.</p>
                    </div>
                </div>
                <div class="w-px h-4 bg-gray-100 ml-4"></div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-sigan-blue text-white text-xs font-black flex items-center justify-center flex-shrink-0">2</div>
                    <div class="pt-0.5">
                        <p class="text-sm font-bold text-gray-800">Notification par email</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Vous recevrez un email vous informant de la décision académique.</p>
                    </div>
                </div>
                <div class="w-px h-4 bg-gray-100 ml-4"></div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-full bg-sigan-blue text-white text-xs font-black flex items-center justify-center flex-shrink-0">3</div>
                    <div class="pt-0.5">
                        <p class="text-sm font-bold text-gray-800">Paiement sous 72h</p>
                        <p class="text-xs text-gray-400 mt-0.5 leading-relaxed">Si votre dossier est validé, un lien de paiement vous sera envoyé. Vous aurez <strong class="text-gray-600">72 heures</strong> pour régler les frais.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6 animate-up-3">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-sigan-blue flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                <div>
                    <p class="text-sm font-bold text-blue-800 mb-1">Vérifiez votre boîte email</p>
                    <ul class="text-xs text-blue-700 space-y-1 leading-relaxed">
                        <li>• Consultez aussi vos spams et courriers indésirables.</li>
                        <li>• Conservez l'adresse email utilisée lors de l'inscription.</li>
                        <li>• Le non-paiement dans les 72h entraîne l'annulation du dossier.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center animate-up-4">
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 bg-sigan-blue text-white font-bold text-sm px-8 py-3.5 rounded-xl hover:bg-blue-700 transition-all shadow-sm active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Retour à l'accueil
            </a>
        </div>

    </div>
</div>
@endsection
