@extends('regidoc.layouts.layout-doc')

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
                            <h5 class="mb-2 title-info">Intervenants</h5>
                        </div>

                        @if($find_document->courrier && $find_document->courrier->accuseReceptions->count() > 0)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-5">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">Accusés de réception</span>
                                    </div>
                                    <div class="col-7">
                                        @foreach($find_document->courrier->accuseReceptions as $accuseReception)
                                            @if($accuseReception->user && $accuseReception->user->agent)
                                                <div class="detailCourierUserInfosBox">
                                                    <div class="avatarDetailCourier">
                                                        <img class="avatarDetailCourier-avatar"
                                                            src="{{ imageOrDefault($accuseReception->user->agent?->image) }}"
                                                            alt="image profil">
                                                    </div>
                                                    <div>
                                                        <p style="font-size: 14px; color: var(--colorTitre); margin-bottom: 5px;">
                                                            {{ Str::ucfirst($accuseReception->user->agent->prenom ?? '') . ' ' . Str::ucfirst($accuseReception->user->agent->nom ?? '') }}
                                                            @if($accuseReception->user->agent->poste)
                                                                <small class="d-block text-muted">
                                                                    {{ $accuseReception->user->agent->poste->titre }}
                                                                </small>
                                                            @endif
                                                            <small class="d-block text-muted">
                                                                {{ $accuseReception->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if ($find_document->followers->count())
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">En copie</span>
                                        </div>
                                        <div class="col-7">
                                            @foreach ($find_document->followers->unique() as $follower)
                                                <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                    {{ Str::ucfirst($follower->prenom ?? '') . ' ' . Str::ucfirst($follower->nom ?? '') }}
                                                </p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <hr class="mt-4">

                        <div class="col-12">
                            <h6 class="mt-3 mb-2 title-info">Informations générales</h6>
                        </div>
                        @if ($find_document->libelle)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">Titre</span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ Str::ucfirst($find_document->libelle) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->reference)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">Référence</span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->reference }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->categorie)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Catégorie
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->categorie->title }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($find_document->courrier && $find_document->courrier->expediteur)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Expéditeur
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-1">
                                                {{ $find_document->courrier->expediteur->prenom }} {{ $find_document->courrier->expediteur->nom }}
                                                @if($find_document->courrier->expediteur->poste)
                                                    <small class="d-block text-muted">
                                                        {{ $find_document->courrier->expediteur->poste->titre }}
                                                    </small>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($find_document->courrier && $find_document->courrier->externExpediteur)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Expéditeur
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-1" name="expediteur_externe" id="expediteur_externe">
                                                {{ $find_document->courrier->externExpediteur->nom }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->typeDocument)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Type de document
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->typeDocument->titre }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($find_document->reference_interne)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                N° d'enregistrement
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->reference_interne }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($find_document->courrier && $find_document->courrier->nature_id)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Nature
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->courrier->nature->titre ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->traitement)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Traitement à effectuer
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->traitement->titre }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($find_document->courrier && $find_document->courrier->priorite_id)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Priorité
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->courrier->priorite->titre ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->date_du_courrier)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Date du courrier
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ \Carbon\Carbon::parse($find_document->date_du_courrier)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->date_arrive)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Date de réception
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ \Carbon\Carbon::parse($find_document->date_arrive)->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($find_document->description)
                            <div class="col-12">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-5">
                                            <span style="font-size: 13px; color: var(--colorParagraph)">
                                                Objet
                                            </span>
                                        </div>
                                        <div class="col-7">
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ $find_document->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-5">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Créé par
                                        </span>
                                    </div>
                                    <div class="col-7">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $find_document->author?->prenom }} {{ $find_document->author?->nom }}
                                            @if($find_document->author?->poste)
                                                <small class="d-block text-muted">
                                                    {{ $find_document->author->poste->titre }}
                                                </small>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Section des pièces jointes -->
                    @if($find_document->piecesJointes->count() > 0)
                        <div class="col-12 mt-4">
                            <h6 class="mb-3 title-info">Pièces jointes</h6>
                            <div class="list-group">
                                @foreach($find_document->piecesJointes as $piece)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-file-earmark me-2"></i>
                                                <a href="{{ $piece->url }}" target="_blank" class="text-decoration-none">
                                                    {{ $piece->nom }}
                                                </a>
                                                <small class="d-block text-muted">{{ $piece->formatted_size }}</small>
                                            </div>
                                            <a href="{{ $piece->url }}" download class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <!-- Fin section des pièces jointes -->

                </div>
                <div class="footer-sidebar">
                    @can('Archiver')
                        <a href="#" class="btn btn-valid w-100" data-bs-toggle="modal"
                        data-bs-target="#modal-new-archive">Archiver</a>
                    @endcan
                    {{-- <a href="#" class="btn" data-bs-toggle="modal"
                        data-bs-target="#modal-delete-document">Supprimer</a> --}}
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
                                $docInfo = null;
                                $docUrl = null;
                                $docName = 'Sélectionner un document';

                                if ($find_document->document) {
                                    $docArr = is_array($find_document->document) ? $find_document->document : json_decode($find_document->document, true);
                                    $firstElement = $docArr[0] ?? null;

                                    if (is_array($firstElement)) {
                                        // Cas où l'élément est un tableau associatif (format JSON)
                                        $docUrl = $firstElement['download_link'] ?? null;
                                        $docName = $firstElement['original_name'] ?? 'Document';
                                    } elseif (is_string($firstElement)) {
                                        // Cas où l'élément est une simple chaîne (chemin du fichier)
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
                {{-- @if($find_document->libelle)
                    <div class="document-title-bar mt-3 p-3 bg-light rounded">
                        <h4>{{ $find_document->libelle }}</h4>
                        @if($find_document->reference)
                            <small class="text-muted">Réf: {{ $find_document->reference }}</small>
                        @endif
                    </div>
                @endif --}}
        </div>

    </div>

    {{-- @livewire('document.modal-document-share', ['document' => $find_document]) --}}

    <div class="modal fade" id="modal-new-archive" tabindex="-1" aria-labelledby="archiveModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archiveModalLabel">Archivage du document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('regidoc.documents.archive') }}" method="post" id="archiveForm">
                    @csrf
                    <input type="hidden" name="document_id" value="{{ $find_document->id }}">
                    
                    <div class="modal-body">
                        <!-- 1. Date d'émission -->
                        <div class="mb-3">
                            <label for="date_emission" class="form-label">Date d'émission</label>
                            @php
                                $dateArrive = $find_document->date_arrive ? (is_string($find_document->date_arrive) ? \Carbon\Carbon::parse($find_document->date_arrive) : $find_document->date_arrive) : now();
                            @endphp
                            <input type="text" class="form-control" id="date_emission" 
                                   value="{{ $dateArrive->format('d/m/Y') }}" 
                                   disabled>
                        </div>

                        <!-- 2. Émetteur -->
                        <div class="mb-3">
                            <label for="emetteur" class="form-label">Émetteur</label>
                            @if($find_document->type == 1)
                                <select class="form-select form-control select2" name="expediteur_externe" required
                                    data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                    data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierExpediteur" data-tags="true">
                                </select>
                            @elseif($find_document->type == 3)
                                <select class="form-select form-control select2" name="expediteur_externe" required
                                    data-get-items-route="{{ route('regidoc.ajax.getServices.json') }}"
                                    data-route=""
                                    data-method="get" data-label="titre"
                                    data-related-model="Service" data-tags="false">
                                </select>
                            @endif
                        </div>

                        <!-- 3. Rédacteur -->
                        <div class="mb-3">
                            <label for="redacteur" class="form-label">Rédacteur</label>
                            @if($find_document->type == 1)
                                <select class="form-select form-control select2" name="redacteur" required
                                    data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.redacteurs') }}"
                                    data-route="{{ route('regidoc.ajax.redacteurs.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom" data-max-selection="1"
                                    data-related-model="Redacteur" data-tags="true" multiple>
                                </select>
                            @elseif($find_document->type == 3)
                                <select class="form-select form-control select2" name="redacteur" required
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents.json') }}"
                                    data-route=""
                                    data-method="get" data-label="prenom,nom,post_nom"
                                    data-related-model="Agent" data-tags="false">
                                </select>
                            @endif
                        </div>

                        <!-- 4. Destination -->
                        <div class="mb-3">
                            <label for="destination" class="form-label">Destination</label>
                            @if($find_document->type == 1)
                                <select class="form-select form-control select2" name="destination" required
                                    data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.destinatairearchives') }}"
                                    data-route="{{ route('regidoc.ajax.destinatairearchives.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="Destination" data-tags="true" data-max-selection="1" multiple>
                                </select>
                            @elseif($find_document->type == 3)
                                <select class="form-select form-control select2" name="destination" required
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents.json') }}"
                                    data-route=""
                                    data-method="get" data-label="prenom,nom,post_nom"
                                    data-related-model="CourrierExpediteur" data-tags="true">
                                </select>
                            @endif
                        </div>

                        <!-- 5. Observations -->
                        <div class="mb-3">
                            <label for="observations" class="form-label">Observations</label>
                            <textarea class="form-control" id="observations" name="observations" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Archiver le document</button>
                    </div>
                </form>
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

@push('scripts')
<script>
// Initialisation/refixe Select2 dans le modal d'archivage pour garantir l'affichage correct
// et la gestion des tags (création via AJAX) comme ailleurs dans l'application.
$(document).on('shown.bs.modal', '#modal-new-archive', function () {
    const $modal = $(this);
    $modal.find('select.select2').each(function () {
        const $el = $(this);
        try { if ($el.data('select2')) { $el.select2('destroy'); } } catch (e) {}

        const cfg = {
            dropdownParent: $modal,
            tags: $el.data('tags') ? $el.data('tags') : false,
            placeholder: $el.data('placeholder') || 'Sélectionnez',
            language: 'fr',
            width: '100%',
            maximumSelectionLength: $el.data('max-selection') ? $el.data('max-selection') : null,
        };

        const getUrl = $el.data('get-items-route');
        if (getUrl) {
            cfg.ajax = {
                url: getUrl,
                dataType: 'json',
                delay: 250,
                headers: { 'Accept': 'application/json' },
                data: function (params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1,
                        model: $el.data('related-model'),
                        label: $el.data('get-items-field') || $el.data('label'),
                        method: $el.data('method') || 'get',
                        id: $el.data('id')
                    };
                },
                processResults: function (data) {
                    if (data && data.results) {
                        return { results: data.results, pagination: { more: !!(data.pagination && data.pagination.more) } };
                    }
                    if (data && data.data) {
                        const label = $el.data('get-items-field') || $el.data('label');
                        const items = data.data.map(function (item) {
                            return { id: item.id, text: item[label] || item.nom || item.titre };
                        });
                        return { results: items, pagination: { more: (data.current_page || 1) < (data.last_page || 1) } };
                    }
                    return { results: [] };
                }
            };
        }

        $el.select2(cfg);

        // Création dynamique (tags)
        $el.off('select2:select.modalTags').on('select2:select.modalTags', function (e) {
            if (!$el.data('tags')) return;
            const route = $el.data('route');
            const label = $el.data('get-items-field') || $el.data('label');
            const relativeId = $el.data('relative-id');
            const data = e.params.data;
            if (!route || !label || !data) return;

            // Si l'élément sélectionné possède déjà un id numérique, ce n'est pas un nouveau tag
            if (data.id && !isNaN(Number(data.id))) {
                return;
            }

            const csrf = $('meta[name="csrf-token"]').attr('content') || $modal.find('input[name="_token"]').val();
            $.ajax({
                url: route,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf },
                data: { [label]: data.text, relative_id: relativeId },
                success: function (resp) {
                    const newId = (resp && (resp.results?.id ?? resp.id)) ? (resp.results?.id ?? resp.id) : null;
                    if (newId) {
                        // 1) Supprimer l'option temporaire (id non numérique) déjà sélectionnée
                        if (data.id) {
                            $el.find('option').filter(function(){ return $(this).val() == String(data.id); }).remove();
                        }
                        // 2) Éviter un doublon éventuel si une option avec le même newId existe déjà
                        $el.find('option').filter(function(){ return $(this).val() == String(newId); }).remove();
                        // 2bis) Éviter un doublon sur le même libellé (au cas où une option avec même texte mais autre id existe)
                        $el.find('option').filter(function(){ return ($(this).text() || '').trim() === (data.text || '').trim(); }).remove();

                        // Si la sélection est limitée à 1, on forcera la valeur plus bas
                        const maxSel = $el.data('max-selection');

                        // 3) Ajouter l'option persistée (si elle n'existe pas déjà)
                        if ($el.find('option[value="' + String(newId) + '"]').length === 0) {
                            const option = new Option(data.text, newId, true, true);
                            $el.append(option);
                        }

                        if (maxSel && Number(maxSel) === 1) {
                            // Forcer explicitement la valeur unique sur le nouvel ID
                            $el.val([String(newId)]).trigger('change');
                        } else {
                            // Dédupliquer la sélection en mode multiple
                            let vals = $el.val() || [];
                            vals.push(String(newId));
                            const unique = Array.from(new Set(vals.filter(v => v != null && v !== '')));
                            $el.val(unique).trigger('change');
                        }
                    }
                },
                error: function (xhr) {
                    console.error('Echec de création du tag', xhr?.responseText || xhr);
                }
            });
        });
    });
});
</script>
@endpush
