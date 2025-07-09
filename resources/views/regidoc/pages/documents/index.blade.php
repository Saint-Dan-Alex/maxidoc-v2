@extends('regidoc.layouts.master')
@section('styles')
    <style>
        @media(max-width: 576px) {
            .tabBar {
                display: none !important;
            }
        }
    </style>
    <style>
        #upload-button {
            width: 150px;
            display: block;
            margin: 20px auto;
        }

        #file-to-upload {
            display: none;
        }

        #pdf-loader {
            display: none;
            text-align: center;
            color: #999999;
            font-size: 13px;
            line-height: 100px;
            height: 100px;
            position: absolute;
        }

        #pdf-contents {
            display: none;
            position: relative;
            overflow-x: auto;
            text-align: center;
        }

        #pdf-meta {
            margin: 0 0 20px 0;
        }

        #pdf-current-page {
            display: inline;
        }

        #pdf-total-pages {
            display: inline;
        }

        .pdf-canvas {
            box-sizing: border-box;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.05), -2px -2px 5px rgba(0, 0, 0, 0.05);
        }

        .page-loader {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            display: flex;
            justify-content: center;
        }

        .page-loader img {
            width: 70px;
            height: 70px;
            margin: auto;
            object-fit: contain;
        }

        .text-layer {
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            opacity: 0.2;
            line-height: 1.0;
            margin: auto;
        }

        .text-layer>div {
            color: transparent;
            position: absolute;
            white-space: pre;
            cursor: text;
            transform-origin: 0% 0%;
        }

        .text-layer>div::selection {
            background: #dd5500;
        }

        .image-container {
            position: absolute;
            top: 100%;
            left: 100%;
            transform: translate(-110%, -170%);
            z-index: 9999;
        }

        .image-container img {
            width: 200px;
            /* Set an initial width */
            height: auto;
            /* Preserve aspect ratio */
            resize: both;
            overflow: auto;
            object-fit: cover;
        }

        .ui-resizable-sw,
        .ui-resizable-ne,
        .ui-resizable-nw,
        .ui-resizable-se {
            border: 1px solid #999999;
        }

        .ui-resizable-n,
        .ui-resizable-s {
            height: 9px;
            width: 9px;
            left: 49%;
            border: 1px solid #999;
        }

        .ui-resizable-e,
        .ui-resizable-w {
            height: 9px;
            width: 9px;
            top: 41%;
            border: 1px solid #999;
        }

        .ui-icon-gripsmall-diagonal-se {
            background-position: initial;
        }

        .ui-icon {
            width: 9px;
            height: 9px;
            background: none !important;
        }

        .ui-resizable-se {
            right: -5px;
            bottom: -5px;
        }

        .pdf-page {
            position: relative;
        }

        .vignette-column {
            /* overflow: hidden; */
            /* width: 100%; */
            /* padding: 0; */
            transition: .3s ease-in-out;
        }

        #vignet-container {
            overflow-y: scroll;
            height: calc(100vh - 71px);
        }

        .signature {
            position: fixed;
            /* pointer-events: none; Make the signature element ignore mouse events */
            z-index: 1041;
            /* display: none; */
            /* border: 1px solid #eee; */
            width: 175px;
            height: 75px;
        }

        .signature.dropped-true {
            border: none;
        }

        .signature.dropped-true:hover {
            border: 1px solid #eee;
        }

        .signature.dropped-true img {
            cursor: pointer;
        }

        .signature.dropped-true button {
            display: none;
        }

        .signature.dropped-true:hover button {
            display: initial;
        }


        /* annotation */
        .pdf-content {
            border: 1px solid #000000;
        }

        .annotationLayer>a {
            display: block;
            position: absolute;
        }

        .annotationLayer>a:hover {
            opacity: 0.2;
            background: #ff0;
            box-shadow: 0px 2px 10px #ff0;
        }

        .annotText>div {
            z-index: 200;
            position: absolute;
            padding: 0.6em;
            max-width: 20em;
            background-color: #FFFF99;
            box-shadow: 0px 2px 10px #333;
            border-radius: 7px;
        }

        .annotText>img {
            position: absolute;
            opacity: 0.6;
        }

        .annotText>img:hover {
            opacity: 1;
        }

        .annotText>div>h1 {
            font-size: 1.2em;
            border-bottom: 1px solid #000000;
            margin: 0px;
        }

        .pdf-canvas {
            max-width: 100%;
        }

        .text-layer {
            max-width: 100%;
        }

        .back-overplay {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1031;
            display: none;
            opacity: 0;
            visibility: hidden;
            transition: .3s;
            pointer-events: none;
        }

        .sidebar {
            z-index: 1032;

        }

        .back-overplay.show {
            opacity: 1;
            visibility: visible;
            pointer-events: visible;
        }

        .close-parent {
            color: var(--colorParagraph);
            font-size: 14px;
        }

        .menu-action {
            width: 32px;
            height: 32px;
            align-items: center;
            justify-content: center;
            color: var(--colorTitre);
            cursor: pointer;
        }

        @media(max-width: 567px) {
            #pdf-contents {
                min-width: 100% !important;
            }

            .sidebar {
                width: 90% !important;
            }

            .back-overplay {
                display: block;
            }

            #pdf-main-container .nav-tools-page .save_pdf,
            #pdf-main-container .nav-tools-page .btn-conf-on {
                width: 50%;
            }

            .annotation-btn-float {
                position: fixed;
                bottom: 20px;
                border: none !important;
                right: 20px;
            }

            .annotation-btn-float .btn {
                background: var(--primaryColor);
                color: white;
                border-radius: 8px;
            }

            .annotation-btn-float .btn .tooltip-btn {
                display: none;
            }

            .all-annot {
                position: fixed !important;
                top: 0 !important;
                right: 0;
                height: 100% !important;
                width: 90%;
                z-index: 1032;
                background: var(--bg-card);
                padding: 20px;
                opacity: 0;
                transform: translateX(100%);
                transition: .3s;
            }

            .all-annot.show {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
@endsection

{{-- 
@section('content')
    <div class="card card-lg pb-0">
        <div class="d-flex align-items-center gap-3 ">
            <h1 class="mb-0">Documents</h1>
        </div>
        <div class="container-fluid px-lg-3">
            @livewire('document.des-documents')
        </div>
    </div>
@endsection --}}

@section('content')
    <div class="">
        <div class="card card-lg pb-0">
            <div class="d-flex align-items-center gap-3 ">
                {{-- <a href="javascript:history.back()" class="back mb-0">
                <i class="bi bi-chevron-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a> --}}

                {{-- <a href="{{ route('regidoc.home') }}" class="back mb-0">
                    <i class="fi fi-rr-angle-left"></i>
                    <div class="tooltip-indicator">
                        Retour
                    </div>
                </a> --}}
                <h1 class="mb-0">Documents</h1>

            </div>
            {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
        </div>
        <div class="container-fluid px-lg-2">
            {{-- <a href="{{ route('regidoc.documents.index') }}" class="back">
            <i class="fi fi-rr-angle-left"></i>
            <div class="tooltip-indicator">
                Retour
            </div>
        </a> --}}
            {{-- <h1 class="mb-1">{{ Str::ucfirst($dossier->titre) }}</h1>
        <p class="mb-1 text-muted text-sm" style="font-size: 14px;">Ref: {{ Str::ucfirst($dossier->reference) }}</p>
        <p class="text-muted text-sm" style="font-size: 14px;">Créé le: {{ $dossier->created_at->format('d/m/Y') }}</p> --}}

            @livewire('document.des-documents')
        </div>
    </div>

    {{-- <div class="tabBarBtn d-block d-lg-none d-sm-none">
        <div class="content-tab d-flex align-items-center justify-content-center">
            <a href="#" class="btn btn-add" style="width: 90%">
                Numériser
            </a>
        </div>
    </div> --}}
    {{--   @foreach ($documents as $document)
       
         <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-dossier-{{ $dossier->id }}" aria-labelledby="offcanvasRightLabel">
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
        </div> 


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
        </div> --}}

    {{-- @if (Auth::user()->agent->isDG())
    @livewire('document.document-partage-modal', ['document' => $document], key($document->id))
    @endif
    @endforeach
    @endsection

    @section('scripts')
    <script></script> --}}
    </div>
@endsection
