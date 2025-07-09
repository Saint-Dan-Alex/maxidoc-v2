<div class="tab-pane fade show active" id="tache-{{ $tache->id }}" role="tabpanel" aria-labelledby="home-tab">
    <h6 class="mt-4">
        Progression de la tâche assignée
    </h6>
    <div class="block-progress-bar d-flex align-items-center justify-content-between">
        <div class="content-bar @if($pourcentage < 50) red @elseif($pourcentage >= 50 && $pourcentage < 80 ) orange @else green @endif">
            <div class="bar" style="width: {{ $pourcentage }}%">

            </div>
        </div>
        
        <div class="pourc d-flex">
            <p class="mb-0">{{ number_format($pourcentage, 0) }}%</p>
        </div>
    </div>
    <h6 class="mt-4">
        Objectifs assignés
    </h6>
    <div class="py-3 block-item">
        @foreach ($tache->objectifs as $objectif)
            <div class="form-check">
                <input type="checkbox" name="objectif" wire:click='objetcifChangeStatut({{ $objectif->id }})'
                    class="form-check-input check-cible" {{ $objectif->statut == 1 ? 'checked' : '' }}
                    @disabled($objectif->agent_id != Auth::user()->agent->id)>
                <label class="form-check-label ms-2 col-12" for="flexCheckDefault">
                    @if ($objectif->agent_id != Auth::user()->agent->id)
                        @if ($objectif->statut == 1)
                            <strike>
                                {!! $objectif->libelle !!}
                            </strike>
                        @else
                            {!! $objectif->libelle !!}
                        @endif
                        <span class="text-end"> -
                            {{ $objectif?->agent?->nom . ' ' . $objectif?->agent?->prenom }} |
                        </span>
                    @else
                        {{-- <a href=" {{route('taches.objectif.delete', $objectif->id)}} " class="btn btn-sm ">
                                    <i class="fi fi-rr-pencil"></i>
                                </a> --}}
                        {{-- <a href=" {{ route('taches.objectif.delete', $objectif->id) }} "
                            class="btn btn-sm btn-delete">
                            <i class="fi fi-rr-trash"></i>
                        </a> --}}
                        @if ($objectif->statut == 1)
                            <strike>
                                {!! $objectif->libelle !!}
                            </strike>
                        @else
                            {!! $objectif->libelle !!}
                        @endif
                        <span class="text-end"> -
                            {{ $objectif->agent?->nom . ' ' . $objectif?->agent?->prenom }} |
                        </span>
                        {{-- <a href=" {{route('taches.objectif.delete', $objectif->id)}} " class="btn btn-sm">
                                        <i class="fi fi-rr-pencil"></i>
                                    </a> --}}
                    @endif
                    @if ($objectif->user_id == Auth::id())
                        <a href="#" class="btn btn-sm btn-delete">
                            <i class="fi fi-rr-trash"></i>
                        </a>
                    @endif
                </label>
            </div>
        @endforeach
        </form>

    </div>
</div>
