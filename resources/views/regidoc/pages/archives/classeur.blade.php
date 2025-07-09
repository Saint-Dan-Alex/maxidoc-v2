@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <a href="javascript:history.go(-1)" class="back mb-3">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h1>Archivage</h1>
            <p>
                Archives / <span style="color: lightcyan;">{{ Auth::user()->agent?->direction?->titre }}</span> /
                <span style="color: lightcyan"> {{ $annee }} </span>

            </p>
        </div>
        <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div>
    </div>
    <div class="container-fluid px-lg-3 block-top-margin">


        <div class="mt-3 row g-lg-3">
            @livewire('archivage.classeur-index', ['annee' => $annee])
        </div>
    </div>

    {{-- @foreach ($classeurs as $classeur)
        <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-classeur-{{ $classeur->id }}" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header" style="flex-direction: column;">
                <div class="d-flex justify-content-between w-100">
                    <div class="text-star">
                        <h5 id="offcanvasRightLabel" class="mb-1">Détails du classeur </h5>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">
                                Créé le:
                            </span>
                            {{ $classeur->created_at->isoFormat('LLLL') }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">Par: </span>
                            {{ $classeur->author->nom }} {{ $classeur->author->nom }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            {{-- <span style="display: inline-block" class="me-1">Departement: </span>  -}}
                            {{ $classeur->author->fonction()->departement->libelle }}
                        </p>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="offcanvas-body">
                <div class="block-progress">
                    <div class="card card-notification card-campaing">
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Référence :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $classeur->reference }}
                            </h6>
                        </div>
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Dénomination :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $classeur->titre }}
                            </h6>
                        </div>
                    </div>

                    <div class="card card-notification card-campaing">
                        <div class="text-star">
                            <h6 class="mb-3 date">
                                Description
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">
                                {{ $classeur->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <div class="d-flex justify-content-end">
                    <button class="btn" data-bs-toggle="modale" data-bs-target="#modal-delete-classeur-{{ $classeur->id }}">Supprimer</button>
                    <button class="btn">Modifier</button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-classeur-{{ $classeur->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Etes-vous sûr de vouloir supprimer ce classeur ?</h5>
                            <p>Cette action est irrémédiable</p>
                        </div>
                        <form action="{{ route('regidoc.classeurs.destroy', $classeur) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3 block-btn d-flex justify-content-center">
                                <a href="#" class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</a>
                                <button class="btn btn-delete">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach --}}


    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-division" aria-labelledby="offcanvasRightLabel">
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

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Dénomination
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Description
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>
                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Département
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Chef du département</h5>
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>


                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
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

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Dénomination
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Description
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>



                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-personnel" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header" style="flex-direction: column;">
            <div class="d-flex justify-content-between w-100">
                <div class="text-star">
                    <h5 id="offcanvasRightLabel" class="mb-1">Détails du personnel </h5>
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
                    <div class="avatar-user">
                        <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo de profil">
                        <span class="etat unactive">Suspendu</span>
                    </div>
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Nom complet
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Lieu de naissance
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Date de naissance
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Adresse
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Etat civil
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Nationalite
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Téléphone
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Email
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>

                <div class="card card-notification card-campaing">
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Fonction
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Matricule
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Département
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Division
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Etat civil
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Nationalite
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Téléphone
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">
                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Email
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
                    <div class="text-center content-text">
                        <i data-feather="trash"></i>
                        <h5>Are you sure ?</h5>
                        <p>This action can't be undone.</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                        <button class="btn btn-delete">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-suspend" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="power"></i>
                        <h5>Are you sure ?</h5>
                        <p>This action can't be undone.</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
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
    <div class="modal fade" id="modal-new-personnel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un personnel</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group row g-4">
                            <div class="block-img-upload">
                                <a href="{{-- route('courriers.received') -}}"></a>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Nom complet">
                            </div>

                            <div class="col-lg-6">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected="">Département</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected="">Division</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected="">Fonction</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" placeholder="Username">
                            </div>
                            <div class="col-lg-6">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected="">Sexe</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" placeholder="Nationalité">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" placeholder="Date de naissance">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" placeholder="Lieu de naissance">
                            </div>
                            <div class="col-lg-12">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected="">Etat civil</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Adresse Complet">
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Téléphone">
                            </div>
                            <div class="col-lg-12">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="col-lg-12">
                                <input type="password" class="form-control" placeholder="Mot de passe">
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- @include('components.admin.modals.archive') --}}
@endsection
