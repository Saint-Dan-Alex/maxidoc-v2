<div>
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex">
            <a href="{{ route('regidoc.home') }}" style="font-size: 14px; color: var(--colorTitle)" class="btn-back">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h4 class="ms-2">Créer un document </h4>
        </div>
        {{-- <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="dossier_id" value="{{ $dossier_id }}"> --}}
        <div class="body-siderbar">
            <div class="form-group row g-2" id="form-input">
                {{-- <div class="col-12">
                            <a href="{{ url()->previous() }}" style="font-size: 14px; color: var(--colorTitle)">
                                <i class="bi bi-arrow-left"></i>
                                Retour
                            </a>
                        </div> --}}

                {{-- <div class="col-12">
                            <div class="block-file block-import-doc">
                                <label>
                                    <i class="bi bi-file-text-fill me-2"></i>
                                    <p>Cliquer pour selectionner un modele</p>
                                    <i class="bi bi-plus-lg"></i>
                            </div>
                        </div> --}}

                {{-- <div class="mb-4 col-12 d-none block-col">
                            <ul class="list-file">
                                <li class="d-flex align-items-center">
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
                        </div> --}}

                <div class="col-12">
                    <h4 style="color: var(--colorTitre); font-size: 22px;"> {{ $template }} </h4>
                    <hr>
                    @if ($brouillon && Auth::id() == $brouillon->user_id)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert"
                            style="font-size: 13px; background: var(--bg-card); border: none;border-radius: 8px; color: var(--colorParagraph);border-left: 2px solid #df9d1e;">
                            <span class="d-flex align-items-center">
                                <i class="fi fi-rr-exclamation me-2" style="font-size: 16px; color: #df9d1e;"></i>
                                Remplissez les champs requis pour Générez un PDF
                            </span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                style="background: none">
                                <i class="fi fi-rr-cross" style="font-size: 12px"></i>
                            </button>
                        </div>
                    @endif
                    <h5 class="mb-0 title-info">Détails du Document</h5>
                </div>

                @if ($modele == 'template-1')
                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row" wire:ignore>
                            <label class="col-5 col-form-label">Destinataire {{-- $agent_id --}} </label>
                            <div class="col-7">
                                <select class="form-select form-control select2Agent" data-placeholder="Selectionner"
                                    name="agent_id" data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                    data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                    data-related-model="Agent">
                                    <option value="">Selectionnez un Agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"> {{ $agent->prenom . ' ' . $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Direction</label>
                            <div class="col-7" wire:ignore.self>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-1') required @endif wire:model='direction'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Division</label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-1') required @endif wire:model='division'>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" wire:ignore>
                        <div class="d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" id="sc" name="sc"
                                    class="echeance-toggle form-check-input">
                            </div>
                            <label for="permission-9" class="mb-0" style="font-size: 12px">
                                Signer sous couvert</label>
                        </div>
                    </div>
                    <div class="col-12 d-none" id="ssc" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Signé S/C de </label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-1') required @endif wire:model='section'>
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-1') required @endif wire:model='reference'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row">
                            <label class="col-5 col-form-label">A </label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-1') required @endif wire:model='directeur'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Lieu et date</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-1') required @endif wire:model='lieu_date'
                                    placeholder="ex : Kinshasa, 06/06/1960">
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-1'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Objet</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    wire:model="concerne" placeholder="Objet du document"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" wire:ignore>
                        <label class="form-label">Contenu</label>
                        <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self></textarea>
                    </div>
                @endif
                @if ($modele == 'template-2')
                    <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="ref" wire:model="reference"
                                    @if ($modele == 'template-2') required @endif @disabled(Auth::user()->agent->isSecretaire() == false)>
                            </div>
                        </div>
                    </div>
                    @if ($brouillon == null || ($brouillon && $brouillon->user_id == Auth::id()))
                        <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                            <div class="row">
                                <label class="col-5 col-form-label">Copie</label>
                                <div class="col-7" wire:ignore>
                                    <select class="form-select form-control selectCopie"
                                        aria-label="Default select example" name="copie[]" id="2"
                                        data-placeholder="Selectionner" multiple wire:model="copie"
                                        wire:change='changeCopie'>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                            <div class="row">
                                <label class="col-5 col-form-label">Lieu des personnes en copie</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="title"
                                        @if ($modele == 'template-2') required @endif wire:model='lieu_copie'>
                                </div>
                            </div>
                        </div>

                        <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                            <div class="row">
                                <label class="col-5 col-form-label">Destinataire</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="title"
                                        @if ($modele == 'template-2') required @endif wire:model='dest'>
                                </div>
                            </div>
                        </div>

                        <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                            <div class="row">
                                <label class="col-5 col-form-label">Ville</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="title"
                                        @if ($modele == 'template-2') required @endif wire:model='ville'
                                        placeholder="Ville">
                                </div>
                            </div>
                        </div>

                        <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                            <div class="row">
                                <label class="col-5 col-form-label">Lieu et date</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="title"
                                        @if ($modele == 'template-2') required @endif wire:model='lieu_date'
                                        placeholder="ex : Kinshasa, 30/06/1960">
                                </div>
                            </div>
                        </div>

                        <div @class(['col-12', 'd-none' => $modele != 'template-2'])>
                            <div class="row">
                                <label class="col-5 col-form-label">Objet</label>
                                <div class="col-7">
                                    <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                        wire:model="concerne" placeholder="Objet du document"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" wire:ignore>
                            <label class="form-label">Contenu</label>
                            <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self>
                                @if ($brouillon)
{{ session('body', '') }}
@endif
                            </textarea>
                        </div>
                    @endif
                @endif
                @if ($modele == 'template-3')
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Rue</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="rue" wire:model="rue"
                                    @if ($modele == 'template-3') required @endif />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Numéro</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="num" wire:model="num"
                                    @if ($modele == 'template-3') required @endif />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Boite Postal</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="bp" wire:model="bp"
                                    @if ($modele == 'template-3') required @endif />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Id National</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="idnat" wire:model="idnat"
                                    @if ($modele == 'template-3') required @endif />
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">N° Téléphone</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="phone" wire:model="phone"
                                    @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Email</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="email" wire:model="email"
                                    @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Impôt</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="impot" wire:model="impot"
                                    @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">N° Bon</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="bon" wire:model="bon"
                                    @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Fournisseur</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="fournisseur"
                                    wire:model="fournisseur" @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Date</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="date" wire:model="date"
                                    @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Location</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="location" wire:model="location"
                                    @if ($modele == 'template-3') required @endif>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($modele == 'template-5')
                    <div @class(['col-12', 'd-none' => $modele != 'template-5'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7">
                                <input type="text" class="form-control" placeholder="Référence" name="ref"
                                    @if ($modele == 'template-5') required @endif wire:model='reference'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-5'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataires</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control selectCopie"
                                    aria-label="Default select example" name="copie[]" id="2"
                                    data-placeholder="Selectionner" multiple wire:model="copie"
                                    wire:change='changeCopie'>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-5'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Concerne</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    wire:model="concerne" placeholder="Concerne du document"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" wire:ignore>
                        <label class="form-label">Contenu</label>
                        <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self></textarea>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-5'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Lieu et date</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-5') required @endif wire:model='lieu_date'
                                    placeholder="ex : Kinshasa, 06/06/1960">
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-5'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Signataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="exp_fonction"
                                    @if ($modele == 'template-5') required @endif wire:model='exp_fonction'
                                    placeholder="Fonction du Signataire">
                                <input type="text" class="form-control" name="exp_name"
                                    @if ($modele == 'template-5') required @endif wire:model='exp_name'
                                    placeholder="Nom du Signataire">
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-5'])>
                        <div class="row">
                            <label class="col-5 col-form-label">CoSignataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="dest_fonction"
                                    @if ($modele == 'template-5') required @endif wire:model='dest_fonction'
                                    placeholder="Fonction du CoSignataire">
                                <input type="text" class="form-control" name="dest_name"
                                    @if ($modele == 'template-5') required @endif wire:model='dest_name'
                                    placeholder="Nom du CoSignataire">
                            </div>
                        </div>
                    </div>
                @endif
                @if ($modele == 'template-6')
                    <div @class(['col-12', 'd-none' => $modele != 'template-6'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Siège</label>
                            <div class="col-7">
                                <input type="text" class="form-control" placeholder="Siège" name="siege"
                                    @if ($modele == 'template-6') required @endif wire:model='direction'>
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-6'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7">
                                <input type="text" class="form-control" placeholder="Référence" name="ref"
                                    @if ($modele == 'template-6') required @endif wire:model='reference'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-6'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Lieu et date</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-6') required @endif wire:model='lieu_date'
                                    placeholder="ex : Kinshasa, 06/06/1960">
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-6'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Concerne</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    wire:model="concerne" placeholder="Concerne du document"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" wire:ignore>
                        <label class="form-label">Contenu</label>
                        <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self></textarea>
                    </div>


                    <div @class(['col-12', 'd-none' => $modele != 'template-6'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Signataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="exp_fonction"
                                    @if ($modele == 'template-6') required @endif wire:model='exp_fonction'
                                    placeholder="Fonction du Signataire">
                                <input type="text" class="form-control" name="exp_name"
                                    @if ($modele == 'template-6') required @endif wire:model='exp_name'
                                    placeholder="Nom du Signataire">
                            </div>
                        </div>
                    </div>
                @endif
                @if ($modele == 'template-7')
                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-7') required @endif wire:model='reference'>
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Agent {{-- $agent_id --}} </label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control select2Agent" wire:model="agent_id"
                                    data-placeholder="Selectionner" name="agent_id"
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                    data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                    data-related-model="Agent">
                                    <option value="">Selectionnez un Agent</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"> {{ $agent->prenom . ' ' . $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Mission</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    wire:model="concerne" placeholder="Objet du document"></textarea>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Durée</label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-7') required @endif wire:model='direction'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Date de départ</label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-7') required @endif wire:model='date'>
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Financement</label>
                            <div class="col-7" wire:ignore>
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-7') required @endif wire:model='location'>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" wire:ignore>
                        <label class="form-label">Contenu</label>
                        <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self></textarea>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-7'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Lieu et date</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-7') required @endif wire:model='lieu_date'
                                    placeholder="ex : Kinshasa, 06/06/1960">
                            </div>
                        </div>
                    </div>
                    <div class="col-12" wire:ignore>
                        <div class="row">
                            <label class="col-5 col-form-label">Signataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="exp_fonction"
                                    @if ($modele == 'template-7') required @endif wire:model='exp_fonction'
                                    placeholder="Fonction du Signataire">
                                <input type="text" class="form-control" name="exp_name"
                                    @if ($modele == 'template-7') required @endif wire:model='exp_name'
                                    placeholder="Nom du Signataire">
                            </div>
                        </div>
                    </div>
                @endif
                @if ($modele == 'template-8')
                    <div @class(['col-12', 'd-none' => $modele != 'template-8'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Référence</label>
                            <div class="col-7">
                                <input type="text" class="form-control" placeholder="Référence" name="ref"
                                    @if ($modele == 'template-8') required @endif wire:model='reference'>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-8'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Destinataires</label>
                            <div class="col-7" wire:ignore>
                                <select class="form-select form-control selectCopie"
                                    aria-label="Default select example" name="copie[]" id="2"
                                    data-placeholder="Selectionner" multiple wire:model="copie"
                                    wire:change='changeCopie'>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-8'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Concerne</label>
                            <div class="col-7">
                                <textarea name="objet" id="" cols="30" rows="3" class="form-control" style="resize: none"
                                    wire:model="concerne" placeholder="Concerne du document"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-12" wire:ignore>
                        <label class="form-label">Contenu</label>
                        <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self></textarea>
                    </div>

                    <div @class(['col-12', 'd-none' => $modele != 'template-8'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Lieu et date</label>
                            <div class="col-7">
                                <input type="text" class="form-control" name="title"
                                    @if ($modele == 'template-8') required @endif wire:model='lieu_date'
                                    placeholder="ex : Kinshasa, 06/06/1960">
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-8'])>
                        <div class="row">
                            <label class="col-5 col-form-label">Signataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="exp_fonction"
                                    @if ($modele == 'template-8') required @endif wire:model='exp_fonction'
                                    placeholder="Fonction du Signataire">
                                <input type="text" class="form-control" name="exp_name"
                                    @if ($modele == 'template-8') required @endif wire:model='exp_name'
                                    placeholder="Nom du Signataire">
                            </div>
                        </div>
                    </div>
                    <div @class(['col-12', 'd-none' => $modele != 'template-8'])>
                        <div class="row">
                            <label class="col-5 col-form-label">CoSignataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="dest_fonction"
                                    @if ($modele == 'template-8') required @endif wire:model='dest_fonction'
                                    placeholder="Fonction du CoSignataire">
                                <input type="text" class="form-control" name="dest_name"
                                    @if ($modele == 'template-8') required @endif wire:model='dest_name'
                                    placeholder="Nom du CoSignataire">
                            </div>
                        </div>
                    </div>
                @endif

                @if ($modele == 'template-1' || $modele == 'template-2' || $modele == 'template-3' || $brouillon == null)
                    <div class="col-12">
                        <div class="row">
                            <label class="col-5 col-form-label">Signataire</label>
                            <div class="col-7">
                                <input type="text" class="mb-2 form-control" name="exp_fonction"
                                    @if ($modele == 'template-1' || $modele == 'template-2' || $modele == 'template-3' || $brouillon == null) required @endif wire:model='exp_fonction'
                                    placeholder="Fonction du Signataire" @readonly($brouillon && Auth::id() != $brouillon->user_id)>
                                <input type="text" class="form-control" name="exp_name"
                                    @if ($modele == 'template-1' || $modele == 'template-2' || $modele == 'template-3' || $brouillon == null) required @endif wire:model='exp_name'
                                    placeholder="Nom du Signataire" @readonly($brouillon && Auth::id() != $brouillon?->user_id)>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        @foreach ($cosignataires as $index => $cosignataire)
                            <div class="row">
                                <label class="col-5 col-form-label">CoSignataire {{ $index + 1 }}</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="dest_fonction"
                                        @if ($modele == 'template-1' || $modele == 'template-2' || $modele == 'template-3' || $brouillon == null) required @endif
                                        wire:model="cosignataires.{{ $index }}.dest_fonction"
                                        placeholder="Fonction du Cosignataire" @readonly($brouillon && Auth::id() != $brouillon->user_id)>
                                    <input type="text" class="form-control" name="dest_name"
                                        @if ($modele == 'template-1' || $modele == 'template-2' || $modele == 'template-3' || $brouillon == null) required @endif
                                        wire:model="cosignataires.{{ $index }}.dest_name"
                                        placeholder="Nom du Cosignataire" @readonly($brouillon && Auth::id() != $brouillon->user_id)>
                                    <a href="#" class="m-2 text-danger"
                                        wire:click.prevent="removeCosignataire({{ $index }})">
                                        <i class="fi fi-rr-trash"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($modele != 'template-7')
                        <div class="col-12">
                            <a href="javascript:void(0)" wire:click='addCosignataire' class="btn-plus-rounded"><i
                                    class="fi fi-rr-plus me-1" style="font-size: 12px"></i> Ajouter un signataire
                            </a>
                        </div>
                    @endif
                @endif
                @if ($brouillon)
                    <div class="col-12 d-flex align-items-space-between">
                        <div class="p-4 card card-dash">
                            <a href="javascript:void(0)" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasComment" aria-controls="offcanvasRight">
                                <span class="d-flex align-items-center">
                                    <i class="fi fi-rr-comment"></i> Annotations
                                </span>
                            </a>
                        </div>
                        <div class="p-4 card card-dash">
                            <a href="javascript:void(0)"class="btn " style="background: var(--bgContent)"
                                data-bs-toggle="modal" data-bs-target="#modal-new-annotation" class='dropdown-item'>
                                <i class="fi fi-rr-add"></i> Ajouter
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="footer-sidebar">
            {{-- @if ($brouillon != null && $brouillon->user_id != Auth::id())
                <a href="#" data-bs-toggle="modal" class="btn" style="background: var(--bgContent)"
                    data-bs-target="#modal-partage">Partager Brouillon</a>
            @endif
            @if (($brouillon && $brouillon->user->id == Auth::id()) || $brouillon == null)
                <button class="btn" style="background: var(--bgContent)" wire:click='saveBrouillon'
                    @disabled($complete == false)>Enregistrer Brouillon</button>
            @endif --}}
            {{-- <button class="btn btn-valid" id="btn-download" wire:click='generatePDF'
                @disabled($complete == false)>Générer</button>  Unikho --}}
            {{-- <button class="btn btn-valid" @disabled($complete)>Envoyer par courrier</button> --}}

            {{-- <button class="btn btn-valid" wire:click='generatePDF' @disabled($complete == false)>
                <span wire:loading.remove wire:target="generatePDF">
                    Générer
                </span>
                <span wire:loading wire:target="generatePDF">
                    <div class="spinner-border spinner-border-sm text-light" role="status">
                        <span class="visually-hidden">Génération en cours...</span>
                    </div> 
                </span>
            </button> --}}

            <button class="btn btn-valid" wire:click='previewPDF'>
                <span wire:loading.remove wire:target="previewPDF">Prévisualiser le PDF</span>
                <span wire:loading wire:target="previewPDF">
                    <div class="spinner-border spinner-border-sm text-light" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </span>
            </button>

        </div>
    </div>

    <div class="content-scanner">
        <div class="pt-5 pb-3 container-fluid ps-2" id="pdf-main-container">
            <div class="mb-4"></div>
            <div class="nav-tools-page" id="pdf-meta"
                style="position: fixed;top: 0;left: 470px;right: 0;width: calc(100vw - 470px);z-index: 3;">
                <div class="row align-items-center ms-0 w-100">
                    <div class="col-lg-4 ps-0">
                        @if ($brouillon)
                            <div class="name-file">
                                <div class="dropdown">
                                    <button class="mb-0 btn dropdown-toggle" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style="font-size: 12px; white-space: nowrap; color: var(--colorTitre); overflow: hidden; text-overflow: ellipsis; font-weight: 500 !important;">
                                        {{ $brouillon->nom . 'pdf' }}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-start"
                                        aria-labelledby="dropdownMenuButton1" style="">
                                        <li>
                                            <a class="dropdown-item btn-doc" href="javascript:void(0)"
                                                data-url="http://127.0.0.1:8000/storage/documents/August2023/LIDuQ0zejD9rNAvwWFag.pdf"
                                                data-name="atestations.pdf"
                                                wire:click="selectDoc([{&quot;download_link&quot;:&quot;documents\/August2023\/LIDuQ0zejD9rNAvwWFag.pdf&quot;,&quot;original_name&quot;:&quot;atestations.pdf&quot;}])">
                                                <i class="fi fi-rr-file me-1"></i>
                                                {{ $brouillon->nom . 'pdf' }}
                                            </a>
                                        </li>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="mx-auto tool-nav">
                            <div class="d-flex align-items-center justify-content-center">
                                <a href="javascript:void(0)" class="btn-signer btn-tools btn">
                                    <svg viewBox="0 0 24 24" width="512" height="512">
                                        <path
                                            d="M9,16h1.59c1.07,0,2.07-.42,2.83-1.17L23.12,5.12c.57-.57,.88-1.32,.88-2.12s-.31-1.55-.88-2.12c-1.17-1.17-3.07-1.17-4.24,0L9.17,10.59c-.76,.76-1.17,1.76-1.17,2.83v1.59c0,.55,.45,1,1,1ZM21.71,2.29c.19,.19,.29,.44,.29,.71s-.1,.52-.29,.71l-1.29,1.29-1.41-1.41,1.29-1.29c.39-.39,1.02-.39,1.41,0ZM10,13.41c0-.53,.21-1.04,.59-1.41l7-7,1.41,1.41-7,7c-.38,.38-.88,.59-1.41,.59h-.59v-.59Zm14,9.59c0,.55-.45,1-1,1-1.54,0-2.29-1.12-2.83-1.95-.5-.75-.75-1.05-1.17-1.05-.51,0-.9,.44-1.51,1.15-.7,.83-1.57,1.85-3.03,1.85s-2.32-1.03-3-1.87c-.58-.7-.96-1.13-1.46-1.13-.39,0-.63,.25-1.16,.91-.72,.88-1.71,2.09-3.84,2.09-2.76,0-5-2.24-5-5s2.24-5,5-5c.55,0,1,.45,1,1s-.45,1-1,1c-1.65,0-3,1.35-3,3s1.35,3,3,3c1.18,0,1.67-.6,2.29-1.36,.6-.73,1.34-1.64,2.71-1.64,1.47,0,2.32,1.03,3,1.87,.58,.7,.96,1.13,1.46,1.13s.9-.44,1.51-1.15c.7-.83,1.57-1.85,3.03-1.85s2.29,1.12,2.83,1.95c.5,.75,.75,1.05,1.17,1.05,.55,0,1,.45,1,1Z" />
                                    </svg>
                                    <div class="tooltip-indicator">
                                        Signer
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="btn-tampon btn-tools btn">
                                    <svg viewBox="0 0 24 24" width="512" height="512">
                                        <path
                                            d="M12,24c-1.626,0-3.16-.714-4.208-1.959-1.54,.176-3.127-.405-4.277-1.555-1.149-1.15-1.729-2.74-1.59-4.362-1.211-.964-1.925-2.498-1.925-4.124s.714-3.16,1.96-4.208c-.175-1.537,.405-3.127,1.555-4.277,1.15-1.15,2.737-1.733,4.361-1.59,.964-1.21,2.498-1.925,4.124-1.925s3.16,.714,4.208,1.959c1.542-.173,3.127,.405,4.277,1.555,1.149,1.15,1.729,2.74,1.59,4.362,1.211,.964,1.925,2.498,1.925,4.124s-.714,3.16-1.96,4.208c.175,1.537-.405,3.127-1.555,4.277-1.151,1.15-2.741,1.726-4.361,1.59-.964,1.21-2.498,1.925-4.124,1.925Zm-4.127-3.924c.561,0,1.081,.241,1.448,.676,.668,.793,1.644,1.248,2.679,1.248s2.011-.455,2.679-1.248c.403-.479,.99-.721,1.616-.67,1.034,.087,2.044-.28,2.776-1.012,.731-.731,1.1-1.743,1.012-2.776-.054-.624,.19-1.213,.67-1.617,.792-.667,1.247-1.644,1.247-2.678s-.455-2.011-1.247-2.678c-.479-.403-.724-.993-.67-1.617,.088-1.033-.28-2.045-1.012-2.776s-1.748-1.094-2.775-1.012c-.626,.056-1.214-.191-1.617-.669-.668-.793-1.644-1.248-2.679-1.248s-2.011,.455-2.679,1.248c-.404,.479-.993,.719-1.616,.67-1.039-.09-2.044,.28-2.776,1.012-.731,.731-1.1,1.743-1.012,2.776,.054,.624-.19,1.213-.67,1.617-.792,.667-1.247,1.644-1.247,2.678s.455,2.011,1.247,2.678c.479,.403,.724,.993,.67,1.617-.088,1.033,.28,2.045,1.012,2.776,.732,.731,1.753,1.095,2.775,1.012,.057-.005,.113-.007,.169-.007Zm4.928-4.941l4.739-4.568c.397-.383,.409-1.017,.025-1.414-.383-.397-1.016-.409-1.414-.026l-4.752,4.581c-.391,.391-1.022,.391-1.44-.025l-2.278-2.117c-.402-.375-1.036-.353-1.413,.052-.376,.404-.353,1.037,.052,1.413l2.252,2.092c.586,.586,1.357,.879,2.126,.879,.765,0,1.526-.289,2.104-.866Z" />
                                    </svg>
                                    <div class="tooltip-indicator">
                                        Tampon
                                    </div>
                                </a>
                                <a href="#" class="btn-tools btn">
                                    <svg viewBox="0 0 24 24" width="512" height="512">
                                        <path
                                            d="M9,12c3.309,0,6-2.691,6-6S12.309,0,9,0,3,2.691,3,6s2.691,6,6,6Zm0-10c2.206,0,4,1.794,4,4s-1.794,4-4,4-4-1.794-4-4,1.794-4,4-4Zm1.75,14.22c-.568-.146-1.157-.22-1.75-.22-3.86,0-7,3.14-7,7,0,.552-.448,1-1,1s-1-.448-1-1c0-4.962,4.038-9,9-9,.762,0,1.519,.095,2.25,.284,.535,.138,.856,.683,.719,1.218-.137,.535-.68,.856-1.218,.719Zm12.371-4.341c-1.134-1.134-3.11-1.134-4.243,0l-6.707,6.707c-.755,.755-1.172,1.76-1.172,2.829v1.586c0,.552,.448,1,1,1h1.586c1.069,0,2.073-.417,2.828-1.172l6.707-6.707c.567-.567,.879-1.32,.879-2.122s-.312-1.555-.878-2.121Zm-1.415,2.828l-6.708,6.707c-.377,.378-.879,.586-1.414,.586h-.586v-.586c0-.534,.208-1.036,.586-1.414l6.708-6.707c.377-.378,1.036-.378,1.414,0,.189,.188,.293,.439,.293,.707s-.104,.518-.293,.707Z" />
                                    </svg>

                                    <div class="tooltip-indicator">
                                        Initiale
                                    </div>
                                </a>
                                <a href="#" class="btn-tools btn">
                                    <svg viewBox="0 0 24 24" width="512" height="512">
                                        <path
                                            d="M19,2h-1V1c0-.552-.448-1-1-1s-1,.448-1,1v1H8V1c0-.552-.448-1-1-1s-1,.448-1,1v1h-1C2.243,2,0,4.243,0,7v12c0,2.757,2.243,5,5,5h4c.552,0,1-.448,1-1s-.448-1-1-1H5c-1.654,0-3-1.346-3-3V10H23c.552,0,1-.448,1-1v-2c0-2.757-2.243-5-5-5Zm3,6H2v-1c0-1.654,1.346-3,3-3h14c1.654,0,3,1.346,3,3v1Zm-3.121,4.879l-5.707,5.707c-.755,.755-1.172,1.76-1.172,2.829v1.586c0,.552,.448,1,1,1h1.586c1.069,0,2.073-.417,2.828-1.172l5.707-5.707c.567-.567,.879-1.32,.879-2.122s-.312-1.555-.878-2.121c-1.134-1.134-3.11-1.134-4.243,0Zm2.828,2.828l-5.708,5.707c-.377,.378-.879,.586-1.414,.586h-.586v-.586c0-.534,.208-1.036,.586-1.414l5.708-5.707c.377-.378,1.036-.378,1.414,0,.189,.188,.293,.439,.293,.707s-.104,.518-.293,.707Zm-16.707-1.707c0-.552,.448-1,1-1h7c.552,0,1,.448,1,1s-.448,1-1,1H6c-.552,0-1-.448-1-1Zm6,4c0,.552-.448,1-1,1H6c-.552,0-1-.448-1-1s.448-1,1-1h4c.552,0,1,.448,1,1Z" />
                                    </svg>
                                    <div class="tooltip-indicator">
                                        Date de signature
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        @if ($brouillon)
                            <div class="block-intervenant">
                                <div class="content-intervenant d-flex align-items-center justify-content-end">
                                    @foreach ($brouillon->agents as $agent)
                                        <div class="avatar-intervenant">
                                            <div class="tooltip-team">
                                                {{ $agent->prenom . ' ' . $agent->nom }}
                                            </div>
                                            <img src="{{ imageOrDefault($agent->image) }}"
                                                alt="image de.{{ $agent->nom . ' ' . $agent->prenom }} ">
                                        </div>
                                    @endforeach

                                    {{-- <div class="dropdown">
                                        <div class="avatar-intervenant plus d-flex align-items-center justify-content-center"
                                            data-bs-toggle="dropdown" aria-expanded="false" style="margin-right: 0">
                                            <span>
                                                9+
                                            </span>
                                        </div>
                                        <div class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton2">
                                            <div class="list-users">
                                                <div class="content-user d-flex align-items-center">
                                                    <div class="avatar" style="flex: 0 0 auto">
                                                        <img src="{{ asset('assets/regidoc/default.png') }}"
                                                            alt="image de ">
                                                    </div>
                                                    <div class="name">
                                                        John Doe
                                                    </div>
                                                </div>
                                                <div class="content-user d-flex align-items-center">
                                                    <div class="avatar" style="flex: 0 0 auto">
                                                        <img src="{{ asset('assets/regidoc/default.png') }}"
                                                            alt="image de ">
                                                    </div>
                                                    <div class="name">
                                                        John Doe
                                                    </div>
                                                </div>
                                                <div class="content-user d-flex align-items-center">
                                                    <div class="avatar" style="flex: 0 0 auto">
                                                        <img src="{{ asset('assets/regidoc/default.png') }}"
                                                            alt="image de ">
                                                    </div>
                                                    <div class="name">
                                                        John Doe
                                                    </div>
                                                </div>
                                                <div class="content-user d-flex align-items-center">
                                                    <div class="avatar" style="flex: 0 0 auto">
                                                        <img src="{{ asset('assets/regidoc/default.png') }}"
                                                            alt="image de ">
                                                    </div>
                                                    <div class="name">
                                                        John Doe
                                                    </div>
                                                </div>
                                                <div class="content-user d-flex align-items-center">
                                                    <div class="avatar" style="flex: 0 0 auto">
                                                        <img src="{{ asset('assets/regidoc/default.png') }}"
                                                            alt="image de ">
                                                    </div>
                                                    <div class="name">
                                                        John Doe
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
            {{-- <div class="block-letter">
                @livewire('document.document-modele')
            </div> --}}
            @if ($modele)
                @if ($modele == 'template-1')
                    @include('regidoc.pages.templates.template-1')
                @endif
                @if ($modele == 'template-2')
                    @include('regidoc.pages.templates.template-2', [
                        'brouillon' => $brouillon ? true : false,
                    ])
                @endif
                @if ($modele == 'template-3')
                    @include('regidoc.pages.templates.template-3')
                @endif
                @if ($modele == 'template-4')
                    @include('regidoc.pages.templates.template-4')
                @endif
                @if ($modele == 'template-5')
                    @include('regidoc.pages.templates.template-5')
                @endif
                @if ($modele == 'template-6')
                    @include('regidoc.pages.templates.template-6')
                @endif
                @if ($modele == 'template-7')
                    @include('regidoc.pages.templates.template-7')
                @endif
                @if ($modele == 'template-8')
                    @include('regidoc.pages.templates.template-8')
                @endif
            @else
                <div class="block-no-file">
                    <i class="bi bi-file-x"></i>
                    <h4>Aucun aperçu !</h4>
                    <p>Veuillez uploader un fichier</p>
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="modal-partage" data-bs-backdrop="static" wire:ignore data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-2 pt-2 pb-2 modal-body px-lg-4 pb-lg-4">
                    <div class="d-flex align-items-center w-100 badge-xxl green">
                        <span class="icon-circle-check" style="flex: 0 0 auto">
                            <i class="text-white fi fi-rr-check"></i>
                        </span>
                        <p>
                            En Partageant ce document, vous êtes donnez la possibilité à la personne le droit de le
                            modifier
                        </p>
                    </div>
                    <div class="col-12">
                        <select name="agent_id" id="agent_id" class="form-select form-control"
                            aria-label="Default select example" wire:model='participant_id'>
                            @foreach ($agents as $agent)
                                <option value="{{ $agent->id }}"> {{ $agent->prenom . ' ' . $agent->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-lg-3 g-2">
                        {{-- <div class="col-6">
                            <button id="download" class="btn btn-action-doc d-flex flex-column h-100">
                                <i class="fi fi-rr-download"></i>
                                Télécharger dans votre Ordinateur
                            </button>
                        </div>
                        <div class="col-6">
                            <button id="save" class="btn btn-action-doc d-flex flex-column h-100"><i
                                    class="fi fi-rr-folder-download"></i>Enregistrer dans vos documents</button>
                        </div>
                        <div class="col-6">
                            <button id="sendCourrier" class="btn btn-action-doc d-flex flex-column h-100"><i
                                    class="fi fi-rr-paper-plane"></i>Joindre à un nouveau Courrier</button>
                        </div> --}}
                        <a href="#" class="text-center btn" wire:click='sendBrouillon'>Partager</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-new-annotation" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog" wire:ignore>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Annotation</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-2">
                        <div class="col-lg-12">
                            <textarea name="note" id="" cols="30" rows="5" class="form-control" wire:model='comment'
                                placeholder="Saisissez vos annotations ici"></textarea>
                        </div>
                    </div>
                    <div class="mt-3 from-group row">
                        <div class="mb-3 col-lg-12 text-end">
                            <button type="reset" class="btn btn-cansel" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="mt-0 btn btn-add" wire:click='saveComment'
                                data-bs-dismiss="modal">Enregistrer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComment" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Commentaires</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="all-comments" style="overflow: hidden; height: auto!important;">
                <div class="block-scroll" id="tache-commentaires">
                    @if ($brouillon)
                        @forelse ($brouillon->commentaires as $comment)
                            <div class="block-comment commentaires">
                                <div class="block-info-comment d-flex">
                                    <div class="avatar-comment commentaires">
                                        <img src="{{ imageOrDefault($comment->user->agent->image) }}"
                                            alt="Photo profil">
                                    </div>
                                    <div class="name-comment commentaires">
                                        <h6 class="mb-0">
                                            {{ $comment->user->agent->prenom . ' ' . $comment->user->agent->nom }}
                                            <span> - {{ $comment->user->agent->direction->titre }}</span>
                                        </h6>
                                        <p>{{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 comment commentaires">
                                    {!! $comment->message !!}
                                </div>
                            </div>
                        @endforelse
                    @endif

                    @empty($brouillon)
                        <div class="h-100 d-flex justify-content-center align-items-center">
                            <h2 class="text-sm text-center text-secondary">Aucun Commentaire sur cette tâche</h2>
                        </div>
                    @endempty

                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script src="{{ asset('assets/js/ckbox/ckeditor.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $('.block-body').on('input', function(e) {
            var maxHeight = $(this).data('maxheight');
            var signatureMaxHeight = $(this).data('signatureheight');
            var height = 0;
            var withFooter = false;

            $(this).css('max-height', maxHeight);

            if (signatureMaxHeight > 0) {
                height = signatureMaxHeight;
                withFooter = true;
            } else {
                height = maxHeight;
                withFooter = false;
            }

            var positionIndex = $(this).parent().index();

            console.log(this.clientHeight, height, this.clientHeight >= height);
            if (this.clientHeight >= height) {
                if ($(this).parent()[0].nextElementSibling === null) {
                    if (withFooter) {
                        addPage($(this).parent().find('.block-signature'));
                        $(this).parent().find('.block-signature').remove();
                    } else {
                        addPage();
                    }
                }
            } else {
                if ($('.inner-letter').length > 1) {
                    removePage(positionIndex + 1);
                }
            }


        });

        $('.block-body').on('keydown', function(e) {
            var maxHeight = $(this).data('maxheight');
            var signatureMaxHeight = $(this).data('signatureheight');
            var height = 0;
            var withFooter = false;

            if (signatureMaxHeight > 0) {
                height = signatureMaxHeight;
                withFooter = true;
            } else {
                height = maxHeight;
                withFooter = false;
            }

            var positionIndex = $(this).parent().index();

            if (e.which !== 8) {
                if (this.clientHeight >= maxHeight) {
                    var nextPage = $(this).parent()[0].nextElementSibling;
                    window.scrollTo(0, nextPage.scrollHeight);
                    $(nextPage).find('.block-body').html('<p></p>');
                    $(nextPage).find('.block-body').focus();
                    var paragraph = $(nextPage).find('.block-body p')[0];
                    // Create a range and set its start and end positions
                    var range = document.createRange();
                    range.selectNodeContents(paragraph);

                    // Create a selection and add the range to it
                    var selection = window.getSelection();
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
            }

            if (positionIndex > 1) {
                console.log(e.which);
                if (e.which === 8) {
                    // Check if the text is empty
                    if ($(this).text().trim() === '') {
                        // Move focus to the previous div
                        var prevPage = $(this).parent()[0].previousElementSibling;
                        $(prevPage).find('.block-body').focus();

                        var paragraph = $(prevPage).find('.block-body p').last()[0];
                        console.log(paragraph);
                        // Create a range and set its start and end positions
                        var range = document.createRange();
                        range.selectNodeContents(paragraph);

                        // Create a selection and add the range to it
                        var selection = window.getSelection();
                        selection.removeAllRanges();
                        selection.addRange(range);

                        // Prevent the Backspace key from deleting content
                        // event.preventDefault();
                    }
                }
            }
        });

        $('.block-body').on('paste', function(event) {
            // Prevent the default paste behavior
            event.preventDefault();

            var maxHeight = $(this).data('maxheight');
            var signatureMaxHeight = $(this).data('signatureheight');
            var height = 0;
            var withFooter = false;

            $(this).css('max-height', maxHeight);

            if (signatureMaxHeight > 0) {
                height = signatureMaxHeight;
                withFooter = true;
            } else {
                height = maxHeight;
                withFooter = false;
            }

            // Get the clipboard data
            var clipboardData = (event.originalEvent || event).clipboardData;
            var pastedText = clipboardData.getData('text/plain');

            // Check if the pasted text exceeds the max height
            console.log(this.scrollHeight, this.offsetHeight);

            if (this.scrollHeight + 20 < this.offsetHeight + height) {
                // Append the pasted text to the current div
                $(this).append(pastedText);
            } else {
                // Calculate how much text can fit in the current div
                var remainingSpace = this.offsetHeight + height - this.scrollHeight;

                // Split the pasted text
                var textToAdd = pastedText.substring(0, remainingSpace);

                // Append the text to the current div
                $(this).append(textToAdd);

                // Create a new div for the remaining text
                var newDiv = null;
                if ($(this).parent()[0].nextElementSibling === null) {
                    if (withFooter) {
                        addPage($(this).parent().find('.block-signature'));
                        $(this).parent().find('.block-signature').remove();
                    } else {
                        addPage();
                    }
                }

                var nexPage = $(this).parent()[0].nextElementSibling;
                newDiv = $(nexPage).find('.block-body');

                // Append the remaining text to the new div
                newDiv.text(pastedText.substring(remainingSpace));

                // Insert the new div after the current div
                $(this).after(newDiv);
            }
        });


        // add page
        function addPage(element = undefined) {
            var template = $('#page-template');
            var newPage = template.clone(true);
            var parent = $('.block-letter > div');
            var newId = 'page' + ($('.inner-letter').length + 1);
            newPage.removeClass('d-none');
            newPage.addClass('inner-letter');
            newPage.attr('id', newId);
            newPage.find('.block-body').html('');

            if (element[0] !== undefined) {
                // append element after .block-body
                newPage.append(element);
            }

            parent.append(newPage);
        }

        // remove page
        function removePage(id) {
            var currentPage = $('#page' + id);
            var prevPage = $('#page' + (id - 1));

            var signatureElement = currentPage.find('.block-signature');
            if (signatureElement.length > 0) {
                prevPage.append(signatureElement);
            }

            currentPage.remove();
        }
    </script>
    <script>
        let editor = null;
        let isDirty = false;

        // This sample still does not showcase all CKEditor 5 features (!)
        // Visit https://ckeditor.com/docs/ckeditor5/latest/features/index.html to browse all the features.
        ClassicEditor.create(document.getElementById("editor"), {
                // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html#extended-toolbar-configuration-format
                toolbar: {
                    items: [
                        // 'exportPDF', 'exportWord', '|',
                        // 'findAndReplace', 'selectAll', '|',
                        'undo', 'redo',
                        // 'heading', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                        'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript',
                        'removeFormat', '|',
                        'bulletedList', 'numberedList', 'todoList', '|',
                        'outdent', 'indent', '|',
                        // '-',
                        'alignment',
                        // '|',
                        // 'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'htmlEmbed',
                        // '|',
                        // 'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                        // 'textPartLanguage', '|',
                        // 'sourceEditing'
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
                            '@apple', '@bears', '@brownie', '@cake', '@cake', '@candy', '@canes',
                            '@chocolate', '@cookie', '@cotton', '@cream',
                            '@cupcake', '@danish', '@donut', '@dragée', '@fruitcake', '@gingerbread',
                            '@gummi', '@ice', '@jelly-o',
                            '@liquorice', '@macaroon', '@marzipan', '@oat', '@pie', '@plum', '@pudding',
                            '@sesame', '@snaps', '@soufflé',
                            '@sugar', '@sweet', '@topping', '@wafer'
                        ],
                        minimumCharacters: 1
                    }]
                },
                // plugins = [
                //     Essentials,
                //     UploadAdapter,
                //     Autoformat,
                //     Bold,
                //     Italic,
                //     BlockQuote,
                //     EasyImage,
                //     Heading,
                //     Image,
                //     ImageCaption,
                //     ImageStyle,
                //     ImageToolbar,
                //     ImageUpload,
                //     Link,
                //     List,
                //     Paragraph,
                //     Alignment // <--- ADDED
                // ],
                language: 'fr',
                // The "super-build" contains more premium features that require additional configuration, disable them below.
                // Do not turn them on unless you read the documentation and know how to configure them and setup the editor.
                // removePlugins: [
                //     // These two are commercial, but you can try them out without registering to a trial.
                //     // 'ExportPdf',
                //     // 'ExportWord',
                //     'CKBox',
                //     'CKFinder',
                //     'EasyImage',
                //     // This sample uses the Base64UploadAdapter to handle image uploads as it requires no configuration.
                //     // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/base64-upload-adapter.html
                //     // Storing images as Base64 is usually a very bad idea.
                //     // Replace it on production website with other solutions:
                //     // https://ckeditor.com/docs/ckeditor5/latest/features/images/image-upload/image-upload.html
                //     // 'Base64UploadAdapter',
                //     'RealTimeCollaborativeComments',
                //     'RealTimeCollaborativeTrackChanges',
                //     'RealTimeCollaborativeRevisionHistory',
                //     'PresenceList',
                //     'Comments',
                //     'TrackChanges',
                //     'TrackChangesData',
                //     'RevisionHistory',
                //     'Pagination',
                //     'WProofreader',
                //     // Careful, with the Mathtype plugin CKEditor will not load when loading this sample
                //     // from a local file system (file://) - load this site via HTTP server if you enable MathType.
                //     'MathType',
                //     // The following features are part of the Productivity Pack and require additional license.
                //     'SlashCommand',
                //     'Template',
                //     'DocumentOutline',
                //     'FormatPainter',
                //     'TableOfContents'
                // ],

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
                @this.set('body', editor.getData())
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('.selectCopie').select2({
                tags: true,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                width: '100%',
            });

            $('.selectCopie').on('change', function(e) {
                var data = $(this).val();
                @this.set('copie', data);
            });
            var checkbox = $('#sc');
            var secondDiv = $('#ssc');
            // console.log(secondDiv);

            checkbox.change(function() {
                if (checkbox.is(':checked')) {
                    secondDiv.removeClass('d-none');
                } else {
                    secondDiv.addClass('d-none');
                }
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        bootstrap.Modal.prototype.enforceFocus = function() {
            $(document)
                .off('focusin.bs.modal') // guard against infinite focus loop
                .on('focusin.bs.modal', $.proxy(function(e) {
                    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                        this.$element.focus()
                    }
                }, this))
        }

        $('.select2').select2({
            tags: $(this).data('tags') ? $(this).data('tags') : false,
            placeholder: $(this).data('placeholder'),
            language: "fr",
            maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
            width: "100%",
            dropdownParent: $('#modal-action-save')
        });

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        // const canvas = document.getElementById("canvas_signature_pad");
        // const signaturePad = new SignaturePad(canvas);
        // signaturePad.penColor = $('select[name="color"]').val();

        // function resizeCanvas() {
        //     const ratio = Math.max(window.devicePixelRatio || 1, 1);
        //     canvas.width = canvas.offsetWidth * ratio;
        //     canvas.height = canvas.offsetHeight * ratio;
        //     canvas.getContext("2d").scale(ratio, ratio);
        //     // signaturePad.clear();
        //     // otherwise isEmpty() might return incorrect value
        // }

        // window.addEventListener("resize", resizeCanvas);
        // resizeCanvas();

        // $('select[name="color"]').on('change', function() {
        //     signaturePad.penColor = $(this).val();
        // });

        // $('.clear-canevas').on('click', function() {
        //     signaturePad.clear();
        // });

        $('.btn-close').click(function() {
            $('.signature.dropped-true.active').removeClass('active');
            $('.modal-signature').css({
                width: '0px'
            });
        })

        // const input = document.getElementById('file-img');
        // const img = document.getElementById('sign-img');
        // const img_block = document.getElementById('img_block');

        // input.addEventListener('change', () => {
        //     const file = input.files[0];
        //     const reader = new FileReader();

        //     reader.addEventListener('load', () => {
        //         img.src = reader.result;
        //         img_block.classList.remove('d-none');
        //     });

        //     reader.readAsDataURL(file);
        // })

        // // Initialize pdf.js
        // const pdfjsLib = window['pdfjs-dist/build/pdf'];

        // Initialize pdf-lib
        // const {
        //     PDFDocument,
        //     rgb
        // } = PDFLib;

        let __PDF_DOC,
            __CURRENT_PAGE,
            __TOTAL_PAGES,
            __PAGE_RENDERING_IN_PROGRESS = 0;

        // showPDF(url);

        // function showPDF(pdf_url) {
        //     $("#pdf-loader").show();

        //     PDFJS.getDocument({
        //         url: pdf_url
        //     }).then(function(pdf_doc) {
        //         __PDF_DOC = pdf_doc;
        //         __TOTAL_PAGES = __PDF_DOC.numPages;

        //         // Hide the pdf loader and show pdf container in HTML
        //         $("#pdf-loader").hide();
        //         $("#pdf-contents").show();
        //         $("#pdf-total-pages").text(__TOTAL_PAGES);

        //         for (var i = 1; i <= __TOTAL_PAGES; i++) {

        //             var pdfPage = document.createElement('div');
        //             pdfPage.classList.add('pdf-page');
        //             pdfPage.setAttribute('id', 'page-' + i);

        //             var canvas = document.createElement('canvas');
        //             // canvas.setAttribute('width', '595px');
        //             canvas.setAttribute('data-page', i);
        //             canvas.classList.add('pdf-canvas');
        //             canvas.classList.add('mb-2');
        //             $(pdfPage).append(canvas);

        //             var textLayer = document.createElement('div');
        //             textLayer.classList.add('text-layer');
        //             $(pdfPage).append(textLayer);

        //             var annotationLayer = document.createElement('div');
        //             annotationLayer.classList.add('annotationLayer');
        //             $(pdfPage).append(annotationLayer);

        //             var loader = document.createElement('div');
        //             loader.classList.add('page-loader');
        //             loader.classList.add('page-' + i);

        //             var loaderIcon = document.createElement('img');
        //             loaderIcon.src = "{{ asset('assets/images/loader.svg') }}";
        //             $(loader).append(loaderIcon);

        //             $(pdfPage).append(loader);

        //             $('#pdf-contents').append(pdfPage);

        //             var vignettePage = document.createElement('div');
        //             vignettePage.classList.add('vignette-page');

        //             var vignetteLink = document.createElement('a');
        //             vignetteLink.setAttribute('href', '#page-' + i);

        //             var vignetteCanvas = document.createElement('canvas');
        //             vignetteCanvas.setAttribute('width', '140px');
        //             vignetteCanvas.classList.add('mb-2');

        //             $(vignetteLink).append(vignetteCanvas);
        //             $(vignettePage).append(vignetteLink);

        //             $('#vignet-container').append(vignettePage);

        //             $("#page-" + i).droppable();

        //             $("#page-" + i).on("drop", function(event, ui) {

        //                 $(ui.draggable).attr('data-page', $(this).find('canvas').data('page'));

        //                 var droppableOffset = $(this).offset();
        //                 var draggablePosition = ui.draggable.position();

        //                 // Calculate the position of the draggable relative to the droppable
        //                 var relativeLeft = draggablePosition.left - droppableOffset.left;
        //                 var relativeTop = draggablePosition.top - droppableOffset.top;

        //                 $(ui.draggable).attr('data-x', relativeLeft);
        //                 $(ui.draggable).attr('data-y', relativeTop);

        //             });

        //             // Show the first page
        //             showPage(canvas, vignetteCanvas, textLayer, i);
        //         }

        //     }).catch(function(error) {
        //         // If error re-show the upload button
        //         $("#pdf-loader").hide();
        //         $("#upload-button").show();

        //         alert(error.message);
        //     });
        // }

        // function showPage(canvas, vignetteCanvas, textLayer, page_no) {
        //     __PAGE_RENDERING_IN_PROGRESS = 1;
        //     __CURRENT_PAGE = page_no;

        //     // Disable Prev & Next buttons while page is being loaded
        //     $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

        //     // While page is being rendered hide the canvas and show a loading message
        //     $("#pdf-canvas").hide();
        //     $(".page-loader.page-" + page_no).show();

        //     // Update current page in HTML
        //     $("#pdf-current-page").text(page_no);

        //     // Fetch the page
        //     __PDF_DOC.getPage(page_no).then(function(page) {

        //         // Support HiDPI-screens.
        //         var outputScale = window.devicePixelRatio || 1;

        //         var scale = outputScale > 1 ? 1.5 : 1.2;

        //         var viewport = page.getViewport(scale);

        //         var context = canvas.getContext('2d');

        //         canvas.width = Math.floor(viewport.width * outputScale);
        //         canvas.height = Math.floor(viewport.height * outputScale);
        //         canvas.style.width = Math.floor(viewport.width) + "px";
        //         canvas.style.height = Math.floor(viewport.height) + "px";

        //         $(canvas).parent().css({
        //             width: Math.floor(viewport.width) + "px",
        //             height: Math.floor(viewport.height) + "px",
        //             margin: '10px auto',
        //         });

        //         var transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] :
        //             null;

        //         var renderContext = {
        //             canvasContext: context,
        //             transform: transform,
        //             viewport: viewport
        //         };

        //         // Render the page contents in the canvas
        //         page.render(renderContext).then(function() {
        //             __PAGE_RENDERING_IN_PROGRESS = 0;

        //             // Show the canvas and hide the page loader
        //             $(".page-loader.page-" + page_no).hide();

        //             // Return the text contents of the page after the pdf has been rendered in the canvas
        //             return page.getTextContent();
        //         }).then(function(textContent) {
        //             // Get canvas offset
        //             var canvas_offset = $(canvas).offset();

        //             // Clear HTML for text layer
        //             $(textLayer).html('');

        //             // Assign the CSS created to the text-layer element
        //             $(textLayer).css({
        //                 left: '0px',
        //                 top: '8px',
        //                 height: canvas.height + 'px',
        //                 width: canvas.width + 'px'
        //             });

        //             // Pass the data to the method for rendering of text over the pdf canvas.
        //             PDFJS.renderTextLayer({
        //                 textContent: textContent,
        //                 container: $(textLayer).get(0),
        //                 viewport: viewport,
        //                 textDivs: []
        //             });

        //         });

        //         var scale_vignette_required = vignetteCanvas.width / page.getViewport(1).width * outputScale;

        //         // Get viewport of the page at required scale
        //         var vignettevViewport = page.getViewport(scale_vignette_required);

        //         // Set canvas height
        //         vignetteCanvas.height = vignettevViewport.height;

        //         var renderVignetteContext = {
        //             canvasContext: vignetteCanvas.getContext('2d'),
        //             viewport: vignettevViewport
        //         };
        //         page.render(renderVignetteContext);
        //     });
        // }

        // function addToLayer(annotationLayer, commentElement) {
        //     annotationLayer.append(commentElement);
        //     // Suppose commentList est votre liste d'éléments de commentaire
        //     const comments = document.querySelectorAll('.annotationLayer .comment');

        //     // Lors de l'ajout d'un nouveau commentaire
        //     const newComment = commentElement;

        //     const commentList = [];

        //     // Bouclez à travers les éléments et obtenez leurs positions
        //     comments.forEach(comment => {
        //         const rect = comment.getBoundingClientRect();
        //         commentList.push({
        //             comment,
        //             top: rect.top
        //         });
        //     });


        //     // Triez la liste des commentaires par position top (du plus petit au plus grand)
        //     commentList.sort((a, b) => a.top - b.top);

        //     var newTop = newComment.getBoundingClientRect().top;
        //     console.log(newTop);

        //     // Trouvez l'index où le nouveau commentaire doit être inséré en fonction de sa position top
        //     let insertIndex = 0;
        //     console.log(commentList[0].top == newTop);
        //     while (insertIndex < commentList.length && commentList[insertIndex].top < newTop) {
        //         insertIndex++;
        //     }

        //     // Insérez le nouveau commentaire à l'index approprié
        //     commentList.splice(insertIndex, 0, newComment);

        //     // Maintenant, vous pouvez ajuster les positions des commentaires existants situés au-dessus du nouvel élément
        //     for (let i = 0; i < insertIndex; i++) {
        //         commentList[i].top += newComment.getBoundingClientRect().height
        //         commentList[i].comment.top = commentList[i].top;
        //     }

        // }

        // Render PDF with annotations
        // async function renderPdfWithAnnotations() {

        //     var allCanvas = document.querySelectorAll('#pdf-contents canvas');

        //     const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
        //     console.log(pageAnnotations);

        //     allCanvas.forEach(canvas => {
        //         const context = canvas.getContext('2d');
        //         pageAnnotations.forEach(ann => {
        //             context.beginPath();
        //             context.rect(ann.x, ann.y, ann.width, ann.height);
        //             context.strokeStyle = 'red';
        //             context.lineWidth = 2;
        //             context.stroke();
        //         });
        //         canvas.context = context;
        //     });

        // }


        document.addEventListener('livewire:load', () => {





            // $('input[name=dest_fonction], input[name=dest_name]').on('keyup', function() {

            //     console.log($(".signatureContainer.cosignature"));

            //     $(".signatureContainer.cosignature").droppable({
            //         classes: {
            //             "ui-droppable": "ui-state-highlight"
            //         },
            //         drop: function(event, ui) {
            //             $(this).removeClass("ui-state-highlight");
            //             $(this).removeClass("bg-warning");
            //             $(ui.draggable).addClass("dropped-true");

            //             var droppableOffset = $(this).offset();
            //             var draggablePosition = ui.draggable.position();

            //             var relativeLeft = draggablePosition.left - droppableOffset.left;
            //             var relativeTop = draggablePosition.top //- droppableOffset.top;

            //             $(ui.draggable).attr('data-x', relativeLeft);
            //             $(ui.draggable).attr('data-y', relativeTop);

            //         }
            //     });
            // })

            $(".signatureContainer").droppable({
                classes: {
                    "ui-droppable": "ui-state-highlight"
                },
                drop: function(event, ui) {
                    $(this).removeClass("ui-state-highlight");
                    $(this).removeClass("bg-warning");
                    $(ui.draggable).addClass("dropped-true");

                    var droppableOffset = $(this).offset();
                    var draggablePosition = ui.draggable.position();

                    var relativeLeft = draggablePosition.left - droppableOffset.left;
                    var relativeTop = draggablePosition.top //- droppableOffset.top;

                    $(ui.draggable).attr('data-x', relativeLeft);
                    $(ui.draggable).attr('data-y', relativeTop);

                }
            });

        })


        // Livewire.on('signateurAdded', function(evt) {
        //     // let cosignataires = @js($cosignataires);
        //     // cosignataires.forEach(cosignataire => {
        //     //     console.log(cosignataire);
        //     // });
        //     // $('input[name=dest_fonction], input[name=dest_name]').on('keyup', function () {

        //     //     console.log($(".signatureContainer"));
        //     // console.log($(".signatureContainer.cosignature"));

        //     $(".signatureContainer.cosignature").droppable({
        //         classes: {
        //             "ui-droppable": "ui-state-highlight"
        //         },
        //         drop: function(event, ui) {
        //             $(this).removeClass("ui-state-highlight");
        //             $(this).removeClass("bg-warning");
        //             $(ui.draggable).addClass("dropped-true");

        //             var droppableOffset = $(this).offset();
        //             var draggablePosition = ui.draggable.position();

        //             var relativeLeft = draggablePosition.left - droppableOffset.left;
        //             var relativeTop = draggablePosition.top //- droppableOffset.top;

        //             $(ui.draggable).attr('data-x', relativeLeft);
        //             $(ui.draggable).attr('data-y', relativeTop);

        //         }
        //     });
        //     // })
        // });

        Livewire.on('changeCosignataire', function(evt) {
            $(".signatureContainer.cosignature").droppable({
                classes: {
                    "ui-droppable": "ui-state-highlight"
                },
                drop: function(event, ui) {
                    $(this).removeClass("ui-state-highlight");
                    $(this).removeClass("bg-warning");
                    $(ui.draggable).addClass("dropped-true");

                    var droppableOffset = $(this).offset();
                    var draggablePosition = ui.draggable.position();

                    var relativeLeft = draggablePosition.left - droppableOffset.left;
                    var relativeTop = draggablePosition.top //- droppableOffset.top;

                    $(ui.draggable).attr('data-x', relativeLeft);
                    $(ui.draggable).attr('data-y', relativeTop);

                }
            });
            // })
        });

        // let numberOfBreakpoints = 1.02;
        // let reste = 0;

        Livewire.on('changeBody', function(evt) {
            breackPage()
        });

        function breackPage() {

            var elementHTML = document.querySelector("#doc_save");
            var countPage = elementHTML.getBoundingClientRect().height / 1030;
            countPage = Math.ceil(countPage);

            var bodyBounds = document.querySelector("#block-body").getBoundingClientRect();
            var bodyBottom = bodyBounds.bottom;
            bodyBottom = Math.ceil(bodyBottom) + 245;

            for (let index = 1; index < countPage; index++) {
                var image = elementHTML.querySelectorAll('.logo-card')[index - 1];
                imageBoundBottom = image.getBoundingClientRect().bottom;

                if (bodyBottom >= imageBoundBottom) {
                    if (elementHTML.querySelectorAll('.p' + index).length === 0) {
                        var clonedImage = image.cloneNode(true);
                        clonedImage.classList.remove('p' + index);
                        clonedImage.style.top = (1030 * index) + 'px';
                        elementHTML.style.minHeight = (1030 * index) + 1030 + 'px';
                        $(image).parent().append(clonedImage);
                    }
                } else {
                    elementHTML.style.minHeight = (1030 * index) - 1030 + 'px';
                    $(image).parent().remove(image);
                }
                image.classList.add('p' + index);
            }

        }

        // $("#doc_save").on("drop", function(event, ui) {

        //     // $(ui.draggable).attr('data-page', $(this).find('canvas').data('page'));

        //     var droppableOffset = $(this).offset();
        //     var draggablePosition = ui.draggable.position();

        //     // Calculate the position of the draggable relative to the droppable
        //     var relativeLeft = draggablePosition.left - droppableOffset.left;
        //     var relativeTop = draggablePosition.top - droppableOffset.top;

        //     $(ui.draggable).attr('data-x', relativeLeft);
        //     $(ui.draggable).attr('data-y', relativeTop);

        // });

        $('.btn-signer').on('click', function(event) {
            console.log('click');
            $.ajax({
                url: "{{ route('regidoc.ajax.signature') }}",
                method: 'get',
                success: function(data) {
                    if (data.image !== '' && data.image !== undefined) {
                        var signatureElement = createSignatureElement();
                        var imgElement = document.createElement('img');
                        $(imgElement).addClass('w-100 h-100');
                        $(imgElement).css({
                            objectFit: 'contain',
                        })
                        $(imgElement).attr('src', data.image);

                        $(signatureElement).append(imgElement);
                        signatureElement.style.left = event.clientX + 5 + 'px';
                        signatureElement.style.top = event.clientY + 5 + 'px';
                    } else {
                        newSignatureImage();
                    }
                }
            });

        });

        $('.btn-tampon').on('click', function(event) {
            $.ajax({
                url: "{{ route('regidoc.ajax.tampon') }}",
                method: 'get',
                success: function(data) {
                    if (data.image !== '' && data.image !== undefined) {
                        var signatureElement = createSignatureElement();
                        signatureElement.classList.add('tampon');
                        var imgElement = document.createElement('img');
                        $(imgElement).addClass('w-100 h-100');
                        $(imgElement).css({
                            objectFit: 'contain',
                        })
                        $(imgElement).attr('src', data.image);

                        $(signatureElement).append(imgElement);
                        signatureElement.style.left = event.clientX + 5 + 'px';
                        signatureElement.style.top = event.clientY + 5 + 'px';
                    } else {
                        newTamponImage();
                    }
                }
            });
        });

        function createSignatureElement() {
            if ($('.signature:not(.dropped-true)').length == 0) {
                var signatureElement = document.createElement('div');
                // $(signatureElement).attr('data-html2canvas-ignore', true);
                signatureElement.classList.add('signature');
                signatureElement.style.position = 'fixed';

                var removeBtn = document.createElement('button');
                removeBtn.classList.add('btn');
                removeBtn.classList.add('btn-danger');
                removeBtn.classList.add('btn-sm');
                removeBtn.classList.add('rounded-circle');
                removeBtn.classList.add('remove-btn');
                $(removeBtn).text('x');
                $(removeBtn).css({
                    position: 'absolute',
                    right: 0
                });

                $(signatureElement).append(removeBtn);

                $(signatureElement).draggable({
                    appendTo: ".signatureContainer",
                    connectToSortable: ".signatureContainer",
                    containment: "parent"
                });
                $('.signatureContainer').append(signatureElement);

                return signatureElement;
            }
        }

        function newSignatureImage() {
            if ($('.signature:not(.dropped-true)').length == 0) {

                $('.modal-signature').find('.dessin').removeClass('d-none');
                $('.modal-signature').find('.dessin-tab').addClass('active');
                $('.modal-signature').find('.dessin-tab').addClass('show');
                $('.modal-signature').find('.dessin-tab').removeClass('d-none');

                $('.modal-signature').find('.import-image-tab').removeClass('active');
                $('.modal-signature').find('.import-image-tab').removeClass('show');
                $('.modal-signature').find('.import-image button').removeClass('active');

                $('.modal-signature').addClass('signature-modal');
                $('.modal-signature').removeClass('tampon-modal');
                $('.modal-signature').css({
                    width: '100%'
                });
            }
        }

        function newTamponImage() {
            if ($('.signature:not(.dropped-true)').length == 0) {

                $('.modal-signature').find('.dessin').addClass('d-none');
                $('.modal-signature').find('.dessin-tab').removeClass('active');
                $('.modal-signature').find('.dessin-tab').removeClass('show');
                $('.modal-signature').find('.dessin-tab').addClass('d-none');

                $('.modal-signature').find('.import-image-tab').addClass('active');
                $('.modal-signature').find('.import-image-tab').addClass('show');
                $('.modal-signature').find('.import-image button').addClass('active');

                $('.modal-signature').removeClass('signature-modal');
                $('.modal-signature').addClass('tampon-modal');
                $('.modal-signature').css({
                    width: '100%'
                });

            }
        }

        // Event handlers for tracking mouse movement on the document
        $(document).on('mousemove', function(event) {
            var signatureElement = document.querySelector('.signature:not(.dropped-true)');
            if (signatureElement !== null) {
                // Set the position of the signature element to the current mouse position
                signatureElement.style.left = event.clientX + 5 + 'px';
                signatureElement.style.top = event.clientY + 5 + 'px';
            }
        });

        $("body").on("click", ".signatureContainer", function() {

            // Get the first draggable element (you can modify this selector based on your actual draggable elements)
            var draggableElement = $(".signature:not(.dropped-true)").first();

            // Check if the draggable element exists and is draggable
            if (draggableElement.length > 0 && draggableElement.hasClass("ui-draggable")) {

                $(draggableElement).addClass('dropped-true');
                $(draggableElement).resizable({
                    // aspectRatio: true,
                    autoHide: true,
                    handles: "n, e, s, w, ne, se, sw, nw"
                });

                // $(draggableElement).css({
                //     position: 'absolute',
                //     left: (event.clientX) + window.scrollX + 'px',
                //     top: (event.clientY) + window.scrollY + 'px'
                // })

                $('.signature').find('img').on('dblclick', function() {
                    $(this).parent().addClass('active');
                    if ($(this).hasClass('tampon')) {
                        newTamponImage();
                    } else {
                        newSignatureImage();
                    }
                });

                // Simulate the drop event on the droppable area
                $(this).trigger("drop");
                // $(this).trigger("drop", {
                //     draggable: $(draggableElement),
                //     helper: $(draggableElement),
                //     offset: {
                //         top: $(draggableElement).offset().top,
                //         left: $(draggableElement).offset().left
                //     },
                //     position: {
                //         top: $(draggableElement).offset().top,
                //         left: $(draggableElement).offset().left
                //     }
                // });

                $('.remove-btn').on('click', function() {
                    $(this).parent().remove();
                })
            }

        });



        $('select.select2Agent').each(function() {
            $(this).select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
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
                    url: $(this).data('get-items-route'),
                    data: function(params) {
                        var query = {
                            search: params.term,
                            type: $(this).data('get-items-field'),
                            method: $(this).data('method'),
                            id: $(this).data('id'),
                            page: params.page || 1,
                            model: $(this).data('related-model'),
                            label: $(this).data('label'),
                        }
                        return query;
                    }
                },
                width: '100%',
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
                dropdownParent: $(this).parent()
            });

            $(this).on('select2:select', function(e) {
                var data = e.params.data;

                if (data.id == '') {
                    // "None" was selected. Clear all selected options
                    $(this).val([]).trigger('change');
                } else {
                    $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            $(this).on('select2:unselect', function(e) {
                var data = e.params.data;
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected',
                    false);
            });

            $(this).on('select2:selecting', function(e) {

                if (!$(this).data('tags')) {
                    return;
                }
                var $el = $(this);
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
        });

        $('select[name=agent_id]').on('change', function() {
            var agent_id = $(this).val();
            @this.set('agent_id', agent_id);
        })
    </script>
@endpush
