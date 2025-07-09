
{{-- @if(Auth::user()->isAdmin())
    @include('components.admin.topbar-home')
@endif

@if (Auth::user()->isPersonel())
    @include('components.personnel.topbar-home')
@endif

@if (Auth::user()->isHumanRes())
    @include('components.humanres.topbar-home')
@endif --}}

{{-- <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid px-lg-4">
        <div class="d-flex ms-auto align-items-center">
            <div class="theme-control-toggle fa-icon-wait theme-mode-control">
                <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark" />
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Passer au thème clair"><span class="fas fa-sun fs-0"></span></label>
                <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Passer au thème sombre"><span class="fas fa-moon fs-0"></span></label>
                <!-- <label for="switch">
                </label> -->
                <div class="bar">
                    <div class="div">
                            <i class="fi fi-rr-sun"></i>
                            <i class="fi fi-sr-moon"></i>
                    </div>
                </div>
            </div>
            <!-- <div class="theme-mode-control">
                <input type="checkbox" id="switch">
                <label for="switch">
                </label>

            </div> -->
            <a href="/chat" class="link ms-2">
                <i class="fi fi-rr-comment"></i>
            </a>
            <a href="" class="link" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotif" aria-controls="offcanvasRight">
                <i class="fi fi-rr-bell"></i>
            </a>
            <div class="block-user d-flex align-items-center">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="avatar-user">
                            <img src="{{asset('assets/img/team/1.jpg')}}" alt="image profil">

                        </div>
                        <div class="user-name">
                            <h6>John Doe</h6>
                            <p>User</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                      <li><a class="dropdown-item" href="/profil-user"><i class="fi fi-rr-user"></i> Profil</a></li>
                      <li><a class="dropdown-item" href="#"><i class="fi fi-rr-settings-sliders fi-rr"></i> Parametres</a></li>
                      <li><a class="dropdown-item" href="#"><i class="fi fi-rr-interrogation"></i> Aide</a></li>
                      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-logout"><i class="fi fi-rr-sign-out-alt"></i> Deconnexion</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</nav> --}}

