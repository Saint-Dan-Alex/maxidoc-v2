@extends('regidoc.layouts.master')
@section('styles')
    <style>
        @media(max-width: 576px) {
            .tabBar {
                display: none !important;
            }
        }
    </style>
@endsection
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
        {{-- <a href="{{ route('regidoc.documents.index') }}" class="back">
            <i class="fi fi-rr-angle-left"></i>
            <div class="tooltip-indicator">
                Retour
            </div>
        </a> --}}
        {{-- <h1 class="mb-1">{{ Str::ucfirst($dossier->titre) }}</h1>
        <p class="mb-1 text-muted text-sm" style="font-size: 14px;">Ref: {{ Str::ucfirst($dossier->reference) }}</p>
        <p class="text-muted text-sm" style="font-size: 14px;">Créé le: {{ $dossier->created_at->format('d/m/Y') }}</p> --}}
        <div class="mt-3 row g-lg-3">
            @livewire('document.document', ['dossier' => $dossier])
        </div>
    </div>
    <div class="tabBarBtn d-block d-lg-none d-sm-none">
        <div class="content-tab d-flex align-items-center justify-content-center">
            <a href="#" class="btn btn-add" style="width: 90%">
                Numériser
            </a>
        </div>
    </div>
    @foreach ($documents as $document)
        {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-dossier-{{ $dossier->id }}" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header" style="flex-direction: column;">
                <div class="d-flex justify-content-between w-100">
                    <div class="text-star">
                        <h5 id="offcanvasRightLabel" class="mb-1">Détails du dossier </h5>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">
                                Créé le:
                            </span>
                            {{ $dossier->created_at->isoFormat('LLLL') }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">Par: </span>
                            {{ $dossier->author->nom }} {{ $dossier->author->nom }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            {{ $dossier->author->fonction()->departement->libelle }}
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
                                {{ $dossier->reference }}
                            </h6>
                        </div>
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Dénomination :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $dossier->titre }}
                            </h6>
                        </div>
                    </div>

                    <div class="card card-notification card-campaing">
                        <div class="text-star">
                            <h6 class="mb-3 date">
                                Description
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">
                                {{ $dossier->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <div class="d-flex justify-content-end">
                    {{-- <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-{{ $dossier->id }}">Supprimer</button> --}}
        {{-- <button class="btn">Modifier</button> -}}
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="modal-delete-document-{{ $document->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Etes-vous sûr de vouloir supprimer ce document ?</h5>
                            <p>Cette action est irrémédiable</p>
                        </div>
                        <form action="{{ route('regidoc.documents.destroy', $document) }}" method="POST">
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

        @if (Auth::user()->agent->isDG())
            @livewire('document.document-partage-modal', ['document' => $document], key($document->id))
        @endif
    @endforeach
@endsection
