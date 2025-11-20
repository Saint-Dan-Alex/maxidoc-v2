<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 150px;
            height: auto;
        }
        .security-icon {
            text-align: center;
            margin-bottom: 20px;
        }
        .security-icon svg {
            width: 64px;
            height: 64px;
            color: #2563eb;
        }
        h1 {
            color: #1e293b;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }
        .code-container {
            background-color: #f0f4ff;
            border: 2px solid #2563eb;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 2.0rem;
            font-weight: 700;
            letter-spacing: 4px;
            color: #2563eb;
            font-family: 'Courier New', monospace;
        }
        .info-text {
            color: #64748b;
            font-size: 14px;
            line-height: 1.8;
            margin: 20px 0;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning p {
            margin: 0;
            color: #92400e;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 12px;
        }
        .footer img {
            max-width: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="logo">
            <img src="{{ asset('assets/regidoc/logo4.png') }}" alt="MaxiDoc Logo">
        </div>

        <div class="security-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3V6a3 3 0 10-6 0v2c0 1.657 1.343 3 3 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11a7 7 0 0114 0v5a3 3 0 01-3 3H8a3 3 0 01-3-3v-5z" />
            </svg>
        </div>

        <h1>Réinitialisation de votre mot de passe</h1>

        <p class="info-text">
            Bonjour,<br><br>
            Un administrateur a demandé la réinitialisation du mot de passe de votre compte <strong>MaxiDoc</strong>.
            Voici votre <strong>nouveau mot de passe temporaire</strong> :
        </p>

        <div class="code-container">
            <div class="code">{{ $password }}</div>
        </div>

        <p class="info-text">
            Pour des raisons de sécurité, nous vous recommandons fortement de vous connecter dès que possible
            puis de modifier ce mot de passe depuis votre espace utilisateur.
        </p>

        <p class="info-text" style="text-align: center;">
            <a href="{{ url('/login') }}" style="display:inline-block;padding:10px 20px;border-radius:6px;background:#2563eb;color:#ffffff;text-decoration:none;font-weight:600;">
                Se connecter à MaxiDoc
            </a>
        </p>

        <div class="warning">
            <p>
                <strong>⚠️ Attention :</strong> Si vous n'êtes pas à l'origine de cette demande, contactez
                immédiatement votre administrateur ou l'équipe support. Ne partagez jamais votre mot de passe
                avec qui que ce soit.
            </p>
        </div>

        <p class="info-text">
            Pour toute question ou assistance, n'hésitez pas à contacter notre équipe de support.
        </p>

        <div class="footer">
            <img src="{{ asset('assets/regidoc/logo4.png') }}" alt="MaxiDoc">
            <p>© {{ date('Y') }} MaxiDoc. Tous droits réservés.</p>
            <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
