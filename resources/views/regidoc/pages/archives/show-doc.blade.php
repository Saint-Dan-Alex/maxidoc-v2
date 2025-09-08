@extends('regidoc.layouts.layout-doc')

@section('content')
    <div class="block-scanner">
        <div class="sidebar-doc">
            <div class="header-sidebar">
                <a href="javascript:history.go(-1)">
                    <i class="bi bi-arrow-left"></i></a>
                <h4>Details du fichier</h4>
                {{-- <div class="block-badge off">
                    <i class="bi bi-unlock-fill"></i>
                    Non confidentiel
                </div> --}}
            </div>
            {{-- <form action="">
                <div class="body-siderbar">
                    <div class="form-group row g-3">
                        <div class="col-12">
                            <h5 class="title-info mb-2">Informations générales</h5>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Nom</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->titre ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Catégorie</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->categorie->titre) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Type de courrier</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->type->title ?? '')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-sidebar">
                    <a href="{{ route('regidoc.my.courriers.destroy', $find_document) }}" class="btn">Supprimer</a>
                    {{-- <button class="btn btn-valid">Modifier</button> -}}
                </div>
            </form> --}}

            <form action="">
                <div class="body-siderbar">
                    <div class="d-flex justify-content-between">
                        {{-- <div class="block-assign" data-bs-toggle="modal" data-bs-target="#modal-new-task-ass">
                            <i class="bi bi-person-plus"></i> Assigner ce document
                        </div> --}}
                        {{-- <div class="block-assign" data-bs-toggle="modal" data-bs-target="#modal-new-task-ass">
                            <i class="fi fi-rr-share me-1"></i> Partager
                        </div> --}}
                    </div>
                    <div class="form-group row g-3">
                        <div class="col-12">
                            <h5 class="mb-2 title-info">Informations générales</h5>
                        </div>
                        @if($find_document->reference_interne)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                {{-- <label for="inputPassword" class="col-5 col-form-label">Nom</label> --}}

                                    <div class="col-5">
                                        <span>N° d'enregistrement</span>
                                    </div>
                                    <div class="col-7">
                                        <p class="items mb-0">{{ $find_document->reference_interne }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Nom</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->libelle ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Référence</label>
                                <div class="col-7">
                                    <p class="items">{{ Str::ucfirst($find_document->reference ?? '') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($find_document->description)                        
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Description</label>
                                <div class="col-7">
                                    <p class="items scrollable-text">
                                        {{ Str::ucfirst($find_document->description ?? 'Non défini') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Catégorie</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ $find_document->categorie->title ??'Non spécifiée' }}

                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        @if($find_document->emetteur)

                            @if($find_document->type == 1)
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <label for="inputPassword" class="col-5 col-form-label">Emetteur</label>
                                        <div class="col-7">
                                            <p class="items">
                                                {{ $find_document->courrier->externExpediteur->nom ?? 'Non défini' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <label for="inputPassword" class="col-5 col-form-label">Emetteur</label>
                                        <div class="col-7">
                                            <p class="items">
                                                {{ optional($find_document->courrier)->service->name ?? 'Non défini' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                        @if($find_document->destination)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Destination</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{$find_document->destination}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($find_document->redacteur_id)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Rédacteur</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ optional($find_document->redacteur)->nom ?? 'Non défini' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif




                        @if($find_document->courrier)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Type de document</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{$find_document->typeDocument->titre ?? 'Pièce jointe tâche'}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- @if($find_document->nature) --}}
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="inputPassword" class="col-5 col-form-label">Nature</label>
                                    </div>
                                    <div class="col-7">
                                        <p class="items mb-0">{{ $find_document->courrier->nature->titre ?? 'Non défini' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @endif --}}
                        @if($find_document->service)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-5">
                                        <span>Service initiateur</span>
                                    </div>
                                    <div class="col-7">
                                        <p class="items mb-0">{{ $find_document->service->titre ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if ($find_document->date_arrive)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Date d'émission</label>
                                <div class="col-7">
                                    <p class="items">

                                        {{ \Carbon\Carbon::parse($find_document->date_arrive)->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if ($find_document->priorite)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Priorité
                                            </span>
                                        </div>
                                        <div class="col-lg-6">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ Str::ucfirst($find_document->priorite->titre ?? '') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Ajouté par</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ Str::ucfirst($find_document->author->prenom ?? '') }}
                                        {{ Str::ucfirst($find_document->author->nom ?? '') }}
                                    </p>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                </div>
                <div class="footer-sidebar">
                    {{-- <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-delete-document">Supprimer</a> --}}
                    @can('Désarchiver des documents')
                        <a href="#" class="btn btn-valid" data-bs-toggle="modal"
                            data-bs-target="#modal-new-archive">Desarchiver</a>
                    @endcan
                </div>
            </form>

        </div>
        <div class="content-scanner">
            <div class="container-fluid">
                <div class="document-selector mb-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" 
                                id="documentDropdown" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false"
                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @php
                                $docUrl = null;
                                $docName = 'Sélectionner un document';

                                if ($find_document->document) {
                                    $docArr = is_array($find_document->document) ? $find_document->document : json_decode($find_document->document, true);
                                    $firstElement = $docArr[0] ?? null;

                                    if (is_array($firstElement)) {
                                        $docUrl = $firstElement['download_link'] ?? null;
                                        $docName = $firstElement['original_name'] ?? 'Document';
                                    } elseif (is_string($firstElement)) {
                                        $docUrl = $firstElement;
                                        $docName = basename($firstElement);
                                    }
                                }
                            @endphp
                            {{ $docName }}
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="documentDropdown">
                            @if($docUrl)
                                <li>
                                    <a class="dropdown-item document-item active" 
                                       href="javascript:void(0)"
                                       data-url="{{ asset('storage/' . $docUrl) }}">
                                        <i class="fi fi-rr-file me-2"></i>
                                        {{ $docName }} (principal)
                                    </a>
                                </li>
                            @endif
                            
                            @if(isset($find_document->piecesJointes) && $find_document->piecesJointes->count() > 0)
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-header">Pièces jointes</li>
                                @foreach($find_document->piecesJointes as $piece)
                                    @php
                                        $filePath = $piece->chemin;
                                        $fullPath = storage_path('app/public/' . $filePath);
                                        $isPdf = Str::endsWith(strtolower($filePath), '.pdf');
                                        $exists = file_exists($fullPath);
                                    @endphp
                                    <li>
                                        <a class="dropdown-item document-item" 
                                           href="javascript:void(0)"
                                           data-url="{{ ($isPdf && $exists) ? asset('storage/' . $filePath) : '' }}"
                                           data-error="{{ (!$exists) ? 'Fichier introuvable' : (!$isPdf ? 'Format non supporté' : '') }}">
                                            <i class="fi fi-rr-file me-2"></i>
                                            {{ $piece->nom }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                
                <div id="document-viewer">
                    <div id="document-error" style="display:none; padding:2rem; color:red; text-align:center;"></div>
                    @php
                        $iframeUrl = '';
                        if ($docUrl) {
                           $iframeUrl = asset('storage/' . $docUrl) . '#toolbar=0&navpanes=0&page=1';
                        }
                    @endphp
                    <iframe src="{{ $iframeUrl }}" 
                            frameborder="0"
                            class="w-100"
                            style="height: calc(100vh - 200px);"></iframe>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="modal-new-archive" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Désarchiver</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">
                        <form action="{{ route('regidoc.documents.desarchiver') }}" method="post">
                            @csrf
                            <input type="hidden" name="document_id" id="" value="{{ $find_document->id }}">
                            <div class="">
                                <h4>Etes-vous sûr de vouloir desarchiver ce document ?</h4>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button class="btn btn-add" type="submit">Désarchiver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pdfSuffix = '#toolbar=0&navpanes=0&page=1';

        document.querySelectorAll('.document-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                const dropdownButton = document.getElementById('documentDropdown');
                dropdownButton.textContent = this.textContent.trim();

                const iframe = document.querySelector('#document-viewer iframe');
                const errorDiv = document.getElementById('document-error');
                let url = this.getAttribute('data-url');
                let error = this.getAttribute('data-error');
                if (error) {
                    errorDiv.textContent = error;
                    errorDiv.style.display = 'block';
                    iframe.style.display = 'none';
                    iframe.src = 'about:blank';
                } else if (url) {
                    errorDiv.style.display = 'none';
                    iframe.style.display = 'block';
                    if (!url.endsWith(pdfSuffix)) {
                        url += pdfSuffix;
                    }
                    iframe.src = url;
                } else {
                    errorDiv.textContent = 'Aucun fichier à afficher';
                    errorDiv.style.display = 'block';
                    iframe.style.display = 'none';
                    iframe.src = 'about:blank';
                }

                document.querySelectorAll('.document-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
@endpush
