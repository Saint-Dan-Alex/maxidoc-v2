{{-- <!-- <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
    <script>
    var navbarStyle = localStorage.getItem("navbarStyle");
    if (navbarStyle && navbarStyle !== 'transparent') {
        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
    }
    </script>
    <div class="d-flex align-items-center">
    <div class="toggle-icon-wrapper">

        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

    </div><a class="navbar-brand" href="{{route('dige.index')}}">
        <div class="d-flex align-items-center py-3"><img class="me-2" src="{{asset('assets/img/icons/spot-illustrations/favicon.png')}}" alt="" width="40" /><span class="font-sans-serif">Barua</span>
        </div>
    </a>
    </div>
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content scrollbar">
        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
            <li class="nav-item">
                <a class="nav-link Active" href="{{route('dige.index')}}" >
                <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-chart-pie"></span></span><span class="nav-link-text ps-1 Active">Dashboard</span>
                </div>
                </a>

                    <a class="nav-link" href="{{route('dige.tache')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="bi bi-calendar2-week-fill"></span></span><span class="nav-link-text ps-1">Taches</span>
                        </div>
                    </a>


            </li>
            <li class="nav-item">

                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                <div class="col-auto navbar-vertical-label">Réssources Humaines
                </div>
                <div class="col ps-0">
                    <hr class="mb-0 navbar-vertical-divider" />
                </div>
                </div>
                <a class="nav-link" href="{{route('dige.departements')}}" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-house-user"></span></span><span class="nav-link-text ps-1">Départements</span>
                    </div>
                    </a>
                <a class="nav-link" href="{{route('dige.divisions')}}" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-project-diagram"></span></span><span class="nav-link-text ps-1">Divisions</span>
                    </div>
                    </a>
                <a class="nav-link" href="{{ route('dige.fonctions')}}" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-tag"></span></span><span class="nav-link-text ps-1">Fonctions</span>
                    </div>
                    </a>
                <a class="nav-link" href="{{ route('dige.personnels')}}" role="button" aria-expanded="false">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-user-alt"></span></span><span class="nav-link-text ps-1">Personnels</span>
                    </div>
                    </a>


                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Courriérs
                    </div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('courriers.send')}}" aria-expanded="false">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-paper-plane"></span></span><span class="nav-link-text ps-1">Nouveau courrier</span>
                        </div>
                    </a>


                  <a class="nav-link" href="{{route('courriers.received')}}" aria-expanded="false">

                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-envelope-open"></span></span><span class="nav-link-text ps-1">Courrier réçus</span>
                            </div>



                  <a class="nav-link" href="{{route('courriers.sent')}}" aria-expanded="false">

                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-envelope-open-text"></span></span><span class="nav-link-text ps-1">Courrier envoyés</span>
                            </div>
                        </a>


                  <a class="nav-link" href="{{route('courriers.reponse')}}" aria-expanded="false">

                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-envelope-open-text"></span></span><span class="nav-link-text ps-1">Courrier répondu</span>
                    </div>
                </a>


                    <a class="nav-link" href="{{route('messages')}}" role="button" aria-expanded="false">
                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-comments"></span></span><span class="nav-link-text ps-1">Chat</span>
                        </div>
                    </a>




                    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                        <div class="col-auto navbar-vertical-label">Archivage
                    </div>
                        <div class="col ps-0">
                            <hr class="mb-0 navbar-vertical-divider" />
                        </div>
                    </div>
                    <a class="nav-link" href="{{ route('archives')}}" aria-expanded="false">

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-sitemap"></span></span><span class="nav-link-text ps-1">Classeurs</span>
                        </div>
                    </a>


                  <a class="nav-link" href="{{ route('viewdossiers')}}" aria-expanded="false">

                            <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-folder"></span></span><span class="nav-link-text ps-1">Dossiers</span>
                            </div>


                  </a>

                  <a class="nav-link" href="{{route('viewdocuments')}}" >

                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-file"></span></span><span class="nav-link-text ps-1">Documents</span>
                        </div>
                  </a>



            </li>

        </ul>
        <div class="sett mb-3">
            <div class="" role="alert">
                <div class="btn-close-falcon-cont">
                    <div class="btn-close-falco" aria-label="Close" data-bs-dismiss="alert"></div>
                </div>
                <div class="card-body text-center"><img src="{{asset('img/gallery/enveloppe.png')}}" alt="" width="80" />
                    <p class="fs--2 mt-2"> <br /><a href="#!"></a></p>
                    <div class="d-grid"></div>
                </div>
            </div>
        </div>
    </div>

</nav> --> --}}

<div class="sidebar">

    <div class="close-menu">
        <i class="fi fi-rr-menu-burger"></i>
    </div>
    <div class="content-sidebar">
        <div class="logo">
            <a href="/">
               <div class="block-logo">
                   <img src="{{asset('assets/img/logos/logo-ads1.svg')}}" alt="">
                   <img src="{{asset('assets/img/logos/logo-ads1.svg')}}">
               </div>
               <div class="name-entreprise">
                   <h6>Name brand</h6>
                   <p>Direction générale</p>
               </div>
            </a>

        </div>
        <div class="block-links">
            <ul class="lists">
                <li>
                    <span class="tooltip-sm">
                       Courrier
                    </span>
                    <a href="contact-detail.html">
                       <span>
                        <i class="fi fi-rr-envelope fi-rr"></i>
                        <i class="fi fi-sr-envelope fi-sr"></i>
                       </span>
                       <span class="title">
                            Courrier
                       </span>
                    </a>
                </li>

                <li>
                    <span class="tooltip-sm">
                        Archivage
                    </span>
                    <a href="{{ route('archives') }}" class="{{ request()->is('archives/classeurs') ? 'active' : ''}}">
                       <span>
                        <i class="fi fi-rr-box fi-rr"></i>
                        <i class="fi fi-sr-box fi-sr"></i>
                       </span>
                       <span class="title">
                            Archivage
                       </span>
                    </a>
                </li>

                <li>
                    <span class="tooltip-sm">
                        Parametre
                    </span>
                    <a href="#">
                       <span>
                        <i class="fi fi-rr-settings-sliders fi-rr"></i>
                        <i class="fi fi-sr-settings-sliders fi-sr"></i>
                       </span>
                       <span class="title">
                            Parametre
                       </span>
                    </a>
                </li>
            </ul>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                <div class="card card-sm pointer" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                    <div class="text-center" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                        <h6>Créer une tâche</h6>
                        <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-new-task" ><i class="fi fi-rr-plus"></i></a>
                    </div>
                    </a>
                </div>
            </a>
        </div>
        <img src="images/logoUjumbe.png" alt="" class="logo-app">
    </div>
</div>
