@extends('layouts.public')
@section('title', 'Paiement confirmé')

@push('head')
<style>
    @keyframes scaleIn { from{transform:scale(0);opacity:0} to{transform:scale(1);opacity:1} }
    @keyframes drawCheck { from{stroke-dashoffset:48} to{stroke-dashoffset:0} }
    @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    .anim-scale { animation: scaleIn 0.6s cubic-bezier(0.68,-0.55,0.265,1.55) forwards; }
    .anim-check { stroke-dasharray:48; stroke-dashoffset:48; animation: drawCheck 0.4s ease-out 0.5s forwards; }
    .anim-1 { opacity:0; animation: fadeUp 0.5s ease forwards 0.3s; }
    .anim-2 { opacity:0; animation: fadeUp 0.5s ease forwards 0.5s; }
    .anim-3 { opacity:0; animation: fadeUp 0.5s ease forwards 0.7s; }
</style>
@endpush

@section('content')
<div class="flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-lg">

        {{-- Icône animée --}}
        <div class="flex justify-center mb-8 anim-scale">
            <div class="relative w-24 h-24 rounded-full bg-green-50 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full bg-green-100 animate-ping opacity-20" style="animation-duration:3s;"></div>
                <svg class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path class="anim-check" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        {{-- Titre --}}
        <div class="text-center mb-8 anim-1">
            <h1 class="text-3xl font-black text-gray-900 mb-2">Paiement confirmé !</h1>
            <p class="text-gray-500 text-base leading-relaxed">
                Félicitations <strong class="text-gray-800">{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</strong>,<br>
                vous êtes officiellement inscrit(e) à <strong class="text-sigan-blue">HOREB ACADEMY</strong>.
            </p>
        </div>

        {{-- Récap --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5 anim-2">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Récapitulatif de votre inscription</p>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Filière</span>
                    <span class="font-bold text-sigan-blue">{{ $inscription->filiere->nom ?? '—' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Niveau</span>
                    <span class="font-semibold text-gray-800">{{ $inscription->niveau }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Année académique</span>
                    <span class="font-semibold text-gray-800">{{ $inscription->annee_academique }}</span>
                </div>
                @if(isset($paiement) && $paiement)
                <div class="border-t border-gray-100 pt-3 flex justify-between text-sm">
                    <span class="text-gray-400">Montant payé</span>
                    <span class="font-black text-green-600 text-base">{{ number_format($paiement->montant, 0, ',', ' ') }} XOF</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Info email --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-6 anim-2">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-sigan-blue flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                <div>
                    <p class="text-sm font-bold text-blue-800 mb-1">Email envoyé avec vos identifiants</p>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        Vérifiez <strong>{{ $inscription->etudiant->email_personnel }}</strong>.<br>
                        Vous y trouverez vos identifiants de connexion et votre <strong>reçu PDF</strong>.
                    </p>
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="text-center anim-3">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 bg-sigan-blue text-white font-bold text-sm px-8 py-4 rounded-xl hover:bg-blue-700 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                Accéder à mon espace étudiant
            </a>
            <p class="text-xs text-gray-400 mt-3">
                Des questions ? Contactez-nous à <a href="mailto:horebacademy@manosphone.com" class="text-sigan-blue hover:underline">horebacademy@manosphone.com</a>
            </p>
        </div>

    </div>
</div>
@endsection
