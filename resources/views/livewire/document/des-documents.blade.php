{{-- Tabpane --}}

<div class="mt-0 row g-lg-3">
    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center content-list">
            <div class="col-lg-8 col-sm-8 col-9">
                <div class="d-flex">
                    <ul class="mb-0 nav nav-tabs nav-user" id="myTab" role="tablist" wire:ignore>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 1 ? 'active' : '' }}" id="all-tab"
                                data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab"
                                aria-controls="all" aria-selected="{{ $active_tab == 1 }}"
                                wire:click='changeTab(1)'>Tous mes documents</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 2 ? 'active' : '' }}" id="entrant-tab"
                                data-bs-toggle="tab" data-bs-target="#entrant" type="button" role="tab"
                                aria-controls="entrant" aria-selected="{{ $active_tab == 2 }}"
                                wire:click='changeTab(2)'>Documents partagés</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-3 d-flex align-items-center justify-content-end">
                <a href="{{ route('document.creation') }}" class="btn btn-add btn-add-hover ms-auto btn-doc-inbox"
                    style="flex: 0 0 auto;">
                    Créer un document
                </a>
            </div>
        </div>
        <div class="tab-content" id="myTabContent" style="border-radius: 12px">
            <div class="tab-pane  {{ $active_tab == 1 ? 'show active' : '' }}" id="all" role="tabpanel"
                aria-labelledby="all-tab">
                <div class="col-lg-12">
                    <div class="card card-table" style="overflow: inherit; border-radius: 12px;">
                        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
                            <div class="text-center m-auto">
                                <div class="spinner-border" role="status" style="color: var(--primaryColor)">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6 col-sm-6 col-xl-8">
                                <h4>Liste de mes documents</h4>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center mt-1">
                            <div class="col-lg-4">
                                <div class="col-lg-12">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model='search'>
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter(null)'>Par défaut</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("AtoZ")'>A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("ZtoA")'>Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("dateAdded")'>Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("dateModified")'>Date de
                                                        modification</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("shared")'>Documents
                                                        partagés</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 col-sm-8 col-lg-8">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <div class="input-group block-input-filter">
                                        @if (Auth::user()->agent->isDG())
                                            <select class="form-select form-control" name="lieu_query"
                                                wire:model.debounce.500ms="lieu_query">
                                                <option value="null" selected disabled>Lieu</option>
                                                <option value="">Toutes</option>
                                                @foreach ($lieus as $lieu)
                                                    <option value="{{ $lieu->id }}"
                                                        @selected(Auth::user()->agent->lieu->id == $lieu->id)>
                                                        {{ $lieu->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <select class="form-select form-control" name='direction_query'
                                                wire:model.debounce.500ms="direction_query">
                                                <option value=null selected disabled>Direction</option>
                                                <option value="">Tous</option>
                                                @foreach ($directions as $direction)
                                                    <option value="{{ $direction->id }}">
                                                        {{ $direction->titre }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-select form-control" name="division_query"
                                                wire:model.debounce.500ms="division_query">
                                                <option value=null selected disabled>Division</option>
                                                <option value="">Toutes</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}">
                                                        {{ $division->libelle }}</option>
                                                @endforeach
                                            </select>
                                            <select class="form-select form-control" name="agent_query"
                                                wire:model.debounce.500ms="agent_query">
                                                <option value=null selected disabled>Agent</option>
                                                <option value="">Tous</option>
                                                @foreach ($agents as $agent)
                                                    <option value="{{ $agent->id }}">
                                                        {{ $agent->nom . ' ' . $agent->prenom . ' ' . $agent->post_nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                        <select name="datep" id="jour" class="form-select form-control"
                                            wire:model.debounce.500ms='selectedDay'>
                                            <option value="null" selected disabled>Jour</option>
                                            @for ($i = 1; $i <= 30; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->day($i)->isoFormat('DD') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="mois" class="form-select form-control"
                                            wire:model.debounce.500ms='selectedMonth'>
                                            <option value="null" selected disabled>Mois</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->month($i)->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="annee" class="form-select form-control"
                                            style="border-right: none" wire:model.debounce.500ms='selectedYear'>
                                            <option value="null" selected disabled>Année</option>
                                            @for ($i = ((int) now()->year); $i > 1990; $i--)
                                                <option value="{{ $i }}">
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <button class="btn btn-add refresh-filter btn-search-sm" type="button"
                                            id="" wire:click="refreshSelection">
                                            <i class="fi fi-rr-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-3 mb-0">
                        <div class="table-responsive">
                            <div class="card card-table w-100" style="height: 250px" wire:loading>
                                <div class="d-flex justify-content-center h-100 align-items-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover" wire:loading.remove>
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Type de courrier</th>
                                        <th scope="col">Service initiateur</th>
                                        <th scope="col">Date de création</th>
                                        <th scope="col">Ajouté par</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($documents as $document)
                                        <tr>
                                            <td class="text-nowrap">
                                                {{-- <svg width="15px" height="auto" viewBox="0 0 384 512"
                                                    class="svg-icon-doc">
                                                    <path fill="red"
                                                        d="M181.9 256.1c-5-16-4.9-46.9-2-46.9c8.4 0 7.6 36.9 2 46.9m-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7c18.3-7 39-17.2 62.9-21.9c-12.7-9.6-24.9-23.4-34.5-40.8M86.1 428.1c0 .8 13.2-5.4 34.9-40.2c-6.7 6.3-29.1 24.5-34.9 40.2M248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24m-8 171.8c-20-12.2-33.3-29-42.7-53.8c4.5-18.5 11.6-46.6 6.2-64.2c-4.7-29.4-42.4-26.5-47.8-6.8c-5 18.3-.4 44.1 8.1 77c-11.6 27.6-28.7 64.6-40.8 85.8c-.1 0-.1.1-.2.1c-27.1 13.9-73.6 44.5-54.5 68c5.6 6.9 16 10 21.5 10c17.9 0 35.7-18 61.1-61.8c25.8-8.5 54.1-19.1 79-23.2c21.7 11.8 47.1 19.5 64 19.5c29.2 0 31.2-32 19.7-43.4c-13.9-13.6-54.3-9.7-73.6-7.2M377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9m-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9c37.1 15.8 42.8 9 42.8 9" />
                                                </svg> --}}

                                                <div class="d-flex align-items-center">
                                                    <svg class="svg-icon-doc" xmlns="http://www.w3.org/2000/svg"
                                                        width="0.75em" height="1em" viewBox="0 0 384 512">
                                                        <path fill="currentColor"
                                                            d="M181.9 256.1c-5-16-4.9-46.9-2-46.9c8.4 0 7.6 36.9 2 46.9m-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7c18.3-7 39-17.2 62.9-21.9c-12.7-9.6-24.9-23.4-34.5-40.8M86.1 428.1c0 .8 13.2-5.4 34.9-40.2c-6.7 6.3-29.1 24.5-34.9 40.2M248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24m-8 171.8c-20-12.2-33.3-29-42.7-53.8c4.5-18.5 11.6-46.6 6.2-64.2c-4.7-29.4-42.4-26.5-47.8-6.8c-5 18.3-.4 44.1 8.1 77c-11.6 27.6-28.7 64.6-40.8 85.8c-.1 0-.1.1-.2.1c-27.1 13.9-73.6 44.5-54.5 68c5.6 6.9 16 10 21.5 10c17.9 0 35.7-18 61.1-61.8c25.8-8.5 54.1-19.1 79-23.2c21.7 11.8 47.1 19.5 64 19.5c29.2 0 31.2-32 19.7-43.4c-13.9-13.6-54.3-9.7-73.6-7.2M377 105L279 7c-4.5-4.5-10.6-7-17-7h-6v128h128v-6.1c0-6.3-2.5-12.4-7-16.9m-74.1 255.3c4.1-2.7-2.5-11.9-42.8-9c37.1 15.8 42.8 9 42.8 9" />
                                                    </svg>
                                                    {{ Str::limit(Str::ucfirst($document->libelle), 30) ?? 'Non définie' }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ Str::ucfirst($document->reference) ?? 'Non définie' }}
                                            </td>
                                            <td>
                                                {{ Str::ucfirst($document->typeDocument?->titre) ?? 'Non définie' }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $document->author->service?->titre ?? 'Non définie' }}
                                            </td>
                                            <td>{{ $document->created_at->format('d/m/Y') ?? 'Non définie' }}</td>
                                            <td class="text-nowrap">
                                                {{ Str::ucfirst($document->author?->prenom ?? '') }}
                                                {{ Str::ucfirst($document->author?->nom ?? '') }}
                                            </td>
                                            <td>
                                                @if (
                                                    ($document->courrier?->isIntern() &&
                                                        is_array($document->courrier?->destinateurs->pluck('id')->toArray()) &&
                                                        in_array(Auth::user()->agent->id, $document->courrier?->destinateurs->pluck('id')->toArray())) ||
                                                        (is_array($document->courrier?->followers->pluck('id')->toArray()) &&
                                                            in_array(Auth::user()->agent->id, $document->courrier?->followers->pluck('id')->toArray())) ||
                                                        $document->courrier?->created_by == Auth::user()->agent->id ||
                                                        $document->created_by == Auth::user()->agent->id ||
                                                        Auth::user()->agent->isDG())
                                                    <div class="d-flex align-items-center">
                                                        <a class="btn"
                                                            href="{{ route('regidoc.documents.show', $document) }}">
                                                            <i class="fi fi-rr-eye" class="me-1"></i>
                                                            <div class="tooltip-btn">Voir détails</div>
                                                        </a>
                                                        @can('Signer un courrier')
                                                            <a href="{{ route('regidoc.documents.sign', ['doc_id' => $document?->id, 'is_original' => true, 'courrier_id' => $document->courrier?->id]) }}"
                                                                class="btn">
                                                                <i class="fi fi-rr-feather" class="me-1"></i>
                                                                <div class="tooltip-btn">Signer</div>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                Aucun document trouvé
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if (count($documents))
                            {{ $documents->links() }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="tab-pane  {{ $active_tab == 2 ? 'show active' : '' }}" id="entrant" role="tabpanel"
                aria-labelledby="entrant-tab">
                <div class="col-lg-12">
                    <div class="card card-table" style="overflow: inherit">
                        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
                            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
                            <div class="text-center m-auto">
                                <div class="spinner-border" role="status" style="color: var(--primaryColor)">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-lg-6 col-sm-6 col-xl-8">
                                <h4 class="mb-0">Liste des documents partagés</h4>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center mt-1">
                            <div class="col-lg-6 col-md-6">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2 input-search-card"
                                            placeholder="Recherche" style="border:none;" wire:model='search'>
                                        <div class="dropdown">
                                            <button class="btn btn-filter me-2" id="dropdownMenuButton1"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg data-name="Layer 1" viewBox="0 0 24 24" width="512"
                                                    height="512">
                                                    <path
                                                        d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z" />
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter(null)'>Par défaut</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("AtoZ")'>A - Z</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("ZtoA")'>Z - A</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("dateAdded")'>Date d'ajout</a>
                                                </li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("dateModified")'>Date de
                                                        modification</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0)"
                                                        wire:click='changeFilter("shared")'>Documents
                                                        partagés</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-12 col-md-6 col-sm-6 col-lg-6 d-flex align-items-center justify-content-lg-end gap-2">
                                <div class="d-flex align-items-center justify-content-end gap-2 w-100">
                                    <div class="input-group block-input-filter">
                                        <select name="datep" id="jour" class="form-select form-control"
                                            wire:model.debounce.500ms='selectedDay'>
                                            <option value="null" selected disabled>Jour</option>
                                            @for ($i = 1; $i <= 30; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->day($i)->isoFormat('DD') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="mois" class="form-select form-control"
                                            wire:model.debounce.500ms='selectedMonth'>
                                            <option value="null" selected disabled>Mois</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->month($i)->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="annee" class="form-select form-control"
                                            style="border-right: none" wire:model.debounce.500ms='selectedYear'>
                                            <option value="null" selected disabled>Année</option>
                                            @for ($i = ((int) now()->year); $i > 1990; $i--)
                                                <option value="{{ $i }}">
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <button class="btn btn-add refresh-filter btn-search-sm" type="button"
                                            id="" wire:click="refreshSelection">
                                            <i class="fi fi-rr-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-3 mb-0">
                        <div class="table-responsive">
                            <div class="card card-table w-100" style="height: 250px" wire:loading>
                                <div class="d-flex justify-content-center h-100 align-items-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover" wire:loading.remove>
                                <thead>
                                    <tr>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Référence</th>
                                        <th scope="col">Type de document</th>
                                        <th scope="col">Service initiateur</th>
                                        <th scope="col">Date de création</th>
                                        <th scope="col">Ajouté par</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($shareds as $document)
                                        <tr>
                                            <td class="text-nowrap">
                                                {{ Str::limit(Str::ucfirst($document->libelle), 30) ?? 'Non définie' }}
                                            </td>
                                            <td>
                                                {{ Str::ucfirst($document->reference) ?? 'Non définie' }}
                                            </td>
                                            <td>
                                                {{ Str::ucfirst($document->typeDocument?->titre) ?? 'Non définie' }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ $document->author->service?->titre ?? 'Non définie' }}
                                            </td>
                                            <td>{{ $document->created_at->format('d/m/Y') ?? 'Non définie' }}</td>
                                            <td class="text-nowrap">
                                                {{ Str::ucfirst($document->author?->prenom ?? '') }}
                                                {{ Str::ucfirst($document->author?->nom ?? '') }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a class="btn"
                                                        href="{{ route('regidoc.documents.show', $document) }}">
                                                        <i class="fi fi-rr-eye" class="me-1"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                    @can('Signer un courrier')
                                                        <a href="{{ route('regidoc.documents.sign', ['doc_id' => $document?->id, 'is_original' => true, 'courrier_id' => $document->courrier?->id]) }}"
                                                            class="btn">
                                                            <i class="fi fi-rr-feather" class="me-1"></i>
                                                            <div class="tooltip-btn">Signer</div>
                                                        </a>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                Aucun document trouvé
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if (count($shareds))
                            {{ $shareds->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
