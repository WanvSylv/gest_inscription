<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOREB ACADEMY — Excellence & Avenir</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-bg {
            background-image: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #1a56db 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #60a5fa, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.10);
        }
        .nav-blur {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            background: rgba(255,255,255,0.92);
        }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    {{-- ═══════ NAVIGATION ═══════ --}}
    <nav class="nav-blur fixed top-0 left-0 right-0 z-50 border-b border-gray-100 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" class="h-16 w-auto">
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#programmes" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Programmes</a>
                <a href="#pourquoi" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Pourquoi nous</a>
                <a href="#galerie" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors">Campus</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-sigan-blue hover:text-blue-700 transition-colors px-4 py-2 rounded-lg hover:bg-blue-50 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Administration
                </a>
                @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 transition-colors px-4 py-2 rounded-lg hover:bg-gray-100">
                    Connexion
                </a>
                @endauth
                <a href="{{ route('preinscription.verify-email') }}" class="text-sm font-semibold text-white bg-sigan-blue hover:bg-blue-700 transition-colors px-5 py-2.5 rounded-xl shadow-sm">
                    S'inscrire
                </a>
            </div>
        </div>
    </nav>

    {{-- ═══════ HERO ═══════ --}}
    <section class="hero-bg pt-16 min-h-screen flex items-center relative overflow-hidden">

        {{-- Décorations géométriques --}}
        <div class="absolute top-20 right-0 w-96 h-96 bg-white/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-6xl mx-auto px-6 py-24 grid lg:grid-cols-2 gap-16 items-center w-full">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 text-xs text-blue-200 font-semibold mb-6">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    Inscriptions ouvertes — Année 2026-2027
                </div>

                <h1 class="text-5xl lg:text-6xl font-black text-white leading-tight mb-6">
                    Construisez<br>
                    <span class="text-gradient">votre avenir</span><br>
                    avec nous.
                </h1>

                <p class="text-lg text-blue-100/80 font-light leading-relaxed mb-10 max-w-md">
                    HOREB ACADEMY forme les leaders de demain grâce à des programmes d'excellence en Licence et Master, dans un environnement stimulant et bienveillant.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('preinscription.verify-email') }}"
                       class="inline-flex items-center gap-2 bg-white text-sigan-blue font-bold text-sm px-7 py-4 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                        Déposer ma candidature
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="#programmes"
                       class="inline-flex items-center gap-2 border border-white/30 text-white font-semibold text-sm px-7 py-4 rounded-xl hover:bg-white/10 transition-all duration-200">
                        Nos programmes
                    </a>
                </div>

                <div class="flex items-center gap-8 mt-12 pt-8 border-t border-white/10">
                    <div>
                        <p class="text-3xl font-black text-white">500+</p>
                        <p class="text-xs text-blue-200 font-medium mt-0.5">Étudiants formés</p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div>
                        <p class="text-3xl font-black text-white">12</p>
                        <p class="text-xs text-blue-200 font-medium mt-0.5">Filières disponibles</p>
                    </div>
                    <div class="w-px h-10 bg-white/20"></div>
                    <div>
                        <p class="text-3xl font-black text-white">98%</p>
                        <p class="text-xs text-blue-200 font-medium mt-0.5">Taux de satisfaction</p>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block relative">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=800&h=500&fit=crop&q=80"
                         alt="Étudiants HOREB Academy"
                         class="w-full h-[500px] object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-900">Accrédité & reconnu</p>
                        <p class="text-[10px] text-gray-500">Ministère de l'Enseignement</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════ PROGRAMMES ═══════ --}}
    <section id="programmes" class="py-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <p class="text-sigan-blue text-sm font-bold uppercase tracking-widest mb-3">Nos formations</p>
                <h2 class="text-4xl font-black text-gray-900">Des programmes conçus<br>pour votre réussite</h2>
                <p class="text-gray-500 mt-4 max-w-xl mx-auto text-base font-light">Des cursus rigoureux qui allient théorie et pratique professionnelle pour vous préparer au monde du travail.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80&fit=crop"
                             alt="Informatique" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-blue-50 text-sigan-blue text-xs font-bold px-3 py-1 rounded-full mb-3">Licence · Master</span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Informatique & Numérique</h3>
                        <p class="text-sm text-gray-500 font-light leading-relaxed">Développement logiciel, cybersécurité, intelligence artificielle et systèmes d'information.</p>
                        <a href="{{ route('preinscription.verify-email') }}" class="inline-flex items-center gap-1.5 text-sigan-blue text-sm font-semibold mt-4 hover:gap-2.5 transition-all">
                            Postuler <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=600&q=80&fit=crop"
                             alt="Gestion" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-blue-50 text-sigan-blue text-xs font-bold px-3 py-1 rounded-full mb-3">Licence · Master</span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Gestion & Management</h3>
                        <p class="text-sm text-gray-500 font-light leading-relaxed">Finance, comptabilité, marketing, gestion de projet et entrepreneuriat d'entreprise.</p>
                        <a href="{{ route('preinscription.verify-email') }}" class="inline-flex items-center gap-1.5 text-sigan-blue text-sm font-semibold mt-4 hover:gap-2.5 transition-all">
                            Postuler <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm">
                    <div class="h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=600&q=80&fit=crop"
                             alt="Droit" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="inline-block bg-blue-50 text-sigan-blue text-xs font-bold px-3 py-1 rounded-full mb-3">Licence · Master</span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Droit & Sciences Juridiques</h3>
                        <p class="text-sm text-gray-500 font-light leading-relaxed">Droit privé, droit public, droit des affaires et pratique juridique contemporaine.</p>
                        <a href="{{ route('preinscription.verify-email') }}" class="inline-flex items-center gap-1.5 text-sigan-blue text-sm font-semibold mt-4 hover:gap-2.5 transition-all">
                            Postuler <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════ POURQUOI NOUS ═══════ --}}
    <section id="pourquoi" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=400&q=80&fit=crop"
                             alt="Campus" class="rounded-2xl w-full h-56 object-cover">
                        <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=400&q=80&fit=crop"
                             alt="Étudiants" class="rounded-2xl w-full h-56 object-cover mt-8">
                        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=400&q=80&fit=crop"
                             alt="Bibliothèque" class="rounded-2xl w-full h-40 object-cover">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=400&q=80&fit=crop"
                             alt="Conférence" class="rounded-2xl w-full h-40 object-cover -mt-4">
                    </div>
                </div>

                <div>
                    <p class="text-sigan-blue text-sm font-bold uppercase tracking-widest mb-3">Pourquoi nous choisir</p>
                    <h2 class="text-4xl font-black text-gray-900 mb-6">Une académie<br>à votre service.</h2>
                    <p class="text-gray-500 font-light leading-relaxed mb-10">
                        Depuis sa création, HOREB ACADEMY s'est imposée comme un établissement de référence grâce à la qualité de son corps enseignant, la modernité de ses équipements et son accompagnement personnalisé.
                    </p>

                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sigan-blue/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Corps enseignant d'excellence</h4>
                                <p class="text-gray-500 text-sm font-light mt-0.5">Des professeurs docteurs et professionnels reconnus dans leur domaine.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sigan-blue/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Diplômes reconnus nationalement</h4>
                                <p class="text-gray-500 text-sm font-light mt-0.5">Certifications validées par le Ministère de l'Enseignement Supérieur.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sigan-blue/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Accompagnement personnalisé</h4>
                                <p class="text-gray-500 text-sm font-light mt-0.5">Un suivi individuel tout au long de votre parcours académique.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sigan-blue/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-sigan-blue" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">Insertion professionnelle</h4>
                                <p class="text-gray-500 text-sm font-light mt-0.5">Un réseau d'entreprises partenaires pour faciliter votre intégration.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════ GALERIE ═══════ --}}
    <section id="galerie" class="py-24 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <p class="text-sigan-blue text-sm font-bold uppercase tracking-widest mb-3">Notre campus</p>
                <h2 class="text-4xl font-black text-gray-900">Un cadre propice<br>à l'apprentissage</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=500&q=80&fit=crop"
                     alt="Campus" class="rounded-2xl w-full h-48 object-cover col-span-2">
                <img src="https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=300&q=80&fit=crop"
                     alt="Bibliothèque" class="rounded-2xl w-full h-48 object-cover">
                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?w=300&q=80&fit=crop"
                     alt="Cours" class="rounded-2xl w-full h-48 object-cover">
                <img src="https://images.unsplash.com/photo-1606761568499-6d2451b23c66?w=300&q=80&fit=crop"
                     alt="Laboratoire" class="rounded-2xl w-full h-48 object-cover">
                <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=300&q=80&fit=crop"
                     alt="Remise de diplômes" class="rounded-2xl w-full h-48 object-cover">
                <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=500&q=80&fit=crop"
                     alt="Sport" class="rounded-2xl w-full h-48 object-cover col-span-2">
            </div>
        </div>
    </section>

    {{-- ═══════ CTA FINAL ═══════ --}}
    <section class="py-24 bg-sigan-blue relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/50 to-transparent pointer-events-none"></div>
        <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
            <h2 class="text-4xl lg:text-5xl font-black text-white mb-6">
                Votre avenir commence<br>ici, maintenant.
            </h2>
            <p class="text-blue-100/80 text-lg font-light mb-10 max-w-xl mx-auto">
                Les inscriptions pour l'année académique 2026-2027 sont ouvertes. Ne laissez pas passer cette opportunité.
            </p>
            <a href="{{ route('preinscription.verify-email') }}"
               class="inline-flex items-center gap-2.5 bg-white text-sigan-blue font-bold text-base px-8 py-4 rounded-xl shadow-xl hover:shadow-2xl hover:scale-105 transition-all duration-200">
                Commencer ma pré-inscription
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
            <p class="text-blue-200/60 text-sm mt-6">Gratuit · Sans engagement · Résultat sous 72h</p>
        </div>
    </section>

    {{-- ═══════ FOOTER ═══════ --}}
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-6xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-2.5">
                    <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" class="h-7 w-auto">
                    <span class="text-white font-bold">HOREB <span class="text-gray-400 font-light">academy</span></span>
                </div>
                <p class="text-sm text-center">© {{ date('Y') }} HOREB ACADEMY. Tous droits réservés.</p>
                <a href="{{ route('login') }}" class="text-sm hover:text-white transition-colors">Espace administration</a>
            </div>
        </div>
    </footer>

</body>
</html>
