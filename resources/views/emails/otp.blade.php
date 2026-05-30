<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification — HOREB ACADEMY</title>
</head>
<body style="margin:0;padding:0;background:#f8fafc;font-family:'Inter',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 60%,#1a56db 100%);padding:32px 40px;text-align:center;">
                        <img src="{{ asset('images/logo.png') }}" alt="HOREB Academy" style="height:56px;width:auto;margin-bottom:12px;display:block;margin-left:auto;margin-right:auto;">
                        <p style="color:rgba(191,219,254,0.8);font-size:13px;margin:0;font-weight:500;letter-spacing:0.05em;">VÉRIFICATION D'ADRESSE EMAIL</p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:40px;">
                        <p style="color:#374151;font-size:15px;margin:0 0 8px 0;">Bonjour,</p>
                        <p style="color:#6b7280;font-size:14px;line-height:1.6;margin:0 0 32px 0;">
                            Vous avez demandé à vous inscrire à <strong style="color:#111827;">HOREB ACADEMY</strong> avec l'adresse <strong style="color:#1a56db;">{{ $email }}</strong>.<br>
                            Veuillez utiliser le code ci-dessous pour confirmer votre adresse email.
                        </p>

                        {{-- OTP Code --}}
                        <div style="background:#f0f7ff;border:2px solid #bfdbfe;border-radius:12px;padding:28px;text-align:center;margin-bottom:32px;">
                            <p style="color:#6b7280;font-size:12px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;margin:0 0 12px 0;">Votre code de vérification</p>
                            <p style="color:#1a56db;font-size:48px;font-weight:900;letter-spacing:0.2em;margin:0;font-family:'Courier New',monospace;">{{ $code }}</p>
                            <p style="color:#9ca3af;font-size:12px;margin:12px 0 0 0;">Ce code expire dans <strong>10 minutes</strong></p>
                        </div>

                        <p style="color:#6b7280;font-size:13px;line-height:1.6;margin:0 0 16px 0;">
                            Si vous n'avez pas demandé cette vérification, ignorez cet email. Votre adresse email ne sera pas utilisée.
                        </p>

                        <div style="background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:12px 16px;">
                            <p style="color:#92400e;font-size:12px;margin:0;">
                                ⚠️ Ne partagez jamais ce code avec quelqu'un. HOREB ACADEMY ne vous demandera jamais votre code par téléphone ou email.
                            </p>
                        </div>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f9fafb;border-top:1px solid #f3f4f6;padding:24px 40px;text-align:center;">
                        <p style="color:#9ca3af;font-size:12px;margin:0;">© {{ date('Y') }} HOREB ACADEMY — Tous droits réservés</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
