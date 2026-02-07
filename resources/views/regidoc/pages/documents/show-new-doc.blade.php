@extends('regidoc.layouts.layout-doc')

@section('content')
    <script src="{{ asset('assets/js/pdfjs/pdf.js') }}"></script>
    <script src="{{ asset('assets/js/pdfjs/pdf.worker.js') }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
        #pdf-main-container {
            padding-left: 0 !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: var(--bgContent, #f8f9fa);
            width: 100%;
            position: relative;
        }

        #pdf-contents {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            overflow-y: auto;
        }

        .pdf-canvas {
            box-sizing: border-box;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            height: auto !important;
            display: block;
            margin: 0 auto;
        }

        .pdf-page {
            position: relative;
            margin-bottom: 25px;
            display: flex;
            justify-content: center;
            width: fit-content;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .pdf-tools-modified {
            display: flex !important;
            width: fit-content !important;
            min-width: unset !important;
            margin: 10px auto !important;
            padding: 5px 20px !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(0,0,0,0.1) !important;
            position: sticky !important;
            top: 10px !important;
            z-index: 1000;
            justify-content: center !important;
            gap: 20px !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
        }

        .pdf-tools-modified #toolbarViewerLeft,
        .pdf-tools-modified #toolbarViewerMiddle,
        .pdf-tools-modified #toolbarViewerRight {
            min-width: unset !important;
            width: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            gap: 10px !important;
        }

        .pdf-tools-modified #toolbarViewerLeft::after,
        .pdf-tools-modified #toolbarViewerMiddle::after {
            display: none !important;
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
            width: 100%;
            height: 100%;
        }

        .text-layer > div {
            color: transparent;
            position: absolute;
            white-space: pre;
            cursor: text;
            transform-origin: 0% 0%;
        }

        .loader-overlay {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .loader-content {
            text-align: center;
        }

        .loader-text {
            margin-top: 10px;
            font-weight: 500;
        }
    </style>
    <div class="block-scanner">
        <div class="sidebar-doc">
            <div class="header-sidebar">
                <div class="d-flex align-items-center">
                    <a href="{{ route('regidoc.home') }}" class="btn-back">
                        <i class="fi fi-rr-angle-left"></i>
                        <div class="tooltip-indicator">Retour</div>
                    </a>
                    <h4 class="ms-2">Détails du fichier</h4>
                </div>
            </div>

            <form action="{{ route('documents.savePDF') }}" method="POST">
                @csrf
                <div class="body-siderbar">
                    @if (Auth::user()->agent->isDG())
                        <div class="d-flex justify-content-between mb-4">
                            <!-- Champs cachés pour inclure les données nécessaires à l'enregistrement -->
                            <input type="hidden" name="pdfname" value="{{ $pdfname ?? '' }}">
                            <input type="hidden" name="reference" value="{{ $data['reference'] ?? '' }}">
                            <input type="hidden" name="objet" value="{{ $data['objet'] ?? '' }}">
                            <input type="hidden" name="pdfPath" value="{{ $pdfPath ?? '' }}">


                            <button type="submit" class="block-assign mb-0">
                                <i class="bi bi-person-plus"></i>
                                Enregistrer
                            </button>
                            <a href="{{ asset('storage/tmp/' . $pdfname . '.pdf') }}" download class="block-assign mb-0">
                                <i class="bi bi-share"></i>
                                Télécharger
                            </a>
                            <div class="block-assign mb-0 text-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-delete-document">
                                <i class="bi bi-trash"></i>
                                Abandonner
                            </div>
                        </div>
                    @endif

                    <div class="form-group row g-3">
                        <div class="col-12">
                            <h5 class="mb-2 title-info">Informations générales</h5>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="content-scanner">
            <div class="container-fluid">
                @if (isset($pdfPath))
                    <div id="pdf-main-container" 
                         style="width: 100%; min-height: 80vh;"
                         data-url="{{ asset('storage/tmp/' . $pdfname . '.pdf') }}" 
                         data-name="{{ $pdfname }}" 
                         data-courrier="" 
                         data-tache="" 
                         data-docid="" 
                         data-code="" 
                         data-original="true">
                        <div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
                            {{-- Le script showPDF.js va injecter le contenu ici --}}
                        </div>
                        @include('components.pdf-tools')
                    </div>
                @else
                    <p>Aucun document PDF disponible à afficher.</p>
                @endif
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
                        <h5>Êtes-vous sûr de vouloir supprimer ce document ?</h5>
                        <p>Cette action est irrémédiable</p>
                    </div>
                    <form action="{{ route('documents.deleteTemp', ['filename' => $pdfname]) }}" method="POST">
                        @csrf
                        <div class="mb-3 block-btn d-flex justify-content-center">
                            <a href="#" class="btn btn-cancel me-4" data-bs-dismiss="modal"
                                aria-label="Close">Annuler</a>
                            <button class="btn btn-delete">Abandonner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/showPDF.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js?v=1"></script>
@endpush
