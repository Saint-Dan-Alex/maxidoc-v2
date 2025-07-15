<div class="sidebar-doc">
    <div class="header-sidebar">
        <div class="d-flex align-items-center">
            <a href="{{ route('regidoc.courriers.index') }}" class="btn-back">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h4 class="ms-2">Details du fichier</h4>
        </div>
    </div>
    <div class="body-siderbar">
        <div class="d-flex justify-content-between mb-4 align-items-center">

            @php
                $hasSeen = false;
                foreach ($courrier->etapes as $etape) {
                    if ($etape->pivot->view_by == Auth::user()->id) {
                        $hasSeen = true;
                        break;
                    }
                }
            @endphp

            @if ($courrier->isIntern() && $courrier->dest_interne_id == Auth::user()->agent->id)
                <div class="blockBnts d-flex align-items-center" wire:ignore>
                    <div class="dropdown">
                        <button class="block-assign mb-0 btn" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                            aria-expanded="true">
                            Traiter le courrier
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2"
                            data-popper-placement="bottom-end">
                            @can('Assigner une tâche')
                                @if ($courrier->document)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'direction']) }} " >
                                            Assigner une tâche à une direction
                                        </a>
                                    </li>
                                @endif
                            @endcan
                            @can('Assigner une tâche')
                                @if ($courrier->document)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'agent']) }} " >
                                            Assigner une tâche à un agent
                                        </a>
                                    </li>
                                @endif
                            @endcan
                            @can('Suivi des courriers')
                                <li>
                                    <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasHisto" aria-controls="offcanvasRight">
                                        Signer le document
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasComment" aria-controls="offcanvasRight">
                                        Annotations
                                    </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                @if (!$hasSeen && $courrier->author->id != Auth::user()->agent->id)
                    <div class="block-assign mb-0" wire:click="accuserReception">
                        Accuser réception
                    </div>
                @else
                    <div class="blockBnts d-flex align-items-center" wire:ignore>
                        <div class="dropdown">
                            <button class="block-assign mb-0 btn" id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                aria-expanded="true">
                                Traiter le courrier
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2"
                                data-popper-placement="bottom-end">
                                @can('Assigner une tâche')
                                    @if ($courrier->document)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'direction']) }} " >
                                                Assigner une tâche à une direction
                                            </a>
                                        </li>
                                    @endif
                                @endcan
                                @can('Assigner une tâche')
                                    @if ($courrier->document)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'agent']) }} " >
                                                Assigner une tâche à un agent
                                            </a>
                                        </li>
                                    @endif
                                @endcan
                                @can('Suivi des courriers')
                                    <li>
                                        <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasHisto" aria-controls="offcanvasRight">
                                            Signer le document
                                        </a>
                                    </li>
                                @endcan
                                <li>
                                    <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasComment" aria-controls="offcanvasRight">
                                            Annotations
                                        </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            @endif

            @if ($mode != 'edit')
                @if ($hasSeen)
                    @if ($seenBtnTraite && !$courrier->traitements->where('agent_id', Auth::user()->agent->id)->count())
                        @can('Traiter un courrier')
                            <div class="block-assign mb-0" wire:click="traiterCourrier">
                                Traiter le courrier
                            </div>
                        @endcan
                    @else
                        <span class="badge bg-success py-1">Traité</span>
                    @endif
                @else
                    <div></div>
                @endif
            @else
                <div></div>
            @endif

            @if (!Auth::user()->agent->isSecretaire())
                @if (Auth::user()->can('Partager un courrier') ||
                        (Auth::user()->can('Modifier un courrier') && $etape->pivot->view_by == null) ||
                        (Auth::user()->can('Assigner une tâche') && $courrier->document != null) ||
                        Auth::user()->can('Suivi des courriers'))
                    <div class="blockBnts d-flex align-items-center" wire:ignore>
                        <div class="dropdown">
                            <button class="btn btn-light rounded-circle" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="true" style="font-size: 14px;">
                                <i class="fi fi-rr-menu-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1"
                                data-popper-placement="bottom-end">
                                @can('Partager un courrier')
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal-new-task-ass">
                                            Partager ce document
                                        </a>
                                    </li>
                                @endcan
                                @can('Modifier un courrier')
                                    @if ($etape->pivot->view_by == null)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('regidoc.courriers.edit', $courrier) }}">
                                                Modifier
                                            </a>
                                        </li>
                                    @endif
                                @endcan
                                {{-- @can('Assigner une tâche')
                                    @if ($courrier->document)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id]) }} ">
                                                Assigner une tâche
                                            </a>
                                        </li>
                                    @endif
                                @endcan --}}
                                @can('Suivi des courriers')
                                    <li>
                                        <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasHisto" aria-controls="offcanvasRight">
                                            Activités
                                        </a>
                                    </li>
                                @endcan
                                <li>
                                    <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasComment" aria-controls="offcanvasRight">
                                        Annotations
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <div class="m-2 d-none position-absolute d-flex loader-card justify-content-center"
            style="z-index: 2; height:98%; width:98%; background-color: rgba(237, 240, 246, 0.95); left:-3px; top:-1px"
            wire:loading wire:target="traiterCourrier" wire:loading.class.remove="d-none">
            <div class="m-auto text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>

        <form action="" method="POST" wire:submit.prevent='validerTraitement'
            class="@if ($mode != 'edit') d-none @endif">
            <div>
                <div class="form-group row g-3">

                    <div class="col-12">
                        <h5 class="mb-3 title-info">Informations pour traitement</h5>
                    </div>

                    <div class="col-12">
                        <div class="block-file">
                            <input type="file" id="file-import" name="document" accept=".pdf" multiple
                                wire:model='document_files'>
                            <label for="file-import">
                                <i class="fi fi-sr-file"></i>
                                <p>Cliquer pour importer un document scanné</p>
                                <i class="bi bi-plus-lg"></i>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4 col-12 d-none block-col" wire:ignore>
                        <ul class="list-file">

                            <li class="d-flex align-items-center">
                                <div class="block-remove">
                                    <a href="#" class="btn btn-remove autre" id="btn-remove">
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
                    </div>

                    {{-- @if (Auth::user()->agent->isSecretaire()) --}}
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Mettre en copie</label>
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

                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Traitement à effectuer</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="traitement_id" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                    data-get-items-field="titre" data-method="get" data-label="titre"
                                    data-related-model="CourrierTypesTraitement">
                                    <option value="" selected disabled>Selectionnez</option>
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

                    <div class="col-12 block_echeances" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label" for="check-date">Activer la date
                                d'échéance</label>
                            <div class="col-7" wire:ignore>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="check-date"
                                        name="check-date" wire:model="checkEcheance">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 @if (!$checkEcheance) d-none @endif date-limite">
                        <div class="row">
                            <label class="col-5 col-form-label">Date d'échéance</label>
                            <div class="col-7">
                                <input type="date" class="form-control" id="inputPassword" name="date-limite"
                                    wire:model="stat.date_limite" min="{{ now()->format('d-m-Y') }}">
                            </div>
                        </div>
                    </div>
                    {{-- @endif --}}

                    <div class="col-12" wire:ignore>
                        <label class="form-label">Commentaires</label>
                        <textarea name="content" class="form-control body" id="editor" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="footer-sidebar">
                    <a href="#" class="btn" wire:click="annulerTraitement">Annuler</a>
                    <button class="btn btn-valid" type="submit">Valider</button>
                </div>
            </div>
        </form>

        <div class="form-group row g-3 @if ($mode == 'edit') d-none @endif">

            @php
                $courrierViwers = $courrier->etapes
                    ->map(function ($etape) {
                        $agent = \App\Models\User::find($etape->pivot->view_by)?->agent;
                        if ($agent && !$agent->is(Auth::user()->agent)) {
                            return $agent;
                        }
                    })
                    ->reject(function ($agent) {
                        return $agent == null;
                    });
            @endphp
            @if ($courrierViwers->count())
                <div class="col-12">
                    <h5 class="mb-2 title-info">Informations sur la destinations</h5>
                </div>
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Intervenants</label>
                        <div class="col-7">
                            <ul>
                                @foreach ($courrier->etapes as $etape)
                                    @if ($etape->pivot->view_by)
                                        @php
                                            $agentViewed = \App\Models\User::find($etape->pivot->view_by)->agent;
                                        @endphp
                                        {{-- @if ($agentViewed->id != Auth::user()->agent->id) --}}
                                        <li class="items">
                                            {{ Str::ucfirst($agentViewed->prenom ?? '') . ' ' . Str::ucfirst($agentViewed->nom ?? '') }}
                                        </li>
                                        {{-- @endif --}}
                                        {{-- <p class="items">
                                            {{ Str::ucfirst($agentViewed->prenom ?? '') . ' ' . Str::ucfirst($agentViewed->nom ?? '') }}
                                        </p> --}}
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- @if ($courrier->destinateurs->count())
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Intervenants</label>
                        <div class="col-7">
                            @foreach ($courrier->destinateurs->unique() as $destinateur)
                                <p class="items">
                                    {{ Str::ucfirst($destinateur->prenom ?? '') . ' ' . Str::ucfirst($destinateur->nom ?? '') }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif --}}

            @if ($courrier->followers->count())
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">En copie</label>
                        <div class="col-7">
                            @foreach ($courrier->followers->unique() as $follower)
                                <p class="items">
                                    {{ Str::ucfirst($follower->prenom ?? '') . ' ' . Str::ucfirst($follower->nom ?? '') }}
                                </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <h5 class="mb-2 title-info">Informations générales</h5>
            </div>
            @if ($courrier->title)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Titre</label>
                        <div class="col-7">
                            <p class="items">{{ Str::ucfirst($courrier->title ?? '') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->reference_courrier)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Référence</label>
                        <div class="col-7">
                            <p class="items">{{ Str::ucfirst($courrier->reference_courrier ?? '') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->expediteur || $courrier->externExpediteur)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Expéditeur</label>
                        <div class="col-7">
                            <p class="items">
                                @if ($courrier->type_id == 3 || $courrier->type_id == 2)
                                    {{ $courrier->expediteur?->prenom }}
                                    {{ $courrier->expediteur?->nom }}
                                @else
                                    {{ $courrier->externExpediteur?->nom }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->categorie)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Catégorie</label>
                        <div class="col-7">
                            <p class="items">
                                {{ Str::ucfirst($courrier->categorie->title) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->type)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Type de document</label>
                        <div class="col-7">
                            <p class="items">
                                {{ Str::ucfirst($courrier->type->titre ?? '') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->traitement)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Traitement à effectuer</label>
                        <div class="col-7">
                            <p class="items">
                                {{ Str::ucfirst($courrier->traitement->titre ?? '') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->priorite)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Priorité</label>
                        <div class="col-7">
                            <p class="items">
                                {{ Str::ucfirst($courrier->priorite->titre ?? '') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->date_du_courrier)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Date du courrier</label>
                        <div class="col-7">
                            <p class="items">
                                {{ $courrier->date_du_courrier->isoFormat('LL') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->date_arrive)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Date de réception</label>
                        <div class="col-7">
                            <p class="items">
                                {{ $courrier->date_arrive?->isoFormat('LL') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->date_fin)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Date d'échéance</label>
                        <div class="col-7">
                            <p class="items">
                                {{ $courrier->date_fin->isoFormat('LL') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->service)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Service initiateur</label>
                        <div class="col-7">
                            <p class="items">
                                {{ $courrier->service?->titre }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($courrier->objet)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Objet</label>
                        <div class="col-7">
                            <p class="items">
                                {{ $courrier->objet }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- <div class="col-12">
                <div class="row align-items-center">
                    <label for="inputPassword" class="col-5 col-form-label">Date de création</label>
                    <div class="col-7">
                        <p class="items">
                            {{ $courrier->created_at->isoFormat('LL') }}
                        </p>
                    </div>
                </div>
            </div> --}}

            @if ($courrier->author)
                <div class="col-12">
                    <div class="row align-items-center">
                        <label for="inputPassword" class="col-5 col-form-label">Ajouté par</label>
                        <div class="col-7">
                            <p class="items">
                                {{ Str::ucfirst($courrier->author->service->titre ?? '') }}
                                {{-- {{ Str::ucfirst($courrier->author->nom ?? '') }} --}}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
    <div class="footer-sidebar" wire:ignore>
        {{-- <a href="{{ route('regidoc.my.courriers.destroy', $courrier) }}" class="btn">Supprimer</a> --}}
        @can('Classer un courrier')
            <a href="{{ route('regidoc.courriers.classify', $courrier->id) }}" class="btn btn-valid">Classer le
                document</a>
        @endcan
    </div>
</div>

@push('livewireScripts')
    <script src="{{ asset('assets/js/ckbox/ckeditor.js') }}"></script>
    <script>
        // Livewire.on('modeChanged', function() {
        // setEntrat($('#type_id').val());
        $('select[name=priorite]').on('change', function(e) {
            var data = e.target.value;
            // @this.stat['priorite_id'] = data;
            @this.setPriorite(data);
        });

        $('select[name=traitement_id]').on('change', function(e) {
            var data = e.target.value;
            @this.setTraitement(data);
        });

        $('.selectCopie').on('change', function(e) {
            var data = $(this).val();
            @this.setCopie(data);
        });

        function setEntrat(data) {
            if (data == 2 || data == 3) {
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
                // @this.isConfidentiel = true;
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
            maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
            width: '100%'
        });

        ClassicEditor.create(document.getElementById("editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        'undo', 'redo',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript',
                        'superscript',
                        'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        'alignment',
                    ],
                    shouldNotGroupWhenFull: true
                },
                // Changing the language of the interface requires loading the language file using the <script> tag.
                // language: 'es',
                list: {
                    properties: {
                        styles: true,
                        startIndex: true,
                        reversed: true
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/headings.html#configuration
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/editor-placeholder.html#using-the-editor-configuration
                placeholder: '',
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-family-feature
                fontFamily: {
                    options: [
                        'default',
                        'Arial, Helvetica, sans-serif',
                        'Courier New, Courier, monospace',
                        'Georgia, serif',
                        'Lucida Sans Unicode, Lucida Grande, sans-serif',
                        'Tahoma, Geneva, sans-serif',
                        'Times New Roman, Times, serif',
                        'Trebuchet MS, Helvetica, sans-serif',
                        'Verdana, Geneva, sans-serif'
                    ],
                    supportAllValues: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/font.html#configuring-the-font-size-feature
                fontSize: {
                    options: [10, 12, 14, 'default', 18, 20, 22],
                    supportAllValues: true
                },
                // Be careful with the setting below. It instructs CKEditor to accept ALL HTML markup.
                // https://ckeditor.com/docs/ckeditor5/latest/features/general-html-support.html#enabling-all-html-features
                htmlSupport: {
                    allow: [{
                        name: /.*/,
                        attributes: true,
                        classes: true,
                        styles: true
                    }]
                },
                // Be careful with enabling previews
                // https://ckeditor.com/docs/ckeditor5/latest/features/html-embed.html#content-previews
                htmlEmbed: {
                    showPreviews: true
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/link.html#custom-link-attributes-decorators
                link: {
                    decorators: {
                        addTargetToExternalLinks: true,
                        defaultProtocol: 'https://',
                        toggleDownloadable: {
                            mode: 'manual',
                            label: 'Downloadable',
                            attributes: {
                                download: 'file'
                            }
                        }
                    }
                },
                // https://ckeditor.com/docs/ckeditor5/latest/features/mentions.html#configuration
                mention: {
                    feeds: [{
                        marker: '@',
                        feed: [
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy',
                            '@canes',
                            '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake',
                            '@gingerbread',
                            '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum',
                            '@pudding',
                            '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                language: 'fr',

            }).then(editor => {
                window.editor = editor;
                handleStatusChanges(editor);
            })
            .catch(error => {
                console.error(error);
            });

        // Listen to new changes (to enable the "Save" button) and to
        // pending actions (to show the spinner animation when the editor is busy).
        function handleStatusChanges(editor) {
            editor.model.document.on('change:data', () => {
                isDirty = true;
                @this.set('commentaire', editor.getData())
            });
        }
        const fileImport = document.getElementById('file-import');
        const fileName = document.querySelector('.list-file .name-file')

        if (fileImport) {
            fileImport.addEventListener('change', function() {
                const fichier = this.files[0];
                if (fichier) {
                    let namefile = fichier.name;
                    if (namefile.length >= 12) {

                        let splitName = namefile.split('.');

                        namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];

                    }
                    const analyseur = new FileReader();

                    analyseur.readAsDataURL(fichier);
                    analyseur.addEventListener('load', function() {
                        $('.block-no-file').addClass('d-none')
                        $('.block-col').removeClass('d-none')
                        fileName.innerHTML = namefile;
                    })
                }
            })
        }

        $('.block-remove .btn-remove.autre').click(function(e) {
            e.preventDefault()
            $(this).parent().parent().parent().parent().addClass('d-none')
            $('.col-img').addClass('d-none')
            $('#label-5').removeClass('active')
            $(fileImport).val('');

        })
        // });
    </script>
@endpush
