<div class="mt-3 row g-lg-3">
    <div class="col-lg-12">
        <div class="d-flex row justify-content-between align-items-center align-items-md-center block-action-table-2">
            <div class="col-lg-8 col-sm-8 col-9">
                <ul class="mb-0 bg-white nav nav-tabs nav-user" id="myTab" role="tablist" wire:ignore>
                    @php
                        $activeTab = 0;
                    @endphp
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
                        @php
                            $activeTab = $activeTab == 0 ? 1 : $activeTab;
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#all"
                                type="button" role="tab" aria-controls="all" aria-selected="true">Tous les
                                courriers</button>
                        </li>
                    @endif

                    @can('Enregistrer un courrier entrant')
                        @php
                            $activeTab = $activeTab == 0 ? 2 : $activeTab;
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#entrat"
                                type="button" role="tab" aria-controls="entrat" aria-selected="true">Courriers
                                entrants</button>
                        </li>
                    @endcan

                    @can('Enregistrer un courrier sortant')
                        @php
                            $activeTab = $activeTab == 0 ? 3 : $activeTab;
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#sortant"
                                type="button" role="tab" aria-controls="sortant" aria-selected="true">Courriers
                                Sortants</button>
                        </li>
                    @endcan

                    @can('Enregistrer un courrier interne')
                        @php
                            $activeTab = $activeTab == 0 ? 4 : $activeTab;
                        @endphp
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#interne"
                                type="button" role="tab" aria-controls="interne" aria-selected="true">Courriers
                                nternes</button>
                        </li>
                    @endcan
                </ul>
            </div>
            <div class="col-sm-4 col-3 d-flex align-items-center justify-content-end">
                @can('Voir les courriers')
                    <a href="{{ route('regidoc.courriers.create') }}" class="btn btn-add btn-add-hover ms-2"
                        style="flex: 0 0 auto;">
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

        <div class="bg-white tab-content" id="myTabContent" style="border-radius: 12px" wire:ignore.self>

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
                <div class="tab-pane fade  @if ($activeTab == 1) show active @endif" id="all"
                    role="tabpanel" aria-labelledby="home-tab" wire:ignore.self>

                    <div class="m-2 d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:98%; width:98%; background-color: rgba(255,255,255,0.95)" wire:loading
                        wire:target="filter" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px">
                        <div class="row g-3">
                            <div class="col">
                                <h4 class="no-padding no-margin">Liste des courriers numérisés</h4>
                            </div>
                            <div class="col-lg-6 col-xl-5 col-xxl-4 d-flex align-items-center justify-content-end">
                                <input type="text" class="form-control me-2 input-search-card" wire:model='search'
                                    placeholder="Recherche" style="border:none;">

                                {{-- <div class="dropdown" style="flex: 0 0 auto" wire:ignore.self>
                                    <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                            <path d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                            </path>
                                        </svg>
                                        &nbsp;
                                        {{ $filterVal }}
                                    </button>

                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @foreach ($filters as $key => $filter)
                                            <li>
                                                <a class="dropdown-item" wire:click='filter({{ $key }})' style="cursor: pointer">
                                                    {{ $filter }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div> --}}

                            </div>
                        </div>
                        <hr class="mb-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Titre</th>
                                        <th scope="col">N° d'enregistrement</th>
                                        <th scope="col">Expéditeur</th>
                                        <th scope="col">Accusées réceptions</th>
                                        <th scope="col">Date de réception</th>
                                        @can('Definir le traitement')
                                            <th scope="col">Priorité</th>
                                        @endcan
                                        <th scope="col">Statut</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courrierGroups as $type_id => $courriers)
                                        @php
                                            $type = \App\Models\CourrierType::find($type_id);
                                        @endphp
                                        <tr class="bg-lightBlue">
                                            <td colspan="7" class="text-start fw-bold">
                                                <div
                                                    class="badge-title @if ($type?->id == 1) red @elseif($type?->id == 2) green @else blue @endif">
                                                    Courrier {{ $type?->titre }}
                                                </div>
                                            </td>
                                        </tr>
                                        @forelse ($courriers as $courrier)
                                            <tr @class(['', 'tr-no-read' => !$courrier->isViewed()])>
                                                <td class="text-truncate">{{ $courrier['title'] }}</td>
                                                <td>{{ $courrier->reference_interne }}</td>
                                                <td>
                                                    @if ($courrier->type_id == 3 || $courrier->type_id == 2)
                                                        {{ $courrier->expediteur?->prenom || $courrier->expediteur?->nom ? $courrier->expediteur?->prenom . ' ' . $courrier->expediteur?->nom : 'Inconnu' }}
                                                    @else
                                                        {{ $courrier->externExpediteur?->nom ?? 'Inconnu' }}
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
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false" style="margin-right: 0">
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
                                                                                        <img src="{{ imageOrDefault($agent->image) }}"
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
                                                @can('Definir le traitement')
                                                    <td>
                                                        <div @class([
                                                            'flag-content',
                                                            'text-secondary' =>
                                                                $courrier->priorite_id != 1 &&
                                                                $courrier->priorite_id != 2 &&
                                                                $courrier->priorite_id != 3,
                                                            'normal' => $courrier->priorite_id == 1,
                                                            'urgent' => $courrier->priorite_id == 3,
                                                            'absolute' => $courrier->priorite_id == 2,
                                                        ])>
                                                            <i class="fi fi-sr-flag" style="font-size: 16px;"></i>
                                                            <div class="tooltip-team">
                                                                {{ $courrier->priorite?->titre ?? 'Non définie' }}</div>
                                                        </div>
                                                    </td>
                                                @endcan
                                                <td>
                                                    <div @class([
                                                        'badge',
                                                        'badge-red' => $courrier->statut_id == 1,
                                                        'badge-yellow' => $courrier->statut_id == 2,
                                                        'badge-green' => $courrier->statut_id == 3,
                                                    ])>
                                                        {{ $courrier->statut?->libelle ?? 'Inconnu' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if (Auth::user()->can('view', $courrier))
                                                            <a href="{{ route('regidoc.courriers.show', $courrier) }}"
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
                                                <td colspan="8" class="text-center td-empty">
                                                    <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                        width="35px" class="">
                                                    <br>
                                                    Aucun courrier {{ $type->titre }} n'est en cours de traitement
                                                </td>
                                            </tr>
                                        @endforelse
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center td-empty">
                                                <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                    width="35px" class="">
                                                <br>
                                                Aucun courrier n'est en cours de traitement
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            @if ($courrierGroups instanceof \Illuminate\Pagination\LengthAwarePaginator && $courrierGroups->hasPages())
                                {{ $courrierGroups->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @can('Enregistrer un courrier entrant')
                <div class="tab-pane fade @if ($activeTab == 2) show active @endif" id="entrat"
                    role="tabpanel" aria-labelledby="home-tab" wire:ignore.self>
                    <div class="m-2 d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:98%; width:98%; background-color: rgba(255,255,255,0.95)" wire:loading
                        wire:target="filter, switchView" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

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
                                        <select wire:model.debounce.500ms = "statut" id="statut"
                                            style="border-right: none" class="form-select form-control">
                                            <option value="null" selected disabled>Etat </option>
                                            <option value="">Tous</option>
                                            <option value=1>En attente</option>
                                            <option value=2>En cours</option>
                                            <option value=3>Traité</option>
                                            <option value=4>Archivé</option>
                                        </select>
                                        <select id="priority" class="form-select form-control"
                                            wire:model.debounce.500ms = "priority">
                                            <option value="null" selected disabled>Priorité</option>
                                            <option value="">Toutes</option>
                                            <option value=1>Faible</option>
                                            <option value=2>Moyen</option>
                                            <option value=3>Fort</option>
                                        </select>
                                        <select name="datep" id="mois" class="form-select form-control"
                                            wire:model.debounce.500ms = 'selectedMonth'>
                                            <option value="null" selected disabled>Mois</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->month($i)->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="annee" class="form-select form-control"
                                            style="border-right: none" wire:model.debounce.500ms = 'selectedYear'>
                                            <option value="null" selected disabled>Année</option>
                                            {{-- @for ($i = 1990; $i < ((int) now()->year) + 1; $i++) --}}
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
                        <hr class="mb-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Titre</th>
                                        <th scope="col">N° d'enregistrement</th>
                                        <th scope="col">Expediteur</th>
                                        <th scope="col">Accusées réceptions</th>
                                        <th scope="col">Date de réception</th>
                                        @can('Definir le traitement')
                                            <th scope="col">Priorité</th>
                                        @endcan
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @php
                                        $courriers = isset($courrierGroups[1]) ? $courrierGroups[1] : [];
                                    @endphp --}}
                                    @forelse ($courrierGroups[1] ?? [] as $key => $courrier)
                                        <tr>
                                            <td class="text-truncate">
                                                {{ $courrier->title }}
                                            </td>
                                            <td>
                                                {{ $courrier->reference_interne }}
                                            </td>
                                            <td>
                                                @if ($courrier->type_id == 3 || $courrier->type_id == 2)
                                                    {{ $courrier->expediteur?->prenom || $courrier->expediteur?->nom ? $courrier->expediteur?->prenom . ' ' . $courrier->expediteur?->nom : 'Inconu' }}
                                                @else
                                                    {{ $courrier->externExpediteur?->nom ?? 'Inconu' }}
                                                @endif
                                            </td>
                                            <td class="text-nowrap">

                                                <div class="box-avatar d-flex align-items-center">
                                                    @foreach ($courrier->followers->unique() as $follower)
                                                        @if (!$follower->is(Auth::user()->agent))
                                                            <div class="cursor-pointer avatar-team"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-personnel"
                                                                aria-controls="offcanvasRight">
                                                                <div class="tooltip-team">
                                                                    {{ $follower->prenom }} {{ $follower->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($follower->image) }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                {{ $courrier->created_at->format('d/m/Y') }}
                                            </td>
                                            @can('Definir le traitement')
                                                <td>
                                                    <div @class([
                                                        'flag-content',
                                                        '' => $courrier->priorite_id == 1,
                                                        'urgent' => $courrier->priorite_id == 3,
                                                        'absolute' => $courrier->priorite_id == 2,
                                                    ])>
                                                        <i class="fi fi-sr-flag" style="font-size: 16px;"></i>
                                                        <div class="tooltip-team">
                                                            {{ $courrier->priorite?->titre ?? 'Non définie' }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endcan
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
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                    width="35px" class=""><br>
                                                Aucun courrier en cours de traitement
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endcan

            @can('Enregistrer un courrier sortant')
                <div class="tab-pane fade @if ($activeTab == 3) show active @endif" id="sortant"
                    role="tabpanel" aria-labelledby="home-tab" wire:ignore.self>
                    <div class="m-2 d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:98%; width:98%; background-color: rgba(255,255,255,0.95)" wire:loading
                        wire:target="filter, switchView" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 card card-table {{ $view == 2 ? 'd-none' : '' }}"
                        style="overflow:visible; border-radius: 12px 12px 12px 12px;">
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
                                        <select wire:model.debounce.500ms = "statut" id="statut"
                                            style="border-right: none" class="form-select form-control">
                                            <option value="null" selected disabled>Etat </option>
                                            <option value="">Tous</option>
                                            <option value=1>En attente</option>
                                            <option value=2>En cours</option>
                                            <option value=3>Traité</option>
                                            <option value=4>Archivé</option>
                                        </select>
                                        <select id="priority" class="form-select form-control"
                                            wire:model.debounce.500ms = "priority">
                                            <option value="null" selected disabled>Priorité</option>
                                            <option value="">Toutes</option>
                                            <option value=1>Faible</option>
                                            <option value=2>Moyen</option>
                                            <option value=3>Fort</option>
                                        </select>
                                        <select name="datep" id="mois" class="form-select form-control"
                                            wire:model.debounce.500ms = 'selectedMonth'>
                                            <option value="null" selected disabled>Mois</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->month($i)->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="annee" class="form-select form-control"
                                            style="border-right: none" wire:model.debounce.500ms = 'selectedYear'>
                                            <option value="null" selected disabled>Année</option>
                                            {{-- @for ($i = 1990; $i < ((int) now()->year) + 1; $i++) --}}
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
                        <hr class="mb-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Titre</th>
                                        <th scope="col">N° d'enregistrement</th>
                                        <th scope="col">Expediteur</th>
                                        <th scope="col">Accusées réceptions</th>
                                        <th scope="col">Date de réception</th>
                                        @can('Definir le traitement')
                                            <th scope="col">Priorité</th>
                                        @endcan
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courrierGroups[2] ?? [] as $courrier)
                                        <tr>
                                            <td class="text-truncate">
                                                {{ $courrier->title }}
                                            </td>
                                            <td>
                                                {{ $courrier->reference_interne }}
                                            </td>
                                            <td>
                                                @if ($courrier->type_id == 3 || $courrier->type_id == 2)
                                                    {{ $courrier->expediteur?->prenom || $courrier->expediteur?->nom ? $courrier->expediteur?->prenom . ' ' . $courrier->expediteur?->nom : 'Inconu' }}
                                                @else
                                                    {{ $courrier->externExpediteur?->nom ?? 'Inconu' }}
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="box-avatar d-flex align-items-center">
                                                    @foreach ($courrier->followers->unique() as $follower)
                                                        @if (!$follower->is(Auth::user()->agent))
                                                            <div class="cursor-pointer avatar-team"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-personnel"
                                                                aria-controls="offcanvasRight">
                                                                <div class="tooltip-team">
                                                                    {{ $follower->prenom }} {{ $follower->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($follower->image) }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                {{ $courrier->created_at->format('d/m/Y') }}
                                            </td>
                                            @can('Definir le traitement')
                                                <td>
                                                    <div @class([
                                                        'flag-content',
                                                        '' => $courrier->priorite_id == 1,
                                                        'urgent' => $courrier->priorite_id == 3,
                                                        'absolute' => $courrier->priorite_id == 2,
                                                    ])>
                                                        <i class="fi fi-sr-flag" style="font-size: 16px;"></i>
                                                        <div class="tooltip-team">
                                                            {{ $courrier->priorite?->titre ?? 'Non définie' }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endcan
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
                    </div>
                </div>
            @endcan

            @can('Enregistrer un courrier interne')
                <div class="tab-pane fade @if ($activeTab == 4) show active @endif" id="interne"
                    role="tabpanel" aria-labelledby="home-tab" wire:ignore.self>
                    <div class="m-2 d-none position-absolute loader-card d-flex justify-content-center"
                        style="z-index: 2; height:98%; width:98%; background-color: rgba(255,255,255,0.95)" wire:loading
                        wire:target="filter, switchView" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 card card-table {{ $view == 2 ? 'd-none' : '' }}"
                        style="overflow:visible; border-radius: 12px 12px 12px 12px;">
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
                                        <select wire:model.debounce.500ms = "statut" id="statut"
                                            style="border-right: none" class="form-select form-control">
                                            <option value="null" selected disabled>Etat </option>
                                            <option value="">Tous</option>
                                            <option value=1>En attente</option>
                                            <option value=2>En cours</option>
                                            <option value=3>Traité</option>
                                            <option value=4>Archivé</option>
                                        </select>
                                        <select id="priority" class="form-select form-control"
                                            wire:model.debounce.500ms = "priority">
                                            <option value="null" selected disabled>Priorité</option>
                                            <option value="">Toutes</option>
                                            <option value=1>Faible</option>
                                            <option value=2>Moyen</option>
                                            <option value=3>Fort</option>
                                        </select>
                                        <select name="datep" id="mois" class="form-select form-control"
                                            wire:model.debounce.500ms = 'selectedMonth'>
                                            <option value="null" selected disabled>Mois</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">
                                                    {{ now()->month($i)->isoFormat('MMMM') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="datep" id="annee" class="form-select form-control"
                                            style="border-right: none" wire:model.debounce.500ms = 'selectedYear'>
                                            <option value="null" selected disabled>Année</option>
                                            {{-- @for ($i = 1990; $i < ((int) now()->year) + 1; $i++) --}}
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
                        <hr class="mb-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Titre</th>
                                        <th scope="col">N° d'enregistrement</th>
                                        <th scope="col">Expediteur</th>
                                        <th scope="col">Accusées réceptions</th>
                                        <th scope="col">Date de réception</th>
                                        <th scope="col">Priorité</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($courrierGroups[3] ?? [] as $courrier)
                                        <tr>
                                            <td>
                                                {{ $courrier->title }}
                                            </td>
                                            <td>
                                                {{ $courrier->reference_interne }}
                                            </td>
                                            <td>
                                                @if ($courrier->type_id == 3 || $courrier->type_id == 2)
                                                    {{ $courrier->expediteur?->prenom || $courrier->expediteur?->nom ? $courrier->expediteur?->prenom . ' ' . $courrier->expediteur?->nom : 'Inconu' }}
                                                @else
                                                    {{ $courrier->externExpediteur?->nom ?? 'Inconu' }}
                                                @endif
                                            </td>
                                            <td class="text-nowrap">
                                                <div class="box-avatar d-flex align-items-center">
                                                    @foreach ($courrier->followers->unique() as $follower)
                                                        @if (!$follower->is(Auth::user()->agent))
                                                            <div class="cursor-pointer avatar-team"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-personnel"
                                                                aria-controls="offcanvasRight">
                                                                <div class="tooltip-team">
                                                                    {{ $follower->prenom }} {{ $follower->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($follower->image) }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                {{ $courrier->created_at->format('d/m/Y') }}
                                            </td>
                                            @can('Definir le traitement')
                                                <td>
                                                    <div @class([
                                                        'flag-content',
                                                        '' => $courrier->priorite_id == 1,
                                                        'urgent' => $courrier->priorite_id == 3,
                                                        'absolute' => $courrier->priorite_id == 2,
                                                    ])>
                                                        <i class="fi fi-sr-flag" style="font-size: 16px;"></i>
                                                        <div class="tooltip-team">
                                                            {{ $courrier->priorite?->titre ?? 'Non définie' }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @endcan
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
                    </div>
                </div>
            @endcan
        </div>
    </div>

</div>
