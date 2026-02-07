@extends('regidoc.layouts.layout-doc')
@section('content')
    <script src="{{ asset('assets/js/pdfjs/pdf.js') }}"></script>
    <script src="{{ asset('assets/js/pdfjs/pdf.worker.js') }}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
        .pdf-canvas {
            box-sizing: border-box;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.05), -2px -2px 5px rgba(0, 0, 0, 0.05);
            max-width: 100%;
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
            max-width: 100%;
        }

        .text-layer > div {
            color: transparent;
            position: absolute;
            white-space: pre;
            cursor: text;
            transform-origin: 0% 0%;
        }

        .pdf-page {
            position: relative;
            margin-bottom: 20px;
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
                <a href="{{ url()->previous() }}" class="btn-back" style="font-size: 14px; color: var(--colorTitle)">
                    <i class="fi fi-rr-angle-left"></i>
                    <div class="tooltip-indicator">
                        Retour
                    </div>
                </a>
                <h4 class="ms-0">Enregistrer un courrier/dossier</h4>
            </div>
            @livewire('document.add-doc-form', ['types' => $types, 'natures' => $natures, 'services' => $services, 'agents' => $agents, 'dossier_id' => $dossier_id])
        </div>
        <div class="content-scanner">
            <div class="container-fluid">
                <div id="pdf-main-container" class="d-none"
                     style="width: 100%; min-height: 80vh;"
                     data-url="" 
                     data-name="" 
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
                <div class="block-no-file">
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
