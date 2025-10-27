<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentification à deux facteurs - {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .auth-container {
            display: flex;
            height: 100vh;
        }

        /* Colonne gauche avec image */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), 
                        url('{{ asset('assets/images/loginvisuel1.jpg') }}') center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px;
            color: white;
            position: relative;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(13, 71, 161, 0.8), rgba(25, 118, 210, 0.6));
            z-index: 1;
        }

        .left-content {
            position: relative;
            z-index: 2;
        }

        .left-panel h1 {
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .left-panel .subtitle {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .logo-bottom {
            position: absolute;
            bottom: 40px;
            right: 40px;
            z-index: 2;
        }

        .logo-bottom img {
            height: 40px;
            filter: brightness(0) invert(1);
        }

        /* Colonne droite avec formulaire */
        .right-panel {
            flex: 1;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-container {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 50px 40px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        .form-container h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
        }

        .form-container .description {
            color: #666;
            font-size: 14px;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .code-input-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 30px;
        }

        .code-digit {
            width: 60px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .code-digit:focus {
            outline: none;
            border-color: #1976d2;
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
        }

        .btn-verify {
            width: 100%;
            padding: 14px;
            background: #1976d2;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-verify:hover:not(:disabled) {
            background: #1565c0;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
        }

        .btn-verify:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .resend-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .resend-link a {
            color: #1976d2;
            text-decoration: none;
            font-weight: 500;
        }

        .resend-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #d32f2f;
            font-size: 14px;
            margin-top: -20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 992px) {
            .left-panel {
                display: none;
            }
            
            .right-panel {
                flex: 1;
            }
        }

        @media (max-width: 576px) {
            .code-digit {
                width: 45px;
                height: 45px;
                font-size: 20px;
            }

            .form-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Colonne gauche -->
        <div class="left-panel">
            <div class="left-content">
                <h1>Votre gestionnaire<br>de documents</h1>
                <div class="subtitle">intelligents</div>
            </div>
            <div class="logo-bottom">
                <img src="{{ asset('assets/regidoc/logo4.png') }}" alt="MaxiDoc">
            </div>
        </div>

        <!-- Colonne droite -->
        <div class="right-panel">
            <div class="form-container">
                <h2>Authentification à deux facteurs</h2>
                <p class="description">
                    Veuillez saisir le code à 6 chiffres envoyé à votre adresse email pour sécuriser votre connexion
                </p>

                <!-- Messages de succès -->
                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Formulaire -->
                <form method="POST" action="{{ route('auth.two-factor.verify') }}" id="verify-form">
                    @csrf
                    
                    <input type="hidden" name="email" value="{{ session('2fa_email') }}">
                    <input type="hidden" id="verification-code" name="code">

                    <!-- Champs pour le code -->
                    <div class="code-input-container">
                        <input type="text" class="code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="0">
                        <input type="text" class="code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="1">
                        <input type="text" class="code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="2">
                        <input type="text" class="code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="3">
                        <input type="text" class="code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="4">
                        <input type="text" class="code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="5">
                    </div>

                    <!-- Messages d'erreur -->
                    @error('code')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    @error('email')
                        <div class="error-message">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <!-- Bouton -->
                    <button type="submit" class="btn-verify" id="verify-btn" disabled>
                        Vérifier
                    </button>

                    <!-- Lien renvoyer -->
                    <div class="resend-link">
                        Vous n'avez pas reçu de code ? <a href="{{ route('auth.two-factor.resend') }}">Renvoyer</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Script pour la gestion des champs de code -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const codeInputs = document.querySelectorAll('.code-digit');
            const verificationCodeInput = document.getElementById('verification-code');
            const verifyBtn = document.getElementById('verify-btn');
            const verifyForm = document.getElementById('verify-form');
            const verifyText = document.getElementById('verify-text');
            const verifySpinner = document.getElementById('verify-spinner');

            // Focus sur le premier champ au chargement
            codeInputs[0].focus();

            // Fonction pour vérifier si tous les champs sont remplis
            function checkAllFilled() {
                const allFilled = Array.from(codeInputs).every(input => input.value.length === 1);
                verifyBtn.disabled = !allFilled;
                
                if (allFilled) {
                    verifyBtn.classList.add('active');
                    // Remplir le champ caché avec le code complet
                    verificationCodeInput.value = Array.from(codeInputs).map(input => input.value).join('');
                } else {
                    verifyBtn.classList.remove('active');
                }
            }

            // Gérer la saisie dans chaque champ
            codeInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Accepter uniquement les chiffres
                    if (!/^\d$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Passer au champ suivant si rempli
                    if (value.length === 1 && index < codeInputs.length - 1) {
                        codeInputs[index + 1].focus();
                    }
                    
                    checkAllFilled();
                });

                // Gérer la touche Backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        codeInputs[index - 1].focus();
                    }
                });

                // Gérer le copier-coller
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').trim();
                    
                    if (/^\d{6}$/.test(pastedData)) {
                        pastedData.split('').forEach((char, i) => {
                            if (codeInputs[i]) {
                                codeInputs[i].value = char;
                            }
                        });
                        codeInputs[5].focus();
                        checkAllFilled();
                    }
                });
            });

            // Gérer la soumission du formulaire
            verifyForm.addEventListener('submit', function() {
                verifyBtn.disabled = true;
                verifyText.style.display = 'none';
                verifySpinner.style.display = 'inline-block';
            });
        });
    </script>
</body>
</html>
