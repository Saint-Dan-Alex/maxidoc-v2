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
                                <img src="{{ asset('assets/images/loginvisuel4.jpg') }}" alt=""
                                    style="position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: -1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xxl-8 col-xl-9">
                                <div class="card-login">
                                    <div class="logo-lg">
                                        {{-- <div class="round"></div>
                                        <div class="round"></div> --}}
                                        {{-- <img src="{{ asset('assets/regidoc/logo.png') }}" alt="" class="img-fluid"> --}}
                                    </div>
                                    <h1>{{ __('Update Password') }}</h1>
                                    <p class="mb-4">
                                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                    </p>
                                    @livewire('auth.update-password-form')
                                    {{-- <form method="post" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group row g-3">
                                            <div class="col-12 position-relative">

                                                <input type="email" class="form-control form-control-validation" placeholder="Addresse email" name="email" required>
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
                                    </form> --}}
                                    {{-- <div class="block-copy-allright">
                                        <span> <small>© MaxiDoc</small> <small>{{ now()->format('Y') }}</small></span>
                                    </div> --}}
                                </div>
                                <div class="mt-4 text-center block-copy-allright">
                                    <span style="font-size: 12px;"> <small>© MaxiDoc</small>
                                        <small>{{ now()->format('Y') }}</small></span>
                                    <span style="font-size: 12px;"><small>By <a href="https://www.newtech-rdc.net/"
                                                style="color: #afafc1" target="_blank">Newtech
                                                consulting</a></small>
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
        const btnShowPassword = document.querySelectorAll('.show-password');
        btnShowPassword.forEach(btnClick => {
            $(btnClick).click(function() {
                $(this).toggleClass('show');
                const inputPassword = $(this).parent().find('.input-password');
                if ($(inputPassword).attr('type') == 'password') {
                    $(inputPassword).attr('type', 'text')
                } else {
                    $(inputPassword).attr('type', 'password')
                }

            })
        });
    </script>
@endsection
