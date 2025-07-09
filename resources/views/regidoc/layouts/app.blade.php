<!DOCTYPE html>
<html lang="fr">

<head>
    @include('regidoc.layouts.partials.head.meta')

    @include('regidoc.layouts.partials.head.styles')

    @yield('css')
</head>

<body>
    {{-- <div id="page-load">
        <div class="backdrop fade"></div>
        <div class="parent-modal">
            <div class="dialog dialog-centered">
                <div class="content-modal">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="load-spiner">
                            </div>
                            <div class="text-stared">
                                <h6 class="mb-0" style="color:var(--colorTitre)!important;">
                                    Veuillez patienter...
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}
    @yield('body')

    {{-- @if (session()->get('session') && json_decode(session()->get('session'))->name != '')
        <div class="message-flash success">
            <div class="content-text d-flex">
                <div class="icon">
                    @if (json_decode(session()->get('session'))->statut == 'success')
                        <i class="bi bi-check"></i>
                    @endif
                </div>
                <div class="text-star">
                    <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                    <p>{{ json_decode(session()->get('session'))->message }}</p>
                </div>
            </div>
        </div>
        {{ session()->pull('session') }}
    @endif --}}

    {{-- @livewire('livewire-alert') --}}
    @include('regidoc.layouts.partials.head.script')

    @yield('javascript')
    @stack('livewireScripts')

    <script>
        $(document).ready(function() {
            // Cacher le loader par défaut(-)
            $('#page-load').hide();

            // Afficher le loader lorsqu'une requête AJAX commence
            $(document).ajaxStart(function() {
                $('#page-load').show();
                $('.btn-loader').removeClass('d-none');
            });

            // Cacher le loader lorsqu'une requête AJAX se termine
            $(document).ajaxStop(function() {
                $('#page-load').hide();
                $('.btn-loader').removeClass('d-none');
            });

            // Afficher le loader lorsqu'une page commence à charger
            $(window).on('beforeunload', function() {
                $('#page-load').show();
                $('.btn-loader').removeClass('d-none');
                $('.block-login .btn.btn-valid-form ').addClass('sm')
            });
        });
    </script>
    <script>
        $('.message-flash').addClass('show')
        setTimeout(() => {
            $('.message-flash').removeClass('show')
        }, 5000);

        $(document).ready(function() {

            $('#form-login').on('keyup', '.form-control', function(event) {
                event.preventDefault();

                $('.form-control').removeClass('form-error');
            });
        });

        window.livewire.onError(statusCode => {
            if (statusCode === 419) {
                // alert('Your own message')
                location.reload()
                return false
            }else if (statusCode === 500) {
                // alert('Une erreur c\'est produite')

                return false
            }
        })
    </script>

    @livewireScripts
</body>

</html>
