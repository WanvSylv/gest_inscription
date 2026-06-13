<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Validé — HOREB ACADEMY</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

            {{-- Header --}}
            <tr>
                <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 60%,#1a56db 100%);padding:32px 40px;text-align:center;">
                    <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" style="height:56px;width:auto;display:block;margin:0 auto 12px;">
                    <p style="color:rgba(191,219,254,0.8);font-size:13px;margin:0;font-weight:600;letter-spacing:0.05em;">DÉCISION ACADÉMIQUE</p>
                </td>
            </tr>

            {{-- Badge validé --}}
            <tr>
                <td style="padding:32px 40px 0;text-align:center;">
                    <div style="display:inline-block;background:#f0fdf4;border:2px solid #bbf7d0;border-radius:50%;width:72px;height:72px;line-height:72px;text-align:center;margin-bottom:20px;">
                        <span style="font-size:36px;">✅</span>
                    </div>
                    <h1 style="color:#111827;font-size:22px;font-weight:900;margin:0 0 8px 0;">Votre dossier est validé !</h1>
                    <p style="color:#6b7280;font-size:14px;margin:0;">Félicitations {{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="padding:28px 40px;">
                    <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px 0;">
                        La Direction Académique de HOREB ACADEMY a examiné votre dossier de pré-inscription et a le plaisir de vous informer que votre candidature a été <strong style="color:#16a34a;">acceptée</strong>.
                    </p>

                    {{-- Récap --}}
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:24px;">
                        <p style="color:#374151;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 12px 0;">Récapitulatif de votre inscription</p>
                        <table width="100%" cellpadding="6" cellspacing="0">
                            <tr><td style="color:#6b7280;font-size:13px;width:40%;">Filière</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->filiere->nom }}</td></tr>
                            <tr><td style="color:#6b7280;font-size:13px;">Niveau</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->niveau }}</td></tr>
                            <tr><td style="color:#6b7280;font-size:13px;">Année académique</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->annee_academique }}</td></tr>
                            <tr><td style="color:#6b7280;font-size:13px;">Frais de scolarité</td><td style="color:#1a56db;font-size:13px;font-weight:700;">{{ number_format($inscription->filiere->frais_inscription, 0, ',', ' ') }} XOF</td></tr>
                        </table>
                    </div>

                    {{-- Alerte 72h --}}
                    <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:12px;padding:16px 20px;margin-bottom:24px;">
                        <p style="color:#92400e;font-size:13px;font-weight:700;margin:0 0 6px 0;">⏰ Action requise sous 72 heures</p>
                        <p style="color:#b45309;font-size:13px;margin:0;line-height:1.6;">
                            Pour finaliser votre inscription, vous devez effectuer le paiement des frais de scolarité dans un délai de <strong>72 heures</strong>. Passé ce délai, votre dossier sera automatiquement annulé.
                        </p>
                    </div>

                    {{-- Bouton paiement --}}
                    <div style="text-align:center;margin-bottom:24px;">
                        <a href="{{ route('paiement.show', ['token' => $inscription->token_paiement]) }}"
                           style="display:inline-block;background:#1a56db;color:#fff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:12px;">
                            Procéder au paiement →
                        </a>
                    </div>

                    <p style="color:#9ca3af;font-size:12px;text-align:center;margin:0;">
                        Si le bouton ne fonctionne pas, copiez ce lien :<br>
                        <a href="{{ route('paiement.show', ['token' => $inscription->token_paiement]) }}" style="color:#1a56db;word-break:break-all;">
                            {{ route('paiement.show', ['token' => $inscription->token_paiement]) }}
                        </a>
                    </p>
                </td>
            </tr>

            {{-- Footer --}}
            <tr>
                <td style="background:#f9fafb;border-top:1px solid #f3f4f6;padding:20px 40px;text-align:center;">
                    <p style="color:#9ca3af;font-size:12px;margin:0;">© {{ date('Y') }} HOREB ACADEMY — Tous droits réservés</p>
                </td>
            </tr>

        </table>
    </td></tr>
</table>
</body>
</html>
