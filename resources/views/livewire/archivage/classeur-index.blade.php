<div class="col-lg-12">
    <div class="card card-table" style="overflow: inherit">
        <div class="row g-1">
            <div class="col-lg-7 col-sm-6">
                <h4 class="mb-0">Classeurs {{ $annee }}</h4>
            </div>
            <div class="col-lg-5 col-sm-6">
                <div class="d-flex align-items-center justify-content-end">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter  d-flex text-nowrap" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- <i class="fi fi-rr-filter me-2"></i> {{ $filterText }} --}}
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                </path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-4">
            @forelse ($classeurs as $classeur)
                <div class="col-lg-3">
                    <div class="col-folder">
                        <a href="{{ route('regidoc.archive-classeurs.show', $classeur) }}">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/icons/Fichier 27.png') }}" alt=""
                                    class="me-2">
                                <div class="text-star">
                                    <h6 class="text-capitalize">{{ $classeur->titre }}</h6>
                                    <p>Ref: {{ $classeur->reference }}</p>
                                    <p>Créé le: {{ $classeur->created_at->format('m/d/Y') }}</p>
                                </div>
                            </div>
                        </a>
                        {{-- <div class="block-options">
                                <div class="dropdown">
                                    <i class="fi fi-rr-menu-dots-vertical"></i>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#detail-classeur-{{ $classeur->id }}">
                                                <i class="fi fi-rr-eye" class="me-1"></i> Voir détails
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="">
                                                <i class="fi fi-rr-edit" class="me-1"></i> Modifier
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-{{ $classeur->id }}">
                                                <i class="fi fi-rr-trash" class="me-1"></i>Supprimer
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> --}}
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <p>Aucun classeur trouvé</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
