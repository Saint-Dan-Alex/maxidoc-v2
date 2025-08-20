@if ($objectif)
    <div class="modal modal-sm fade" id="modal-edit-participants-{{ $objectif->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex sm align-items-center" id="exampleModalLabel">
                        {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="modifierParticipant">
                        <div class="form-group row g-4">
                            <div class="col-lg-12 mt-0">
                                <label>Objectifs assignés</label>
                                <div class="list-object mt-2">
                                    @foreach ($objectifs as $obj)
                                        <div class="d-flex align-items-center mb-2 p-2" style="background: #f8f9fa; border-radius: 4px;">
                                            <i class="fi fi-rr-target me-2" style="color: var(--primary);"></i>
                                            <span>{{ $obj->libelle }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 w-100 mt-3">
                                <button type="button" class="btn btn-cansel w-50" data-bs-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-danger w-50" wire:click='deleteParticipant({{ $objectif->id }})' data-bs-dismiss="modal">
                                    <i class="fi fi-rr-trash me-1"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
