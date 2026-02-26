@extends('regidoc.layouts.master')

@section('style')
    <style>
        .signature-tab-pane {
            padding: 20px;
        }
        #canvas_signature_pad_profile_page {
            cursor: crosshair;
            background-color: #f8f9fa;
        }
        .btn-group .btn-check:checked + .btn-outline-primary {
            background-color: var(--color-primary, #0d6efd);
            border-color: var(--color-primary, #0d6efd);
            color: white;
        }
        #image-upload-placeholder {
            transition: all 0.3s ease;
        }
        #image-upload-placeholder:hover {
            background-color: #e9ecef;
            border-radius: 8px;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid px-lg-2">
        <div class="mb-2 card card-lg card-profil-lg bg-white card-profil-userAuth">
            <div class="row g-lg-4 g-4">
                <div class="col-lg-3 col-sm-4 col-md-4">
                    <div class="avatar-lg profil-lg">
                        <img src="{{ imageOrDefault(Auth::user()->agent->image) }}"
                            alt="Photo de profil de {{ Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom }}">
                        <button class="btn btn-add-photo" data-bs-toggle="modal" data-bs-target="#modal-change-photo-profil">
                            <i class="fi fi-rr-camera"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8   mt-0">

                    <div class="card-profil-userAuth-infosBox">
                        <div class="row">
                            <div class="col-6">
                                <div class="content-info-profil">
                                    <div class="block-badge-statut">
                                        {{ Auth::user()->statut?->libelle }}
                                    </div>
                                    <h1 class="text-center text-lg-start mt-2 mt-lg-0 profil-title">
                                        {{ Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom }}</h1>
                                    <p class="mb-0 text-center text-lg-start poste-user-auth ">Matricule :
                                        {{ Auth::user()->agent->matricule }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                @if (Auth::user()->agent->isDG())
                                    <div class="text-center">
                                        @if (Auth::user()->agent->delegue_id == null)
                                            <button class="btn btn-action-delegue mt-2 mt-lg-0"
                                                data-bs-target="#modal-delegue" data-bs-toggle="modal">
                                                Déléguer mes responsabilités
                                            </button>
                                        @else
                                            <a href="{{ route('regidoc.profil.delegueRemove') }}"
                                                class="btn btn-action-delegue mt-2  mt-lg-0">
                                                Reprendre mes responsabilités
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
    
                            {{-- <div class="col-12 p-0 m-0">
                                <hr>
                            </div> --}}

                            <div class="col-12">
                                <div class="block-coord blockCoord-profil-userAuth">
                                    <div class="row g-2">
                                        <div class="col-lg-4 col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fi fi-rr-bank"></i>
                                                <p>
                                                    {{ Auth::user()->agent->direction->titre ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fi fi-rr-user"></i>
                                                <p class="">{{ Auth::user()->agent->poste?->titre ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-4 col-sm-6 col-md-6">
                                            <div class="d-flex align-items-star">
                                                <i class="fi fi-rr-marker"></i>
                                                <p>
                                                    {{ Auth::user()->agent->adresse?->residence }}
                                                </p>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-4 col-sm-6 col-md-6">
                                            <div class="d-flex align-items-center">
                                                <i class="fi fi-rr-envelope"></i>
                                                <p>{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-4 col-sm-6 col-md-6">
                                            <div class="d-flex align-items-star">
                                                <i class="fi fi-rr-phone-call"></i>
                                                <p>{{ Auth::user()->agent->adresse?->phone }}</p>
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>





                </div>
            </div>
        </div>

        <div class="row g-lg-3">
            <div class="col-lg-12">
                <div class="d-flex">
                    <ul class="mb-0  nav nav-tabs nav-user" id="myTab" role="tablist">
                        <li class="nav-item me-1" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#departement" type="button" role="tab" aria-controls="departement"
                                aria-selected="true">Fiche agent</button>
                        </li>
                        <li class="nav-item me-1" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#activite"
                                type="button" role="tab" aria-controls="activite" aria-selected="false">Votre activité</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#edit-profil"
                                type="button" role="tab" aria-controls="edit-profil" aria-selected="false">Modifier la
                                fiche</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="signature-tab-btn" data-bs-toggle="tab" data-bs-target="#signature-profile"
                                type="button" role="tab" aria-controls="signature-profile" aria-selected="false">eSignature</button>
                        </li>
                    </ul>
                </div>
                <div class="card card-table card-profil" style="border-radius: 12px 12px 12px 12px">
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="departement" role="tabpanel" aria-labelledby="home-tab">
                            <div class="info-lg">
                                <h2>Infomartions personnelles</h2>
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Prénom</p>
                                            <h6>{{ Auth::user()->agent->prenom ?? '' }}</h6>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Nom</p>
                                            <h6>{{ Auth::user()->agent->nom }}</h6>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Post-nom</p>
                                            <h6>{{ Auth::user()->agent->post_nom ?? 'Non défini' }}</h6>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Sexe</p>
                                            <h6>{{ Auth::user()->agent->sexe ?? '' }}</h6>
                                        </div>

                                    </div>
                                    {{-- <div class="col-lg-4">
                                        <div class="items">
                                            <p>Lieu de naissance</p>
                                            <h6>{{ Auth::user()->agent->lieu_naiss ?? '' }}</h6>
                                        </div>

                                    </div>
                                     <div class="col-lg-4">
                                        <div class="items">
                                            <p>Date de naissance</p>
                                            <h6>{{ date('d F Y', strtotime(Auth::user()->agent->date_naiss)) ?? '' }}</h6>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Nationalité</p>
                                            <h6>{{ Auth::user()->agent->nationalite ?? '' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Etat civil</p>
                                            <h6>{{ Auth::user()->agent->etat_civil ?? '' }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Nombre d'enfants</p>
                                            <h6>{{ Auth::user()->agent->nbr_enfant ?? '0' }}</h6>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        {{-- <div class="tab-pane fade" id="contrat" role="tabpanel" aria-labelledby="home-tab">
                            <div class="info-lg">
                                <div class="d-flex justify-content-between">
                                    <h2>Informations contractuelles</h2>

                                </div>

                            </div>

                            <div class="info-lg">
                                <h2>Fonction</h2>
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Classification</p>
                                            <h6>Salarié - Cadre</h6>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Catégorie</p>
                                            <h6>Ingénieur et Cadres - 170</h6>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="items">
                                            <p>Fonction</p>
                                            <h6>{{ Auth::user()->agent?->poste?->titre ?? 'Non specifié' }}</h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="info-lg">
                                <h2>Job description</h2>
                                <p class="para">{{ Auth::user()->agent->poste?->description }}</p>
                            </div>
                        </div> --}}

                        <div class="tab-pane fade" id="activite" role="tabpanel" aria-labelledby="home-tab">
                            <div class="info-lg">
                                <h2>Historique d'activité de l'agent</h2>
                                <div class="table-responsive">
                                    <table class="table mt-3">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th style="text-align: left !important;">Type</th>
                                                <th style="text-align: left !important;">Titre</th>
                                                <th style="text-align: left !important;">Description</th>
                                                <th style="text-align: left !important;">Date et Heure</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($historiques as $key => $item)
                                                @php
                                                    $courriel = null;
                                                    $task = null;
                                                    if ($item->historiquecable_type == 'App\Models\Courrier') {
                                                        $courriel = \App\Models\Courrier::find($item->historiquecable_id);
                                                    } elseif ($item->historiquecable_type == 'App\Models\Tache') {
                                                        $task = \App\Models\Tache::find($item->historiquecable_id);
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <span class="number">
                                                            {{ $key + 1 }}
                                                        </span>
                                                    </td>
                                                    @if ($item->historiquecable_type == 'App\\Models\\Courrier')
                                                        <td style="text-align: left !important;">Courrier</td>
                                                        <td class="table-cell" style="text-align: left !important;">
                                                            {{ $courriel->title ?? 'Non Specifié' }}
                                                        </td>
                                                    @elseif($item->historiquecable_type == 'App\\Models\\Tache')
                                                        <td style="text-align: left !important;">Tâche</td>
                                                        <td class="table-cell" style="text-align: left !important;">
                                                            {{ $task->titre ?? 'Non Specifié' }}
                                                        </td>
                                                    @else
                                                        <td style="text-align: left !important;">Autre</td>
                                                        <td style="text-align: left !important;">-</td>
                                                    @endif
                                                    <td style="text-align: left !important;">
                                                        {{ $item->description ?? 'Non spécifié' }}
                                                    </td>
                                                    <td style="text-align: left !important;">
                                                        {{ $item->created_at->isoFormat('ddd l') }} à
                                                        {{ $item->created_at->format('H:i:s') }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px" class="mb-2">
                                                        <p class="mb-0">Aucune activité à signaler</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    
                                    <!-- Pagination -->
                                    <div class="mt-4 d-flex justify-content-center">
                                        {!! $historiques->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="edit-profil" role="tabpanel" aria-labelledby="home-tab">
                            <div class="info-lg">
                                <h2>Informations personnelles</h2>
                                <form method="post" action="{{ route('regidoc.rh.user.perso.update') }}">
                                    @csrf
                                    <div class="form-group row g-3">
                                        <div class="col-lg-4 mailauto">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->agent?->id }}">
                                            <label class="nom">Nom</label>
                                            <input type="text" name="nom" value="{{ Auth::user()->agent?->nom }}"
                                                class="form-control nom" placeholder="Insérez le nom" required
                                                style="text-transform: capitalize">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Post-nom</label>
                                            <input type="text" name="postnom"
                                                value="{{ Auth::user()->agent?->post_nom }}" class="form-control"
                                                placeholder="Insérez le post-nom" style="text-transform: capitalize">
                                        </div>
                                        <div class="col-lg-4 mailauto">
                                            <label>Prénom</label>
                                            <input type="text" name="prenom"
                                                value="{{ Auth::user()->agent?->prenom }}" class="form-control nom"
                                                placeholder="Insérez le prénom" style="text-transform: capitalize">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Sexe</label>
                                            <select class="form-select" name="sexe"
                                                aria-label="Default select example" required>
                                                <option value="F"
                                                    {{ Auth::user()->agent?->sexe == 'F' ? 'selected' : '' }}>Féminin
                                                </option>
                                                <option value="M"
                                                    {{ Auth::user()->agent?->sexe == 'M' ? 'selected' : '' }}>Masculin
                                                </option>
                                            </select>
                                        </div>
                                        {{-- <div class="col-lg-4">
                                            <label>Lieu de naissance</label>
                                            <input type="text" name="lieunaissance"
                                                value="{{ Auth::user()->agent?->lieu_naiss }}" class="form-control"
                                                placeholder="Insérez le lieu de naissance">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Date de naissance</label>
                                            <input type="date" name="datenaissance"
                                                value="{{ Auth::user()->agent?->date_naiss }}" class="form-control"
                                                placeholder="Insérez la date de naissance">
                                        </div> --}}
                                        <div class="col-lg-4 mail">
                                            <label>E-mail</label>
                                            <input type="email" name="email" value="{{ Auth::user()->email }}"
                                                class="form-control" placeholder="Insérez l'adresse e-mail"
                                                style="text-transform: lowercase" required>
                                        </div>
                                        {{-- <div class="col-lg-4">
                                            <label>Téléphone</label>
                                            <input type="phone" name="telephone"
                                                value="{{ Auth::user()->agent?->adresse?->phone }}" class="form-control"
                                                placeholder="Insérez le téléphone" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Nationalité</label>
                                            <input type="text" name="nationalite"
                                                value="{{ Auth::user()->agent->nationalite }}" class="form-control"
                                                placeholder="Insérez la nationalité">
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Etat-civil</label>
                                            <select class="form-select" name="etatcivil"
                                                aria-label="Default select example" required>
                                                <option value="Célibataire(e)"
                                                    {{ Auth::user()->agent->etat_civil == 'Célibataire(e)' ? 'selected' : '' }}>
                                                    Célibataire</option>
                                                <option value="Divorcé(e)"
                                                    {{ Auth::user()->agent->etat_civil == 'Divorcé(e)' ? 'selected' : '' }}>
                                                    Divorcé(e)</option>
                                                <option value="Marié(e)"
                                                    {{ Auth::user()->agent->etat_civil == 'Marié(e)' ? 'selected' : '' }}>
                                                    Marié(e)</option>
                                                <option value="Veuf(ve)"
                                                    {{ Auth::user()->agent->etat_civil == 'Veuf(ve)' ? 'selected' : '' }}>
                                                    Veuf(Veuve)</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Nombre d'enfants</label>
                                            <input type="text" name="enfants"
                                                value="{{ Auth::user()->agent->nbr_enfant }}" class="form-control"
                                                placeholder="Insérez le nombre d'enfants" required>
                                        </div>
                                        <div class="col-lg-4">
                                            <label>Adresse</label>
                                            <textarea name="adresse" id="" cols="30" rows="3" class="form-control" required>{{ Auth::user()->agent->adresse?->residence }}</textarea>
                                        </div> --}}
                                        <div class="mt-4 col-lg-12 text-end">
                                            <button class="btn btn-add float-end">Modifier</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if (Auth::user()->id == 1)
                                <div class="info-lg">
                                    <h2>Modifier le mot de passe</h2>
                                    <form method="post" action="{{ route('regidoc.rh.user.update.password') }}">
                                        @csrf
                                        <div class="form-group row g-3">
                                            <div class="col-lg-4 mailauto">
                                                <label class="nom">Mot de passe actuel</label>
                                                <input type="password" name="password_old" class="form-control nom"
                                                    placeholder="Insérez l'ancien mot de passe" required>
                                            </div>
                                            <div class="col-lg-4">
                                                <label>Nouveau mot de passe</label>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Insérez le nouveau mot de passe" required>
                                            </div>
                                            <div class="col-lg-4 mailauto">
                                                <label>Confirmation du mot de passe</label>
                                                <input type="password" name="password_confirm" class="form-control nom"
                                                    placeholder="Confirmez le nouveau mot de passe" required>
                                            </div>
                                            <div class="mt-4 col-lg-12 text-end">
                                                <button class="btn btn-add float-end">Modifier</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="signature-profile" role="tabpanel" aria-labelledby="signature-tab-btn">
                            <div class="info-lg">
                                <h2>Ma signature</h2>
                                <p class="text-muted mb-3">Enregistrez votre signature électronique pour l'utiliser lors de la signature des documents.</p>
                                
                                <div class="mt-4">
                                    <h6 class="mb-2">Aperçu</h6>
                                    <div id="no-signature-profile" class="text-muted">
                                        Aucune signature enregistrée.
                                        <div class="mt-3">
                                            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-save-signature-profile">
                                                Enregistrer ma signature
                                            </button>
                                        </div>
                                    </div>
                                    <div id="signature-preview-profile" class="d-none">
                                        <img id="signature-preview-img-profile" src="" alt="signature" class="img-fluid border rounded" style="max-width: 260px; background: #fff;">
                                        {{-- <div class="mt-2">
                                            <button class="btn btn-default" data-bs-toggle="modal" data-bs-target="#modal-save-signature-profile">Modifier</button>
                                        </div> --}}
                                        <div class="mt-3">
                                            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-save-signature-profile">
                                                Mettre à jour
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Enregistrement de la signature (Profil) - déplacé en bas pour éviter des problèmes d'empilement Bootstrap -->
    <div class="modal fade" id="modal-save-signature-profile" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ma signature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4 d-flex justify-content-center">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="signature_method" id="method-draw" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="method-draw"><i class="fi fi-rr-edit me-2"></i> Dessiner</label>
                            
                            <input type="radio" class="btn-check" name="signature_method" id="method-import" autocomplete="off">
                            <label class="btn btn-outline-primary" for="method-import"><i class="fi fi-rr-upload me-2"></i> Importer une image</label>
                        </div>
                    </div>

                    <div id="draw-signature-container">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="signature-color" class="form-label">Couleur du stylo :</label>
                                <input type="color" class="form-control form-control-color w-100" id="signature-color" value="#000000" title="Choisir une couleur">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dessinez votre signature dans le cadre ci-dessous :</label>
                            <div class="border rounded p-2 bg-white">
                                <canvas id="canvas_signature_pad_profile_page" style="width: 100%; height: 250px; touch-action: none; cursor: crosshair;"></canvas>
                            </div>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-clear-signature-profile">
                                    <i class="fi fi-rr-refresh me-1"></i> Effacer le dessin
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="import-signature-container" class="d-none">
                        <div class="mb-3">
                            <label class="form-label">Sélectionnez une image de votre signature (JPG, PNG) :</label>
                            <div class="border rounded p-4 text-center bg-light">
                                <input type="file" id="input-signature-image" class="form-control d-none" accept="image/*">
                                <label for="input-signature-image" style="cursor: pointer;" class="w-100 mb-0">
                                    <div id="image-upload-placeholder">
                                        <i class="fi fi-rr-camera-retro" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="mt-2 mb-0">Cliquez pour choisir un fichier</p>
                                        <small class="text-muted">Format recommandé : PNG avec fond transparent</small>
                                    </div>
                                    <div id="image-upload-preview" class="d-none">
                                        <img id="signature-import-preview-img" src="" class="img-fluid border rounded" style="max-height: 200px;">
                                        <p class="mt-2 mb-0 text-primary">Cliquer pour changer l'image</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="color: var(--colorTitre)">Annuler</button>
                    <button type="button" class="btn btn-add" id="btn-save-signature-profile">Enregistrer la signature</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delegue" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Déléguer mes responsabilités</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('regidoc.profil.delegueSave') }}">
                        @csrf
                        <div class="form-group row g-3 g-lg-3">
                            <div class="col-lg-12">
                                <h5 style="font-size: 15px;">À qui souhaitez-vous déléguer vos responsabilités ?</h5>
                            </div>
                            <div class="col-lg-12">
                                <ul class="permissions checkbox list-unstyled permission-action mb-0">
                                    <!-- <li class="d-flex align-items-center justify-content-between li-check">
                                        <label for="dga" class="mb-0">DGA</label>
                                        <input type="checkbox" class="the-permission form-check-input mt-0"
                                            name="to_dga" id="dga"
                                            value="{{ Auth::user()->agent->direction?->adjoint?->id }}">
                                    </li> -->
                                </ul>
                            </div>
                            <div class="col-lg-12">
                                <label for="autre_agent">Autre agent</label>
                                <select name="autre_agent" id="autre_agent" class="form-control select2">
                                    <option value="">Selectionner</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}">
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <h5 style="font-size: 15px;">Que peut faire le délégué ?</h5>
                            </div>
                            <div class="col-lg-12">
                                <ul class="permissions checkbox list-unstyled permission-action">
                                    @php
                                        $permissions = Auth::user()->permissions;
                                    @endphp
                                    @foreach ($permissions as $perm)
                                        <li class="d-flex align-items-center justify-content-between li-check">
                                            <label class="mb-0" for="permission-{{ $perm->id }}">
                                                {{ Str::ucfirst(str_replace('_', ' ', $perm->name)) }}
                                            </label>
                                            <input type="checkbox" style="flex: 0 0 auto"
                                                id="permission-{{ $perm->id }}" name="permissions[]"
                                                class="the-permission form-check-input mt-0" value="{{ $perm->id }}" checked>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-add">Sauvegarder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔍 DEBUG NON-BLOQUANT — soumission normale préservée --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#modal-delegue form');
        if (!form) {
            console.error('%c[DELEGUE ERROR] Formulaire #modal-delegue introuvable dans le DOM !', 'color:red;font-weight:bold');
            return;
        }
        console.log('%c[DELEGUE] ✅ Formulaire trouvé. Action = ' + form.action, 'color:green;font-weight:bold');

        form.addEventListener('submit', function () {
            // ⚠️ PAS de e.preventDefault() → le formulaire se soumet normalement

            const autreAgent = form.querySelector('[name="autre_agent"]');
            const toDga      = form.querySelector('[name="to_dga"]');

            const agentId = (toDga && toDga.checked)
                ? toDga.value
                : (autreAgent ? autreAgent.value : null);

            const permissionsChecked = Array.from(
                form.querySelectorAll('input[name="permissions[]"]:checked')
            ).map(cb => cb.value);

            console.groupCollapsed('%c[DELEGUE] 📤 Soumission formulaire', 'color:blue;font-weight:bold');
            if (!agentId || agentId === '') {
                console.error('%c[DELEGUE ERROR] ❌ Aucun agent délégué sélectionné ! (agentId vide)', 'color:red;font-weight:bold');
            } else {
                console.log('%c[DELEGUE] Agent délégué ID = ' + agentId, 'color:green');
            }

            if (permissionsChecked.length === 0) {
                console.warn('%c[DELEGUE WARN] ⚠️ Aucune permission cochée !', 'color:orange;font-weight:bold');
            } else {
                console.log('%c[DELEGUE] Permissions cochées (' + permissionsChecked.length + ') = ', 'color:green', permissionsChecked);
            }

            console.log('[DELEGUE] URL =', form.action, '| Méthode =', form.method);
            console.groupEnd();

            return true; // Laisser le formulaire se soumettre normalement
        });
    });
    </script>
    {{-- FIN DEBUG NON-BLOQUANT --}}

    <div class="modal fade" id="modal-change-photo-profil" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier la photo de profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.profil.updateAvatar') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="agent_id" value="{{ Auth::user()->agent->id }}">
                        <div class="form-group row g-3">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <div class="block-up-img w-100">
                                    <input type="file" id="file-img-profil" accept=".jpg,.png,.jpeg" name="image"
                                        required>
                                    <label for="file-img-profil" class="dashed" id="label-5">
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
                                            Cliquez pour télécharger la photo
                                        </p>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-img d-none">
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
                                                <p class="name-file"></p>
                                                <p class="pourc">
                                                    <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="reset" class="btn btn-cansel w-50"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-add mt-0 w-50"
                                    data-bs-dismiss="modal">Enregistrer</button>
                            </div>
                            {{-- <div class="mt-3 col-12 d-flex align-items-center justify-content-end mt-lg-4">
                                <a href="javascript:void(0)" class="btn me-4" data-bs-dismiss="modal" aria-label="Close"
                                    style="color: var(--colorTitre)">Annuler</a>
                                <button class="btn btn-add mt-0">Enregistrer</button>
                            </div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach (Auth::user()->agent?->created_documents()->groupBy('dossier_id') ?? [] as $key => $documentGroups)
        @php
            $dossier = \App\Models\Dossier::find($key);
        @endphp
        <div class="modal fade" id="modal-pass-dossier-{{ $dossier?->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Autorisation</h5>
                            <p>Veuillez saisir le mot de passe pour accéder au dossier</p>
                        </div>
                        <form action="{{ route('regidoc.dossiers.access') }}" method="POST">
                            @csrf
                            <div class="form-group row g-3 align-items-center">
                                <input type="hidden" name="dossier_id" id="" value="{{ $dossier?->id }}">
                                <div class="col-12 position-relative">
                                    <label for="password" class="mb-3">Mot de passe</label>
                                    <input type="password" class="form-control form-control-validation"
                                        placeholder="Mot de passe" name="password">
                                </div>
                                <div class="mt-2 col-12 d-flex justify-content-end">
                                    <button class="btn btn-add">{{ __('Accéder') }}</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
    <script>
        (function(){
            let signaturePadProfile = null;
            const previewImg = document.getElementById('signature-preview-img-profile');
            const previewBlock = document.getElementById('signature-preview-profile');
            const noSignatureText = document.getElementById('no-signature-profile');

            let currentColor = '#000000';
            let currentMethod = 'draw'; // 'draw' or 'import'
            let importedImageData = null;

            function initSignaturePad() {
                const canvas = document.getElementById('canvas_signature_pad_profile_page');
                if (!canvas) return;
                
                // Redimensionner le canvas pour sa taille réelle
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                const ctx = canvas.getContext('2d');
                ctx.scale(ratio, ratio);
                
                if (signaturePadProfile) {
                    signaturePadProfile.off();
                }

                signaturePadProfile = new SignaturePad(canvas, {
                    minWidth: 1.5,
                    maxWidth: 3.5,
                    penColor: currentColor
                });
            }

            // Gestionnaires pour le changement de méthode
            document.querySelectorAll('input[name="signature_method"]').forEach(input => {
                input.addEventListener('change', function() {
                    currentMethod = this.id === 'method-draw' ? 'draw' : 'import';
                    
                    const drawContainer = document.getElementById('draw-signature-container');
                    const importContainer = document.getElementById('import-signature-container');
                    
                    if (currentMethod === 'draw') {
                        drawContainer.classList.remove('d-none');
                        importContainer.classList.add('d-none');
                        setTimeout(initSignaturePad, 50);
                    } else {
                        drawContainer.classList.add('d-none');
                        importContainer.classList.remove('d-none');
                    }
                });
            });

            // Gestion de l'import d'image
            const inputImage = document.getElementById('input-signature-image');
            inputImage.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = function(event) {
                    importedImageData = event.target.result;
                    document.getElementById('signature-import-preview-img').src = importedImageData;
                    document.getElementById('image-upload-placeholder').classList.add('d-none');
                    document.getElementById('image-upload-preview').classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            });

            // Couleur du stylo
            const colorPicker = document.getElementById('signature-color');
            if (colorPicker) {
                colorPicker.value = currentColor;
                colorPicker.addEventListener('input', function(e) {
                    currentColor = e.target.value;
                    if (signaturePadProfile) {
                        signaturePadProfile.penColor = currentColor;
                    }
                });
            }

            document.addEventListener('shown.bs.modal', function (event) {
                if (event.target && event.target.id === 'modal-save-signature-profile') {
                    setTimeout(initSignaturePad, 100);
                }
            });

            function loadSignaturePreview() {
                fetch('/ajax/signatures/get/user/image', {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(async (res) => {
                    if (!res.ok) throw new Error('Erreur de chargement');
                    return res.json();
                })
                .then((data) => {
                    const src = data?.image_url || data?.image || '';
                    if (src) {
                        if (previewImg) previewImg.src = src;
                        if (previewBlock) previewBlock.classList.remove('d-none');
                        if (noSignatureText) noSignatureText.classList.add('d-none');
                    } else {
                        if (previewBlock) previewBlock.classList.add('d-none');
                        if (noSignatureText) noSignatureText.classList.remove('d-none');
                    }
                })
                .catch(() => {
                    if (previewBlock) previewBlock.classList.add('d-none');
                    if (noSignatureText) noSignatureText.classList.remove('d-none');
                });
            }

            window.addEventListener('load', loadSignaturePreview);

            document.addEventListener('shown.bs.tab', function (event) {
                if (event.target && event.target.id === 'signature-tab-btn') {
                    loadSignaturePreview();
                }
            });

            window.addEventListener('resize', function(){
                const modal = document.getElementById('modal-save-signature-profile');
                if (modal && modal.classList.contains('show') && currentMethod === 'draw') {
                    initSignaturePad();
                }
            });

            const clearBtn = document.getElementById('btn-clear-signature-profile');
            if (clearBtn) {
                clearBtn.addEventListener('click', function(){
                    if (signaturePadProfile) signaturePadProfile.clear();
                });
            }

            function csrfToken() {
                const meta = document.querySelector('meta[name="csrf-token"]');
                return meta ? meta.getAttribute('content') : '';
            }

            const saveBtn = document.getElementById('btn-save-signature-profile');
            if (saveBtn) {
                saveBtn.addEventListener('click', function(){
                    let imgData = null;
                    
                    if (currentMethod === 'draw') {
                        if (!signaturePadProfile || signaturePadProfile.isEmpty()) {
                            alert('Veuillez dessiner votre signature avant de l\'enregistrer.');
                            return;
                        }
                        imgData = signaturePadProfile.toDataURL('image/png');
                    } else {
                        if (!importedImageData) {
                            alert('Veuillez importer une image de votre signature.');
                            return;
                        }
                        imgData = importedImageData;
                    }

                    saveBtn.disabled = true;
                    saveBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Enregistrement...';

                    fetch('/ajax/signatures/save/user/image', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken(),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ image: imgData })
                    })
                    .then(async (res) => {
                        if (!res.ok) throw new Error('Erreur serveur');
                        return res.json();
                    })
                    .then((data) => {
                        const modalEl = document.getElementById('modal-save-signature-profile');
                        if (modalEl) {
                            const modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        }
                        loadSignaturePreview();
                    })
                    .catch((err) => {
                        console.error(err);
                        alert("Une erreur est survenue lors de l'enregistrement de la signature.");
                    })
                    .finally(() => {
                        saveBtn.disabled = false;
                        saveBtn.innerHTML = 'Enregistrer la signature';
                    });
                });
            }
        })();
    </script>
    <script>
        // Sécuriser l'ouverture du modal Signature en JS (au cas où l'attribut data-bs ne suffit pas)
        document.addEventListener('DOMContentLoaded', function(){
            const el = document.getElementById('modal-save-signature-profile');
            if (!el) return;
            const modal = new bootstrap.Modal(el);
            document.querySelectorAll('[data-bs-target="#modal-save-signature-profile"]').forEach(btn => {
                btn.addEventListener('click', function(e){
                    // Laisser Bootstrap gérer normalement mais forcer l'ouverture si nécessaire
                    setTimeout(() => {
                        if (!el.classList.contains('show')) {
                            modal.show();
                        }
                    }, 0);
                });
            });
        });
    </script>
    <script>
        // feather.replace()

        const nvFichier = document.getElementById('file-img-profil');
        const filename = document.querySelector('.list-file .name-file')
        console.log(filename);

        nvFichier.addEventListener('change', function() {
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
                    $('.col-img').removeClass('d-none')
                    $('#label-5').addClass('active')
                    filename.innerHTML = namefile;
                })
            }
        })
        $('.block-remove .btn-remove').click(function(e) {
            e.preventDefault()
            $(this).parent().parent().parent().parent().addClass('d-none')
            $('.col-img').addClass('d-none')
            $('#label-5').removeClass('active')
            $(nvFichier).val('');
        })

        $('#dga').on('change', function() {
            if (this.checked) {
                $('#autre_agent').attr('disabled', true);
            } else {
                $('#autre_agent').attr('disabled', false);
            }
        });
    </script>
@endsection
