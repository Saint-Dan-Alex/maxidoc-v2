<div class="row g-2 g-lg-3">
    <!-- Débogage -->
    {{-- <div class="col-12">
        <div class="alert alert-info p-2 mb-2" style="font-size: 0.8rem;">
            <strong>Débogage TacheInfo</strong><br>
            Tâche ID: {{ $tache->id }}<br>
            Nombre d'objectifs: {{ $tache->objectifs ? $tache->objectifs->count() : 0 }}
            @if($tache->objectifs && $tache->objectifs->count() > 0)
                <br>Statut: {{ $tache->objectifs->first()->statut ?? 'N/A' }}
                <br>Créé le: {{ $tache->objectifs->first()->created_at ?? 'N/A' }}
                <br>Mis à jour: {{ $tache->objectifs->first()->updated_at ?? 'N/A' }}
            @endif
        </div>
    </div> --}}
    
    <div class="col-lg-12">
        <div class="items">
            <p class="mb-2 me-0"><i class="fi fi-rr-user me-1"></i> Créée par</p>
            <div class="d-flex w-100 align-items-center">
                <div class="avatar-us-create">
                    <img src="{{ imageOrDefault($tache->user->agent->image) }}"
                        alt="photo de profil {{ $tache->user->agent->prenom . ' ' . $tache->user->agent->nom }}">
                </div>
                <h6 class="mb-0 ms-2">
                    {{ $tache->user->agent->prenom . ' ' . $tache->user->agent->nom }}
                </h6>
            </div>
            {{-- @if($traitementTime)
                <div class="mt-2 w-100">
                    <div class="badge bg-light text-dark" style="font-size: 0.8rem;">
                        <i class="fi fi-rr-time me-1"></i> Traitement: {{ $traitementTime }}
                    </div>
                </div>
            @endif --}}
        </div>
    </div>
    <div class="col-lg-12">
        <div class="items">
            <p class="mb-2 me-0"><i class="fi fi-rr-users me-1"></i> Participants</p>
            <div class="block-all-membres">
                @php
                    $others = collect();
                @endphp
                @foreach ($tache->objectifs->sortByDesc('id')->unique('agent_id') as $objectif)
                    @if ($loop->index < 3)
                        <div class="avatar-membre" data-bs-toggle="modal"
                            data-bs-target="#modal-edit-participants-{{ $objectif->id }}"
                            data-objectif-id="{{ $objectif->id }}"
                            onclick="event.stopPropagation();">
                            <img src="{{ imageOrDefault($objectif->agent?->image) }}" alt="image profil">
                            <div class="tooltip-name">
                                {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}
                            </div>
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
                                3+
                            </span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2"
                            style="">
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
                @if ($tache->pourcentage < 100 && $tache->statut_id != '3')
                    <div class="avatar-membre" data-bs-toggle="modal"
                        data-bs-target="#modal-add-participants-{{ $tache->id }}" 
                        style="cursor: pointer;">
                        <i class="fi fi-rr-plus"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-12">
        <div class="items">
            <p class="mb-3 me-0"><i class="fi fi-rr-calendar-clock me-1"></i> Période </p>
            <h6> {{ $tache->date_fin ? 'Du' . $tache->date_debut?->format('d/m/Y') : $tache->date_debut?->format('d-m-Y') }}
                {{ $tache->date_fin ? 'Au ' . $tache->date_fin?->format('d/m/Y') : '' }}</h6>
        </div>
    </div> --}}
    {{-- <div class="col-lg-12">
        <div class="items">
            <h6>
                Annotations
            </h6>
            <div class="block-scroll-descrip">
                <p style="color: var(--colorTitre)">{!! $tache->description !!}</p>
            </div>
        </div>
    </div> --}}
    
    @include('livewire.taches._modals', ['tache' => $tache])
    
    <style>
        .modal {
            z-index: 1060; /* Assure que la modale s'affiche au-dessus des autres éléments */
        }
    </style>
    
    <script>
        // Gestion de l'ouverture des modales
        document.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const modal = event.target;
            
            // Vérifier si c'est une modale d'édition de participant
            if (modal.id && modal.id.startsWith('modal-edit-participants-')) {
                const objectifId = button.getAttribute('data-objectif-id');
                
                // Émettre l'événement Livewire pour charger les données
                if (window.Livewire) {
                    window.Livewire.emit('editParticipant', objectifId);
                }
            }
        });
        
        // Gestion du rechargement de la page après suppression
        window.addEventListener('reload-page', function(event) {
            const delay = event.detail?.delay || 0;
            setTimeout(() => {
                window.location.reload();
            }, delay);
        });
    </script>
</div>
