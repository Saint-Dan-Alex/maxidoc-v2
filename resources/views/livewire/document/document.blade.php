<div class="col-lg-12">
    <div class="card card-table" style="overflow: inherit">
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        <div class="row g-3">
            {{-- <div class="col-lg-9 col-sm-9">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 align-items-center bread-folder">
                        <li class="breadcrumb-item"><a href="{{url()->previous()}}"><i class="fi fi-rr-folder me-2"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fi fi-rr-angle-right me-2"></i>
                            {{ $dossier->titre }}</li>
                    </ol>
                </nav>
            </div> --}}
            <div class="col-lg-12 d-none d-sm-block col-sm-12">
                <div class="d-flex align-items-center justify-content-end">

                    <a href="{{ route('regidoc.documents.create') . '?dossier=' . $dossier->id }}" class="btn btn-add "
                        style="flex: 0 0 auto;">
                        Numériser
                    </a>
                    {{-- <a href="{{ route('regidoc.documents.createNew').'?dossier='.$dossier->id }}" class="btn btn-add ms-2 btn-add-hover" style="flex: 0 0 auto;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus d-flex d-lg-none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Créer un courrier</span>
                    </a> --}}
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-xl-8">
                <h4>Liste des documents</h4>
            </div>
            {{-- <h4 class="mb-1">Dossier {{ $dossier->titre }}</h4>
                <p class="mb-1">Ref: 000</p>
                <p>Créé le: 02/04/2023</p> --}}
            <div class="col-lg-6 col-sm-6 col-xl-4">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter me-2" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z" />
                            </svg>
                            {{-- <i class="fi fi-rr-filter me-2"></i> --}}
                            {{-- {{ $filterText }} --}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                    modification</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <hr class="mt-3 mb-0">
        <div class="table-responsive">
            <table class="table table-hover">
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
                    @forelse ($documents as $document)
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
                                    <a class="btn" href="{{ route('regidoc.documents.show', $document) }}">
                                        <i class="fi fi-rr-eye" class="me-1"></i>
                                        <div class="tooltip-btn">Voir détails</div>
                                    </a>
                                    @if (Auth::user()->agent->isDG())
                                        <a class="btn" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal-new-task-ass">
                                            <i class="fi fi-rr-share" class="me-1"></i>
                                            <div class="tooltip-btn">Partager</div>
                                        </a>
                                    @endif
                                    {{-- <a class="btn" href="{{ files($document?->document)->link }}"
                                        download="{{ files($document?->document)->link }}">
                                        <i class="fi fi-rr-download" class="me-1"></i>
                                        <div class="tooltip-btn">Télécharger</div>
                                    </a>
                                    <a class="btn" href="{{ route('regidoc.documents.edit', $document) }}">
                                        <i class="fi fi-rr-edit" class="me-1"></i>
                                        <div class="tooltip-btn">Modifier</div>
                                    </a>
                                    <a class="btn" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-document-{{ $document->id }}">
                                        <i class="fi fi-rr-trash" class="me-1"></i>
                                        <div class="tooltip-btn">Supprimer</div>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Aucun courrier entrant
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- <div class="row g-3 g-lg-5">
            @forelse ($documents as $document)
                <div class="col-lg-4">
                    <div class="col-folder">
                        <a href="{{ route('regidoc.documents.show', $document) }}">
                            <div class="d-flex align-items-center">
                                <img src="{{ fileIcon($document?->document) }}" alt="" class="me-2 img-file">
                                <div class="text-star">

                                    <h6>{{ Str::ucfirst($document->libelle) }}</h6>
                                    <p>Ref : {{ Str::ucfirst($document->reference) }}</p>
                                    <p>Ajouté le: {{ $document->created_at->format('d/m/Y h:i') }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="block-options">
                            <div class="dropdown">
                                <i class="fi fi-rr-menu-dots-vertical"></i>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-new-task-ass">
                                            <i class="fi fi-rr-share" class="me-1"></i> Assigner
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('regidoc.documents.show', $document) }}">
                                            <i class="fi fi-rr-eye" class="me-1"></i> Voir détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ files($document?->document)->link }}" download="{{ files($document?->document)->link }}">
                                            <i class="fi fi-rr-download" class="me-1"></i> Télécharger
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('regidoc.documents.edit', $document) }}">
                                            <i class="fi fi-rr-edit" class="me-1"></i> Modifier
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-document-{{ $document->id }}">
                                            <i class="fi fi-rr-trash" class="me-1"></i>Supprimer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="top-0 dropdown position-absolute" style="right: 0;">
                            <button class="btn" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="true" style="font-size: 14px;">
                                <i class="fi fi-rr-menu-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1"
                                data-popper-placement="bottom-end">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-new-task-ass">
                                        <i class="fi fi-rr-share" class="me-1"></i> Assigner
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ files($document?->document)->link }}"
                                        download="{{ files($document?->document)->link }}">
                                        <i class="fi fi-rr-download" class="me-1"></i> Télécharger
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('regidoc.documents.edit', $document) }}">
                                        <i class="fi fi-rr-edit" class="me-1"></i> Modifier
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-document-{{ $document->id }}">
                                        <i class="fi fi-rr-trash" class="me-1"></i>Supprimer
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px" class="">
                    <p>Aucun document trouvé</p>
                </div>
            @endforelse
        </div> --}}
    </div>
</div>
