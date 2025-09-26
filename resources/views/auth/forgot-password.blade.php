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
                                    <h2 class="block-bg-app-content-titleBox-title" style="font-family: 'Roboto', 'Roboto-bold', sans-serif;">
                                        Votre gestionnaire de documents <span class="highlight">intelligents</span>
                                    </h2>
                                    <div class="block-bg-app-content-icon">
                                        <img src="{{ asset('assets/regidoc/logo-white.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="block-bg-app-content-imageBox">
                                    <img id="backgroundImage" src="{{ asset('assets/images/loginvisuel1.jpg') }}" alt="" />
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
                                    <h1>Mot de passe oublié ?</h1>
                                    <p class="mb-4">
                                        Veuillez saisir votre adresse e-mail pour réinitialiser votre mot de passe.
                                    </p>
                                    
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group row g-3 g-lg-4 align-items-center">
                                            <div class="col-12 position-relative">
                                                <input type="email" 
                                                    class="form-control form-control-validation {{ $errors->has('email') ? 'form-error' : '' }}"
                                                    placeholder="Adresse e-mail" 
                                                    name="email" 
                                                    value="{{ old('email') }}"
                                                    required 
                                                    autofocus>
                                                <i class="fi fi-rr-at position-absolute icon-form"></i>
                                            </div>
                                            
                                            @error('email')
                                                <div class="col-12">
                                                    <div class="error-message">
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                            @enderror

                                            <div class="mt-4 col-12 d-flex justify-content-center">
                                                <button type="submit" class="btn btn-valid btn-valid-form d-flex align-items-center justify-content-center">
                                                    <span class="text">
                                                        {{ __('Réinitialiser le mot de passe') }}
                                                    </span>
                                                    <span
                                                        class="spinner-border spinner-border-white text-success d-none btn-loader"
                                                        role="status"
                                                        style="font-size: 10px !important; width:18px;height:18px">
                                                        <span class="sr-only"></span>
                                                    </span>
                                                </button>
                                            </div>

                                            <div class="col-12 text-center mt-3">
                                                <a href="{{ route('login') }}" class="text-primary" style="font-size: 0.875rem; text-decoration: none;">
                                                    <i class="fi fi-rr-arrow-left me-1"></i> Retour à la page de connexion
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-4 block-copy-allright d-flex align-items-center gap-1 justify-content-center">
                                    <span>
                                        <small style="font-size: 12px">MaxiDoc&trade; By</small>
                                        <img src="{{ asset('assets/images/logo-newtech-white.png') }}" alt="" width="70">
                                    </span>
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
        $(".form-control-validation").each((i, element) => {
            var value = '';
            $(element).on('keyup', function() {
                if ($(element).val() == '') {
                    $('.btn-valid').addClass('disabled');
                } else {
                    $('.btn-valid').removeClass('disabled');
                }
            });

        });
    </script>
@endsection
