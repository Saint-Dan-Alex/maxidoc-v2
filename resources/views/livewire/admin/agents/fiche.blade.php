<div>
    <div class="sidebar sidebar-mobile">
        <div class="content-sidebar d-flex flex-column" style="overflow: hidden">
            <div class="logo normal">
                <a href="{{ route('regidoc.home') }}">
                    <div class="block-logo">
                        <img src="{{ asset('assets/regidoc/logo.png') }}" alt="">
                        <img src="{{ asset('assets/regidoc/icon.png') }}">
                    </div>
                </a>
            </div>
            <div class="logo white d-none">
                <a href="{{ route('regidoc.home') }}">
                    <div class="block-logo">
                        <img src="{{ asset('assets/regidoc/logo-white.png') }}" alt="">
                        <img src="{{ asset('assets/regidoc/icon-white.png') }}">
                    </div>
                </a>
            </div>

            <div class="block-btn">
                <a href="{{ route('regidoc.personnels.create') }}" class="btn-add btn w-100">
                    <i class="fi fi-rr-"></i> Ajouter un employé
                </a>
            </div>

            <div class="block-search">
                <form action="">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fi fi-rr-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Recherche"
                            wire:model.debounce.500ms='search' wire:.ignore.self>
                    </div>
                </form>
                <ul class="nav nav-tabs nav-sm mt-3 nav-tab-users">
                    <li class="nav-item">
                        <button class="nav-link {{ $tab == 1 ? 'active' : '' }} nav-link-agent" data-bs-toggle="tab"
                            data-bs-target="#person-active" type="button" role="tab"
                            wire:click="changeTab(1)">Actifs</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link {{ $tab == 2 ? 'active' : '' }} nav-link-agent" data-bs-toggle="tab"
                            data-bs-target="#person-unactive" type="button" role="tab"
                            wire:click="changeTab(2)">Suspendus</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content flex-grow-1" id="myTabContent" style="overflow-y: auto; scrollbar-width: thin;"
                wire:ignore.self>

                <div class="tab-pane fade {{ $tab == 1 ? 'show active' : '' }} " id="person-active" role="tabpanel"
                    aria-labelledby="home-tab" wire:ignore.self>
                    <div class="block-personnels">
                        <ul class="nav nav-tabs all-person pb-0" id="list-contact" wire:ignore.self>
                            @forelse ($actifAgents ?? [] as $actifAgent)
                                <li class="nav-item">
                                    <button class="nav-link click link-user-tab"
                                        wire:click="showUser({{ $actifAgent->id }})">
                                        <div class="block-detail-person d-flex align-items-center w-100">
                                            <div class="avatar-person">
                                                <img src="{{ imageOrDefault($actifAgent?->image) }}"
                                                    alt="photo profil">
                                            </div>
                                            <div class="name-person">
                                                <h6>{{ $actifAgent?->prenom . ' ' . $actifAgent?->nom }}</h6>
                                                <p>{{ $actifAgent?->poste?->titre }}</p>
                                            </div>
                                            @if (Auth::user()->agent->id == $actifAgent?->id)
                                                <small class="badge bg-info ms-3" style="font-size:8px">Vous</small>
                                            @endif
                                        </div>
                                    </button>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                    {!! $actifAgents->links() !!}
                </div>

                <div class="tab-pane fade {{ $tab == 2 ? 'show active' : '' }}" id="person-unactive" role="tabpanel"
                    aria-labelledby="profile-tab" wire:ignore.self>
                    <div class="block-personnels">
                        <ul class="nav nav-tabs all-person" id="list-contact" wire:ignore.self>
                            @forelse ($inactifAgents ?? [] as $inactifAgent)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link click" wire:click="showUser({{ $inactifAgent->id }})">
                                        <div class="block-detail-person d-flex align-items-center w-100">
                                            <div class="avatar-person">
                                                <img src="{{ imageOrDefault($inactifAgent?->image) }}"
                                                    alt="photo profil">
                                            </div>
                                            <div class="name-person">
                                                <h6>{{ $inactifAgent?->prenom . ' ' . $inactifAgent?->nom }}</h6>
                                                <p>{{ $inactifAgent?->poste?->titre }}</p>
                                            </div>
                                            @if (Auth::user()->agent->id == $inactifAgent?->id)
                                                <small class="badge bg-info ms-3" style="font-size:8px">Vous</small>
                                            @endif
                                        </div>
                                    </button>
                                </li>
                            @empty
                            @endforelse
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid px-lg-2">

        <div class="d-flex   align-items-center mb-lg-3 mb-2">
            <a href="{{ route('regidoc.home') }}" class="back mb-0">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h1 class=" ms-2 mb-0" style="flex: 0 0 auto;">Fiche de l'agent </h1>

            <button class="btn btn-list btn-list-agent d-flex d-lg-none">Liste des agents</button>
        </div>

        <div class="tab-content" id="myTabContent" wire:ignore.self>

            <div class="tab-pane fade show active" id="block-details-person" role="tabpanel" aria-labelledby="home-tab"
                wire:ignore.self>
                <div class="row g-lg-2 g-2">
                    <div class="m-2 d-none position-absolute loader-card d-flex justify-content-center"
                        style="z-index: 2; height:98%; width:100%; background-color: rgba(244,245,252,0.99)"
                        wire:loading wire:target="showUser,archiveAgent" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border" role="status" style="color: var(--primaryColor)">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    {{-- @if ($agent == null) --}}
                    <div class="col-12 @if ($agent != null) d-none @endif">
                        <div class="card card-table justify-content-center align-items-center"
                            style="height: calc(100vh - 200px); background: transparent;box-shadow: none;">
                            {{-- <img src="{{ asset('assets/img/icons/icon-employes.png') }}" alt=""
                                class="img-icon"> --}}

                            <img src="{{ asset('assets/regidoc/default.png') }}" alt=""
                                class="img-icon  img-personnal-details-none">




                            {{-- <span class="svg-personnal-details-none-box">

                                <svg class="svg-personnal-details-none" xmlns="http://www.w3.org/2000/svg"
                                    width="1em" height="1em" viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M28.523 23.813c-.518-.51-6.795-2.938-7.934-3.396c-1.133-.45-1.585-1.697-1.585-1.697s-.51.282-.51-.51c0-.793.51.51 1.02-2.548c0 0 1.415-.397 1.134-3.68h-.34s.85-3.51 0-4.698c-.853-1.188-1.187-1.98-3.06-2.548c-1.87-.567-1.19-.454-2.548-.396c-1.36.057-2.492.793-2.492 1.188c0 0-.85.057-1.188.397c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.624l-.337.11c-.283 3.284 1.132 3.682 1.132 3.682c.51 3.058 1.02 1.755 1.02 2.548c0 .792-.51.51-.51.51s-.453 1.246-1.585 1.697c-1.132.453-7.416 2.887-7.927 3.396c-.51.52-.453 2.896-.453 2.896h26.954s.063-2.378-.453-2.897zm-6.335 2.25h-4.562v-1.25h4.562z" />
                                </svg>

                            </span> --}}

                            <p class="mb-0 mt-3" style="font-size: 12px;">Cliquez sur le nom d'un agent pour voir les
                                détails
                            </p>
                        </div>
                    </div>
                    {{-- @else --}}
                    {{-- <div class="col-lg-12 @if ($agent == null) d-none @endif">
                        <div class="card card-table card-profil card-profil-sm h-100 card-profil-agent">

                        </div>
                    </div> --}}

                    <div class="col-lg-12 @if ($agent == null) d-none @endif">
                        <div class="d-flex" wire:ignore>
                            <ul class="nav-user nav nav-tabs mt-3 mb-0 " role="tablist" wire:ignore>
                                <li class="nav-item" role="presentation">

                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#edit-profil" type="button" role="tab" wire:ignore
                                        aria-controls="edit-profil" aria-selected="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                            viewBox="0 0 24 24" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Modifier le profil" style="outline: none; box-shadow: none;"
                                            id="tooltip-svg">
                                            <path fill="currentColor"
                                                d="M3.34 17a10 10 0 0 1-.979-2.326a3 3 0 0 0 .003-5.347a10 10 0 0 1 2.5-4.337a3 3 0 0 0 4.632-2.674a10 10 0 0 1 5.007.003a3 3 0 0 0 4.632 2.671a10.06 10.06 0 0 1 2.503 4.336a3 3 0 0 0-.002 5.347a10 10 0 0 1-2.501 4.337a3 3 0 0 0-4.632 2.674a10 10 0 0 1-5.007-.002a3 3 0 0 0-4.631-2.672A10 10 0 0 1 3.339 17m5.66.196a5 5 0 0 1 2.25 2.77q.75.07 1.499.002a5 5 0 0 1 2.25-2.772a5 5 0 0 1 3.526-.564q.435-.614.748-1.298A5 5 0 0 1 18 12c0-1.26.47-2.437 1.273-3.334a8 8 0 0 0-.75-1.298A5 5 0 0 1 15 6.804a5 5 0 0 1-2.25-2.77q-.75-.071-1.5-.001A5 5 0 0 1 9 6.804a5 5 0 0 1-3.526.564q-.436.614-.747 1.298A5 5 0 0 1 6 12c0 1.26-.471 2.437-1.273 3.334a8 8 0 0 0 .75 1.298A5 5 0 0 1 9 17.196M12 15a3 3 0 1 1 0-6a3 3 0 0 1 0 6m0-2a1 1 0 1 0 0-2a1 1 0 0 0 0 2" />
                                        </svg>
                                    </button>

                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="agent-tab" data-bs-toggle="tab"
                                        data-bs-target="#fiche-agent" type="button" role="tab" wire:ignore
                                        aria-controls="fiche-agent" aria-selected="false">Fiche agent</button>
                                </li>

                                {{-- <li class="nav-item " role="presentation">
                                    <button class="nav-link " id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#departement" type="button" role="tab" wire:ignore
                                        aria-controls="departement" aria-selected="false">Detail personnel</button>
                                </li> --}}

                                <li class="nav-item " role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#activite" type="button" role="tab" wire:ignore
                                        aria-controls="activite" aria-selected="false">Activités</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="authentication-tab" data-bs-toggle="tab"
                                        data-bs-target="#authentication" type="button" role="tab"
                                        aria-controls="authentication" wire:ignore
                                        aria-selected="false">Authentification</button>
                                </li>
                            </ul>

                        </div>

                        <div class="card card-table card-profil" wire:ignore.self>
                            <div class="tab-content" id="myTabContent" wire:ignore.self>
                                <div class="tab-pane fade" id="edit-profil" wire:ignore.self role="tabpanel"
                                    aria-labelledby="edit-profil-tab">
                                    <div class="info-lg">
                                        <h2>Modification des informations personnelles de l'agent</h2>
                                        <form wire:submit.prevent="updateAgent" enctype="multipart/form-data">
                                            <div class="form-group row g-3 ">
                                                <div class="col-lg-2">
                                                    <div class="avatar-img avatar-user-modal">
                                                        @if ($photo)
                                                            <img src="{{ $photo->temporaryUrl() }}"
                                                                alt="photo de profil" id="">
                                                        @else
                                                            <img src="{{ imageOrDefault($agent?->image) }}"
                                                                alt="photo de profil" id="">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-10 mb-3" wire:ignore>
                                                    <div class="block-up-img" wire:ignore>
                                                        <label for="file-img-profil" class="dashed" id="label-2"
                                                            wire:ignore>
                                                            <svg viewBox="0 0 801.19 537.98">
                                                                <g id="Calque_2" data-name="Calque 2">
                                                                    <g id="Calque_1-2" data-name="Calque 1">
                                                                        <path
                                                                            d="M754.28,264.59A159.67,159.67,0,0,0,648.9,217.87c.58-.77,1.13-1.55,1.68-2.34A76.4,76.4,0,0,0,531.91,120,195.87,195.87,0,0,0,351.32,0C256.06,0,176.7,68,159.12,158.11,68.79,173.41,0,252,0,346.7,0,452.34,85.64,538,191.28,538c1.43,0,2.85,0,4.27-.05s2.82.05,4.24.05H642.14A161.47,161.47,0,0,0,796.75,415.41c.12-.47.23-.94.34-1.41a160.45,160.45,0,0,0-42.81-149.41ZM499.56,296.45c-5.09,11.64-15.11,15.75-27.19,15.78-13.62,0-27.23.24-40.84-.06-6.1-.14-8.07,2.22-8,8.13.27,16.07.1,32.13.1,51.47-.93,15.74,1.62,34.84-1.34,53.79-3.89,25-25.87,43.75-50.7,43.4a51.73,51.73,0,0,1-50.17-43.18c-1.85-10.85-1.11-21.72-1.19-32.58-.16-23.69-.35-47.38.12-71.06.16-8-2.58-10.36-10.31-10-12.77.54-25.58.22-38.37.11-11.93-.1-22.14-3.65-27.34-15.48-5.4-12.28-.77-22.17,8-30.91q49.93-49.95,100-99.87c12.27-12.17,26.86-12.3,39-.23q50.48,50,100.53,100.44C500.41,274.72,504.71,284.65,499.56,296.45Z">
                                                                        </path>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                            <p>
                                                                Cliquez pour télécharger une photo de profil
                                                            </p>
                                                            <div x-data="{ isUploading: false, progress: 0 }"
                                                                x-on:livewire-upload-start="isUploading = true"
                                                                x-on:livewire-upload-finish="isUploading = false"
                                                                x-on:livewire-upload-error="isUploading = false"
                                                                x-on:livewire-upload-progress="progress = $event.detail.progress">

                                                                <!-- File Input -->

                                                                <input type="file" wire:model="photo"
                                                                    id="file-img-profil" accept=".jpg,.png">

                                                                <!-- Progress Bar -->

                                                                <div x-show="isUploading">
                                                                    {{-- <progress max="100" x-bind:value="progress"></progress> --}}
                                                                    <div class="progress mt-2" role="progressbar"
                                                                        aria-label="Example with label"
                                                                        aria-valuenow="0" aria-valuemin="0"
                                                                        aria-valuemax="100"
                                                                        style="width: 300px !important; height: 7px">
                                                                        <div class="progress-bar bg-success"
                                                                            :style="'width: ' + progress +
                                                                                '%; font-size: 8px !important;'"
                                                                            x-text="progress + '%'"></div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </label>
                                                    </div>
                                                    @error('photo')
                                                        <small class="error text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6" wire:ignore.self>
                                                    <label>
                                                        Nom
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Inserez le nom" name="nom"
                                                        value="{{ $agent?->nom }}" required
                                                        wire:model='form_stat.nom'>
                                                </div>
                                                <div class="col-lg-6" wire:ignore.self>
                                                    <label>
                                                        Post-nom
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Inserez le post-nom" name="post_nom"
                                                        value="{{ $agent?->post_nom }}" required
                                                        wire:model='form_stat.post_nom'>
                                                </div>
                                                <div class="col-lg-6" wire:ignore.self>
                                                    <label>
                                                        Prénom
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        placeholder="Inserez le prenom" name="prenom"
                                                        value="{{ $agent?->prenom }}" wire:model='form_stat.prenom'>
                                                </div>
                                                <div class="col-lg-6" wire:ignore.self>
                                                    <label>
                                                        Sexe
                                                    </label>
                                                    <select class="form-select" aria-label="Default select example"
                                                        name="sexe" wire:model='form_stat.sexe'>
                                                        <option value="">Selectionez</option>
                                                        <option value="M" @selected($agent?->sexe == 'M')>
                                                            Masculin
                                                        </option>
                                                        <option value="F" @selected($agent?->sexe == 'F')>Feminin
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label>Lieu d'affectation</label>
                                                    <select class="form-select select2" name="lieu_id"
                                                        aria-label="Default select example" required
                                                        wire:model='form_stat.lieu_id'>
                                                        <option value="" selected disabled>Selectionnez</option>
                                                        <option value="0" @selected($form_stat['lieu_id'] == 0 || $form_stat['lieu_id'] == '')>Aucun
                                                        </option>
                                                        @foreach ($lieus as $lieu)
                                                            <option value="{{ $lieu->id }}"
                                                                @selected($form_stat['lieu_id'] == $lieu->id)>
                                                                {{ $lieu->titre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label> Direction</label>
                                                    <select class="form-select select2" name="direction_id"
                                                        aria-label="Default select example"
                                                        wire:model='form_stat.direction_id' required>
                                                        <option value="">Selectionnez</option>
                                                        <option value="0" @selected($form_stat['direction_id'] == 0 || $form_stat['direction_id'] == '')>
                                                            Aucun
                                                        </option>
                                                        @foreach ($directions as $direction)
                                                            <option value="{{ $direction->id }}"
                                                                @selected($form_stat['direction_id'] == $direction->id)>
                                                                {{ $direction->titre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                

                                                <div class="col-lg-4">
                                                    <label>Service</label>
                                                    <select class="form-select select2" name="sevice_id"
                                                        aria-label="Default select example"
                                                        wire:model='form_stat.service_id'>
                                                        <option value="" selected disabled>Selectionnez</option>
                                                        <option value="0" @selected($form_stat['service_id'] == 0 || $form_stat['service_id'] == '')>Aucun
                                                        </option>
                                                        @foreach ($services as $service)
                                                            <option value="{{ $service->id }}"
                                                                @selected($form_stat['service_id'] == $service->id)>
                                                                {{ $service->titre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                               

                                                <div class="col-lg-4">
                                                    <label>Fonction</label>
                                                    <select class="form-select" name="fonction_id"
                                                        aria-label="Default select example" multiple
                                                        wire:model='form_stat.fonction_id'>
                                                        <option value="">Selectionnez</option>
                                                        <option value="">Aucun</option>
                                                        @foreach ($fonctions as $fonction)
                                                            <option value="{{ $fonction->id }}"
                                                                @selected($form_stat['fonction_id'] == $fonction->id)>
                                                                {{ $fonction->titre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label>Grade</label>
                                                    <select class="form-select select2" name="grade_id"
                                                        aria-label="Default select example"
                                                        wire:model='form_stat.grade_id'>
                                                        <option value="">Selectionnez</option>
                                                        @foreach ($grades as $grade)
                                                            <option value="{{ $grade->id }}"
                                                                @selected($form_stat['grade_id'] == $grade->id)>
                                                                {{ $grade->titre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-lg-4">
                                                    <label>Matricule</label>
                                                    <input type="text" name="matricule" class="form-control"
                                                        placeholder="Matricule" value="{{ $agent?->matricule }}"
                                                        wire:model='form_stat.matricule'>
                                                </div>

                                                <div class="mt-4 col-lg-12 text-end">
                                                    <button class="btn btn-add">
                                                        Sauvegarder
                                                        <span
                                                            class="spinner-border spinner-border-white text-success ms-1 d-none btn-loader"
                                                            role="status"
                                                            style="font-size: 10px !important; width:14px;height:14px"
                                                            wire:loading wire:target="updateAgent"
                                                            wire:loading.class.remove="d-none">
                                                            <span class="sr-only"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="fiche-agent" wire:ignore.self
                                    role="tabpanel" aria-labelledby="agent-tab">

                                    <div class="info-lg">
                                        <div class="block-user-info">
                                            <div
                                                class=" mb-3  d-flex justify-content-between align-items-center flex-wrap flex-sm-nowrap @if ($agent == null) d-none @endif">
                                                {{-- <h2 class="mb-0" style="flex: 0 0 auto;">Informations personnelles
                                                    de l'agent </h2> --}}
                                                <div
                                                    class="block-btns btns-actions mt-sm-0  w-100 justify-content-end  agent-detail-infos">
                                                    @if ($agent?->isDG() == false)
                                                        <button class="btn btn-switch" wire:click='switchStatut'>
                                                            <input type="checkbox" name="statut" id="statut"
                                                                {{ $statut == 1 ? 'checked' : '' }}>
                                                            <div class="block-bg">
                                                                <span>
                                                                    Actif
                                                                </span>
                                                                <span>
                                                                    Suspendu
                                                                </span>
                                                                <div class="div">
                                                                    <div class="bubble">
                                                                        <div class="dote"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </button>

                                                        {{-- <button class="btn" wire:click='archiveAgent({{ $agent?->id }})'>
                                                        <i class="fi fi-rr-box"></i> Archiver l'agent
                                                    </button> --}}
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="row g-3 align-items-start pb-4">
                                                <div class="col-lg-4">
                                                    <div class="d-flex">

                                                        <div class="avatar-user avatar-user-agent-detail">
                                                            <span
                                                                class="statut {{ $agent?->statut_id == 1 ? 'on' : 'off' }}"></span>
                                                            <img src="{{ imageOrDefault($agent?->image) }}"
                                                                alt="photo profil">
                                                        </div>

                                                        <div class="text-star">
                                                            <h4>{{ $agent?->prenom }} {{ $agent?->nom }}</h4>
                                                            <p class="mb-0">{{ $agent?->poste?->titre }}</p>
                                                            <p class="mb-0">Matricule: {{ $agent?->matricule }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="col-6 text-star">
                                                            <h5></h5>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-8">
                                                    <div class="details-contact">
                                                        <div class="details">
                                                            <div class="row g-3">
                                                                <div class="col-lg-4">
                                                                    <div
                                                                        class=" block-detail-sm block-detail-agent-sm">
                                                                        <div class="icon">
                                                                            <i class="fi fi-rr-envelope"></i>
                                                                        </div>
                                                                        <div class="infos">
                                                                            <p>Email</p>
                                                                            <h6
                                                                                style=" display: flex; word-break: break-all;">
                                                                                {{ $agent?->user->email ?? 'Non Specifié' }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="block-detail-sm block-detail-agent-sm">
                                                                        <div class="icon">
                                                                            <i class="fi fi-rr-marker"></i>
                                                                        </div>
                                                                        <div class="phone">
                                                                            <p>Lieu d'affectation</p>
                                                                            <h6>{{ $agent?->lieu?->titre ?? 'Non Specifié' }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="block-detail-sm block-detail-agent-sm">
                                                                        <div class="icon">
                                                                            <i class="fi fi-rr-home"></i>
                                                                        </div>
                                                                        <div class="infos">
                                                                            <p>Direction</p>
                                                                            <h6>{{ $agent?->direction?->titre ?? 'Non Specifié' }}
                                                                            </h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade show active" id="infos-personnal-tab"
                                            wire:ignore.self role="tabpanel" aria-labelledby="infos-personnal-tab">
                                            <div class="info-lg">
                                                <h2 class="mt-2">Infos personnelles</h2>
                                                <div class="row g-3">
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Prenom </p>
                                                            <h6>{{ $agent?->prenom ?? 'Non Specifié' }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Nom</p>
                                                            <h6>{{ $agent?->nom ?? 'Non Specifié' }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Post-nom</p>
                                                            <h6>{{ $agent?->post_nom ?? 'Non Specifié' }}</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Sexe</p>
                                                            <h6>{{ $agent?->sexe ?? 'Non Specifié' }}</h6>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-lg-3">
                                            <div class="items">
                                                <p>Lieu de naissance</p>
                                                <h6>{{ $agent?->lieu_naiss ?? 'Non Specifié' }}</h6>
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="items">
                                                <p>Date de naissance</p>
                                                <h6>{{ date('d/m/Y', strtotime($agent?->date_naiss)) ?? 'Non Specifié' }}
                                                </h6>
                                            </div>

                                        </div>
                                        <div class="col-lg-3">
                                            <div class="items">
                                                <p>Province d'origine</p>
                                                <h6>{{ $agent?->province ?? 'Non Specifié' }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="items">
                                                <p>Ville d'origine</p>
                                                <h6>{{ $agent?->ville ?? 'Non Specifié' }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="items">
                                                <p>Nationalité</p>
                                                <h6>{{ $agent?->nationalite ?? 'Non Specifié' }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="items">
                                                <p>Etat civil</p>
                                                <h6>{{ $agent?->etat_civil ?? 'Non Specifié' }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="items">
                                                <p>Nombre d'enfants</p>
                                                <h6>{{ $agent?->nbr_enfant ?? 'Non Specifié' }}</h6>
                                            </div>
                                        </div> --}}
                                                </div>
                                            </div>
                                            <div class="info-lg">
                                                <h2>Informations professionnelles</h2>
                                                <div class="row g-3">
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Direction </p>
                                                            <h6>{{ $agent?->direction?->titre ?? 'Non Specifié' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Division</p>
                                                            <h6>{{ $agent?->division?->libelle ?? 'Non Specifié' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Service </p>
                                                            <h6>{{ $agent?->service?->titre ?? 'Non Specifié' }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="items">
                                                            <p>Fonction</p>
                                                            <h6>{{ $agent?->poste?->titre ?? 'Non Specifié' }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                {{-- <div class="tab-pane fade" id="activite" wire:ignore.self role="tabpanel"
                                    aria-labelledby="activite-tab">
                                    <div class="info-lg">
                                        <h2>L'historique complet des activités de l'agent {{ $agent?->nom }}</h2>

                                        <div class="row g-3">
                                            @if ($agent && $historiques->isNotEmpty())
                                                <table class="table mt-lg-3 mt-2">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th style="text-align: left;">Type</th>
                                                            <th style="text-align: left;">Titre</th>
                                                            <th style="text-align: left;">Actions réalisées</th>
                                                            <th style="text-align: left;">Date et Heure</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($historiques as $key => $item)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ class_basename($item->historiquecable_type) }}
                                                                </td>
                                                                <td>{{ $item->historiquecable->titre ?? 'Non Spécifié' }}
                                                                </td>
                                                                <td>{{ $item->description ?? 'Non Spécifié' }}</td>
                                                                <td>{{ $item->created_at->isoFormat('ddd l') }} à
                                                                    {{ $item->created_at->format('H:i:s') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-center mt-4">

                                                    <div wire:key="historiques-pagination-{{ $historiquesPage }}">
                                                        {!! $historiques->links() !!}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center col-12">
                                                    <img src="{{ asset('assets/images/sad.gif') }}"
                                                        alt="Aucune activité" width="35px">
                                                    <p>Aucune activité à signaler</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="tab-pane fade" id="activite" wire:ignore.self role="tabpanel"
                                    aria-labelledby="activite-tab">
                                    <div class="info-lg">
                                        <h2>L'historique complet des activités de l'agent {{ $agent?->nom }}</h2>

                                        <div class="row g-3">
                                            @if ($agent && $historiques->isNotEmpty())
                                                <table class="table mt-lg-3 mt-2">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th style="text-align: left;">Actions réalisées</th>
                                                            <th style="text-align: left;">Titre</th>
                                                            <th style="text-align: left;">Type</th>
                                                            <th style="text-align: left;">Date et Heure</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($historiques as $key => $item)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>{{ $item->description ?? 'Non Spécifié' }}</td>
                                                                <td>{{ $item->historiquecable->titre ?? 'Non Spécifié' }}
                                                                <td>{{ class_basename($item->historiquecable_type) }}
                                                                </td>
                                                                </td>
                                                                <td>{{ $item->created_at->isoFormat('ddd l') }} à
                                                                    {{ $item->created_at->format('H:i:s') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <!-- Inclure la pagination personnalisée ici -->
                                                <div class="d-flex justify-content-center mt-4">
                                                    @if ($historiques->hasPages())
                                                        <nav aria-label="Pagination">
                                                            <ul class="pagination">
                                                                <!-- Lien "Précédent" -->
                                                                @if ($historiques->onFirstPage())
                                                                    <li class="page-item disabled">
                                                                        {{-- <span class="page-link">Précédent</span> --}}
                                                                        <span class="page-link" aria-hidden="true">
                                                                            <i class="fi fi-rr-angle-left"></i>
                                                                        </span>
                                                                    </li>
                                                                @else
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"
                                                                            wire:click="updateHistoriquesPage({{ $historiques->currentPage() - 1 }})">
                                                                            <i class="fi fi-rr-angle-left"></i></a>
                                                                    </li>
                                                                @endif

                                                                <!-- Liens des pages -->
                                                                @foreach ($historiques->getUrlRange(1, $historiques->lastPage()) as $page => $url)
                                                                    @if ($page == $historiques->currentPage())
                                                                        <li class="page-item active">
                                                                            <span
                                                                                class="page-link">{{ $page }}</span>
                                                                        </li>
                                                                    @else
                                                                        <li class="page-item">
                                                                            <a class="page-link" href="#"
                                                                                wire:click="updateHistoriquesPage({{ $page }})">{{ $page }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach

                                                                <!-- Lien "Suivant" -->
                                                                @if ($historiques->hasMorePages())
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"
                                                                            wire:click="updateHistoriquesPage({{ $historiques->currentPage() + 1 }})">
                                                                            <i class="fi fi-rr-angle-right"></i></a>
                                                                    </li>
                                                                @else
                                                                    <li class="page-item disabled">
                                                                        {{-- <span class="page-link">Suivant</span> --}}

                                                                        <span class="page-link">
                                                                            <i class="fi fi-rr-angle-right"></i>


                                                                        </span>

                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </nav>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-center col-12">
                                                    <img src="{{ asset('assets/images/sad.gif') }}"
                                                        alt="Aucune activité" width="35px">
                                                    <p>Aucune activité à signaler</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="authentication" role="tabpanel"
                                    aria-labelledby="authentication-tab" wire:ignore.self>
                                    <div class="info-lg">
                                        <form wire:submit.prevent="regeneratePassword">
                                            <input type="hidden" name="user_id" value="{{ $agent?->user?->id }}">
                                            <input type="hidden" name="agent_id" value="{{ $agent?->id }}">
                                            <div class="form-group row g-3 justify-content-center">
                                                <div class="col-lg-12">
                                                    <h2>
                                                        Réinitialisation du mot de passe
                                                    </h2>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label>Email de l'agent <small>(le nouveau mot de passe sera envoyé
                                                            à cette adresse)</small></label>
                                                    <input type="email" wire:model="email" class="form-control"
                                                        placeholder="Insérez l'email de l'agent" required
                                                        autocomplete="off">
                                                    @error('email')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 text-end">
                                                    <button type="submit" class="btn btn-add float-center mt-0">
                                                        Régénérer le mot de passe
                                                        <span
                                                            class="spinner-border spinner-border-white text-success ms-1 d-none btn-loader"
                                                            role="status"
                                                            style="font-size: 10px !important; width:14px;height:14px"
                                                            wire:loading wire:target="regeneratePassword"
                                                            wire:loading.class.remove="d-none">
                                                            <span class="sr-only"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <hr>

                                        <form method="post" wire:submit.prevent="changeRole">
                                            <div class="form-group row g-3 justify-content-center">
                                                <div class="col-lg-12">
                                                    <h2 class="mb-2">Roles</h2>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        @php
                                                            $roles = \Spatie\Permission\Models\Role::all();
                                                        @endphp
                                                        @foreach ($roles as $role)
                                                            <div class="col">
                                                                <input type="radio" name="role_id"
                                                                    id="{{ 'role_' . $role->id }}"
                                                                    class="permission-groupe form-check-input"
                                                                    value="{{ $role->name }}"
                                                                    @checked($agent?->user->hasRole($role->name)) wire:model="role">
                                                                <label for="{{ 'role_' . $role->id }}">
                                                                    <strong>{{ $role->name }}</strong>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="mt-4 col-lg-112 text-end">
                                                    <button class="btn btn-add float-end">
                                                        Enregistrer
                                                        <span
                                                            class="spinner-border spinner-border-white text-success ms-1 d-none btn-loader"
                                                            role="status"
                                                            style="font-size: 10px !important; width:14px;height:14px"
                                                            wire:loading wire:target="changeRole"
                                                            wire:loading.class.remove="d-none">
                                                            <span class="sr-only"></span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                        <hr>

                                        <div class="form-group row g-3 justify-content-center">
                                            <div class="col-lg-12">
                                                <h2 class="mb-2">Permissions octroyées à l'agent</h2>
                                            </div>
                                            <div class="col-12">
                                                <ul class="permissions checkbox list-unstyled" wire:ignore>
                                                    @php
                                                        $role_permissions = $agent?->user?->permissions->count()
                                                            ? $agent?->user?->permissions->pluck('key')->toArray()
                                                            : [];
                                                        $modules = \App\Models\Module::all();
                                                    @endphp
                                                    @foreach ($modules as $modKey => $module)
                                                        <li class="mb-3 li">
                                                            <input type="checkbox" id="{{ 'module_' . $module->id }}"
                                                                class="permission-group form-check-input"
                                                                value="{{ $module->id }}">
                                                            {{-- wire:change='toggelPermission'wire:model='selected_modules' --}}
                                                            <label for="{{ 'module_' . $module->id }}">
                                                                <strong>{{ Str::upper(str_replace('_', ' ', $module->titre)) }}</strong>
                                                            </label>
                                                            <ul class="list-unstyled ms-4">
                                                                @foreach ($module->permissions as $key => $perm)
                                                                    <li
                                                                        class="d-flex align-items-center justify-content-between li-check">
                                                                        <label class="mb-0"
                                                                            for="permission-{{ $perm->id }}">
                                                                            {{ Str::ucfirst(str_replace('_', ' ', $perm->name)) }}
                                                                        </label>
                                                                        <input type="checkbox" style="flex: 0 0 auto"
                                                                            id="permission-{{ $perm->id }}"
                                                                            name="permissions[{{ $perm->id }}]"
                                                                            class="the-permission form-check-input me-1 mt-0"
                                                                            value="{{ $perm->name }}"
                                                                            wire:model='permissions'>

                                                                        {{-- @checked($agent?->user->hasPermissionTo($perm->id) --}}
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="mt-4 col-lg-112 text-end">
                                                <button class="btn btn-add float-end save-permission">
                                                    Enregistrer
                                                    <span
                                                        class="spinner-border spinner-border-white text-success ms-1 d-none btn-loader"
                                                        role="status"
                                                        style="font-size: 10px !important; width:14px;height:14px"
                                                        wire:loading wire:target="changePermission"
                                                        wire:loading.class.remove="d-none">
                                                        <span class="sr-only"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-lg-12 @if ($agent == null) d-none @endif">
                        <div class="d-flex" wire:ignore>
                            <ul class="nav-user nav nav-tabs mt-3 mb-0 " role="tablist" wire:ignore>

                                <li class="nav-item " role="presentation">
                                    <button class="nav-link active" id="infos-personnal-tab" data-bs-toggle="tab"
                                        data-bs-target="#infos-personnal" type="button" role="tab" wire:ignore
                                        aria-controls="infos-personnal" aria-selected="false">Detail
                                        personnel
                                    </button>
                                </li>
                            </ul>

                        </div>

                        <div class="card card-table card-profil" wire:ignore.self>
                            <div class="tab-content" id="infos-personnal-tab" wire:ignore.self>

                                <div class="tab-pane fade show active" id="infos-personnal-tab" wire:ignore.self
                                    role="tabpanel" aria-labelledby="infos-personnal-tab">
                                    <div class="info-lg">
                                        <h2>Infos personnelles</h2>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Prenom </p>
                                                    <h6>{{ $agent?->prenom ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Nom</p>
                                                    <h6>{{ $agent?->nom ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Post-nom</p>
                                                    <h6>{{ $agent?->post_nom ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Sexe</p>
                                                    <h6>{{ $agent?->sexe ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Lieu de naissance</p>
                                                    <h6>{{ $agent?->lieu_naiss ?? 'Non Specifié' }}</h6>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Date de naissance</p>
                                                    <h6>{{ date('d/m/Y', strtotime($agent?->date_naiss)) ?? 'Non Specifié' }}
                                                    </h6>
                                                </div>

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Province d'origine</p>
                                                    <h6>{{ $agent?->province ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Ville d'origine</p>
                                                    <h6>{{ $agent?->ville ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Nationalité</p>
                                                    <h6>{{ $agent?->nationalite ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Etat civil</p>
                                                    <h6>{{ $agent?->etat_civil ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Nombre d'enfants</p>
                                                    <h6>{{ $agent?->nbr_enfant ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="info-lg">
                                        <h2>Informations professionnelles</h2>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Direction </p>
                                                    <h6>{{ $agent?->direction?->titre ?? 'Non Specifié' }}
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Division</p>
                                                    <h6>{{ $agent?->division?->libelle ?? 'Non Specifié' }}
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Service </p>
                                                    <h6>{{ $agent?->service?->titre ?? 'Non Specifié' }}
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="items">
                                                    <p>Fonction</p>
                                                    <h6>{{ $agent?->poste?->titre ?? 'Non Specifié' }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div>

            </div>
        </div>

    </div>

    @include('components.admin.modals.personals', [ 'fonctions' => $fonctions])
</div>

@section('scripts')
    <script>
        $('document').ready(function() {

            $('.permission-group').on('change', function() {
                var parentChecked = this.checked;
                var input = $(this).siblings('ul').find("input[type='checkbox']");
                input.prop('checked', parentChecked);
            });

            $('.save-permission').on('click', function() {
                var input = $('.permission-group').siblings('ul').find("input[type='checkbox']");
                input.each(function() {
                    if (this.checked) {
                        @this.call('selectPermission', $(this).val())
                    }
                });
                @this.call('changePermission')

            });

            $('.permission-select-all').on('click', function() {
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function() {
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked() {
                $('.permission-group').each(function() {
                    var allChecked = true;
                    $(this).siblings('ul').find("input[type='checkbox']").each(function() {
                        if (!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function() {
                parentChecked();
            });

            livewire.on('tab2Change', function() {
                parentChecked();
            });

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(event) {
                parentChecked();
            })

        });
        $('.link-user-tab').click(function() {
            $('.link-user-tab').removeClass('active')
            $(this).addClass('active')
        })

        // const nvImg_profil = document.querySelector('.file-img-profil');
        // var nsr = document.getElementById('img_profil');
        // // console.log(nvImg_profil);
        // nvImg_profil.addEventListener('change', function() {
        //     const fichier_img = this.files[0];
        //     if (fichier_img) {
        //         const analyseur_file = new FileReader();
        //         analyseur_file.readAsDataURL(fichier_img);
        //         analyseur_file.addEventListener('load', function() {
        //             nsr.setAttribute('src', this.result);
        //             $(nsr).addClass('fade')
        //             $("#label-2").addClass('active')
        //         })
        //     }
        //     setTimeout(() => {
        //         $(nsr).removeClass('fade')
        //     }, 3000);
        // })
    </script>

    <script>
        // Livewire.on('userShown', function () {
        //     $('.select2').select2({
        //         tags: $(this).data('tags') ? $(this).data('tags') : false,
        //         placeholder: $(this).data('placeholder'),
        //         language: "fr",
        //         width: '100%',
        //         maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
        //     })
        // })

        $('select[name=lieu_id]').on('change', function(e) {
            livewire.emit('changeLieu', e.target.value);
        });

        $('select[name=direction_id]').on('change', function(e) {
            livewire.emit('changeDirection', e.target.value);
        });

        $('select[name=division_id]').on('change', function(e) {
            livewire.emit('changeDivision', e.target.value);
        });

        $('select[name=sevice_id]').on('change', function(e) {
            // console.log(e);
            livewire.emit('changeService', e.target.value);
        });

        $('select[name=section_id]').on('change', function(e) {
            livewire.emit('changeSection', e.target.value);
        });

        window.livewire.on('select2', () => {
            $('.select2').each(function() {
                var old = $('.select2-container.select2-container--default.select2-container--open');
                if (old.length > 0) {
                    // console.log(old);
                    old.remove();
                }

                $(this).select2({
                    width: '100%',
                    placeholder: 'Selectionnez'
                });
                // $(this).on('select2:open', event =>
                //     setTimeout(() =>
                //         $(event.target).data('select2').dropdown.$search.get(0).focus(), 10
                //     )
                // );
            });

            $('select[name=fonction_id]').select2({
                tags: true,
                placeholder: 'Selectionnez',
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
                width: '100%',
                maximumSelectionLength: 1,
            })

            $('select[name=fonction_id]').on('select2:select', function(e) {
                var data = e.params.data;

                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            $('select[name=fonction_id]').on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
            });

            $('select[name=fonction_id]').on('select2:selecting', function(e) {
                var $el = $(this);
                // var route = $el.data('route');
                // var label = $el.data('label');
                // var relativeId = $el.data('relative-id');
                // var errorMessage = $el.data('error-message');
                var newTag = e.params.args.data.newTag;

                if (!newTag) return;

                $el.select2('close');

                @this.saveFonction(e.params.args.data.text)

                return false;
            });

        });

        $('select[name=grade_id]').on('change', function(e) {
            livewire.emit('changeGrade', e.target.value);
        });


        $('.btn-switch input').on('change', function() {
            $('.btn-switch').toggleClass('active')
        })
    </script>
@endsection

<script>
    // Initialisation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTrigger = document.getElementById('tooltip-svg');
        const tooltip = new bootstrap.Tooltip(tooltipTrigger);

        // Ajouter un événement pour cacher le tooltip au clic
        tooltipTrigger.addEventListener('click', function() {
            tooltip.hide(); // Cache le tooltip
        });
    });
</script>
