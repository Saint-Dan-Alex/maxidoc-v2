<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<!--
    # Project developed by Newtech Consulting SARL
    # Contact : Tél: +(243) 977 776 901
                Email: contact@newtech-rdc.net
                Adresse: 374 avenue Colonel Mondjiba C/Ngaliema, Q/Basoko, Réf/Galerie St.Pierre
                Kinshasa - RDC
-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MaxiDoc | Gestion électronique des courriers</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logos/logo-ads1.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.js"></script>

    <!-- Styles -->
    {{-- @include('meta.styles') --}}
    @livewire('livewire-alert')
    @include('regidoc.layouts.partials.head.styles')
    @livewireStyles()
</head>

<body>
    <main class="main" id="top" style="overflow-x: hidden;">
        {{-- @include('components.topnav-home') --}}
        {{-- @include('layouts.partials.header.navbar') --}}

        @yield('content')
        {{-- <div class="container" data-layout="container">
                <script>
                    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                    if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                    }
                </script>



            </div> --}}
    </main>
    <div class="modal fade" id="modal-logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="power"></i>
                        <h5>Déconnexion</h5>
                        <p>Voulez-vous vraiment vous déconnecter ?</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-between w-100">
                        <button class="btn btn-cancel" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                        <form method="POST" action="{{ route('logout') }}" class="p-0">
                            @csrf
                            <a class="btn btn-delete" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                Déconnexion
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('meta.scripts') --}}
    @include('regidoc.layouts.partials.head.scripts')
    @yield('scripts')
    @stack('livewireScripts')
    <script>
        $(document).ready(function() {
            $("#input-search-conv").keyup(function() {
                if ($(this).val() === '') {
                    $("#block-clean-input-search-conv").removeClass('show')
                } else {
                    $("#block-clean-input-search-conv").addClass('show')
                    $("#block-clean-input-search-conv").click(function() {
                        $(this).removeClass('show')
                        $("#input-search-conv").val('');
                        if ($("#input-search-conv").val() === '') {
                            $("#list-conv li").show()
                            $(".sidebar-doc .empty-result").removeClass('show')
                        }
                    })
                }
                var value = $(this).val().toLowerCase()
                $("#list-conv li").each(function() {
                    var searc = $(this).text().toLowerCase();
                    if (searc.indexOf(value) > -1) {
                        $(this).show()
                        $(".sidebar-doc .empty-result").removeClass('show')
                    } else {
                        $(this).hide()
                        $(".sidebar-doc .empty-result").addClass('show')
                    }
                })
            })
            $("#input-search-contact").keyup(function() {
                if ($(this).val() === '') {
                    $("#block-clean-input-search-contact").removeClass('show')
                } else {
                    $("#block-clean-input-search-contact").addClass('show')
                    $("#block-clean-input-search-contact").click(function() {
                        $(this).removeClass('show')
                        $("#input-search-contact").val('');
                        if ($("#input-search-contact").val() === '') {
                            $("#list-contact li").show()
                            $(".sidebar-doc .empty-result-contact").removeClass('show')
                        }
                    })
                }
                var value = $(this).val().toLowerCase()
                $("#list-contact li").each(function() {
                    var searc = $(this).text().toLowerCase();
                    if (searc.indexOf(value) > -1) {
                        $(this).show()
                        $(".sidebar-doc .empty-result-contact").removeClass('show')
                    } else {
                        $(this).hide()
                        $(".sidebar-doc .empty-result-contact").addClass('show')
                    }
                })
            })
            $(".header-sidebar .btn-new-chat").click(function() {
                $(".block-scanner .sidebar-contact").addClass('show')
            })
            $(".block-scanner .sidebar-contact .back").click(function(e) {
                e.preventDefault()
                $(".block-scanner .sidebar-contact").removeClass('show')
            })
            $('.theme-mode-control label').click(function() {
                $('.theme-mode-control').toggleClass('active')
            })
            $('.close-menu').click(function() {
                $('.sidebar').toggleClass('sidebar-sm')
                $('.wrapper').toggleClass('wrapper-lg')
            })
            @if (Session::has('success'))
                $('.message-flash').addClass('show')
                setTimeout(() => {
                    $('.message-flash').removeClass('show')
                }, 5000);
            @elseif (session()->has('message'))
                $('.message-flash').addClass('show')
                setTimeout(() => {
                    $('.message-flash').removeClass('show')
                }, 5000);
            @endif

            const nvFichier = document.getElementById('file-upload');
            const filename = document.querySelector('.list-file .name-file')
            const iframe = document.querySelector('.content-scanner iframe');

            nvFichier.addEventListener('change', function() {
                const fichier = this.files[0];
                if (fichier) {
                    let namefile = fichier.name;
                    if (namefile.length >= 12) {

                        let splitName = namefile.split('.');

                        namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];

                    }
                    const analyseur = new FileReader();
                    $(iframe).addClass('show')
                    $(iframe).addClass('fade')
                    analyseur.readAsDataURL(fichier);
                    analyseur.addEventListener('load', function() {
                        $(iframe).removeClass('d-none')
                        $('.block-no-file').addClass('d-none')
                        $('.block-col').removeClass('d-none')
                        iframe.setAttribute('src', this.result);
                        filename.innerHTML = namefile;
                    })
                }
                setTimeout(() => {
                    $(iframe).removeClass('fade')
                }, 3000);
            })

            // if(fichier) {

            //     let namefile = fichier.name;
            //     if (namefile.length >= 12) {

            //         let splitName = namefile.split('.');

            //         namefile = splitName[0].substring(0,12) + "... ." + splitName[1];

            //     }

            //     const analyseur = new FileReader();



            //     analyseur.readAsDataURL(fichier);

            //     analyseur.addEventListener('load', function(){
            //         console.log(progressArea)
            //         progressArea.style.display = "flex";
            //         filename.innerHTML = namefile;

            //     })

            // }
        })
    </script>
    <div class="message-flash success">
        <div class="content-text d-flex">
            <div class="icon">
                <i data-feather="check-circle"></i>
            </div>
            <div class="text-star">
                <h6>Successfuly massage</h6>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Mollitia, quidem?</p>
            </div>
        </div>
    </div>

</body>

</html>
