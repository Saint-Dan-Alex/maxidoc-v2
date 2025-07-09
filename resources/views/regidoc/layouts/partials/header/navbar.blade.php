<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid px-lg-4">

        <div class="row w-100 ms-0">
            <div class="col-lg-6 col-4 col-sm-6 ps-0">
                <div class="d-flex align-items-center">
                    <div class="logo-header">
                        <a href="/">
                            <div class="block-logo">
                                <img src="{{ asset('assets/regidoc/icon.png') }}">
                                <img src="{{ asset('assets/regidoc/icon-white.png') }}">
                            </div>
                        </a>
                    </div>
                    <div class="align-items-center block-search-nav d-lg-flex">
                        @livewire('search.search-engin')
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-8 col-sm-6 pe-0">
                <div class="d-flex ms-auto align-items-center justify-content-end">
                    <a href="" class="link me-4 d-lg-none d-flex d-sm-none btn-search-mobile">
                        <i class="fi fi-rr-search"></i>
                    </a>

                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <!--begin::Menu toggle-->
                            <a href="#" class="d-flex align-items-center link" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="svg-icon theme-light-show svg-icon-2">
                                    <i class="fi fi-rr-sun"></i>
                                    <div class="tooltip-indicator">
                                        Thème
                                    </div>
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" id="theme-switch-menu">
                                <li class="">
                                    <a href="#" class="dropdown-item" data-element="mode" data-value="light">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fi fi-rr-sun"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Claire</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#" class="dropdown-item" data-element="mode" data-value="dark">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fi fi-rr-moon-stars"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Sombre</span>
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#" class="dropdown-item" data-element="mode" data-value="system">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <span class="svg-icon svg-icon-3">
                                                <i class="fi fi-rr-computer"></i>
                                            </span>
                                        </span>
                                        <span class="menu-title">Système</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @livewire('notification.notification-icon')

                    <div class="close-menu-sm">
                        <i class="fi fi-rr-menu-burger"></i>
                    </div>
                    <div class="block-user d-flex align-items-center">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center" id="dropdownMenuButton2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="avatar-user">
                                    <img src="{{ imageOrDefault(Auth::user()->agent?->image) }}" alt="image profil">
                                </div>
                                <div class="user-name me-2 d-none d-lg-block">
                                    <h6>{{ Auth::user()->agent?->prenom . ' ' . Auth::user()->agent?->nom }}</h6>
                                    <p>{{ Auth::user()->agent?->poste?->titre }}</p>
                                </div>
                                <i class="fi fi-rr-angle-down arrow d-none d-lg-block"
                                    style="color: var(--colorParagraph); font-size: 14px;"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                                <li>
                                    <a class="dropdown-item" href="{{ route('regidoc.profil.index') }}">
                                        <i class="fi fi-rr-user"></i> Profil
                                    </a>
                                </li>
                                {{-- <li>
                                    <a class="dropdown-item" href="{{-- route('dige.parametre-profil') -}}">
                                        <i class="fi fi-rr-settings-sliders fi-rr"></i> Parametres
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fi fi-rr-interrogation"></i> Aide
                                    </a>
                                </li> --}}
                                <li>
                                    {{-- data-bs-toggle="modal" data-bs-target="#modal-logout" --}}
                                    <a class="dropdown-item" href="javascript:void(0)"
                                        onclick="document.getElementById('logout-form').submit()">
                                        <i class="fi fi-rr-sign-out-alt"></i>Deconnexion
                                    </a>
                                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</nav>

{{-- <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid px-lg-4">
    <div class="logo-header">
        <a href="/">
            <div class="block-logo">
                <img src="{{ asset('assets/regidoc/logo-regidoc.svg') }}">
            </div>
        </a>
        <div class="close-menu-sm">
            <i class="fi fi-rr-menu-burger"></i>
        </div>
    </div>
        <div class="d-flex ms-auto align-items-center">
            {{-- <div class="d-flex block-search-nav">
                <form method="post" action="">
                    @csrf
                    <div class="input-group flex-nowrap">
                        <input type="text" class="form-control" placeholder="Recherche" aria-label="Username" aria-describedby="addon-wrapping">
                        <span class="input-group-text" id="addon-wrapping">
                            <i class="fi fi-rr-search"></i>
                        </span>
                      </div>
                </form>
            </div> --}}
{{-- <div class="theme-control-toggle fa-icon-wait theme-mode-control">
                <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Passer au thème clair"><span class="fas fa-sun fs-0"></span></label>
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Passer au thème sombre"><span class="fas fa-moon fs-0"></span></label>
                <!-- <label for="switch">
                </label> --> test

                <div class="bar">
                    <div class="div">
                            <i class="fi fi-rr-sun"></i>
                            <i class="fi fi-sr-moon"></i>
                    </div>
                </div>
            </div> -}}
            <!-- <div class="theme-mode-control">
                <input type="checkbox" id="switch">
                <label for="switch">
                </label>

            </div> -->
            <a href="{{ route('chat.index') }}" class="link ms-2">
                <i class="fi fi-rr-comment"></i>
            </a>
            <a href="" class="link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotif" aria-controls="offcanvasRight">
                <i class="fi fi-rr-bell"></i>
                <span class="blink"></span>
            </a>
            <div class="block-user d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-user">
                            <img src="{{ imageOrDefault(Auth::user()->agent->image) }}" alt="image profil">

                        </div>
                        {{-- <div class="user-name">
                            <h6>John Doe</h6>
                            <p>User</p>
                        </div> -}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                      <li><a class="dropdown-item" href="{{ route('profil.index') }}"><i class="fi fi-rr-user"></i> Profil</a></li>
                      {{-- <li><a class="dropdown-item" href=""><i class="fi fi-rr-settings-sliders fi-rr"></i> Parametres</a></li> --}}
{{-- <li><a class="dropdown-item" href="#"><i class="fi fi-rr-interrogation"></i> Aide</a></li> -}}
                      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-logout"><i class="fi fi-rr-sign-out-alt"></i>Deconnexion</a></li>
                      {{-- <li><a class="dropdown-item" href="#" ><i class="fi fi-rr-sign-out-alt"></i>Deconnexion</a></li> -}}
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav> --}}
