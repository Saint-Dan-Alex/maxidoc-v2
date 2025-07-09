@extends('regidoc.layouts.app')

@section('style')
@endsection

@section('body')
    <div class="global-div">
        <div class="block-login">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-6 pe-0 ps-0 d-none-mobile">
                        <div class="block-bg-app">
                            <div class="before">
                                <img src="{{ asset('assets/images/ads-login-visuel.jpg') }}" alt=""
                                    style="position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: -1">
                            </div>
                            {{-- <img src="{{ asset('assets/images/bg-4.jpg') }}" alt=""> --}}
                            {{-- <div class="block-text">
                                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, voluptas.</h1>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xxl-8 col-xl-9">
                                <div class="card-login">
                                    <div class="logo-lg">
                                        <div class="round"></div>
                                        <div class="round"></div>
                                        <img src="{{ asset('assets/images/logo-phar-icon.png') }}" alt="">
                                    </div>
                                    <h1>Mot de passe oublié ?</h1>
                                    <p class="mb-4">Veuillez saisir votre adresse e-mail pour réinitialiser le mot de
                                        passe de votre compte</p>
                                    <form method="post" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group row g-3">
                                            <div class="col-12 position-relative">

                                                <input type="email" class="form-control form-control-validation"
                                                    placeholder="Addresse email" name="email" required>
                                                <i class="fi fi-rr-at position-absolute icon-form"></i>
                                            </div>
                                            @if (session()->get('session') && json_decode(session()->get('session'))->code == '0')
                                                <div class="col-12">
                                                    <div class="error-message">
                                                        {{ json_decode(session()->pull('session'))->email }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="mt-4 col-12 d-flex">
                                                <button class="btn btn-valid disabled">{{ __('Connexion') }}</button>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="block-copy-allright">
                                        <span> <small>© MaxiDoc</small> <small>{{ now()->format('Y') }}</small></span>
                                    </div>
                                </div>
                                <div class="mt-4 text-center block-copy-allright">
                                    <span> <small>© MaxiDoc</small>
                                        <small>{{ now()->format('Y') }}</small></span>
                                    <br>
                                    <span><small>Delopped by <a href="https://www.newtech-rdc.net/"
                                                style="color: #afafc1" target="_blank">Newtech
                                                consulting</a></small></span>
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
