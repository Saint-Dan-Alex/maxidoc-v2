<div class="modal fade" id="modal-edit-fonction-{{ $fonction->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Modifier un fonction</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent='save'>
                    <div class="form-group row g-4">
                        <div class="col-lg-12">
                            <label for="">Titre</label>
                            <input type="text" name="titre" class="form-control" wire:model='titre'
                                value="{{ $fonction->titre }}" placeholder="Nom du fonction" required>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Direction</label>
                            <select name="direction_id" class="form-control" wire:model='direction_id' required>
                                <option value="">Selectionnez la direction</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}" @selected($direction_id == $direction->id)>
                                        {{ $direction->titre }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Division</label>
                            <select name="service_id" class="form-control" wire:model='service_id'
                                @disabled($isReadOnly['division'])>
                                <option value="">Selectionnez la division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}" @selected($division_id == $division->id)>
                                        {{ $division->libelle }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Service</label>
                            <select name="service_id" class="form-control" wire:model='service_id'
                                @disabled($isReadOnly['service'])>
                                <option value="">Selectionnez la service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" @selected($service_id == $service->id)>
                                        {{ $service->titre }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12">
                            <label for="">Section</label>
                            <select name="section_id" class="form-control" wire:model='section_id'
                                @disabled($isReadOnly['section'])>
                                <option value="">Selectionnez la section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}" @selected($section_id == $section->id)>
                                        {{ $section->titre }} </option>
                                @endforeach
                            </select>
                        </div>



                    </div>
                    <div class="col-lg-12">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" cols="30" rows="5"> {{ $fonction->description }} </textarea>
                    </div>

                    <div class="col-lg-12 text-end">
                        <button class="btn btn-add" type="submit" data-bs-dismiss="modal">Modifier</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
