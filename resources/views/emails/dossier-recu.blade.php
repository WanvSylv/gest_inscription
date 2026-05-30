<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier reçu — HOREB ACADEMY</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

            {{-- Header --}}
            <tr>
                <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 60%,#1a56db 100%);padding:32px 40px;text-align:center;">
                    <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" style="height:56px;width:auto;display:block;margin:0 auto 12px;">
                    <p style="color:rgba(191,219,254,0.8);font-size:13px;margin:0;font-weight:600;letter-spacing:0.05em;">CONFIRMATION DE RÉCEPTION</p>
                </td>
            </tr>

            {{-- Badge --}}
            <tr>
                <td style="padding:32px 40px 0;text-align:center;">
                    <div style="display:inline-block;background:#f0f7ff;border:2px solid #bfdbfe;border-radius:50%;width:72px;height:72px;line-height:72px;text-align:center;margin-bottom:20px;">
                        <span style="font-size:36px;">📋</span>
                    </div>
                    <h1 style="color:#111827;font-size:22px;font-weight:900;margin:0 0 8px 0;">Dossier bien reçu !</h1>
                    <p style="color:#6b7280;font-size:14px;margin:0;">Bonjour <strong>{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</strong></p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="padding:28px 40px;">
                    <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px 0;">
                        Nous avons bien reçu votre dossier de pré-inscription à <strong style="color:#1a56db;">HOREB ACADEMY</strong>. Notre Direction Académique va l'examiner dans les meilleurs délais.
                    </p>

                    {{-- Récap --}}
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:24px;">
                        <p style="color:#374151;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 12px 0;">Récapitulatif de votre demande</p>
                        <table width="100%" cellpadding="6" cellspacing="0">
                            <tr><td style="color:#6b7280;font-size:13px;width:40%;">Filière</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->filiere->nom }}</td></tr>
                            <tr><td style="color:#6b7280;font-size:13px;">Niveau</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->niveau }}</td></tr>
                            <tr><td style="color:#6b7280;font-size:13px;">Année académique</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->annee_academique }}</td></tr>
                            <tr><td style="color:#6b7280;font-size:13px;">Date de soumission</td><td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->created_at->format('d/m/Y à H:i') }}</td></tr>
                        </table>
                    </div>

                    {{-- Étapes --}}
                    <div style="margin-bottom:24px;">
                        <p style="color:#374151;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 16px 0;">Prochaines étapes</p>

                        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
                            <div style="width:28px;height:28px;background:#1a56db;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;text-align:center;line-height:28px;">
                                <span style="color:#fff;font-size:12px;font-weight:700;">1</span>
                            </div>
                            <div style="padding-top:4px;">
                                <p style="color:#111827;font-size:13px;font-weight:700;margin:0 0 3px 0;">Examen du dossier</p>
                                <p style="color:#6b7280;font-size:12px;margin:0;">La Direction Académique examine votre candidature et vos pièces jointes.</p>
                            </div>
                        </div>

                        <div style="display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;">
                            <div style="width:28px;height:28px;background:#1a56db;border-radius:50%;text-align:center;line-height:28px;flex-shrink:0;">
                                <span style="color:#fff;font-size:12px;font-weight:700;">2</span>
                            </div>
                            <div style="padding-top:4px;">
                                <p style="color:#111827;font-size:13px;font-weight:700;margin:0 0 3px 0;">Notification par email</p>
                                <p style="color:#6b7280;font-size:12px;margin:0;">Vous recevrez une réponse sur cette adresse email.</p>
                            </div>
                        </div>

                        <div style="display:flex;align-items:flex-start;gap:12px;">
                            <div style="width:28px;height:28px;background:#1a56db;border-radius:50%;text-align:center;line-height:28px;flex-shrink:0;">
                                <span style="color:#fff;font-size:12px;font-weight:700;">3</span>
                            </div>
                            <div style="padding-top:4px;">
                                <p style="color:#111827;font-size:13px;font-weight:700;margin:0 0 3px 0;">Paiement sous 72h</p>
                                <p style="color:#6b7280;font-size:12px;margin:0;">Si votre dossier est accepté, un lien de paiement vous sera envoyé. Vous aurez <strong>72 heures</strong> pour régler les frais.</p>
                            </div>
                        </div>
                    </div>

                    <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:12px 16px;">
                        <p style="color:#92400e;font-size:12px;margin:0;">⚠️ Vérifiez régulièrement vos spams. Conservez cette adresse email <strong>{{ $inscription->etudiant->email_personnel }}</strong> pour toute la durée du processus.</p>
                    </div>
                </td>
            </tr>

            {{-- Footer --}}
            <tr>
                <td style="background:#f9fafb;border-top:1px solid #f3f4f6;padding:20px 40px;text-align:center;">
                    <p style="color:#9ca3af;font-size:12px;margin:0;">© {{ date('Y') }} HOREB ACADEMY — Tous droits réservés</p>
                    <p style="color:#d1d5db;font-size:11px;margin:4px 0 0 0;">📧 horebacademy@manosphone.com</p>
                </td>
            </tr>

        </table>
    </td></tr>
</table>
</body>
</html>
