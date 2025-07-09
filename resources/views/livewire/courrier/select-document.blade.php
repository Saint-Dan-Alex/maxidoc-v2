<div class="modal fade" id="modal-select-document" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    wire:ignore>
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Selectionez un fichier</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-left: 26px; padding-right: 26px;">
                <div>
                    <div class="block-sroll-body">
                        {{-- <div class="row g-3 g-lg-5">
                            @forelse ($documents as $document)
                                <div class="col-lg-4">
                                    <div class="col-folder">
                                        <input type="radio" name="selectedDoc" wire:model='selectedDoc' value="{{ $document->id }}" class="d-none" id="input-file-in-{{ $document->id }}">
                                        <label for="input-file-in-{{ $document->id }}" class="lable-file-in">
                                            <div class="d-flex align-items-center justify-content-center" style="flex-direction: column">
                                                <img src="{{ fileIcon($document?->document) }}" alt=""
                                                    class="img-file">
                                                <div class="text-center">
                                                    <h6 style="white-space: inherit; overflow:inherit" class="mt-1">{{ Str::ucfirst($document->libelle) }}</h6>
                                                    <p>Reférence : {{ Str::ucfirst($document->reference) }}</p>
                                                    <p>Ajouté le: {{ $document->created_at->format('d/m/Y h:i') }}</p>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center col-12">
                                    <p>Aucun document trouvé</p>
                                </div>
                            @endforelse
                        </div> --}}
                        <div class="all-item-result h-100">

                            <div class="table-responsive h-100" style="scrollbar-width: thin;">
                                <table class="table table-hover">
                                    <thead class="sticky-top">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Créé par</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($documents as $document)
                                            <tr>
                                                <td class="pe-0">
                                                    <div class="form-check p-0">
                                                        <input class="form-check-input ms-0" type="radio" value="" id="flexCheckDefault"
                                                            name="selectedDoc" wire:change='selectedDoc({{ $document->id }})'>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <label for="flexCheckDefault" class="d-flex align-items-center">
                                                            <img src="{{ fileIcon($document?->document) }}" class="me-2" alt=""
                                                            style="flex: 0 0 auto; width: 14px;">
                                                        <span>
                                                            {{ Str::ucfirst($document->libelle) }}
                                                        </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <label for="flexCheckDefault">
                                                        {{ Str::ucfirst($document?->typeDocument?->titre) }}
                                                    </label>
                                                </td>
                                                <td>
                                                    <label for="flexCheckDefault">
                                                        {{ Str::ucfirst($document->author?->nom).' '.Str::ucfirst($document->author?->prenom) }}
                                                    </label>
                                                </td>
                                                </td>
                                                <td>
                                                    <label for="flexCheckDefault">
                                                        {{ $document->created_at->format('d/m/Y h:i') }}
                                                    </label>
                                                </td>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <p>Aucun document trouvé</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 mt-3 block-btn d-flex justify-content-end">
                    {{-- <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Fermer</button> --}}
                    {{-- @if ($this->doc) --}}
                        <button class="btn btn-add" wire:click='selectDoc' data-bs-dismiss="modal" aria-label="Close">Valider</button>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
