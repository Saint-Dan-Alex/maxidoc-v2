@extends('regidoc.layouts.layout-doc')

@section('content')
    <div class="block-scanner">
        <div class="sidebar-doc">
            <div class="header-sidebar">
                <div class="d-flex align-items-center"> 
                    <a href="{{ url()->previous() }}" class="btn-back">
                        <i class="fi fi-rr-angle-left"></i>
                        <div class="tooltip-indicator">
                            Retour
                        </div>
                    </a>

                    <h4 class="ms-2">Détails du document</h4>
                </div>
            </div>

            <form action="">
                <div class="body-siderbar">
                    {{-- <div class="d-flex justify-content-between">
                        <div class="block-assign" data-bs-toggle="modal" data-bs-target="#modal-new-task-ass">
                            <i class="bi bi-person-plus"></i> Assigner ce document
                        </div>
                        {{-- <div class="block-assign" data-bs-toggle="modal" data-bs-target="#modal-new-task-ass">
                            <i class="fi fi-rr-share me-1"></i> Partager
                        </div> -}}
                    </div> --}}

                    @if (Auth::user()->agent->isDG())
                        <div class="d-flex justify-content-between mb-4">
                            <a href="{{ route('regidoc.taches.create', ['doc' => $find_document->id]) }}"
                                class="block-assign mb-0">
                                <i class="bi bi-person-plus"></i>
                                Assigner
                            </a>
                             <div class="block-assign mb-0" data-bs-toggle="modal" data-bs-target="#modal-doc-share">
                                <i class="bi bi-share"></i>
                                Partager
                            </div> 
                        </div>
                    @endif
                    {{-- @can('Partager un document') --}}
                        {{-- <li>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-doc-share">
                                <i class="fi fi-rr-share"></i>
                                <span class="title">Partager</span>
                            </a>
                        </li> --}}
                    {{-- @endcan --}}
                    <div class="form-group row g-3">
                        <div class="col-12">
                            <h5 class="mb-2 title-info">Informations générales</h5>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Titre</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->libelle ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Type de courrier</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ Str::ucfirst($find_document->typeDocument?->titre) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Catégorie</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ Str::ucfirst($find_document->categorie?->title) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Référence courrier</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->reference ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Service initiateur</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ $find_document->author->fonction()->departement?->libelle }}
                                    </p>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Objet</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ $find_document->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Date de création</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ $find_document->created_at?->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Ajouté par</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ Str::ucfirst($find_document->author?->prenom ?? '') }}
                                        {{ Str::ucfirst($find_document->author?->nom ?? '') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="footer-sidebar">
                    {{-- <a href="#" class="btn" data-bs-toggle="modal"
                        data-bs-target="#modal-delete-document">Supprimer</a> --}}
                    @can('Archiver les documents')
                        <a href="#" class="btn btn-valid" data-bs-toggle="modal"
                            data-bs-target="#modal-new-archive">Archiver</a>
                    @endcan
                </div>
            </form>

        </div>
        <div class="content-scanner">
            <div class="container-fluid">
                <iframe src="{{ files($find_document?->document)->link ? files($find_document?->document)->link.'#toolbar=0&navpanes=0&page=1' : '#' }}" frameborder="0"
                    class="w-100"></iframe>
            </div>
        </div>

    </div>

    {{-- @livewire('document.modal-document-share', ['document' => $find_document]) --}}

    <div class="modal fade" id="modal-new-archive" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-3">
                        <form action="{{ route('regidoc.documents.archive') }}" method="post">
                            @csrf
                            <input type="hidden" name="document_id" id="" value="{{ $find_document->id }}">
                            <div class="content-text text-center">
                                <h5>Archivage du document</h5>
                                <p class="mb-0">Vous êtes sur le point d'archiver ce document, êtes-vous sûr de vouloir continuer ?</p>
                            </div>
                            <div class="col-lg-12 text-center mb-3">
                                <button class="btn btn-add mt-2 w-100" type="submit">Confirmer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete-document" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="trash"></i>
                        <h5>Etes-vous sûr de vouloir supprimer ce document ?</h5>
                        <p>Cette action est irrémédiable</p>
                    </div>
                    <form action="{{ route('regidoc.documents.destroy', $find_document) }}" method="POST">
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
@endsection
