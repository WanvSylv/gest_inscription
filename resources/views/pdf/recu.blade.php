<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement — HOREB ACADEMY</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1a1a2e; font-size: 13px; background: #fff; }

        /* ── Header ── */
        .header {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1a56db 100%);
            padding: 28px 36px;
            color: white;
        }
        .header-inner { display: flex; justify-content: space-between; align-items: flex-start; }
        .brand { font-size: 22px; font-weight: 900; letter-spacing: 0.05em; color: white; }
        .brand span { font-weight: 300; opacity: 0.75; }
        .doc-title { text-align: right; }
        .doc-title h1 { font-size: 18px; font-weight: 800; color: white; margin-bottom: 4px; }
        .doc-title p { font-size: 11px; color: rgba(191,219,254,0.8); letter-spacing: 0.08em; text-transform: uppercase; }

        /* ── Numéro de reçu ── */
        .receipt-num {
            background: #f0f7ff;
            border-left: 4px solid #1a56db;
            padding: 12px 36px;
            font-size: 12px;
            color: #1e40af;
            display: flex;
            justify-content: space-between;
        }
        .receipt-num strong { font-weight: 700; }

        /* ── Body ── */
        .body { padding: 28px 36px; }

        /* Sections */
        .section { margin-bottom: 24px; }
        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #6b7280;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        /* Tables */
        table.info { width: 100%; border-collapse: collapse; }
        table.info td { padding: 6px 0; font-size: 13px; vertical-align: top; }
        table.info td:first-child { color: #6b7280; width: 45%; }
        table.info td:last-child { color: #111827; font-weight: 600; }

        /* Grille 2 colonnes */
        .two-col { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        .col:first-child { padding-right: 20px; }
        .col:last-child { padding-left: 20px; border-left: 1px solid #f3f4f6; }

        /* Montant total */
        .amount-box {
            background: #f0f7ff;
            border: 2px solid #bfdbfe;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .amount-box .label { font-size: 13px; font-weight: 700; color: #374151; }
        .amount-box .amount { font-size: 22px; font-weight: 900; color: #1a56db; }
        .amount-box .currency { font-size: 13px; font-weight: 500; color: #6b7280; margin-left: 4px; }

        /* Certification */
        .cert-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 28px;
            font-size: 12px;
            color: #166534;
            line-height: 1.6;
        }
        .cert-box strong { font-weight: 700; }

        /* Sceau / Validation */
        .seal {
            text-align: center;
            margin-bottom: 20px;
        }
        .seal-circle {
            display: inline-block;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            border: 3px solid #1a56db;
            line-height: 90px;
            text-align: center;
            color: #1a56db;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #e5e7eb;
            padding: 16px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
        }
        .footer p { font-size: 10px; color: #9ca3af; }
        .footer .qr-placeholder {
            width: 50px; height: 50px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            color: #d1d5db;
        }

        .badge {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>

    {{-- ══ HEADER ══ --}}
    <div class="header">
        <div class="header-inner">
            <div>
                <div class="brand">HOREB <span>academy</span></div>
                <div style="font-size:11px; color:rgba(191,219,254,0.6); margin-top:4px;">horebacademy@manosphone.com</div>
            </div>
            <div class="doc-title">
                <h1>Reçu de Paiement</h1>
                <p>Document officiel</p>
            </div>
        </div>
    </div>

    {{-- ══ N° REÇU ══ --}}
    <div class="receipt-num">
        <span>N° Transaction : <strong>{{ $paiement->transaction_id }}</strong></span>
        <span>Date : <strong>{{ $paiement->paye_le ? $paiement->paye_le->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</strong></span>
    </div>

    {{-- ══ BODY ══ --}}
    <div class="body">

        {{-- Montant total --}}
        <div class="amount-box">
            <div class="label">Montant total payé</div>
            <div>
                <span class="amount">{{ number_format($paiement->montant, 0, ',', ' ') }}</span>
                <span class="currency">XOF</span>
                <span class="badge" style="margin-left:8px;">Payé</span>
            </div>
        </div>

        {{-- 2 colonnes --}}
        <div class="two-col">

            {{-- Colonne étudiant --}}
            <div class="col">
                <div class="section">
                    <div class="section-title">Informations de l'étudiant</div>
                    <table class="info">
                        <tr><td>Nom complet</td><td>{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</td></tr>
                        <tr><td>Matricule</td><td>{{ $inscription->etudiant->matricule ?? 'En cours...' }}</td></tr>
                        <tr><td>Email</td><td style="font-size:11px;">{{ $inscription->etudiant->email_personnel }}</td></tr>
                        <tr><td>Téléphone</td><td>{{ $inscription->etudiant->telephone }}</td></tr>
                        <tr><td>Nationalité</td><td>{{ $inscription->etudiant->nationalite }}</td></tr>
                    </table>
                </div>
            </div>

            {{-- Colonne inscription --}}
            <div class="col">
                <div class="section">
                    <div class="section-title">Détails de l'inscription</div>
                    <table class="info">
                        <tr><td>Filière</td><td>{{ $inscription->filiere->nom }}</td></tr>
                        <tr><td>Niveau</td><td>{{ $inscription->niveau }}</td></tr>
                        <tr><td>Année académique</td><td>{{ $inscription->annee_academique }}</td></tr>
                        <tr><td>Moyen de paiement</td><td>{{ ucfirst(str_replace('_', ' ', $paiement->methode ?? 'Mobile Money')) }}</td></tr>
                        <tr><td>Statut</td><td><span class="badge">Confirmé</span></td></tr>
                    </table>
                </div>
            </div>

        </div>

        {{-- Certification --}}
        <div class="cert-box">
            <strong>Certification :</strong> Ce document certifie que <strong>{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</strong>
            a bien réglé ses frais d'inscription pour l'année académique <strong>{{ $inscription->annee_academique }}</strong>
            en filière <strong>{{ $inscription->filiere->nom }}</strong> ({{ $inscription->niveau }}) à HOREB ACADEMY.
            Ce reçu est généré électroniquement et constitue un justificatif officiel de paiement.
        </div>

        {{-- Sceau --}}
        <div class="seal">
            <div class="seal-circle">HOREB<br>ACADEMY<br>OFFICIEL</div>
        </div>

    </div>

    {{-- ══ FOOTER ══ --}}
    <div class="footer">
        <div>
            <p style="font-weight:700; color:#374151; margin-bottom:2px;">HOREB ACADEMY</p>
            <p>Reçu généré le {{ now()->format('d/m/Y à H:i') }}</p>
            <p>Ce document ne nécessite pas de signature manuscrite.</p>
        </div>
        <div>
            <p style="color:#374151; font-weight:600; font-size:11px;">Transaction FedaPay</p>
            <p style="font-size:9px; word-break:break-all; max-width:200px;">{{ $paiement->transaction_id }}</p>
        </div>
    </div>

</body>
</html>
