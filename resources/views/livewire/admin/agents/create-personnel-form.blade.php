<div class="card card-table">
    <form action="{{ route('regidoc.personnels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row g-3">
            <div class="col-12">
                <h6 style="color: var(--colorTitre)">Informations personnelles</h6>
            </div>
            <div class="col-lg-2">
                <div class="avatar-user-modal" id="avatar-user-modal" wire:ignore>
                    <img src="{{ imageOrDefault('') }}" alt="photo de profil" id="img-profil-user">
                </div>
            </div>
            <div class="col-lg-10" wire:ignore>
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
                            Cliquez pour ajouter une photo de profil
                        </p>
                    </label>
                </div>
            </div>
            <div class="col-lg-6 mt-4">
                <input type="text" class="form-control" name="nom" placeholder="Nom" wire:model='nom' required>
            </div>
            <div class="col-lg-6 mt-4">
                <input type="text" class="form-control" name="post_nom" wire:model='post_nom' placeholder="Post-nom"
                    required>
            </div>
            <div class="col-lg-6">
                <input type="text" class="form-control" name="prenom" placeholder="Prénom" wire:model='prenom'>
            </div>
            <div class="col-lg-6">
                <select class="form-select form-control" name="sexe" wire:model='sexe'
                    aria-label="Default select example" required>
                    <option disabled selected value="">Sexe</option>
                    <option value="M">Masculin</option>
                    <option value="F">Féminin</option>
                </select>
            </div>
            {{-- <div class="col-lg-6">
                <input type="text" name="lieu_naiss" wire:model='lieu_naiss' class="form-control"
                    placeholder="lieu de naissance">
            </div>
            <div class="col-lg-6">
                <input type="date" name="date_naiss" wire:model='date_naiss' class="form-control"
                    placeholder="Date de naissance" max="{{ now()->subYear(17)->format('Y-m-d') }}"
                    min="{{ now()->subYear(80)->format('Y-m-d') }}">
            </div>

            <div class="col-lg-6">
                <input type="text" name="nationalite" wire:model='nationalite' class="form-control"
                    placeholder="Nationalité" required>
            </div>

            <div class="col-lg-6">
                <input type="text" name="province" wire:model='province' class="form-control"
                    placeholder="Province d'origine" required>
            </div>

            <div class="col-lg-6">
                <input type="text" name="ville" wire:model='ville' class="form-control"
                    placeholder="Ville d'origine" required>
            </div>

            <div class="col-lg-6">
                <select class="form-select form-control" name="etat_civil" wire:model='etat_civil'
                    aria-label="Default select example" required>
                    <option selected value="" value="">Etat civil</option>
                    <option value="Marié(e)">Marié(e)</option>
                    <option value="Célibataire">Célibataire</option>
                    <option value="Divorcé(e)">Divorcé(e)</option>
                    <option value="Veuf">Veuf(ve)</option>
                </select>
            </div>


            <div class="col-lg-6">
                <input type="number" name="nbr_enfants" wire:model='nbr_enfants' class="form-control"
                    placeholder="Nombre d'enfants" min={{ 0 }} required>
            </div>

            <div class="col-lg-6">
                <input type="tel" name="telephone" wire:model='telephone' class="form-control"
                    placeholder="Téléphone" required>
            </div>

            <div class="col-lg-12">
                <textarea name="adresse" class="form-control" placeholder="Adresse complete" id="" cols="30"
                    rows="3" required wire:model='adresse'></textarea>
            </div> --}}
            <div class="col-lg-6">
                <input type="text" name="matricule" wire:model='matricule' class="form-control"
                    placeholder="Matricule" required>
            </div>
            <div class="col-12">
                <h6 style="color: var(--colorTitre)">Informations d'authentification</h6>
            </div>
            <div class="col-lg-6">
                <input type="mail" name="newMail" class="form-control" wire:model.debounce.500ms='newMail' required>
            </div>
            {{-- <div class="col-lg-6">
                <input type="text" name="logo" class="form-control" value="@ regideso.cd" readonly required>
            </div> --}}
            {{-- <div class="col-lg-12">
                <small>Envoyer le nouveau mot de passe aux destinataires suivants</small>
                <input type="email" name="email" wire:model='email' class="form-control" placeholder="Email"
                    required>
            </div> --}}
            <div class="col-12">
                <h6 style="color: var(--colorTitre)">Informations professionnelles</h6>
            </div>
            {{-- <div class="col-lg-6">
                <select class="form-select form-control" name="type_contrat" aria-label="Default select example"
                    required>
                    <option selected value="" disabled>Type de contrat</option>
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
                <select class="form-select form-control" name="planning_id" aria-label="Default select example"
                    required>
                    <option selected value="" disabled>planning</option>
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
                        <select class="form-select form-control" name="devise" aria-label="Default select example"
                            required>
                            <option selected value="" disabled>Devise</option>
                            <option value="$">$</option>
                            <option value="fc">Fc</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <select class="form-select form-control" name="departement_id" aria-label="Default select example"
                    required>
                    <option selected value="" disabled>Département</option>
                    {{-- @foreach ($departements as $departement)
                        <option value="{{ $departement->id }}">{{ $departement->libelle }}</option>
                    @endforeach -}}
                </select>
            </div> --}}
            <div class="col-lg-4">
                <label for="">Lieu d'affectation</label>
                <select class="form-select form-control" name="lieu_id" aria-label="Default select example"
                    wire:model='lieu_id' required>
                    <option selected value="">Selectionnez </option>
                    @foreach ($lieus as $lieu)
                        <option value="{{ $lieu->id }}">{{ $lieu->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="">Direction</label>
                <select class="form-select form-control" name="direction_id" aria-label="Default select example"
                    wire:model='direction_id' required @disabled($isReadyOnly['direction'])>
                    <option selected value="">Selectionnez</option>
                    @foreach ($directions as $direction)
                        <option value="{{ $direction->id }}">{{ $direction->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="">Division</label>
                <select class="form-select form-control" name="division_id" wire:model="division_id"
                    aria-label="Default select example" @disabled($isReadyOnly['division'])>
                    <option selected value="">Selectionnez</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="">Service</label>
                <select class="form-select form-control" name="sevice_id"
                    wire:model='service_id'aria-label="Default select example" @disabled($isReadyOnly['service'])>
                    <option selected value="">Selectionnez</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="">Section</label>
                <select class="form-select form-control" name="section_id" wire:model="section_id"
                    aria-label="Default select example" @disabled($isReadyOnly['section'])>
                    <option selected value="">Selectionnez</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="">Grade</label>
                <select class="form-select form-control" name="grade_id" aria-label="Default select example">
                    <option selected value="">Selectionnez</option>
                    @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}">{{ $grade->titre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-4">
                <label for="">Type Fonction</label>
                <select class="form-select form-control" name="fonction_type" caria-label="Default select example"
                    wire:model='fonction_type' @disabled($isReadyOnly['fonction_type'])>
                    <option selected value="">Selectionnez</option>
                    <option selected value="6">Existante</option>
                    <option selected value="1">Directeur</option>
                    <option selected value="2">Chef</option>
                    <option selected value="3">Secretaire</option>
                    <option selected value="4">Assistant</option>
                    <option selected value="5">Autre</option>
                </select>
            </div>
            @if ($fonction_type == '1')
                <div class="col-lg-4">
                    <label for="">Directions</label>
                    <select class="form-select form-control" name="fonction" caria-label="Default select example"
                        @disabled($isReadyOnly['fonction'])>
                        <option selected value="">Selectionnez</option>
                        @foreach ($directions as $direction)
                            <option value="{{ $direction->titre }}">{{ $direction->titre }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif ($fonction_type == '3')
                <div class="col-lg-4">
                    <label for="">Secretaire de</label>
                    <select class="form-select form-control" name="sec_type" caria-label="Default select example"
                        wire:model='sec_type' @disabled($isReadyOnly['fonction_type'])>
                        <option selected value="">Selectionnez</option>
                        <option selected value="1">Direction</option>
                        <option selected value="2">Division</option>
                    </select>
                </div>
                @if ($sd)
                    <div class="col-lg-4">
                        <label for="">Directions</label>
                        <select class="form-select form-control" name="fonction" caria-label="Default select example"
                            @disabled($isReadyOnly['fonction_type'])>
                            <option selected value="">Selectionnez</option>
                            @foreach ($directions as $direction)
                                <option value="{{ $direction->titre }}">{{ $direction->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($sdv)
                    <div class="col-lg-4">
                        <label for="">Divisions</label>
                        <select class="form-select form-control" name="fonction" caria-label="Default select example"
                            @disabled($isReadyOnly['fonction_type'])>
                            <option selected value="">Selectionnez</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->libelle }}">{{ $division->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @elseif ($fonction_type == '2')
                <div class="col-lg-4">
                    <label for="">Chef de</label>
                    <select class="form-select form-control" name="chef_type" caria-label="Default select example"
                        wire:model='chef_type' @disabled($isReadyOnly['fonction_type'])>
                        <option selected value="">Selectionnez</option>
                        <option selected value="1">Division</option>
                        <option selected value="2">Service</option>
                        <option selected value="3">Section</option>
                    </select>
                </div>
                @if ($cd)
                    <div class="col-lg-4">
                        <label for="">Divisions</label>
                        <select class="form-select form-control" name="fonction" caria-label="Default select example"
                            @disabled($isReadyOnly['fonction'])>
                            <option selected value="">Selectionnez</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->libelle }}">{{ $division->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($csv)
                    <div class="col-lg-4">
                        <label for="">Services</label>
                        <select class="form-select form-control" name="fonction" caria-label="Default select example"
                            @disabled($isReadyOnly['fonction'])>
                            <option selected value="">Selectionnez</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}">{{ $service->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                @if ($csc)
                    <div class="col-lg-4">
                        <label for="">Section</label>
                        <select class="form-select form-control" name="fonction" caria-label="Default select example"
                            @disabled($isReadyOnly['fonction'])>
                            <option selected value="">Selectionnez</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @elseif ($fonction_type == '4')
                <div class="col-lg-4">
                    <label for="">Fonction</label>
                    <select class="form-select form-control" name="fonction" caria-label="Default select example"
                        @disabled($isReadyOnly['fonction'])>
                        <option selected value="">Selectionnez</option>
                        @foreach ($fonctions as $fonction)
                            <option value="{{ $fonction->titre }}">{{ $fonction->titre }}</option>
                        @endforeach
                    </select>
                </div>
            @elseif ($fonction_type == '5')
                <div class="col-lg-4">
                    <label for="">Fonction</label>
                    <input type="text" class="form-control" name="fonction" wire:model='fonction' />
                </div>
            @elseif ($fonction_type == '6')
                <div class="col-lg-4">
                    <label for="">Fonction</label>
                    <select class="form-select form-control" name="fonction_id" caria-label="Default select example">
                        <option selected value="">Selectionnez</option>
                        @foreach ($fonctions as $fonction)
                            <option value="{{ $fonction->id }}">{{ $fonction->titre }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="mb-3 col-lg-12 d-flex justify-content-end">
                <div class="col-lg-6 text-end">
                    <a href="/ressources-humaines/personnels" class="btn btn-cansel-create h-100 me-2">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-add">Créer</button>
                </div>
            </div>
        </div>
    </form>
</div>
