{{-- <div class="mt-3 row g-lg-3">

    <div class="row pe-0">
        <div class="col-12 pe-0">
        </div>
    </div>
</div> --}}
<div class="col-lg-12" id="des-courriers-root">
    <!-- Modal Suppression (Soft Delete) -->
    <div class="modal fade" id="modal-delete-courrier" tabindex="-1" aria-hidden="true" wire:ignore.self style="z-index: 99999;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i class="fi fi-rr-trash shadow-icon-danger" style="font-size: 3rem; color: #dc3545;"></i>
                        <h5 class="mt-3">Mettre à la corbeille ?</h5>
                        <p>Le courrier pourra être restauré par un administrateur.</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-delete" wire:click="deleteCourrier">Confirmer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Suppression Définitive (Force Delete) -->
    <div class="modal fade" id="modal-force-delete-courrier" tabindex="-1" aria-hidden="true" wire:ignore.self style="z-index: 99999;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i class="fi fi-rr-exclamation shadow-icon-danger" style="font-size: 3rem; color: #dc3545;"></i>
                        <h5 class="mt-3 text-danger">Action irréversible !</h5>
                        <p>Voulez-vous vraiment supprimer définitivement ce courrier ?</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-delete" wire:click="forceDeleteCourrier" style="background-color: #dc3545; border-color: #dc3545;">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Restauration -->
    <div class="modal fade" id="modal-restore-courrier" tabindex="-1" aria-hidden="true" wire:ignore.self style="z-index: 99999;">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i class="fi fi-rr-refresh shadow-icon-success" style="font-size: 3rem; color: #198754;"></i>
                        <h5 class="mt-3 text-success">Restaurer le courrier ?</h5>
                        <p>Le courrier sera remis dans la liste principale.</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal">Annuler</button>
                        <button class="btn btn-add" wire:click="restoreCourrier" style="background-color: #198754; border-color: #198754;">Restaurer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex row justify-content-between align-items-center align-items-md-center block-action-table-2">
        <div class="col-lg-8 col-sm-8 col-9">
            <div class="d-flex">
                <ul class="mb-0 nav nav-tabs nav-user" id="myTab" role="tablist" wire:ignore>
                    @if (
                        (Auth::user()->can('Numériser un document entrant') && Auth::user()->can('Numériser un document sortant')) ||
                            (Auth::user()->can('Numériser un document entrant') &&
                                Auth::user()->can('Numériser un document interne')) ||
                            (Auth::user()->can('Numériser un document sortant') &&
                                Auth::user()->can('Numériser un document interne')) ||
                            (!(
                                (Auth::user()->can('Numériser un document entrant') &&
                                    Auth::user()->can('Numériser un document sortant')) ||
                                (Auth::user()->can('Numériser un document entrant') &&
                                    Auth::user()->can('Numériser un document interne')) ||
                                (Auth::user()->can('Numériser un document sortant') &&
                                    Auth::user()->can('Numériser un document interne'))
                            ) &&
                                Auth::user()->can('Voir les courriers')) && !$isSuperAdmin)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 1 ? 'active' : '' }}" id="all-tab"
                                data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab"
                                aria-controls="all" aria-selected="{{ $active_tab == 1 }}"
                                wire:click='changeTab(1)'>Tous </button>
                        </li>
                    @endif

                    @if ($isSuperAdmin)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $active_tab == 5 ? 'active' : '' }}" id="trash-tab"
                                data-bs-toggle="tab" data-bs-target="#trash" type="button" role="tab"
                                aria-controls="trash" aria-selected="{{ $active_tab == 5 }}"
                                wire:click='changeTab(5)'>
                                <i class="fi fi-rr-trash me-1"></i> Corbeille
                            </button>
                        </li>
                    @else
                        @if ($isDG)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $active_tab == 2 ? 'active' : '' }}" id="entrant-tab"
                                    data-bs-toggle="tab" data-bs-target="#entrant" type="button" role="tab"
                                    aria-controls="entrant" aria-selected="{{ $active_tab == 2 }}"
                                    wire:click='changeTab(2)'>A orienter</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $active_tab == 3 ? 'active' : '' }}" id="sortant-tab"
                                    data-bs-toggle="tab" data-bs-target="#sortant" type="button" role="tab"
                                    aria-controls="sortant" aria-selected="{{ $active_tab == 3 }}"
                                    wire:click='changeTab(3)'>En cours</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $active_tab == 4 ? 'active' : '' }}" id="finalise-tab"
                                    data-bs-toggle="tab" data-bs-target="#finalise" type="button" role="tab"
                                    aria-controls="finalise" aria-selected="{{ $active_tab == 4 }}"
                                    wire:click='changeTab(4)'>Finalisés</button>
                            </li>
                            @if ($isDG || $isAssistant || $isSecretaire || Auth::user()->can('Restaurer un courrier'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $active_tab == 5 ? 'active' : '' }}" id="trash-tab"
                                        data-bs-toggle="tab" data-bs-target="#trash" type="button" role="tab"
                                        aria-controls="trash" aria-selected="{{ $active_tab == 5 }}"
                                        wire:click='changeTab(5)'>
                                        <i class="fi fi-rr-trash me-1"></i> Corbeille
                                    </button>
                                </li>
                            @endif
                        @else
                            @if (!$isSec)
                                @can('Numériser un document entrant')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $active_tab == 2 ? 'active' : '' }}" id="entrant-tab"
                                            data-bs-toggle="tab" data-bs-target="#entrant" type="button" role="tab"
                                            aria-controls="entrant" aria-selected="{{ $active_tab == 2 }}"
                                            wire:click='changeTab(2)'>Entrants</button>
                                    </li>
                                @endcan
                            @endif

                            @can('Numériser un document sortant')
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $active_tab == 3 ? 'active' : '' }}" id="sortant-tab"
                                        data-bs-toggle="tab" data-bs-target="#sortant" type="button" role="tab"
                                        aria-controls="sortant" aria-selected="{{ $active_tab == 3 }}"
                                        wire:click='changeTab(3)'>Traités</button>
                                </li>
                            @endcan

                            @can('Numériser un document interne')
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $active_tab == 4 ? 'active' : '' }}" id="interne-tab"
                                        data-bs-toggle="tab" data-bs-target="#interne" type="button" role="tab"
                                        aria-controls="interne" aria-selected="{{ $active_tab == 4 }}"
                                        wire:click='changeTab(4)'>Internes</button>
                                </li>
                            @endcan

                            @if ($isAssistant || $isSecretaire || Auth::user()->can('Restaurer un courrier'))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $active_tab == 5 ? 'active' : '' }}" id="trash-tab"
                                        data-bs-toggle="tab" data-bs-target="#trash" type="button" role="tab"
                                        aria-controls="trash" aria-selected="{{ $active_tab == 5 }}"
                                        wire:click='changeTab(5)'>
                                        <i class="fi fi-rr-trash me-1"></i> Corbeille
                                    </button>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-3 d-flex align-items-center justify-content-end">
            @can('Numériser un document')
                @if(!$isSuperAdmin)
                <a href="{{ route('regidoc.courriers.create') }}"
                    class="btn btn-add btn-add-hover ms-auto btn-scanner-inbox" style="flex: 0 0 auto;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-plus d-flex d-sm-none d-lg-none">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Numériser un document</span>
                </a>
                @endif
            @endcan
        </div>
    </div>

    <div class="bg-white tab-content" id="myTabContent" style="border-radius: 12px">
        @if (
            (Auth::user()->can('Numériser un document entrant') && Auth::user()->can('Numériser un document sortant')) ||
                (Auth::user()->can('Numériser un document entrant') &&
                    Auth::user()->can('Numériser un document interne')) ||
                (Auth::user()->can('Numériser un document sortant') &&
                    Auth::user()->can('Numériser un document interne')) ||
                (!(
                    (Auth::user()->can('Numériser un document entrant') &&
                        Auth::user()->can('Numériser un document sortant')) ||
                    (Auth::user()->can('Numériser un document entrant') &&
                        Auth::user()->can('Numériser un document interne')) ||
                    (Auth::user()->can('Numériser un document sortant') &&
                        Auth::user()->can('Numériser un document interne'))
                ) &&
                    Auth::user()->can('Voir les courriers')))
            <!-- Tous Tab -->
            <div class="tab-pane fade {{ $active_tab == 1 ? 'show active' : '' }}" id="all" role="tabpanel"
                aria-labelledby="all-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col">
                            <h4 class="no-padding no-margin">@if($isDG) Tous les courriers @else Liste des courriers numérisés @endif</h4>
                        </div>
                        <div class="col-lg-6 col-xl-5 col-xxl-4 d-flex align-items-center justify-content-end">
                            <input type="text" class="form-control me-2 input-search-card" wire:model='search'
                                placeholder="Recherche" style="border:none;">
                        </div>
                    </div>
                    @if($isDG)
                    <div class="row g-3 align-items-center">
                        <div class="col-12 d-flex align-items-center justify-content-lg-end">
                            <div class="d-flex align-items-center w-100">
                               <div class="input-group block-input-filter flex-nowrap">
                                   <select wire:model.debounce.500ms="statut" id="statut" style="min-width: 70px; flex: 1; border-right: none"
                                       class="form-select form-control">
                                       <option value="null" selected disabled>Etat </option>
                                       <option value="">Tous</option>
                                       <option value=1>En attente</option>
                                       <option value=2>En cours</option>
                                       <option value=3>Traité</option>
                                       <option value=4>Archivé</option>
                                   </select>
                                   <select id="priority" class="form-select form-control" style="min-width: 75px; flex: 1;"
                                       wire:model.debounce.500ms="priority">
                                       <option value="null" selected disabled>Priorité</option>
                                       <option value="">Toutes</option>
                                       <option value=1>Faible</option>
                                       <option value=2>Moyen</option>
                                       <option value=3>Fort</option>
                                       <option value=4>Urgent</option>
                                   </select>
                                   <select name="datep" id="mois" class="form-select form-control" style="min-width: 70px; flex: 1;"
                                       wire:model.debounce.500ms='selectedMonth'>
                                       <option value="null" selected disabled>Mois</option>
                                       @for ($i = 1; $i <= 12; $i++)
                                           <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                           </option>
                                       @endfor
                                   </select>
                                   <select name="datep" id="annee" class="form-select form-control"
                                       style="min-width: 70px; max-width: 90px; border-right: none" wire:model.debounce.500ms='selectedYear'>
                                       <option value="null" selected disabled>Année</option>
                                       @for ($i = ((int) now()->year); $i > 1990; $i--)
                                           <option value="{{ $i }}">{{ $i }}</option>
                                       @endfor
                                   </select>
                                   <button class="btn btn-add refresh-filter btn-search-sm flex-shrink-0" type="button"
                                       id="" wire:click="refreshSelection">
                                       <i class="fi fi-rr-refresh"></i>
                                   </button>
                               </div>
                           </div>
                       </div>
                    </div>
                    @endif
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
                                    @if (!$isSec)
                                        <th scope="col">Titre</th>
                                    @endif
                                    <th scope="col">N° d'enregistrement</th>
                                    @if (!$isSec)
                                        <th scope="col">Expéditeur</th>
                                    @endif
                                    @if (!$isSec)
                                        <th scope="col">Destinataire</th>
                                    @endif
                                    @if (!$isSec)
                                        <th scope="col">Accusées réceptions</th>
                                    @endif
                                    <th scope="col">Date de réception</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Priorité</th>
                                    @if (!$isSec)
                                        <th scope="col">Statut</th>
                                        <th scope="col">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($allcourriers as $courrier)
                                    @if ($courrier->statut_id != 3)
                                        <tr @class(['', 'tr-no-read' => !$courrier->isViewed()])>
                                            @if($courrier->type)
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

                                                @elseif ($courrier->type->titre === 'Entrant')
                                                @if (!$isSec)   
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
                                                @elseif ($courrier->type->titre === 'Interne')
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
                                                @else
                                                    <td class="text-truncate title-file-box-table-data">
                                                        {{ $courrier->title ?? 'Non définie' }}
                                                    </td>
                                                @endif
                                            @else
                                                <td class="text-truncate title-file-box-table-data">
                                                    {{ $courrier->title ?? 'Non définie' }}
                                                </td>
                                            @endif
                                            <td>{{ $courrier->reference_interne }}</td>
                                            
                                            @if (!$isSec)
                                                <td>
                                                    @if ($courrier->type_id == 1)
                                                        {{ $courrier->externExpediteur->nom ?? 'N/D' }}
                                                    @elseif($courrier->type_id == 3)
                                                    {{ optional($courrier->author->service)->titre ?? 'N/D' }}
                                                @else
                                                    Lerexcom Petroleum
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if ($courrier->type_id == 2)
                                                    {{ $courrier->externDestinateur->nom ?? 'N/D' }}
                                                @elseif($courrier->type_id == 3)
                                                {{ optional($courrier->destinateurs->first())->prenom }} {{ optional($courrier->destinateurs->first())->nom ?? 'N/D' }}
                                                @else
                                                    Lerexcom Petroleum
                                                @endif
                                            </td>
                                            @endif
                                            @if (!$isSec)
                                            <td class="text-nowrap">
                                                @if ($courrier->accuseReceptions->count() > 0)
                                                    <div class="box-avatar d-flex align-items-center">
                                                        @php
                                                            $shownAccuses = $courrier->accuseReceptions->take(4);
                                                            $otherAccuses = $courrier->accuseReceptions->slice(4);
                                                        @endphp
                                                        
                                                        @foreach($shownAccuses as $accuse)
                                                            <div class="cursor-pointer avatar-team"
                                                                data-bs-toggle="tooltip" 
                                                                data-bs-placement="top"
                                                                title="{{ $accuse->user->agent->prenom }} {{ $accuse->user->agent->nom }}">
                                                                <img src="{{ imageOrDefault($accuse->user->agent->image) }}" 
                                                                    alt="{{ $accuse->user->agent->prenom }} {{ $accuse->user->agent->nom }}"
                                                                    class="avatar-img">
                                                            </div>
                                                        @endforeach
                                                        
                                                        @if($otherAccuses->count() > 0)
                                                            <div class="dropdown">
                                                                <div class="cursor-pointer avatar-team plus d-flex align-items-center justify-content-center"
                                                                    data-bs-toggle="dropdown" 
                                                                    aria-expanded="false"
                                                                    style="margin-right: 0">
                                                                    <span>+{{ $otherAccuses->count() }}</span>
                                                                </div>
                                                                <div class="dropdown-menu dropdown-menu-end p-2">
                                                                    <div class="list-users">
                                                                        @foreach($otherAccuses as $accuse)
                                                                            <div class="content-user d-flex align-items-center mb-2">
                                                                                <div class="avatar me-2">
                                                                                    <img src="{{ imageOrDefault($accuse->user->agent->image) }}" 
                                                                                        alt="{{ $accuse->user->agent->prenom }} {{ $accuse->user->agent->nom }}"
                                                                                        class="avatar-img">
                                                                                </div>
                                                                                <div class="name">
                                                                                    <div>{{ $accuse->user->agent->prenom }} {{ $accuse->user->agent->nom }}</div>
                                                                                    <small class="text-muted">{{ $accuse->created_at->format('d/m/Y H:i') }}</small>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="">Aucun accusé</span>
                                                @endif
                                            </td>
                                                
                                            @endif
                                            
                                            <td>{{ $courrier->created_at->format('d/m/Y H:i:s') }}</td>
                                            
                                            <td>{{ $courrier->type ? $courrier->type->titre : 'Inconnu' }}</td>
                                            <td>
                                            <div @class([
                                                'badge-priority',
                                                'badge-priority-gray' =>
                                                    $courrier->priorite_id != 1 &&
                                                    $courrier->priorite_id != 2 &&
                                                    $courrier->priorite_id != 3 &&
                                                    $courrier->priorite_id != 4,
                                                'normal badge-priority-normal' => $courrier->priorite_id == 1,
                                                'urgent  badge-priority-red' => $courrier->priorite_id == 4,
                                                'absolute badge-priority-yellow' => $courrier->priorite_id == 3,
                                                'important badge-priority-green' => $courrier->priorite_id == 2,
                                            ])>
                                                {{ $courrier->priorite?->titre ?? 'N/A' }}
                                            </div>
                                        </td>

                                            @if (!$isSec)
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
                                                        @php
                                                            [$agentId, $dgAgentId] = \App\Helpers\DelegationHelper::getAgentIds();
                                                            $agentIds = array_filter([$agentId, $dgAgentId]);
                                                            
                                                            $isAuthorized = ($courrier->isIntern() && array_intersect($courrier->destinateurs->pluck('id')->toArray(), $agentIds)) ||
                                                                array_intersect($courrier->followers->pluck('id')->toArray(), $agentIds) ||
                                                                in_array($courrier->created_by, $agentIds) ||
                                                                $courrier->partages->whereIn('agent_id', $agentIds)->count() > 0 ||
                                                                $isDG;
                                                                
                                                            // Seul le VRAI DG est restreint sur les nouveaux courriers (statut 1) 
                                                            $isRealDG = Auth::user()->agent && Auth::user()->agent->isDG() && !session('delegation_mode');
                                                            $canShowActions = $isAuthorized && (!$isRealDG || $courrier->statut_id != 1);
                                                        @endphp
                                                        
                                                        @if ($canShowActions)
                                                            <a href="{{ route('regidoc.courriers.show', $courrier) }}"
                                                                class="btn">
                                                                <i class="fi fi-rr-eye"></i>
                                                                <div class="tooltip-btn">Voir détails</div>
                                                            </a>
                                                            @can('delete', $courrier)
                                                                <button wire:click="confirmDeletion({{ $courrier->id }})" class="btn text-danger">
                                                                    <i class="fi fi-rr-trash"></i>
                                                                    <div class="tooltip-btn">Supprimer</div>
                                                                </button>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </td>
                                            @endif
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

       @if ($isDG || (!$isSec && Auth::user()->can('Numériser un document entrant')))
       <!-- Entrants Tab / A orienter (DG) -->
       <div class="tab-pane fade {{ $active_tab == 2 ? 'show active' : '' }}" id="entrant" role="tabpanel"
           aria-labelledby="entrant-tab">
           <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-lg-6">
                        <h4 class="no-padding no-margin ps-3">@if($isDG) Courriers à orienter @else Courriers entrants @endif</h4>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center justify-content-lg-end">
                            <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                style="border:none;" wire:model='search'>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-12 d-flex align-items-center justify-content-lg-end">
                        <div class="d-flex align-items-center w-100">
                           <div class="input-group block-input-filter flex-nowrap">
                               <select wire:model.debounce.500ms="statut" id="statut" style="min-width: 70px; flex: 1; border-right: none"
                                   class="form-select form-control">
                                   <option value="null" selected disabled>Etat </option>
                                   <option value="">Tous</option>
                                   <option value=1>En attente</option>
                                   <option value=2>En cours</option>
                                   <option value=3>Traité</option>
                                   <option value=4>Archivé</option>
                               </select>
                               <select id="priority" class="form-select form-control" style="min-width: 75px; flex: 1;"
                                   wire:model.debounce.500ms="priority">
                                   <option value="null" selected disabled>Priorité</option>
                                   <option value="">Toutes</option>
                                   <option value=1>Faible</option>
                                   <option value=2>Moyen</option>
                                   <option value=3>Fort</option>
                                   <option value=4>Urgent</option>
                               </select>
                               <select name="datep" id="mois" class="form-select form-control" style="min-width: 70px; flex: 1;"
                                   wire:model.debounce.500ms='selectedMonth'>
                                   <option value="null" selected disabled>Mois</option>
                                   @for ($i = 1; $i <= 12; $i++)
                                       <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                       </option>
                                   @endfor
                               </select>
                               <select name="datep" id="annee" class="form-select form-control"
                                   style="min-width: 70px; max-width: 90px; border-right: none" wire:model.debounce.500ms='selectedYear'>
                                   <option value="null" selected disabled>Année</option>
                                   @for ($i = ((int) now()->year); $i > 1990; $i--)
                                       <option value="{{ $i }}">{{ $i }}</option>
                                   @endfor
                               </select>
                               <button class="btn btn-add refresh-filter btn-search-sm flex-shrink-0" type="button"
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
                               @if($isDG)
                                   <th scope="col">Priorité</th>
                               @else
                                   @can('Definir le traitement')
                                       <th scope="col">Priorité</th>
                                   @endcan
                               @endif
                               <th scope="col">Date de réception</th>
                               @if (!$isSec)
                                   <th scope="col">Statut</th>
                                   <th scope="col">Action</th>
                               @endif
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
                                        @if ($entrant->accuseReceptions->count() > 0)
                                            <div class="box-avatar d-flex align-items-center">
                                                @php
                                                    $shownAccuses = $entrant->accuseReceptions->take(4);
                                                    $otherAccuses = $entrant->accuseReceptions->slice(4);
                                                @endphp
                                                
                                                @foreach($shownAccuses as $accuse)
                                                    <div class="cursor-pointer avatar-team"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-placement="top"
                                                        title="{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}">
                                                        <img src="{{ imageOrDefault(optional($accuse->user->agent)->image) }}" 
                                                            alt="{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}"
                                                            class="avatar-img">
                                                    </div>
                                                @endforeach
                                                
                                                @if($otherAccuses->count() > 0)
                                                    <div class="dropdown">
                                                        <div class="cursor-pointer avatar-team plus d-flex align-items-center justify-content-center"
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false"
                                                            style="margin-right: 0">
                                                            <span>+{{ $otherAccuses->count() }}</span>
                                                        </div>
                                                        <div class="dropdown-menu dropdown-menu-end p-2">
                                                            <div class="list-users">
                                                                @foreach($otherAccuses as $accuse)
                                                                    <div class="content-user d-flex align-items-center mb-2">
                                                                        <div class="avatar me-2">
                                                                            <img src="{{ imageOrDefault(optional($accuse->user->agent)->image) }}" 
                                                                                alt="{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}"
                                                                                class="avatar-img" width="24" height="24">
                                                                        </div>
                                                                        <div class="name">
                                                                            <div>{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}</div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">Aucun accusé</span>
                                        @endif
                                    </td>
                                    @if($isDG)
                                        <td>
                                            <div @class([
                                                'badge-priority',
                                                'badge-priority-gray' =>
                                                    $entrant->priorite_id != 1 &&
                                                    $entrant->priorite_id != 2 &&
                                                    $entrant->priorite_id != 3 &&
                                                    $entrant->priorite_id != 4,
                                                'normal badge-priority-normal' => $entrant->priorite_id == 1,
                                                'urgent  badge-priority-red' => $entrant->priorite_id == 4,
                                                'absolute badge-priority-yellow' => $entrant->priorite_id == 3,
                                                'important badge-priority-green' => $entrant->priorite_id == 2,
                                            ])>
                                                {{ $entrant->priorite?->titre ?? 'N/A' }}
                                            </div>
                                        </td>
                                    @else
                                        @can('Definir le traitement')
                                            <td>
                                                <div @class([
                                                    'badge-priority',
                                                    'badge-priority-gray' =>
                                                        $entrant->priorite_id != 1 &&
                                                        $entrant->priorite_id != 2 &&
                                                        $entrant->priorite_id != 3 &&
                                                        $entrant->priorite_id != 4,
                                                    'normal badge-priority-normal' => $entrant->priorite_id == 1,
                                                    'urgent  badge-priority-red' => $entrant->priorite_id == 4,
                                                    'absolute badge-priority-yellow' => $entrant->priorite_id == 3,
                                                    'important badge-priority-green' => $entrant->priorite_id == 2,
                                                ])>
                                                    {{ $entrant->priorite?->titre ?? 'N/A' }}
                                                </div>
                                            </td>
                                        @endcan
                                    @endif
                                    <td>{{ $entrant->created_at->format('d/m/Y') }}</td>
                                    @if (!$isSec)
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
                                                @php
                                                    [$agentId, $dgAgentId] = \App\Helpers\DelegationHelper::getAgentIds();
                                                    $agentIds = array_filter([$agentId, $dgAgentId]);
                                                    
                                                    $isAuthorized = ($entrant->isIntern() && array_intersect($entrant->destinateurs->pluck('id')->toArray(), $agentIds)) ||
                                                        array_intersect($entrant->followers->pluck('id')->toArray(), $agentIds) ||
                                                        in_array($entrant->created_by, $agentIds) ||
                                                        $entrant->partages->whereIn('agent_id', $agentIds)->count() > 0 ||
                                                        $isDG;
                                                        
                                                    $isRealDG = Auth::user()->agent && Auth::user()->agent->isDG() && !session('delegation_mode');
                                                    $canShowActions = $isAuthorized && (!$isRealDG || $entrant->statut_id != 1);
                                                @endphp
                                                
                                                @if ($canShowActions)
                                                    <a href="{{ route('regidoc.courriers.show', $entrant) }}" class="btn">
                                                        <i class="fi fi-rr-eye"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                    @can('delete', $entrant)
                                                        <button wire:click="confirmDeletion({{ $entrant->id }})" class="btn text-danger">
                                                            <i class="fi fi-rr-trash"></i>
                                                            <div class="tooltip-btn">Supprimer</div>
                                                        </button>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    @endif
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
            
        @endif

        @if ($isDG || Auth::user()->can('Numériser un document sortant'))
            <!-- Sortants Tab / En cours (DG) -->
            <div class="tab-pane fade {{ $active_tab == 3 ? 'show active' : '' }}" id="sortant" role="tabpanel"
                aria-labelledby="sortant-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                    <div class="row g-3 align-items-center mb-3">
                    <div class="col-lg-6">
                        <h4 class="no-padding no-margin ps-3">@if($isDG) Courriers en cours @else Courriers sortants @endif</h4>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center justify-content-lg-end">
                            <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                style="border:none;" wire:model='search'>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-items-center">
                    <div class="col-12 d-flex align-items-center justify-content-lg-end">
                        <div class="d-flex align-items-center w-100">
                                <div class="input-group block-input-filter flex-nowrap">
                                    <select wire:model.debounce.500ms="statut" id="statut" style="min-width: 70px; flex: 1; border-right: none"
                                        class="form-select form-control">
                                        <option value="null" selected disabled>Etat </option>
                                        <option value="">Tous</option>
                                        <option value=1>En attente</option>
                                        <option value=2>En cours</option>
                                        <option value=3>Traité</option>
                                        <option value=4>Archivé</option>
                                    </select>
                                    <select id="priority" class="form-select form-control" style="min-width: 75px; flex: 1;"
                                        wire:model.debounce.500ms="priority">
                                        <option value="null" selected disabled>Priorité</option>
                                        <option value="">Toutes</option>
                                        <option value=1>Faible</option>
                                        <option value=2>Moyen</option>
                                        <option value=3>Fort</option>
                                        <option value=4>Urgent</option>
                                    </select>
                                    <select name="datep" id="mois" class="form-select form-control" style="min-width: 70px; flex: 1;"
                                        wire:model.debounce.500ms='selectedMonth'>
                                        <option value="null" selected disabled>Mois</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                            </option>
                                        @endfor
                                    </select>
                                    <select name="datep" id="annee" class="form-select form-control"
                                        style="min-width: 70px; max-width: 90px; border-right: none" wire:model.debounce.500ms='selectedYear'>
                                        <option value="null" selected disabled>Année</option>
                                        @for ($i = ((int) now()->year); $i > 1990; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <button class="btn btn-add refresh-filter btn-search-sm flex-shrink-0" type="button"
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
                                    @if($isDG)
                                        <th scope="col">Priorité</th>
                                    @endif
                                    <th scope="col">Accusées réceptions</th>
                                    <th scope="col">Date du courrier</th>
                                    <th scope="col">Date de traitement</th>
                                    <th scope="col">Date d'émission</th>
                                    <th scope="col">Statut</th>
                                    {{-- <th scope="col" class="text-center">Accusés</th> --}}
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
                                        @if($isDG)
                                            <td>
                                                <div @class([
                                                    'badge-priority',
                                                    'badge-priority-gray' =>
                                                        $sortant->priorite_id != 1 &&
                                                        $sortant->priorite_id != 2 &&
                                                        $sortant->priorite_id != 3 &&
                                                        $sortant->priorite_id != 4,
                                                    'normal badge-priority-normal' => $sortant->priorite_id == 1,
                                                    'urgent  badge-priority-red' => $sortant->priorite_id == 4,
                                                    'absolute badge-priority-yellow' => $sortant->priorite_id == 3,
                                                    'important badge-priority-green' => $sortant->priorite_id == 2,
                                                ])>
                                                    {{ $sortant->priorite?->titre ?? 'N/A' }}
                                                </div>
                                            </td>
                                        @endif
                                        <td class="text-nowrap">
                                            @if ($sortant->accuseReceptions->count() > 0)
                                                <div class="box-avatar d-flex align-items-center">
                                                    @php
                                                        $shownAccuses = $sortant->accuseReceptions->take(4);
                                                        $otherAccuses = $sortant->accuseReceptions->slice(4);
                                                    @endphp
                                                    
                                                    @foreach($shownAccuses as $accuse)
                                                        <div class="cursor-pointer avatar-team"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top"
                                                            title="{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}">
                                                            <img src="{{ imageOrDefault(optional($accuse->user->agent)->image) }}" 
                                                                alt="{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}"
                                                                class="avatar-img">
                                                        </div>
                                                    @endforeach
                                                    
                                                    @if($otherAccuses->count() > 0)
                                                        <div class="dropdown">
                                                            <div class="cursor-pointer avatar-team plus d-flex align-items-center justify-content-center"
                                                                data-bs-toggle="dropdown" 
                                                                aria-expanded="false"
                                                                style="margin-right: 0">
                                                                <span>+{{ $otherAccuses->count() }}</span>
                                                            </div>
                                                            <div class="dropdown-menu dropdown-menu-end p-2">
                                                                <div class="list-users">
                                                                    @foreach($otherAccuses as $accuse)
                                                                        <div class="content-user d-flex align-items-center mb-2">
                                                                            <div class="avatar me-2">
                                                                                <img src="{{ imageOrDefault(optional($accuse->user->agent)->image) }}" 
                                                                                    alt="{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}"
                                                                                    class="avatar-img" width="24" height="24">
                                                                            </div>
                                                                            <div class="name">
                                                                                <div>{{ optional($accuse->user->agent)->prenom }} {{ optional($accuse->user->agent)->nom }}</div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">Aucun accusé</span>
                                            @endif
                                        </td>
                                        <td>{{ $sortant->date_du_courrier->format('d/m/Y H:i') ?? 'Non defini' }}</td>
                                        <td>{{ $sortant->created_at->format('d/m/Y H:i' ) ?? 'Non defini'}}</td>
                                        <td>
                                            {{ $sortant->updated_at->format('d/m/Y H:i')?? 'Non defini' }}
                                        </td>
                                        <td>
                                                <div @class([
                                                'badge',
                                            'badge-gray' => $sortant->statut_id == 1,
                                            'badge-yellow' => $sortant->statut_id == 2,
                                            'badge-green' => $sortant->statut_id == 3,
                                        ])>
                                           {{ $sortant->statut_id == 3 ? 'Transmis' : ($sortant->statut?->libelle ?? 'Inconnu') }}
                                       </div>
                                        </td>

                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    [$agentId, $dgAgentId] = \App\Helpers\DelegationHelper::getAgentIds();
                                                    $agentIds = array_filter([$agentId, $dgAgentId]);
                                                    
                                                    $isAuthorized = ($sortant->isIntern() && array_intersect($sortant->destinateurs->pluck('id')->toArray(), $agentIds)) ||
                                                        array_intersect($sortant->followers->pluck('id')->toArray(), $agentIds) ||
                                                        in_array($sortant->created_by, $agentIds) ||
                                                        $sortant->partages->whereIn('agent_id', $agentIds)->count() > 0 ||
                                                        $isDG;
                                                        
                                                    // Seul le VRAI DG est restreint sur les nouveaux courriers (statut 1) 
                                                    $isRealDG = Auth::user()->agent && Auth::user()->agent->isDG() && !session('delegation_mode');
                                                    $canShowActions = $isAuthorized && (!$isRealDG || $sortant->statut_id != 1);
                                                @endphp

                                                @if ($canShowActions)
                                                    <a href="{{ route('regidoc.courriers.show', $sortant) }}"
                                                        class="btn">
                                                        <i class="fi fi-rr-eye"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                    @can('delete', $sortant)
                                                        <button wire:click="confirmDeletion({{ $sortant->id }})" class="btn text-danger">
                                                            <i class="fi fi-rr-trash"></i>
                                                            <div class="tooltip-btn">Supprimer</div>
                                                        </button>
                                                    @endcan
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
        @endif

        @if (!$isDG)
            @can('Numériser un document interne')
                <div class="tab-pane fade {{ $active_tab == 4 ? 'show active' : '' }}" id="interne" role="tabpanel"
                    aria-labelledby="interne-tab">
                    <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <h4 class="no-padding no-margin ps-3">Courriers internes</h4>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="col-lg-6">
                                    <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                        style="border:none;" wire:model='search'>
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
                                            <td>{{ optional($interne->author->service)->titre ?? 'N/D' }}</td>
                                            <td>{{ optional($interne->destinateurs->first())->prenom }} {{ optional($interne->destinateurs->first())->nom ?? 'N/D' }}</td>
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
                                                    @php
                                                        [$agentId, $dgAgentId] = \App\Helpers\DelegationHelper::getAgentIds();
                                                        $agentIds = array_filter([$agentId, $dgAgentId]);
                                                        
                                                        $isAuthorized = ($interne->isIntern() && array_intersect($interne->destinateurs->pluck('id')->toArray(), $agentIds)) ||
                                                            array_intersect($interne->followers->pluck('id')->toArray(), $agentIds) ||
                                                            in_array($interne->created_by, $agentIds) ||
                                                            $interne->partages->whereIn('agent_id', $agentIds)->count() > 0 ||
                                                            $isDG;
                                                            
                                                        // Seul le VRAI DG est restreint sur les nouveaux courriers (statut 1) 
                                                        $isRealDG = Auth::user()->agent && Auth::user()->agent->isDG() && !session('delegation_mode');
                                                        $canShowActions = $isAuthorized && (!$isRealDG || $interne->statut_id != 1);
                                                    @endphp

                                                    @if ($canShowActions)
                                                        <a href="{{ route('regidoc.courriers.show', $interne) }}"
                                                            class="btn">
                                                            <i class="fi fi-rr-eye"></i>
                                                            <div class="tooltip-btn">Voir détails</div>
                                                        </a>
                                                        @can('delete', $interne)
                                                            <button wire:click="confirmDeletion({{ $interne->id }})" class="btn text-danger">
                                                                <i class="fi fi-rr-trash"></i>
                                                                <div class="tooltip-btn">Supprimer</div>
                                                            </button>
                                                        @endcan
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
        @else
            <!-- Finalisés Tab (DG) -->
            <div class="tab-pane fade {{ $active_tab == 4 ? 'show active' : '' }}" id="finalise" role="tabpanel"
                aria-labelledby="finalise-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-lg-6 col-md-6">
                            <h4 class="no-padding no-margin ps-3">Courriers finalisés</h4>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="d-flex align-items-center justify-content-lg-end">
                                <input type="text" class="form-control input-search-card" placeholder="Recherche"
                                    style="border:none;" wire:model='search'>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3 align-items-center">
                        <div class="col-12 d-flex align-items-center justify-content-lg-end">
                            <div class="d-flex align-items-center w-100">
                               <div class="input-group block-input-filter flex-nowrap">
                                   <select id="priority" class="form-select form-control" style="min-width: 75px; flex: 1;"
                                       wire:model.debounce.500ms="priority">
                                       <option value="null" selected disabled>Priorité</option>
                                       <option value="">Toutes</option>
                                       <option value=1>Faible</option>
                                       <option value=2>Moyen</option>
                                       <option value=3>Fort</option>
                                       <option value=4>Urgent</option>
                                   </select>
                                   <select name="datep" id="mois" class="form-select form-control" style="min-width: 70px; flex: 1;"
                                       wire:model.debounce.500ms='selectedMonth'>
                                       <option value="null" selected disabled>Mois</option>
                                       @for ($i = 1; $i <= 12; $i++)
                                           <option value="{{ $i }}">{{ now()->month($i)->isoFormat('MMMM') }}
                                           </option>
                                       @endfor
                                   </select>
                                   <select name="datep" id="annee" class="form-select form-control"
                                       style="min-width: 70px; max-width: 90px; border-right: none" wire:model.debounce.500ms='selectedYear'>
                                       <option value="null" selected disabled>Année</option>
                                       @for ($i = ((int) now()->year); $i > 1990; $i--)
                                           <option value="{{ $i }}">{{ $i }}</option>
                                       @endfor
                                   </select>
                                   <button class="btn btn-add refresh-filter btn-search-sm flex-shrink-0" type="button"
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
                                    <th scope="col">Expéditeur</th>
                                    <th scope="col">Priorité</th>
                                    <th scope="col">Date de réception</th>
                                    <th scope="col">Statut</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($finalises as $finalise)
                                    <tr>
                                        <td>{{ $finalise->title }}</td>
                                        <td>{{ $finalise->reference_interne }}</td>
                                        <td>{{ $finalise->externExpediteur->nom ?? 'N/D' }}</td>
                                        <td>
                                            <div @class([
                                                'badge-priority',
                                                'badge-priority-gray' =>
                                                    $finalise->priorite_id != 1 &&
                                                    $finalise->priorite_id != 2 &&
                                                    $finalise->priorite_id != 3 &&
                                                    $finalise->priorite_id != 4,
                                                'normal badge-priority-normal' => $finalise->priorite_id == 1,
                                                'urgent  badge-priority-red' => $finalise->priorite_id == 4,
                                                'absolute badge-priority-yellow' => $finalise->priorite_id == 3,
                                                'important badge-priority-green' => $finalise->priorite_id == 2,
                                            ])>
                                                {{ $finalise->priorite?->titre ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>{{ $finalise->created_at->format('d/m/Y') }}</td>
                                        <td><div class="badge badge-green">Finalisé</div></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    [$agentId, $dgAgentId] = \App\Helpers\DelegationHelper::getAgentIds();
                                                    $agentIds = array_filter([$agentId, $dgAgentId]);
                                                    
                                                    $isAuthorized = ($finalise->isIntern() && array_intersect($finalise->destinateurs->pluck('id')->toArray(), $agentIds)) ||
                                                        array_intersect($finalise->followers->pluck('id')->toArray(), $agentIds) ||
                                                        in_array($finalise->created_by, $agentIds) ||
                                                        $finalise->partages->whereIn('agent_id', $agentIds)->count() > 0 ||
                                                        $isDG;
                                                    
                                                    // Pour les finalisés, pas de restriction de statut 1
                                                    $canShowActions = $isAuthorized;
                                                @endphp
                                                
                                                @if ($canShowActions)
                                                    <a href="{{ route('regidoc.courriers.show', $finalise) }}" class="btn">
                                                        <i class="fi fi-rr-eye"></i>
                                                        <div class="tooltip-btn">Voir détails</div>
                                                    </a>
                                                    @can('delete', $finalise)
                                                        <button wire:click="confirmDeletion({{ $finalise->id }})" class="btn text-danger">
                                                            <i class="fi fi-rr-trash"></i>
                                                            <div class="tooltip-btn">Supprimer</div>
                                                        </button>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center">Aucun courrier finalisé</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if ($finalises instanceof \Illuminate\Pagination\LengthAwarePaginator && $finalises->count() > 0)
                            {{ $finalises->links() }}
                        @endif
                    </div>
                </div>
            </div>
        @endif

            @if($isDG || $isAssistant || $isSecretaire || Auth::user()->can('Restaurer un courrier') || $isSuperAdmin)
            <!-- Corbeille Tab -->
            <div class="tab-pane fade {{ $active_tab == 5 ? 'show active' : '' }}" id="trash" role="tabpanel"
                aria-labelledby="trash-tab">
                <div class="pb-5 card card-table" style="overflow:visible; border-radius: 12px 12px 12px 12px;">
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-lg-6">
                            <h4 class="no-padding no-margin ps-3">Corbeille</h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Titre</th>
                                    <th scope="col">N° d'enregistrement</th>
                                    <th scope="col">Expéditeur</th>
                                    <th scope="col">Destinataire</th>
                                    <th scope="col">Date de réception</th>
                                    <th scope="col">Supprimé le</th>
                                    <th scope="col">Auteur de la suppression</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($trashed as $item)
                                    <tr>
                                        <td>{{ $item->title ?? ($item->objet ?? 'Sans titre') }}</td>
                                        <td>{{ $item->reference_interne }}</td>
                                        <td>
                                            @if ($item->is_intern)
                                                {{ optional($item->expediteur)->prenom }} {{ optional($item->expediteur)->nom }}
                                            @else
                                                {{ $item->externExpediteur->nom ?? 'N/D' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->type_id == 2)
                                                {{ $item->externDestinateur->nom ?? 'N/D' }}
                                            @else
                                                {{ optional($item->destinateurs->first())->prenom }}
                                                {{ optional($item->destinateurs->first())->nom ?? 'N/D' }}
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($item->deletionHistory)
                                                {{ $item->deletionHistory->user->agent ? ($item->deletionHistory->user->agent->prenom . ' ' . $item->deletionHistory->user->agent->nom) : $item->deletionHistory->user->name }}
                                            @else
                                                N/D
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('regidoc.courriers.show', $item) }}" class="btn text-primary" title="Voir détails">
                                                    <i class="fi fi-rr-eye"></i>
                                                </a>
                                                <button wire:click="confirmRestoration({{ $item->id }})" class="btn text-success" title="Restaurer">
                                                    <i class="fi fi-rr-refresh"></i>
                                                </button>
                                                <button wire:click="confirmForceDeletion({{ $item->id }})" class="btn text-danger" title="Supprimer définitivement">
                                                    <i class="fi fi-rr-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center">La corbeille est vide</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex align-items-center justify-content-between gap-4 mt-3 px-3">
                            <div class="ms-auto custom-pagination-shadcn">
                                @if ($trashed instanceof \Illuminate\Pagination\LengthAwarePaginator && $trashed->count() > 0)
                                    {{ $trashed->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
    </div>
</div>


    <script>
        window.addEventListener('show-delete-modal', event => {
            $('#modal-delete-courrier').modal('show');
        });

        window.addEventListener('hide-delete-modal', event => {
            $('#modal-delete-courrier').modal('hide');
        });

        window.addEventListener('show-force-delete-modal', event => {
            $('#modal-force-delete-courrier').modal('show');
        });

        window.addEventListener('hide-force-delete-modal', event => {
            $('#modal-force-delete-courrier').modal('hide');
        });

        window.addEventListener('show-restore-modal', event => {
            $('#modal-restore-courrier').modal('show');
        });

        window.addEventListener('hide-restore-modal', event => {
            $('#modal-restore-courrier').modal('hide');
        });
    </script>

<script>
    function initTooltips() {
        // Détruire les tooltips existants
        var tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipList.forEach(function(tooltipEl) {
            var tooltip = bootstrap.Tooltip.getInstance(tooltipEl);
            if (tooltip) {
                tooltip.dispose();
            }
            // Créer un nouveau tooltip
            new bootstrap.Tooltip(tooltipEl, {
                trigger: 'hover',
                placement: 'top',
                container: 'body'
            });
        });
    }

    document.addEventListener('livewire:load', function() {
        // Initialisation initiale des tooltips
        initTooltips();
        
        // Réinitialiser les tooltips après chaque mise à jour Livewire
        document.addEventListener('livewire:update', function() {
            initTooltips();
        });
        
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
