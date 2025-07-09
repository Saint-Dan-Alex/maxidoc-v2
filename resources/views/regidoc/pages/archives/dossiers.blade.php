@extends('regidoc.layouts.master')

@section('content')
    <div class="container-fluid px-lg-4">
        <a href="javascript:history.go(-1)" class="back">
            <i class="fi fi-rr-angle-left"></i>
            <div class="tooltip-indicator">
                Retour
            </div>
        </a>
        <p class="bg-white p-2 rounded">
            Archives/<span style="color:darkgray;">{{ Auth::user()->agent?->direction?->titre }}/</span>
            {{ $classeur->created_at->format('Y') . '/' }}
            <span class="text-primary text-capitalize"> {{ $classeur->titre }} </span>
        </p>
        <div class="row g-lg-3">
            @livewire('archivage.dossiers', ['classeur' => $classeur])
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-departement" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header" style="flex-direction: column;">
            <div class="d-flex justify-content-between w-100">
                <div class="text-star">
                    <h5 id="offcanvasRightLabel" class="mb-1">Détails du département </h5>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block" class="me-1">Créé
                            le: </span> 22 Jav 2022</p>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block" class="me-1">Par:
                        </span> John Doe</p>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
                            Responsable
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>
                <div class="card card-notification card-campaing">
                    <div class="d-flex justify-content-between">
                        <div class="text-star">

                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Nombre de divisions
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                        </div>
                        <div class="text-star">

                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
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
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block" class="me-1">Créé
                            le: </span> 22 Jav 2022</p>
                    <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block" class="me-1">Par:
                        </span> John Doe</p>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
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
                                <a href=""></a>
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
    </div>

    {{-- <div class="modal fade" id="modal-new-archive-dossier"   tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" >
            <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                <span>Archiver</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row g-4">
                    <form action="{{ route('regidoc.dossiers.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="classeur_id" id="" value="{{ $classeur->id }}">
                        <div>
                            <div class="my-3 col-lg-12">
                                <input type="text" class="form-control" placeholder="Denomination" name="titre" required>
                            </div>
                        </div>
                        <div >
                            <div class="my-3 col-lg-12">
                                <input type="text" class="form-control" placeholder="Réference" name="reference" required>
                            </div>
                        </div>
                        <div >
                            <div class="my-3 col-lg-12">
                                <textarea name="description" class="form-control" id="description" placeholder="description" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        {{-- <div class="my-3 col-lg-12">
                            <select name="classeur_id" id="" class="form-control" required>
                                <option value="" selected >Selectionner un Classeur</option>
                                @forelse ($classeurs as $classeur)
                                    <option value="{{ $classeur->id }}">{{ $classeur->titre }}</option>
                                @empty

                                @endforelse
                            </select>
                        </div> -}}
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-add" data-bs-dismiss="modal" aria-label="Close">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div> --}}
@endsection
