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
                                        @php
                                            $content = [
                                                [
                                                    'text' =>
                                                        'Votre gestionnaire de documents <span class="highlight"> intelligents </span>',
                                                    'image' => '/loginvisuel1.jpg',
                                                ],
                                                [
                                                    'text' =>
                                                        'Suivez à la <span class="highlight"> loupe </span> chaque courier qui circule dans votre organisation',
                                                    'image' => '/loginvisuel2.jpg',
                                                ],
                                                [
                                                    'text' =>
                                                        'Pour une gestion <span class="highlight"> de couriers simplifiées</span> et maitrisée',
                                                    'image' => '/loginvisuel3.jpg',
                                                ],
                                                [
                                                    'text' =>
                                                        'Profitez d\'un <span class="highlight">point d\'entrée unique</span> pour tout vos couriers',
                                                    'image' => '/loginvisuel4.jpg',
                                                ],
                                                [
                                                    'text' =>
                                                        'Un outil <span class="highlight">complet</span> pour toutes vos correspondances',
                                                    'image' => '/loginvisuel5.jpg',
                                                ],
                                            ];
                                            $selectedContent = $content[rand(0, count($content) - 1)];
                                        @endphp

                                        {!! $selectedContent['text'] !!}
                                    </h2>
                                    <div class="block-bg-app-content-icon">
                                        <img src="{{ asset('assets/regidoc/logo-white.png') }}" alt="">
                                    </div>
                                </div>

                                <div class="block-bg-app-content-imageBox">
                                    <img id="backgroundImage"
                                        src="{{ asset('assets/images/' . $selectedContent['image']) }}" alt="" />
                                </div>

                            </div>



                            {{-- <div class="before" style="z-index: 1">
                                @php
                                    $images = [
                                        '/loginvisuel.jpg',
                                        '/loginvisuel1.jpg',
                                        '/loginvisuel2.jpg',
                                        '/loginvisuel3.jpg',
                                        '/loginvisuel4.jpg',
                                        '/loginvisuel5.jpg',
                                    ];
                                @endphp
                                <img id="backgroundImage"
                                    src="{{ asset('assets/images/' . $images[rand(0, count($images) - 1)]) }}" alt=""
                                    style="position: absolute; width: 100%; height: 100%; object-fit: cover; z-index: -1">
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xxl-8 col-xl-9 col-md-8 col-sm-8">
                                <img src="{{ asset('assets/regidoc/logo.png') }}" alt=""
                                    class="logo-app d-block d-md-none">
                                <div class="card-login">
                                    <h1>Connexion</h1>
                                    <p class="mb-4">
                                        Veuillez saisir vos informations d'identification pour vous connecter
                                    </p>
                                    <div class="col-12">
                                        <x-jet-input-error for="email" class="mb-3 message-input" />
                                    </div>
                                    <form method="POST" action="{{ route('login') }}" id="form-login">
                                        @csrf
                                        <div class="form-group row g-3 g-lg-4 align-items-center">
                                            <div class="col-12 position-relative">
                                                <input type="email"
                                                    class="form-control form-control-validation {{ session()->get('session') && json_decode(session()->get('session'))->code == '0' ? 'form-error' : '' }}"
                                                    placeholder="Adresse e-mail" name="email">
                                                <i class="fi fi-rr-at position-absolute icon-form"></i>
                                            </div>
                                            @if (session()->get('session') && json_decode(session()->get('session'))->code == '0')
                                                <div class="col-12">
                                                    <div class="error-message">
                                                        {{ json_decode(session()->pull('session'))->email }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-12 position-relative">
                                                <input type="password"
                                                    class="form-control form-control-validation input-password {{ session()->get('session') && json_decode(session()->get('session'))->code == '1' ? 'form-error' : '' }}"
                                                    placeholder="Mot de passe" name="password" id="input-password">
                                                <i class="fi fi-rr-lock-alt position-absolute icon-form"></i>
                                                <div class="btn-show-password show-password" id="show-password">
                                                    <div>
                                                        <i class="fi fi-rr-eye"></i>
                                                        <i class="fi fi-rr-eye-crossed"></i>
                                                    </div>
                                                    <div class="tooltip-team">
                                                        <span>Voir</span>
                                                        <span>Cacher</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (session()->get('session') && json_decode(session()->get('session'))->code == '2')
                                                <div class="col-12">
                                                    <div class="error-message">
                                                        {{ json_decode(session()->pull('session'))->password }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-4 col-12 d-flex justify-content-center">
                                                <button class="btn btn-valid btn-valid-form d-flex align-items-center justify-content-center">
                                                    <span class="text">
                                                        {{ __('Connexion') }}
                                                    </span>
                                                    <span
                                                        class="spinner-border spinner-border-white text-success d-none btn-loader"
                                                        role="status"
                                                        style="font-size: 10px !important; width:18px;height:18px">
                                                        <span class="sr-only"></span>
                                                    </span>
                                                </button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                                <div
                                    class="mt-4 block-copy-allright d-flex align-items-center gap-1 justify-content-center">
                                    <span>
                                        <small style="font-size: 12px">MaxiDoc&trade; By</small>
                                        {{-- <small>{{ now()->format('Y') }}</small> --}}
                                    </span>
                                    <span class="d-flex align-items-center gap-1">
                                        <a href="https://regideso.cd/" style="color: #afafc1" target="_blank">
                                            <img src="{{ asset('assets/regidoc/logo2.png') }}" alt="Logo regideso">
                                            <img src="{{ asset('assets/regidoc/white.png') }}" alt="Logo regideso">
                                        </a>
                                        </small>
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

        // Fonction aleatoire background
        // async function aleaImageBackgroud(tableauImages) {
        //     const tableauMelange = [...tableauImages];
        //     let indexPrecedent = -1;

        //     while (true) {
        //         for (let i = tableauMelange.length - 1; i > 0; i--) {
        //             const j = Math.floor(Math.random() * (i + 1));
        //             [tableauMelange[i], tableauMelange[j]] = [tableauMelange[j], tableauMelange[i]];
        //         }

        //         for (const imageNom of tableauMelange) {
        //             if (imageNom !== tableauImages[indexPrecedent]) {
        //                 const imgElement = document.getElementById("backgroundImage");
        //                 imgElement.src = "{{ asset('assets/images/') }}" + imageNom;

        //                 const tempsAleatoire = Math.floor(Math.random() * (20000 - 8000 + 1)) + 8000;
        //                 await new Promise(resolve => setTimeout(resolve, tempsAleatoire));

        //                 indexPrecedent = tableauImages.indexOf(imageNom);
        //             }
        //         }
        //     }
        // }

        // const tableauImages = ["/loginvisuel.jpg", "/loginvisuel1.jpg", "/loginvisuel2.jpg", "/loginvisuel3.jpg",
        //     "/loginvisuel4.jpg", "/loginvisuel5.jpg"
        // ];
        // aleaImageBackgroud(tableauImages);
    </script>
@endsection
