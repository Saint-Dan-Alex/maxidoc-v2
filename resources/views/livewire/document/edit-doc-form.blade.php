<form action="{{ route('regidoc.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="dossier_id" value="{{ $dossier_id }}">
    <div class="body-siderbar">
        <div class="form-group row g-2">
            <div class="col-12">
                <a href="{{ url()->previous() }}" style="font-size: 14px; color: var(--colorTitle)">
                    <i class="bi bi-arrow-left"></i>
                    Retour
                </a>
            </div>

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
                    <input type="file" id="file-upload" name="document" accept="image/*,.pdf, .docx">
                    <label for="file-upload">
                        <i class="bi bi-folder-fill"></i>
                        <p>Cliquer pour importer un fichier</p>
                        <i class="bi bi-plus-lg"></i>
                    </label>
                </div>
            </div>
            <div class="mb-4 col-12 @if (!$document || !$document?->document) d-none @endif block-col">
                <ul class="list-file">
                    <li class="d-flex align-items-center">
                        <i class="bi bi-file-earmark"></i>
                        <div class="block-detail">
                            <div class="names">
                                <p class="name-file">{{ $document->libelle }} <span class="size"></span></p>
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
                            id="type_id">
                            <option value="" selected disabled>Selectionner</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" @selected($document->type == $type->id)>
                                    {{ $type->titre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Référence</label>
                    <div class="col-7">
                        <input type="text" class="form-control" name="ref" value="{{ $document->reference }}">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Titre</label>
                    <div class="col-7">
                        <input type="text" class="form-control" name="title" value="{{ $document->libelle }}">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Catégorie</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example" name="categorie">
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($document->categorie->id == $category->id)>
                                    {{ $category->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            {{-- <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Nature</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example"
                            name="nature">
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($natures as $nature)
                                <option value="{{ $nature->id }}" @selected($document->nature->id == $nature->id)>
                                    {{ $nature->titre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Service initiateur</label>
                    <div class="col-7">
                        <select class="form-select form-control" aria-label="Default select example" name="service">
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($departements as $depart)
                                <option value="{{ $depart->id }}" @selected($depart->id == Auth::user()->agent->fonction()->departement?->id)>
                                    {{ $depart->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> --}}
            <div class="col-12">
                <div class="row">
                    <label class="col-5 col-form-label">Objet</label>
                    <div class="col-7">
                        <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none">{{ $document->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="footer-sidebar">
        <a href="#" class="btn">Annuler</a>
        <button type="submit" class="btn btn-valid">Enregistrer</button>
    </div>
</form>


@push('scripts')
    <script>
        $(document).ready(function() {
            // $('.select2').select2({
            //     // dropdownParent: $('#modal-new-task'),
            //     width: '100%',
            //     placeholder: $(this).data('placeholder')
            // });

            // $('.tag').select2({
            //     dropdownParent: $('#modal-new-task'),
            //     width: '100%',
            //     placeholder: $(this).data('placeholder'),
            //     tags:true,
            // });
            // var data = [
            //     @foreach ($agents as $agent)
            //         {
            //             id: {{ $agent->id }},
            //             text: '<div class="block-info-formule d-flex py-1 ps-1"><div class="icon avatar"><img src="{{ imageOrDefault($agent->image) }}"/></div> {{ $agent->prenom }} {{ $agent->nom }}</div>',
            //             html: '<div class="block-info-formule d-flex py-1 ps-1"><div class="icon avatar"><img src="{{ imageOrDefault($agent->image) }}"/></div> {{ $agent->prenom }} {{ $agent->nom }}</div>',
            //             title: '{{ $agent->prenom }} {{ $agent->nom }}'
            //         },
            //     @endforeach
            // ];

            // $("#agent_select").select2({
            //     dropdownParent: $('#modal-new-task'),
            //     width: '100%',
            //     placeholder: $(this).data('placeholder'),
            //     data: data,
            //     escapeMarkup: function(markup) {
            //         return markup;
            //     },
            //     templateResult: function(data) {
            //         return data.html;
            //     },
            //     templateSelection: function(data) {
            //         return data.text;
            //     }
            // });

            // $('#destination').on('change', function(e) {
            //     var data = $('#destination').select2("val");
            //     @this.set('agentSelected', data);
            //     $('#copie').select2();
            // });

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
