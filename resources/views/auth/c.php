<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentification à deux facteurs - {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- CSS principal -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
    
    <style>
        .code-input-container {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 15px;
        }
        
        .code-digit {
            width: calc(16.666% - 6px);
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            padding: 10px 0;
        }
        
        .error-message {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ef4444;
            margin-top: 8px;
            padding: 4px 0;
        }
        
        #verify-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        #verify-btn.active {
            opacity: 1;
            cursor: pointer;
        }
        
        #verify-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        #verify-spinner {
            display: none;
        }
        
        .block-copy-allright {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
    </style>
</head>
<body>
    <div class="global-div">
        <div class="block-login">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-8 col-sm-10">
                        <div class="card-login">
                            <!-- Logo -->
                            <div class="logo-app">
                                <img src="{{ asset('assets/regidoc/logo4.png') }}" alt="MaxiDoc Logo">
                            </div>

                            <!-- Titre -->
                            <h1 class="text-center">Authentification à deux facteurs</h1>
                            <p class="text-center mb-4">
                                Un code de vérification a été envoyé à votre adresse email. 
                                Veuillez le saisir ci-dessous pour continuer.
                            </p>

                            <!-- Messages de succès -->
                            @if (session('status'))
                                <div class="alert alert-success mb-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <!-- Formulaire -->
                            <form method="POST" action="{{ route('auth.two-factor.verify') }}" id="verify-form">
                                @csrf
                                
                                <!-- Email caché -->
                                <input type="hidden" name="email" value="{{ session('2fa_email') }}">
                                
                                <!-- Code caché (sera rempli par JS) -->
                                <input type="hidden" id="verification-code" name="code">

                                <!-- Champs pour le code à 6 chiffres -->
                                <div class="code-input-container">
                                    <input type="text" class="form-control code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="0">
                                    <input type="text" class="form-control code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="1">
                                    <input type="text" class="form-control code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="2">
                                    <input type="text" class="form-control code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="3">
                                    <input type="text" class="form-control code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="4">
                                    <input type="text" class="form-control code-digit" maxlength="1" pattern="\d" inputmode="numeric" autocomplete="off" data-index="5">
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

                                <!-- Bouton de vérification -->
                                <button type="submit" class="btn btn-valid w-100 mt-3" id="verify-btn" disabled>
                                    <span id="verify-text">Vérifier</span>
                                    <span id="verify-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </button>

                                <!-- Lien pour renvoyer le code -->
                                <div class="text-center mt-3">
                                    <a href="{{ route('auth.two-factor.resend') }}" class="text-decoration-none">
                                        Vous n'avez pas reçu le code ? Renvoyer
                                    </a>
                                </div>
                            </form>

                            <!-- Footer -->
                            <div class="block-copy-allright">
                                <img src="{{ asset('assets/regidoc/logo5.png') }}" alt="MaxiDoc" style="width: 60px;">
                                <p>© {{ date('Y') }} MaxiDoc. Tous droits réservés.</p>
                            </div>
                        </div>
                    </div>
                </div>
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
