<div class="card card-table px-0">
    <div class="row px-lg-3 px-2 align-items-center g-2">
        <div class="col-lg-7 col-sm-6">
            <h4 class="title-card">Tâches en cours</h4>
        </div>
        <div class="col-lg-5 col-sm-6 d-flex align-items-center justify-content-end">
        
          
        </div>
    </div>
    <hr class="mb-0">
    <div class="d-content-table" style="overflow: hidden">
        <div class="table-responsive">
            <div class="d-none position-absolute loader-card d-flex justify-content-center"
                style="z-index: 2; height:80%; width:95%; background-color:rgba(255,255,255,0.95)" wire:loading
                wire:target="filter" wire:loading.class.remove="d-none">
                <div class="text-center m-auto">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            
            <table class="table table-hover">
                <thead>
                      <tr>
                        <th scope="col">Créée par</th>
                        <th scope="col">Document</th>
                        <th scope="col">Date debut</th>
                        <th scope="col">Date fin</th>
                        <th scope="col">Assigné à</th>
                        <th scope="col">Priorite</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Date création</th>
                        {{-- <th scope="col">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($taches as $tache)
                        <tr>
                            <td>
                                {{ $tache->user->agent->prenom }} {{ $tache->user->agent->nom }}
                            </td>
                            <td>
                                @if (count($tache->documents))
                                    <a href="{{ route('regidoc.documents.show', $tache->documents->first()) }}" class="link-doc-table">
                                        <i class="fi fi-rr-document"></i> {{ $tache->documents->first()->libelle }}
                                    </a>
                                @else
                                    <small>
                                        Pas de document
                                    </small>
                                @endif
                            </td>
                            <td>
                                {{ $tache->date_debut?->format('d/m/Y') ?? 'Non définie' }}
                            </td>
                            <td>
                                {{ $tache->date_fin?->format('d/m/Y') ?? 'Non définie' }}
                            </td>
                            <td class="text-nowrap">
                                <div class="box-avatar d-flex align-items-center">
                                   
                                    @php
                                        $others = collect();
                                    @endphp
                                    @foreach ($tache->objectifs->unique('id') as $objectif)
                                        @if ($loop->index < 4)
                                            <div class="cursor-pointer avatar-team">
                                                <div class="tooltip-team">
                                                    {{ $objectif->agent?->prenom }}
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
                                            <div class="avatar-membre plus d-flex align-items-center justify-content-center"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span>
                                                    4+
                                                </span>
                                            </div>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton2" style="">
                                                <div class="list-users">
                                                    @foreach ($others as $objectif)
                                                        <div class="content-user d-flex align-items-center">
                                                            <div class="avatar" style="flex: 0 0 auto">
                                                                <img src="{{ imageOrDefault($objectif->agent->image) }}"
                                                                    alt="{{ $objectif->agent->prenom }} {{ $objectif->agent->nom }}">
                                                            </div>
                                                            <div class="name">
                                                                {{ $objectif->agent->prenom }} {{ $objectif->agent->nom }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div @class([
                                    'badge',
                                    'badge-red' => $tache->priorite->id == 3,
                                    'badge-success' => $tache->priorite->id == 4,
                                    'badge-yellow' => $tache->priorite->id == 2,
                                    'badge-light' => $tache->priorite->id == 1,
                                ])>
                                    {{ $tache->priorite->titre ?? 'Non définie' }}
                                </div>
                            </td>
                            <td>
                                <div @class([
                                    'badge',
                                    'badge-yellow' => $tache->tache_statut_id == 2,
                                    'badge-gray' => $tache->tache_statut_id == 1,
                                    'badge-green' => $tache->tache_statut_id == 3,
                                    'badge-red' => $tache->tache_statut_id == 4,
                                ])>
                                    {{ $tache->statut->titre ?? 'Non définie' }}
                                </div>
                            </td>
                            <td>
                                {{ $tache->created_at->format('d/m/Y') ?? 'Non définie' }}
                            </td>
                            {{-- <td>
                                @if ($courrier->isIntern() && $courrier->destinateur && $courrier->destinateur->is(Auth::user()->agent))
                                    <a href="#" class="btn btn-default btn-sm">
                                        Traiter
                                    </a>
                                    <a href="#" class="btn btn-default btn-sm">
                                        Classer
                                    </a>
                                    <a href="#" class="btn btn-default btn-sm">
                                        Supprimer
                                    </a>
                                @elseif(in_array(Auth::user()->agent->id, $courrier->followers->pluck('id')->toArray()))
                                    <a href="{{ route('regidoc.courriers.show', $courrier) }}"
                                        class="btn btn-default btn-sm">
                                        <i class="fi fi-rr-eye"></i>
                                        Voir
                                    </a>
                                @endif
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                Aucune tâche disponible
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
