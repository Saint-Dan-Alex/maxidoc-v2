<div id="createMailPage">
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex align-items-center">
            <a href="{{ route('regidoc.documents.index') }}" class="btn-back"
                style="font-size: 14px; color: var(--colorTitle)">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h4 class="ms-0 ms-2">Archivage du document</h4>
        </div>
        {{--  --}}
        <form id="archive-form" action="{{ route('regidoc.archivages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="body-siderbar">
        <div class="form-group row g-3">

            {{-- =================================================================== --}}
            {{-- DÉBUT DE LA CONDITION PRINCIPALE --}}
            {{-- =================================================================== --}}

          
                {{-- AFFICHAGE POUR LES AUTRES UTILISATEURS : FORMULAIRE COMPLET --}}

                
                <div class="col-12">
                    <div class="row" wire:ignore>
                        <label class="col-5 col-form-label">Type de document</label>
                        <div class="col-7">
                            <select class="form-select form-control select autreSelect2"
                                aria-label="Default select example" name="type" id="type_id" required wire:model='type' onchange="console.log('[UI] Type choisi:', this.value); var v=this.value; if(v==1){$('.type-3-group').addClass('d-none').hide();$('.type-1-group').removeClass('d-none').show();}else if(v==3){$('.type-1-group').addClass('d-none').hide();$('.type-3-group').removeClass('d-none').show();}else{$('.type-1-group,.type-3-group').addClass('d-none').hide();}">
                                <option value="" selected >Selectionnez</option>
                                @foreach ($types as $type)
                                    @if ($type->id != 2)
                                        <option value="{{ $type->id }}">
                                            {{ $type->titre }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @if (!$selectedDoc)
                    <div class="col-12 select_doc" onclick="scanToPdf();" wire:ignore>
                        <div class="block-file block-import-doc">
                            <label for="is_scan">
                                <i class="fi fi-rr-print"></i>
                                <p>Numériser à partir d'un scanner</p>
                                <i class="bi bi-plus-lg"></i>
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="is_scan" id="server_response" wire:ignore />
                    

                    <div class="col-12" wire:ignore>
                        <div class="block-file ">
                            <input type="file" id="file-upload" name="document" accept=".pdf" required>
                            <label for="file-upload" class="d-flex">
                                <svg viewBox="0 0 24 24" width="32" height="32">
                                    <path
                                        d="m23.493,11.017c-.487-.654-1.234-1.03-2.05-1.03h-.443v-1.987c0-2.757-2.243-5-5-5h-5.056c-.154,0-.31-.037-.447-.105l-3.155-1.578c-.414-.207-.878-.316-1.342-.316h-2C1.794,1,0,2.794,0,5v13c0,2.757,2.243,5,5,5h12.558c2.226,0,4.15-1.432,4.802-3.607l1.532-6.116c.234-.782.089-1.605-.398-2.26ZM2,18V5c0-1.103.897-2,2-2h2c.154,0,.31.037.447.105l3.155,1.578c.414-.207.878.316,1.342.316h5.056c1.654,0,3,1.346,3,3v1.987h-10.385c-1.7,0-3.218,1.079-3.789,2.72l-2.19,7.138c-.398-.509-.636-1.15-.636-1.845Zm19.964-5.253l-1.532,6.115c-.384,1.279-1.539,2.138-2.874,2.138H5c-.208,0-.411-.021-.607-.062l2.334-7.609c.279-.803,1.039-1.342,1.889-1.342h12.828c.242,0,.383.14.445.224.062.084.156.259.075.536Z" />
                                </svg>
                                <p class="d-flex align-items-center justify-content-center g-2"> Importer à partir
                                    de l'ordinateur
                                    <span class="mx-1" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="PDF uniquement">
                                        <i class="fi fi-sr-info ms-2" style="font-size: 20px;"></i>
                                    </span>
                                </p>
                                <i class="bi bi-plus-lg"></i>
                            </label>
                        </div>
                    </div>
                     <div class="mb-4 col-12 d-none block-col" wire:ignore>
                        <ul class="list-file">
                            <li class="d-flex align-items-center">
                                <div class="block-remove">
                                    <a href="#" class="btn btn-remove">
                                        <i class="fi fi-rr-trash"></i>
                                    </a>
                                </div>
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
                         <div class="d-flex d-md-none justify-content-end">
                            <a href="#" style="font-size: 12px; font-weight: 500; color: var(--primaryColor)"
                               data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotif"
                               aria-controls="offcanvasRight">Voir le document</a>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="selected_doc" value="{{ $fileName }}" id="" wire:ignore />
                @endif
                
                {{-- <div class="col-12 categorie_field" wire:ignore>
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
                </div> --}}

                {{-- <div class="col-12" wire:ignore>
                    <h5 class="mt-1 title-info">Destination du courrier</h5>
                </div>
                
                <div class="col-12 exped_extern" wire:ignore>
                    <div class="row">
                        <label class="col-5 col-form-label">Expéditeur</label>
                        <div class="col-7" wire:ignore>
                            <select class="form-select form-control sele" aria-label="Default select example"
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

                @can('Mettre en copie')
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">En copie</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control selectCopie"
                                    aria-label="Default select example" name="copie[]" id="copie"
                                    data-placeholder="Selectionner" multiple>
                                    @foreach ($followers as $follower)
                                        <option value="{{ $follower->id }}">
                                            {{ $follower->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endcan --}}

                <div class="col-12">
                    <h5 class="mb-3 title-info">Détails du Document</h5>
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
                        <label class="col-5 col-form-label">Référence document</label>
                        <div class="col-7">
                            <input type="text" class="form-control" name="ref"
                                placeholder="Référence document" wire:model="ref">
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
                
               <div class="col-12">
                    <div class="row">
                        <label class="col-5 col-form-label">Titre</label>
                        <div class="col-7">
                            <textarea name="title" class="form-control" id="title" cols="30" rows="2"
                                placeholder="Titre / objet" required></textarea>
                        </div>
                    </div>
                </div> 

                @php
                    $show_traitement = auth()->user()->can('Definir le traitement');
                @endphp
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
                                    data-related-model="Priorite" @if ($type == [1, 3]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                @endcan
                <!-- Champs supplémentaires -->
                <!-- Groupes d'inputs spécifiques par type -->
                <!-- Type 1: Courrier entrant -->
                <div class="type-1-group d-none" wire:ignore>
                    <div class="col-12 mb-3" >
                        <div class="row">
                            <label class="col-5 col-form-label">Rédacteur</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="redacteur" required
                                    data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                    data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom" data-max-selection="1"
                                    data-related-model="CourrierExpediteur" data-tags="true"  @if ($type == [1]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3" >
                        <div class="row">
                            <label class="col-5 col-form-label">Emetteur</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="expediteur_externe" required
                                    data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                    data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierExpediteur" data-tags="true" @if ($type == [1]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3" >
                        <div class="row">
                            <label class="col-5 col-form-label">Destination</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="destination" required
                                    data-placeholder="Sélectionnez"
                                    data-get-items-route="{{ route('regidoc.ajax.destinatairearchives') }}"
                                    data-route="{{ route('regidoc.ajax.destinatairearchives.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="Destination" data-tags="true" data-max-selection="1" multiple @if ($type == [1]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Type 3: Courrier sortant -->
                <div class="type-3-group d-none" wire:ignore>
                    <div class="col-12 mb-3" >
                        <div class="row">
                            <label class="col-5 col-form-label">Rédacteur 2</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="redacteur" required
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                    data-route=""
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="Agent" data-tags="false" @if ($type == [3]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3" >
                        <div class="row">
                            <label class="col-5 col-form-label">Emetteur 2</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="expediteur_externe" required
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                    data-route=""
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="Agent" data-tags="false" @if ($type == [3]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3" >
                        <div class="row">
                            <label class="col-5 col-form-label">Destination 2</label>
                            <div class="col-7">
                                <select class="form-select form-control select2" name="destination" required
                                    data-get-items-route="{{ route('regidoc.ajax.expediteurcourriers') }}"
                                    data-route="{{ route('regidoc.ajax.expediteurcourriers.save') }}"
                                    data-get-items-field="nom" data-method="get" data-label="nom"
                                    data-related-model="CourrierExpediteur" data-tags="true" @if ($type == [3]) required @endif>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                

              

                <div class="col-12">
                    <div class="row">
                        <label class="col-5 col-form-label">Date du document</label>
                        <div class="col-7">
                            <input type="date" class="form-control" id="inputPassword1" name="date-doc"
                                max="{{ now()->format('Y-m-d') }}" required>
                        </div>
                    </div>
                </div>

                <div class="col-12 datearrive_field" wire:ignore>
                    <div class="row">
                        <label class="col-5 col-form-label">Date d'archivage</label>
                        <div class="col-7">
                            <input type="datetime-local" class="form-control" id="date-arrivee" name="date-arriv"
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

          
            {{-- =================================================================== --}}
            {{-- FIN DE LA CONDITION PRINCIPALE --}}
            {{-- =================================================================== --}}

        </div>
    </div>
    
    <div class="footer-sidebar">
        <a href="{{ route('regidoc.archivages.index') }}" class="btn btn-concel">Annuler</a>
        <button type="submit" id="submit-btn" @disabled(!$isFormValid) class="btn btn-valid">Archiver</button>
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
    function scanToPdf() {
        scanner.scan(displayServerResponse, {
            "can_app_enabled": false,
            "java_applet_enabled": true,
            "output_settings": [{
                "type": "save",
                "format": "pdf",
                "save_path": "{{ str_replace('\\', '/', storage_path() . '/app/public/tmp_scanne/file.pdf') }}"
            }]
        });
    }

    function displayServerResponse(successful, mesg, response) {
        const fileURL = "{{ asset('storage/tmp_scanne/file.pdf') }}";
        const iframe = document.querySelector('.content-scanner iframe');
        $(iframe).attr('src', fileURL + '?t=' + new Date().getTime());
        $('.block-no-file').addClass('d-none');
        $(iframe).removeClass('d-none').addClass('show fade');
        document.getElementById('server_response').value = 'true';
        $('#file-upload').prop('required', false);
    }
</script>

<script>
// Note: La logique d'affichage/masquage est gérée plus bas via toggleTypeGroups
// et l'écouteur délégué sur #type_id (change/select2). Aucune initialisation
// supplémentaire n'est nécessaire ici.
    document.getElementById("file-upload").addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const fileURL = URL.createObjectURL(file);
            document.getElementById("fileDisplay").src = fileURL;
        }
    });

    document.addEventListener('livewire:initialized', () => {
        // (Suppression de la logique robuste toggleTypeGroups)

        // Enregistrer les options Select2 pour réutilisation
        $('.autreSelect2, .select2').each(function() {
            const $el = $(this);
            const getUrl = $el.data('get-items-route');
            const saveUrl = $el.data('route');
            const label = $el.data('get-items-field') || $el.data('label');
            const model = $el.data('related-model');
            const tags = $el.data('tags') === true || $el.data('tags') === 'true';
            const maxSel = $el.data('max-selection') || null;
            const placeholder = $el.data('placeholder') || 'Sélectionnez';

            const config = {
                tags: tags,
                placeholder: placeholder,
                language: 'fr',
                maximumSelectionLength: maxSel,
                width: '100%',
                ajax: getUrl ? {
                    url: getUrl,
                    dataType: 'json',
                    delay: 250,
                    headers: { 'Accept': 'application/json' },
                    data: (params) => ({
                        search: params.term || '',
                        page: params.page || 1,
                        label: label,
                        model: model,
                        relative_id: $el.data('relative-id') || null,
                        method: $el.data('method') || 'get'
                    }),
                    processResults: (data) => {
                        if (data.results) {
                            return { results: data.results, pagination: { more: !!data.pagination?.more } };
                        }
                        if (data.data) {
                            const items = data.data.map(item => ({
                                id: item.id,
                                text: item[label] || item.nom || item.titre
                            }));
                            return {
                                results: items,
                                pagination: { more: data.current_page < data.last_page }
                            };
                        }
                        return { results: [] };
                    }
                } : null
            };

            // Stocker la config pour réutilisation
            $el.data('select2-options', config);

            // Initialiser uniquement si pas déjà fait
            if (!$el.data('select2')) {
                $el.select2(config);
            }

            // Gestion des nouveaux tags
            if (tags && saveUrl) {
                $el.off('select2:select').on('select2:select', function(e) {
                    const data = e.params.data;
                    if (!data.id || isNaN(Number(data.id))) {
                        $.ajax({
                            url: saveUrl,
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: { [label]: data.text, relative_id: $el.data('relative-id') },
                            success: (resp) => {
                                const newId = resp.results?.id || resp.id;
                                if (newId) {
                                    const option = new Option(data.text, newId, true, true);
                                    $el.append(option).trigger('change');
                                }
                            }
                        });
                    }
                });
            }
        });

        // Écouteur simple sur le changement de type - délégation
        $(document).on('change select2:select select2:clear', '#type_id', function(e) {
            const val = $(this).val();
            const text = $(this).find('option:selected').text().trim();
            console.debug('[Type change]', { val, text, event: e.type });
            if (val == 1) {
                $('.type-3-group').addClass('d-none').hide();
                $('.type-1-group').removeClass('d-none').show();
            } else if (val == 3) {
                $('.type-1-group').addClass('d-none').hide();
                $('.type-3-group').removeClass('d-none').show();
            } else {
                // aucune sélection valide => masquer tout
                $('.type-1-group').addClass('d-none').hide();
                $('.type-3-group').addClass('d-none').hide();
            }

            // Appels Livewire après le toggle UI
            @this.set('type', val);
            @this.call('changeNumRef');
        });
        // Indiquer que le handler est attaché
        window.__typeHandlerBound = true;

        // Initialisation au chargement du DOM (sans logique robuste)
        $(function() {
            const initialType = $('#type_id').val();
            // appliquer la même logique simple au chargement
            if (initialType == 1) {
                $('.type-3-group').addClass('d-none').hide();
                $('.type-1-group').removeClass('d-none').show();
            } else if (initialType == 3) {
                $('.type-1-group').addClass('d-none').hide();
                $('.type-3-group').removeClass('d-none').show();
            } else {
                $('.type-1-group, .type-3-group').addClass('d-none').hide();
            }
        });
        // (Suppression du hook Livewire message.processed)
    });

    // Fallback: attacher le même gestionnaire au chargement du DOM si Livewire n'initialise pas
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.__typeHandlerBound) {
            $(document).on('change select2:select select2:clear', '#type_id', function(e) {
                const val = $(this).val();
                const text = $(this).find('option:selected').text().trim();
                console.debug('[Type change - DOMContentLoaded]', { val, text, event: e.type });
                if (window.Livewire) {
                    @this.set('type', val);
                    @this.call('changeNumRef');
                }
                if (val == 1) {
                    $('.type-3-group').addClass('d-none').hide();
                    $('.type-1-group').removeClass('d-none').show();
                } else if (val == 3) {
                    $('.type-1-group').addClass('d-none').hide();
                    $('.type-3-group').removeClass('d-none').show();
                } else {
                    $('.type-1-group, .type-3-group').addClass('d-none').hide();
                }
            });
            window.__typeHandlerBound = true;
        }
        const initialType = $('#type_id').val();
        if (initialType == 1) {
            $('.type-3-group').addClass('d-none').hide();
            $('.type-1-group').removeClass('d-none').show();
        } else if (initialType == 3) {
            $('.type-1-group').addClass('d-none').hide();
            $('.type-3-group').removeClass('d-none').show();
        } else {
            $('.type-1-group, .type-3-group').addClass('d-none').hide();
        }
    });

    // Gestion du bouton de soumission
    document.addEventListener('livewire:initialized', () => {
        $('#submit-btn').on('click', function(e) {
            const form = document.getElementById('archive-form');
            if (!form.checkValidity()) {
                e.preventDefault();
                const invalid = form.querySelector(':invalid');
                if (invalid) invalid.focus();
            } else {
                form.submit();
            }
        });
    });

    // Initialisation des tooltips
    document.addEventListener('DOMContentLoaded', () => {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(tooltipEl => {
            new bootstrap.Tooltip(tooltipEl);
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
