<div class="sidebar sidebar-mobile">
    <div class="close-menu">
        <span></span>
        <span></span>
        <i class="fi fi-rr-menu-burger"></i>
    </div>
    <div class="logo">
        <a href="/">
            <div class="block-logo">
                <img src="{{ asset('assets/regidoc/logo-regidoc.svg') }}" alt="">
                <img src="{{ asset('assets/images/logo-phar.ico') }}">
            </div>
        </a>
    </div>
    <div class="mb-auto content-sidebar">

        <div class="block-links ">
            <ul class="lists">
                <li>
                    <a href="{{ route('home') }}"
                        class="{{ session()->get('menu') == '0' ? 'active' : '' }} panelsession">
                        <span>
                            <i class="fi fi-rr-apps fi-rr"></i>
                            <i class="fi fi-sr-apps fi-sr"></i>
                        </span>
                        <span class="title">
                            Tableau de bord
                        </span>
                    </a>
                </li>
                <li class="link-hover">
                    <a href="#" class="{{ session()->get('menu') == '1' ? 'active' : '' }} link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-stocks" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-boxes fi-rr"></i>
                            <i class="fi fi-sr-boxes fi-sr"></i>
                        </span>
                        <span class="title">
                            Gestion de stocks
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-stocks">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('stocks.index') }}" class="panelsession">Accueil</a>
                                <a href="{{ route('categories.index') }}" class="panelsession">Catégories</a>
                                <a href="{{ route('fournisseurs.index') }}" class="panelsession">Partenairess</a>
                                <a href="{{ route('clients.index') }}" class="panelsession">Grands clients</a>
                                <a href="{{ route('lots.index') }}" class="panelsession">Lots</a>
                                <a href="{{ route('produits.index') }}" class="panelsession">Produits</a>
                                <a href="{{ route('quarantaines.index') }}" class="panelsession">Quarantaines</a>
                                <a href="{{ route('types.produits.index') }}" class="panelsession">Types de produit</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="{{ session()->get('menu') == '2' ? 'active' : '' }} panelsession link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-finances" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-coins fi-rr"></i>
                            <i class="fi fi-sr-coins fi-sr"></i>
                        </span>
                        <span class="title">
                            Finances
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-finances">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('finances.index') }}" class="panelsession">Accueil</a>
                                <a href="{{ route('finances.commandes.index') }}"
                                    class="panelsession">Approvisionnements</a>
                                <a href="{{ route('finances.ventes.index') }}" class="panelsession">Ventes</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="{{ session()->get('menu') == '5' ? 'active' : '' }} panelsession link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-comptabilites" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-money fi-rr"></i>
                            <i class="fi fi-sr-money fi-sr"></i>
                        </span>
                        <span class="title">
                            Comptabilités
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-comptabilites">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('comptabilites.index') }}" class="panelsession">Accueil</a>
                                <a href="{{ route('comptabilites.paies.index') }}" class="panelsession">Fiches de
                                    paie</a>
                                <a href="{{ route('comptabilites.note.credits.index') }}" class="panelsession">Note de
                                    credit</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="{{ session()->get('menu') == '7' ? 'active' : '' }} panelsession link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-budgets" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-wallet fi-rr"></i>
                            <i class="fi fi-sr-wallet fi-sr"></i>
                        </span>
                        <span class="title">
                            Budgets
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-budgets">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('comptabilites.budgets.index') }}" class="panelsession">Accueil</a>
                                <a href="{{ route('comptabilites.journals.index') }}" class="panelsession">Journal
                                    d'activités</a>
                                <a href="{{ route('comptabilites.revenu.report.index') }}"
                                    class="panelsession">Rapport de revenus</a>
                                <a href="{{ route('comptabilites.budgets.prevision.index') }}"
                                    class="panelsession">Budget prévisionnel</a>
                                <a href="{{ route('comptabilites.budgets.execution.index') }}"
                                    class="panelsession">Exécution budgetaire</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('taches.index') }}"
                        class="{{ session()->get('menu') == '3' ? 'active' : '' }} panelsession">
                        <span>
                            <i class="fi fi-rr-list-check fi-rr"></i>
                            <i class="fi fi-sr-list-check fi-sr"></i>
                        </span>
                        <span class="title">
                            Gestion de tâches
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="{{ session()->get('menu') == '4' ? 'active' : '' }} panelsession link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-rh" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-users-alt fi-rr"></i>
                            <i class="fi fi-sr-users-alt fi-sr"></i>
                        </span>
                        <span class="title">
                            RH
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-rh">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('rh.index') }}">Accueil</a>
                                <a href="{{ route('rh.user.index') }}" class="panelsession">Personnels</a>
                                <a href="{{ route('rh.contrat.index') }}" class="panelsession">Contrats</a>
                                <a href="{{ route('rh.conges.index') }}" class="panelsession">Congés</a>
                                <a href="{{ route('rh.services.index') }}" class="panelsession">Services</a>
                                <a href="{{ route('rh.plannings.index') }}" class="panelsession">Plannings</a>
                                <a href="{{ route('rh.pointages.index') }}" class="panelsession">Pointages</a>
                                <a href="{{ route('rh.postes.index') }}" class="panelsession">Organigrammes</a>
                                {{-- <a href="{{ route('rh.absences.index') }}" class="panelsession">Absences</a> --}}
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="{{ session()->get('menu') == '6' ? 'active' : '' }} panelsession link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-commissions" aria-expanded="false"
                        aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-chart-area fi-rr"></i>
                            <i class="fi fi-sr-chart-area fi-sr"></i>
                        </span>
                        <span class="title">
                            Commissions
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-commissions">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('commissions.index') }}" class="panelsession">Accueil</a>
                                <a href="{{ route('commissions.delegue') }}" class="panelsession">Commerciaux</a>
                                <a href="{{ route('commissions.etablissements') }}"
                                    class="panelsession">Etablissements</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="#" class="{{ session()->get('menu') == '9' ? 'active' : '' }} panelsession link"
                        data-bs-toggle="collapse" data-bs-target="#collapseExample-all-configurations"
                        aria-expanded="false" aria-controls="collapseExample">
                        <span>
                            <i class="fi fi-rr-settings fi-rr"></i>
                            <i class="fi fi-sr-settings fi-sr"></i>
                        </span>
                        <span class="title">
                            Configurations
                        </span>
                        <i class="fi fi-rr-angle-down arrow"></i>
                    </a>
                    <div class="collapse" id="collapseExample-all-configurations">
                        <div class="card-body">
                            <div class="block-drop-list">
                                <a href="{{ route('comptabilites.budget.categories.besoin.index') }}"
                                    class="panelsession">Catégories du besoin</a>
                                <a href="{{ route('configurations.index') }}"
                                    class="panelsession">Conditionnements</a>
                                <a href="{{ route('comptabilites.mode.paiements.index') }}"
                                    class="panelsession">Modes de paiement</a>
                                <a href="{{ route('comptabilites.imposables.index') }}" class="panelsession">Charges
                                    imposables</a>
                                <a href="{{ route('comptabilites.primes.index') }}" class="panelsession">Primes</a>
                                <a href="{{ route('comptabilites.charge.sociales.index') }}"
                                    class="panelsession">Charges
                                    sociales</a>
                                <a href="{{ route('rh.typecontrat.index') }}" class="panelsession">Types de
                                    contrat</a>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a href="{{ route('rh.about.index') }}"
                        class="{{ session()->get('menu') == '8' ? 'active' : '' }} panelsession">
                        <span>
                            <i class="fi fi-rr-info fi-rr"></i>
                            <i class="fi fi-sr-info fi-sr"></i>
                        </span>
                        <span class="title">
                            A-propos
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="block-logout">
        <div class="icon-info">
            <i class="fi fi-rr-info"></i>
        </div>
        <div class="text-infos">
            <p>© MaxiDoc {{ now()->format('Y') }}</p>
            <p>Developed by <a href="https://www.newtech-rdc.net" target="_blank">Newtech consulting</a></p>
        </div>
    </div>
    <div class="tooltip-lg">
        Tooltip
    </div>
</div>
