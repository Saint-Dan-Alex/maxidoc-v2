@extends('regidoc.layouts.master')
@section('content')
    <div class="container-fluid px-lg-4">
        <h1 class="mb-3">Recherche avancée</h1>
        <div class="row g-lg-3">
            <div class="col-lg-8">
                <div class="block-result-advance">
                    <div class="content-result d-flex flex-column">
                        <div class="header">
                            <div class="row align-items-center g-3">
                                <div class="col-lg-5">
                                    <h5 class="mb-0">Résultats <span
                                            style="color: var(--colorParagraph); font-weight: 400; font-size: 14px">(100)</span>
                                    </h5>
                                </div> 
                                <div class="col-lg-7">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control" placeholder="Recherche">
                                        <div class="dropdown" style="flex: 0 0 auto">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="true">
                                                <i class="fi fi-rr-filter"></i>
                                                Filtres
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1"
                                                data-popper-placement="bottom-start">
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(1)">
                                                        Auccun
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(2)">
                                                        Destinateur : A - Z
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(3)">
                                                        Destinateur : Z - A
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(4)">
                                                        Expediteur : A - Z
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(5)">
                                                        Expediteur : Z - A
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(6)">
                                                        Date d'entrée
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(7)">
                                                        Date : Ajourd'huit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascrip:void(0)"
                                                        wire:click="filter(8)">
                                                        Date : hier
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="all-item-result">
                                {{-- <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-result">
                                    <div class="content-item d-flex align-items-center">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icons/Fichier-pdf.svg')}}" alt="">
                                        </div>
                                        <div class="detail-item">
                                            <h6>Name file</h6>
                                            <div>
                                                Crée le 20/10/2023
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="table-responsive h-100">

                                    <table class="table table-hover ">
                                        <thead class="sticky-top">
                                            <tr>
                                                <th scope="col">Nom</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Créé par</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/images/icons/Fichier-pdf.svg') }}"
                                                            class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            Document
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>Lettre de motivation</td>
                                                <td>John doe</td>
                                                <td>Le 20/10/2023</td>
                                                <td>
                                                    <div class="badge">
                                                        success
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
            <div class="col-lg-4">
                <div class="block-preview-doc-sm h-100">
                    <object data="{{ asset('assets/pdfs/documents/1.pdf') }}" class="w-100 h-100"
                        type=""></object>
                    {{-- <div id="pdfPreviewContainer"></div> --}}

                    {{-- <iframe src="{{ asset('assets/pdfs/documents/1.pdf') }}" frameborder="0" sandbox="allow-same-origin allow-scripts">
                    </iframe> --}}
                </div>
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
@endsection

@section('scripts')
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

    <script>
        // Récupérez le conteneur du PDF
        var container = document.getElementById('pdfPreviewContainer');

        // Chemin vers le fichier PDF
        var pdfUrl = "{{ asset('assets/pdfs/documents/1.pdf') }}";

        // Chargement du fichier PDF
        PDFJS.getDocument(pdfUrl).then(function(pdf) {
            // Récupérez la première page du PDF
            pdf.getPage(1).then(function(page) {
                // Créez un élément canvas pour afficher l'aperçu
                var canvas = document.createElement('canvas');
                var context = canvas.getContext('2d');
                var viewport = page.getViewport({
                    scale: 1
                });

                // Définissez la taille du canvas en fonction de la taille de la page
                canvas.width = viewport.width;
                canvas.height = viewport.height;

                // Dessinez la première page du PDF sur le canvas
                page.render({
                    canvasContext: context,
                    viewport: viewport
                });

                // Ajoutez le canvas au conteneur
                container.appendChild(canvas);
            });
        });
    </script>
@endsection
