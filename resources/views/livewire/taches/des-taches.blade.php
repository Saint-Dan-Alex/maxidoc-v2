<div class="row g-lg-3">


    <div class="col-lg-12">
        <div class="d-flex justify-content-between align-items-center content-list">

            <div class="col-lg-8 col-sm-8 col-9">
                <div class="d-flex">
                    <ul class="mb-0  nav nav-tabs nav-user" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class = "nav-link {{ $tab == 1 ? 'active' : '' }}" id="tasks-tab"
                                data-bs-toggle="tab" data-bs-target="#tasks" type="button" role="tab"
                                aria-controls="tasks" aria-selected="{{ $tab == 1 }}"
                                wire:click='changeTab({{ 1 }})'>
                                Toutes mes tâches
                            </button>

                        </li>
                        @if (Auth::user()->agent->isDG() == false || Auth::user()->agent->isDelegue() == false)
                            @if (!Auth::user()->agent->isDG())
                                <li class="nav-item me-3" role="presentation">
                                    <button class = "nav-link {{ $tab == 2 ? 'active' : '' }}" id="assignees-tab"
                                        data-bs-toggle="tab" data-bs-target="#assignees" type="button" role="tab"
                                        aria-controls="assignees" aria-selected="{{ $tab == 2 }}"
                                        wire:click='changeTab({{ 2 }})'>
                                        Tâches assignées
                                        <span @class([
                                            'badge bg-danger ms-2 rounded-pill py-1 px-2 fw-normal',
                                            'd-none' => $newTachesCount <= 0,
                                        ]) style="font-size:10px">
                                            {{ $newTachesCount }}
                                        </span>
                                    </button>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <button class = "nav-link {{ $tab == 3 ? 'active' : '' }}" id="en-cours-tab"
                                    data-bs-toggle="tab" data-bs-target="#en-cours" type="button" role="tab"
                                    aria-controls="en-cours" aria-selected="{{ $tab == 3 }}"
                                    wire:click='changeTab({{ 3 }})'>
                                    Tâches en cours
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class = "nav-link {{ $tab == 4 ? 'active' : '' }}" id="terminees-tab"
                                    data-bs-toggle="tab" data-bs-target="#terminees" type="button" role="tab"
                                    aria-controls="terminees" aria-selected="{{ $tab == 4 }}"
                                    wire:click='changeTab({{ 4 }})'>
                                    Tâches Terminées
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class = "nav-link {{ $tab == 5 ? 'active' : '' }}" id="hors-delais-tab"
                                    data-bs-toggle="tab" data-bs-target="#hors-delais" type="button" role="tab"
                                    aria-controls="hors-delais" aria-selected="{{ $tab == 5 }}"
                                    wire:click='changeTab({{ 5 }})'>
                                    Tâches hors délais
                                </button>
                            </li>
                        @endif
                    </ul>

                </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-3 d-flex align-items-center justify-content-end">
                <a href="{{ route('regidoc.taches.create') }}"
                    class="btn btn-add btn-add-hover ms-auto btn-tasks-inbox " style="flex: 0 0 auto;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-plus d-flex d-sm-none d-lg-none">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Créer une tâche</span>
                </a>
            </div>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="d-none position-absolute d-flex loader-card justify-content-center"
                style="z-index: 2; height:500px; width:100%; background-color:#edf0f6">
                <div class="m-auto text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            <div class = "tab-pane  {{ $tab == 1 ? 'show active' : '' }}" id="tasks" role="tabpanel"
                aria-labelledby="tasks-tab">
                <div class="px-3 pt-3 card card-table" style="overflow:visible; border-radius: 0px 12px 12px 12px">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-6">
                            <h4 class="no-padding no-margin">Liste des tâches à traiter</h4>
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
                        <table class="table table-hover" wire:loading.remove>
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Priorité</th>
                                    <th scope="col">Participants</th>
                                    <th scope="col">Date d'échéance</th>
                                    <th scope="col" class="text-center">Progression</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($taches as $tache)
                                    <tr>
                                        <td> {{ Str::limit($tache->titre, 30, '...') }} </td>
                                        <td> {{ $tache->priorite->titre }} </td>
                                        <td>
                                            <div class="box-avatar d-flex align-items-center">
                                                @php
                                                    $others = collect();
                                                @endphp
                                                @foreach ($tache->objectifs->sortByDesc('id')->unique('agent_id') as $objectif)
                                                    @if ($loop->index < 3)
                                                        <div class="cursor-pointer avatar-team" data-bs-toggle="modal"
                                                            data-bs-target="#modal-edit-participants-{{ $objectif->id }}">
                                                            <div class="tooltip-team">
                                                                {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}
                                                            </div>
                                                            <img src="{{ imageOrDefault($objectif->agent?->image) }}"
                                                                alt="image de profil {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}">
                                                        </div>
                                                    @else
                                                        @php
                                                            $others->push($objectif);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                @if (count($others))
                                                    <div class="dropdown">
                                                        <div class="cursor-pointer avatar-team plus d-flex align-items-center justify-content-center"
                                                            data-bs-toggle="dropdown" aria-expanded="false"
                                                            style="margin-right: 0">
                                                            <span>
                                                                3+
                                                            </span>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-end"
                                                            aria-labelledby="dropdownMenuButton2" style="">
                                                            <div class="list-users">
                                                                @foreach ($others as $objectif)
                                                                    <div class="content-user d-flex align-items-center"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal-edit-participants-{{ $objectif->id }}">
                                                                        <div class="avatar" style="flex: 0 0 auto">
                                                                            <img src="{{ imageOrDefault($objectif->agent->image) }}"
                                                                                alt="{{ $objectif->agent->prenom }} {{ $objectif->agent->nom }}">
                                                                        </div>
                                                                        <div class="name">
                                                                            {{ $objectif->agent->prenom }}
                                                                            {{ $objectif->agent->nom }}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="user badge-plus ms-0" data-bs-toggle="modal"
                                                    data-bs-target="#modal-add-participants-{{ $tache->id }}">
                                                    <div class="tooltip-team">
                                                        Ajouter un agent
                                                    </div>
                                                    <i class="fi fi-rr-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td> {{ $tache->created_at->format('d/m/Y') }} </td>
                                        <td>
                                            <div
                                                class="progress-tache {{ $tache->pourcentage >= 80 ? 'green' : '' }} {{ $tache->pourcentage >= 50 && $tache->pourcentage < 80 ? 'orange' : '' }} ">
                                                <div class="pourc">
                                                    {{ $tache->pourcentage }}%
                                                </div>
                                                <div class="content-progress-tache">
                                                    <div style="width: {{ $tache->pourcentage }}%">

                                                    </div>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            <div
                                                class="badge @if ($tache->tache_statut_id == 1) badge-gray @elseif($tache->tache_statut_id == 2) badge-yellow @elseif($tache->tache_statut_id == 3) badge-green @elseif($tache->tache_statut_id == 4) badge-red @endif">
                                                {{ $tache->tache_statut?->titre }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center btns-action-table">
                                                <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn">
                                                    <i class="fi fi-rr-eye"></i>
                                                    <div class="tooltip-btn">Voir détails</div>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
                                            <div class="text-center col-12">
                                                <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                    width="35px" class="">
                                                <p>Vous n'avez aucune tâche</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if (count($taches))
                            {{ $taches->links() }}
                        @endif
                    </div>
                    {{-- {!! $taches->withQueryString()->links() !!} --}}
                </div>
            </div>
            {{-- @if (Auth::user()->agent->isDG() == false || Auth::user()->agent->isDelegue() == false) --}}
            @if (!Auth::user()->agent->isDG() || !Auth::user()->agent->isDelegue())
                <div class = "tab-pane  {{ $tab == 2 ? 'show active' : '' }}" id="assignees" role="tabpanel"
                    aria-labelledby="assignees-tab">
                    <div class="card card-table w-100" style="height: 250px; border-radius: 0 12px 12px 12px"
                        wire:loading>
                        <div class="d-flex justify-content-center h-100 align-items-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card card-table" style="border-radius: 0px 12px 12px 12px">
                        <div class="row g-3" wire:loading.remove>
                            @forelse ($newTaches as $key => $tache)
                                <div class="col-lg-4 col-xxl-3 col-md-6 col-sm-6">
                                    <div class="card card-table widget-task">
                                        <div class="block-taks task p-0" style="border: none">
                                            <div
                                                class="badge-task mb-2 @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div
                                                class="badge-task mb-2 @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div
                                                        class="block-progress d-flex justify-content-between align-items-center">
                                                        <div class="progressBar">
                                                            <div class="move"
                                                                style="width: {{ $tache->pourcentage }}%">
                                                            </div>
                                                        </div>
                                                        <div class="pourcentage">
                                                            {{ $tache->pourcentage }}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-between">
                                                    <div class="block-user d-flex">
                                                        <div class="block-user d-flex">
                                                            @foreach ($tache->objectifs as $objectif)
                                                                <div class="user">
                                                                    <span class="online"></span>
                                                                    <img src="{{ imageOrDefault($objectif->agent?->image) }}"
                                                                        alt="image de profil {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}">
                                                                </div>
                                                            @endforeach

                                                            {{-- <div class="user badge-plus" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-add-participants-{{ $tache->id }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-plus">
                                                                        <line x1="12" y1="5" x2="12"
                                                                            y2="19"></line>
                                                                        <line x1="5" y1="12" x2="19"
                                                                            y2="12"></line>
                                                                    </svg>
                                                                </div> --}}
                                                        </div>
                                                    </div>
                                                    @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                                                        @if ($tache->pourcentage == 0)
                                                            <button class="btn btn-sm btn-add btn-add-hover"
                                                                wire:click="updateStatut({{ $tache->id }},1)"
                                                                wire:loading.attr='disabled'>
                                                                Accuser reception
                                                                <span class="spinner-border text-success d-none ms-1"
                                                                    role="status" wire:target="updateStatut"
                                                                    wire:loading.class.remove="d-none"
                                                                    style="font-size: 2px !important; width:10px;height:10px">
                                                                    <span class="sr-only"></span>
                                                                </span>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-add btn-add-hover" disabled>
                                                                Vous avez déjà accusé réception
                                                            </button>
                                                        @endif
                                                    @else
                                                        @if ($tache->isForDirection() && $tache->pourcentage == 0)
                                                            <button class="btn btn-sl btn-add" disabled>
                                                                En attente d'un accusé de réception
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-add btn-add-hover"
                                                                wire:click="updateStatut({{ $tache->id }})"
                                                                wire:loading.attr='disabled'>
                                                                Traiter
                                                                <span class="spinner-border text-success d-none ms-1"
                                                                    role="status"
                                                                    wire:target="updateStatut({{ $tache->id }})"
                                                                    wire:loading.class.remove="d-none"
                                                                    style="font-size: 2px !important; width:10px;height:10px">
                                                                    <span class="sr-only"></span>
                                                                </span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 mx-auto">
                                    <div class="card card-table" style="box-shadow: none!important">
                                        <div class="text-center col-12">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                class="" width="35px">
                                            <p class="text-center para"
                                                style="font-size: 14px; color: var(--colorParagraph)">
                                                Aucune tâche ne vous est assignée
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- {!! $newTaches->withQueryString()->links() !!} --}}
                </div>

                <div class = "tab-pane  {{ $tab == 3 ? 'show active' : '' }}" id="en-cours" role="tabpanel"
                    aria-labelledby="en-cours-tab">
                    <div class="card card-table w-100" style="height: 250px; border-radius: 0 12px 12px 12px"
                        wire:loading>
                        <div class="d-flex justify-content-center h-100 align-items-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-table card" style="border-radius: 0 12px 12px 12px">
                        <div class="row g-3" wire:loading.remove>
                            @forelse ($tacheEncours as $key => $tache)
                                <div class="col-lg-4 col-xxl-3 col-md-6 col-sm-6">
                                    <div class="card-table widget-task">
                                        <div class="block-taks task p-0" style="border: none">
                                            <div
                                                class="badge-task mb-2 @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div
                                                class="badge-task mb-2 @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="block-detail">
                                                        <p>{{ 'La Tâche est en cours ... ' }}
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-2 info-echeance">
                                                        @if ($tache->date_debut)
                                                            <i class="fi fi-rr-calendar-clock icon"></i>
                                                            <p class="debute-task task-date">
                                                                {{ $tache->date_debut->format('d/m/Y') }}
                                                            </p>
                                                        @endif
                                                        @if ($tache->date_fin)
                                                            <span style="color: var(--colorParagraph)">-</span>
                                                            <p class="end-task task-date">
                                                                {{ $tache->date_fin->format('d/m/Y') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div
                                                        class="block-progress d-flex justify-content-between align-items-center">
                                                        <div class="progressBar">

                                                            <div class="move"
                                                                style="width: {{ $tache->pourcentage }}%">
                                                            </div>
                                                        </div>
                                                        <div class="pourcentage">
                                                            {{ $tache->pourcentage }}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-between">
                                                    <div class="block-user d-flex">
                                                        @foreach ($tache->objectifs as $objectif)
                                                            <div class="user">
                                                                <span class="online"></span>
                                                                <div class="tooltip-team">
                                                                    {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objectif->agent?->image) }}"
                                                                    alt="image de profil {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="block-options-sm d-flex align-items-center">
                                                        <a href="{{ route('regidoc.taches.show', $tache) }}"
                                                            class="btn btn-sm btn-add btn-add-hover">
                                                            Voir
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 mx-auto">
                                    <div class="card card-table"
                                        style="border-radius: 0 12px 12px 12px; box-shadow: none!important">
                                        <div class="text-center col-12">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                class="" width="35px">
                                            <p class="text-center para"
                                                style="font-size: 14px; color: vafr(--colorParagraph)">
                                                Aucune tâche en cours
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="tab-pane {{ $tab == 4 ? 'show active' : '' }}" id="terminees" role="tabpanel"
                    aria-labelledby="terminees-tab">
                    <div class="card card-table w-100" style="height: 250px; border-radius: 0 12px 12px 12px"
                        wire:loading>
                        <div class="d-flex justify-content-center h-100 align-items-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-table card" style="border-radius: 0 12px 12px 12px">
                        <div class="row g-3" wire:loading.remove>
                            @forelse ($endTaches as $key => $tache)
                                <div class="col-lg-4 col-xxl-3 col-md-6 col-sm-6">
                                    <div class="card-table widget-task">
                                        <div class="block-taks task p-0" style="border: none">
                                            <div
                                                class="badge-task mb-2 @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="block-detail">
                                                        <p>{{ 'La tâche est terminée.' }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-2 info-echeance">
                                                        @if ($tache->date_debut)
                                                            <i class="fi fi-rr-calendar-clock icon"></i>
                                                            <p class="debute-task task-date">
                                                                {{ $tache->date_debut->format('d/m/Y') }}
                                                            </p>
                                                        @endif
                                                        @if ($tache->date_fin)
                                                            <span style="color: var(--colorParagraph)">-</span>
                                                            <p class="end-task task-date">
                                                                {{ $tache->date_fin->format('d/m/Y') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div
                                                        class="block-progress d-flex justify-content-between align-items-center">
                                                        <div class="progressBar">
                                                            <div class="move"
                                                                style="width: {{ $tache->pourcentage }}%">
                                                            </div>
                                                        </div>
                                                        <div class="pourcentage">
                                                            {{ $tache->pourcentage }}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-between">
                                                    <div class="block-user d-flex">
                                                        @foreach ($tache->objectifs as $objectif)
                                                            <div class="user">
                                                                <span class="online"></span>
                                                                <div class="tooltip-team">
                                                                    {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objectif->agent?->image) }}"
                                                                    alt="image de profil {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="block-options-sm d-flex align-items-center">
                                                        <a href="{{ route('regidoc.taches.show', $tache) }}"
                                                            class="btn btn-sm btn-add btn-add-hover">
                                                            Voir
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 mx-auto">
                                    <div class="card card-table"
                                        style="border-radius: 0 12px 12px 12px; box-shadow: none!important">
                                        <div class="text-center col-12">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                class="" width="35px">
                                            <p class="text-center para"
                                                style="font-size: 14px; color: vafr(--colorParagraph)">
                                                Aucune tâche terminée
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class = "tab-pane  {{ $tab == 5 ? 'show active' : '' }}" id="hors-delais" role="tabpanel"
                    aria-labelledby="hors-delais-tab">
                    <div class="card card-table w-100" style="height: 250px; border-radius: 0 12px 12px 12px"
                        wire:loading>
                        <div class="d-flex justify-content-center h-100 align-items-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card card-table" style="border-radius: 0px 12px 12px 12px">
                        <div class="row g-3" wire:loading.remove>
                            @forelse ($horsDelais as $key => $tache)
                                <div class="col-lg-4 col-xxl-3 col-md-6 col-sm-6">
                                    <div class="card card-table widget-task">
                                        <div class="block-taks task p-0" style="border: none">
                                            <div
                                                class="badge-task mb-2 @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="block-detail">
                                                        <p>{{ 'La Tâche est hors delais ... ' || Str::substr($tache->description, 0, 50) }}
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center gap-2 info-echeance">
                                                        <i class="fi fi-rr-calendar-clock icon"></i>
                                                        <p class="debute-task task-date">
                                                            {{ $tache->date_debut->format('d/m/Y') }}
                                                        </p>
                                                        -
                                                        <p class="end-task task-date">
                                                            {{ $tache->date_fin->format('d/m/Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-12">
                                                    <div
                                                        class="block-progress d-flex justify-content-between align-items-center">
                                                        <div class="progressBar">

                                                            <div class="move"
                                                                style="width: {{ $tache->pourcentage }}%">
                                                            </div>
                                                        </div>
                                                        <div class="pourcentage">
                                                            {{ $tache->pourcentage }}%
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="col-12 ">
                                                    {{-- <div class="block-user d-flex">
                                                        @foreach ($tache->objectifs as $objectif)
                                                            <div class="user">
                                                                <span class="online"></span>
                                                                <div class="tooltip-team">
                                                                    {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objectif->agent?->image) }}"
                                                                    alt="image de profil {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}">
                                                            </div>
                                                        @endforeach
                                                    </div> --}}
                                                    <div class="block-options-sm d-flex align-items-center">
                                                        @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                                                            @if ($tache->pourcentage == 0)
                                                                <button class="btn btn-sm btn-add"
                                                                    wire:click="updateStatut({{ $tache->id }},1)">
                                                                    Accuser reception
                                                                    <span
                                                                        class="spinner-border text-success d-none ms-1"
                                                                        role="status" wire:target="updateStatut"
                                                                        wire:loading.class.remove="d-none"
                                                                        style="font-size: 2px !important; width:10px;height:10px">
                                                                        <span class="sr-only"></span>
                                                                    </span>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-add" disabled>
                                                                    Vous avez déjà accusé réception
                                                                </button>
                                                            @endif
                                                        @else
                                                            @if ($tache->isForDirection() && $tache->pourcentage == 0)
                                                                <button class="btn btn-sl btn-add w-100 mt-2" disabled>
                                                                    En attente d'un accusé de réception
                                                                </button>
                                                            @else
                                                                <button
                                                                    class="btn btn-sm btn-add btn-add-hover w-100 mt-2"
                                                                    wire:click="updateStatut({{ $tache->id }})">
                                                                    Traiter
                                                                    <span
                                                                        class="spinner-border text-success d-none ms-1"
                                                                        role="status"
                                                                        wire:target="updateStatut({{ $tache->id }})"
                                                                        wire:loading.class.remove="d-none"
                                                                        style="font-size: 2px !important; width:10px;height:10px">
                                                                        <span class="sr-only"></span>
                                                                    </span>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 mx-auto">
                                    <div class="card card-table" style="box-shadow: none!important">
                                        <div class="text-center col-12">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                class="" width="35px">
                                            <p class="text-center para"
                                                style="font-size: 14px; color: vafr(--colorParagraph)">
                                                Aucune tâche en retard
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
</div>
