@extends('regidoc.layouts.master')

@section('content')
    <div class="container-fluid px-lg-3">
        <div class="row g-lg-3">
            <div class="col-lg-3">
                <h1 class="mb-lg-4 mb-3">Paramètres</h1>
                <ul class="nav nav-pills mb-3 nav-parametres flex-column" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-lieux-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-lieux" type="button" role="tab" aria-controls="pills-lieux"
                            aria-selected="true">Lieux d'affectation</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-direction-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-direction" type="button" role="tab" aria-controls="pills-direction"
                            aria-selected="false">Directions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-section-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-section" type="button" role="tab" aria-controls="pills-section"
                            aria-selected="false">Sections</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-secretariat-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-secretariat" type="button" role="tab"
                            aria-controls="pills-secretariat" aria-selected="false">Secretariat</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-division-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-division" type="button" role="tab" aria-controls="pills-division"
                            aria-selected="false">Divisions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-assistanat-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-assistanat" type="button" role="tab"
                            aria-controls="pills-assistanat" aria-selected="false">Assistanat</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-service-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-service" type="button" role="tab" aria-controls="pills-service"
                            aria-selected="false">Services</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-fonction-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-fonction" type="button" role="tab" aria-controls="pills-fonction"
                            aria-selected="false">Fonctions</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-grade-tab" data-bs-toggle="pill" data-bs-target="#pills-grade"
                            type="button" role="tab" aria-controls="pills-grade" aria-selected="false">Grades</button>
                    </li>
                </ul>

            </div>
            <div class="col-lg-9">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-lieux" role="tabpanel"
                        aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Lieux d'affectation</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>

                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
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
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="d-flex justify-content-end align-items-center">
                                        <a href="#" class="btn btn-add" data-bs-toggle="modal"
                                            data-bs-target="#modal-new-lieu" style="flex: 0 0 auto">
                                            Ajouter
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> Direction générale </td>
                                            <td> David Tshilumba </td>
                                            <td> </td>
                                            <td>
                                                <div class="d-flex align-items-center btns-action-table">

                                                    <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-direction-1"><i
                                                            class="fi fi-rr-pencil"></i>
                                                        Editer</a>
                                                    <form action="http://127.0.0.1:8000/systemes/directions/1"
                                                        method="POST" style="flex: 0 0 auto">
                                                        <input type="hidden" name="_token"
                                                            value="ODrcGnA03sDgQAahwuTzWkf5LvCnFLCDuhQFTs6q"> <input
                                                            type="hidden" name="_method" value="DELETE"> <button
                                                            type="submit" class="btn btn-danger  p-2"><i
                                                                class="fi fi-rr-trash"></i>
                                                            Supprimer</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-direction" role="tabpanel" aria-labelledby="pills-profile-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Directions</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
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
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="d-flex justify-content-end align-items-center">

                                        <a href="#" class="btn btn-add" data-bs-toggle="modal"
                                            data-bs-target="#modal-new-direction" style="flex: 0 0 auto">
                                            Ajouter
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> Direction générale </td>
                                            <td> Miguel Katemb </td>
                                            <td> </td>
                                            <td>
                                                <div class="d-flex align-items-center btns-action-table">

                                                    <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-direction-1"><i
                                                            class="fi fi-rr-pencil"></i>
                                                        Editer</a>
                                                    <form action="http://127.0.0.1:8000/systemes/directions/1"
                                                        method="POST">
                                                        <input type="hidden" name="_token"
                                                            value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                            type="hidden" name="_method" value="DELETE"> <button
                                                            type="submit" class="btn btn-danger  p-2"><i
                                                                class="fi fi-rr-trash"></i>
                                                            Supprimer</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-section" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Sections</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-section">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Service</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Nbre Employé</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> Section courrier interne </td>
                                            <td> </td>
                                            <td> </td>
                                            <td> </td>
                                            <td>
                                                <div class="d-flex align-items-center btns-action-table">

                                                    <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-departement-1"><i
                                                            class="fi fi-rr-pencil"></i>
                                                        Editer</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-secretariat" role="tabpanel"
                        aria-labelledby="pills-contact-tab" tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Secretariat</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-secretariat">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Direction</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> Secrétaire Général </td>
                                            <td> Direction générale </td>
                                            <td> Lord Francis </td>
                                            <td>
                                                <div class="d-flex align-items-center btns-action-table">

                                                    <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-secretariat-1"><i
                                                            class="fi fi-rr-pencil"></i>
                                                        Editer</a>
                                                    <form action="http://127.0.0.1:8000/systemes/secretariats/1"
                                                        method="POST">
                                                        <input type="hidden" name="_token"
                                                            value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                            type="hidden" name="_method" value="DELETE"> <button
                                                            type="submit" class="btn btn-danger"><i
                                                                class="fi fi-rr-trash"></i>
                                                            Supprimer</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-division" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Divisions</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-division">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Direction</th>
                                            <th scope="col">Responsable</th>
                                            <th scope="col">Nbe Services</th>
                                            <th scope="col">Nbe Agents</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> Divison de la Brigade Anti-fraude Secrétariat </td>
                                            <td> Direction de la Brigade Anti-fraude </td>
                                            <td> Miguel Katemb </td>
                                            <td> 1 </td>
                                            <td> 0 </td>
                                            <td>
                                                <div class="d-flex align-items-center btns-action-table">

                                                    <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-division-16"><i
                                                            class="fi fi-rr-pencil"></i>
                                                        Editer</a>
                                                    <form action="http://127.0.0.1:8000/systemes/divisions/16"
                                                        method="POST" style="flex:  0 0 auto;">
                                                        <input type="hidden" name="_token"
                                                            value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                            type="hidden" name="_method" value="DELETE"> <button
                                                            type="submit" class="btn btn-danger  p-2"><i
                                                                class="fi fi-rr-trash"></i>
                                                            Supprimer</button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-assistanat" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Assistanat</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-assistanat">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Direction</th>
                                        <th scope="col">Responsable</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Assistant (e) DG </td>
                                        <td> Direction générale </td>
                                        <td> Jean-Louis Dikasa </td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">

                                                <a href="#" class="btn btn-success " data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-assistant-1"><i
                                                        class="fi fi-rr-pencil"></i>
                                                    Editer</a>
                                                <form action="http://127.0.0.1:8000/systemes/assistants/1" method="POST">
                                                    <input type="hidden" name="_token"
                                                        value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                        type="hidden" name="_method" value="DELETE"> <button
                                                        type="submit" class="btn btn-danger "><i
                                                            class="fi fi-rr-trash"></i>
                                                        Supprimer</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="pills-service" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Services</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-service">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Responsable</th>
                                        <th scope="col">Nbe agents</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Corps des assistants au contrôle </td>
                                        <td> Division de l'Audit Interne et Inspection </td>
                                        <td> Miguel Katemb </td>
                                        <td> 0 </td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">

                                                <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-service-25"><i
                                                        class="fi fi-rr-pencil"></i>
                                                    Editer</a>
                                                <form action="http://127.0.0.1:8000/systemes/services/25"
                                                    style="flex: 0 0 auto" method="POST">
                                                    <input type="hidden" name="_token"
                                                        value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                        type="hidden" name="_method" value="DELETE"> <button
                                                        type="submit" class="btn btn-danger  p-2"><i
                                                            class="fi fi-rr-trash"></i>
                                                        Supprimer</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-fonction" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Fonctions</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-fonction">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Direction</th>
                                        <th scope="col">Division</th>
                                        <th scope="col">Section</th>
                                        <th scope="col">Nbe Agents</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> Directeur générale </td>
                                        <td> </td>
                                        <td> Direction générale </td>
                                        <td> Direction générale </td>
                                        <td> </td>
                                        <td> 1 </td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">
                                                <a href="#" class="btn btn-primary  p-2" data-bs-toggle="modal"
                                                    data-bs-target="#modal-show-fonction-1"><i class="fi fi-rr-eye"></i>
                                                    Voir</a>
                                                <a href="#" class="btn btn-success  p-2 me-2"
                                                    data-bs-toggle="modal" data-bs-target="#modal-edit-fonction-1"><i
                                                        class="fi fi-rr-pencil"></i>
                                                    Editer</a>
                                                <form action="http://127.0.0.1:8000/systemes/fonctions/1"
                                                    style="flex: 0 0 auto" method="POST">
                                                    <input type="hidden" name="_token"
                                                        value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                        type="hidden" name="_method" value="DELETE"> <button
                                                        type="submit" class="btn btn-danger  p-2"><i
                                                            class="fi fi-rr-trash"></i>
                                                        Supprimer</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Gestionnaire courriers interne </td>
                                        <td> Service Courrier </td>
                                        <td> Direction générale </td>
                                        <td> Direction générale </td>
                                        <td> </td>
                                        <td> 2 </td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">
                                                <a href="#" class="btn btn-primary  p-2" data-bs-toggle="modal"
                                                    data-bs-target="#modal-show-fonction-2"><i class="fi fi-rr-eye"></i>
                                                    Voir</a>
                                                <a href="#" class="btn btn-success  p-2 me-2"
                                                    data-bs-toggle="modal" data-bs-target="#modal-edit-fonction-2"><i
                                                        class="fi fi-rr-pencil"></i>
                                                    Editer</a>
                                                <form action="http://127.0.0.1:8000/systemes/fonctions/2"
                                                    style="flex: 0 0 auto" method="POST">
                                                    <input type="hidden" name="_token"
                                                        value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                        type="hidden" name="_method" value="DELETE"> <button
                                                        type="submit" class="btn btn-danger  p-2"><i
                                                            class="fi fi-rr-trash"></i>
                                                        Supprimer</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-grade" role="tabpanel" aria-labelledby="pills-contact-tab"
                        tabindex="0">
                        <div class="block-info-page">
                            <h3 class="text-page">Grades</h3>
                            <p class="para-page mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis
                                rerum labore unde excepturi, nihil saepe corporis nemo illo optio iure sapiente. Et
                                assumenda nobis possimus vitae deserunt! Perferendis, unde iure.</p>
                        </div>
                        <div class="card card-table" style="overflow: inherit">
                            <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                                wire:loading="" wire:target="filter, changeFilter"
                                wire:loading.class.remove="d-none">
                                <div class="text-center m-auto">
                                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model="search">
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">

                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                                    </path>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(1)">Par défaut</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(2)">A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(3)">Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(4)">Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click="changeFilter(5)">Date de
                                                        modification</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 d-flex align-items-center justify-content-end">
                                    <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                                        data-bs-target="#modal-new-grade">
                                        Ajouter
                                    </a>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Responsable</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> C-1 </td>
                                        <td>John doe</td>
                                        <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non, earum!</td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">

                                                <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-grade-1"><i class="fi fi-rr-pencil"></i>
                                                    Editer</a>
                                                <form action="http://127.0.0.1:8000/systemes/grades/1" method="POST"
                                                    style="flex: 0 0 auto">
                                                    <input type="hidden" name="_token"
                                                        value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                        type="hidden" name="_method" value="DELETE"> <button
                                                        type="submit" class="btn btn-danger  p-2"><i
                                                            class="fi fi-rr-trash"></i>
                                                        Supprimer</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> C-2 </td>
                                        <td>John doe</td>
                                        <td>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Non, earum!</td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">

                                                <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                                    data-bs-target="#modal-edit-grade-2"><i class="fi fi-rr-pencil"></i>
                                                    Editer</a>
                                                <form action="http://127.0.0.1:8000/systemes/grades/2" method="POST"
                                                    style="flex: 0 0 auto">
                                                    <input type="hidden" name="_token"
                                                        value="S9d8ZANB54FlcK7hNWjsl8muUkKMtrxoa4zNwxGt"> <input
                                                        type="hidden" name="_method" value="DELETE"> <button
                                                        type="submit" class="btn btn-danger  p-2"><i
                                                            class="fi fi-rr-trash"></i>
                                                        Supprimer</button>
                                                </form>

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
    <div class="modal fade" id="modal-new-lieu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un lieu</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.lieux.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="titre" class="form-control" placeholder="Nom du lieu"
                                    required>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                <div class="modal-body">
                    <form action="{{-- route('regidoc.directions.store') --}}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control" placeholder="Nom du Direction"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->agent->id }}"> {{ $user->agent->prenom . ' ' . $user->agent->nom }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-section" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un section</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{-- route('regidoc.sections.store') --}}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control"
                                    placeholder="Nom du département" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Service</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="">Selectionnez un service</option>
                                    {{-- @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->titre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->agent->id }}">{{ $user->agent->prenom.' '.$user->agent->nom }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Statut</label>
                                <select name="statut_id" class="form-control" required>
                                    <option value="">Selectionnez le statut</option>
                                    {{-- @foreach ($statuts as $statut)
                                        <option value="{{ $statut->id }}"> {{ $statut->libelle }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-secretariat" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter une secretariat</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.secretariats.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="titre" class="form-control"
                                    placeholder="Nom du secretariat" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Direction</label>
                                <select name="direction_id" class="form-control" required>
                                    <option value="">Selectionnez le département</option>
                                    {{-- @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
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
                        <span>Ajouter une division</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.divisions.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control"
                                    placeholder="Nom du division" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Direction</label>
                                <select name="direction_id" class="form-control" required>
                                    <option value="">Selectionnez le département</option>
                                    {{-- @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->agent->id }}"> {{ $user->agent->prenom .' '. $user->agent->nom }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Statut</label>
                                <select name="statut_id" class="form-control" required>
                                    <option value="">Selectionnez le statut</option>
                                    {{-- @foreach ($statuts as $statut)
                                        <option value="{{ $statut->id }}">
                                            {{ $statut->libelle }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-assistanat" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter une assistant</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <select name="direction_id" class="form-control" required>
                                    <option value="">Selectionnez le département</option>
                                    {{-- @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-service" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un service</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.services.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control"
                                    placeholder="Nom du service" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Division</label>
                                <select name="division_id" class="form-control" required>
                                    <option value="">Selectionnez le Division</option>
                                    {{-- @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"> {{ $division->libelle }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    {{-- @foreach ($users as $user)
                                        <option value="{{ $user->agent->id }}"> {{ $user->agent->prenom.' '.$user->agent->nom }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Statut</label>
                                <select name="statut_id" class="form-control" required>
                                    <option value="">Selectionnez le statut</option>
                                    {{-- @foreach ($statuts as $statut)
                                        <option value="{{ $statut->id }}">
                                            {{ $statut->libelle }} </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
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
                        <span>Ajouter une fonction</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.fonctions.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control"
                                    placeholder="Nom de la fonction" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Direction</label>
                                <select name="direction_id" class="form-control" required>
                                    <option value="">Selectionnez la direction</option>
                                    {{-- @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}">
                                            {{ $direction->titre }} </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-lg-12">
                                <label for="">Division</label>
                                <select name="division_id" class="form-control">
                                    <option value="">Selectionnez la division</option>
                                    {{-- @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">
                                            {{ $division->libelle }} </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-lg-12">
                                <label for="">Service</label>
                                <select name="service_id" class="form-control">
                                    <option value="">Selectionnez le service</option>
                                    {{-- @foreach ($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->titre }} </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="col-lg-12">
                                <label for="">Section</label>
                                <select name="section_id" class="form-control">
                                    <option value="">Selectionnez la section</option>
                                    {{-- @foreach ($sections as $section)
                                        <option value="{{ $section->id }}">
                                            {{ $section->titre }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            {{-- <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control" required>
                                    <option value="">Selectionnez le responsable</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->agent->prenom.' '.$user->agent->nom }} </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-lg-12">
                                <label for="">Description</label>
                                <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
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
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-grade" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter une grade</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.grades.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="titre" class="form-control" placeholder="Nom du grade"
                                    required>
                            </div>
                            <div class="col-lg-12 text-end mb-3">
                                <button class="btn btn-add mt-2">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
