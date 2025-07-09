<div class="col-lg-12">
    <div class="pt-4 card card-table">
        <div class="row g-1">
            <div class="col-lg-7 col-sm-6">
                <p class="mb-0"><small>Classeur</small></p>
                <h4 class="mb-1">{{ $classeur->titre }}</h4>
                {{-- <p class="mb-0">Ref: {{ $classeur->reference }}</p>
                <p>Créé le: {{ $classeur->created_at->format('d/m/Y') }}</p> --}}
            </div>
            <div class="col-lg-5 col-sm-6">
                <div class="d-flex justify-content-center align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter d-flex text-nowrap" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{-- <i class="fi fi-rr-filter me-2"></i> {{ $filterText }} --}}
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                </path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)"
                                    wire:click='changeFilter(1)'>Filtre</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-3 mb-3">
        <div class="row g-3 g-lg-5">
            @forelse ($dossiers as $dossier)
                <div class="col-lg-3">
                    <div class="col-folder">
                        <a
                            href="{{ route('regidoc.archive-classeurs.archive-dossiers.show', [$dossier->classeur, $dossier]) }}">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/icons/Fichier 22.png') }}" alt=""
                                    class="me-2">
                                <div class="text-star">
                                    <h6>{{ Str::ucfirst($dossier->titre) }}</h6>
                                    <p>Ref: {{ $dossier->reference }}</p>
                                    <p>Créé le: {{ $dossier->created_at->format('m-d-Y') }}</p>
                                </div>
                            </div>
                        </a>
                        {{-- <div class="block-options">
                            <div class="dropdown">
                                <i data-feather="more-horizontal"></i>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="share-2" class="me-1"></i> Partager
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="eye" class="me-1"></i> Voir détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="download" class="me-1"></i> Télécharger
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i data-feather="trash" class="me-1"></i>Supprimer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <p>Aucun dossiers trouvé</p>
                </div>
            @endforelse

        </div>

    </div>

</div>
