<form action="{{ route('regidoc.documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="dossier_id" value="{{ $dossier_id }}">
    <div class="body-siderbar">
        <div class="form-group row g-2">
            {{-- <div class="col-12">
                <a href="" style="font-size: 14px; color: var(--colorTitle)">
                    <i class="bi bi-arrow-left"></i>
                    Retour
                </a>
            </div> --}}

            <div class="col-12">
                <div class="block-file block-import-doc">
                    <label onclick="window.print()">
                        <i class="bi bi-printer-fill"></i>
                        <p>Cliquer pour scanner un fichier</p>
                        <i class="bi bi-plus-lg"></i>
                </div>
            </div>
            <div class="col-12">
                <div class="block-file">
                    <input type="file" id="file-upload" name="document" accept="image/*,.pdf, .docx" multiple
                        required>
                    <label for="file-upload">
                        <i class="bi bi-folder-fill"></i>
                        <p>Cliquer pour importer un fichier</p>
                        <i class="bi bi-plus-lg"></i>
                    </label>
                </div>
            </div>
            <div class="mb-4 col-12 d-none block-col">
                <ul class="list-file">
                    <li class="d-flex align-items-center">
                        <i class="bi bi-file-earmark"></i>
                        <div class="block-detail">
                            <div class="names">
                                <p class="name-file">File uploader <span class="size"></span></p>
                                <p class="pourc">
                                    <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <h5 class="mb-0 title-info">Détails du Document</h5>
            </div>
            <div class="col-12">
                <div class="row" wire:ignore>
                    <label class="col-5 col-form-label">Type de document</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example" name="type"
                            id="type_id" required>
                            <option value="" selected disabled>Selectionner</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Référence</label>
                    <div class="col-7">
                        <input type="text" class="form-control" name="ref" required>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Titre</label>
                    <div class="col-7">
                        <input type="text" class="form-control" name="title" required>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Catégorie</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example" name="categorie"
                            required>
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Nature</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example" name="nature"
                            required>
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($natures as $nature)
                                <option value="{{ $nature->id }}">{{ $nature->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Service initiateur</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example" name="service"
                            required>
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($services as $service)
                                <option value="1">{{ $service->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Objet</label>
                    <div class="col-7">
                        <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"></textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="footer-sidebar">
        <a href="#" class="btn">Annuler</a>
        <button class="btn btn-valid">Numériser</button>
    </div>
</form>


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#type_id').on('change', function(e) {
                var data = $(this).val();
                // console.log(data);
                if (data == 2 || data == 3) {
                    $('.exped_extern').addClass('d-none');
                    $('.exped_intern').removeClass('d-none');
                } else {
                    $('.exped_extern').removeClass('d-none');
                    $('.exped_intern').addClass('d-none');
                }
            });
        });
    </script>
@endpush
