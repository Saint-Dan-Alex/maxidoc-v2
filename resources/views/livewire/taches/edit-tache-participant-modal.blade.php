@if ($objectif)
    <div class="modal fade modal-sm" id="modal-edit-participants-{{ $objectif->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex sm align-items-center" id="exampleModalLabel">
                        {{ $objectif->agent?->prenom . ' ' . $objectif->agent?->nom . ' - ' . $objectif->agent?->poste?->titre }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form wire:submit.prevent="modifierParticipant">
                        <div class="form-group row g-3">
                            <div class="col-lg-12">
                                <label for="" class="mb-2"  style="color: var(--colorParagraph)">Objectifs assignés: </label>
                                <ul class="list-object">
                                    @foreach ($objectifs as $obj)
                                        <li class="d-flex align-items-baseline">
                                            <i class="fi fi-rr-target me-1" style="flex: 0 0 auto;"></i>
                                            {{ $obj->libelle }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            {{-- <div class="col-lg-12">
                                <label for="">Assigner un nouvel objectif</label>
                                <input type="text" class="form-control" wire:model='libelle' required>
                                @error('libelle')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}
                            {{-- <div class="col-lg-12 text-center">
                                <a href="#" class="btn btn-danger text-end"
                                    wire:click='deleteParticipant({{ $objectif->id }})' data-bs-dismiss="modal"><i
                                        class="fi fi-rr-trash"></i></a>
                            </div> --}}
                            {{-- <div class="col-lg-12 text-end mb-3">
                                <button type="submit" class="btn btn-add mt-3"
                                    data-bs-dismiss="modal">Enregistrer</button>
                            </div> --}}

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
