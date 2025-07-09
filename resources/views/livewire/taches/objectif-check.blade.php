<div class="block-scroll" id="tache-commentaires" wire:poll>
    @forelse ($tache->objectifs as $objectif)
        <div class="block-comment commentaires">
            <div class="block-info-comment d-flex">
                <div class="avatar-comment commentaires">
                    <img src="{{ imageOrDefault($objectif->agent->image) }}" alt="Photo profil">
                </div>
                <div class="name-comment commentaires">
                    <h6 class="mb-0">
                        {{ $objectif->agent->prenom . ' ' . $objectif->agent->nom }}
                        <span> - {{ $objectif->agent?->direction?->titre }}</span>
                    </h6>
                    <p>{{ $objectif->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
            <div class="d-flex flex-column mt-2 gap-2">
                <div class="block-dashed-object">
                    <div class="form-check">
                        <input type="checkbox" name="objectif" wire:click='objetcifChangeStatut({{ $objectif->id }})'
                            class="form-check-input check-cible" {{ $objectif->statut == 1 ? 'checked' : '' }}
                            @disabled($objectif->agent_id != Auth::user()->agent->id) id="objectif-{{ $objectif->id }}">
                        <label class="form-check-label ms-2 mb-0 col-12" for="objectif-{{ $objectif->id }}">
                            @if ($objectif->agent_id != Auth::user()->agent->id)
                                @if ($objectif->statut == 1)
                                    <strike>
                                        {!! $objectif->libelle !!}
                                    </strike>
                                @else
                                    {!! $objectif->libelle !!}
                                @endif
                            @else
                                @if ($objectif->statut == 1)
                                    <strike>
                                        {!! $objectif->libelle !!}
                                    </strike>
                                @else
                                    {!! $objectif->libelle !!}
                                @endif
                            @endif
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h2 style="font-size: 13px; color: var(--colorTitre)" class="text-center text-sm text-secondary">Aucun
            commentaire sur cette tâche</h2>
    @endforelse

</div>
