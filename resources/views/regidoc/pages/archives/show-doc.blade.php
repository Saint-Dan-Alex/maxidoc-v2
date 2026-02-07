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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorBox = document.getElementById('document-error');
            document.querySelectorAll('.document-item').forEach(function(item){
                item.addEventListener('click', function(e){
                    e.preventDefault();
                    const url = this.getAttribute('data-url');
                    const name = this.textContent.trim();
                    
                    if (!url) {
                        errorBox.style.display = 'block';
                        errorBox.textContent = 'Format non supporté';
                        return;
                    }
                    
                    errorBox.style.display = 'none';
                    
                    // Mise à jour du bouton dropdown
                    const dropdownButton = document.getElementById('documentDropdown');
                    if (dropdownButton) dropdownButton.textContent = name;
                    
                    // Utilisation de showPDF si disponible
                    if (typeof showPDF === 'function') {
                        showPDF(url);
                    } else {
                        console.error('showPDF function not found');
                    }

                    document.querySelectorAll('.document-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
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
                        @can('Suivi des courriers')
                            <div class="block-assign" data-bs-toggle="offcanvas" data-bs-target="#offcanvasHistoDocArch" aria-controls="offcanvasHistoDocArch">
                                <i class="fi fi-rr-list"></i>
                                Historique des activités
                            </div>
                        @endcan
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
                                        <label for="inputPassword" class="col-form-label">N° d'enregistrement</label>
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

                            @if($find_document->emetteur)
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <label for="inputPassword" class="col-5 col-form-label">Emetteur</label>
                                        <div class="col-7">
                                            @if($find_document->type==1)
                                                <p class="items">
                                                    {{ $find_document->externExpediteur->nom ?? 'Non défini' }}
                                                </p>
                                            @else
                                            <p class="items">
                                                {{ $find_document->service->titre ?? 'Non défini' }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            
                            @endif
                        @endif
                        
                        @if($find_document->destination_id)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Destination</label>
                                <div class="col-7">
                                    @if($find_document->type==1)
                                        <p class="items">
                                            {{ optional($find_document->destination)->nom ?? 'Non défini' }}
                                        </p>
                                    @else
                                        <p class="items">
                                            {{$find_document->agentDest->nom }}  {{$find_document->agentDest->prenom }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($find_document->redacteur_id)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Rédacteur</label>
                                <div class="col-7">
                                    @if($find_document->type==1)
                                    <p class="items">
                                        {{ optional($find_document->redacteur)->nom ?? 'Non défini' }}
                                    </p>
                                    @else
                                    <p class="items">
                                        {{ $find_document->agent->nom }} {{$find_document->agent->prenom}}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif




                        @if($find_document->type)
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
                        @if($find_document->nature_id)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="inputPassword" class="col-5 col-form-label">Nature</label>
                                    </div>
                                    <div class="col-7">
                                        <p class="items mb-0">{{ $find_document->nature->titre ?? 'Non défini' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($find_document->service)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-5">
                                        <label for="inputPassword" class="col-5 col-form-label">Service initiateur</label>
                                   
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
                        @if ($find_document->date_du_courrier)
                        <div class="col-12">
                            <div class="row align-items-center">
                                <label for="inputPassword" class="col-5 col-form-label">Date du document</label>
                                <div class="col-7">
                                    <p class="items">
                                        {{ \Carbon\Carbon::parse($find_document->date_du_courrier)->isoFormat('LL') }}
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
                                $docIsPdf = true;

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
                                    if ($docUrl) {
                                        $pathFromUrl = parse_url($docUrl, PHP_URL_PATH) ?: $docUrl;
                                        $docIsPdf = \Illuminate\Support\Str::endsWith(strtolower($pathFromUrl), '.pdf');
                                    }
                                }
                            @endphp
                            @php
                                $attachments = [];
                                foreach ($find_document->piecesJointes as $piece) {
                                    $url = $piece->url;
                                    $pathFromUrl = parse_url($url, PHP_URL_PATH);
                                    $isPdf = \Illuminate\Support\Str::endsWith(strtolower($pathFromUrl ?? ''), '.pdf');
                                    $attachments[] = [
                                        'url' => $url,
                                        'name' => $piece->original_name ?? $piece->nom,
                                        'is_pdf' => $isPdf,
                                    ];
                                }
                                if ($find_document->taches) {
                                    foreach ($find_document->taches as $tache) {
                                        if ($tache->documents) {
                                            foreach ($tache->documents as $doc) {
                                                try {
                                                    $fileObj = files($doc->document);
                                                    if ($fileObj && !empty($fileObj->link)) {
                                                        $url = str_replace('\\', '/', $fileObj->link);
                                                        $pathFromUrl = parse_url($url, PHP_URL_PATH);
                                                        $attachments[] = [
                                                            'url' => $url,
                                                            'name' => $fileObj->name ?? basename($url),
                                                            'is_pdf' => \Illuminate\Support\Str::endsWith(strtolower($pathFromUrl ?? ''), '.pdf'),
                                                        ];
                                                    }
                                                } catch (\Throwable $e) {
                                                }
                                            }
                                        }
                                    }
                                }
                                $attachments = collect($attachments)->filter(fn($a) => !empty($a['url']))->unique('url')->values()->all();
                            @endphp
                            {{ $docName }}
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="documentDropdown">
                            @if($docUrl)
                                <li>
                                    <a class="dropdown-item document-item active" 
                                       href="javascript:void(0)"
                                       data-url="{{ asset('storage/' . $docUrl) }}"
                                       data-type="{{ $docIsPdf ? 'pdf' : 'image' }}">
                                        <i class="fi fi-rr-file me-2"></i>
                                        {{ $docName }} (principal)
                                    </a>
                                </li>
                            @endif
                            
                            @if(isset($attachments) && count($attachments) > 0)
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-header">Pièces jointes</li>
                                @foreach($attachments as $att)
                                    <li>
                                        <a class="dropdown-item document-item" 
                                           href="javascript:void(0)"
                                           data-url="{{ $att['url'] }}"
                                           data-type="{{ $att['is_pdf'] ? 'pdf' : 'image' }}">
                                            <i class="fi fi-rr-file me-2"></i>
                                            {{ $att['name'] }}
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
                        $initialUrl = $docUrl ? asset('storage/' . $docUrl) : '';
                    @endphp
                    <div id="pdf-main-container" 
                         style="width: 100%; min-height: 80vh;"
                         data-url="{{ $initialUrl }}" 
                         data-name="{{ $docName }}" 
                         data-courrier="{{ $find_document->courrier_id ?? '' }}" 
                         data-tache="" 
                         data-docid="{{ $find_document->id }}" 
                         data-code="" 
                         data-original="true">
                        <div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
                            {{-- Le script showPDF.js va injecter le contenu ici --}}
                        </div>
                        @include('components.pdf-tools')
                    </div>
                </div>
            </div>
        </div>

    </div>

    @can('Suivi des courriers')
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHistoDocArch" aria-labelledby="offcanvasHistoDocArchLabel">
            <div class="offcanvas-header align-items-center">
                <h5 class="offcanvas-title" id="offcanvasHistoDocArchLabel">Historique des activités</h5>
                <div class="d-flex align-items-center">
                    <a href="{{ $find_document->courrier ? route('regidoc.courriers.export-historique', $find_document->courrier->id) : route('regidoc.documents.export-historique', $find_document->id) }}" class="btn btn-sm btn-outline-primary me-2" target="_blank" title="Exporter l'historique en PDF">
                        <i class="fi fi-rr-print"></i>
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                        <i class="fi fi-rr-cross"></i>
                    </button>
                </div>
            </div>
            <div class="offcanvas-body">
                <div class="block-activity">
                    @php
                        $historiques = collect();
                        if ($find_document->courrier) {
                            $historiques = $historiques->merge($find_document->courrier->history);
                        }
                        $historiques = $historiques->merge($find_document->history);
                        $historiques = $historiques->sortByDesc('created_at');
                        $historiquesGroup = $historiques->groupBy('user_id');
                        $revision = new \Venturecraft\Revisionable\Revision();
                    @endphp
                    @foreach ($historiquesGroup as $user_id => $historiques)
                        @php
                            $user = \App\Models\User::find($user_id);
                        @endphp
                        <div class="items-activity">
                            <div class="avatar-activ">
                                <img src="{{ imageOrDefault($user?->agent->image) }}" alt="">
                            </div>
                            <p class="agent">
                                <span>{{ $user?->agent->prenom . ' ' . $user?->agent->nom }}</span>
                                - {{ $user?->agent?->poste?->titre }}
                            </p>
                            @foreach ($historiques ?? [] as $history)
                                @if ($history instanceof $revision)
                                    @if ($history->key == 'created_at' && !$history->old_value)
                                        <div class="mt-2 block-dot-line">
                                            @if ($history->revisionable_type == 'App\\Models\\Courrier')
                                                <div class="dot-line">
                                                    <p>Création de ce courrier</p>
                                                    <div class="date">{{ $history->newValue() }}</div>
                                                </div>
                                            @elseif ($history->revisionable_type == 'App\\Models\\Document')
                                                <div class="dot-line">
                                                    <p>Numérisation des documents du courrier</p>
                                                    <div class="date">{{ $history->newValue() }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="mt-2 block-dot-line">
                                            @if ($history->revisionable_type == 'App\\Models\\Courrier')
                                                <div class="dot-line">
                                                    <p>
                                                        Modification sur {{ $history->fieldName() }} du courrier
                                                    </p>
                                                    <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}</div>
                                                </div>
                                            @elseif ($history->revisionable_type == 'App\\Models\\Document')
                                                <div class="dot-line">
                                                    <p>
                                                        Modification sur {{ $history->fieldName() }} du document de ce
                                                        courrier
                                                    </p>
                                                    <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <div class="mt-2 block-dot-line">
                                        <div class="block-dot-line-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48">
                                                <circle cx="24" cy="24" r="21" fill="currentColor" />
                                                <path fill="#ffffff" d="M34.6 14.6L21 28.2l-5.6-5.6l-2.8 2.8l8.4 8.4l16.4-16.4z" />
                                            </svg>
                                        </div>
                                        <div class="dot-line">
                                            <p> <span> {{ $history->description }}</span></p>
                                            <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}</div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endcan

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
<script src="{{ asset('assets/js/showPDF.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js?v=1"></script>
@endpush
