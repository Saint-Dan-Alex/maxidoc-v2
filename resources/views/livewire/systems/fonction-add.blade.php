<div class="modal fade" id="modal-new-fonction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Ajouter une fonction</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent='save'>
                    <div class="form-group row g-4">
                        <div class="col-lg-12">
                            <label for="">Titre</label>
                            <input type="text" name="libelle" wire:model='titre' class="form-control"
                                placeholder="Nom de la fonction" required>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Direction</label>
                            <select name="direction_id" wire:model='direction_id' class="form-control" required>
                                <option value="">Selectionnez la direction</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}">
                                        {{ $direction->titre }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Division</label>
                            <select name="division_id" wire:model='division_id' class="form-control"
                                @disabled($isReadOnly['division'])>
                                <option value="">Selectionnez la division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">
                                        {{ $division->libelle }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Service</label>
                            <select name="service_id" wire:model='service_id' class="form-control"
                                @disabled($isReadOnly['service'])>
                                <option value="">Selectionnez le service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">
                                        {{ $service->titre }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Section</label>
                            <select name="section_id" wire:model='section_id' class="form-control"
                                @disabled($isReadOnly['section'])>
                                <option value="">Selectionnez la section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">
                                        {{ $section->titre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Description</label>
                            <textarea name="description" wire:model='description' class="form-control" cols="30" rows="5"></textarea>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add" type="submit" data-bs-dismiss="modal">Ajouter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
