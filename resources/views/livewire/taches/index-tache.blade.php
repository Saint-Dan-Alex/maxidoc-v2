<div class="row g-lg-3 mt-3">
    <div class="col-lg-12" wire:poll>

        @if (Auth::user()->agent->isDG() == false || Auth::user()->agent->isDelegue() == false)
            <div class="mb-0 mb-lg-2 d-flex justify-content-between align-items-center content-list">
                {{-- <ul class="nav nav-pills mt-3 mb-3 nav-mobile navlist-white  bg-nav-mobile nav-tabs nav-tab-page"
                    id="pills-tab" role="tablist" wire:ignore.self>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void()" wire:click='changeTab(1)' @class(['nav-link', 'active' => $tab == 1])>Mes Tâches</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void()" wire:click='changeTab(2)' @class(['nav-link', 'active' => $tab == 2])>
                            Assignées
                            <span class="badge bg-danger ms-2">
                                {{ $newTachesCount }}
                            </span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void()" wire:click='changeTab(3)' @class(['nav-link', 'active' => $tab == 3])>En cours</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void()" wire:click='changeTab(4)' @class(['nav-link', 'active' => $tab == 4])>Terminées</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="javascript:void()" wire:click='changeTab(5)' @class(['nav-link', 'active' => $tab == 5])>Hors Delais</a>
                    </li>
                </ul> --}}

                <ul class="nav nav-pills nav-mobile navlist-white  bg-nav-mobile nav-tabs nav-tab-page"
                    role="tablist" wire:ignore.self id="pills-tab">
                    <li class="nav-item me-3" role="presentation">
                        <button @class(['nav-link', 'active' => $tab == 1]) id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#mes-taches2" type="button" role="tab" aria-controls="mes-taches"
                            aria-selected="true" wire:click='changeTab(1)' wire:loading.attr="disabled">
                            Toutes mes tâches
                        </button>
                    </li>
                    <li class="nav-item me-3" role="presentation">
                        <button @class(['nav-link', 'active' => $tab == 2]) id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#assignees2" type="button" role="tab" aria-controls="assignees"
                            aria-selected="false" wire:click='changeTab(2)' wire:loading.attr="disabled">
                            Assignées
                            <span @class([
                                'badge bg-danger ms-2 rounded-pill py-1 px-2 fw-normal',
                                'd-none' => $newTachesCount <= 0,
                            ]) style="font-size:10px">
                                {{ $newTachesCount }}
                            </span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button @class(['nav-link', 'active' => $tab == 3]) id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#en-cours2" type="button" role="tab" aria-controls="en-cours"
                            aria-selected="false" wire:click='changeTab(3)' wire:loading.attr="disabled">
                            En cours
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button @class(['nav-link', 'active' => $tab == 4]) id="terminees-tab" data-bs-toggle="tab"
                            data-bs-target="#terminees2" type="button" role="tab" aria-controls="terminees"
                            aria-selected="false" wire:click='changeTab(4)' wire:loading.attr="disabled">
                            Terminées
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button @class(['nav-link', 'active' => $tab == 5]) id="hors-delais-tab" data-bs-toggle="tab"
                            data-bs-target="#hors-delais2" type="button" role="tab" aria-controls="hors-delais"
                            aria-selected="false" wire:click='changeTab(5)' wire:loading.attr="disabled">
                            Hors délais
                        </button>
                    </li>
                </ul>
            </div>
        @endif

        <div class="tab-content" id="myTabContent" wire:ignore.self>
            <div class="d-none position-absolute d-flex loader-card justify-content-center"
                style="z-index: 2; height:500px; width:100%; background-color:#edf0f6" wire:loading
                wire:target="changeTab" wire:loading.class.remove="d-none">
                <div class="m-auto text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>

            <div @class(['tab-pane fade', 'show active' => $tab == 1]) id="mes-taches" role="tabpanel" aria-labelledby="mes-taches-tab">
                @if ($tab == 1)
                    <div class="px-3 pt-3 card card-table" style="overflow: inherit">
                        <div class="row px-lg-3 px-3 align-items-center">
                            <div class="col-lg-6 col-6">
                                <h4 class="no-padding no-margin">Liste des tâches à traiter</h4>
                            </div>
                            <div class="col-lg-6 col-6">
                                <div class="d-flex align-items-center justify-content-end">
                                    <a href="{{ route('regidoc.taches.create') }}" class="btn btn-add">
                                        Créer une tâche
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr class="mb-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Titre</th>
                                        <th scope="col">Priorité</th>
                                        <th scope="col">Participants</th>
                                        <th scope="col">Date d'échéance</th>
                                        <th scope="col">Progression</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Actions</th>
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
                                                    @foreach ($tache->objectifs->sortByDesc('id')->unique('agent_id') as $objecif)
                                                        @if ($loop->index < 3)
                                                            <div class="cursor-pointer avatar-team"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modal-edit-participants-{{ $objecif->id }}">
                                                                <div class="tooltip-team">
                                                                    {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objecif->agent?->image) }}"
                                                                    alt="image de profil {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}">
                                                            </div>
                                                        @else
                                                            @php
                                                                $others->push($objecif);
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
                                                                    @foreach ($others as $objecif)
                                                                        <div class="content-user d-flex align-items-center"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#modal-edit-participants-{{ $objecif->id }}">
                                                                            <div class="avatar"
                                                                                style="flex: 0 0 auto">
                                                                                <img src="{{ imageOrDefault($objecif->agent->image) }}"
                                                                                    alt="{{ $objecif->agent->prenom }} {{ $objecif->agent->nom }}">
                                                                            </div>
                                                                            <div class="name">
                                                                                {{ $objecif->agent->prenom }}
                                                                                {{ $objecif->agent->nom }}
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
                                                            Ajouter un autre participant
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
                                                    {{-- <a href="#" class="p-2 text-white btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#modal-show-tache-{{ $tache->id }}"><i
                                                                class="fi fi-rr-eye"></i>
                                                            Voir</a> --}}
                                                    <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn"
                                                        {{-- data-bs-toggle="offcanvas"
                                                        data-bs-target="#detail-task-{{ $tache->id }}" --}}
                                                       >
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
                                                    <p>Aucune tâche n'a été trouvée</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {!! $taches->withQueryString()->links() !!}
                    </div>
                @endif
            </div>

            @if (Auth::user()->agent->isDG() == false  || Auth::user()->agent->isDelegue() == false)
                <div @class(['tab-pane fade', 'show active' => $tab == 2]) id="assignees" role="tabpanel" aria-labelledby="assignees-tab">
                    @if ($tab == 2)
                        <div class="row g-3">
                            @forelse ($newTaches as $key => $tache)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="pb-1 card card-table">
                                        <div class="block-taks task" style="border: none">
                                            <div class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
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
                                                            @foreach ($tache->objectifs as $objecif)
                                                                <div class="user">
                                                                    <span class="online"></span>
                                                                    <img src="{{ imageOrDefault($objecif->agent?->image) }}"
                                                                        alt="image de profil {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}">
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
                                                            <button class="btn btn-sm btn-add"
                                                                wire:click="updateStatut({{ $tache->id }},1)"
                                                                wire:loading.attr='disabled'>
                                                                Accuser réception 
                                                                <span class="spinner-border text-success d-none ms-1"
                                                                    role="status" wire:target="updateStatut"
                                                                    wire:loading.class.remove="d-none"
                                                                    style="font-size: 2px !important; width:10px;height:10px">
                                                                    <span class="sr-only"></span>
                                                                </span>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-add" disabled>
                                                                Vous avez déjà accusé réception ?
                                                            </button>
                                                        @endif
                                                    @else
                                                        @if ($tache->isForDirection() && $tache->pourcentage == 0)
                                                            <button class="btn btn-sl btn-add" disabled>
                                                                En attente d'un accusé de réception
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-add"
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
                                    <div class="card card-table">
                                        <div class="text-center col-12">
                                            <img src="{{ asset('assets/images/sad.gif') }}" alt=""
                                                class="" width="35px">
                                            <p class="text-center para"
                                                style="font-size: 14px; color: var(--colorParagraph)">
                                                Aucune tâche assignée
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        {{-- {!! $newTaches->withQueryString()->links() !!} --}}
                    @endif
                </div>

                <div @class(['tab-pane fade', 'show active' => $tab == 3]) id="en-cours" role="tabpanel" aria-labelledby="en-cours-tab">
                    @if ($tab == 3)
                        <div class="row g-3">
                            @forelse ($tacheEncours as $key => $tache)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="pb-1 card card-table">
                                        <div class="block-taks task" style="border: none">
                                            <div
                                                class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div
                                                class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="block-detail">
                                                        <p>{{ 'La Tâche est en cours ... ' }}
                                                    </div>
                                                </div>
                                                @if ($tache->date_debut)
                                                    <div class="col-6">
                                                        <span class="item-date">
                                                            Date de début
                                                        </span>
                                                        <p class="debute-task task-date"> {{ $tache->date_debut }}</p>
                                                    </div>
                                                @endif
                                                @if ($tache->date_fin)
                                                    <div class="col-6">
                                                        <span class="item-date">
                                                            Date d'échéance
                                                        </span>
                                                        <p class="end-task task-date">{{ $tache->date_fin }}</p>
                                                    </div>
                                                @endif
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
                                                        @foreach ($tache->objectifs as $objecif)
                                                            <div class="user">
                                                                <span class="online"></span>
                                                                <div class="tooltip-team">
                                                                    {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objecif->agent?->image) }}"
                                                                    alt="image de profil {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="block-options-sm d-flex align-items-center">
                                                        <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn btn-sm btn-add"
                                                            {{-- data-bs-toggle="offcanvas"
                                                            data-bs-target="#detail-task-{{ $tache->id }}" --}}
                                                            >Voir</a>
                                                        {{-- <a href="#" data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-task-{{ $tache->id }}"
                                                                data-bs-pan="{{ 1 }}"
                                                                aria-controls="offcanvasRight">
                                                                <i class="fi fi-rr-eye"></i>
                                                            </a>
                                                            <a href="#" data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-task-{{ $tache->id }}"
                                                                data-bs-pan="{{ 2 }}">
                                                                <i class="fi fi-rr-clip"></i>
                                                            </a>
                                                            <a href="#" data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-task-{{ $tache->id }}"
                                                                data-bs-pan="{{ 3 }}">
                                                                <i class="fi fi-rr-comment-alt"></i>
                                                            </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 mx-auto">
                                    <div class="card card-table">
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
                        {{-- {!! $tacheEncours->withQueryString()->links() !!} --}}
                    @endif
                </div>

                <div @class(['tab-pane', 'show active' => $tab == 4]) id="terminees" role="tabpanel" aria-labelledby="terminees-tab">
                    @if ($tab == 4)
                        <div class="row g-3">
                            @forelse ($endTaches as $key => $tache)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="pb-1 card card-table">
                                        <div class="block-taks task" style="border: none">
                                            <div
                                                class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="block-detail">
                                                        <h6>{{ $tache->tache }}</h6>
                                                        <p>{{ 'La tâche est terminée.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-6 d-flex align-items-end" style="flex-tache:column">
                                                    @if ($tache->date_debut)
                                                        <div class="col-6">
                                                            <span class="item-date">
                                                                Date de début
                                                            </span>
                                                            <p class="debute-task task-date"> {{ $tache->date_debut }}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($tache->date_fin)
                                                        <div class="col-6">
                                                            <span class="item-date">
                                                                Date d'échéance
                                                            </span>
                                                            <p class="end-task task-date">{{ $tache->date_fin }}</p>
                                                        </div>
                                                    @endif
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
                                                            {{ $tache->pourcentage }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-between">
                                                    <div class="block-user d-flex">
                                                        @foreach ($tache->objectifs as $objecif)
                                                            <div class="user">
                                                                <span class="online"></span>
                                                                <div class="tooltip-team">
                                                                    {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objecif->agent?->image) }}"
                                                                    alt="image de profil {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="block-options-sm d-flex align-items-center">
                                                        <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn btn-sm btn-add"
                                                            {{-- data-bs-toggle="offcanvas"
                                                            data-bs-target="#detail-task-{{ $tache->id }}" --}}
                                                            >Voir</a>
                                                        {{-- <a href="#" data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-task-{{ $tache->id }}"
                                                                data-bs-pan="{{ 1 }}"
                                                                aria-controls="offcanvasRight">
                                                                <i class="fi fi-rr-eye"></i>
                                                            </a>
                                                            <a href="#" data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-task-{{ $tache->id }}"
                                                                data-bs-pan="{{ 2 }}">
                                                                <i class="fi fi-rr-clip"></i>
                                                            </a>
                                                            <a href="#" data-bs-toggle="offcanvas"
                                                                data-bs-target="#detail-task-{{ $tache->id }}"
                                                                data-bs-pan="{{ 3 }}">
                                                                <i class="fi fi-rr-comment-alt"></i>
                                                            </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-lg-12 mx-auto">
                                    <div class="card card-table">
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
                        {{-- {!! $endTaches->withQueryString()->links() !!} --}}
                    @endif
                </div>

                <div @class(['tab-pane', 'show active' => $tab == 5]) id="hors-delais" role="tabpanel"
                    aria-labelledby="hors-delais-tab">
                    @if ($tab == 5)
                        <div class="row g-3">
                            @forelse ($horsDelais as $key => $tache)
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="pb-1 card card-table">
                                        <div class="block-taks task" style="border: none">
                                            <div
                                                class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div
                                                class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                                {{ $tache->priorite->titre }}
                                            </div>
                                            <div class="block">{{ $tache->titre }}</div>
                                            <div class="row g-2">
                                                <div class="col-12">
                                                    <div class="block-detail">
                                                        <p>{{ 'La Tâche est hors delais ... ' || Str::substr($tache->description, 0, 50) }}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <span class="item-date">
                                                        Date de début
                                                    </span>
                                                    <p class="debute-task task-date"> {{ $tache->date_debut }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <span class="item-date">
                                                        Date d'échéance
                                                    </span>
                                                    <p class="end-task task-date">{{ $tache->date_fin }}</p>
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
                                                        @foreach ($tache->objectifs as $objecif)
                                                            <div class="user">
                                                                <span class="online"></span>
                                                                <div class="tooltip-team">
                                                                    {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}
                                                                </div>
                                                                <img src="{{ imageOrDefault($objecif->agent?->image) }}"
                                                                    alt="image de profil {{ $objecif->agent?->prenom . ' ' . $objecif->agent?->nom }}">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="block-options-sm d-flex align-items-center">
                                                        @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                                                            @if ($tache->pourcentage == 0)
                                                                <button class="btn btn-sm btn-add"
                                                                    wire:click="updateStatut({{ $tache->id }},1)">
                                                                    Accuser réception
                                                                    <span class="spinner-border text-success d-none ms-1"
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
                                                                <button class="btn btn-sl btn-add" disabled>
                                                                    En attente d'un accusé de réception
                                                                </button>
                                                            @else
                                                                <button class="btn btn-sm btn-add"
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
                                    <div class="card card-table">
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
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
