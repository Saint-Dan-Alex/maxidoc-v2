{{-- ajouter --}}
<div class="modal fade" id="modal-new-classeur" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Créer un classeur</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row g-4">
                    <form action="{{ route('regidoc.classeurs.store') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Réference" name="reference"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" placeholder="Denomination" name="titre"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                    rows="5"></textarea>
                            </div>

                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add" type="submit" data-bs-dismiss="modal" aria-label="Close"
                                    wire:click.prevent="storeFonction()">Créer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-new-dossier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Créer un dossier</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row g-4">
                    <form action="{{ route('regidoc.dossiers.store') }}" method="post">
                        @csrf
                        <div>
                            <div class="my-3 col-lg-12">
                                <input type="text" class="form-control" placeholder="Denomination" name="titre">
                            </div>
                        </div>
                        <div>
                            <div class="my-3 col-lg-12">
                                <input type="text" class="form-control" placeholder="Réference" name="reference"
                                    required>
                            </div>
                        </div>
                        <div>
                            <div class="my-3 col-lg-12">
                                {{-- <input type="text" class="form-control" placeholder="description" name="description"> --}}
                                <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                    rows="5"></textarea>
                            </div>
                        </div>
                        <div class="my-3 col-lg-12">
                            <select name="classeur_id" id="" class="form-control" required>
                                <option value="" selected>Selectionnez</option>
                                @forelse ($classeurs as $classeur)
                                    <option value="{{ $classeur->id }}">{{ $classeur->titre }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button type="submit" class="btn btn-add" data-bs-dismiss="modal"
                                aria-label="Close">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-new-document" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div wire:ignore.self class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Numérisez un document</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row g-4">
                    <form action="{{ route('regidoc.documents.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div>
                                <div class="my-3 col-lg-12">
                                    <input type="text" class="form-control" placeholder="Denomination"
                                        name="name">
                                </div>
                            </div>
                            <div>
                                <div class="my-3 col-lg-12">
                                    <input type="text" class="form-control" placeholder="Réference"
                                        name="reference" required>
                                </div>
                            </div>
                            <div class="my-3 col-lg-12">
                                <select name="classeur" id="" class="form-control" required>
                                    <option value="" selected>Selectionnez</option>
                                    @forelse ($classeurs as $classeur)
                                        <option value="{{ $classeur->id }}">{{ $classeur->titre }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div>
                                <div class="my-3 col-lg-12">
                                    <select name="dossier" id="" class="form-control">
                                        <option value="" selected>Selectionnez</option>
                                        @forelse ($dossiers as $dossier)
                                            <option value="{{ $dossier->id }}">{{ $dossier->titre }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="my-3 col-lg-12">
                                    <div class="block-file">
                                        <input type="file" id="file-upload" name="document"
                                            accept="image/*,.pdf, .docx" required>
                                        <label for="file-upload">
                                            <i class="bi bi-folder-fill"></i>
                                            <p>Cliquer pour importer un fichier</p>
                                            <i class="bi bi-plus-lg"></i>
                                        </label>
                                    </div>
                                    <div class="block-file">
                                        <input type="file" id="file-upload" name="document"
                                            accept="image/*,.pdf, .docx" required>
                                        <label for="file-upload">
                                            <i class="bi bi-scanner-fill"></i>
                                            <p>Cliquer pour scanner un fichier</p>
                                            <i class="bi bi-plus-lg"></i>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add" type="submit" data-bs-dismiss="modal"
                                aria-label="Close">Numériser</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
