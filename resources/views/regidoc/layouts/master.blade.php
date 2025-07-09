{{-- @php
    $messages = App\Models\Chat ::where('user_receve',Auth::user()->id)->where('read_at',null)->get();
    $courriers = App\Models\Notification :: where('type_id',3)->where('user_receve',Auth::user()->id)->where('readed_at',null)->get();
    $taches = App\Models\Notification :: where('type_id',2)->where('user_receve',Auth::user()->id)->where('readed_at',null)->get();
@endphp --}}
<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
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
    <!-- Styles -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon">
    @include('regidoc.layouts.partials.head.styles')
    @yield('styles')
    @livewireStyles()
    @livewireScripts()
</head>

<body>

    <div class="global-div">
        <x-sidebar />

        <div class="wrapper">
            @include('regidoc.layouts.partials.header.navbar')
            <div class="content">
                @yield('content')
            </div>
            @include('regidoc.layouts.partials.footer.footer')
        </div>
        {{-- <div class="tabBar d-block d-lg-none">
            <div class="content-tab d-flex align-items-center">
                <a href="#" class="active">
                    <i class="fi fi-rr-apps fi-rr"></i>
                    <i class="fi fi-sr-apps fi-sr"></i>
                    <span>Accueil</span>
                </a>
                <a href="#">
                    <i class="fi fi-rr-document fi-rr"></i>
                    <i class="fi fi-sr-document fi-sr"></i>
                    <span>Courriers</span>
                </a>
                <a href="#">
                    <i class="fi fi-rr-folder fi-rr"></i>
                    <i class="fi fi-sr-folder fi-sr"></i>
                    <span>Documents</span>
                </a>
                <a href="#">
                    <i class="fi fi-rr-box fi-rr"></i>
                    <i class="fi fi-sr-box fi-sr"></i>
                    <span>Archivage</span>
                </a>
            </div>
        </div> --}}
        <div class="backdropFilter"></div>
    </div>
    <div class="modal fade" id="modalNewDoc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nouveau document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-lg-5">
                    <div class="row g-lg-4 g-3">
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 1]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Lettre officielle</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/lettre-officielle.png') }}"
                                        alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 4]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Lettre interne</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/lettre-interne.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 5]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Note circulaire</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/note-circulaire.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 8]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Note de service</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/note-service.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 6]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Message email</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/message-email.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 7]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Ordre de mission</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/ordre-mission.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 2]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Bon de commande</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/bon-commande.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{ route('regidoc.documents.createNew', ['doc_type' => 3]) }}"
                                class="link-new-doc">
                                <h6 class="title-doc-new">Demande d'achat</h6>
                                <div class="block-img-view-doc">
                                    <img src="{{ asset('assets/images/imgDocs/demande-achat.png') }}" alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-load" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <div class="load-spiner">
                        </div>
                        <div class="text-star">
                            <h6 style="color:var(--colorTitre)!important;">Veuillez patienter...</h6>
                            <p style="font-size: 14px" class="mb-0">Nous préparons votre espace de travail</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @livewire('notification.notification-drawer')

    <div class="modal fade" id="modal-logout" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
    <audio id="audio-alert" src="{{ asset('assets/songs/newMessage.wav') }}"></audio>


    @if (session()->has('session'))
        @if (json_decode(session()->get('session'))->statut == 'success')
            <div class="message-flash success">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/iconvert-maxidoc.svg') }}" alt="icon success">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'warnig')
            <div class="message-flash warning">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/iconorange-maxidoc.svg') }}" alt="icon warning">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'error')
            <div class="message-flash error">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/error-icon.png') }}" alt="icon error">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @endif
        @php
            Session::forget('session');
        @endphp
    @endif

    @if ($errors->any())
        <div class="message-flash error">
            <div class="content-text d-flex">
                <div class="icon">
                    <i data-feather="x-circle"></i>
                </div>
                <div class="text-star">
                    <h6>{{ __('Whoops! Something went wrong.') }}</h6>
                    <ul class="mt-3 list-unstyled error-list">
                        @foreach ($errors->all() as $error)
                            <li class="text-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @livewire('livewire-alert')

    @include('regidoc.layouts.partials.head.scripts')

    @yield('scripts')

    @yield('injs')
    @stack('livewireScripts')

    <script>
        $(document).ready(function() {
            // Cacher le loader par défaut(-)
            $('#page-load').hide();

            // Afficher le loader lorsqu'une requête AJAX commence
            // $(document).ajaxStart(function() {
            //     $('#page-load').show();
            // });

            // Cacher le loader lorsqu'une requête AJAX se termine
            // $(document).ajaxStop(function() {
            //     $('#page-load').hide();
            // });

            // Afficher le loader lorsqu'une page commence à charger
            $(window).on('beforeunload', function() {
                $('#page-load').show();
            });

            // var audioAlert = $("#audio-alert")[0];
            // // Vérifier si l'audio est prêt à être joué
            // if (audioAlert.readyState > 0) {
            //     // Mettre le lecteur audio à la position de début
            //     audioAlert.currentTime = 0;

            //     // Jouer le son
            //     audioAlert.play();
            // }
        });
    </script>
    <script>
        $(".content").scroll(function() {
            if ($(this).scrollTop() > 40) {
                $('.navbar').addClass('box-shadow')
            } else {
                $('.navbar').removeClass('box-shadow')

            }
        });

        // window.addEventListener('alert', event => {
        //     $('.message-flash.wire').addClass('show')
        //     setTimeout(() => {
        //         $('.message-flash.wire').removeClass('show')
        //     }, 5000);
        // });

        document.addEventListener('DOMContentLoaded', function() {

            var items = [].slice.call(document.querySelectorAll('[data-element="mode"]'));

            items.map(function(item) {
                item.addEventListener("click", function(e) {
                    e.preventDefault();

                    // $(this).toggleClass('active');

                    var menuMode = item.getAttribute("data-value");
                    var mode = menuMode;

                    if (menuMode === "system") {
                        mode = getSystemMode();
                    }

                    setMode(mode, menuMode);
                    window.location.refresh();
                });
            });

            function getMode() {
                var mode;

                if (document.documentElement.hasAttribute("data-theme")) {
                    return document.documentElement.getAttribute("data-theme");
                } else if (localStorage.getItem("data-theme") !== null) {
                    return localStorage.getItem("data-theme");
                } else if (getMenuMode() === "system") {
                    return getSystemMode();
                }

                return "light";
            }

            function setMode(mode, menuMode) {
                var currentMode = getMode();

                // Reset mode if system mode was changed
                if (menuMode === 'system') {
                    if (getSystemMode() !== mode) {
                        mode = getSystemMode();
                    }
                } else if (mode !== menuMode) {
                    menuMode = mode;
                }

                // Read active menu mode value
                var activeMenuItem = document.querySelector('[data-element="mode"][data-value="' + menuMode + '"]');

                // Enable switching state
                document.documentElement.setAttribute("data-theme-mode-switching", "true");

                // Set mode to the target document.documentElement
                document.documentElement.setAttribute("data-theme", mode);

                // Disable switching state
                setTimeout(function() {
                    document.documentElement.removeAttribute("data-theme-mode-switching");
                }, 300);

                // Store mode value in storage
                localStorage.setItem("data-theme", mode);

                // Set active menu item
                if (activeMenuItem) {
                    localStorage.setItem("data-theme-mode", menuMode);
                    setActiveMenuItem(activeMenuItem);
                }

                // if (mode !== currentMode) {
                // 	KTEventHandler.trigger(document.documentElement, 'kt.thememode.change', the);
                // }
            }

            function getMenuMode() {
                // if (!menu) {
                // 	return null;
                // }

                var menuItem = document.querySelector('.active[data-element="mode"]');

                if (menuItem && menuItem.getAttribute('data-value')) {
                    return menuItem.getAttribute('data-value');
                } else if (document.documentElement.hasAttribute("data-theme-mode")) {
                    return document.documentElement.getAttribute("data-theme-mode")
                } else if (localStorage.getItem("data-theme-mode") !== null) {
                    return localStorage.getItem("data-theme-mode");
                } else {
                    return typeof defaultThemeMode !== "undefined" ? defaultThemeMode : "light";
                }
            }

            function getSystemMode() {
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? "dark" : "light";
            }

            function setActiveMenuItem(item) {
                var menuMode = item.getAttribute("data-value");

                var activeItem = document.querySelector('.active[data-element="mode"]');

                if (activeItem) {
                    activeItem.classList.remove("active");
                }

                item.classList.add("active");
                localStorage.setItem("data-theme-mode", menuMode);
            }

            setTimeout(function() {
                $('.page-loader').remove();
            }, 500);
        });
        $('.close-menu-sm').click(function() {
            $('body').toggleClass('overflowHidden')
            $('.sidebar').toggleClass('sidebar-sm')
            $('.sidebar-mobile').toggleClass('sidebar-respo')
            $('.backdropFilter').toggleClass('show')
            $('.wrapper').toggleClass('wrapper-lg')

        })
        $('.backdropFilter').click(function() {
            $('body').removeClass('overflowHidden')
            $(this).removeClass('show')
            $('.sidebar-mobile').removeClass('sidebar-respo')
            $('.sidebar').removeClass('sidebar-sm')
            $('.wrapper').toggleClass('wrapper-lg')
        })
        $('.btn-search-mobile').click(function(e) {
            e.preventDefault()
            $('.navbar .block-search-nav .position-lg-relative.search-lg-nav').addClass('show')
        })
        $('.close-search-nav').click(function() {
            $('.navbar .block-search-nav .position-lg-relative.search-lg-nav').removeClass('show')
        })
        $('.theme-mode-control label').click(function() {
            $('.theme-mode-control').toggleClass('active')
        })

        $('.close-menu').click(function() {
            $('body').removeClass('overflowHidden')
            $('.navbar .block-search-nav').toggleClass('sm-margin')
            $('.sidebar').toggleClass('sidebar-sm')
            $('.wrapper').toggleClass('wrapper-lg')

            $('.backdropFilter').toggleClass('show')
            $('.sidebar-mobile').toggleClass('sidebar-respo')
            $('.sidebar ul.lists li .collapse').removeClass('show')

            if ($('.sidebar').hasClass('sidebar-sm')) {
                // localStorage.setItem("data-size", "small")
                $('.sidebar .collapse').removeClass('.show')

                sidebarSm();
            } else {
                // localStorage.setItem("data-size", "large")
                $('.sidebar ul.lists li a.link').attr('data-bs-toggle', "collapse")
            }
        })

        // @if (session()->get('session') && json_decode(session()->get('session'))->name != '')
        // @endif

        $('.message-flash:not(.wire)').addClass('show')
        setTimeout(() => {
            $('.message-flash:not(.wire)').removeClass('show')
        }, 10000);
    </script>

    <script>
        $('.card-notification .btn-close').click(function() {
            $(this).parent().addClass('fadeOut')
            setInterval(() => {
                $(this).parent().addClass('delete')
            }, 500);
        });

        var body = $('.offcanvas-body');
        var btnClose = body.find('.card-notification.see .btn-close');

        btnClose.on('click', function() {
            // console.log('click');
            showEmpty(body);
            setTimeout(() => {
                showEmpty(body);
            }, 1000);
        });

        function showEmpty(body) {
            if (body.find('.card-notification.see').length > 0) {
                $('.block-empty-notif').removeClass('show')
            } else {
                $('.block-empty-notif').addClass('show')
            }
        }

        showEmpty(body);

        var lis = document.querySelectorAll(".nav-tache li");

        if (window.matchMedia("(max-width: 576px)").matches) {
            var linkItems = document.querySelectorAll(".nav-tache li");
            linkItems.forEach((linkItem, index) => {
                var width = $(linkItem).width();

                linkItem.addEventListener("click", () => {
                    $(linkItem).parent().css("transform", "translateX(" + (index * width) + ")")
                    // indicator.style.top = `${index * 53 + 88}px`;
                    // $(indicator).text(text.innerHTML)
                    // $(indicator).addClass('show')
                })
            })

        }

        function sidebarSm() {
            var linkItems = document.querySelectorAll(".sidebar-sm ul li");
            var indicator = document.querySelector(".tooltip-lg");
            linkItems.forEach((linkItem, index) => {
                linkItem.addEventListener("mouseenter", () => {
                    var text = linkItem.querySelector(".title");
                    indicator.style.top = `${index * 53 + 88}px`;
                    $(indicator).text(text.innerHTML)
                    $(indicator).addClass('show')
                })

                linkItem.addEventListener("mouseleave", () => {
                    indicator.style.top = 78 + 'px';
                    $(indicator).removeClass('show')
                })
            })
        }

        $('.backdropFilter').click(function() {
            $('body').removeClass('overflowHidden')
            $(this).removeClass('show')
            $('.sidebar-mobile').removeClass('sidebar-respo')
            $('.sidebar').removeClass('sidebar-sm')
            $('.wrapper').toggleClass('wrapper-lg')

        })

        $(document).ready(function() {

            $('.logout-button').on('click', function(event) {
                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    url: '/logout-session',
                    type: "post",
                    success: function(data) {
                        // console.log(data);
                        $('#form-logout').submit();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            var linkItems = document.querySelectorAll(".nav-folder li");
            var indicator = document.querySelector(".indicator-nav");
            linkItems.forEach((linkItem, index) => {
                linkItem.addEventListener("click", () => {
                    var width = $(linkItem).width();
                    var leftOffset = linkItem.offsetLeft;
                    console.log(leftOffset);
                    indicator.style.left = `${leftOffset + ((width / 2 ) - 9)}px`;
                })


            })

            var linkItems2 = document.querySelectorAll(".nav-folder li");
            var indicator2 = document.querySelector(".indicator-nav");
            linkItems2.forEach((linkItem2, index2) => {
                var btn = $(linkItem2).find('button.active');
                var width2 = $(btn.parent()).width();
                var leftOffset2 = btn.parent()[0].offsetLeft;
                indicator2.style.left = `${leftOffset2 + ((width2 / 2 ) - 9)}px`;
            })

        });
    </script>

    <script>
        // console.log(true);
        window.livewire.onError(statusCode => {
            if (statusCode === 419) {
                // alert('Your own message')
                location.reload()
                return false
            } else if (statusCode === 500) {
                // alert('Une erreur c\'est produite')

                return false
            }
        })
    </script>

</body>

</html>
