@extends('layouts.app')

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
                                <img src="{{ asset('assets/images/pill.png') }}" alt="logo de ADS" class="logo-pill">
                                <img src="{{ asset('assets/images/pill.png') }}" alt="logo de ADS" class="logo-pill">
                                <img src="{{ asset('assets/images/logo-white.png') }}" alt="logo de ADS" class="logo-center">
                                <h1>Bienvenue sur ADS ERP</h1>
                                <p>Votre logiciel de gestion intélligent</p>
                            </div>
                            {{-- <img src="{{ asset('assets/images/bg-4.jpg') }}" alt=""> --}}
                            {{-- <div class="block-text">
                                <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Optio, voluptas.</h1>
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-md-8 col-sm-8">
                                <div class="card-login">
                                    <div class="logo-lg">
                                        <div class="round"></div>
                                        <div class="round"></div>
                                        <img src="{{ asset('assets/images/logo-phar-icon.png') }}" alt="">

                                    </div>
                                    <h1>Validation</h1>
                                    <p class="mb-4">Veuillez saisir le code à quatre chiffres que vous avez réçu via le compte e-mail : <span style="color: var(--primaryColor); display: inline-block;font-weight: 600">{{ $email }}</span></p>
                                    <form method="post" action="{{ route('auth.verification.code') }}">
                                        @csrf
                                        <div class="form-group row g-3">
                                            <div class="col-12">
                                                <label for="password">Code de validation</label>
                                            </div>
                                            <div class="col-12 position-relative d-flex w-100">
                                                <input type="hidden" class="form-control text-center p-0 form-control-validation me-2" name="email" value="{{ $email }}" placeholder="-" maxlength="1" onkeypress="isInputNumber(event)" style="width: calc(100% / 4)">
                                                <input type="text" class="form-control text-center p-0 form-control-validation me-2" name="code1" placeholder="-" maxlength="1" onkeypress="isInputNumber(event)" style="width: calc(100% / 4)">
                                                <input type="text" class="form-control text-center p-0 form-control-validation me-2" name="code2" placeholder="-" maxlength="1" onkeypress="isInputNumber(event)" style="width: calc(100% / 4)">
                                                <input type="text" class="form-control text-center p-0 form-control-validation me-2" name="code3" placeholder="-" maxlength="1" onkeypress="isInputNumber(event)" style="width: calc(100% / 4)">
                                                <input type="text" class="form-control text-center p-0 form-control-validation" name="code4" placeholder="-" maxlength="1" onkeypress="isInputNumber(event)" style="width: calc(100% / 4)">
                                            </div>
                                            @if ((session()->get('session') && json_decode(session()->get('session'))->message != ''))
                                                <div class="col-12">
                                                    <div class="error-message">
                                                        {{ json_decode(session()->pull('session'))->message }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-12 d-flex mt-4">
                                                <button class="btn btn-valid disabled">{{ __('Connexion') }}</button>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="block-copy-allright">
                                        <span> <small>© MaxiDoc</small> <small>{{ now()->format('Y') }}</small></span>
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
    function isInputNumber(evt) {
    var inputValid = String.fromCharCode(evt.which);

    if (!(/[0-9]/.test(inputValid))) {
        evt.preventDefault();
    }
}
document.querySelectorAll('.form-control-validation').forEach(function (element) {
        element.addEventListener('keyup', function (evt) {
            if (element.nextElementSibling != null && this.value != "") {
                this.nextElementSibling.focus();
            }
        });
    element.addEventListener('focus', function (evt) {
        // console.log(element.previousElementSibling.value != '');
        if (element.previousElementSibling != null && element.previousElementSibling.value == '') {
            this.previousElementSibling.focus();
        }
    });
});

$(".form-control-validation").each((i, element) => {
    var value = '';
    $(element).on('keyup', function() {
        if (element.nextElementSibling != null || $(element).val() == '') {
            $('.btn-valid').addClass('disabled');
        } else {
            $('.btn-valid').removeClass('disabled');
        }
    });

});
</script>
@endsection
