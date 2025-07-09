@foreach ($agents as $key => $agent)
    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="block-details-person-{{ $agent->id }}"
        role="tabpanel" aria-labelledby="home-tab">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="/" class="back">
                <i class="fi fi-rr-angle-left"></i>
                Retour
            </a>
            {{-- <button class="btn" style="font-size: 12px;color: var(--primaryColor); font-weight: 600">
                Plus de fiche
            </button> --}}
        </div>
        <div class="row g-lg-3">
            <div class="col-lg-3 pe-lg-0">
                <div class="card card-table card-profil card-profil-sm h-100">
                    <div class="block-user-info">
                        <div class="d-flex align-items-center">
                            <div class="avatar-user">
                                <img src="{{ imageOrDefault($agent->image) }}" alt="photo profil">
                            </div>
                            <div class="text-star">
                                <h4>{{ $agent->prenom . ' ' . $agent->nom }}</h4>
                                <p class="mb-0">{{ $agent->poste?->titre }}</p>
                                <p class="mb-0">{{ $agent->matricule }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">

                        </div>
                        <hr>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 text-star">
                                <h5>Direction</h5>
                                <p class="mb-0">{{ $agent->poste?->direction?->titre }}</p>
                            </div>
                            <div class="col-12 text-star">
                                <h5>Poste</h5>
                                <p class="mb-0">{{ $agent->poste?->titre }}</p>
                            </div>
                            {{-- <div class="col-12text-star">
                                <h5>Niveau d'accès</h5>
                                <p class="mb-0">{{ $agent->user?->role->libelle }}</p>
                            </div> --}}
                        </div>
                        <hr>
                        <div class="details-contact">
                            <h5>Coordonnées</h5>
                            <div class="details">
                                <div class="row g-2">
                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                        <div class="block-detail-sm">
                                            <div class="icon">
                                                <i class="fi fi-rr-envelope"></i>
                                            </div>
                                            <div class="infos">
                                                <h6 class="mb-0">Email</h6>
                                                <p>{{ $agent->adresse?->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                        <div class="block-detail-sm">
                                            <div class="icon">
                                                <i class="fi fi-rr-phone-call"></i>
                                            </div>
                                            <div class="phone">
                                                <h6 class="mb-0">Téléphone</h6>
                                                <p>{{ $agent->adresse?->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-12">
                                        <div class="block-detail-sm">
                                            <div class="icon">
                                                <i class="fi fi-rr-marker"></i>
                                            </div>
                                            <div class="infos">
                                                <h6 class="mb-0">Adresse</h6>
                                                <p>{{ $agent->adresse?->residence }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 ps-lg-1">

                <ul class="mb-0 nav nav-tabs nav-folder ms-3" id="myTab" role="tablist">
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link active" id="departement-tab-{{ $agent->id }}" data-bs-toggle="tab"
                            data-bs-target="#departement-{{ $agent->id }}" type="button" role="tab"
                            aria-controls="departement-{{ $agent->id }}" aria-selected="true">Infos personnelles</button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link" id="contrat-tab-{{ $agent->id }}" data-bs-toggle="tab"
                            data-bs-target="#contrat-{{ $agent->id }}" type="button" role="tab"
                            aria-controls="contrat-{{ $agent->id }}" aria-selected="false">Contrat</button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link" id="planning-tab-{{ $agent->id }}" data-bs-toggle="tab"
                            data-bs-target="#planning-{{ $agent->id }}" type="button" role="tab"
                            aria-controls="planning-{{ $agent->id }}" aria-selected="false">Planning</button>
                    </li>
                    <li class="nav-item me-1" role="presentation">
                        <button class="nav-link" id="activite-tab-{{ $agent->id }}" data-bs-toggle="tab"
                            data-bs-target="#activite-{{ $agent->id }}" type="button" role="tab"
                            aria-controls="activite-{{ $agent->id }}" aria-selected="false">Activités</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="edit-profil-tab-{{ $agent->id }}" data-bs-toggle="tab"
                            data-bs-target="#edit-profil-{{ $agent->id }}" type="button" role="tab"
                            aria-controls="edit-profil-{{ $agent->id }}" aria-selected="false">Modifier</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="authentication-tab-{{ $agent->id }}" data-bs-toggle="tab"
                            data-bs-target="#authentication-{{ $agent->id }}" type="button" role="tab"
                            aria-controls="edit-profil-{{ $agent->id }}" aria-selected="false">Authenfication</button>
                    </li>
                    <div class="indicator-nav">
                        <span></span>
                    </div>
                </ul>

                <div class="card card-table card-profil">
                    <div class="tab-content" id="myTabContent-{{ $agent->id }}">
                        <div class="tab-pane fade show active" id="departement-{{ $agent->id }}" role="tabpanel" aria-labelledby="home-tab-{{ $agent->id }}">
                            <div class="info-lg">
                                <h2>Details personnels</h2>
                                <div class="row g-3">
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Prénom</p>
                                            <h6>{{ $agent->prenom }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Nom</p>
                                            <h6>{{ $agent->nom }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Post-nom</p>
                                            <h6>{{ $agent->post_nom }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Sexe</p>
                                            <h6>{{ $agent->sexe }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Lieu de naissance</p>
                                            <h6>{{ $agent->lieu_naiss }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Date de naissance</p>
                                            <h6>{{ $agent->date_naiss }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Nationalité</p>
                                            <h6>{{ $agent->nationalite }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Etat civil</p>
                                            <h6>{{ $agent->etat_civil }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                        <div class="items">
                                            <p>Nombre d'enfants</p>
                                            <h6>{{ $agent->nbr_enfant }}</h6>
                                        </div>
                                    </div>
                                    @if ($agent->user?->contrat->last() != null)
                                        <div class="col-lg-4 col-sm-4 col-md-4 col-6">
                                            <div class="items">
                                                <p>Salaire</p>
                                                <div class="block-salaire">
                                                    <h6 class="text-clique text-clique-1">
                                                        {{ $agent->user?->contrat->last()->devise . $agent->user?->contrat->last()->salaire }}
                                                    </h6>
                                                    <h6 class="opacity">
                                                        {{ $agent->user?->contrat->last()->devise . $agent->user?->contrat->last()->salaire }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="info-lg">
                                <h2>Documents cursus du personnel</h2>
                                <div class="row g-3">
                                    @if ($agent->user?->documents->count() < 1)
                                        <div class="col-lg-12 d-flex align-items-center">
                                            <div class="icon-lg text-star"></div>
                                            <div class="text-star">
                                                <p class="para">
                                                    Aucun document enregistré pour le moment !
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($agent->user?->documents as $document)
                                            <div class="col-lg-4 d-flex align-items-center">
                                                <a href="{{ asset('assets/pdfs/documents/' . $document->id . '.' . $document->type) }}"
                                                    target="_blank">
                                                    <div class="icon-lg text-star">
                                                        @if ($document->type == 'pdf')
                                                            <img src="{{ asset('assets/images/icons/fichier-pdf.png') }}"
                                                                alt="" class="me-2 img-file"
                                                                style="width: 30px">
                                                        @else
                                                            <img src="{{ asset('assets/images/icons/fichier-image.png') }}"
                                                                alt="" class="me-2 img-file"
                                                                style="width: 30px">
                                                        @endif
                                                    </div>
                                                </a>
                                                <a href="{{ asset('assets/pdfs/documents/' . $document->id . '.' . $document->type) }}"
                                                    target="_blank">
                                                    <div class="text-star">
                                                        <p class="para">
                                                            {{ $document->libelle }}
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="contrat-{{ $agent->id }}" role="tabpanel" aria-labelledby="home-tab">
                            <div class="info-lg">
                                <div class="d-flex justify-content-between">
                                    <h2>Informations contractuelles</h2>
                                    <div class="dropdown">
                                        <button class="btn btn-end" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fi fi-rr-menu-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="{{ $agent->user?->contrat->last() == null || $agent->user?->contrat->last()->statut_id == '2' ? '#modal-new-contrat-' . $agent->id : '#modal-edit-contrat-' . $agent->id }}"
                                                    href="#">
                                                    {{ $agent->user?->contrat->last() == null || $agent->user?->contrat->last()->statut_id == '2' ? 'Ajouter un contrat' : 'Modifier le contrat' }}
                                                </a>
                                            </li>
                                            @if ($agent->user?->contrat->last() != null)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('rh.user.contrat', [$agent->user?->contrat->last()->id, $agent->user?->contrat->last()->statut_id == '1' ? '2' : '1']) }}">
                                                        {{ $agent->user?->contrat->last()->statut_id == '1' ? 'Mettre fin au contrat' : 'Rénouveler le contrat' }}
                                                    </a>
                                                </li>
                                            @endif
                                            {{-- <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modal-new-contrat-old" href="#">Ajouter un ancien contrat</a></li> --}}
                                            {{-- <li><a class="dropdown-item" href="#">Fiche du salaire</a></li>
                                                            <li><a class="dropdown-item" href="#">Temps de travail et rémunération</a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                                @if ($agent->user?->contrat->last() != null)
                                    <div class="row g-3">
                                        <div class="col-lg-3 col-6 col-sm-4 col-md-4">
                                            <div class="items">
                                                <p>Type de contrat</p>
                                                <h6>{{ $agent->user?->contrat->last()->typecontrat->libelle }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-6 col-sm-4 col-md-4">
                                            <div class="items">
                                                <p>Début du contrat</p>
                                                <h6>{{ date('d-m-Y', strtotime($agent->user?->contrat->last()->debut)) }}
                                                </h6>
                                            </div>
                                        </div>
                                        @if ($agent->user?->contrat->last()->fin != null)
                                            <div class="col-lg-3 col-6 col-sm-4 col-md-4">
                                                <div class="items">
                                                    <p>Fin du contrat</p>
                                                    <h6>
                                                        {{ date('d-m-Y', strtotime($agent->user?->contrat->last()->fin)) }}
                                                    </h6>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-lg-3 col-6 col-sm-4 col-md-4">
                                            <div class="items">
                                                <p>Statut</p>
                                                <h6>{{ $agent->user?->contrat->last()->statut_id == '1' ? 'Valide' : 'Non valide' }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    Aucun contrat pour l'instant !
                                @endif
                            </div>
                            <div class="info-lg">
                                <h2>Anciens contrats</h2>
                                <div class="row g-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            @if ($agent->user?->contrat->where('statut_id', '!=', '1')->count() < 1)
                                                <thead>
                                                    <tr>
                                                        Aucun ancien contrat !
                                                    </tr>
                                                </thead>
                                            @else
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Type de contrat</th>
                                                        <th scope="col">Salaire</th>
                                                        <th scope="col">Début</th>
                                                        <th scope="col">Fin</th>
                                                        <th scope="col">Statut</th>
                                                        {{-- <th scope="col">Action</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($agent->user?->contrat->where('statut_id', '!=', '1') as $oldcontrat)
                                                        <tr>
                                                            <td>
                                                                <div class="block-planning ">
                                                                    <span>{{ $oldcontrat->typecontrat->libelle }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="block-planning ">
                                                                    <span>{{ $oldcontrat->devise . $oldcontrat->salaire }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="block-planning ">
                                                                    <span>{{ $oldcontrat->debut }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="block-planning ">
                                                                    <span>{{ $oldcontrat->fin }}</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="block-planning ">
                                                                    @if ($oldcontrat->statut_id == 4)
                                                                        <span>{{ 'Supprimé' }}</span>
                                                                    @elseif ($oldcontrat->statut_id == 2)
                                                                        <span>{{ 'En attente' }}</span>
                                                                    @elseif ($oldcontrat->statut_id)
                                                                        <span>{{ 'Terminé' }}</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @if ($agent->user?->contrat->last() != null)
                                <div class="info-lg">
                                    <h2>Rémunération et temps de travail prévue dans le contrat</h2>
                                    <div class="row g-3">
                                        <div class="col-lg-4 col-6 col-sm-4 col-md-4">
                                            <div class="items">
                                                <p>Salaire du contrat</p>
                                                <h6>{{ $agent->user?->contrat->last()->devise . $agent->user?->contrat->last()->salaire }}
                                                </h6>
                                            </div>

                                        </div>
                                        <div class="col-lg-4 col-6 col-sm-4 col-md-4">
                                            <div class="items">
                                                <p>Temps contractuel / semaine</p>
                                                <h6>{{ $agent->user?->contrat->last()->temps }} heures</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="info-lg">
                                <h2>Poste</h2>
                                <div class="row g-3">
                                    <div class="col-lg-4 col-6 col-sm-4 col-md-4">
                                        <div class="items">
                                            <p>Classification</p>
                                            <h6>{{ $agent->poste?->classification->libelle ?? "" }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6 col-sm-4 col-md-4">
                                        <div class="items">
                                            <p>Catégorie</p>
                                            <h6>{{ $agent->poste?->categorie->libelle ?? "" }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6 col-sm-4 col-md-4">
                                        <div class="items">
                                            <p>Poste</p>
                                            <h6>{{ $agent->poste?->titre }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="info-lg">
                                <h2>Job description</h2>
                                <p class="para">
                                    {!! $agent->poste?->description !!}
                                </p>
                                {{-- <button class="btn btn-cv">
                                                            Voir mon CV
                                                        </button> --}}
                            </div>
                        </div>

                        <div class="tab-pane fade" id="planning-{{ $agent->id }}" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="info-lg">
                                <h2>Horaire de travail</h2>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        @if ($agent->user?->planning == null)
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        Aucun planning défini pour le moment !
                                                    </th>
                                                </tr>
                                                <thead>
                                                @else
                                                    <thead>
                                                        <tr class="text-center">
                                                            @if ($agent->user?->planning->lundi != null)
                                                                <th scope="col">Lundi</th>
                                                            @endif
                                                            @if ($agent->user?->planning->mardi != null)
                                                                <th scope="col">Mardi</th>
                                                            @endif
                                                            @if ($agent->user?->planning->mercredi != null)
                                                                <th scope="col">Mercredi</th>
                                                            @endif
                                                            @if ($agent->user?->planning->jeudi != null)
                                                                <th scope="col">Jeudi</th>
                                                            @endif
                                                            @if ($agent->user?->planning->vendredi != null)
                                                                <th scope="col">Vendredi</th>
                                                            @endif
                                                            @if ($agent->user?->planning->samedi != null)
                                                                <th scope="col">Samedi</th>
                                                            @endif
                                                            @if ($agent->user?->planning->dimanche != null)
                                                                <th scope="col">Dimanche</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                    <tr>
                                                        @if ($agent->user?->planning->lundi != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->lundi }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($agent->user?->planning->mardi != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->mardi }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($agent->user?->planning->mercredi != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->mercredi }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($agent->user?->planning->jeudi != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->jeudi }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($agent->user?->planning->vendredi != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->vendredi }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($agent->user?->planning->samedi != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->samedi }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                        @if ($agent->user?->planning->dimanche != null)
                                                            <td>
                                                                <div class="text-center block-planning">
                                                                    <span>{{ $agent->user?->planning->dimanche }}</span>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                        @endif
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h2 class="mb-0">Heures de travail / semaine</h2>
                                    <div class="text-end">
                                        @if ($agent->user?->planning == null)
                                            <button class="btn btn-add">
                                                <i class="fi fi-rr-plus"></i>
                                                Ajouter
                                            </button>
                                            {{-- @include('pages.rh.personnels.components.modal-edit-planning', ['user' => $agent->user, 'plannings', $plannings]) --}}
                                        @else
                                            <button class="btn btn-add" data-bs-toggle="modal"
                                                data-bs-target="#modal-edit-planning-{{ $agent->id }}">
                                                <i class="fi fi-rr-plus"></i>
                                                Modifier
                                            </button>

                                        @endif
                                    </div>
                                </div>
                                <div class="row" style="margin-top: -10px">
                                    <div class="col-lg-4">
                                        <div class="items">
                                            @if ($agent->user?->contrat->last() != null)
                                                <h6>{{ $agent->user?->contrat->last()->temps }} heures</h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="info-lg">
                                <h2>Pointages</h2>
                                <div class="block-scroll-point-table">
                                    <table class="table table-responsive table-bordered">
                                        @if ($agent->user?->pointages->count() < 1)
                                            <thead>
                                                <tr>
                                                    <th>Aucun pointage pour l'instant !</th>
                                                </tr>
                                            </thead>
                                        @else
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Arrivé</th>
                                                    <th scope="col">Temps de travail</th>
                                                    <th scope="col">Temps supplémentaire</th>
                                                    {{-- <th scope="col">Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($agent->pointages as $pointage)
                                                    @php
                                                        $minutesplaningbegin = 0;
                                                        $minutesplaningend = 0;
                                                        $minutesarrive = 0;
                                                        $minutesconnected = 0;
                                                        $heureuserconnected = 0;
                                                        $minutesuserconnected = 0;
                                                        $minutessupuserconnected = 0;
                                                        $heuressupuserconnected = 0;
                                                        $minutesplaning = 0;

                                                        if (date('N', strtotime($pointage->date)) == 1) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->lundi, 0, 2) * 60 + Str::substr($agent->user?->planning->lundi, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->lundi, 8, 2) * 60 + Str::substr($agent->planning->lundi, 11, 2);
                                                        } elseif (date('N', strtotime($pointage->date)) == 2) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->mardi, 0, 2) * 60 + Str::substr($agent->planning->mardi, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->mardi, 8, 2) * 60 + Str::substr($agent->planning->mardi, 11, 2);
                                                        } elseif (date('N', strtotime($pointage->date)) == 3) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->mercredi, 0, 2) * 60 + Str::substr($agent->planning->mercredi, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->mercredi, 8, 2) * 60 + Str::substr($agent->planning->mercredi, 11, 2);
                                                        } elseif (date('N', strtotime($pointage->date)) == 4) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->jeudi, 0, 2) * 60 + Str::substr($agent->planning->jeudi, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->jeudi, 8, 2) * 60 + Str::substr($agent->planning->jeudi, 11, 2);
                                                        } elseif (date('N', strtotime($pointage->date)) == 5) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->vendredi, 0, 2) * 60 + Str::substr($agent->planning->vendredi, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->vendredi, 8, 2) * 60 + Str::substr($agent->planning->vendredi, 11, 2);
                                                        } elseif (date('N', strtotime($pointage->date)) == 6) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->samedi, 0, 2) * 60 + Str::substr($agent->planning->samedi, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->samedi, 8, 2) * 60 + Str::substr($agent->planning->samedi, 11, 2);
                                                        } elseif (date('N', strtotime($pointage->date)) == 7) {
                                                            $minutesplaningbegin = Str::substr($agent->planning->dimanche, 0, 2) * 60 + Str::substr($agent->planning->dimanche, 3, 2);
                                                            $minutesplaningend = Str::substr($agent->planning->dimanche, 8, 2) * 60 + Str::substr($agent->planning->dimanche, 11, 2);
                                                        }

                                                        $minutesarrive = date('G', strtotime($pointage->arrive)) * 60 + date('i', strtotime($pointage->arrive));

                                                        if (date('d-m-Y', strtotime($pointage->date)) >= now()->format('d-m-Y')) {
                                                            $minutesplaningend = (now()->format('G') + 0) * 60 + now()->format('i');
                                                        } else {
                                                            if ($minutesplaningbegin >= $minutesarrive) {
                                                                $minutessupuserconnected = $minutesconnected - $minutesplaning;
                                                                $heuressupuserconnected = $minutessupuserconnected / 60;
                                                            } else {
                                                                $minutessupuserconnected = 0;
                                                                $heuressupuserconnected = 0;
                                                            }
                                                        }

                                                        $minutesconnected = $minutesplaningend - $minutesarrive;

                                                        $heureuserconnected = $minutesconnected / 60;
                                                        $heureuserconnected = Str::substr($heureuserconnected, 1, 1) == '.' ? Str::substr($heureuserconnected, 0, 1) : Str::substr($heureuserconnected, 0, 2);
                                                        $minutesuserconnected = $minutesconnected - $heureuserconnected * 60;

                                                        $minutesplaning = $minutesplaningend - $minutesplaningbegin;
                                                    @endphp

                                                    <tr>
                                                        <td>
                                                            <div class="block-planning ">
                                                                <span>{{ session()->get('jours')[date('N', strtotime($pointage->date)) - 1] . ', ' . date('d-m-Y', strtotime($pointage->date)) }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="block-planning ">
                                                                <span>{{ $pointage->arrive }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="block-planning ">
                                                                <span>{{ ($heureuserconnected < 10 ? '0' . $heureuserconnected : $heureuserconnected) . ':' . ($minutesuserconnected < 10 ? '0' . $minutesuserconnected : $minutesuserconnected) }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="block-planning ">
                                                                <span>{{ $pointage->supplementaire ?? '0:0' }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <div class="info-lg">
                                <h2>Congés</h2>
                                <table class="table table-responsive table-bordered">
                                    @if ($agent->user?->pivotuserconge->count() < 1)
                                        <thead>
                                            <tr>
                                                <th class="text-center">Aucun congé attribué pour l'instant !
                                                </th>
                                            </tr>
                                        </thead>
                                    @else
                                        <thead>
                                            <tr class="text-center">
                                                <th scope="col">Titre</th>
                                                <th scope="col">Date début</th>
                                                <th scope="col">Durée (jours)</th>
                                                <th scope="col">Statut</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($agent->user?->pivotuserconge as $pivotuserconge)
                                                <tr>
                                                    {{-- <td>
                                                                    <div class="text-center block-planning">
                                                                        <span>{{ $pivotuserconge->libelle }}</span>
                                                                    </div>
                                                                </td> --}}
                                                    <td>
                                                        <div class="text-center block-planning">
                                                            <span>{{ $pivotuserconge->conge->libelle }}</span>
                                                            {{-- <span>Caisse</span> --}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center block-planning">
                                                            <span>{{ date('d-m-Y', strtotime($pivotuserconge->debut)) }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center block-planning">
                                                            <span>{{ $pivotuserconge->jour }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="text-center block-planning">
                                                            @if ($pivotuserconge->statut_id == '1')
                                                                <span>En cours</span>
                                                            @elseif ($pivotuserconge->statut_id == '2')
                                                                <span>Terminé</span>
                                                            @elseif ($pivotuserconge->statut_id == '3')
                                                                <span>Supprimé</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>

                            <div class="mt-3 text-end">
                                <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-add-conge-{{ $agent->id }}">
                                    <i class="fi fi-rr-plus"></i>
                                    Attribuer un congé
                                </button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="activite-{{ $agent->id }}" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="info-lg">
                                <h2>Fichiers partagés</h2>
                                <div class="row g-3">
                                    @forelse ($agent->user?->fichiers ?? [] as $fichier)
                                        <div class="col-lg-4 d-flex align-items-center">
                                            <a href="{{ asset('assets/pdfs/fichiers/' . $fichier->id . '.' . $fichier->type) }}"
                                                target="_blank">
                                                <div class="icon-lg text-star">
                                                    <img src="{{ asset('assets/images/icons/fichier-pdf.png') }}"
                                                        alt="" class="me-2 img-file" style="width: 30px">
                                                </div>
                                            </a>
                                            <a href="{{ asset('assets/pdfs/fichiers/' . $fichier->id . '.' . $fichier->type) }}"
                                                target="_blank">
                                                <div class="text-star">
                                                    <p class="para">
                                                        {{ $fichier->libelle }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="text-center">
                                            Aucun fichier partagé !
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="info-lg">
                                <h2>Progression de tâches</h2>
                                @forelse ($agent->user?->pivotusertache ?? [] as $pivottache)
                                    <div class="block-all-task">
                                        <div class="block-task-item">
                                            <div class="mb-0 form-check d-flex ps-0">
                                                {{-- <input class="form-check-input ms-0 me-3" type="checkbox" value="" id="flexCheckDefault1" name="flexRadioDefault"> --}}
                                                <label
                                                    class="mb-0 form-check-label d-flex justify-content-between w-100"
                                                    for="flexCheckDefault1">
                                                    <div class="infos-croup" style="width: 50%">
                                                        <h6 class="mb-0">{{ $pivottache->tache->libelle }}
                                                        </h6>
                                                        <p>{{ $pivottache->tache->pivotusertaches->count() }}
                                                            agents</p>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="p-0 btn btn-end btn-toggle"
                                                            id="dropdownMenuButton2" data-bs-toggle="dropdown"
                                                            aria-expanded="true">
                                                            <p class="d-flex">Priorité : <span class="ms-1 d-flex"
                                                                    style="color: var(--colorTitre)">{{ $pivottache->tache->etat->libelle }}
                                                                    <i class="fi fi-rr-triangle ms-1"
                                                                        style="transform: rotate(180deg); font-size: 8px; margin-top: -7px;position: relative; top: -4px"></i></span>
                                                            </p>
                                                        </button>
                                                        <ul class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton2"
                                                            style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0.366669px, 38px);"
                                                            data-popper-placement="bottom-end">
                                                            @foreach ($etats as $etat)
                                                                <li>
                                                                    @if ($etat->id == $pivottache->tache->etat_id)
                                                                        <a class="dropdown-item" href="#">
                                                                        @else
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('taches.priorite', [$pivottache->tache->id, $etat->id]) }}">
                                                                    @endif
                                                                    {{ $etat->libelle }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </label>
                                            </div>
                                            <div
                                                class="my-2 block-progress d-flex justify-content-between align-items-center">
                                                <div class="progressBar">
                                                    <div class="move"
                                                        style="width: {{ $pivottache->tache->cibles->count() <= 0 ? 0 : ($pivottache->tache->cibles->where('statut', '1')->count() * 100) / $pivottache->tache->cibles->count() }}%">
                                                    </div>
                                                </div>
                                                <div class="pourcentage">
                                                    {{ $pivottache->tache->cibles->count() <= 0 ? 0 : Str::substr(($pivottache->tache->cibles->where('statut', '1')->count() * 100) / $pivottache->tache->cibles->count(), 0, 2) }}%
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="date">
                                                    <span>Date début :
                                                        {{ date('d-m-Y', strtotime($pivottache->tache->debut)) }}</span>
                                                </div>
                                                <div class="date">
                                                    <span>Date limite :
                                                        {{ date('d-m-Y', strtotime($pivottache->tache->fin)) }}</span>
                                                </div>
                                                {{-- <div class="mt-0 tools-sm d-flex align-items-center justify-content-end">
                                                                            <a href="#">
                                                                                <i class="fi fi-rr-clip"></i>
                                                                            </a>
                                                                            <a href="#">
                                                                                <i class="fi fi-rr-comment-alt"></i>
                                                                            </a>
                                                                            <a href="#">
                                                                                <i class="fi fi-rr-user-add"></i>
                                                                            </a>
                                                                        </div> --}}
                                            </div>

                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center">
                                        Aucune tâche attribuée !
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="tab-pane fade" id="edit-profil-{{ $agent->id }}" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="info-lg">
                                <form method="post" action="{{ route('rh.user.update') }}" id="edit-person">
                                    @csrf
                                    <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                                    <div class="form-group row g-3">
                                        <div class="col-lg-12">
                                            <h2>Informations professionnelles</h2>
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Direction</label>
                                            <select class="form-select" name="direction_id"
                                                aria-label="Default select example" required>
                                                <option value="" selected disabled>Selectionnez</option>
                                                @foreach ($directions as $direction)
                                                    <option value="{{ $direction->id }}" @selected($agent->poste?->direction && $agent->poste?->direction->is($direction) ? true : $agent->poste?->service?->direction->id == $direction->id)>
                                                        {{ $direction->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Service</label>
                                            <select class="form-select" name="service_id"
                                                aria-label="Default select example" required>
                                                <option value="" selected disabled>Selectionnez</option>
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" @selected($agent->poste?->service?->id == $service->id)>
                                                        {{ $service->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-6">
                                            <label>Poste</label>
                                            <select class="form-select" name="fonction_id"
                                                aria-label="Default select example" required>
                                                @foreach ($fonctions as $fonction)
                                                    <option value="{{ $fonction->id }}" @selected($agent->poste?->id == $fonction->id)>
                                                        {{ $fonction->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Planning</label>
                                            <select class="form-select" name="planning_id"
                                                aria-label="Default select example" required>
                                                @foreach ($plannings as $planning)
                                                    <option value="{{ $planning->id }}"
                                                        {{ $agent->planning_id == $planning->id ? 'selected' : '' }}>
                                                        {{ $planning->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                                        <label>Accréditation</label>
                                                        <select class="form-select" name="role_id"
                                                            aria-label="Default select example" required>
                                                            @foreach ($roles as $role)
                                                                <option value="{{ $role->id }}"
                                                                    {{ $agent->role_id == $role->id ? 'selected' : '' }}>
                                                                    {{ $role->libelle }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> --}}
                                        <div class="col-lg-6">
                                            <label>Matricule</label>
                                            <input type="text" name="matricule" value="{{ $agent->matricule }}"
                                                class="form-control" placeholder="Insérez le numéro matricule"
                                                required>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Statut</label>
                                            <select class="form-select" name="statut_id"
                                                aria-label="Default select example" required>
                                                @foreach ($statuts as $statut)
                                                    <option value="{{ $statut->id }}"
                                                        {{ $agent->statut_id == $statut->id ? 'selected' : '' }}>
                                                        {{ $statut->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mt-4 col-lg-12 text-end">
                                            <button class="btn btn-add">Modifier</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="authentication-{{ $agent->id }}" role="tabpanel"
                            aria-labelledby="home-tab">
                            <div class="info-lg">
                                <form method="post" action="{{ route('rh.user.update.auth') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="user_id" value="{{ $agent->user?->id }}">
                                    <input type="hidden" name="agent_id" value="{{ $agent->id }}">
                                    <div class="form-group row g-3 justify-content-center">
                                        <div class="col-lg-12">
                                            <h2>Informations sur le mode d'authentification à l'application</h2>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Email</label>
                                            <input type="email" name="email"
                                                value="{{ old('email', $agent->user?->email) }}" class="form-control"
                                                placeholder="Insérez l'email" required autocomplete="off">
                                        </div>
                                        {{-- <div class="col-lg-10">
                                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                        <label>Téléphone</label>
                                                        <input type="tel" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="form-control" placeholder="Insérez l'email" required>
                                                    </div> --}}
                                        <div class="col-lg-6">
                                            <input type="hidden" name="user_id" value="{{ $agent->user?->id }}">
                                            <label>Mot de passe </label>
                                            <input type="password" name="password" class="form-control"
                                                placeholder="Insérez l'email" autocomplete="new-password">
                                            <small>(laissez vide pour garder l'ancien)</small>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="hidden" name="user_id" value="{{ $agent->user?->id }}">
                                            <label>Confirmer le mot de passe</label>
                                            <input type="password" name="password_confirm" class="form-control"
                                                placeholder="Confirmer le mot de passe">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Statut</label>
                                            <select class="form-select" name="statut_id"
                                                aria-label="Default select example" required>
                                                <option value="" selected disabled>Selectionnez le statut
                                                </option>
                                                @foreach ($statuts as $statut)
                                                    <option value="{{ $statut->id }}"
                                                        {{ $agent->user?->statut_id == $statut->id ? 'selected' : '' }}>
                                                        {{ $statut->libelle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12"></div>
                                        <div class="mt-4 text-end">
                                            <button class="btn btn-add float-end">Enregistrer</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <form method="post" action="{{ route('rh.user.permissions') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="user_id" value="{{ $agent->user_id }}">
                                    <div class="form-group row g-3 justify-content-center">
                                        <div class="col-lg-12">
                                            <h2>Informations sur les permission</h2>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <a href="javascript:void(0)"
                                                    class="permission-select-all" style="color: var(--colorTitre); font-size:14px">Sélectionner tout</a> /
                                                <a href="javascript:void(0)"
                                                    class="permission-deselect-all" style="color: var(--colorTitre); font-size:14px">Désélectionner tout</a>
                                            </div>

                                            <ul class="permissions checkbox list-unstyled">
                                                @php
                                                    $role_permissions = $agent->user?->permissions->count() ? $agent->user?->permissions->pluck('key')->toArray() : [];
                                                @endphp
                                                @foreach (\App\Models\Permission::all()->groupBy('task') as $table => $permission)
                                                    <li class="mb-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input permission-group" type="checkbox" role="switch" id="{{ $table }}">
                                                            </div>
                                                            <label for="{{ $table }}" style="color: var(--colorTitre)">
                                                                <strong>{{ Str::title(str_replace('_', ' ', $table)) }}</strong>
                                                            </label>
                                                        </div>
                                                        {{-- <input type="checkbox" id="{{ $table }}"
                                                            class="permission-group"> --}}

                                                        <ul class="list-unstyled ms-4">

                                                            @foreach ($permission as $perm)
                                                                <li>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="form-check form-switch">
                                                                            <input class="form-check-input permission-group" type="checkbox" role="switch" id="permission-{{ $perm->id }}" name="permissions[{{ $perm->id }}]" value="{{ $perm->id }}" @if (in_array($perm->key, $role_permissions)) checked @endif>
                                                                        </div>
                                                                        <label for="permission-{{ $perm->id }}">
                                                                            {{ Str::title(str_replace('_', ' ', $perm->key)) }}
                                                                        </label>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="mt-4 col-lg-12 text-end">
                                            <button class="btn btn-add float-end">Enregistrer</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
