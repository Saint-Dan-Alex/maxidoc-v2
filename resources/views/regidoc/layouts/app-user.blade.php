<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">
<!--
# Project developed by REGIDESO S.A with Newtech Consulting
# Developers:
# - Jean-Louis DIKASA MVITA jdikasa@yahoo.fr +243811647737
# - Francis ISASI MPEMBA isafranck23@gmail.com +243828580212
# - Pedrien KINKANI pedrienk@gmail.com +243810678167
# - Siméon ZILU ximeonzislu@gmail.com +243810814949
-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MaxiDoc | Gestion électronique des courriers</title>
    <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon">

    <!-- Styles -->
    @include('regidoc.layouts.partials.head.styles')
    @livewireStyles()
    @livewireScripts()
</head>

<body>

    <div class="global-div">
        <div class="wrapper">
            {{-- @include('components.topnav-home') --}}
            @include('regidoc.layouts.partials.header.navbar')
            <div class="content">
                @yield('content')
                {{-- <!-- @include('components.footer') --> --}}
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

    @livewire('notification.notification-drawer')

    @if (session()->get('session') && json_decode(session()->get('session'))->name != '')
        @if (json_decode(session()->get('session'))->statut == 'success')
            <div class="message-flash success">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        <img src="{{ asset('assets/images/icons/file_icon.png') }}" alt="icon success">
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'warnig')
            <div class="message-flash warning">
                <div class="content-text d-flex">
                    <div class="icon">
                        <i data-feather="alert-circle"></i>
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'error')
            <div class="message-flash error">
                <div class="content-text d-flex">
                    <div class="icon">
                        <i data-feather="x-circle"></i>
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @endif

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
    @stack('livewireScripts')
    <script>
        //  feather.replace()
        $(document).scroll(function() {
            if ($(this).scrollTop() > 40) {
                $('.navbar').addClass('box-shadow')
            } else {
                $('.navbar').removeClass('box-shadow')
            }
        })

        $(document).ready(function() {

            $('.block-salaire .text-clique.text-clique-1').click(function() {
                $(this).addClass('active');
                $('.block-salaire .text-clique.text-clique-2').addClass('active');
            })
            $('.block-salaire .text-clique.text-clique-2').click(function() {
                $(this).removeClass('active');
                $('.block-salaire .text-clique.text-clique-1').removeClass('active');
            })
            $('.theme-mode-control label').click(function() {
                $('.theme-mode-control').toggleClass('active')

            })
            $('.close-menu').click(function() {
                $('.sidebar').toggleClass('sidebar-sm')
                $('.wrapper').toggleClass('wrapper-lg')
            })
            var linkItems = document.querySelectorAll(".nav-folder li");
            var indicator = document.querySelector(".indicator-nav");
            linkItems.forEach((linkItem, index) => {
                linkItem.addEventListener("click", () => {
                    var width = $(linkItem).width();
                    var leftOffset = linkItem.offsetLeft;
                    console.log(leftOffset);
                    indicator.style.left = `${leftOffset + ((width / 2 ) - 9)}px`;
                })


                // console.log(width);
            })

            var linkItems2 = document.querySelectorAll(".nav-folder li");
            // console.log(linkItems2);
            var indicator2 = document.querySelector(".indicator-nav");
            linkItems2.forEach((linkItem2, index2) => {
                var btn = $(linkItem2).find('button.active');
                var width2 = $(btn.parent()).width();
                var leftOffset2 = btn.parent()[0].offsetLeft;
                indicator2.style.left = `${leftOffset2 + ((width2 / 2 ) - 9)}px`;
            })

            window.addEventListener('alert', event => {
                $('.message-flash.wire').addClass('show')
                setTimeout(() => {
                    $('.message-flash.wire').removeClass('show')
                }, 5000);
            });

            @if (Session::has('session'))
                $('.message-flash').addClass('show')
                setTimeout(() => {
                    $('.message-flash').removeClass('show')
                }, 5000);
            @endif

            // $('.message-flash').addClass('show')
            // setTimeout(() => {
            //     $('.message-flash').removeClass('show')
            // }, 5000);

        })
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
            // $('.close-menu-sm').click(function() {
            //     $('body').toggleClass('overflowHidden')
            //     $('.sidebar').toggleClass('sidebar-sm')
            //     $('.sidebar-mobile').toggleClass('sidebar-respo')
            //     $('.backdropFilter').toggleClass('show')
            //     $('.wrapper').toggleClass('wrapper-lg')
            // })
            $('.btn-list-agent').click(function() {
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

        });

        // $('.select2').select2({
        //     tags: $(this).data('tags') ? $(this).data('tags') : false,
        //     placeholder: $(this).data('placeholder'),
        //     language: "fr",
        //     width: '100%',
        //     maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
        // })

        // document.addEventListener('livewire:load', () => {
        //     Livewire.onPageExpired((response, message) => {
        //         alert('test')
        //         location.reload()
        //     })
        // })

        // window.livewire.onError(statusCode => {
        //     if (statusCode === 419) {
        //         // alert('Your own message')
        //         location.reload()
        //         return false
        //     } else if (statusCode === 500) {
        //         // alert('Une erreur c\'est produite')
        //         return false
        //     }
        // })
    </script>

</body>

</html>
