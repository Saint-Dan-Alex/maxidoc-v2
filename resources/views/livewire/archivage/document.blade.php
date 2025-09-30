<div class="col-lg-12">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <p class="bg-white p-2 rounded">
            @php
                // Charger les relations nécessaires
                $dossier->load([
                    'classeur',
                    'author.direction',
                    'author.service',
                    'documents.category',
                    'documents.nature'
                ]);

                $breadcrumbs = [];
                
                // 1. Année de création du classeur
                $breadcrumbs[] = $dossier->classeur->created_at->format('Y');
                
                // 2. Nom du classeur
                $breadcrumbs[] = $dossier->classeur->titre;
                
                // 3. Direction de l'agent qui a créé le dossier
                if ($dossier->author && $dossier->author->direction) {
                    $breadcrumbs[] = $dossier->author->direction->titre;
                }
                
                // 4. Service de l'agent qui a créé le dossier
                if ($dossier->author && $dossier->author->service) {
                    $breadcrumbs[] = $dossier->author->service->titre;
                }
                
                // 5. Catégorie du premier document du dossier
                if ($dossier->documents->isNotEmpty() && $dossier->documents->first()->category) {
                    $breadcrumbs[] = $dossier->documents->first()->category->title;
                }
                
                // 6. Nature du premier document du dossier
                if ($dossier->documents->isNotEmpty() && $nature = $dossier->documents->first()->nature) {
                    $breadcrumbs[] = $nature->titre;
                }
            @endphp
            
            @foreach($breadcrumbs as $index => $item)
                @if($loop->last)
                    <span class="text-primary text-capitalize">{{ $item }}</span>
                @else
                    {{ $item }}
                    @if(!$loop->last) / @endif
                @endif
            @endforeach
        </p>
        
        {{-- <a href="@if (count($documents)) {{ route('regidoc.archive-classeurs.archive-dossiers.show', [$documents[0]->dossier->classeur, $documents[0]->dossier]) }} @else {{ back() }} @endif"
            class="back">
            <i class="fi fi-rr-angle-left"></i> Retour
        </a> --}}
        {{-- <div class="col-10 d-flex align-items-center justify-content-end"> --}}

        {{-- <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-archive-document">Ajouter</button> --}}
        {{-- </div> --}}
    </div>
    @can('Archiver')
    <div class="d-flex align-items-center justify-content-between my-2">
        <h1 class="mb-0 "></h1>
        <a href="{{ route('regidoc.archivages.create') }}" class="btn" style="background: var(--bgBtnPrimary); color: var(--whiteColor); font-size: 14px; padding: 10px 24px; font-weight: 600; border-radius: 12px; display: inline-flex; align-items: center;">
           
            <span>Archiver un document</span>
        </a>
    </div>
    @endcan
    <div class="pb-5 card card-table position-relative" style="overflow:inherit; min-height: 200px;">
        <!-- Overlay de chargement -->
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="search,lieu_query,direction_query,division_query,agent_query,selectedDay,selectedMonth,selectedYear,filter,resetFilters" 
            wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border" role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        <!-- Ligne du titre -->
        <div class="mb-3">
            <p class="mb-0"><small>Dossier</small></p>
            <h4 class="mb-0">{{ Str::ucfirst($dossier->titre) }}</h4>
        </div>
        
        <!-- Ligne des filtres et recherche -->
        <div class="d-flex align-items-center justify-content-between position-relative">
            <!-- Barre de recherche -->
            <div class="d-flex align-items-center" style="width: 300px;">
                <input type="text" class="form-control input-search-card" placeholder="Recherche"
                    style="border:none;" wire:model.debounce.500ms='search'>
            </div>
            
            <!-- Filtres avancés -->
            <div class="d-flex align-items-center gap-2">
                <!-- Bouton de tri -->
                <div class="dropdown">
                    <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false" title="Trier par">
                        <svg data-name="Layer 1" viewBox="0 0 24 24" width="20" height="20">
                            <path
                                d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                            </path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par défaut</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A - Z</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z - A</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date d'ajout</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de modification</a></li>
                    </ul>
                </div>
                
                <!-- Filtres avancés -->
                <div class="input-group block-input-filter">
                    @if (Auth::user()->agent->isDG())
                        <select class="form-select form-control" name="lieu_query"
                            wire:model.debounce.500ms="lieu_query" title="Filtrer par lieu">
                            <option value="" selected>Lieu</option>
                            @foreach ($lieus as $lieu)
                                <option value="{{ $lieu->id }}">
                                    {{ $lieu->titre }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <select class="form-select form-control" name='direction_query'
                            wire:model.debounce.500ms="direction_query" {{ !$directions->count() ? 'disabled' : '' }} title="Filtrer par direction">
                            <option value="" selected>Direction</option>
                            @foreach ($directions as $direction)
                                <option value="{{ $direction->id }}">
                                    {{ $direction->titre }}
                                </option>
                            @endforeach
                        </select> --}}
                        {{-- <select class="form-select form-control" name="division_query"
                            wire:model.debounce.500ms="division_query" {{ !$divisions->count() ? 'disabled' : '' }} title="Filtrer par division">
                            <option value="" selected>Division</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">
                                    {{ $division->libelle }}
                                </option>
                            @endforeach
                        </select> --}}
                        {{-- <select class="form-select form-control" name="agent_query"
                            wire:model.debounce.500ms="agent_query" {{ !$agents->count() ? 'disabled' : '' }} title="Filtrer par agent">
                            <option value="" selected>Agent</option>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}">
                                    {{ $agent->nom . ' ' . $agent->prenom }}
                                </option>
                            @endforeach
                        </select> --}}
                    @endif
                    <select name="datep" id="jour" class="form-select form-control"
                        wire:model.debounce.500ms='selectedDay' title="Filtrer par jour">
                        <option value="" selected>Jour</option>
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select name="datep" id="mois" class="form-select form-control"
                        wire:model.debounce.500ms='selectedMonth' title="Filtrer par mois">
                        <option value="" selected>Mois</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">
                                {{ now()->month($i)->isoFormat('MMMM') }}
                            </option>
                        @endfor
                    </select>
                    <select name="datep" id="annee" class="form-select form-control"
                        style="border-right: none" wire:model.debounce.500ms='selectedYear' title="Filtrer par année">
                        <option value="" selected>Année</option>
                        @for ($i = ((int) now()->year); $i > 1990; $i--)
                            <option value="{{ $i }}">
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <!-- Bouton de réinitialisation -->
                <button class="btn btn-sm btn-outline-secondary" wire:click="resetFilters" title="Réinitialiser les filtres">
                    <i class="fi fi-rr-refresh"></i>
                </button>
            </div>
        </div>
        
        <hr class="mt-3 mb-4">
        <div class="row g-3 g-lg-5">
            @forelse ($paginatedDocuments as $document)
                <div class="col-lg-3">
                    <div class="col-folder">
                        @if (Str::startsWith($document->reference, 'DAA/'))
                            @php
                                $url = json_decode($document?->document);
                            @endphp
                        @endif
                        <a
                            href="{{ Str::startsWith($document->reference, 'DAA/') ? route($url->url, ['agent' => $url->agent, 'doc' => $url->doc]) : route('regidoc.archive-documents.show', $document) }}">
                            <div class="d-flex align-items-center">
                                @if (Str::startsWith($document->reference, 'DAA/') == false)
                                    <img src="{{ fileIcon($document?->document) }}" alt=""
                                        class="me-2 img-file">
                                @else
                                    <img src="{{ asset('assets/regidoc/icon.png') }}" alt=""
                                        class="me-2 img-file">
                                @endif
                                <div class="text-star">

                                    <h6 class="text-capitalize">{{ Str::ucfirst($document->libelle) }}</h6>
                                    <p>Reférence : {{ Str::ucfirst($document->reference) }}</p>
                                    <p>Archivé le : {{ \Carbon\Carbon::parse($document->archived_at)->format('d/m/Y h:i') }}</p>

                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <p>Aucun document trouvé</p>
                </div>
            @endforelse
            
            <!-- Pagination -->
            <div class="col-12">
                <div class="d-flex justify-content-center mt-4">
                    {{ $paginatedDocuments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
