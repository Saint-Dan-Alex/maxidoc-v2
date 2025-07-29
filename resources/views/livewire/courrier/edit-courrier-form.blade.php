<div>
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex align-items-center">
            <a href="{{ route('regidoc.courriers.index') }}" class="btn-back"
                style="font-size: 14px; color: var(--colorTitle)">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="ms-0 ms-2">Modification</h4>
        </div>
        <form action="{{ route('regidoc.courriers.update', $courrier) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="body-siderbar">
                <div class="form-group row g-3">

                    <div class="col-12">
                        <div class="row" wire:ignore>
                            <label class="col-5 col-form-label">Type de courrier</label>
                            <div class="col-7">
                                <select class="form-select form-control select" aria-label="Default select example"
                                    name="type" id="type_id" {{-- data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre"
                                    data-method="get"
                                    data-label="titre"
                                    data-related-model="CourrierType" --}} disabled>
                                    <option value="" selected disabled>Sélectionnez</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}" @selected($courrier->type->id == $type->id)>
                                            {{ $type->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 categorie_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Catégorie</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="categorie" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.naturecourriers') }}"
                                    data-route="{{ route('regidoc.ajax.naturecourriers.save') }}"
                                    data-get-items-field="title" data-method="get" data-label="title"
                                    data-related-model="CourrierCategory" data-tags="true" data-max-selection="1"
                                    multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($courrier->categorie?->id == $category->id)>
                                            {{ $category->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    

                    @if ($courrier->document && !$selectedDoc)
                        {{-- wire:ignore --}}
                        <div class="mb-4 col-12 block-col">
                            {{-- <input type="hidden" name="document_id" id="" value="{{ $selectedDoc ? $selectedDoc->id : $courrier->document->id }}"> --}}
                            <ul class="list-file">
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark"></i>
                                    <div class="block-detail">
                                        <div class="names mb-0">
                                            <p class="name-file">{{ $courrier->document->libelle }} <span
                                                    class="size"></span></p>
                                            <p class="pourc">
                                                <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                            </p>
                                        </div>
                                        <small>Référence : {{ $courrier->document->reference_interne }}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @elseif ($selectedDoc)
                        <div class="mb-4 col-12 block-col">
                            <input type="hidden" name="document_id" id="" value="{{ $selectedDoc?->id }}">
                            <ul class="list-file">
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark"></i>
                                    <div class="block-detail">
                                        <div class="names mb-0">
                                            <p class="name-file">{{ $selectedDoc?->libelle }} <span
                                                    class="size"></span></p>
                                            <p class="pourc">
                                                <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                            </p>
                                        </div>
                                        <small>Référence : {{ $selectedDoc?->reference }}</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endif

                    <div class="col-12 d-none select_doc" wire:ignore>
                        <div class="block-file block-import-doc">
                            <label for="file-select" data-bs-toggle="modal" data-bs-target="#modal-select-document">
                                <i class="bi bi-folder-fill"></i>
                                <p>Cliquez pour sélectionner un document</p>
                                <i class="bi bi-plus-lg"></i>
                            </label>
                        </div>
                    </div>

                    @if ($selectedDoc)
                        <div class="mb-4 col-12 block-co">
                            <input type="hidden" name="document_id" id="" value="{{ $selectedDoc->id }}">
                            <ul class="list-file">
                                <li class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark"></i>
                                    <div class="block-detail">
                                        <div class="names">
                                            <p class="name-file">{{ $selectedDoc->libelle }} <span
                                                    class="size"></span></p>
                                            <p class="pourc">
                                                <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    @endif

                    {{-- <div class="col-12">
                        <h5 class="mt-1 title-info">Destination</h5>
                    </div> --}}

                    {{-- <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataire</label>
                            <div class="col-7">
                                <select class="form-select form-control mb-1" aria-label="Default select example"
                                    name="destination" id="destination"
                                    @if ($isConfidentiel) disabled @endif>
                                    <option value="" @if (!$isConfidentiel) selected @endif disabled>
                                        Selectionnez le destinateur
                                    </option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected($isConfidentiel && $agent->id == $dg->id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($isConfidentiel)
                                    <select class="form-select form-control " aria-label="Default select example"
                                        name="destination2" id="destination2"
                                        @if ($isConfidentiel) disabled @endif>
                                        <option value="" @if (!$isConfidentiel) selected @endif
                                            disabled>
                                            Selectionnez le destinateur</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}" @selected($isConfidentiel && $agent->id == $dga->id)>
                                                {{ $agent->prenom }} {{ $agent->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataire</label>
                            <div class="col-7">
                                <select class="form-select form-control mb-1" aria-label="Default select example"
                                    name="destination" id="destination"
                                    @if ($isConfidentiel) disabled @endif>
                                    <option value="" @if (!$isConfidentiel) selected @endif disabled>
                                        Sélectionnez
                                    </option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected(($isConfidentiel && $dg && $agent->id == $dg->id) || ($dg && $agent->id == $dg->id) || $agent->id == $courrier->dest_interne_id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($isConfidentiel)
                                    <select class="form-select form-control " aria-label="Default select example"
                                        name="destination2" id="destination2"
                                        @if ($isConfidentiel) disabled @endif>
                                        <option value="" @if (!$isConfidentiel) selected @endif
                                            disabled>
                                            Sélectionnez</option>
                                        @foreach ($agents as $agent)
                                            <option value="{{ $agent->id }}" @selected($isConfidentiel && $agent->id == $dga->id)>
                                                {{ $agent->prenom }} {{ $agent->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Copie</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control selectCopie"
                                    aria-label="Default select example" name="copie[]" id="copie"
                                    data-placeholder="Selectionner" multiple>
                                    @foreach ($followers as $follower)
                                        <option value="{{ $follower->id }}" @selected(in_array($follower->id, $courrier->followers->pluck('id')->toArray()))>
                                            {{ $follower->prenom }} {{ $follower->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}

                    <div class="col-12">
                        <h5 class="mb-3 title-info">Détails du Courrier</h5>
                    </div>

                    @if($courrier->type_id == 3) {{-- Courrier interne --}}
                    <div class="col-12 exped_intern">
                        <div class="row">
                            <label class="col-5 col-form-label">Expéditeur Interne</label>
                            <div class="col-7">
                                <select class="form-select form-control text-capitalize"
                                    aria-label="Sélectionner l'expéditeur interne" name="exp_int" required>
                                    <option value="" disabled>Sélectionnez un expéditeur</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected($courrier->exped_interne_id == $agent->id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                            @if($agent->fonctions->isNotEmpty())
                                                ({{ $agent->fonctions->first()->titre }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('exp_int')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @else {{-- Courrier externe --}}
                    <div class="col-12 exped_extern" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Expéditeur</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control sele" aria-label="Default select example"
                                    name="exp" data-placeholder="Sélectionnez un expéditeur"
                                    data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                    data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierExpediteur" data-tags="true" data-max-selection="1"
                                    data-relative-id="{{ $courrier->categorie ? $courrier->categorie->id : '' }}" 
                                    @if ($type == [1]) required @endif>
                                    @if($courrier->exped_externe && $courrier->externExpediteur)
                                        <option value="{{ $courrier->exped_externe }}" selected>
                                            {{ $courrier->externExpediteur->nom }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div
                    </div>
                    @endif

                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="ref" placeholder="Référence"
                                    value="{{ $courrier->reference }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Titre</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title" placeholder="Titre"
                                    value="{{ $courrier->title }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 nature_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Nature</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="nature" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.naturecourriers') }}"
                                    data-route="{{ route('regidoc.ajax.naturecourriers.save') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="CourrierNature" data-tags="true" data-max-selection="1"
                                    multiple>
                                    @foreach ($natures as $nature)
                                        <option value="{{ $nature->id }}" @selected($courrier->nature_id == $nature->id)>
                                            {{ $nature->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-none">
                        <div class="row">
                            <label class="col-5 col-form-label">Traitement à effectuer</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="traitement_id" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="CourrierTypesTraitement">
                                    <option value="" selected disabled>Sélectionnez</option>
                                    @foreach ($traitements as $traitement)
                                        <option value="{{ $traitement->id }}" @selected($courrier->traitement?->id == $traitement->id)>
                                            {{ $traitement->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 priote_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Priorité</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="priorite" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="Priorite">
                                    @foreach ($priorites as $priorite)
                                        <option value="{{ $priorite->id }}" @selected($priorite->id == $courrier->priorite_id)>
                                            {{ $priorite->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Date du courrier</label>
                            <div class="col-7">
                                <input type="date" class="form-control" id="inputPassword1" name="date-doc"
                                    value="{{ $courrier->date_du_courrier?->toDateString() }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 datearrive_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Date d'arrivée</label>
                            <div class="col-7">
                                <input type="date" class="form-control" id="inputPassword1" name="date-arriv"
                                    value="{{ $courrier->date_arrive?->toDateString() }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-none block_echeance" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label" for="check-date">Activer la date d'échéance</label>
                            <div class="col-7" wire:ignore>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" value="0" role="switch"
                                        id="check-date" name="check-date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none date-limite" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Date d'échéance</label>
                            <div class="col-7">
                                <input type="date" class="form-control" id="inputPassword" name="date-limite">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-none block_initiateur" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Service initiateur</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="service_init" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="Service">
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" @selected($courrier->service_id == $service->id)>
                                            {{ $service->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Objet</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    placeholder="Objet">{{ $courrier->objet }}</textarea>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->agent->is(Auth::user()->agent->direction->secretaire->agent))
                        <div class="col-12 d-none block_traitant" wire:ignore>
                            <div class="row">
                                <label class="col-5 col-form-label">Service traitant</label>
                                <div class="col-7" wire:ignore>
                                    <select class="form-select form-control select2"
                                        aria-label="Default select example" name="service_traitant"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                        data-get-items-field="titre" data-method="get" data-label="titre"
                                        data-related-model="Service">
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" @selected($courrier->service_traitant_id == $service->id)>
                                                {{ $service->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="footer-sidebar">
                <a href="{{ route('regidoc.courriers.index') }}" class="btn">Quitter</a>
                <button class="btn btn-valid">Valider</button>
            </div>
        </form>
    </div>
    <div class="content-scanner">
        <div class="container-fluid">
            <iframe
                src="@if ($selectedDoc) {{ files($selectedDoc->document)->link }} @else {{ files($courrier->document?->document)->link }} @endif"
                frameborder="0" class="w-100 @if (!$selectedDoc && !$courrier->document) d-none @endif"></iframe>
            @if (!$selectedDoc && !$courrier->document)
                <div class="block-no-file">
                    <i class="bi bi-file icon"></i>
                    <h4>Pas encore de document importé</h4>
                    <p>Le document numérisé apparaîtra ici.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('livewireScripts')
    {{-- <script>
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

            $('.selectCopie').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {

            setEntrat($('#type_id').val());
            $('#type_id').on('change', function(e) {
                var data = e.target.value;
                // console.log(e.target.value);
                setEntrat(data);
            });

            function setEntrat(data) {
                if (data == 2 || data == 3) {
                    @this.isConfidentiel = false;
                    $('.exped_extern').addClass('d-none');
                    $('.exped_intern').removeClass('d-none');
                    $('.block_traitant').removeClass('d-none');
                    $('.block_initiateur').removeClass('d-none');
                    $('.block_echeance').removeClass('d-none');
                    $('.select_doc').removeClass('d-none');
                    $('#destination2').addClass('d-none');
                    $('.categorie_field').addClass('d-none');
                    $('.priote_field').removeClass('d-none');
                    $('.datearrive_field').removeClass('d-none');
                    $('.nature_field').removeClass('d-none');
                } else {
                    @this.isConfidentiel = true;
                    $('.exped_extern').removeClass('d-none');
                    $('.exped_intern').addClass('d-none');
                    $('.block_traitant').addClass('d-none');
                    $('.block_initiateur').addClass('d-none');
                    $('.block_echeance').addClass('d-none');
                    $('.select_doc').addClass('d-none');
                    $('.categorie_field').removeClass('d-none');
                    $('.priote_field').removeClass('d-none');
                    $('.datearrive_field').removeClass('d-none');
                    $('.nature_field').removeClass('d-none');
                    $('#destination2').removeClass('d-none');
                }

                if (data == 2) {
                    $('.priote_field').addClass('d-none');
                    $('.datearrive_field').addClass('d-none');
                    $('.block_echeance').addClass('d-none');
                    $('.nature_field').addClass('d-none');
                }
            }

            $('.selectCopie').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
            });

            // Écouteur pour le changement de catégorie
            $('select[name="categorie"]').on('change', function(e) {
                $('select[name=exp]').data('relative-id', e.target.value);
                $('select[name=exp]').attr('data-relative-id', e.target.value);
                $('select[name=exp]').val(null).trigger('change');
            });
            
            // Initialisation de la catégorie actuelle
            var initialCategory = $('select[name="categorie"]').val();
            if (initialCategory) {
                $('select[name=exp]').data('relative-id', initialCategory);
                $('select[name=exp]').attr('data-relative-id', initialCategory);
            }
            
            // Initialisation du sélecteur d'expéditeurs avec Select2
            $('select[name="exp"]').select2({
                tags: $('select[name="exp"]').data('tags') ? $('select[name="exp"]').data('tags') : false,
                placeholder: $('select[name="exp"]').data('placeholder'),
                language: "fr",
                createTag: function(params) {
                    var term = $.trim(params.term);

                    if (term === '') {
                        return null;
                    }

                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                },
                ajax: {
                    url: $('select[name="exp"]').data('get-items-route'),
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: $('select[name="exp"]').data('get-items-field'),
                            method: $('select[name="exp"]').data('method'),
                            id: $('select[name="exp"]').data('id'),
                            page: params.page || 1,
                            model: $('select[name="exp"]').data('related-model'),
                            label: $('select[name="exp"]').data('label'),
                            relative_id: $('select[name="exp"]').data('relative-id'),
                        }
                        return query;
                    }
                },
                width: '100%',
                minimumInputLength: 0,
                allowClear: true,
                maximumSelectionLength: $('select[name="exp"]').data('max-selection') ? $('select[name="exp"]').data('max-selection') : null,
                templateResult: formatExp,
                templateSelection: formatExpSelection
            });

            function formatExp(exp) {
                if (!exp.id) {
                    return exp.text;
                }
                return $('<span>').text(exp.text);
            }

            function formatExpSelection(exp) {
                return exp.text;
            }

            // code jl to open scanner device to importe a file

        });
    </script>
@endpush
