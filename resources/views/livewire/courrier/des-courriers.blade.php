{{-- <div class="mt-3 row g-lg-3">

    <div class="row pe-0">
        <div class="col-12 pe-0">
        </div>
    </div>
</div> --}}
<div class="col-lg-12">
    <div class="d-flex row justify-content-between align-items-center align-items-md-center block-action-table-2">
        <div class="col-lg-8 col-sm-8 col-9">
            <div class="d-flex">
                <ul class="mb-0 nav nav-tabs nav-user" id="myTab" role="tablist" wire:ignore>
                    @if (
                        (Auth::user()->can('Enregistrer un courrier entrant') && Auth::user()->can('Enregistrer un courrier sortant')) ||
                            (Auth::user()->can('Enregistrer un courrier entrant') &&
                                Auth::user()->can('Enregistrer un courrier interne')) ||
                            (Auth::user()->can('Enregistrer un courrier sortant') &&
                                Auth::user()->can('Enregistrer un courrier interne')) ||
                            (!(
                                (Auth::user()->can('Enregistrer un courrier entrant') &&
                                    Auth::user()->can('Enregistrer un courrier sortant')) ||
                                (Auth::user()->can('Enregistrer un courrier entrant') &&
                                    Auth::user()->can('Enregistrer un courrier interne')) ||
                                (Auth::user()->can('Enregistrer un courrier sortant') &&
                                    Auth::user()->can('Enregistrer un courrier interne'))
                            ) &&
                                Auth::user()->can('Voir les courriers')))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 1 ? 'active' : '' }}" id="all-tab"
                                data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab"
                                aria-controls="all" aria-selected="{{ $active_tab == 1 }}"
                                wire:click='changeTab(1)'>Tous les courriers</button>
                        </li>
                    @endif

                    @can('Enregistrer un courrier entrant')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 2 ? 'active' : '' }}" id="entrant-tab"
                                data-bs-toggle="tab" data-bs-target="#entrant" type="button" role="tab"
                                aria-controls="entrant" aria-selected="{{ $active_tab == 2 }}"
                                wire:click='changeTab(2)'>Courriers entrants</button>
                        </li>
                    @endcan

                    @can('Enregistrer un courrier sortant')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 3 ? 'active' : '' }}" id="sortant-tab"
                                data-bs-toggle="tab" data-bs-target="#sortant" type="button" role="tab"
                                aria-controls="sortant" aria-selected="{{ $active_tab == 3 }}"
                                wire:click='changeTab(3)'>Courriers sortants</button>
                        </li>
                    @endcan

                    @can('Enregistrer un courrier interne')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 4 ? 'active' : '' }}" id="interne-tab"
                                data-bs-toggle="tab" data-bs-target="#interne" type="button" role="tab"
                                aria-controls="interne" aria-selected="{{ $active_tab == 4 }}"
                                wire:click='changeTab(4)'>Courriers internes</button>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-3 d-flex align-items-center justify-content-end">
            @can('Voir les courriers')
                <a href="{{ route('regidoc.courriers.create') }}"
                    class="btn btn-add btn-add-hover ms-auto btn-scanner-inbox" style="flex: 0 0 auto;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-plus d-flex d-sm-none d-lg-none">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Numériser un courrier</span>
                </a>
            @endcan
        </div>
    </div>

    <div class="bg-white tab-content" id="myTabContent" style="border-radius: 12px">
        @if (
            (Auth::user()->can('Enregistrer un courrier entrant') && Auth::user()->can('Enregistrer un courrier sortant')) ||
                (Auth::user()->can('Enregistrer un courrier entrant') &&
                    Auth::user()->can('Enregistrer un courrier interne')) ||
                (Auth::user()->can('Enregistrer un courrier sortant') &&
                    Auth::user()->can('Enregistrer un courrier interne')) ||
                (!(
                    (Auth::user()->can('Enregistrer un courrier entrant') &&
                        Auth::user()->can('Enregistrer un courrier sortant')) ||
                    (Auth::user()->can('Enregistrer un courrier entrant') &&
                        Auth::user()->can('Enregistrer un courrier interne')) ||
                    (Auth::user()->can('Enregistrer un courrier sortant') &&
                        Auth::user()->can('Enregistrer un courrier interne'))
                ) &&
                    Auth::user()->can('Voir les courriers')))
            <!-- Tous Tab -->
            <div class="tab-pane fade {{ $active_tab == 1 ? 'show active' : '' }}" id="all" role="tabpanel"
                aria-labelledby="all-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px">
                    <div class="row g-3 align-items-center">
                        <div class="col">
                            <h4 class="no-padding no-margin">Liste des courriers numérisés</h4>
                        </div>
                        <div class="col-lg-6 col-xl-5 col-xxl-4 d-flex align-items-center justify-content-end">
                            <input type="text" class="form-control me-2 input-search-card" wire:model='search'
                                placeholder="Recherche" style="border:none;">
                        </div>
                    </div>
                    <hr class="mb-0">
                    <div class="table-responsive">
                        <div class="card card-table w-100" style="height: 250px" wire:loading>
                            <div class="d-flex justify-content-center h-100 align-items-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover" wire:loading.remove wire:poll.180000ms>
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">N° d'enregistrement</th>
                                    <th scope="col">Expéditeur</th>
                                    <th scope="col">Destinataire</th>
                                    <th scope="col">Accusées réceptions</th>
                                    <th scope="col">Date de réception</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allcourriers as $courrier)
                                    @if ($courrier->statut_id != 3)
                                        <tr @class(['', 'tr-no-read' => !$courrier->isViewed()])>
                                            @if ($courrier->type->titre === 'Sortant')
                                                <td class="text-truncate title-file-box-table-data">
                                                    <span class="mail-out-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                            height="1em" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="m12 4l-.707-.707l.707-.707l.707.707zm1 15a1 1 0 1 1-2 0zM5.293 9.293l6-6l1.414 1.414l-6 6zm7.414-6l6 6l-1.414 1.414l-6-6zM13 4v15h-2V4z" />
                                                        </svg>
                                                    </span>
                                                    {{ $courrier->title }}
                                                </td>
                                            @endif

                                            @if ($courrier->type->titre === 'Entrant')
                                                <td class="text-truncate title-file-box-table-data">
                                                    <span class="mail-entry-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                            height="1em" viewBox="0 0 24 24">
                                                            <path fill="currentColor"
                                                                d="M11 4h2v12l5.5-5.5l1.42 1.42L12 19.84l-7.92-7.92L5.5 10.5L11 16z" />
                                                        </svg>
                                                    </span>
                                                    {{ $courrier->title }}
                                                </td>
                                            @endif

                                            @if ($courrier->type->titre === 'Interne')
                                                <td class="text-truncate title-file-box-table-data">
                                                    <span class="mail-internal-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em"
                                                            height="1em" viewBox="0 0 24 24">
                                                            <path fill="none" stroke="currentColor"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 3L4 7l4 4M4 7h16m-4 14l4-4l-4-4m4 4H4" />
                                                        </svg>
                                                    </span>
                                                    {{ $courrier->title ?? 'Non définie' }}
                                                </td>
                                            @endif
                                            <td>{{ $courrier->reference_interne }}</td>
                                            <td>
                                                @if ($courrier->type_id == 1)
                                                    {{ $courrier->externExpediteur->nom ?? 'N/D' }}
                                                @elseif($courrier->type_id == 3)
                                                    {{ $courrier->service->titre ?? 'N/D' }}
                                                @else
                                                    Newtech Consulting
                                                @endif
                                            </td>
                                            <td>
                                                @if ($courrier->type_id == 2)
                                                    {{ $courrier->externDestinateur->nom ?? 'N/D' }}
                                                @elseif($courrier->type_id == 3)
                                                    {{ $courrier->toDirection->titre ?? 'N/D' }}
                                                @else
                                                    Newtech Consulting
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                @if ($courrier->followers->unique()->count())
                                                    <div class="box-avatar d-flex align-items-center">
                                                        @php
                                                            $others = collect();
                                                        @endphp
                                                        @foreach ($courrier->followers->unique() as $follower)
                                                            @if ($loop->index < 4)
                                                                <div class="cursor-pointer avatar-team"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#detail-personnel"
                                                                    aria-controls="offcanvasRight">
                                                                    <div class="tooltip-team">
                                                                        {{ $follower->poste?->titre }}</div>
                                                                    <img src="{{ imageOrDefault($follower->image) }}"
                                                                        alt="">
                                                                </div>
                                                            @else
                                                                @php
                                                                    $others->push($follower);
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        @if (count($others))
                                                            <div class="dropdown">
                                                                <div class="cursor-pointer avatar-team plus d-flex align-items-center justify-content-center"
                                                                    data-bs-toggle="dropdown" aria-expanded="false"
                                                                    style="margin-right: 0">
                                                                    <span>4+</span>
                                                                </div>
                                                                <div class="dropdown-menu dropdown-menu-end"
                                                                    aria-labelledby="dropdownMenuButton2"
                                                                    style="">
                                                                    <div class="list-users">
                                                                        @foreach ($others as $agent)
                                                                            <div
                                                                                class="content-user d-flex align-items-center">
                                                                                <div class="avatar"
                                                                                    style="flex: 0 0 auto">
                                                                                    <img src="{{ imageOrDefault($agent?->image) }}"
                                                                                        alt="{{ $agent->prenom }} {{ $agent->nom }}">
                                                                                </div>
                                                                                <div class="name">
                                                                                    {{ $agent->prenom }}
                                                                                    {{ $agent->nom }} <br>
                                                                                    {{ $agent->poste?->libelle }}
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    Aucun
                                                @endif
                                            </td>
                                            <td>{{ $courrier->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $courrier->type->titre }}</td>
                                            <td>
                                                <div @class([
                                                    'badge',
                                                    'badge-gray' => $courrier->statut_id == 1,
                                                    'badge-yellow' => $courrier->statut_id == 2,
                                                    'badge-green' => $courrier->statut_id == 3,
                                                ])>
                                                    {{ $courrier->statut?->libelle ?? 'Inconnu' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if (
                                                        ($courrier->isIntern() && in_array(Auth::user()->agent->id, $courrier->destinateurs->pluck('id')->toArray())) ||
                                                            in_array(Auth::user()->agent->id, $courrier->followers->pluck('id')->toArray()) ||
                                                            $courrier->created_by == Auth::user()->agent->id)
                                                        <a href="{{ route('regidoc.courriers.show', $courrier) }}"
                                                            class="btn">
                                                            <i class="fi fi-rr-eye"></i>
                                                            <div class="tooltip-btn">Voir détails</div>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center td-empty">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                width="35px" class="">
                                            <br>
                                            Aucun courrier numérisé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (count($allcourriers))
                        {{ $allcourriers->links() }}
                    @endif
                </div>
            </div>
        @endif

        @can('Enregistrer un courrier entrant')
            <!-- Entrants Tab -->
            <div class="tab-pane fade {{ $active_tab == 2 ? 'show active' : '' }}" id="entrant" role="tabpanel"
                aria-labelledby="entrant-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="col-lg-6">
                                <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                    style="border:none;" wire:model='search'>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <div class="input-group block-input-filter">
                                    <select wire:model.debounce.500ms="statut" id="statut" style="border-right: none"
                                        class="form-select form-control">
                                        <option value="null" selected disabled>Etat </option>
                                        <option value="">Tous</option>
                                        <option value=1>En attente</option>
                                        <option value=2>En cours</option>
                                        <option value=3>Traité</option>
                                        <option value=4>Archivé</option>
                                    </select>
                                    <select id="priority" class="form-select form-control"
                                        wire:model.debounce.500ms="priority">
                                        <option value="null" selected disabled>Priorité</option>
                                        <option value="">Toutes</option>
                                        <option value=1>Faible</option>
                                        <option value=2>Moyen</option>
                                        <option value=3>Fort</option>
                                    </select>
                                    <select name="datep" id="mois" class="form-select form-control"
                                        wire:model.debounce.500ms='selectedMonth'>
                                        <option value="null" selected disabled>Mois</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select name="datep" id="annee" class="form-select form-control"
                                        style="border-right: none" wire:model.debounce.500ms='selectedYear'>
                                        <option value="null" selected disabled>Année</option>
                                        @for ($i = ((int) now()->year); $i > 1990; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
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
                    <hr class="mb-0">
                    <div class="table-responsive">
                        <div class="card card-table w-100" style="height: 250px" wire:loading>
                            <div class="d-flex justify-content-center h-100 align-items-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover" wire:loading.remove wire:poll.180000ms>
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">N° de reference</th>
                                    <th scope="col">Expediteur</th>
                                    <th scope="col">Accusées réceptions</th>
                                    @can('Definir le traitement')
                                        <th scope="col">Priorité</th>
                                    @endcan
                                    <th scope="col">Date de réception</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($entrants as $entrant)
                                    <tr @class(['', 'tr-no-read' => !$entrant->isViewed()])>
                                        <td class="text-truncate title-file-box-table-data">
                                            <span class="mail-entry-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="M11 4h2v12l5.5-5.5l1.42 1.42L12 19.84l-7.92-7.92L5.5 10.5L11 16z" />
                                                </svg>
                                            </span>
                                            {{ $entrant->title }}
                                        </td>
                                        <td>{{ $entrant->reference_courrier }}</td>
                                        <td>{{ $entrant->externExpediteur->nom ?? 'N/D' }}</td>
                                        <td class="text-nowrap">
                                            <div class="box-avatar d-flex align-items-center">
                                                @foreach ($entrant->followers->unique() as $follower)
                                                    @if (!$follower->is(Auth::user()->agent))
                                                        <div class="cursor-pointer avatar-team" data-bs-toggle="offcanvas"
                                                            data-bs-target="#detail-personnel"
                                                            aria-controls="offcanvasRight">
                                                            <div class="tooltip-team">{{ $follower->prenom }}
                                                                {{ $follower->nom }}</div>
                                                            <img src="{{ imageOrDefault($follower->image) }}"
                                                                alt="">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        @can('Definir le traitement')
                                            <td>
                                                <div @class([
                                                    'badge-priority',
                                                    'badge-priority-gray' =>
                                                        $entrant->priorite_id != 1 &&
                                                        $entrant->priorite_id != 2 &&
                                                        $entrant->priorite_id != 3,
                                                    'normal badge-priority-normal' => $entrant->priorite_id == 1,
                                                    'urgent  badge-priority-red' => $entrant->priorite_id == 4,
                                                    'absolute badge-priority-yellow' => $entrant->priorite_id == 3,
                                                    'important badge-priority-green' => $entrant->priorite_id == 2,
                                                ])>
                                                    {{ $entrant->priorite?->titre ?? 'N/A' }}
                                                </div>
                                            </td>
                                        @endcan
                                        <td>{{ $entrant->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div @class([
                                                'badge',
                                                'badge-gray' => $entrant->statut_id == 1,
                                                'badge-yellow' => $entrant->statut_id == 2,
                                                'badge-green' => $entrant->statut_id == 3,
                                            ])>
                                                {{ $entrant->statut?->libelle ?? 'Inconnu' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (
                                                    ($entrant->isIntern() && in_array(Auth::user()->agent->id, $entrant->destinateurs->pluck('id')->toArray())) ||
                                                        in_array(Auth::user()->agent->id, $entrant->followers->pluck('id')->toArray()) ||
                                                        $entrant->created_by == Auth::user()->agent->id)
                                                    <a href="{{ route('regidoc.courriers.show', $entrant) }}"
                                                        class="btn">
                                                        <i class="fi fi-rr-eye"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                width="35px" class=""><br>
                                            Aucun courrier entrant en cours de traitement
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (count($entrants))
                        {{ $entrants->links() }}
                    @endif
                </div>
            </div>
        @endcan

        @can('Enregistrer un courrier sortant')
            <!-- Sortants Tab -->
            <div class="tab-pane fade {{ $active_tab == 3 ? 'show active' : '' }}" id="sortant" role="tabpanel"
                aria-labelledby="sortant-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="col-lg-6">
                                <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                    style="border:none;" wire:model='search'>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <div class="input-group block-input-filter">
                                    <select wire:model.debounce.500ms="statut" id="statut" style="border-right: none"
                                        class="form-select form-control">
                                        <option value="null" selected disabled>Etat </option>
                                        <option value="">Tous</option>
                                        <option value=1>En attente</option>
                                        <option value=2>En cours</option>
                                        <option value=3>Traité</option>
                                        <option value=4>Archivé</option>
                                    </select>
                                    <select id="priority" class="form-select form-control"
                                        wire:model.debounce.500ms="priority">
                                        <option value="null" selected disabled>Priorité</option>
                                        <option value="">Toutes</option>
                                        <option value=1>Faible</option>
                                        <option value=2>Moyen</option>
                                        <option value=3>Fort</option>
                                    </select>
                                    <select name="datep" id="mois" class="form-select form-control"
                                        wire:model.debounce.500ms='selectedMonth'>
                                        <option value="null" selected disabled>Mois</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select name="datep" id="annee" class="form-select form-control"
                                        style="border-right: none" wire:model.debounce.500ms='selectedYear'>
                                        <option value="null" selected disabled>Année</option>
                                        @for ($i = ((int) now()->year); $i > 1990; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
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
                    <hr class="mb-0">
                    <div class="table-responsive">
                        <div class="card card-table w-100" style="height: 250px" wire:loading>
                            <div class="d-flex justify-content-center h-100 align-items-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover" wire:loading.remove wire:poll.180000ms>
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">N° d'enregistrement</th>
                                    <th scope="col">Destinataire</th>
                                    <th scope="col">Accusées réceptions</th>
                                    <th scope="col">Date du courrier</th>
                                    <th scope="col">Date d'émission</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sortants as $sortant)
                                    <tr @class(['', 'tr-no-read' => !$sortant->isViewed()])>
                                        <td class="text-truncate title-file-box-table-data">
                                            <span class="mail-out-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <path fill="currentColor"
                                                        d="m12 4l-.707-.707l.707-.707l.707.707zm1 15a1 1 0 1 1-2 0zM5.293 9.293l6-6l1.414 1.414l-6 6zm7.414-6l6 6l-1.414 1.414l-6-6zM13 4v15h-2V4z" />
                                                </svg>
                                            </span>
                                            {{ $sortant->title }}
                                        </td>
                                        <td>{{ $sortant->reference_interne }}</td>
                                        <td>{{ $sortant->externDestinateur->nom ?? 'N/D' }}</td>
                                        <td class="text-nowrap">
                                            <div class="box-avatar d-flex align-items-center">
                                                @forelse ($sortant->followers->unique() as $follower)
                                                    @if (!$follower->is(Auth::user()->agent))
                                                        <div class="cursor-pointer avatar-team" data-bs-toggle="offcanvas"
                                                            data-bs-target="#detail-personnel"
                                                            aria-controls="offcanvasRight">
                                                            <div class="tooltip-team">{{ $follower->prenom }}
                                                                {{ $follower->nom }}</div>
                                                            <img src="{{ imageOrDefault($follower->image) }}"
                                                                alt="">
                                                        </div>
                                                    @endif
                                                @empty
                                                    Aucune
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>{{ $sortant->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($sortant->accuseReceptions->isNotEmpty())
                                                {{ $sortant->accuseReceptions->last()->created_at->format('d/m/Y') }}
                                            @else
                                                <span>Aucune</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (
                                                    ($sortant->isIntern() && in_array(Auth::user()->agent->id, $sortant->destinateurs->pluck('id')->toArray())) ||
                                                        in_array(Auth::user()->agent->id, $sortant->followers->pluck('id')->toArray()) ||
                                                        $sortant->created_by == Auth::user()->agent->id)
                                                    <a href="{{ route('regidoc.courriers.show', $sortant) }}"
                                                        class="btn">
                                                        <i class="fi fi-rr-eye"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                width="35px" class=""><br>
                                            Aucun courrier sortant n'est en cours de traitement
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (count($sortants))
                        {{ $sortants->links() }}
                    @endif
                </div>
            </div>
        @endcan

        @can('Enregistrer un courrier interne')
            <div class="tab-pane fade {{ $active_tab == 4 ? 'show active' : '' }}" id="interne" role="tabpanel"
                aria-labelledby="interne-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="col-lg-6">
                                <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                    style="border:none;" wire:model='search'>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <div class="input-group block-input-filter">
                                    <select wire:model.debounce.500ms="statut" id="statut" style="border-right: none"
                                        class="form-select form-control">
                                        <option value="null" selected disabled>Etat </option>
                                        <option value="">Tous</option>
                                        <option value=1>En attente</option>
                                        <option value=2>En cours</option>
                                        <option value=3>Traité</option>
                                        <option value=4>Archivé</option>
                                    </select>
                                    <select id="priority" class="form-select form-control"
                                        wire:model.debounce.500ms="priority">
                                        <option value="null" selected disabled>Priorité</option>
                                        <option value="">Toutes</option>
                                        <option value=1>Faible</option>
                                        <option value=2>Moyen</option>
                                        <option value=3>Fort</option>
                                    </select>
                                    <select name="datep" id="mois" class="form-select form-control"
                                        wire:model.debounce.500ms='selectedMonth'>
                                        <option value="null" selected disabled>Mois</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select name="datep" id="annee" class="form-select form-control"
                                        style="border-right: none" wire:model.debounce.500ms='selectedYear'>
                                        <option value="null" selected disabled>Année</option>
                                        @for ($i = ((int) now()->year); $i > 1990; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
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
                    <hr class="mb-0">
                    <div class="table-responsive">
                        <div class="card card-table w-100" style="height: 250px" wire:loading>
                            <div class="d-flex justify-content-center h-100 align-items-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover" wire:loading.remove wire:poll.180000ms>
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">N° de reference</th>
                                    <th scope="col">Service initiateur</th>
                                    <th scope="col">Destinataire</th>
                                    <th scope="col">Accusées réceptions</th>
                                    @can('Definir le traitement')
                                        <th scope="col">Priorité</th>
                                    @endcan
                                    <th scope="col">Date du courrier</th>
                                    <th scope="col">Date de réception</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($internes as $interne)
                                    <tr @class(['', 'tr-no-read' => !$interne->isViewed()])>
                                        <td class="text-truncate title-file-box-table-data">
                                            <span class="mail-internal-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                    viewBox="0 0 24 24">
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M8 3L4 7l4 4M4 7h16m-4 14l4-4l-4-4m4 4H4" />
                                                </svg>
                                            </span>
                                            {{ $interne->title }}
                                        </td>
                                        <td>{{ $interne->reference_interne ?? 'N/A' }}</td>
                                        <td>{{ $interne->service->titre ?? 'N/D' }}</td>
                                        <td>{{ $interne->toDirection->titre ?? 'N/D' }}</td>
                                        <td class="text-nowrap">
                                            <div class="box-avatar d-flex align-items-center">
                                                @foreach ($interne->followers->unique() as $follower)
                                                    @if (!$follower->is(Auth::user()->agent))
                                                        <div class="cursor-pointer avatar-team" data-bs-toggle="offcanvas"
                                                            data-bs-target="#detail-personnel"
                                                            aria-controls="offcanvasRight">
                                                            <div class="tooltip-team">{{ $follower->prenom }}
                                                                {{ $follower->nom }}</div>
                                                            <img src="{{ imageOrDefault($follower->image) }}"
                                                                alt="">
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        @can('Definir le traitement')
                                            <td>
                                                <div @class([
                                                    'badge-priority',
                                                    'badge-priority-gray' =>
                                                        $interne->priorite_id != 1 &&
                                                        $interne->priorite_id != 2 &&
                                                        $interne->priorite_id != 3,
                                                    'normal badge-priority-normal' => $interne->priorite_id == 1,
                                                    'urgent  badge-priority-red' => $interne->priorite_id == 4,
                                                    'absolute badge-priority-yellow' => $interne->priorite_id == 3,
                                                    'important badge-priority-green' => $interne->priorite_id == 2,
                                                ])>
                                                    {{ $interne->priorite?->titre ?? 'N/A' }}
                                                </div>
                                            </td>
                                        @endcan
                                        <td>{{ $interne->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($interne->accuseReceptions->isNotEmpty())
                                                {{ $interne->accuseReceptions->last()->created_at->format('d/m/Y') }}
                                            @else
                                                <span>Aucune</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div @class([
                                                'badge',
                                                'badge-gray' => $interne->statut_id == 1,
                                                'badge-yellow' => $interne->statut_id == 2,
                                                'badge-green' => $interne->statut_id == 3,
                                            ])>
                                                {{ $interne->statut->libelle ?? 'Inconnu' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (
                                                    ($interne->isIntern() && in_array(Auth::user()->agent->id, $interne->destinateurs->pluck('id')->toArray())) ||
                                                        in_array(Auth::user()->agent->id, $interne->followers->pluck('id')->toArray()) ||
                                                        $interne->created_by == Auth::user()->agent->id)
                                                    <a href="{{ route('regidoc.courriers.show', $interne) }}"
                                                        class="btn">
                                                        <i class="fi fi-rr-eye"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                width="35px" class=""><br>
                                            Aucun courrier interne
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if (count($internes))
                        {{ $internes->links() }}
                    @endif
                </div>
            </div>
        @endcan
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function() {
        Echo.channel('addedcourriers')
            .listen('CourrierCreated', (e) => {
                Livewire.emit('courrierCreated', e.courrier);
            });

        window.addEventListener('play-sound', event => {
            var audio = new Audio('/public/assets/songs/newMessage.wav');
            audio.play();
        });
    });

    Echo.channel('addedcourriers')
        .listen('CourrierCreated', (e) => {
            console.log(e.courrier);
        });
</script>
