@extends('regidoc.layouts.layout-doc')

@section('content')
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
                    <iframe src="{{ asset('storage/tmp/' . $pdfname . '.pdf') }}#toolbar=0" frameborder="0" class="w-100"
                        style="height: 100vh;"></iframe>
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
