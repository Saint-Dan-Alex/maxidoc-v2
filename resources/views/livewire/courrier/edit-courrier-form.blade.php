<div>
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex align-items-center">
            <a href="{{ route('regidoc.courriers.index') }}" class="btn-back"
                style="font-size: 14px; color: var(--colorTitle)">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h4 class="ms-0 ms-2">Complément d’informations</h4>
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
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="type" id="type_id" data-placeholder="Sélectionnez un type"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre"
                                    data-method="get"
                                    data-label="titre"
                                    data-related-model="CourrierType" disabled>
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
                    <input type="hidden" name="type" value="{{ $courrier->type->id }}">

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
                                    @if($courrier->courrierCategory)
                                        <option value="{{ $courrier->courrierCategory->id }}" selected>
                                            {{ $courrier->courrierCategory->title }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
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
                        </div>
                    </div>
                    <div class="col-12 contact_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Contact</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2-contact" 
                                    name="contact" 
                                    id="contact_id"
                                    data-placeholder="Sélectionnez"
                                    data-expediteur-id="{{ $courrier->exped_externe }}"
                                    data-route="{{ route('regidoc.ajax.expediteur.contact.save') }}"
                                    data-tags="true"
                                    data-allow-clear="true">
                                    @if($courrier->externExpediteur && $courrier->externExpediteur->contact)
                                        <option value="{{ $courrier->externExpediteur->contact }}" selected>
                                            {{ $courrier->externExpediteur->contact }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">N° d'enregistrement </label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="ref2" placeholder="Référence"
                                    value=" {{ $courrier->reference_interne }}" disabled>
                            </div>
                        </div>
                    </div>

                    

                    @if ($courrier->document && !$selectedDoc)
                        {{-- wire:ignore --}}
                        <div class="mb-4 col-12 block-col">
                            {{-- <input type="hidden" name="document_id" id="" value="{{ $selectedDoc ? $selectedDoc->id : $courrier->document->id }}"> --}}
                            <ul class="list-file">
                                <li class="d-flex align-items-center">
                                    <i class="bi-paperclip"></i>
                                    <div class="block-detail">
                                        <div class="names mb-0">
                                            <p class="name-file">{{ $courrier->document->libelle }} <span
                                                    class="size"></span></p>
                                            <p class="pourc">
                                                <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                            </p>
                                        </div>
                                        {{-- <small>Référence : {{ $courrier->document->reference_interne }}</small> --}}
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

                   

                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Référence du courrier</label>
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
                                <input type="text" class="form-control" name="title" placeholder="Titre/objet"
                                    value="{{ $courrier->title }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-12 nature_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Nature</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="nature" data-placeholder="Sélectionnez une nature">
                                    @if($courrier->courrierNature)
                                        <option value="{{ $courrier->courrier_nature_id }}" selected>
                                            {{ $courrier->courrierNature->titre }}
                                        </option>
                                    @endif
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
                                    name="priorite" data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="Priorite">
                                    
                                    <option value="" disabled selected>Sélectionnez</option>
                                
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
                                    value="{{ $courrier->date_du_courrier?->toDateString() }}"
                                    max="{{ now()->toDateString() }}">

                            </div>
                        </div>
                    </div>
                    <div class="col-12 datearrive_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Date de reception</label>
                            <div class="col-7">
                                <input type="datetime-local" class="form-control" id="inputPassword1" name="date-arriv"
                                    value="{{ $courrier->date_arrive ? $courrier->date_arrive->format('Y-m-d\TH:i') : '' }}" disabled>

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
                            <label class="col-5 col-form-label">Remarques</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    placeholder="Remarques">{{ $courrier->objet }}</textarea>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->agent?->isAssistant() || Auth::user()->agent?->isSecretaire())
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
                <button class="btn btn-valid" @disabled(!$isFormValid)>Valider</button>
            </div>
        </form>
    </div>
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
            // Fonction pour vérifier si tous les champs obligatoires sont remplis
            function checkFormValidity() {
                // Liste des sélecteurs des champs obligatoires
                const requiredFields = [
                    // 'select[name="type_id"]',         // Type de courrier
                    'select[name="categorie"]',      // Catégorie
                    'select[name="exp"]',            // Expéditeur
                    // 'input[name="ref_interne"]',     // N° d'enregistrement
                    'input[name="ref"]',             // Référence du courrier
                    'input[name="title"]',           // Titre
                    'select[name="nature"]',         // Nature
                    // 'select[name="priorite"]',       // Priorité
                    'input[name="date-doc"]',        // Date du courrier
                    // 'input[name="date-arriv"]'       // Date de réception
                ];

                let isValid = true;
                
                // Vérifier chaque champ obligatoire
                for (const selector of requiredFields) {
                    const field = $(selector);
                    // Pour les champs de type select2, vérifier si une valeur est sélectionnée
                    if (field.hasClass('select2-hidden-accessible')) {
                        if (!field.val() || field.val().length === 0) {
                            isValid = false;
                            break;
                        }
                    } 
                    // Pour les champs input normaux
                    else if (!field.val() || field.val().trim() === '') {
                        isValid = false;
                        break;
                    }
                }
                
                @this.set('isFormValid', isValid);
                return isValid;
            }

            // Vérifier la validité du formulaire au chargement de la page
            checkFormValidity();

            // Fonction d'initialisation du sélecteur de catégories
            function initCategorySelect() {
                // Récupérer l'ID de la catégorie actuelle si elle existe
                var currentCategoryId = '{{ $courrier->courrier_category_id ?? '' }}';
                var currentCategoryText = '{{ $courrier->courrierCategory->title ?? '' }}';
                
                // Configuration du sélecteur de catégories
                var $categorySelect = $('select[name="categorie"]');
                
                // Détruire l'instance existante si elle existe
                if ($.fn.select2 && $categorySelect.hasClass('select2-hidden-accessible')) {
                    $categorySelect.select2('destroy');
                }
                
                // Initialiser le sélecteur
                $categorySelect.select2({
                    placeholder: 'Sélectionnez une catégorie',
                    maximumSelectionLength: $(this).data('max-selection') || false,
                    language: 'fr',

                    width: '100%',
                    allowClear: true,
                    ajax: {
                        url: '{{ route('api.categories.by-type') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                type_id: $('select[name="type"]').val(),
                                search: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 0
                });
                
                // Si une catégorie est déjà sélectionnée, on la pré-remplit
                if (currentCategoryId) {
                    var option = new Option(currentCategoryText, currentCategoryId, true, true);
                    $categorySelect.append(option).trigger('change');
                }
            }

            // Initialisation des sélecteurs Select2 sauf le sélecteur de catégories
            // $('.select2').not('select[name="categorie"]').each(function() {
            //     $(this).select2({
            //         tags: $(this).data('tags') ? true : false,
            //         placeholder: $(this).data('placeholder'),
            //         language: "fr",
            //         maximumSelectionLength: $(this).data('max-selection') || false,
            //         width: "100%"
            //     });
            // });

            // Initialisation des sélecteurs
            initCategorySelect();
            initNatureSelect();

            // Fonction d'initialisation du sélecteur de natures
            function initNatureSelect() {
                var $natureSelect = $('select[name="nature"]');
                
                // Détruire l'instance existante si elle existe
                if ($.fn.select2 && $natureSelect.hasClass('select2-hidden-accessible')) {
                    $natureSelect.select2('destroy');
                }
                
                // Initialiser le sélecteur de natures
                $natureSelect.select2({
                    placeholder: 'Sélectionnez une nature',
                    language: 'fr',
                    width: '100%',
                    allowClear: true,
                    ajax: {
                        url: '{{ route('api.natures.by-category') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                category_id: $('select[name="categorie"]').val(),
                                search: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 0
                });
                
                // Si une nature est déjà sélectionnée, on la pré-remplit
                @if($courrier->courrierNature)
                    var option = new Option('{{ $courrier->courrierNature->titre }}', '{{ $courrier->courrier_nature_id }}', true, true);
                    $natureSelect.append(option).trigger('change');
                @endif
            }
            
            // Gestionnaire de changement pour le type de document
            $('select[name="type"]').on('change', function() {
                // Mettre à jour la valeur du champ caché
                $('input[name="type"]').val($(this).val());
                
                // Réinitialiser les sélecteurs dépendants
                $('select[name="categorie"]').val(null).trigger('change');
                $('select[name="nature"]').val(null).trigger('change');
                
                // Détruire et réinitialiser les sélecteurs
                $('select[name="categorie"]').select2('destroy');
                $('select[name="nature"]').select2('destroy');
                
                initCategorySelect();
                initNatureSelect();
                
                // Mettre à jour la validité du formulaire
                checkFormValidity();
            });
            
            // Gestionnaire de changement pour la catégorie
            $('select[name="categorie"]').on('change', function() {
                // Mettre à jour le sélecteur de natures
                $('select[name="nature"]').val(null).trigger('change');
                $('select[name="nature"]').select2('destroy');
                initNatureSelect();
                
                // Mettre à jour la validité du formulaire
                checkFormValidity();
            });

            // Liste des sélecteurs des champs obligatoires
            const requiredFields = [
                // 'select[name="type_id"]',
                'select[name="categorie"]',
                'select[name="exp"]',
                // 'input[name="ref_interne"]',
                'input[name="ref"]',
                'input[name="title"]',
                'select[name="nature"]',
                // 'select[name="priorite"]',
                'input[name="date-doc"]',
                // 'input[name="date-arriv"]'
            ];

            // Écouter les changements sur les champs obligatoires
            $(requiredFields.join(',')).on('change keyup', function() {
                checkFormValidity();
            });

            // Pour les champs Select2
            $(document).on('select2:select select2:unselect', 'select.select2', function() {
                checkFormValidity();
            });

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
             // Initialisation du champ de contact
             function initContactField(expediteurId) {
                if (!expediteurId) {
                    $('.contact_field').addClass('d-none');
                    return;
                }
                
                $('.contact_field').removeClass('d-none');
                
                // Détruire l'instance Select2 existante si elle existe
                if ($('.select2-contact').hasClass('select2-hidden-accessible')) {
                    $('.select2-contact').select2('destroy');
                }
                
                // Initialiser le select2 pour le contact
                $('.select2-contact').select2({
                    placeholder: 'Sélectionnez ou ajoutez un contact',
                    allowClear: true,
                    tags: true,
                    language: 'fr',
                    ajax: {
                        url: '{{ route("regidoc.ajax.expediteur.contacts") }}',
                        data: function (params) {
                            return {
                                expediteur_id: expediteurId,
                                search: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: (params.page * 30) < data.total_count
                                }
                            };
                        },
                        cache: true
                    },
                    createTag: function (params) {
                        var term = $.trim(params.term);
                        if (term === '') {
                            return null;
                        }
                        return {
                            id: term,
                            text: term,
                            newTag: true
                        };
                    }
                });
                
                // Mettre à jour l'ID de l'expéditeur dans le data-attribute
                $('.select2-contact').data('expediteur-id', expediteurId);
                $('.select2-contact').attr('data-expediteur-id', expediteurId);
            }
            
            // Écouteur pour le changement d'expéditeur
            $('select[name="exp"]').on('select2:select', function (e) {
                var expediteurId = e.params.data.id;
                initContactField(expediteurId);
                
                // Réinitialiser le champ de contact
                $('.select2-contact').val(null).trigger('change');
                
                // Charger les contacts existants pour cet expéditeur
                if (expediteurId) {
                    $.ajax({
                        url: '{{ route("regidoc.ajax.expediteur.contacts") }}',
                        data: { expediteur_id: expediteurId },
                        dataType: 'json',
                        success: function (data) {
                            if (data.results && data.results.length > 0) {
                                var options = '';
                                $.each(data.results, function(index, contact) {
                                    options += '<option value="' + contact.id + '" selected>' + contact.text + '</option>';
                                });
                                $('.select2-contact').html(options).trigger('change');
                            }
                        }
                    });
                }
            });
            
            // Sauvegarder un nouveau contact
            $('.select2-contact').on('select2:select', function (e) {
                var contact = e.params.data;
                var expediteurId = $(this).data('expediteur-id');
                
                if (contact.newTag && expediteurId) {
                    $.ajax({
                        url: '{{ route("regidoc.ajax.expediteur.contact.save") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            expediteur_id: expediteurId,
                            contact: contact.text
                        },
                        success: function(response) {
                            var newOption = new Option(contact.text, contact.text, true, true);
                            $('.select2-contact').append(newOption).trigger('change');
                        },
                        error: function(xhr) {
                            console.error('Erreur lors de la sauvegarde du contact', xhr);
                        }
                    });
                }
            });
            
            // Initialiser le champ de contact si un expéditeur est déjà sélectionné
            var initialExpediteurId = $('select[name="exp"]').val();
            if (initialExpediteurId) {
                initContactField(initialExpediteurId);
            }
        });
    </script>
@endpush
