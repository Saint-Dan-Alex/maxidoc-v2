@extends('regidoc.layouts.layout-parametre')
@section('content')
    <div class="block-content-parametre content p-0 m-0">
        <div class="container-fluid px-lg-3 g-3 my-3">
            <div class="row g-lg-3 g-2">
                <div class="col-lg-12">
                    <h1 class="title-page">Organigramme</h1>
                    <p class="paragraph">
                        Setting and options for your application
                    </p>
                </div>
                <div class="col-lg-12">
                    <div class="row g-2">
                        <div class="col-lg-3 col-xl-2">
                            <ul class="mb-0 nav nav-tabs nav-lateral flex-column gap-2" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation"><button class="nav-link active" id="lieu-tab"
                                        data-bs-toggle="tab" data-bs-target="#lieu" type="button" role="tab"
                                        aria-controls="lieu" aria-selected="true">Lieu d'affectation</button></li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="direction-tab"
                                        data-bs-toggle="tab" data-bs-target="#direction" type="button" role="tab"
                                        aria-controls="activites" aria-selected="false" tabindex="-1">Directions</button>
                                </li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="section-tab"
                                        data-bs-toggle="tab" data-bs-target="#section" type="button" role="edit"
                                        aria-controls="section" aria-selected="false" tabindex="-1">Sections</button></li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="secretariat-tab" data-bs-toggle="tab"
                                        data-bs-target="#secretariat" type="button" role="edit"
                                        aria-controls="secretariat" aria-selected="false"
                                        tabindex="-1">Secretariat</button>
                                </li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="division-tab"
                                        data-bs-toggle="tab" data-bs-target="#division" type="button" role="edit"
                                        aria-controls="division" aria-selected="false" tabindex="-1">Division</button>
                                </li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="assistanat-tab"
                                        data-bs-toggle="tab" data-bs-target="#assistanat" type="button" role="edit"
                                        aria-controls="assistanat" aria-selected="false" tabindex="-1">Assistanat</button>
                                </li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="service-tab"
                                        data-bs-toggle="tab" data-bs-target="#service" type="button" role="edit"
                                        aria-controls="service" aria-selected="false" tabindex="-1">Service</button>
                                </li>
                                <li class="nav-item" role="presentation"><button class="nav-link" id="fonction-tab"
                                        data-bs-toggle="tab" data-bs-target="#fonction" type="button" role="edit"
                                        aria-controls="fonction" aria-selected="false" tabindex="-1">Fonction</button>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-9 col-xl-10">
                            <div id="myTabContent" class="tab-content">
                                <div id="lieu" class="tab-pane  show active" role="tabpanel"
                                    aria-labelledby="lieu-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Lieu d'affection
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-lieu">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#editLieu">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteLieu">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Direction Régionale de Kinshasa-Est
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#editLieu">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteLieu">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="direction" class="tab-pane" role="tabpanel" aria-labelledby="direction-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Direction
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-direction">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Code</th>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Lieu</th>
                                                        <th scope="col">Responsable</th>
                                                        <th scope="col">Responsable Adjoint</th>
                                                        <th scope="col">Nbr Agents</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>DC</td>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction Générale
                                                        </td>
                                                        <td>
                                                            Merlin Kamasatua
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            3
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-direction">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-direction">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>DC</td>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction Générale
                                                        </td>
                                                        <td>
                                                            Merlin Kamasatua
                                                        </td>
                                                        <td></td>
                                                        <td>
                                                            3
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-direction">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-direction">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="section" class="tab-pane" role="tabpanel" aria-labelledby="direction-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Section
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-section">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Service</th>
                                                        <th scope="col">Responsable</th>
                                                        <th scope="col">Nbre Employé</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Corps des assistants au contrôle
                                                        </td>
                                                        <td>
                                                            Herve Kinsala
                                                        </td>
                                                        <td>
                                                            0
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-section">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-section">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Corps des assistants au contrôle
                                                        </td>
                                                        <td>
                                                            Herve Kinsala
                                                        </td>
                                                        <td>
                                                            0
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-section">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-section">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="secretariat" class="tab-pane" role="tabpanel"
                                    aria-labelledby="secretariat-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Secretariat
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-secretariat">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Direction</th>
                                                        <th scope="col">Responsable</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Yasmine Kabengele
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-secretariat">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-secretariat">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Yasmine Kabengele
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-secretariat">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-secretariat">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="division" class="tab-pane" role="tabpanel" aria-labelledby="division-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Division
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-division">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Direction</th>
                                                        <th scope="col">Responsable</th>
                                                        <th scope="col">Nbe Services</th>
                                                        <th scope="col">Nbe Agents</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>Direction de l'audit interne et inspection </td>
                                                        <td>
                                                            Herve Kinsala
                                                        </td>
                                                        <td>
                                                            0
                                                        </td>
                                                        <td>
                                                            5
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-division">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-division">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>Direction de l'audit interne et inspection </td>
                                                        <td>
                                                            Herve Kinsala
                                                        </td>
                                                        <td>
                                                            0
                                                        </td>
                                                        <td>
                                                            5
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-division">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-division">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="assistanat" class="tab-pane" role="tabpanel" aria-labelledby="assistanat-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Assistanat
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-assistanat">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Direction</th>
                                                        <th scope="col">Direction</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Kuedisala Caleb
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-assistanat">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-assistanat">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Kuedisala Caleb
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-assistanat">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-assistanat">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="service" class="tab-pane" role="tabpanel" aria-labelledby="service-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Service
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-service">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Direction</th>
                                                        <th scope="col">Division</th>
                                                        <th scope="col">Responsable</th>
                                                        <th scope="col">Nbe agents</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Yasmine Kabengele
                                                        </td>
                                                        <td>
                                                            3
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-service">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-service">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Yasmine Kabengele
                                                        </td>
                                                        <td>
                                                            3
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-service">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-service">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="fonction" class="tab-pane" role="tabpanel" aria-labelledby="fonction-tab">
                                    <div class="card card-table">
                                        <div class="row g-lg-3 g-2 align-items-center">
                                            <div class="col-lg-5">
                                                <h5 class="title-card mb-0">
                                                    Fonction
                                                </h5>
                                            </div>
                                            <div class="col-lg-6 ms-auto">
                                                <div class="d-flex align-items-center ">
                                                    <input type="text" class="form-control me-2 input-search-card"
                                                        placeholder="Recherche" style="border:none;" wire:model="search">
                                                    <div class="dropdown">
                                                        <button class="btn btn-filter" id="dropdownMenuButton1"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                                height="512">
                                                                <path
                                                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end "
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(1)">Par
                                                                    défaut</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(2)">A -
                                                                    Z</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(3)">Z -
                                                                    A</a></li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(4)">Date
                                                                    d'ajout</a>
                                                            </li>
                                                            <li><a class="dropdown-item" href="javascript:void(0)"
                                                                    wire:click="changeFilter(5)">Date de
                                                                    modification</a></li>
                                                        </ul>
                                                    </div>
                                                    <a href="#" class="btn btn-add ms-lg-3" data-bs-toggle="modal"
                                                        style="flex: 0 0 auto" data-bs-target="#modal-new-fonction">
                                                        Ajouter
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Nom</th>
                                                        <th scope="col">Service</th>
                                                        <th scope="col">Direction</th>
                                                        <th scope="col">Division</th>
                                                        <th scope="col">Section</th>
                                                        <th scope="col">Nbe Agents</th>
                                                        <th scope="col" class="text-end">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction Générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            3
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-focntion">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-fonction">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Direction Générale </td>
                                                        <td>
                                                            Direction Générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            Direction générale
                                                        </td>
                                                        <td>
                                                            3
                                                        </td>
                                                        <td>
                                                            <div
                                                                class="d-flex align-items-center justify-content-end btns-action-table">
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#edit-focntion">
                                                                    <i class="fi fi-rr-pencil"></i>
                                                                    <div class="tooltip-btn">Editer</div>
                                                                </a>
                                                                <a href="#" class="btn" data-bs-toggle="modal"
                                                                    data-bs-target="#delete-fonction">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour lieu --}}
        <div class="modal fade" id="modal-new-lieu" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter un lieu</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="http://127.0.0.1:8000/systemes/lieux" method="POST">
                            <input type="hidden" name="_token" value="zrSglQuHstQbpUyXzaBjQVuLo5iioa4kY4AVvgIb">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control" placeholder="Nom du lieu"
                                        required="">
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add mt-0 w-50">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editLieu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier le lieu</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="http://127.0.0.1:8000/systemes/lieux" method="POST">
                            <input type="hidden" name="_token" value="zrSglQuHstQbpUyXzaBjQVuLo5iioa4kY4AVvgIb">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control" placeholder="Nom du lieu"
                                        required="">
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add mt-0 w-50">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="deleteLieu" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer ce lieu ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour lieu --}}

        {{-- Modal pour direction --}}
        <div class="modal fade" id="modal-new-direction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter une Direction</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="#" method="POST">
                            <input type="hidden" name="_token" value="Cyx44XHjOrQdrvvJD0RaT0bXyMzhz4WAy4o2KThy">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="Code"
                                        required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom du Direction" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Lieu</label>
                                    <select name="lieu_id" class="form-control select2Bis select2-hidden-accessible"
                                        required="" data-placeholder="Selectionner" data-select2-id="65"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="67">Selectionnez le lieu</option>
                                        <option value="1">
                                            Direction Régionale de Kinshasa-Ouest
                                        </option>
                                        <option value="2">
                                            Direction Régionale de Kinshasa-Est
                                        </option>
                                        <option value="3">
                                            Direction Régionale du Kongo Central
                                        </option>
                                        <option value="4">
                                            Direction Régionale de la Grande Orientale
                                        </option>
                                        <option value="5">
                                            Direction Régionale du Sud-Kivu
                                        </option>
                                        <option value="6">
                                            Direction Régionale du Nord-Kivu
                                        </option>
                                        <option value="7">
                                            Direction Régionale du Grand Kasai Oriental
                                        </option>
                                        <option value="8">
                                            Direction Régionale du Grand Bandundu
                                        </option>
                                        <option value="9">
                                            Direction Régionale du Grand Kasai Occidental
                                        </option>
                                        <option value="10">
                                            Direction Régionale de Maniema
                                        </option>
                                        <option value="11">
                                            Direction Régionale du Grand Katanga
                                        </option>
                                        <option value="12">
                                            Direction Générale
                                        </option>
                                        <option value="13">
                                            Direction Régionale de l'équateur
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2 select2-hidden-accessible"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true">


                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable Ajoint</label>
                                    <select name="adjoint_id" class="form-control select2 select2-hidden-accessible"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="3" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-direction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier la direction</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="#" method="POST">
                            <input type="hidden" name="_token" value="Cyx44XHjOrQdrvvJD0RaT0bXyMzhz4WAy4o2KThy">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="Code"
                                        required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom du Direction" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Lieu</label>
                                    <select name="lieu_id" class="form-control select2Bis select2-hidden-accessible"
                                        required="" data-placeholder="Selectionner" data-select2-id="65"
                                        tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="67">Selectionnez le lieu</option>
                                        <option value="1">
                                            Direction Régionale de Kinshasa-Ouest
                                        </option>
                                        <option value="2">
                                            Direction Régionale de Kinshasa-Est
                                        </option>
                                        <option value="3">
                                            Direction Régionale du Kongo Central
                                        </option>
                                        <option value="4">
                                            Direction Régionale de la Grande Orientale
                                        </option>
                                        <option value="5">
                                            Direction Régionale du Sud-Kivu
                                        </option>
                                        <option value="6">
                                            Direction Régionale du Nord-Kivu
                                        </option>
                                        <option value="7">
                                            Direction Régionale du Grand Kasai Oriental
                                        </option>
                                        <option value="8">
                                            Direction Régionale du Grand Bandundu
                                        </option>
                                        <option value="9">
                                            Direction Régionale du Grand Kasai Occidental
                                        </option>
                                        <option value="10">
                                            Direction Régionale de Maniema
                                        </option>
                                        <option value="11">
                                            Direction Régionale du Grand Katanga
                                        </option>
                                        <option value="12">
                                            Direction Générale
                                        </option>
                                        <option value="13">
                                            Direction Régionale de l'équateur
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2 select2-hidden-accessible"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true">


                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable Ajoint</label>
                                    <select name="adjoint_id" class="form-control select2 select2-hidden-accessible"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="3" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>

                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-direction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer cette direction ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour direction --}}

        {{-- Modal pour section --}}
        <div class="modal fade" id="modal-new-section" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter une Section</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="#" method="POST">
                            <input type="hidden" name="_token" value="Cyx44XHjOrQdrvvJD0RaT0bXyMzhz4WAy4o2KThy">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom de la section" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Service</label>
                                    <select name="service_id" class="form-control select2Bis select2-hidden-accessible"
                                        required="" data-select2-id="23" tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="25">Selectionnez un service</option>
                                        <option value="1">Assistants DG/DGA</option>
                                        <option value="2">Secrétariats DG/DGA</option>
                                        <option value="3">Service Courrier</option>
                                        <option value="4">Secrétariat CODIR</option>
                                        <option value="5">Service contentieux</option>
                                        <option value="6">Service études et documentation juridique</option>
                                        <option value="7">Service Communication</option>
                                        <option value="8">Service protocole</option>
                                        <option value="9">Service organisation et procédures</option>
                                        <option value="10">Service études économiques et financières</option>
                                        <option value="11">Service contrôle de gestion</option>
                                        <option value="12">Service de données d'entreprise</option>
                                        <option value="13">Service sécurité physique</option>
                                        <option value="14">Service sécurité au travail.</option>
                                        <option value="15">Service Brigade Anti-fraude</option>
                                        <option value="16">Service Brigade Anti-fraude</option>
                                        <option value="17">Secrétariats DG/DGA</option>
                                        <option value="18">Service atelier central</option>
                                        <option value="19">Service qualité de l'eau</option>
                                        <option value="20">Service maintenance et GMAO</option>
                                        <option value="21">Service des intrants</option>
                                        <option value="22">Service eaux souterraines</option>
                                        <option value="23">Service eaux de surface</option>
                                        <option value="24">Service de Distribution</option>
                                        <option value="25">Corps des assistants au contrôle</option>
                                        <option value="26">Service de la Brigade Anti-fraude Secrétariat</option>
                                        <option value="27">Service de l'Exploitation</option>
                                        <option value="28">Direction Générale</option>
                                        <option value="29">Service Administration du personnel</option>
                                        <option value="30">Service Rémunération du personnel et Av. sociaux</option>
                                        <option value="31">Service Proc. Discipl., Réclamation &amp; Partenaires
                                            Sociaux</option>
                                        <option value="32">Service Gest. Prév. des Empl. et des Compétences (GPEC)
                                        </option>
                                        <option value="33">Service Formation</option>
                                        <option value="34">Service Gestion Hospitalière</option>
                                        <option value="35">Service Pharmacie</option>
                                        <option value="36">Service CRM Réferences</option>
                                        <option value="37">Service Hospitalisation Kinshasa</option>
                                        <option value="38">Service Facturation</option>
                                        <option value="39">Service Clientèle et Marketing</option>
                                        <option value="40">Service Recouvrement et Contentieux</option>
                                        <option value="41">Service Recouvrement Privé</option>
                                        <option value="42">Service Recouvrements I.O</option>
                                        <option value="43">Service Etudes Economiques et Financières</option>
                                        <option value="44">Service Planification et Contrôle des Projets</option>
                                        <option value="45">Service Gestion Projets</option>
                                        <option value="46">Service Travaux Génie Civil et Réseau</option>
                                        <option value="47">Service Travaux Forages et Sources</option>
                                        <option value="48">Service Resource en Eau</option>
                                        <option value="49">Service des Etudes de Génie</option>
                                        <option value="50">Service Cartographie et Dessin</option>
                                        <option value="51">Service Intendance</option>
                                        <option value="52">Service Achats Locaux</option>
                                        <option value="53">Section Analyse et Programmation</option>
                                        <option value="54">Service Gestion Stocks et Magasin</option>
                                        <option value="55">Service Réseaux Informatiques et Télécoms</option>
                                        <option value="56">Service Parc Informatique</option>
                                        <option value="57">Service Administration Base des données et Archives
                                        </option>
                                        <option value="58">Service Etudes, Développement Digital et Cybersécurité
                                        </option>
                                        <option value="59">Service Comptabilité Générale</option>
                                        <option value="60">Service Fiscalité</option>
                                        <option value="61">Service CAG</option>
                                        <option value="62">Service Comptabilité Immob.</option>
                                        <option value="63">Service Planification Financière</option>
                                        <option value="64">Service Opérations Financières</option>
                                        <option value="65">Service Budget d'Exploitation et d'Investissement</option>
                                        <option value="66">Service Budget de Trésorerie</option>
                                        <option value="67">service technique</option>
                                        <option value="68">Service Administratif et Financier</option>
                                        <option value="69">Service comptage</option>
                                        <option value="70">Service Maintenance Réseau</option>
                                        <option value="71">Service Expertise Groupe Electrogène</option>
                                        <option value="72">Service assistance aux utilisateurs</option>
                                        <option value="73">Service CMR Référence</option>
                                        <option value="74">Service comptabilité Analytique de gestion</option>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2 select2-hidden-accessible"
                                        required="" data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true">

                                </div>
                                <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                </div>

                                <div class="col-lg-12 ">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-section" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier la section</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="#" method="POST">
                            <input type="hidden" name="_token" value="Cyx44XHjOrQdrvvJD0RaT0bXyMzhz4WAy4o2KThy">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom de la section" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Service</label>
                                    <select name="service_id" class="form-control select2Bis select2-hidden-accessible"
                                        required="" data-select2-id="23" tabindex="-1" aria-hidden="true">
                                        <option value="" data-select2-id="25">Selectionnez un service</option>
                                        <option value="1">Assistants DG/DGA</option>
                                        <option value="2">Secrétariats DG/DGA</option>
                                        <option value="3">Service Courrier</option>
                                        <option value="4">Secrétariat CODIR</option>
                                        <option value="5">Service contentieux</option>
                                        <option value="6">Service études et documentation juridique</option>
                                        <option value="7">Service Communication</option>
                                        <option value="8">Service protocole</option>
                                        <option value="9">Service organisation et procédures</option>
                                        <option value="10">Service études économiques et financières</option>
                                        <option value="11">Service contrôle de gestion</option>
                                        <option value="12">Service de données d'entreprise</option>
                                        <option value="13">Service sécurité physique</option>
                                        <option value="14">Service sécurité au travail.</option>
                                        <option value="15">Service Brigade Anti-fraude</option>
                                        <option value="16">Service Brigade Anti-fraude</option>
                                        <option value="17">Secrétariats DG/DGA</option>
                                        <option value="18">Service atelier central</option>
                                        <option value="19">Service qualité de l'eau</option>
                                        <option value="20">Service maintenance et GMAO</option>
                                        <option value="21">Service des intrants</option>
                                        <option value="22">Service eaux souterraines</option>
                                        <option value="23">Service eaux de surface</option>
                                        <option value="24">Service de Distribution</option>
                                        <option value="25">Corps des assistants au contrôle</option>
                                        <option value="26">Service de la Brigade Anti-fraude Secrétariat</option>
                                        <option value="27">Service de l'Exploitation</option>
                                        <option value="28">Direction Générale</option>
                                        <option value="29">Service Administration du personnel</option>
                                        <option value="30">Service Rémunération du personnel et Av. sociaux</option>
                                        <option value="31">Service Proc. Discipl., Réclamation &amp; Partenaires
                                            Sociaux</option>
                                        <option value="32">Service Gest. Prév. des Empl. et des Compétences (GPEC)
                                        </option>
                                        <option value="33">Service Formation</option>
                                        <option value="34">Service Gestion Hospitalière</option>
                                        <option value="35">Service Pharmacie</option>
                                        <option value="36">Service CRM Réferences</option>
                                        <option value="37">Service Hospitalisation Kinshasa</option>
                                        <option value="38">Service Facturation</option>
                                        <option value="39">Service Clientèle et Marketing</option>
                                        <option value="40">Service Recouvrement et Contentieux</option>
                                        <option value="41">Service Recouvrement Privé</option>
                                        <option value="42">Service Recouvrements I.O</option>
                                        <option value="43">Service Etudes Economiques et Financières</option>
                                        <option value="44">Service Planification et Contrôle des Projets</option>
                                        <option value="45">Service Gestion Projets</option>
                                        <option value="46">Service Travaux Génie Civil et Réseau</option>
                                        <option value="47">Service Travaux Forages et Sources</option>
                                        <option value="48">Service Resource en Eau</option>
                                        <option value="49">Service des Etudes de Génie</option>
                                        <option value="50">Service Cartographie et Dessin</option>
                                        <option value="51">Service Intendance</option>
                                        <option value="52">Service Achats Locaux</option>
                                        <option value="53">Section Analyse et Programmation</option>
                                        <option value="54">Service Gestion Stocks et Magasin</option>
                                        <option value="55">Service Réseaux Informatiques et Télécoms</option>
                                        <option value="56">Service Parc Informatique</option>
                                        <option value="57">Service Administration Base des données et Archives
                                        </option>
                                        <option value="58">Service Etudes, Développement Digital et Cybersécurité
                                        </option>
                                        <option value="59">Service Comptabilité Générale</option>
                                        <option value="60">Service Fiscalité</option>
                                        <option value="61">Service CAG</option>
                                        <option value="62">Service Comptabilité Immob.</option>
                                        <option value="63">Service Planification Financière</option>
                                        <option value="64">Service Opérations Financières</option>
                                        <option value="65">Service Budget d'Exploitation et d'Investissement</option>
                                        <option value="66">Service Budget de Trésorerie</option>
                                        <option value="67">service technique</option>
                                        <option value="68">Service Administratif et Financier</option>
                                        <option value="69">Service comptage</option>
                                        <option value="70">Service Maintenance Réseau</option>
                                        <option value="71">Service Expertise Groupe Electrogène</option>
                                        <option value="72">Service assistance aux utilisateurs</option>
                                        <option value="73">Service CMR Référence</option>
                                        <option value="74">Service comptabilité Analytique de gestion</option>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2 select2-hidden-accessible"
                                        required="" data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true">

                                </div>
                                <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                </div>

                                <div class="col-lg-12 ">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-section" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer cette section ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour section --}}

        {{-- Modal pour secretariat --}}
        <div class="modal fade" id="modal-new-secretariat" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter une secretariat</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="#" method="POST">
                            <input type="hidden" name="_token" value="Cyx44XHjOrQdrvvJD0RaT0bXyMzhz4WAy4o2KThy">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control"
                                        placeholder="Nom du secretariat" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id"
                                        class="form-control select2Bis select2-hidden-accessible" required=""
                                        data-placeholder="Selectionner" data-select2-id="33" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="" data-select2-id="35"></option>
                                        <option value="1"> Direction générale </option>
                                        <option value="2"> Secrétariat Général </option>
                                        <option value="3"> Direction des Stratégies et Contrôle de Gestion </option>
                                        <option value="4"> Direction de l'audit interne et inspection </option>
                                        <option value="5"> Direction de la Brigade Anti-fraude </option>
                                        <option value="6"> Direction de l'exploitation </option>
                                        <option value="7"> Direction Commerciale </option>
                                        <option value="8"> Direction des Projets et Travaux </option>
                                        <option value="9"> Direction des Approvisionnements et Logistique </option>
                                        <option value="11"> Direction Financière </option>
                                        <option value="12"> Direction des Ressources Humaines </option>
                                        <option value="13"> Direction de la Digitalisation et Gestion de l'Information
                                        </option>
                                        <option value="19"> Direction Régionale de Kinshasa-Ouest </option>
                                        <option value="20"> Direction Régionale de Kinshasa-Est </option>
                                        <option value="21"> Direction Régionale de Kongo Central </option>
                                        <option value="22"> Direction Régionale de la Grande Orientale </option>
                                        <option value="23"> Direction Régionale du Sud-Kivu </option>
                                        <option value="24"> Direction Régionale du Nord-Kivu </option>
                                        <option value="25"> Direction Régionale du Grand Kasai-Oriental </option>
                                        <option value="26"> Direction Régionale du Grand Bandundu </option>
                                        <option value="27"> Direction Régionale du Grand Kasai-Occident </option>
                                        <option value="28"> Direction Régionale de Maniema </option>
                                        <option value="29"> Direction Régionale du Grand Katanga </option>
                                        <option value="30"> Direction Régionale de l'équateur </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2 select2-hidden-accessible"
                                        required="" data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <label for="dg">Secretaire DG</label>
                                            <input type="radio" name="for" id="dg" value="1">
                                        </div>
                                        <div>
                                            <label for="dga">Secretaire DGA</label>
                                            <input type="radio" name="for" id="dga" value="2">
                                        </div>
                                        <div>
                                            <label for="direction">Secretaire Direction</label>
                                            <input type="radio" name="for" id="direction" value="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-secretariat" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier le secretariat</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="#" method="POST">
                            <input type="hidden" name="_token" value="Cyx44XHjOrQdrvvJD0RaT0bXyMzhz4WAy4o2KThy">
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control"
                                        placeholder="Nom du secretariat" required="">
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id"
                                        class="form-control select2Bis select2-hidden-accessible" required=""
                                        data-placeholder="Selectionner" data-select2-id="33" tabindex="-1"
                                        aria-hidden="true">
                                        <option value="" data-select2-id="35"></option>
                                        <option value="1"> Direction générale </option>
                                        <option value="2"> Secrétariat Général </option>
                                        <option value="3"> Direction des Stratégies et Contrôle de Gestion </option>
                                        <option value="4"> Direction de l'audit interne et inspection </option>
                                        <option value="5"> Direction de la Brigade Anti-fraude </option>
                                        <option value="6"> Direction de l'exploitation </option>
                                        <option value="7"> Direction Commerciale </option>
                                        <option value="8"> Direction des Projets et Travaux </option>
                                        <option value="9"> Direction des Approvisionnements et Logistique </option>
                                        <option value="11"> Direction Financière </option>
                                        <option value="12"> Direction des Ressources Humaines </option>
                                        <option value="13"> Direction de la Digitalisation et Gestion de l'Information
                                        </option>
                                        <option value="19"> Direction Régionale de Kinshasa-Ouest </option>
                                        <option value="20"> Direction Régionale de Kinshasa-Est </option>
                                        <option value="21"> Direction Régionale de Kongo Central </option>
                                        <option value="22"> Direction Régionale de la Grande Orientale </option>
                                        <option value="23"> Direction Régionale du Sud-Kivu </option>
                                        <option value="24"> Direction Régionale du Nord-Kivu </option>
                                        <option value="25"> Direction Régionale du Grand Kasai-Oriental </option>
                                        <option value="26"> Direction Régionale du Grand Bandundu </option>
                                        <option value="27"> Direction Régionale du Grand Kasai-Occident </option>
                                        <option value="28"> Direction Régionale de Maniema </option>
                                        <option value="29"> Direction Régionale du Grand Katanga </option>
                                        <option value="30"> Direction Régionale de l'équateur </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2 select2-hidden-accessible"
                                        required="" data-placeholder="Selectionner"
                                        data-get-items-route="http://127.0.0.1:8000/ajax/types/get/all/agents"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-select2-id="1" tabindex="-1"
                                        aria-hidden="true">
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <label for="dg">Secretaire DG</label>
                                            <input type="radio" name="for" id="dg" value="1">
                                        </div>
                                        <div>
                                            <label for="dga">Secretaire DGA</label>
                                            <input type="radio" name="for" id="dga" value="2">
                                        </div>
                                        <div>
                                            <label for="direction">Secretaire Direction</label>
                                            <input type="radio" name="for" id="direction" value="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-secretariat" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer cette section ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour secretariat --}}

        {{-- Modal pour assistanat --}}
        <div class="modal fade" id="modal-new-assistanat" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter une assistant</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="{{ route('regidoc.assistants.store') }}" method="POST">
                            @csrf
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control"
                                        placeholder="Nom du assistant" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionnez le département">
                                        <option value=""></option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        {{-- <option value="">Selectionnez le responsable</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                    @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <label for="dg">Assistant DG</label>
                                            <input type="radio" name="for" id="dg" value="1">
                                        </div>
                                        <div>
                                            <label for="dga">Assistant DGA</label>
                                            <input type="radio" name="for" id="dga" value="2">
                                        </div>
                                        <div>
                                            <label for="direction">Assistant Direction</label>
                                            <input type="radio" name="for" id="direction" value="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button class="btn btn-add">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-assistanat" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier l'assistanat</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="{{ route('regidoc.assistants.store') }}" method="POST">
                            @csrf
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control"
                                        placeholder="Nom du assistant" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionnez le département">
                                        <option value=""></option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        {{-- <option value="">Selectionnez le responsable</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                    @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <label for="dg">Assistant DG</label>
                                            <input type="radio" name="for" id="dg" value="1">
                                        </div>
                                        <div>
                                            <label for="dga">Assistant DGA</label>
                                            <input type="radio" name="for" id="dga" value="2">
                                        </div>
                                        <div>
                                            <label for="direction">Assistant Direction</label>
                                            <input type="radio" name="for" id="direction" value="3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button class="btn btn-add">Ajouter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-assistanat" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer cet assistanat ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour assistanat --}}

        {{-- Modal pour division --}}
        <div class="modal fade" id="modal-new-division" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter une division</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="{{ route('regidoc.divisions.store') }}" method="POST">
                            @csrf
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom du division" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionner">
                                        <option value=""></option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12" wire:ignore>
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        {{-- <option value="">Selectionnez le responsable</option> --}}
                                        {{-- @foreach ($users as $user)
                                            <option value="{{ $user->agent?->id }}">
                                                {{ $user->agent?->prenom . ' ' . $user->agent?->nom }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                </div> --}}
                                {{-- <div class="col-lg-12">
                                    <label for="">Statut</label>
                                    <select name="statut_id" class="form-control" required>
                                        <option value="">Selectionnez le statut</option>
                                        @foreach ($statuts as $statut)
                                            <option value="{{ $statut->id }}">
                                                {{ $statut->libelle }} </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-division" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier la division</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="{{ route('regidoc.divisions.store') }}" method="POST">
                            @csrf
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom du division" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionner">
                                        <option value=""></option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12" wire:ignore>
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        {{-- <option value="">Selectionnez le responsable</option> --}}
                                        {{-- @foreach ($users as $user)
                                            <option value="{{ $user->agent?->id }}">
                                                {{ $user->agent?->prenom . ' ' . $user->agent?->nom }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                </div> --}}
                                {{-- <div class="col-lg-12">
                                    <label for="">Statut</label>
                                    <select name="statut_id" class="form-control" required>
                                        <option value="">Selectionnez le statut</option>
                                        @foreach ($statuts as $statut)
                                            <option value="{{ $statut->id }}">
                                                {{ $statut->libelle }} </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-division" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer cette division ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour division --}}

        {{-- Modal pour service --}}
        <div class="modal fade" id="modal-new-service" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter un service</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="{{ route('regidoc.services.store') }}" method="POST">
                            @csrf
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom du service" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionnez le Division">
                                        <option value=""></option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Division</label>
                                    <select name="division_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionnez le Division">
                                        <option value=""></option>
                                        {{-- @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}"> {{ $division->libelle }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        {{-- <option value="">Selectionnez le responsable</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->agent?->id }}">
                                                {{ $user->agent?->prenom . ' ' . $user->agent?->nom }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Statut</label>
                                    <select name="statut_id" class="form-control" required>
                                        <option value="">Selectionnez le statut</option>
                                        @foreach ($statuts as $statut)
                                            <option value="{{ $statut->id }}">
                                                {{ $statut->libelle }} </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-service" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier le service</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form action="{{ route('regidoc.services.store') }}" method="POST">
                            @csrf
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        placeholder="Nom du service" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionnez le Division">
                                        <option value=""></option>
                                        {{-- @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                    @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Division</label>
                                    <select name="division_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionnez le Division">
                                        <option value=""></option>
                                        {{-- @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"> {{ $division->libelle }} </option>
                                    @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        {{-- <option value="">Selectionnez le responsable</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->agent?->id }}">
                                            {{ $user->agent?->prenom . ' ' . $user->agent?->nom }} </option>
                                    @endforeach --}}
                                    </select>
                                </div>
                                {{-- <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Statut</label>
                                <select name="statut_id" class="form-control" required>
                                    <option value="">Selectionnez le statut</option>
                                    @foreach ($statuts as $statut)
                                        <option value="{{ $statut->id }}">
                                            {{ $statut->libelle }} </option>
                                    @endforeach
                                </select>
                            </div> --}}
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-service" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer ce service ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour service --}}

        {{-- Modal pour fonction --}}
        <div class="modal fade" id="modal-new-fonction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Ajouter une fonction</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form wire:submit.prevent='save'>
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" wire:model='titre' class="form-control"
                                        placeholder="Nom de la fonction" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" wire:model='direction_id' class="form-control"
                                        required>
                                        <option value="">Selectionnez la direction</option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}">
                                                {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Division</label>
                                    <select name="division_id" wire:model='division_id' class="form-control">
                                        {{-- <option value="">Selectionnez la division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">
                                                {{ $division->libelle }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Service</label>
                                    <select name="service_id" wire:model='service_id' class="form-control">
                                        {{-- <option value="">Selectionnez le service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">
                                                {{ $service->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Section</label>
                                    <select name="section_id" wire:model='section_id' class="form-control">
                                        <option value="">Selectionnez la section</option>
                                        {{-- @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">
                                                {{ $section->titre }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" wire:model='description' class="form-control" cols="30" rows="5"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0" type="submit">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-fonction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier la fonction</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-1">
                        <form wire:submit.prevent='save'>
                            <div class="form-group row g-lg-3 g-3">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" wire:model='titre' class="form-control"
                                        placeholder="Nom de la fonction" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" wire:model='direction_id' class="form-control"
                                        required>
                                        <option value="">Selectionnez la direction</option>
                                        {{-- @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}">
                                                {{ $direction->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Division</label>
                                    <select name="division_id" wire:model='division_id' class="form-control">
                                        {{-- <option value="">Selectionnez la division</option>
                                        @foreach ($divisions as $division)
                                            <option value="{{ $division->id }}">
                                                {{ $division->libelle }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Service</label>
                                    <select name="service_id" wire:model='service_id' class="form-control">
                                        {{-- <option value="">Selectionnez le service</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}">
                                                {{ $service->titre }} </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Section</label>
                                    <select name="section_id" wire:model='section_id' class="form-control">
                                        <option value="">Selectionnez la section</option>
                                        {{-- @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">
                                                {{ $section->titre }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Description</label>
                                    <textarea name="description" wire:model='description' class="form-control" cols="30" rows="5"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <div class="d-flex gap-2 my-2">
                                        <button type="reset" class="btn btn-cansel w-50"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <button class="btn btn-add w-50 mt-0" type="submit">Ajouter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade modal-sm" id="delete-fonction" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="text-center">
                                    <h5 class="mb-0">Voulez-vous supprimer cette fonction ?</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 mb-2">
                                    <button type="reset" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button class="btn text-white btn-danger mt-0 w-50">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal pour fonction --}}
    </div>
@endsection

@section('scripts')
    <script>
        $('select.select2').each(function() {
            console.log($(this).data('get-items-route'));
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
                width: '100%',
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
                dropdownParent: $(this).parent()
            });

            $(this).on('select2:select', function(e) {
                var data = e.params.data;

                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            $(this).on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',
                    false);
            });

            $(this).on('select2:selecting', function(e) {

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

        $('.select2Bis').each(function() {
            $(this).select2({
                placeholder: $(this).data('placeholder'),
                language: "fr",
                width: '100%',
                dropdownParent: $(this).parent()
            });
        });
    </script>
@endsection
