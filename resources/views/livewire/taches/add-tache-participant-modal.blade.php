@if ($tache)
    <div class="modal modal-sm fade" id="modal-add-participants-{{ $tache->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex sm align-items-center" id="exampleModalLabel">
                        {{-- <span>{{ $tache->libelle }}</span> --}}
                        Ajoutez un autre participant à cette tâche
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="ajouterParticipant">
                        <div class="form-group row g-4">
                            <input type="hidden" name="tache_id" value="{{ $tache->id }}">
                            <div class="col-lg-12 mt-0">
                                <label for="">Agent</label>
                                <select class="form-select" wire:model="agent_id" aria-label="Default select example"
                                    required>
                                    <option value="" selected>Sélectionnez</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ $agent->prenom . ' ' . $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agent_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-12 mt-3">
                                <label for="">Objectif</label>
                                <input type="text" wire:model="libelle" class="form-control" required>
                                @error('libelle')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-cansel w-50"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-add mt-0 w-50"
                                    data-bs-dismiss="modal">Ajouter</button>
                            </div>
                            {{-- <div class="col-lg-12 text-end">


                                <button type="submit" class="btn btn-add" >Ajouter</button>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
