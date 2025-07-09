<div class="col-lg-12">
    <div class="card card-table" style="overflow: inherit">
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)" >
            <div class="text-center m-auto">
                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        <div class="row g-3" wire:loading.remove>
            <div class="col-lg-12 d-none d-sm-block col-sm-12">
                {{-- <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ route('regidoc.documents.create') . '?dossier=' . $dossier->id }}" class="btn btn-add"
                        style="flex: 0 0 auto;">
                        Numériser
                    </a>
                </div> --}}
            </div>
            <div class="col-lg-6 col-sm-6 col-xl-8">
                <h4>Liste de nouvelles tâches</h4>
            </div>
            <div class="col-lg-6 col-sm-6 col-xl-4">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'> 
                </div>
            </div>
        </div>
        <hr class="mt-3 mb-0">
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
                                            <div class="cursor-pointer avatar-team"
                                                data-bs-toggle="modal"
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
                                                            <div class="avatar"
                                                                style="flex: 0 0 auto">
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
                                    <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn" >
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
            @if(count($taches))
                {{ $taches->links() }}
            @endif
            
        </div>
    </div>
</div>
