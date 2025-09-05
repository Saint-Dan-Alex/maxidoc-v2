<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="">
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
    <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.js"></script>

    @include('regidoc.layouts.partials.head.styles')
    @yield('style')
    @livewireScripts()
    <style>
    .scrollable-text {
        max-height: 6em;
        overflow-y: auto;
        white-space: normal;
        scrollbar-width: thin; /* pour Firefox */
    }

    /* Scrollbar fine pour Chrome, Edge, Safari */
    .scrollable-text::-webkit-scrollbar {
        width: 6px;
    }

    .scrollable-text::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 3px;
    }
</style>

</head>

<body>
    <div id="page-load">
        <div class="backdrop fade"></div>
        <div class="parent-modal">
            <div class="dialog dialog-centered">
                <div class="content-modal">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="load-spiner">
                            </div>
                            <div class="text-stared">
                                <h6 class="mb-0" style="color:rgb(255, 255, 255) !important;">
                                    Numérisation en cours, veuillez patienter...
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <main class="main" id="top" style="overflow-x: hidden;">
        @include('components.topnav-home')
        {{-- @include('regidoc.layouts.partials.header.navbar') --}}

        @yield('content')

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

    @if (session()->get('session') && json_decode(session()->get('session'))->name != '')
        @if (json_decode(session()->get('session'))->statut == 'success')
            <div class="message-flash success">
                <div class="content-text d-flex">
                    <div class="icon">
                        <i class="bi bi-check"></i>
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

    @stack('modals')

    @livewire('livewire-alert')

    @include('regidoc.layouts.partials.head.scripts')
    @yield('javascript')
    @stack('scripts')
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
        });
    </script>

    <script>
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
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('select.select2').each(function() {

            $(this).select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                },
                ajax: {
                    url: $(this).data('get-items-route'),
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: $(this).data('get-items-field'),
                            method: $(this).data('method'),
                            id: $(this).data('id'),
                            page: params.page || 1,
                            model: $(this).data('related-model'),
                            label: $(this).data('label'),
                        }
                        return query;
                    }
                },
                // initSelection: function(element, callback) {
                //     var defaultValue = 'defaultOption'; // Set your default value here
                //     var defaultOption = { id: defaultValue, text: defaultValue };
                //     callback(defaultOption);
                // },
                width: '100%',
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
            });

            $(this).on('select2:select', function(e) {
                var data = e.params.data;

                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',
                        'selected');
                }
            });

            $(this).on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',
                    false);
            });

            $(this).on('select2:selecting', function(e) {
                // console.log(e.params.data);
                if ($(this).attr('id') == 'type_id') {
                    // console.log(e.params.args.data.id);
                    var value = e.params.args.data.id;
                    if (value == 2 || value == 3) {
                        $('.exped_extern').addClass('d-none');
                        $('.exped_intern').removeClass('d-none');
                    } else {
                        $('.exped_extern').removeClass('d-none');
                        $('.exped_intern').addClass('d-none');
                    }
                }

                if (!$(this).data('tags')) {
                    return;
                }
                var $el = $(this);
                var route = $el.data('route');
                var label = $el.data('label');
                var relativeId = $el.data('relative-id');
                var errorMessage = $el.data('error-message');
                var newTag = e.params.args.data.newTag;

                if (!newTag) return;

                $el.select2('close');

                $.post(route, {
                    [label]: e.params.args.data.text,
                    relative_id: relativeId,
                    _tagging: true,
                }).done(function(data) {
                    console.log(data);
                    var newOption = new Option(e.params.args.data.text, data.results.id,
                        false, true);
                    $el.append(newOption).trigger('change');
                }).fail(function(error) {
                    // toastr.error(errorMessage);
                    console.log(errorMessage);
                });

                return false;
            });
        });

        $('.theme-mode-control label').click(function() {
            $('.theme-mode-control').toggleClass('active')
        })

        $('.close-menu').click(function() {
            $('.sidebar').toggleClass('sidebar-sm')
            $('.wrapper').toggleClass('wrapper-lg')
        })

        @if (Session::has('session'))
            $('.message-flash').addClass('show')
            setTimeout(() => {
                $('.message-flash').removeClass('show')
            }, 5000);
        @endif

        window.addEventListener('alert', event => {
            $('.message-flash.wire').addClass('show')
            setTimeout(() => {
                $('.message-flash.wire').removeClass('show')
            }, 5000);
        });
    </script>

    <script>
        $(".lable-file-in").click(function() {
            $(".lable-file-in").removeClass('active')
            $(this).addClass('active')
        })
        const v = document.getElementById('file-upload');
        const nvFichier = document.getElementById('file-upload');
        const filename = document.querySelector('.list-file .name-file')
        const iframe = document.querySelector('.content-scanner iframe');

        if (nvFichier) {
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
        }


        $('.block-remove .btn-remove:not(.autre)').click(function(e) {
            e.preventDefault()
            $(this).parent().parent().parent().parent().addClass('d-none')
            $('.col-img').addClass('d-none')
            $('#label-5').removeClass('active')
            $(nvFichier).val('');
            $(iframe).attr('src', '')
        })

        // window.livewire.onError(statusCode => {
        //     if (statusCode === 419) {
        //         // alert('Your own message')
        //         location.reload()
        //         return false
        //     }else if (statusCode === 500) {
        //         // alert('Une erreur c\'est produite')

        //         return false
        //     }
        // })
    </script>
</body>

</html>
