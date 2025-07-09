<div class="">
    <div class="col-lg-12 mb-4">
        <div class="card card-table position-relative" style="overflow: inherit">
            <div class="m-0 d-none position-absolute loader-card d-flex justify-content-center"
                style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                wire:loading wire:target="filter, changeFilter, changeDate" wire:loading.class.remove="d-none">
                <div class="m-auto text-center">
                    <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>

            <div class="row align-items-center g-1 g-lg-2">
                <div class="col-lg-5 col-sm-4">
                    <h4>Classeurs {{ $annee }}</h4>
                </div>
                {{-- <div class="col-lg-7 col-12 d-flex align-items-center justify-content-end col-sm-8">

                <button class="btn btn-add text-nowrap" data-bs-toggle="modal" data-bs-target="#modal-new-classeur">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-plus d-block d-sm-none">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Créer un classeur</span>
                </button>
            </div>
            <div class="col-lg-5 ms-auto">
                <div class="d-flex align-items-center justify-content-end">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                    style="border:none;" wire:model='search'>
                <div class="dropdown">
                    <button class="btn btn-filter me-2 d-flex text-nowrap" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{-- <i class="fi fi-rr-filter me-2"></i> -}}
                        <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                            <path
                                d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z" />
                        </svg>
                        {{-- {{ $filterText }} -}}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                défaut</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A - Z</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z - A</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                d'ajout</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                modification</a>
                        </li>
                    </ul>
                </div>
                </div>
            </div> --}}
            </div>
            <hr class="mb-4">
            {{-- <h5 class="title-small">Classeurs</h5> --}}
            <div class="row g-2 g-lg-3">

                @forelse ($dossiers ?? [] as $dossier)
                    <div class="col-lg-4 col-sm-4 col-xxl-3 col-xl-3 col-12">
                        <div class="col-folder">
                            <a href="@if (!$dossier->confidentiel) {{ route('regidoc.classeurs.dossiers.show', [$dossier->classeur, $dossier]) }} @else # @endif"
                                @if ($dossier->confidentiel) data-bs-toggle="modal" data-bs-target="#modal-pass-dossier-{{ $dossier->id }}" @endif>
                                <div class="d-flex align-items-center" wire:ignore>
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
                                        <p>Créé le: {{ $dossier->created_at->format('d-m-Y') }}</p>
                                        <p>Par:
                                            {{ $dossier->author?->nom }} {{ $dossier->author?->nom }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                            {{-- <div class="top-0 dropdown position-absolute" style="right: 0;">
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
                            </div> --}}
                        </div>
                    </div>
                @empty
                    <div class="text-center col-12 @if (empty($mois)) d-none @endif">
                        <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px" class="">
                        <p>Aucun dossiers trouvé</p>
                    </div>
                @endforelse

                @if ($mois)
                @else
                    @forelse ($annees as $date => $dossier)
                        <div class="col-lg-4 col-sm-4 col-xxl-3 col-xl-4 col-12">
                            <div class="col-folder">
                                <a href="javascript:void(0)" wire:click='changeDate("{{ $date }}")'>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('assets/images/icons/classeur.png') }}" alt=""
                                            class="me-2">
                                        <div class="text-star">
                                            <h6 class="mb-0">{{ Str::upper($date) }}</h6>
                                            @if ($annee)
                                                <p>{{ $annee }}</p>
                                            @endif
                                            {{-- <h6>{{ $classeur->titre }}</h6>
                                            <p>Ref: {{ $classeur->reference }}</p>
                                            <p>Créé le: {{ $classeur->created_at->format('m/d/Y') }}</p> --}}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center col-12">
                            <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px"
                                class="">
                            <p>Aucun classeur trouvé</p>
                        </div>
                    @endforelse
                @endif
                {{-- @forelse ($classeurs as $classeur)
                <div class="col-lg-4 col-sm-4 col-xxl-3 col-xl-4 col-12">
                    <div class="col-folder">
                        <a href="{{ route('regidoc.classeurs.show', $classeur) }}"
                            title="{{ $classeur->description ?? '' }}">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('assets/images/icons/classeur.png') }}" alt=""
                                    class="me-2">
                                <div class="text-star">
                                    <h6>{{ $classeur->titre }}</h6>
                                    <p>Ref: {{ $classeur->reference }}</p>
                                    <p>Créé le: {{ $classeur->created_at->format('m/d/Y') }}</p>
                                </div>
                            </div>
                        </a>
                        <div class="top-0 dropdown position-absolute" style="right: 0;">
                            <button class="btn" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="true" style="font-size: 14px;">
                                <i class="fi fi-rr-menu-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1"
                                data-popper-placement="bottom-end">
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#detail-classeur-{{ $dossier->classeur->id }}">
                                        <i class="fi fi-rr-eye" class="me-1"></i> Voir détails
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-classeur-{{ $dossier->classeur->id }}">
                                        <i class="fi fi-rr-edit" class="me-1"></i> Modifier
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal-delete-classeur-{{ $dossier->classeur->id }}">
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
                    <p>Aucun classeur trouvé</p>
                </div>
            @endforelse --}}
            </div>
        </div>
    </div>

    {{-- <div class="col-lg-12">
        <div class="px-0 card card-table">
            <div class="px-3 row px-lg-4 align-items-center g-2">
                <div class="col-lg-7 col-sm-6">
                    <h4 class="no-padding no-margin badge-card">Brouillon</h4>
                </div>
            </div>

            <hr class="mb-0">

            <div class="d-content-table position-relative" style="overflow: hidden">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Créé par</th>
                                <th scope="col">Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brouillons as $brouillon)
                                <tr class="tr-no-read">
                                    <td class="text-truncate">
                                        {{ $brouillon->nom }}
                                    </td>
                                    <td>
                                        {{ $brouillon->user->agent->nom . ' ' . $brouillon->user->agent->prenom }}
                                    </td>
                                    <td>
                                        {{ $brouillon->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('regidoc.documents.createNew', ['doc_type' => $brouillon->type, 'brouillon' => $brouillon->id]) }}"
                                            class="btn btn-default btn-sm">
                                            Voir
                                        </a>
                                    </td>
                                @empty
                                    <td colspan="7" class="text-center">
                                        Aucun courrier entrant
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}

    @foreach ($dossiers ?? [] as $dossier)
        <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-dossier-{{ $dossier->id }}"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header" style="flex-direction: column;">
                <div class="d-flex justify-content-between w-100">
                    <div class="text-star">
                        <h5 id="offcanvasRightLabel" class="mb-1">Détails du dossier </h5>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">
                                Créé le:
                            </span>
                            {{ $dossier->created_at->isoFormat('LLLL') }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">Par: </span>
                            {{ $dossier->author?->nom }} {{ $dossier->author?->nom }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            {{-- <span style="display: inline-block" class="me-1">Departement: </span>  --}}
                            {{-- {{ $dossier->author?->fonction()->departement?->libelle }} --}}
                        </p>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="offcanvas-body">
                <div class="block-progress">
                    <div class="card card-notification card-campaing">
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Référence :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $dossier->reference }}
                            </h6>
                        </div>
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Dénomination :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $dossier->titre }}
                            </h6>
                        </div>
                    </div>

                    <div class="card card-notification card-campaing">
                        <div class="text-star">
                            <h6 class="mb-3 date">
                                Description
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">
                                {{ $dossier->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <div class="d-flex justify-content-end">
                    {{-- <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-{{ $dossier->id }}">Supprimer</button> --}}
                    {{-- <button class="btn">Modifier</button> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-edit-archive-dossier-{{ $dossier->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier un dossier</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row g-4">
                            <form action="{{ route('regidoc.dossiers.update', $dossier) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="classeur_id" id=""
                                    value="{{ $dossier->classeur->id }}">
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Réference"
                                            name="reference" value="{{ $dossier->reference }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Denomination"
                                            name="titre" value="{{ $dossier->titre }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                            rows="5">{{ $dossier->description }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <span>Confidentiel</span>
                                            <div class="form-check form-switch ms-3">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $dossier->confidentiel }}" role="switch"
                                                    id="check-date" name="confidentiel" @checked($dossier->confidentiel)>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 password @if (!$dossier->confidentiel) d-none @endif">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <input type="password" name="password" id=""
                                                    placeholder="Mot de passe" class="form-control mb-1">
                                                @if ($dossier->confidentiel)
                                                    <small style="font-size: 11px">Laissez vide pour concerver
                                                        l'ancien</small>
                                                @endif
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <input type="password" name="password_confirm" id=""
                                                    placeholder="Confirmez le mot de passe" class="form-control mb-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <button type="submit" class="btn btn-add">Enregistre</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-dossier-{{ $dossier->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Etes-vous sûr de vouloir supprimer ce dossier ?</h5>
                            <p>Cette action est irrémédiable</p>
                        </div>
                        <form action="{{ route('regidoc.dossiers.destroy', $dossier) }}" method="POST">
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

        <div class="modal fade" id="modal-pass-dossier-{{ $dossier->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Autorisation</h5>
                            <p>Veillez saisir le mot de passe pour acceder au dossier</p>
                        </div>
                        <form action="{{ route('regidoc.dossiers.access') }}" method="POST">
                            @csrf
                            <div class="form-group row g-3 align-items-center">
                                <input type="hidden" name="dossier_id" id="" value="{{ $dossier->id }}">
                                <div class="col-12 position-relative">
                                    <label for="password" class="mb-3">Mot de passe</label>
                                    <input type="password" class="form-control form-control-validation"
                                        placeholder="Mot de passe" name="password">
                                </div>
                                <div class="col-12 d-flex mt-2 justify-content-end">
                                    <button class="btn btn-add">{{ __('Accéder') }}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
