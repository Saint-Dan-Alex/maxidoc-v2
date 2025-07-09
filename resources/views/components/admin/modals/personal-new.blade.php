<div class="modal fade" id="modal-new-personnel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Ajouter un employé</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('regidoc.personnels.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row g-3">
                        <div class="col-12">
                            <h6>Informations personnelles</h6>
                        </div>
                        <div class="col-lg-2">
                            <div class="avatar-user-modal" id="avatar-user-modal">
                                <img src="{{ imageOrDefault('') }}" alt="photo de profil" id="img-profil-user">
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="block-up-img">
                                <input type="file" id="file-user-profil" accept=".jpg,.png" name="image">
                                <label for="file-user-profil" class="dashed" id="label-1">
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
                                        Cliquez pour uploader l'image de profil
                                    </p>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="post_nom" placeholder="Post-nom" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="prenom" placeholder="Prénom" required>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-select" name="sexe" aria-label="Default select example" required>
                                <option disabled selected="">Sexe</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="lieu_naiss" class="form-control"
                                placeholder="lieu de naissance">
                        </div>
                        <div class="col-lg-6">
                            <input type="date" name="date_naiss" class="form-control"
                                placeholder="Date de naissance">
                        </div>

                        <div class="col-lg-6">
                            <input type="text" name="nationalite" class="form-control" placeholder="Nationalité"
                                required>
                        </div>

                        <div class="col-lg-6">
                            <input type="text" name="province" class="form-control" placeholder="Province d'origine"
                                required>
                        </div>

                        <div class="col-lg-6">
                            <input type="text" name="ville" class="form-control" placeholder="Ville d'origine"
                                required>
                        </div>

                        <div class="col-lg-6">
                            <select class="form-select" name="etat_civil" aria-label="Default select example" required>
                                <option selected="" disabled>Etat civil</option>
                                <option value="Marié(e)">Marié(e)</option>
                                <option value="Célibataire">Célibataire</option>
                                <option value="Divorcé(e)">Divorcé(e)</option>
                                <option value="Veuf">Veuf(ve)</option>
                            </select>
                        </div>


                        <div class="col-lg-6">
                            <input type="number" name="nbr_enfants" class="form-control"
                                placeholder="Nombre d'enfants" min={{ 0 }} required>
                        </div>

                        <div class="col-lg-6">
                            <input type="tel" name="telephone" class="form-control" placeholder="Téléphone"
                                required>
                        </div>

                        <div class="col-lg-12">
                            <textarea name="adresse" class="form-control" placeholder="Adresse complete" id="" cols="30"
                                rows="3" required></textarea>
                        </div>

                        <div class="col-12">
                            <h6>Informations professionneles</h6>
                        </div>
                        {{-- <div class="col-lg-6">
                            <select class="form-select" name="type_contrat" aria-label="Default select example"
                                required>
                                <option selected="" disabled>Type de contrat</option>
                                @foreach ($typeContrats as $typeContrat)
                                    <option value="{{ $typeContrat->id }}">
                                        {{ $typeContrat->libelle }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class="col-lg-6">
                            <input type="text" name="date_contrat" class="form-control"
                                placeholder="Date debut du contrat" onfocus="(this.type='date')"
                                onblur="(this.type='text')" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="date_fin_contrat" class="form-control"
                                placeholder="Date de fin du contrat" onfocus="(this.type='date')"
                                onblur="(this.type='text')">
                        </div>
                        <div class="col-lg-6">
                            <select class="form-select" name="planning_id" aria-label="Default select example"
                                required>
                                <option selected="" disabled>planning</option>
                                @foreach ($plannings as $planning)
                                    <option value="{{ $planning->id }}">{{ $planning->libelle }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        {{-- <div class="col-lg-6">
                            <input type="number" name="temps" class="form-control" placeholder="Temps de travail"
                                required>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-8 pe-0">
                                    <input type="text" name="salaire" class="flex-grow form-control"
                                        placeholder="Salaire de base convenu" required>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" name="devise" aria-label="Default select example"
                                        required>
                                        <option selected="" disabled>Devise</option>
                                        <option value="$">$</option>
                                        <option value="fc">Fc</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <select class="form-select" name="departement_id" aria-label="Default select example"
                                required>
                                <option selected="" disabled>Département</option>
                                {{-- @foreach ($departements as $departement)
                                    <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                                @endforeach -}}
                            </select>
                        </div> --}}
                        <div class="col-lg-4">
                            <select class="form-select" name="direction_id" aria-label="Default select example"
                                required>
                                <option selected="" disabled>Direction</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}">{{ $direction->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-select" name="division_id" aria-label="Default select example"
                                required>
                                <option selected="" disabled>Division</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <select class="form-select" name="sevice_id" aria-label="Default select example"
                                required>
                                <option selected="" disabled>Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <select class="form-select" name="fonction_id" aria-label="Default select example"
                                required>
                                <option selected="" disabled>Fonction</option>
                                @foreach ($fonctions as $fonction)
                                    <option value="{{ $fonction->id }}">{{ $fonction->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="matricule" class="form-control" placeholder="Matricule"
                                required>
                        </div>
                        <div class="col-12">
                            <h6>Documents professionnels</h6>
                        </div>

                        <div class="col-lg-12">
                            <div class="block-up-img">
                                <input type="file" id="file-user" accept=".pdf" name="document">
                                <label for="file-user" class="dashed" id="label">
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
                                        Cliquez pour uploader le CV
                                    </p>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 d-none" id="col-hidden">
                            <ul class="list-file" id="list-file">
                                <li class="d-flex align-items-center">
                                    <div class="block-remove">
                                        <a href="#" class="btn btn-remove">
                                            <i class="fi fi-rr-trash"></i>
                                        </a>
                                    </div>
                                    <i class="bi bi-file-earmark"></i>
                                    <div class="block-detail">
                                        <div class="names">
                                            <p class="name-file">3c32af2f8db2... .jpg</p>
                                            <p class="pourc">
                                                <i class="bi bi-check-lg" style="font-size: 20px; color: #07c451"></i>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 d-none" id="col-hidden-1">
                            <label for="">Titre du fichier</label>
                            <input type="text" name="doc_titre" id="" class="form-control"
                                placeholder="Titre du fichier">
                        </div>
                        <div class="col-12">
                            <h6>Informations d'authentification</h6>
                        </div>

                        <div class="col-lg-12">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="col-lg-6">
                            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                                required>
                        </div>

                        <div class="col-lg-6">
                            <input type="password" name="password_confirm" class="form-control"
                                placeholder="Confirmez le mot de passe" required>
                        </div>

                        <div class="mb-3 col-lg-12 d-flex justify-content-end">
                            <div class="col-lg-6 text-end">
                                <button class="btn btn-add">Créer</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- end add user --}}

<div class="modal fade" id="modal-import-contact" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-modal="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Impoter données</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group row g-4">
                        <div class="col-lg-12">
                            <div class="drag-file">
                                <input type="file" accept=".xls, xlsx">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 801.19 537.98">
                                    <title>upload-file (blk)</title>
                                    <g id="Calque_2" data-name="Calque 2">
                                        <g id="Calque_1-2" data-name="Calque 1">
                                            <path
                                                d="M754.28,264.59A159.67,159.67,0,0,0,648.9,217.87c.58-.77,1.13-1.55,1.68-2.34A76.4,76.4,0,0,0,531.91,120,195.87,195.87,0,0,0,351.32,0C256.06,0,176.7,68,159.12,158.11,68.79,173.41,0,252,0,346.7,0,452.34,85.64,538,191.28,538c1.43,0,2.85,0,4.27-.05s2.82.05,4.24.05H642.14A161.47,161.47,0,0,0,796.75,415.41c.12-.47.23-.94.34-1.41a160.45,160.45,0,0,0-42.81-149.41ZM499.56,296.45c-5.09,11.64-15.11,15.75-27.19,15.78-13.62,0-27.23.24-40.84-.06-6.1-.14-8.07,2.22-8,8.13.27,16.07.1,32.13.1,51.47-.93,15.74,1.62,34.84-1.34,53.79-3.89,25-25.87,43.75-50.7,43.4a51.73,51.73,0,0,1-50.17-43.18c-1.85-10.85-1.11-21.72-1.19-32.58-.16-23.69-.35-47.38.12-71.06.16-8-2.58-10.36-10.31-10-12.77.54-25.58.22-38.37.11-11.93-.1-22.14-3.65-27.34-15.48-5.4-12.28-.77-22.17,8-30.91q49.93-49.95,100-99.87c12.27-12.17,26.86-12.3,39-.23q50.48,50,100.53,100.44C500.41,274.72,504.71,284.65,499.56,296.45Z">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <p>Uploader votre tableau ici</p>
                            </div>
                            <div class="mt-4 text-star">
                                <p style="font-size: 14px; color: var(--colorParagraph);">Upload files with extension
                                    .xcl</p>
                                <a href="#" class="download">Téléchager un model Excel</a>
                            </div>
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add">Importer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="detail-departement" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header" style="flex-direction: column;">
        <div class="d-flex justify-content-between w-100">
            <div class="text-star">
                <h5 id="offcanvasRightLabel" class="mb-1">Détails du département </h5>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Créé le: </span> 22 Jav 2022</p>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Par: </span> John Doe</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>


    </div>
    <div class="offcanvas-body">

        <div class="block-progress">
            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Dénomination
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Description
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>

            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Responsable
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>
            <div class="card card-notification card-campaing">
                <div class="d-flex justify-content-between">
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Nombre de divisions
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                    <div class="text-star">

                        <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                            Nombre d'agents
                        </h6>
                        <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="d-flex justify-content-end">
            <button class="btn">Modifier</button>
            <button class="btn">Supprimer</button>
        </div>
    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="detail-division" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header" style="flex-direction: column;">
        <div class="d-flex justify-content-between w-100">
            <div class="text-star">
                <h5 id="offcanvasRightLabel" class="mb-1">Détails de divison </h5>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Créé le: </span> 22 Jav 2022</p>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Par: </span> John Doe</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>


    </div>
    <div class="offcanvas-body">
        <div class="block-progress">
            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Dénomination
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Description
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>
            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Département
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Chef du département</h5>
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>


            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Nombre d'agents
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>

        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="d-flex justify-content-end">
            <button class="btn">Modifier</button>
            <button class="btn">Supprimer</button>
        </div>
    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="detail-fonction" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header" style="flex-direction: column;">
        <div class="d-flex justify-content-between w-100">
            <div class="text-star">
                <h5 id="offcanvasRightLabel" class="mb-1">Détails de divison </h5>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Créé le: </span> 22 Jav 2022</p>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Par: </span> John Doe</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>


    </div>
    <div class="offcanvas-body">
        <div class="block-progress">
            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Dénomination
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Description
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>



            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Nombre d'agents
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>

        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="d-flex justify-content-end">
            <button class="btn">Modifier</button>
            <button class="btn">Supprimer</button>
        </div>
    </div>

</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="detail-personnel" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header" style="flex-direction: column;">
        <div class="d-flex justify-content-between w-100">
            <div class="text-star">
                <h5 id="offcanvasRightLabel" class="mb-1">Détails du personnel </h5>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Créé le: </span> 22 Jav 2022</p>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block"
                        class="me-1">Par: </span> John Doe</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>


    </div>
    <div class="offcanvas-body">
        <div class="block-progress">
            <div class="card card-notification card-campaing">
                <h4 class="t-sm">Informations personnelles</h4>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="avatar-user">
                            <img src="http://127.0.0.1:8002/assets/img/team/1.jpg" alt="photo de profil">
                            <span class="etat unactive">Suspendu</span>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-star">

                            <p style="font-size: 12px;" class="mb-0">Nom complet</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Nom complet
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Lieu de naissance</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Lieu de naissance
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Date de naissance</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Date de naissance
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Province d'origine</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Province d'origine
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Ville d'origine</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Ville d'origine
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Etat civil</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Etat civil
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Nombre d'enfants</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Nombre d'enfants
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Adresse</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Adresse
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Téléphone</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Téléphone
                            </h6>
                        </div>
                        <div class="text-star">
                            <p style="font-size: 12px;" class="mb-0">Email</p>
                            <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                                Email
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-notification card-campaing">
                <h4 class="t-sm">Informations professionnelles</h4>
                <div class="text-star">

                    <p style="font-size: 12px;" class="mb-0">Fonction</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Fonction
                    </h6>
                </div>
                <div class="text-star">
                    <p style="font-size: 12px;" class="mb-0">Matricule</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Matricule
                    </h6>
                </div>
                <div class="text-star">
                    <p style="font-size: 12px;" class="mb-0">Département</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Département
                    </h6>
                </div>
                <div class="text-star">
                    <p style="font-size: 12px;" class="mb-0">Division</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Division
                    </h6>
                </div>
                <div class="text-star">
                    <p style="font-size: 12px;" class="mb-0">Niveau d'accès</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Niveau d'accès
                    </h6>
                </div>
                <div class="text-star">
                    <p style="font-size: 12px;" class="mb-0">Type de contrat</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Type de contrat
                    </h6>
                </div>
                <div class="text-star">
                    <p style="font-size: 12px;" class="mb-0">Salaire</p>
                    <h6 class="mb-0 date d-flex justify-content-between align-items-center">
                        Salaire
                    </h6>
                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="d-flex justify-content-end">
            <button class="btn">Modifier</button>
            <button class="btn">Supprimer</button>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-delete-contact" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center content-text">
                    <i data-feather="trash"></i>
                    <h5>Are you sure ?</h5>
                    <p>This action can't be undone.</p>
                </div>
                <div class="mb-3 block-btn d-flex justify-content-center">
                    <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                    <button class="btn btn-delete">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-suspend" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center content-text">
                    <i data-feather="power"></i>
                    <h5>Are you sure ?</h5>
                    <p>This action can't be undone.</p>
                </div>
                <div class="mb-3 block-btn d-flex justify-content-center">
                    <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                    <button class="btn btn-delete">Suspendre</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="modal-new-departement" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Créer un departement</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('regidoc.departements.store') }}" method="POST">
                    @csrf
                    <div class="form-group row g-4">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="nom" maxlength="25"
                                placeholder="Dénomination">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="description" maxlength="30"
                                placeholder="description">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" name="chef" maxlength="15"
                                placeholder="Reponsable du departement">
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add" type="submit">Créer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<div class="modal fade" id="modal-new-division" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Create contact</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group row g-4">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="First-name">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Last-name">
                        </div>
                        <div class="col-lg-12">
                            <input type="email" class="form-control" placeholder="Email adress">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Telephone">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Tag"
                                autocomplete="additional-name">
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-new-fonction" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                    <span>Create contact</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group row g-4">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="First-name">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Last-name">
                        </div>
                        <div class="col-lg-12">
                            <input type="email" class="form-control" placeholder="Email adress">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Telephone">
                        </div>
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Tag"
                                autocomplete="additional-name">
                        </div>
                        <div class="col-lg-12 text-end">
                            <button class="btn btn-add">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
