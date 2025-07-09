@extends('regidoc.layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js?v1') }}"></script>
    <style>
        #dropzone {
            padding: 40px 30px;
            text-align: center;
            cursor: pointer;
        }

        #dropzone-container {
            border: 2px dashed #ddd;
            border-radius: 20px;
            padding: 10px;
        }

        #dropzone p {
            margin: 0px;
            padding: 0px;
            font-size: 12px;
            color: rgb(187, 185, 185);
            font-weight: 500;
        }

        #dropzone-container input {
            display: none;
        }

        #dropzone-container.dragover {
            background-color: #f5f5f5;
            border-color: #000;
        }

        #dropzone-container.has-file #dropzone {
            padding: 25px 30px;
            background-color: #f8f8f8;
            margin-bottom: 10px;
            border-radius: 20px;
        }

        .dropzone-preview {
            border-top: 1px solid #eee
        }

        .dropzone-preview .dropzone-preview-list {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 1em;
            padding: 0px
        }

        .dropzone-preview .dropzone-preview-list>.dropzone-preview-list-item {
            list-style: none;
            margin: 0px;
            padding: 0px;
        }

        .dropzone-preview .dropzone-preview-list>.dropzone-preview-list-item .dropzone-preview-image {
            width: 100%;
            max-height: 100px;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-lg-4">
        <div class="mb-3 row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="mb-2 breadcrumb breadcrumb-no-gutter">
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="{{ route('regidoc.home') }}">
                                <i class="fi fi-sr-apps fi-sr me-2"></i>
                                Tableau de bord
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="breadcrumb-link" href="{{ route('regidoc.taches.index') }}">Gestion des tâches</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Nouvelle tâche</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card card-table">
                    <h4 class="no-padding no-margin">Nouvelle tâche</h4>
                    <hr>
                    <form action="{{ route('regidoc.taches.update', $tache->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group row g-lg-3 g-3">
                            <div class="col-lg-4">
                                <div class="row g-3">

                                    <div class="col-lg-12">
                                        <label class="mb-2">Titre</label>
                                        <input type="text" name="titre" class="form-control"
                                            placeholder="Titre de la tâche" value="{{ $tache->titre }}" required>
                                    </div>

                                    <div class="col-lg-12">
                                        <h6 for="">Listes des objecifs</h6>
                                        @foreach ($tache->objectifs as $objectif)
                                            <div class="assignation-item">
                                                <p>#{{ $loop->iteration }}
                                                    <strong>{{ $objectif->agent->prenom . ' ' . $objectif->agent->nom }}</strong>
                                                    <small> {{ $objectif->libelle }} </small>
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    {{-- <div class="col-lg-12">
                                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                                <label>Affecter à </label>
                                                <a href="javascript:void(0)" class="btn btn-add ms-2 btn-sm-add btn-add-agent">
                                                    <i class="fi fi-rr-plus"></i>
                                                </a>
                                            </div>
                                            <div class="assignation-container">

                                                <div class="assignation-item-append"></div>

                                                <div class="assignation-item-template" style="display: none">
                                                    <div class="mt-3 assignation-item">
                                                        <select class="form-select" aria-label="Default select example"
                                                            data-name="agent_id[]">
                                                            <option selected disabled value="">Selectionner</option>
                                                            <@foreach ($agents as $agent)
                                                                <option value="{{ $agent->id }}">
                                                                    {{ $agent->prenom . ' ' }}
                                                                    {{ $agent->nom }} </option>
                                                                @endforeach
                                                        </select>
                                                        <div class="mt-1 d-flex align-items-start">
                                                            <div class="flex-grow-1 objectif-container">
                                                                <div class="objectif-item">
                                                                    <input type="text" data-name="objects[]"
                                                                        class="form-control" placeholder="Objectif assigné">
                                                                </div>

                                                                <div class="objectif-item-append"></div>

                                                                <div class="mt-1 objectif-item-template" style="display: none">
                                                                    <div class="mt-1 d-flex">
                                                                        <input type="text" data-name="objects[]"
                                                                            class="form-control flex-grow-1"
                                                                            placeholder="Objectif assigné">
                                                                        <a href="javascript:void(0)"
                                                                            class="p-0 m-1 btn text-danger d-block btn-remove-objectif">
                                                                            <i class="fi fi-rr-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="px-2 py-1">
                                                                <a href="javascript:void(0)"
                                                                    class="p-0 btn d-block btn-add-objectif">
                                                                    <i class="fi fi-rr-plus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div> --}}
                                    <div class="col-lg-12">
                                        <label class="mb-2">Date de début</label>
                                        <input type="date" class="form-control" name="date_debut"
                                            value="{{ $tache->date_debut }}">
                                    </div>
                                    <div class="col-lg-12 echeance">
                                        <label class="mb-2">Date d'échéance</label>
                                        <input type="date" class="form-control" name="date_fin"
                                            value="{{ $tache->date_fin }}">
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch">
                                                <input type="checkbox" id="permission-9" name="echeanche"
                                                    class="echeance-toggle form-check-input" value="">
                                            </div>
                                            <label for="permission-9" class="mb-0" style="font-size: 12px">Sans
                                                échéance</label>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-12">
                                        <label class="mb-2">Priorité</label>
                                        <select class="form-select select2" aria-label="Default select example"
                                            name="priorite_id">
                                            <option selected disabled value="">Sélectionnez</option>
                                            @foreach ($priorites as $priorite)
                                                <option value="{{ $priorite->id }}" @selected($priorite->id == $tache->priorite_id)>
                                                    {{ $priorite->titre }} </option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-8">
                                <label class="mb-2">Description</label>
                                <textarea name="description" id="textarea-edit" cols="30" rows="10" class="form-control"> {{ $tache->description }} </textarea>

                            </div>
                            <div class="col-12">

                                <div id="dropzone-container" class="">
                                    <div id="dropzone">
                                        <p>Glissez-déposez vos fichiers ici ou cliquez pour les importer.
                                            (Max 1Mo)</p>
                                    </div>
                                    <div class="dropzone-preview" style="display: none">
                                        <ul class="dropzone-preview-list"></ul>
                                    </div>
                                    <input type="file" name="documents[]" multiple />
                                </div>
                                <div class="col-12">
                                    <label for="">Pièces jointes</label>
                                    @foreach ($tache->documents as $document)
                                        @php
                                            $val = Str::endsWith(files($document->document)->link, '.pdf');
                                        @endphp
                                        <div class="file-upload-task d-flex align-items-center">
                                            <a href="{{ $val ? route('regidoc.documents.showDoc', ['fichier_id' => $document->id, 'tache_id' => $tache->id]) : files($document->document)->link }}"
                                                class="d-flex align-items-center link-show-doc"
                                                title="{{ $document->libelle }}" target="_blank">
                                                <div class="icon me-1" style="flex: 0 0 auto">
                                                    <i class="fi fi-rr-file"></i>
                                                </div>
                                                <div class="name-file">
                                                    <h6 class="mb-0">{{ $document->libelle }}</h6>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mt-3 d-flex justify-content-end mt-lg-4">
                                    <button class="btn" style="font-size: 14px">Annuler</button>
                                    <button class="btn btn-add">Modifier</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade modal-person" id="modal-new-personnel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un personnel</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{ route('rh.user.store') }}">
                        @csrf
                        <div class="form-group row g-3" id="form-user">
                            <div class="col-12">
                                <h2 style="font-size: 13px;font-weight: 700;color: var(--colorTitre);">Informations
                                    personnelles</h2>
                            </div>
                            <div class="col-md-6 mailauto">
                                <label class="nom">Nom</label>
                                <input type="text" name="nom" class="form-control nom"
                                    placeholder="Insérez le nom" required style="text-transform: capitalize">
                            </div>
                            <div class="col-md-6">
                                <label>Post-nom</label>
                                <input type="text" name="postnom" class="form-control"
                                    placeholder="Insérez le post-nom" style="text-transform: capitalize">
                            </div>
                            <div class="col-md-6 mailauto">
                                <label>Prénom</label>
                                <input type="text" name="prenom" class="form-control nom"
                                    placeholder="Insérez le prénom" style="text-transform: capitalize">
                            </div>
                            <div class="col-md-6">
                                <label>Sexe</label>
                                <select class="form-select" name="sexe" aria-label="Default select example"
                                    required>
                                    <option value="" selected disabled>Selectionnez le sexe</option>
                                    <option value="F">Féminin</option>
                                    <option value="M">Masculin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Lieu de naissance</label>
                                <input type="text" name="lieunaissance" class="form-control"
                                    placeholder="Insérez le lieu de naissance">
                            </div>
                            <div class="col-md-6">
                                <label>Date de naissance</label>
                                <input type="date" name="datenaissance" class="form-control"
                                    placeholder="Insérez la date de naissance">
                            </div>
                            <div class="col-md-6">
                                <label>Nationalité</label>
                                <input type="text" name="nationalite" class="form-control"
                                    placeholder="Insérez la nationalité">
                            </div>
                            <div class="col-md-6 mail">
                                <label>E-mail</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Insérez l'adresse e-mail" style="text-transform: lowercase" required>
                            </div>
                            <div class="col-md-6">
                                <label>Téléphone</label>
                                <input type="tel" name="telephone" class="form-control"
                                    placeholder="Insérez le téléphone" required>
                            </div>
                            <div class="col-md-6">
                                <label>Autre Téléphone</label>
                                <input type="tel" name="autre_telephone" class="form-control"
                                    placeholder="Insérez le téléphone">
                            </div>
                            <div class="col-md-12">
                                <label>Adresse</label>
                                <textarea name="adresse" id="" cols="30" rows="4" class="form-control" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Nombre d'enfants</label>
                                <input type="text" name="enfants" value="0" class="form-control"
                                    placeholder="Insérez le nombre d'enfants" required>
                            </div>
                            <div class="col-md-6">
                                <label>Etat-civil</label>
                                {{-- <select class="form-select" name="etatcivil" aria-label="Default select example"
                                required>
                                <option value="" selected disabled>Selectionnez l'état-civil</option>
                                <option value="Célibataire">Célibataire</option>
                                <option value="Divorcé(e)">Divorcé(e)</option>
                                <option value="Marié(e)">Marié(e)</option>
                                <option value="Veuf(ve)">Veuf(Veuve)</option>
                            </select> -}}
                            </div>



                            <div class="col-lg-12">
                                <h2
                                    style="font-size: 13px;font-weight: 700;color: var(--colorTitre); margin-top: 30px;">
                                    Informations professionnelles</h2>
                            </div>

                            <div class="col-md-6">
                                <label>Poste</label>
                                {{-- <select class="form-select" name="fonction_id" aria-label="Default select example"
                                required>
                                <option value="" selected disabled>Selectionnez un poste</option>
                                @foreach ($fonctions as $fonction)
                                    <option value="{{ $fonction->id }}">{{ $fonction->titre }}</option>
                                @endforeach
                            </select> --}}
    {{-- <select class="form-select" name="fonction_id" aria-label="Default select example"
                                required>
                                <option value="" selected disabled>Selectionnez un poste</option>
                                @foreach ($postes as $poste)
                                    <option value="{{ $poste->id }}">{{ $poste->libelle }}</option>
                                @endforeach
                            </select> -}}
                            </div>

                            <div class="col-md-6">
                                <label>Direction</label>
                                {{-- <select class="form-select" name="direction_id" aria-label="Default select example"
                                required>
                                <option value="" selected disabled>Selectionnez une direction</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}">{{ $direction->titre }}</option>
                                @endforeach
                            </select> --}}

    {{-- <label>Division</label>
                            <select class="form-select" name="division_id" aria-label="Default select example"
                                required>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->libelle }}</option>
                                @endforeach
                            </select> -}}
                            </div>
                            <div class="col-md-6">
                                <label>Date debut du fonction</label>
                                <input type="date" name="debut_fonction" class="form-control"
                                    placeholder="Insérez la date de debut du fonction">
                            </div>

                            <div class="col-md-6">
                                <label>Planning</label>
                                {{-- <select class="form-select" name="planning_id" aria-label="Default select example"
                                required>
                                <option value="" selected disabled>Selectionnez un planning</option>
                                @foreach ($plannings as $planning)
                                    <option value="{{ $planning->id }}">{{ $planning->libelle }}</option>
                                @endforeach
                            </select> -}}
                            </div>
                            {{-- <div class="col-md-6">
                            <label>Accréditation</label>
                            <select class="form-select" name="role_id" aria-label="Default select example"
                                required>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->libelle }}</option>
                                @endforeach
                            </select>
                        </div> --}}
    {{-- <div class="col-lg-4">
                                        <label>Matricule</label>
                                        <input type="text" name="matricule" class="form-control" placeholder="Insérez le numéro matricule" required>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>Statut</label>
                                        <select class="form-select" name="statut_id" aria-label="Default select example" required>
                                            @foreach ($statuts as $statut)
                                                <option value="{{ $statut->id }}">{{ $statut->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div> -}}
                            <div class="mt-4 col-lg-12 text-end">
                                <button class="btn btn-add">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                width: "100%"
            });

            $("#dropzone").on("dragover", function(event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).parent().addClass("dragover");
            });

            $("#dropzone").on("dragleave", function(event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).parent().removeClass("dragover");
            });

            $("#dropzone").on("drop", function(event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).parent().removeClass("dragover");
                var files = event.originalEvent.dataTransfer.files;
                if (files.length > 0) {
                    $(this).parent().addClass("has-file");
                    handleDropFiles(files);
                    handleFilesPreview(files);
                }
            });

            $("#dropzone").on("click", function(event) {
                event.preventDefault();
                event.stopPropagation();
                $(this).parent().addClass("dragover");
                $(this).parent().find('input').trigger("click");
            });

            $("#dropzone").parent().find('input').on('change', function(event) {
                $(this).parent().removeClass("dragover");
                var files = event.target.files;
                if (files.length > 0) {
                    $(this).parent().addClass("has-file");
                    handleFilesPreview(files);
                }
            });

            function handleDropFiles(files) {
                $("#dropzone").parent().find('input').prop('files', files);
            }

            function loadImages(files) {
                var imagePromises = [];
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var reader = new FileReader();
                    var promise = new Promise(function(resolve, reject) {
                        reader.onload = function(e) {
                            resolve(e.target.result);
                        }
                        reader.onerror = function(e) {
                            reject(e);
                        }
                        reader.readAsDataURL(file);
                    });
                    imagePromises.push(promise);
                }
                return Promise.all(imagePromises);
            }

            function handleFilesPreview(files) {
                $('.dropzone-preview').show();
                var list = $('.dropzone-preview-list');

                loadImages(files).then(function(imageUrls) {
                    console.log(files);
                    console.log(imageUrls);

                    for (let index = 0; index < imageUrls.length; index++) {
                        var imageUrl = imageUrls[index];
                        var file = files[index];

                        var item = $("<li>", {
                            class: "dropzone-preview-list-item"
                        });
                        var imagePreview = $("<img>", {
                            class: "dropzone-preview-image"
                        });
                        var icon = $("<i>", {
                            class: "fi fi-rr-file dropzone-preview-icon"
                        });
                        var name = $("<small>", {
                            class: "dropzone-preview-name"
                        });

                        let filename = file.name;
                        if (filename.length >= 12) {
                            let splitName = filename.split('.');
                            filename = splitName[0].substring(0, 12) + "... ." + splitName[1];
                            name.text(filename);
                        }

                        if (file.type.match('image.*')) {
                            imagePreview.attr('src', imageUrl);

                            item.append(imagePreview);
                            item.append(name);
                            list.append(item);

                        } else {
                            item.append(icon);
                            item.append(name);
                            list.append(item);
                        }
                    }
                }).catch(function(error) {
                    console.log(error);
                });
            }

            $('body').on('click', '.btn-add-agent', function() {
                let template = $('.assignation-item-template');
                $('.assignation-item-append').append(template.html());

                var input = $('.assignation-item-append .assignation-item').last().find('input').first();
                var select = $('.assignation-item-append .assignation-item').last().find('select').first();

                input.attr('name', input.data('name'));
                input.attr('required', true);
                input.removeAttr('data-name');

                select.attr('name', select.data('name'));
                select.attr('required', true);
                select.removeAttr('data-name');

                $('.assignation-item-append .assignation-item').last().find('select').addClass('select2');
                $('.assignation-item-append .assignation-item').last().find('.select2').select2({
                    width: "100%"
                });
            });

            $('body').on('click', '.btn-add-objectif', function() {
                var template = $(this).parent().parent().find('.objectif-item-template');
                $('.objectif-item-append').append(template.html());
                var input = $('.objectif-item-append > div').last().find('input');
                input.attr('name', input.data('name'));
                input.attr('required', true);
                input.removeAttr('data-name');
            });

            $('body').on('click', '.btn-remove-objectif', function() {
                $(this).parent().remove();
            });

            $('.echeance-toggle').on('change', function() {
                $('.echeance').toggle();
                if ($(this).is(":checked")) {
                    $(this).parent().parent().find('label').text('Avec echeance');
                } else {
                    $(this).parent().parent().find('label').text('Sans echeance');
                }
            });

        });

        const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;
        tinymce.init({
            selector: 'textarea#textarea-edit',
            // plugins: 'preview importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount a11ychecker editimage help formatpainter permanentpen pageembed charmap tinycomments mentions linkchecker emoticons advtable export footnotes mergetags autocorrect',
            plugins: 'preview autolink visualblocks visualchars image link table nonbreaking advlist lists wordcount',
            mobile: {
                plugins: 'preview importcss searchreplace autolink autosave save visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap charmap emoticons'
            },
            // menubar: 'file edit view insert format tools table tc help',
            menubar: false,
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange |  preview | image link table',
            toolbar_sticky: true,
            // toolbar_sticky_offset: isSmallScreen ? 102 : 108,
            // autosave_ask_before_unload: false,
            // autosave_interval: '30s',
            // autosave_prefix: '{path}{query}-{id}-',
            // autosave_restore_when_empty: false,
            // autosave_retention: '2m',
            // image_advtab: false,
            // link_list: [{
            //         title: 'My page 1',
            //         value: 'https://www.tiny.cloud'
            //     },
            //     {
            //         title: 'My page 2',
            //         value: 'http://www.moxiecode.com'
            //     }
            // ],
            // image_list: [{
            //         title: 'My page 1',
            //         value: 'https://www.tiny.cloud'
            //     },
            //     {
            //         title: 'My page 2',
            //         value: 'http://www.moxiecode.com'
            //     }
            // ],
            // image_class_list: [{
            //         title: 'None',
            //         value: ''
            //     },
            //     {
            //         title: 'Some class',
            //         value: 'class-name'
            //     }
            // ],
            importcss_append: false,
            // templates: [{
            //         title: 'New Table',
            //         description: 'creates a new table',
            //         content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
            //     },
            //     {
            //         title: 'Starting my story',
            //         description: 'A cure for writers block',
            //         content: 'Once upon a time...'
            //     },
            //     {
            //         title: 'New list with dates',
            //         description: 'New List with dates',
            //         content: '<div class="mceTmpl"><span class="cdate">cdate</span><br><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
            //     }
            // ],
            // template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            // template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            // height: 600,
            image_caption: true,
            // quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            // noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            // spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
            // tinycomments_mode: 'embedded',
            // content_style: '.mymention{ color: gray; }',
            // contextmenu: 'link image editimage table configurepermanentpen',
            // a11y_advanced_options: true,
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',

        })
    </script>
@endsection
