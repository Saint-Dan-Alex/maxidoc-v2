<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de confirmation eSignature</title>
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
        .icon {
            text-align: center;
            margin-bottom: 20px;
        }
        .icon svg {
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
            font-size: 2.6rem;
            font-weight: 700;
            letter-spacing: 8px;
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

        <div class="icon">
            <!-- Stylo / Signature icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M13.25 4.51l6.24 6.24-7.9 7.9c-.32.33-.73.57-1.18.69l-4.18 1.12a1 1 0 0 1-1.22-1.22l1.12-4.18c.12-.45.36-.86.69-1.18l7.9-7.9Zm1.41-1.41 1.06-1.06a2.75 2.75 0 1 1 3.89 3.89l-1.06 1.06-3.89-3.89Z"/>
            </svg>
        </div>

        <h1>Code de confirmation eSignature</h1>

        <p class="info-text">
            Bonjour,<br><br>
            Vous êtes sur le point de signer un document depuis votre profil utilisateur <strong>MaxiDoc eSignature</strong>.<br>
            Pour des raisons de sécurité, veuillez utiliser le code ci-dessous pour confirmer votre signature :
        </p>

        <div class="code-container">
            <div class="code">{{ $password }}</div>
        </div>

        <p class="info-text" style="text-align: center;">
            <strong>Ce code est valable pour finaliser votre signature.</strong>
        </p>

        <div class="warning">
            <p>
                <strong>⚠️ Attention :</strong> Si vous n'êtes pas à l'origine de cette demande, veuillez ignorer cet email et contacter immédiatement l'administrateur de votre compte.
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
