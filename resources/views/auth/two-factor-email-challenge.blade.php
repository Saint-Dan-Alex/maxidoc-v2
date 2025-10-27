@extends('regidoc.layouts.app')

@section('style')
@endsection

@section('body')
    <div class="global-div">
        <div class="block-login">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 pe-0 ps-0 d-none d-md-block">
                        <div class="block-bg-app">
                            <div class="block-bg-app-content">
                                <div class="block-bg-app-content-titleBox">
                                    <h2 class="block-bg-app-content-titleBox-title"
                                        style="font-family: 'Roboto', 'Roboto-bold', sans-serif;">
                                        Votre gestionnaire de documents <span class="highlight"> intelligents </span>
                                    </h2>
                                    <div class="block-bg-app-content-icon">
                                        <img src="{{ asset('assets/regidoc/logo-white.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="block-bg-app-content-imageBox">
                                    <img id="backgroundImage"
                                        src="{{ asset('assets/images/loginvisuel1.jpg') }}" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xxl-8 col-xl-9 col-md-8 col-sm-8">
                                <img src="{{ asset('assets/regidoc/logo.png') }}" alt=""
                                    class="logo-app d-block d-md-none">
                                <div class="card-login">
                                    <h1>Authentification à deux facteurs</h1>
                                    <p class="mb-4">
                                        Veuillez saisir le code à 6 chiffres envoyé à votre adresse email pour sécuriser votre connexion
                                    </p>
                                    
                                    @if (session('status'))
                                        <div class="alert alert-success mb-3">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('auth.two-factor.verify') }}" id="verify-form">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ session('2fa_email') }}">
                                        
                                        <div class="form-group">
                                            <!-- Champ caché pour stocker le code complet -->
                                            <input type="hidden" id="verification-code" name="code" value="" pattern="[0-9]{6}" required>
                                            
                                            <div class="code-input-container" style="display: flex; justify-content: space-between; gap: 8px; margin-bottom: 15px;">
                                                <!-- 6 champs séparés pour chaque chiffre du code -->
                                                @for ($i = 1; $i <= 6; $i++)
                                                <input type="text" 
                                                    id="code-digit-{{ $i }}" 
                                                    class="form-control code-digit" 
                                                    style="width: calc(16.666% - 6px); text-align: center; font-size: 20px; font-weight: 500; padding: 10px 0;" 
                                                    maxlength="1" 
                                                    pattern="[0-9]" 
                                                    inputmode="numeric" 
                                                    {{ $i == 1 ? 'autofocus' : '' }} 
                                                    autocomplete="one-time-code">
                                                @endfor
                                            </div>
                                            
                                            @error('code')
                                                <div style="display:flex;align-items:center;gap:8px;color:#ef4444;margin-top:8px;padding:4px 0;">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                                        <path d="M12 9v4" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/>
                                                        <path d="M12 16h.01" stroke="#ef4444" stroke-width="2" stroke-linecap="round"/>
                                                        <path d="M12 21a9 9 0 100-18 9 9 0 000 18z" stroke="#ef4444" stroke-width="2"/>
                                                    </svg>
                                                    <span>{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mt-4 col-12 d-flex">
                                            <button type="submit" class="btn btn-valid" id="verify-btn" disabled>
                                                <span id="verify-text">Vérifier</span>
                                            </button>
                                        </div>
                                    </form>
                                    
                                    <div class="mt-3 text-center">
                                        <p>Vous n'avez pas reçu de code ? <a href="{{ route('auth.two-factor.resend') }}">Renvoyer</a></p>
                                    </div>
                                    
                                    <div class="mt-4 text-center block-copy-allright" style="display:flex;flex-direction:column;align-items:center;gap:4px;">
                                        <div style="display:flex;align-items:center;justify-content:center;gap:7px;font-size:15px;color:#334155;font-weight:500;">
                                            <img src="{{ asset('assets/regidoc/logo5.png') }}" alt="MaxiDoc logo" style="height:18px;width:auto;object-fit:contain;display:inline-block;vertical-align:middle;">
                                            <span> MaxiDoc {{ now()->format('Y') }}</span>
                                        </div>
                                        <div style="font-size:13px;color:#8b98b7;">
                                            Developed by <a href="https://www.newtech-rdc.net/" style="color:#2563eb;text-decoration:none;font-weight:500;" target="_blank">Newtech consulting</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les éléments du DOM
        const digitInputs = document.querySelectorAll('.code-digit');
        const verificationCodeInput = document.getElementById('verification-code');
        const form = document.getElementById('verify-form');
        const btn = document.getElementById('verify-btn');

        // Fonction pour mettre à jour le champ caché avec le code complet
        function updateVerificationCode() {
            let code = '';
            digitInputs.forEach(input => {
                code += input.value || '';
            });
            verificationCodeInput.value = code;
            
            // Activer/désactiver le bouton selon que le code est complet ou non
            if (code.length === 6 && /^[0-9]{6}$/.test(code)) {
                btn.disabled = false;
                btn.classList.add('active');
            } else {
                btn.disabled = true;
                btn.classList.remove('active');
            }
        }

        // Configuration des champs de saisie du code
        digitInputs.forEach((input, index) => {
            // Permettre uniquement les chiffres
            input.addEventListener('keypress', function(e) {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });

            // Gérer la saisie dans chaque champ
            input.addEventListener('input', function(e) {
                // Si un caractère est saisi, passer au champ suivant
                if (e.target.value.length === 1) {
                    if (index < digitInputs.length - 1) {
                        digitInputs[index + 1].focus();
                    }
                }
                updateVerificationCode();
            });

            // Gérer la navigation avec les touches du clavier
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && e.target.value === '') {
                    // Si touche Backspace et champ vide, revenir au champ précédent
                    if (index > 0) {
                        digitInputs[index - 1].focus();
                        e.preventDefault();
                    }
                } else if (e.key === 'ArrowLeft') {
                    // Touche flèche gauche, aller au champ précédent
                    if (index > 0) {
                        digitInputs[index - 1].focus();
                        e.preventDefault();
                    }
                } else if (e.key === 'ArrowRight') {
                    // Touche flèche droite, aller au champ suivant
                    if (index < digitInputs.length - 1) {
                        digitInputs[index + 1].focus();
                        e.preventDefault();
                    }
                }
            });

            // Gérer le collage du code complet
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pasteData = (e.clipboardData || window.clipboardData).getData('text');
                
                // Vérifier si les données collées sont un code à 6 chiffres
                if (/^\d{6}$/.test(pasteData)) {
                    // Remplir tous les champs avec les chiffres correspondants
                    for (let i = 0; i < digitInputs.length; i++) {
                        if (i < pasteData.length) {
                            digitInputs[i].value = pasteData[i];
                        }
                    }
                    // Mettre à jour le champ caché et activer le bouton
                    updateVerificationCode();
                }
            });
        });

        // Gérer la soumission du formulaire
        if(form && btn) {
            // Vérifier que le code est complet avant la soumission
            form.addEventListener('submit', function(e) {
                const code = verificationCodeInput.value;
                if (code.length !== 6 || !/^[0-9]{6}$/.test(code)) {
                    e.preventDefault();
                    return false;
                }
                
                // Désactiver le bouton pendant la soumission
                btn.disabled = true;
                return true;
            });
        }

        // Focus automatique sur le premier champ au chargement
        if (digitInputs.length > 0) {
            setTimeout(() => {
                digitInputs[0].focus();
            }, 100);
        }
    });
</script>
@endsection
