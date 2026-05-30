<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau dossier — HOREB ACADEMY</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

            {{-- Header --}}
            <tr>
                <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 60%,#1a56db 100%);padding:28px 40px;text-align:center;">
                    <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" style="height:48px;width:auto;display:block;margin:0 auto 10px;">
                    <p style="color:rgba(191,219,254,0.8);font-size:12px;margin:0;font-weight:600;letter-spacing:0.05em;">NOTIFICATION ADMINISTRATION</p>
                </td>
            </tr>

            {{-- Alert banner --}}
            <tr>
                <td style="background:#f0f7ff;border-bottom:2px solid #bfdbfe;padding:16px 40px;">
                    <p style="color:#1e40af;font-size:14px;font-weight:700;margin:0;">
                        🔔 Un nouveau dossier de pré-inscription vient d'être soumis.
                    </p>
                </td>
            </tr>

            {{-- Body --}}
            <tr>
                <td style="padding:28px 40px;">

                    {{-- Infos étudiant --}}
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:20px;">
                        <p style="color:#374151;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 14px 0;">Informations de l'étudiant</p>
                        <table width="100%" cellpadding="5" cellspacing="0">
                            <tr>
                                <td style="color:#6b7280;font-size:13px;width:38%;">Nom complet</td>
                                <td style="color:#111827;font-size:13px;font-weight:700;">{{ $inscription->etudiant->full_name }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Email</td>
                                <td style="color:#1a56db;font-size:13px;font-weight:600;">{{ $inscription->etudiant->email_personnel }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Téléphone</td>
                                <td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->etudiant->telephone }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Nationalité</td>
                                <td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->etudiant->nationalite }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- Infos inscription --}}
                    <div style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:24px;">
                        <p style="color:#374151;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 14px 0;">Détails de la candidature</p>
                        <table width="100%" cellpadding="5" cellspacing="0">
                            <tr>
                                <td style="color:#6b7280;font-size:13px;width:38%;">Filière</td>
                                <td style="color:#111827;font-size:13px;font-weight:700;">{{ $inscription->filiere->nom }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Niveau</td>
                                <td style="color:#1a56db;font-size:14px;font-weight:700;">{{ $inscription->niveau }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Année académique</td>
                                <td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->annee_academique }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Soumis le</td>
                                <td style="color:#111827;font-size:13px;font-weight:600;">{{ $inscription->created_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- CTA --}}
                    <div style="text-align:center;">
                        <a href="{{ route('academique.inscriptions.show', $inscription) }}"
                           style="display:inline-block;background:#1a56db;color:#fff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:12px;">
                            Examiner le dossier →
                        </a>
                    </div>
                </td>
            </tr>

            {{-- Footer --}}
            <tr>
                <td style="background:#f9fafb;border-top:1px solid #f3f4f6;padding:16px 40px;text-align:center;">
                    <p style="color:#9ca3af;font-size:11px;margin:0;">Cet email est envoyé automatiquement par le système HOREB ACADEMY.</p>
                </td>
            </tr>

        </table>
    </td></tr>
</table>
</body>
</html>
