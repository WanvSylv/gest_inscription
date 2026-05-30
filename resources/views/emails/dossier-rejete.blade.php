<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Décision dossier — HOREB ACADEMY</title>
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

            {{-- Badge --}}
            <tr>
                <td style="padding:32px 40px 0;text-align:center;">
                    <div style="display:inline-block;background:{{ $modifiable ? '#fff7ed' : '#fef2f2' }};border:2px solid {{ $modifiable ? '#fed7aa' : '#fecaca' }};border-radius:50%;width:72px;height:72px;line-height:72px;text-align:center;margin-bottom:20px;">
                        <span style="font-size:36px;">{{ $modifiable ? '⚠️' : '❌' }}</span>
                    </div>
                    @if($modifiable)
                    <h1 style="color:#111827;font-size:22px;font-weight:900;margin:0 0 8px 0;">Votre dossier nécessite des modifications</h1>
                    @else
                    <h1 style="color:#111827;font-size:22px;font-weight:900;margin:0 0 8px 0;">Votre dossier n'a pas été retenu</h1>
                    @endif
                    <p style="color:#6b7280;font-size:14px;margin:0;">{{ $inscription->etudiant->prenom }} {{ $inscription->etudiant->nom }}</p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="padding:28px 40px;">
                    @if($modifiable)
                    <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 20px 0;">
                        La Direction Académique a examiné votre dossier et souhaite vous demander d'apporter les modifications suivantes avant de pouvoir prendre une décision finale.
                    </p>
                    @else
                    <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 20px 0;">
                        Après examen attentif de votre dossier de pré-inscription, la Direction Académique de HOREB ACADEMY a pris la décision de ne pas retenir votre candidature pour cette année académique.
                    </p>
                    @endif

                    {{-- Motif --}}
                    <div style="background:{{ $modifiable ? '#fff7ed' : '#fef2f2' }};border-left:4px solid {{ $modifiable ? '#f97316' : '#ef4444' }};border-radius:0 8px 8px 0;padding:16px 20px;margin-bottom:24px;">
                        <p style="color:{{ $modifiable ? '#9a3412' : '#991b1b' }};font-size:13px;font-weight:700;margin:0 0 6px 0;">
                            {{ $modifiable ? 'Modifications demandées' : 'Motif de la décision' }}
                        </p>
                        <p style="color:{{ $modifiable ? '#c2410c' : '#b91c1c' }};font-size:13px;margin:0;line-height:1.6;">{{ $motif }}</p>
                    </div>

                    @if($modifiable)
                    <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 20px 0;">
                        Veuillez prendre contact avec notre administration pour soumettre les documents ou informations manquants.
                    </p>
                    <div style="text-align:center;margin-bottom:24px;">
                        <a href="mailto:horebacademy@manosphone.com"
                           style="display:inline-block;background:#f97316;color:#fff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:12px;">
                            Contacter l'administration →
                        </a>
                    </div>
                    @else
                    <p style="color:#6b7280;font-size:13px;line-height:1.7;margin:0 0 20px 0;">
                        Nous vous encourageons à postuler à nouveau lors de la prochaine session d'inscription. N'hésitez pas à contacter notre administration pour plus d'informations.
                    </p>
                    @endif

                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;">
                        <p style="color:#374151;font-size:12px;font-weight:700;margin:0 0 8px 0;">Contact Administration</p>
                        <p style="color:#6b7280;font-size:13px;margin:0;">📧 horebacademy@manosphone.com</p>
                    </div>
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
