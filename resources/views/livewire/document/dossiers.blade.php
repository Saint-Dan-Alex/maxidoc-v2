<div class="col-lg-12">

    <div class="card card-table" style="overflow: inherit">

        <div class="d-none position-absolute d-flex loader-card justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        <div class="row g-1 align-items-center">
            <div class="col-lg-6 col-sm-6">
                <h4 class="mb-lg-1 mb-0">{{ $classeur->titre }}</h4>
                <p class="mb-lg-1 mb-0">Réf: {{ $classeur->reference ?? '' }}</p>
                <p class="mb-lg-0 mb-0">Créé le: {{ $classeur->created_at }}</p>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="d-flex align-items-end justify-content-end flex-column gap-2">
                    <button class="btn btn-add text-nowrap" data-bs-toggle="modal"
                        data-bs-target="#modal-new-archive-dossier">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-plus d-block d-sm-none">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        <span>Créer un dossier</span>
                    </button>
                    <div class="d-flex align-items-center w-100">
                        <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter d-flex" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{-- <i class="fi fi-rr-filter me-2"></i> --}}
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z" />
                            </svg>
                            {{-- {{ $filterText }} --}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                    modification</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row g-3 g-lg-5">

            @forelse ($dossiers as $dossier)
                <div class="col-lg-4 col-sm-4 col-xxl-3 col-xl-4 col-12">
                    <div class="col-folder">
                        <a href="@if (!$dossier->confidentiel) {{ route('regidoc.classeurs.dossiers.show', [$dossier->classeur, $dossier]) }} @else # @endif"
                            @if ($dossier->confidentiel) data-bs-toggle="modal" data-bs-target="#modal-pass-dossier-{{ $dossier->id }}" @endif>
                            <div class="d-flex align-items-center">
                                @if ($dossier->confidentiel)
                                    <img src="{{ asset('assets/images/icons/lockedfolder-regidoc.svg') }}"
                                        alt="" class="me-2">
                                @else
                                    <img src="{{ asset('assets/images/icons/folderAds.png') }}" alt=""
                                        class="me-2">
                                @endif

                                <div class="text-star">

                                    <h6>{{ Str::ucfirst($dossier->titre) }}</h6>
                                    <p>Ref: {{ $dossier->reference }}</p>
                                    <p>Créé le: {{ $dossier->created_at->format('m-d-Y') }}</p>
                                </div>
                            </div>
                        </a>
                        {{-- <div class="block-options">
                            <div class="dropdown">
                                <i class="fi fi-rr-menu-dots-vertical"></i>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="fi fi-rr-share" class="me-1"></i> Partager
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="offcanvas" data-bs-target="#detail-dossier-{{ $dossier->id }}">
                                            <i class="fi fi-rr-eye" class="me-1"></i> Voir détails
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-edit-archive-dossier-{{ $dossier->id }}">
                                            <i class="fi fi-rr-edit" class="me-1"></i> Modifier
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-dossier-{{ $dossier->id }}">
                                            <i class="fi fi-rr-trash" class="me-1"></i>Supprimer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="top-0 dropdown position-absolute" style="right: 0;">
                            <button class="btn" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="true" style="font-size: 14px;">
                                <i class="fi fi-rr-menu-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1"
                                data-popper-placement="bottom-end">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#detail-dossier-{{ $dossier->id }}">
                                        <i class="fi fi-rr-eye" class="me-1"></i> Voir détails
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-archive-dossier-{{ $dossier->id }}">
                                        <i class="fi fi-rr-edit" class="me-1"></i> Modifier
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-dossier-{{ $dossier->id }}">
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
                    <p>Aucun dossiers trouvé</p>
                </div>
            @endforelse

        </div>

    </div>

</div>
