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

    <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon">
    @include('regidoc.layouts.partials.head.styles')
    @yield('styles')
    @livewireStyles()
    @livewireScripts()
</head>

<body>

    <div class="global-div">
        @include('regidoc.layouts.partials.header.sidebar-parametre')
        <div class="wrapper-page">
            @yield('content')
        </div>
        <div class="backdropFilter"></div>
    </div>

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
                        <img src="{{ asset('assets/images/icons/iconrouge-maxidoc.svg') }}" alt="icon error">
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
