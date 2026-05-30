<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos identifiants — HOREB ACADEMY</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
    <tr><td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

            <tr>
                <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 60%,#1a56db 100%);padding:32px 40px;text-align:center;">
                    <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" style="height:56px;width:auto;display:block;margin:0 auto 12px;">
                    <p style="color:rgba(191,219,254,0.8);font-size:13px;margin:0;font-weight:600;letter-spacing:0.05em;">ACCÈS ESPACE ÉTUDIANT</p>
                </td>
            </tr>

            <tr>
                <td style="padding:32px 40px 0;text-align:center;">
                    <div style="display:inline-block;background:#f0fdf4;border:2px solid #bbf7d0;border-radius:50%;width:72px;height:72px;line-height:72px;text-align:center;margin-bottom:20px;">
                        <span style="font-size:36px;">🎓</span>
                    </div>
                    <h1 style="color:#111827;font-size:22px;font-weight:900;margin:0 0 8px 0;">Bienvenue à HOREB ACADEMY !</h1>
                    <p style="color:#6b7280;font-size:14px;margin:0;">{{ $user->name }}</p>
                </td>
            </tr>

            <tr>
                <td style="padding:28px 40px;">
                    <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px 0;">
                        Votre inscription est désormais confirmée. Voici vos identifiants pour accéder à votre espace étudiant.
                    </p>

                    <div style="background:#f0f7ff;border:2px solid #bfdbfe;border-radius:12px;padding:24px;margin-bottom:24px;">
                        <p style="color:#1e40af;font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;margin:0 0 16px 0;">Vos identifiants de connexion</p>
                        <table width="100%" cellpadding="8" cellspacing="0">
                            <tr>
                                <td style="color:#6b7280;font-size:13px;width:35%;">Identifiant (Email)</td>
                                <td style="color:#1a56db;font-size:13px;font-weight:700;font-family:'Courier New',monospace;">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td style="color:#6b7280;font-size:13px;">Mot de passe temporaire</td>
                                <td style="color:#1a56db;font-size:13px;font-weight:700;font-family:'Courier New',monospace;background:#fff;border-radius:6px;padding:6px 10px;">{{ $plainPassword }}</td>
                            </tr>
                        </table>
                    </div>

                    <div style="background:#fff7ed;border:1px solid #fed7aa;border-radius:8px;padding:12px 16px;margin-bottom:24px;">
                        <p style="color:#92400e;font-size:12px;margin:0;">⚠️ <strong>Important :</strong> Vous devrez changer ce mot de passe lors de votre première connexion.</p>
                    </div>

                    <div style="text-align:center;margin-bottom:24px;">
                        <a href="{{ route('login') }}"
                           style="display:inline-block;background:#1a56db;color:#fff;font-size:14px;font-weight:700;text-decoration:none;padding:14px 32px;border-radius:12px;">
                            Accéder à mon espace étudiant →
                        </a>
                    </div>
                </td>
            </tr>

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
