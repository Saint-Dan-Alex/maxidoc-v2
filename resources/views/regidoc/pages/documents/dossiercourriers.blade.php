@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg" style="padding-bottom: 30px;">
        <div class="d-flex align-items-center gap-3 mb-lg-4">
            <a href="javascript:history.back()" class="back mb-0">
                <i class="bi bi-chevron-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h1 class="mb-0">Documents</h1>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-3 block-top-margin">
        <div class="mt-3 row g-lg-3">
            @livewire('document.document-index')
        </div>
    </div>

    <div class="modal fade" id="modal-new-archive-dossier" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Créer un dossier</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">
                        <form action="{{ route('regidoc.dossiers.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="classeur_id" id="" value="1{{-- $classeur->id --}}">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" placeholder="Réference" name="reference"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" placeholder="Denomination" name="titre"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                        rows="5"></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <span>Confidentiel</span>
                                        <div class="form-check form-switch ms-3">
                                            <input class="form-check-input" type="checkbox" value="0" role="switch"
                                                id="check-date" name="confidentiel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 password d-none">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <input type="password" name="password" id="" placeholder="Mot de passe"
                                                class="form-control mb-2">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="password" name="password_confirm" id=""
                                                placeholder="Confirmez le mot de passe" class="form-control mb-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-add">Créer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- @foreach ($classeurs as $classeur)
        <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-classeur-{{ $classeur->id }}"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header" style="flex-direction: column;">
                <div class="d-flex justify-content-between w-100">
                    <div class="text-star">
                        <h5 id="offcanvasRightLabel" class="mb-1">Détails du classeur </h5>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">
                                Créé le:
                            </span>
                            {{ $classeur->created_at?->isoFormat('LLLL') }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">Par: </span>
                            {{ $classeur->author?->nom }} {{ $classeur->author?->nom }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            {{-- <span style="display: inline-block" class="me-1">Departement: </span>  --}}
    {{-- {{ $classeur->author?->fonction()->departement?->libelle }} -}}
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
            {{-- <div class="offcanvas-footer">
                <div class="d-flex justify-content-end">
                    <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-{{ $classeur->id }}">Supprimer</button>
                    <button class="btn">Modifier</button>
                </div>
            </div> -}}
        </div>

        <div class="modal fade" id="modal-edit-classeur-{{ $classeur->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Créer un classeur</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row g-4">
                            <form action="{{ route('regidoc.classeurs.update', $classeur) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Réference" name="reference"
                                            value="{{ $classeur->reference }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Denomination" name="titre"
                                            value="{{ $classeur->titre }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                            rows="5">{{ $classeur->description }}</textarea>
                                    </div>

                                    <div class="col-lg-12 text-end">
                                        <button class="btn btn-add" type="submit" data-bs-dismiss="modal"
                                            aria-label="Close" wire:click.prevent="storeFonction()">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-classeur-{{ $classeur->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <a href="#" class="btn btn-cancel me-4" data-bs-dismiss="modal"
                                    aria-label="Close">Annuler</a>
                                <button class="btn btn-delete">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('components.admin.modals.archive') --}}
@endsection
