<div id="createMailPage">
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex align-items-center">
            <a href="{{ route('regidoc.courriers.index') }}" class="btn-back"
                style="font-size: 14px; color: var(--colorTitle)">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h4 class="ms-0 ms-2">Numérisation du courrier</h4>
        </div>
        {{--  --}}
        <form action="{{ route('regidoc.courriers.complete', $courrier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Champs cachés obligatoires -->
            @if(isset($courrier))
                <input type="hidden" name="courrier_id" value="{{ $courrier->id }}">
            @endif
            <input type="hidden" name="type" value="{{ $type[0] ?? '' }}">
            <input type="hidden" name="categorie" id="categorie_hidden" value="">
            <input type="hidden" name="exp" id="exp_hidden" value="">
            <input type="hidden" name="ref" id="ref_hidden" value="">
            <input type="hidden" name="ref_interne" id="ref_interne_hidden" value="">
            <input type="hidden" name="confidentiel" id="confidentiel_hidden" value="0">
            <input type="hidden" name="title" id="title_hidden" value="">
            <input type="hidden" name="nature" id="nature_hidden" value="">
            <input type="hidden" name="date-doc" id="date-doc_hidden" value="">
            <input type="hidden" name="date-arriv" id="date-arriv_hidden" value="">
            <input type="hidden" name="objet" id="objet_hidden" value="">
            <div class="body-siderbar">
                <div class="form-group row g-3">
                    <div class="col-12">
                        <div class="row" wire:ignore>
                            <label class="col-5 col-form-label">Type de document</label>
                            
                            <div class="col-7">
                                <select class="form-select form-control select autreSelect2"
                                    aria-label="Default select example" name="type" id="type_id" required>
                                    <option value="" selected disabled>Selectionnez</option>
                                    @foreach ($types as $type)
                                        @if ($type->id != 2)
                                            <option value="{{ $type->id }}" @selected($loop->first)>
                                                {{ $type->titre }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    


                    {{-- <div class="col-12 d-none exped_intern" wire:ignore>
                        <input type="hidden" name="exp_int" value="{{ Auth::user()->agent->id }}"> 
                         <div class="row">
                            <label class="col-5 col-form-label">Expéditeur</label>
                            <div class="col-7">
                                <select class="form-select form-control autreSelect2"
                                    aria-label="Default select example" name="exp_int">
                                    <option value="" selected disabled>Selectionnez</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected(Auth::user()->agent->id == $agent->id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div> --}}


                    <div class="col-12 d-none" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataire</label>
                            <div class="col-7">
                                <select class="form-select form-control mb-1 select2"
                                    aria-label="Default select example" name="destination" id="destination"
                                    data-placeholder="Selectionnez" @if ($isConfidentiel) disabled @endif
                                    data-get-items-route="{{ route('regidoc.ajax.destinatairecourriers') }}"
                                    data-route="{{ route('regidoc.ajax.destinatairecourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierDestinateurExterne" data-tags="true"
                                    data-max-selection="1" multiple>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- {{ Auth::user()->agent->direction }} --}}

                    <div class="col-12 d-none" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataire</label>
                            <div class="col-7">
                                <select class="form-select form-control selectCopie"
                                    aria-label="Default select example" name="destination2" id="destination2">
                                    <option value="">Selectionnez</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ $agent->prenom }} {{ $agent->nom }} {{ $agent->post_nom }}
                                            
                                            {{-- Optionnel : Afficher la direction ou le service de l'agent pour plus de clarté --}}
                                            @if ($agent->direction)
                                                ({{ $agent->direction->nom ?? $agent->direction->titre }}) 
                                            @endif
                                            @if ($agent->service)
                                                ({{ $agent->service->nom ?? $agent->service->titre }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-12 exped_extern" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Expéditeur</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control autreSelect2" aria-label="Default select example"
                                    name="exp" data-placeholder="Selectionner"
                                    >
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected($isConfidentiel && $agent->id == $dg->id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($isConfidentiel)
                                    <select class="form-select form-control select2" aria-label="Default select example"
                                        name="exp" data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                        data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                        data-get-items-field="nom" data-method="get" data-label="nom"
                                        data-related-model="CourrierExpediteur" data-tags="true" data-max-selection="1"
                                        multiple>
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-12 " wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataire</label>
                            <div class="col-7">
                                <select class="form-select form-control mb-1 select2" aria-label="Default select example"
                                    name="destination" id="destination"
                                    data-placeholder="Selectionner"
                                    @if ($isConfidentiel) disabled @endif
                                    data-get-items-route="{{ route('regidoc.ajax.destinatairecourriers') }}"
                                    data-route="{{ route('regidoc.ajax.destinatairecourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierDestinateurExterne" data-tags="true" data-max-selection="1"
                                    multiple>
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

                    @can('Mettre en copie')
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">En copie</label>
                                <div class="col-7" wire:ignore>
                                    <select class="form-select form-control selectCopie"
                                        aria-label="Default select example" name="copie[]" id="copie"
                                        data-placeholder="Selectionner" multiple>
                                        {{-- <option value="" selected disabled>Selectionnez</option> --}}
                                        @foreach ($followers as $follower)
                                            <option value="{{ $follower->id }}">
                                                {{ $follower->titre }} {{-- $follower->nom --}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <div class="col-12">
                        <h5 class="mb-3 title-info">Détails du Courrier</h5>
                    </div>

                    <!-- Champ Catégorie -->
                    <div class="col-12 categorie_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Catégorie</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="categorie" data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.naturecourriers') }}"
                                    data-route="{{ route('regidoc.ajax.naturecourriers.save') }}"
                                    data-get-items-field="title" data-method="get" data-label="title"
                                    data-related-model="CourrierCategory" data-tags="true" data-max-selection="1"
                                    multiple @if ($type == [1]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>


                    <!-- Champ Expéditeur -->
                    <div class="col-12 exped_extern" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Expéditeur</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="exp" data-placeholder="Selectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                    data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierExpediteur" data-tags="true" data-max-selection="1"
                                    data-relative-id="null" multiple @if ($type == [1]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Champ Référence -->
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="ref" value="{{$courrier->reference_interne}}"
                                    placeholder="Référence du courrier" required>
                            </div>
                        </div>
                    </div>

                    <!-- Champ Titre/Objet -->
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Titre/Objet</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title" 
                                    placeholder="Titre ou objet du courrier" required>
                            </div>
                        </div>
                    </div>

                    <!-- Champ Nature -->
                    <div class="col-12 nature_field">
                        <div class="row">
                            <label class="col-5 col-form-label">Nature</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="nature" required
                                    data-placeholder="Sélectionnez une nature"
                                    data-get-items-route="{{ route('regidoc.ajax.naturecourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="CourrierNature">
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Champ Date du document -->
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Date du document</label>
                            <div class="col-7">
                                <input type="date" class="form-control" name="date-doc" 
                                    max="{{ now()->format('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 d-none block_initiateur" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Service initiateur</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="service_init" data-placeholder="Selectionnez" wire:model="service_init"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="Service">
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">N° d'enregistrement</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="ref_interne" wire:model='num'
                                    placeholder="N° d'enregistrement" readonly>
                            </div>
                        </div>
                    </div>



                    @can('Definir le traitement')
                        <div class="col-12 d-none">
                            <div class="row">
                                <label class="col-5 col-form-label">Traitement à effectuer</label>
                                <div class="col-7" wire:ignore>
                                    <select class="form-select form-control select2" aria-label="Default select example"
                                        name="traitement_id" data-placeholder="Sélectionnez"
                                        data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                        data-get-items-field="titre" data-method="get" data-label="titre"
                                        data-related-model="CourrierTypesTraitement">
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
                                        data-related-model="Priorite" @if (is_array($type) && (in_array(1, $type) || in_array(3, $type))) required @endif>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endcan



                    <div class="col-12 datearrive_field" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Date de réception</label>
                            <div class="col-7">
                                <input type="datetime-local" class="form-control" id="date-arrivee" name="date_arrive"
                                    value="{{ now()->format('Y-m-d\TH:i') }}" readonly
                                    @if ($type == [1]) required @endif>
                            </div>
                        </div>
                    </div>

                    @can("Définir la date d'échéance")
                        <div class="col-12 d-none block_echeance" wire:ignore>
                            <div class="row">
                                <label class="col-5 col-form-label" for="check-date">Ajouter une échéance</label>
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
                    @endcan

                    @can('Definir le traitement')
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Remarques</label>
                                <div class="col-7">
                                    <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                        placeholder="Remarques"></textarea>
                                </div>
                            </div>
                        </div>
                    @endcan

                    {{-- @if (Auth::user()->agent->isSecretaire())
                        <div class="col-12 d-none block_traitant" wire:ignore>
                            <div class="row">
                                <label class="col-5 col-form-label">Service traitant</label>
                                <div class="col-7" wire:ignore>
                                    <select class="form-select form-control select2"
                                        aria-label="Default select example" name="service_traitant"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.categorycourriers') }}"
                                        data-get-items-field="titre" data-method="get" data-label="titre"
                                        data-related-model="Service">
                                        {{-- <option value="" selected disabled>Selectionnez</option>
                                        @foreach ($departements as $depart)
                                            <option value="1">{{ $depart->libelle }}</option>
                                        @endforeach -}}
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endif --}}

                </div>
            </div>
            <div class="footer-sidebar">
                <a href="{{ route('regidoc.courriers.index') }}" class="btn btn-concel">Annuler</a>
                {{-- <a href="{{ route('regidoc.courriers.store') }}" class="btn btn-valid" @disabled(!$isFormValid)>Numériser</a> --}}
                <button class="btn btn-valid" @disabled(!$isFormValid)>Numériser</button>
            </div>
        </form>
    </div>
    <div class="content-scanner">
        <div class="container-fluid d-none d-lg-block" wire:ignore>
            {{-- @dd(Storage::disk('local')->url('tmp/'.$fileName.'.pdf')) --}}
            <iframe
                src="@if ($selectedDoc) {{ asset('storage/tmp/' . $fileName . '.pdf') }}#toolbar=0 @endif "
                frameborder="0" class="w-100 @if (!$selectedDoc) d-none @endif"></iframe>
            <div class="block-no-file  @if ($selectedDoc) d-none @endif">
                <div class="content-scanner-iconFileBox">
                    <img class="content-scanner-iconFileBox-image"
                        src="{{ asset('assets/images/icons/maxidoc.png') }}" alt="file icon" class="me-2">
                </div>
                {{-- <i class="bi bi-file file"></i>
                <i class="fi fi-rr-file file"></i> --}}
                <h4 class="content-scanner-title">Pas encore de document importé</h4>
                <p class="content-scanner-subtitle">Le document numérisé apparaîtra ici.</p>
            </div>
        </div>
    </div>
    <div id="images"></div>
    <div class="offcanvas offcanvas-end" wire:ignore tabindex="-1" id="offcanvasNotif"
        aria-labelledby="offcanvasRightLabel" aria-hidden="true">
        <div class="offcanvas-header" style="display:flex!important">
            <h5 id="offcanvasRightLabel">Aperçu du document</h5>
            <button type="button" class="btn-close btn-close-notification text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body px-0 align-items-center justify-content-center d-flex flex-column"
            style="overflow-x: hidden">
            <iframe id="fileDisplay" class="w-100 h-100" border="0" src=""></iframe>
        </div>
    </div>
</div>
{{-- @dd(Storage::get('public/tmp/file.pdf')) --}}
@push('livewireScripts')
    <script src="{{ asset('vendor/scannerjs/scanner.js') }}"></script>
    
    <script>
        // Fonction pour mettre à jour les champs cachés
        
        // Écouteur d'événement pour la mise à jour des expéditeurs
        document.addEventListener('expediteursUpdated', event => {
            const expediteurs = event.detail;
            const selectExp = $('select[name="exp"]');
            
            // Sauvegarder la valeur sélectionnée
            const selectedValue = selectExp.val();
            
            // Vider et réinitialiser le select
            selectExp.empty().trigger('change');
            
            // Ajouter l'option par défaut
            selectExp.append(new Option('Sélectionnez un expéditeur', '', true, true));
            
            // Ajouter les expéditeurs filtrés
            if (expediteurs && expediteurs.length > 0) {
                expediteurs.forEach(expediteur => {
                    const option = new Option(expediteur.text, expediteur.id, false, false);
                    selectExp.append(option);
                });
                
                // Restaurer la valeur sélectionnée si elle existe toujours dans la nouvelle liste
                if (selectedValue && expediteurs.some(e => e.id == selectedValue)) {
                    selectExp.val(selectedValue).trigger('change');
                }
            }
            
            // Mettre à jour le plugin Select2
            selectExp.trigger('change');
        });
        
        // Initialisation du sélecteur de catégorie avec gestionnaire d'événement
        function initCategorieSelect() {
            $('select[name="categorie"]').select2({
                placeholder: 'Sélectionnez une catégorie',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: $('select[name="categorie"]').data('get-items-route'),
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            field: $('select[name="categorie"]').data('get-items-field'),
                            model: $('select[name="categorie"]').data('related-model')
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on('change', function(e) {
                const categorieId = $(this).val();
                // Mettre à jour le champ caché
                $('#categorie_hidden').val(categorieId);
                // Émettre l'événement pour charger les expéditeurs
                @this.emit('categorieSelected', categorieId);
            });
        }
        
        // Initialisation du sélecteur d'expéditeur
        function initExpediteurSelect() {
            $('select[name="exp"]').select2({
                placeholder: 'Sélectionnez un expéditeur',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: $('select[name="exp"]').data('get-items-route'),
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        const categorieId = $('select[name="categorie"]').val();
                        // Debug: Afficher la valeur de la catégorie sélectionnée
                        console.log('Catégorie sélectionnée:', categorieId);
                        
                        const data = {
                            q: params.term,
                            field: $('select[name="exp"]').data('get-items-field'),
                            model: $('select[name="exp"]').data('related-model'),
                            category_id: categorieId || '',
                            relative_id: categorieId || ''
                        };
                        
                        // Debug: Afficher les données envoyées
                        console.log('Données envoyées au serveur:', data);
                        
                        return data;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            }).on('change', function(e) {
                // Mettre à jour le champ caché
                $('#exp_hidden').val($(this).val());
            });
        }
        function updateHiddenFields() {
            // Mettre à jour le champ caché de la catégorie
            const categorieSelect = document.querySelector('select[name="categorie"]');
            if (categorieSelect) {
                document.getElementById('categorie_hidden').value = categorieSelect.value;
            }
            
            // Mettre à jour le champ caché de l'expéditeur
            const expediteurSelect = document.querySelector('select[name="exp"]');
            if (expediteurSelect) {
                document.getElementById('exp_hidden').value = expediteurSelect.value;
            }
            
            // Mettre à jour le champ caché de la référence
            const refInput = document.querySelector('input[name="reference_courrier"]');
            if (refInput) {
                document.getElementById('ref_hidden').value = refInput.value;
            }
            
            // Mettre à jour le champ caché de la référence interne
            const refInterneInput = document.querySelector('input[name="reference_interne"]');
            if (refInterneInput) {
                document.getElementById('ref_interne_hidden').value = refInterneInput.value;
            }
            
            // Mettre à jour le champ caché du titre
            const titleInput = document.querySelector('input[name="title"]');
            if (titleInput) {
                document.getElementById('title_hidden').value = titleInput.value;
            }
            
            // Mettre à jour le champ caché de la nature
            const natureSelect = document.querySelector('select[name="nature_id"]');
            if (natureSelect) {
                document.getElementById('nature_hidden').value = natureSelect.value;
            }
            
            // Mettre à jour le champ caché de la date du document
            const dateDocInput = document.querySelector('input[name="date_du_courrier"]');
            if (dateDocInput) {
                document.getElementById('date-doc_hidden').value = dateDocInput.value;
            }
            
            // Mettre à jour le champ caché de la date d'arrivée
            const dateArriveInput = document.querySelector('input[name="date_arrive"]');
            if (dateArriveInput) {
                document.getElementById('date-arriv_hidden').value = dateArriveInput.value;
            }
            
            // Mettre à jour le champ caché de l'objet
            const objetInput = document.querySelector('textarea[name="objet"]');
            if (objetInput) {
                document.getElementById('objet_hidden').value = objetInput.value;
            }
            
            // Mettre à jour le champ caché confidentiel
            const confidentielCheckbox = document.querySelector('input[name="confidentiel"]');
            if (confidentielCheckbox) {
                document.getElementById('confidentiel_hidden').value = confidentielCheckbox.checked ? '1' : '0';
            }
        }
        
        // Écouter les changements sur les champs du formulaire
        document.addEventListener('DOMContentLoaded', function() {
            // Mettre à jour les champs cachés au chargement
            updateHiddenFields();
            
            // Écouter les changements sur les champs du formulaire
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('change', updateHiddenFields);
                form.addEventListener('keyup', updateHiddenFields);
                form.addEventListener('submit', function() {
                    // Dernière mise à jour avant soumission
                    updateHiddenFields();
                    return true;
                });
            }
        });
    </script>

    <script>
        //https://github.com/Asprise/scannerjs.javascript-scanner-access-in-browsers-chrome-ie.scanner.js/blob/master/demo-04-scan-pdf-upload-directly.htm
        function scanToPdf() {
            scanner.scan(displayServerResponse, {
                "can_app_enabled": false,
                "java_applet_enabled": true,
                "output_settings": [{
                    "type": "save",
                    "format": "pdf",
                    "save_path": "{{ str_replace('\\', '/', storage_path() . '\\app\\public\\tmp_scanne\\file.pdf') }}"
                }]
            });
        }

        /** Processes the scan result */
        function displayServerResponse(successful, mesg, response) {
            var myInput = document.getElementById('file-upload');
            var file = "{{ asset('storage') . '/tmp_scanne/file.pdf' }}"
            console.log(file);
            const iframe = document.querySelector('.content-scanner iframe');
            $(iframe).attr('src', "{{ asset('storage') . '/tmp_scanne/file.pdf' }}");
            console.log('Test :' + iframe.src);
            $('block-no-file').addClass('d-none');
            $(iframe).removeClass('d-none')
            $(iframe).addClass('show')
            $(iframe).addClass('fade')
            document.getElementById('server_response').value = 'true';
        }
    </script>
    <script>
        document.getElementById("file-upload").addEventListener("change", function() {
            const file = this.files[0];

            if (file) {
                const fileURL = URL.createObjectURL(file);
                const iframe = document.getElementById("fileDisplay");

                // Affiche le fichier dans l'iframe
                iframe.src = fileURL;
            } else {
                alert("Veuillez sélectionner un fichier valide.");
            }
        });
        $(document).ready(function() {
            // Initialiser les sélecteurs
            initCategorieSelect();
            initExpediteurSelect();
            
            setEntrat($('#type_id').val());

            $('#type_id').on('change', function(e) {
                var data = e.target.value;
                setEntrat(data);
            });

            $('.col-12.d-none div > div > input').attr('required', false);
            $('.col-12.d-none div > div > select').attr('required', false);

            function setEntrat(data) {
                @this.type = data;

                if (data == 2 || data == 3) {

                    $('.isConfidentiel').addClass('d-none')
                    $('#copie').removeClass('d-none')

                    $('.exped_extern').addClass('d-none');
                    $('.exped_intern').removeClass('d-none');
                    $('.block_traitant').removeClass('d-none');
                    $('.block_initiateur').removeClass('d-none');
                    $('.block_echeance').removeClass('d-none');

                    $('.categorie_field').addClass('d-none');
                    $('.priote_field').removeClass('d-none');
                    // $('.datearrive_field').removeClass('d-none');
                    $('.datearrive_field').addClass('d-none');
                    $('.nature_field').removeClass('d-none');

                    $('#destination2').removeClass('d-none');

                    $('.exped_intern select').val("");
                    $('.exped_intern select').attr("disabled", false);

                    $('')
                } else {

                    $('.isConfidentiel').removeClass('d-none')
                    $('#copie').addClass('d-none')

                    $('.exped_extern').removeClass('d-none');
                    $('.exped_intern').addClass('d-none');
                    $('.block_traitant').addClass('d-none');
                    $('.block_initiateur').addClass('d-none');
                    $('.block_echeance').addClass('d-none');
                    $('.dest-interne').addClass('d-none');

                    $('.categorie_field').removeClass('d-none');
                    $('.priote_field').removeClass('d-none');
                    $('.datearrive_field').removeClass('d-none');
                    $('.nature_field').removeClass('d-none');

                    $('#destination2').addClass('d-none');

                    $('#destination').parent().parent().parent().addClass('d-none');

                    $('.exped_intern select').val("");
                    $('.exped_intern select').attr("disabled", false);
                }

                if (data == 2) {
                    $('.priote_field').addClass('d-none');
                    $('.datearrive_field').addClass('d-none');
                    $('.block_echeance').addClass('d-none');
                    $('.nature_field').addClass('d-none');
                    $('.exped_intern select').val("");
                    $('.exped_intern select').attr("disabled", false);

                    $('#destination').parent().parent().parent().removeClass('d-none');
                    $('#destination2').parent().parent().parent().addClass('d-none');
                }

                if (data == 3) {
                    $('.exped_intern select').val("{{ Auth::user()->agent->id }}");
                    $('.exped_intern select').attr("disabled", true);
                    $('#destination2').parent().parent().parent().removeClass('d-none');
                    $('#destination').parent().parent().parent().addClass('d-none');
                }
            }

            $('.selectCopie').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
                width: "100%"
            });

            $('.autreSelect2').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
                width: "100%"
            });

            // $('#file-upload').on('change', function(e) {
            //     let files = e.target.files;
            //     if (files.length > 0) {
            //         $('.select_doc').addClass('d-none');
            //     } else {
            //         $('.select_doc').removeClass('d-none');
            //     }
            // });

            $('select[name="service_init"]').on('change', function(e) {
                @this.changeServiceInit(e.target.value);
            });

            $('select[name="categorie"]').on('change', function(e) {
                $('select[name=exp]').data('relative-id', e.target.value);
                $('select[name=exp]').attr('data-relative-id', e.target.value);
                $('select[name=exp]').trigger('change');
            });

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
                maximumSelectionLength: $('select[name="exp"]').data('max-selection') ? $(
                    'select[name="exp"]').data('max-selection') : null,
            });

            $('select[name="exp"]').on('select2:select', function(e) {
                var data = e.params.data;

                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $('select[name="exp"]').val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',
                        'selected');
                }
            });

            $('select[name="exp"]').on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',
                    false);
            });

            $('select[name="exp"]').on('select2:selecting', function(e) {

                if (!$('select[name="exp"]').data('tags')) {
                    return;
                }
                var $el = $('select[name="exp"]');
                var route = $el.data('route');
                var label = $el.data('label');
                var relativeId = $el.data('relative-id');
                var errorMessage = $el.data('error-message');
                var newTag = e.params.args.data.newTag;

                if (!newTag) return;

                $el.select2('close');

                $.post(route, {
                    [label]: e.params.args.data.text,
                    relative_id: relativeId,
                    _tagging: true,
                }).done(function(data) {
                    console.log(data);
                    var newOption = new Option(e.params.args.data.text, data.results.id,
                        false, true);
                    $el.append(newOption).trigger('change');
                }).fail(function(error) {
                    // toastr.error(errorMessage);
                    console.log(errorMessage);
                });

                return false;
            });


            // select all required fields
            $('input[required], select[required]').on('change', function() {
                var fields = $('input[required], select[required]');
                console.log(fields);

                fields.each(function() {
                    if ($(this).val() == '') {
                        // $(this).addClass('is-invalid');
                        @this.set('isFormValid', false)
                    } else {
                        @this.set('isFormValid', true)
                        // $(this).removeClass('is-invalid');
                    }
                })
            });
        });
    </script>
@endpush



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.forEach(function(tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    })
    console.log("initialisation du toolkit reussi");
</script>


<style>
    .tooltip-inner {
        font-size: 12px;
        /* Taille de police pour le texte du tooltip */
    }

    .content-scanner-iconFileBox {
        width: 80px;
        height: auto;
        position: relative;

        overflow: hidden;
    }

    .content-scanner-iconFileBox-image {
        width: inherit;
        height: auto;
        max-width: 100%;
        height: auto;
        object-fit: contain;
        object-position: center center;
    }

    .content-scanner-title {
        margin-top: 20px;
        font-size: 18px !important;
        margin-bottom: 0px !important;
    }

    .content-scanner-subtitle {

        font-size: 14px !important;
    }
</style>
