{{-- ajouter --}}
<div class="modal fade" id="modal-new-archive-document" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Archiver</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group row g-4">
                    <form action="{{ route('regidoc.documents.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="dossier_id" value="{{ $dossier->id }}">
                        <div class="">
                            <div>
                                <div class="col-lg-12 my-3">
                                    <input type="text" class="form-control" placeholder="Denomination"
                                        name="titre">
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-12 my-3">
                                    <input type="text" class="form-control" placeholder="Réference" name="reference"
                                        required>
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-12 my-3">
                                    <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                        rows="5"></textarea>
                                </div>
                            </div>
                            <div>
                                <div class="col-lg-12 my-3">
                                    {{-- multiple --}}
                                    <input type="file" class="form-control" name="lien_fichier">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add" type="submit" data-bs-dismiss="modal"
                                aria-label="Close">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
