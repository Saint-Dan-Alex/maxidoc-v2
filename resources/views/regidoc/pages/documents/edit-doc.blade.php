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
                <h4 class="ms-0">Modifier un courrier/dossier</h4>
            </div>
            @livewire('document.edit-doc-form', ['document' => $document, 'types' => $types, 'natures' => $natures, 'agents' => $agents])
        </div>
        <div class="content-scanner">
            <div class="container-fluid">
                @php
                    $initialUrl = '';
                    if ($document && $document->document && $document->document != '[]' && $document->document != '') {
                        $fileObj = files($document->document);
                        if ($fileObj && !empty($fileObj->link)) {
                            $initialUrl = $fileObj->link;
                        }
                    }
                @endphp
                <div id="pdf-main-container" class="@if (!$initialUrl) d-none @endif"
                     style="width: 100%; min-height: 80vh;"
                     data-url="{{ $initialUrl }}" 
                     data-name="{{ $document->libelle ?? '' }}" 
                     data-courrier="" 
                     data-tache="" 
                     data-docid="{{ $document->id ?? '' }}" 
                     data-code="" 
                     data-original="true">
                    <div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
                        {{-- Le script showPDF.js va injecter le contenu ici --}}
                    </div>
                    @include('components.pdf-tools')
                </div>
                <div class="block-no-file @if ($initialUrl) d-none @endif">
                    <i class="bi bi-file icon"></i>
                    <h4>Pas encore de document importé</h4>
                    <p>Le document numérisé apparaîtra ici.</p>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('javascript')
    <script src="{{ asset('assets/js/showPDF.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js?v=1"></script>
    <script>
        $(document).ready(function() {
            const nvFichier = document.getElementById('file-upload');
            const pdfMainContainer = document.getElementById('pdf-main-container');

            if (nvFichier) {
                nvFichier.addEventListener('change', function() {
                    const fichier = this.files[0];
                    if (fichier) {
                        const analyseur = new FileReader();
                        analyseur.readAsDataURL(fichier);
                        analyseur.addEventListener('load', function() {
                            $(pdfMainContainer).removeClass('d-none');
                            $('.block-no-file').addClass('d-none');
                            
                            if (typeof showPDF === 'function') {
                                showPDF(this.result);
                            }
                        });
                    }
                });
            }

            $('#check-date').on('click', function() {
                $('.date-limite').toggleClass('d-none');
            });

            $('input[name=confidentiel]').on('click', function() {
                console.log($(this));
            });
        });
    </script>
@endsection
