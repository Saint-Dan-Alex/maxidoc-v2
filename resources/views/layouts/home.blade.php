<!Doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MaxiDoc | Gestion électronique des courriers</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.js"></script>

    <!-- Styles -->
    {{-- @include('meta.styles') --}}
    @include('layouts.partials.head.styles')
    @livewireStyles()
</head>

<body>
    <div class="global-div">
        {{-- @include('components.aside') --}}
        <x-sidebar />

        <div class="wrapper">

            {{-- @include('components.topnav-home') --}}
            @include('layouts.partials.header.navbar')
            <div class="content">


                @yield('content')

                {{-- <!-- @include('components.footer') --> --}}
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNotif" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Notificationxxs</h5>
            <hr>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="card card-notification">
                <div class="avatar-user-float">
                    <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                </div>
                <div class="text-star text-content">
                    <h6 class="date d-flex justify-content-between align-items-center"><span>Jeanne labelle </span>
                        <span>12:45 PM</span>
                    </h6>
                    <p>A ajouté deux fichiers dans <span>#name dossier</span></p>
                    <div class="block-file d-flex mt-2">
                        <div class="icon-sm">
                            <i class="fi fi-rr-folder"></i>
                        </div>
                        <div class="block-detail-file">
                            <h6>Name file</h6>
                            <p>12 Mo</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-notification see">
                <div class="avatar-user-float">
                    <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                </div>
                <div class="text-star text-content">
                    <h6 class="date d-flex justify-content-between align-items-center"><span>John Doe</span> <span>12:45
                            PM</span></h6>
                    <p>Vient de laisser un commentaire sur le projet <span>#Name project</span> </p>
                </div>
            </div>
            <div class="card card-notification">
                <div class="avatar-user-float">
                    <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                </div>
                <div class="text-star text-content">
                    <h6 class="date d-flex justify-content-between align-items-center"><span>20 Jan 2021</span>
                        <span>12:45 PM</span>
                    </h6>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sint provident ea repellendus saepe
                        omnis, nihil sequi nulla, vitae hic odio, rem fuga eos aspernatur ipsa incidunt ad maiores
                        delectus quo.</p>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="text-end">
                <a href="#" class="see-more">more</a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <h5 class="mb-0">Inbox</h5>
                <p class="mb-0">(5)</p>
            </div>
            <div class="card card-notification see">
                <div class="avatar-user-float">
                    <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                </div>
                <div class="text-star text-content">
                    <h6 class="date d-flex justify-content-between align-items-center"><span>John Doe</span> <span>12:45
                            PM</span></h6>
                    <p>A envoyé un mail <span>#Description mail</span> </p>
                </div>
                <div class="d-flex justify-content-end">
                    <div class="num">2</div>
                </div>
            </div>
            <div class="card card-notification">
                <div class="avatar-user-float">
                    <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                </div>
                <div class="text-star text-content">
                    <h6 class="date d-flex justify-content-between align-items-center"><span>John Doe</span> <span>12:45
                            PM</span></h6>
                    <p>A envoyé un mail <span>#Description mail</span> </p>
                </div>
            </div>
            <div class="card card-notification see">
                <div class="avatar-user-float">
                    <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                </div>
                <div class="text-star text-content">
                    <h6 class="date d-flex justify-content-between align-items-center"><span>John Doe</span> <span>12:45
                            PM</span></h6>
                    <p>A envoyé un mail <span>#Description mail</span> </p>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="text-center">
                <a href="#" class="btn">Plus des courriers</a>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-logout" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-text text-center">
                        <i data-feather="power"></i>
                        <h5>Are you sure ?</h5>
                        <p>This action can't be undone.</p>
                    </div>
                    <div class="block-btn d-flex justify-content-between mb-3 w-100">
                        <button class="btn btn-cancel" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                        <form method="POST" action="{{ route('logout') }}" class="p-0">
                            @csrf
                            <a class="btn btn-delete" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                this.closest('form').submit();">
                                Deconnexion
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <!-- <div class="message-flash warning">
            <div class="content-text d-flex">
                <div class="icon">
                    <i data-feather="alert-circle"></i>
                </div>
                <div class="text-star">
                    <h6>Successfuly massage</h6>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Mollitia, quidem?</p>
                </div>
            </div>
        </div>
        <div class="message-flash error">
            <div class="content-text d-flex">
                <div class="icon">
                    <i data-feather="x-circle"></i>
                </div>
                <div class="text-star">
                    <h6>Successfuly massage</h6>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Mollitia, quidem?</p>
                </div>
            </div>
        </div> -->
    <!-- <main class="main" id="top">

            <div class="container-fluid" data-layout="container">
                <script>
                    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                    if (isFluid) {
                        var container = document.querySelector('[data-layout]');
                        container.classList.remove('container');
                        container.classList.add('container-fluid');
                    }
                </script>



            </div>
        </main> -->
    {{-- @include('meta.scripts') --}}
    @include('layouts.partials.head.scripts')
    <script>
        //  feather.replace()

        $('.theme-mode-control label').click(function() {
            $('.theme-mode-control').toggleClass('active')

        })
        $('.close-menu').click(function() {
            $('.sidebar').toggleClass('sidebar-sm')
            $('.wrapper').toggleClass('wrapper-lg')
        })
        $('.close-menu-sm').click(function() {
            $('body').toggleClass('overflowHidden')
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
        if (window.matchMedia("(max-width: 1024px)").matches) {
            $('.all-person .nav-item').click(function() {
                $('body').removeClass('overflowHidden')
                $('.backdropFilter').removeClass('show')
                $('.sidebar-mobile').removeClass('sidebar-respo')
                $('.sidebar').removeClass('sidebar-sm')
                $('.wrapper').toggleClass('wrapper-lg')
            })
        }
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
        var indicator2 = document.querySelector(".indicator-nav");
        linkItems2.forEach((linkItem2, index2) => {
            var btn = $(linkItem2).find('button.active');
            var width2 = $(btn.parent()).width();
            var leftOffset2 = btn.parent()[0].offsetLeft;
            indicator2.style.left = `${leftOffset2 + ((width2 / 2 ) - 9)}px`;
        })
        // var linkItemActive = document.querySelector(".nav-folder li");

        // var width = $(linkItemActive).width();

        // var leftOffset = linkItemActive.offsetLeft;
        // console.log(leftOffset);
        // indicator.style.left = `${leftOffset + ((width / 2 ) - 9)}px`;

        $('.message-flash').addClass('show')
        setTimeout(() => {
            $('.message-flash').removeClass('show')
        }, 5000);
    </script>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-departement"
        aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header" style="flex-direction: column;">
            <div class="d-flex justify-content-between w-100">
                <div class="text-star">
                    <h5 id="offcanvasRightLabel" class="mb-1">Détails du département </h5>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                            class="me-1">Créé le: </span> 22 Jav 2022</p>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                            class="me-1">Par: </span> John Doe</p>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>


        </div>
        <div class="offcanvas-body">

            <div class="block-progress">
                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Dénomination
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Description
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>

                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Responsable
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>
                <div class="card card-notification card-campaing">
                    <div class="d-flex justify-content-between">
                        <div class="text-star">

                            <h6 class="date d-flex justify-content-between align-items-center mb-0">
                                Nombre de divisions
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                        </div>
                        <div class="text-star">

                            <h6 class="date d-flex justify-content-between align-items-center mb-0">
                                Nombre d'agents
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="offcanvas-footer">
            <div class="d-flex justify-content-end">
                <button class="btn">Modifier</button>
                <button class="btn">Supprimer</button>
            </div>
        </div>

    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-division" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header" style="flex-direction: column;">
            <div class="d-flex justify-content-between w-100">
                <div class="text-star">
                    <h5 id="offcanvasRightLabel" class="mb-1">Détails de divison </h5>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                            class="me-1">Créé le: </span> 22 Jav 2022</p>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                            class="me-1">Par: </span> John Doe</p>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>


        </div>
        <div class="offcanvas-body">
            <div class="block-progress">
                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Dénomination
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Description
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>
                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Département
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Chef du département</h5>
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>


                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Nombre d'agents
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>

            </div>

        </div>
        <div class="offcanvas-footer">
            <div class="d-flex justify-content-end">
                <button class="btn">Modifier</button>
                <button class="btn">Supprimer</button>
            </div>
        </div>

    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-fonction" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header" style="flex-direction: column;">
            <div class="d-flex justify-content-between w-100">
                <div class="text-star">
                    <h5 id="offcanvasRightLabel" class="mb-1">Détails de divison </h5>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                            class="me-1">Créé le: </span> 22 Jav 2022</p>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                            class="me-1">Par: </span> John Doe</p>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>


        </div>
        <div class="offcanvas-body">
            <div class="block-progress">
                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Dénomination
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Description
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>



                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="date d-flex justify-content-between align-items-center mb-0">
                            Nombre d'agents
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>

            </div>

        </div>
        <div class="offcanvas-footer">
            <div class="d-flex justify-content-end">
                <button class="btn">Modifier</button>
                <button class="btn">Supprimer</button>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal-delete-contact" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-text text-center">
                        <i data-feather="trash"></i>
                        <h5>Are you sure ?</h5>
                        <p>This action can't be undone.</p>
                    </div>
                    <div class="block-btn d-flex justify-content-center mb-3">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal"
                            aria-label="Close">Annuler</button>
                        <button class="btn btn-delete">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-suspend" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content-text text-center">
                        <i data-feather="power"></i>
                        <h5>Are you sure ?</h5>
                        <p>This action can't be undone.</p>
                    </div>
                    <div class="block-btn d-flex justify-content-center mb-3">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal"
                            aria-label="Close">Annuler</button>
                        <button class="btn btn-delete">Suspendre</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-departement" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Create contact</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="First-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Last-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="email" class="form-control" placeholder="Email adress">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Telephone">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Tag"
                                    autocomplete="additional-name">
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-division" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Create contact</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="First-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Last-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="email" class="form-control" placeholder="Email adress">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Telephone">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Tag"
                                    autocomplete="additional-name">
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-fonction" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Create contact</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="First-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Last-name">
                            </div>
                            <div class="col-lg-12">
                                <input type="email" class="form-control" placeholder="Email adress">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Telephone">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Tag"
                                    autocomplete="additional-name">
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
