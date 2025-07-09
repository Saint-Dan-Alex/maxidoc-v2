@extends('regidoc.layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jdikasaDropZone/dist/css/jdikasaDropZone.css') }}">
    <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js?v1') }}"></script>
@endsection

@section('content')
    <div id="createTaskPage">

        <div class="container-fluid px-lg-4">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="back mb-0">
                    <i class="fi fi-rr-angle-left"></i>
                    <div class="tooltip-indicator">
                        Retour
                    </div>
                </a>
                <h4 class="no-padding no-margin ms-2 mb-0">
                    {{ $isSubTask ? 'Création de la sous-tâche' : 'Création de la tâche' }}
                </h4>
                {{-- <nav aria-label="breadcrumb" class="ms-4">
                <ol class="mb-0 breadcrumb breadcrumb-no-gutter">
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
            </nav> --}}
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-table card-new-task-lg">
                        {{-- <h4 class="no-padding no-margin mb-2">
                        {{ $isSubTask ? 'Création de la sous-tâche' : 'Création de la tâche' }}
                    </h4> --}}
                        @if ($document)
                            <div class="attache-doc">
                                Le document <span class="doc-item px-2"><i class="fi fi-rr-clip"></i>
                                    {{ $document->libelle }}</span> est attaché à cette tâche
                            </div>
                            <hr>
                        @endif
                        @if ($isNewdoc)
                            <div class="attache-doc">
                                Vous avez joint le nouveau document <span class="doc-item px-2"><i
                                        class="fi fi-rr-clip"></i>
                                    {{ $docname }}</span> à cette tâche
                            </div>
                            <hr>
                        @endif
                        <form action="{{ route('regidoc.taches.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row ">

                                <div class="form-group-content">
                                    <div class="form-group-content-left">
                                        <div class="row g-3">
                                            @if ($document)
                                                <input type="hidden" name="doc_id" value="{{ $document->id }}">
                                            @endif
                                            @if (isset($courrier_id) && $courrier_id)
                                                <input type="hidden" name="courrier_id" value="{{ $courrier_id }}">
                                            @endif

                                            @if ($isNewdoc)
                                                <input type="hidden" name="newdoc" value="{{ true }}">
                                                <input type="hidden" name="docname" value="{{ $docname }}">
                                                <input type="hidden" name="filename" value="{{ $filename }}">
                                                <input type="hidden" name="dossiername" value="{{ $dossiername }}">
                                            @endif

                                        </div>

                                        <div class="col-lg-12 mb-2 mt-2">
                                            <label class="mb-2">Titre</label>
                                            @if ($isSubTask)
                                                <input type="hidden" name="parent_id" value="{{ $tache->id }}">
                                                <input type="text" name="titre" class="form-control"
                                                    placeholder="Titre de la tâche" value="{{ $tache->titre }}" required>
                                            @elseif($document)
                                                <input type="text" name="titre" class="form-control"
                                                    placeholder="Titre de la tâche" value="{{ '' . $document->libelle }}"
                                                    required>
                                            @else
                                                <input type="text" name="titre" class="form-control"
                                                    placeholder="Titre de la tâche" required>
                                            @endif
                                        </div>

                                        <div class="col-lg-12 mb-2">
                                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                                <label class="mb-0">Participant(s) </label>
                                                {{-- @if (Auth::user()->agent->isDG() == false) --}}
                                                <a href="javascript:void(0)"
                                                    class="btn btn-add ms-2 btn-sm-add btn-add-agent p-0">
                                                    <i class="fi fi-rr-plus"></i>
                                                </a>
                                                {{-- @endif --}}
                                            </div>
                                            <div class="assignation-container">
                                                @php
                                                    use App\Models\Division;
                                                    use App\Models\Service;
                                                    use App\Models\Section;

                                                    $name = '';
                                                    $title = '';
                                                    $objects = [];

                                                    if ($isSubTask) {
                                                        if ($tache->parent != null) {
                                                            if (
                                                                $tache->agents->first()->pivot->type == Division::class
                                                            ) {
                                                                $name = 'service_id';
                                                                $title = 'titre';
                                                                $objects = Service::where(
                                                                    'division_id',
                                                                    $tache->agents->first()->pivot->type_id,
                                                                )->get();
                                                            } elseif (
                                                                $tache->agents->first()->pivot->type == Service::class
                                                            ) {
                                                                $name = 'section_id';
                                                                $title = 'titre';
                                                                $objects = Section::where(
                                                                    'service_id',
                                                                    $tache->agents->first()->pivot->type_id,
                                                                )->get();
                                                            }
                                                        } else {
                                                            $name = 'division_id';
                                                            $title = 'libelle';
                                                            $objects = Division::where(
                                                                'direction_id',
                                                                $tache->agents->first()->pivot->type_id,
                                                            )->get();
                                                        }
                                                    } else {
                                                        if (Auth::user()->agent->isDG()) {
                                                            if ($to == 'direction' || $to == null) {
                                                                $name = 'direction_id';
                                                                $title = 'titre';
                                                                $objects = $directions;
                                                            } elseif ($to == 'agent') {
                                                                $name = 'agent_id';
                                                                $objects = $agents;
                                                            }
                                                        } else {
                                                            $name = 'agent_id';
                                                            $objects = $agents;
                                                        }
                                                    }

                                                @endphp

                                                @include(
                                                    'regidoc.pages.taches.components.assignation-item',
                                                    [
                                                        'name' => $name,
                                                        'title' => $title,
                                                        'objects' => $objects,
                                                    ]
                                                )

                                            </div>

                                        </div>

                                        <div class="col-12 mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" id="permission-9" name="echeanche"
                                                        class="echeance-toggle form-check-input" value="" checked>
                                                </div>
                                                <label for="permission-9" class="mb-0" style="font-size: 14px">
                                                    Ajouter une échéance</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mb-2 echeance d-none">
                                            <label class="mb-2">Date de début</label>
                                            <input type="date" class="form-control" placeholder="Objectif assigné"
                                                name="date_debut">
                                        </div>
                                        <div class="col-lg-12 mb-2 echeance d-none">
                                            <label class="mb-2">Date d'échéance</label>
                                            <input type="date" class="form-control" placeholder="Objectif assigné"
                                                name="date_fin">
                                        </div>

                                        <div class="col-lg-12">
                                            <label class="mb-2">Priorité</label>
                                            <select class="form-select select2" aria-label="Default select example"
                                                name="priorite_id" required>
                                                <option selected disabled value="">Sélectionnez</option>
                                                @foreach ($priorites as $priorite)
                                                    <option value="{{ $priorite->id }}"
                                                        @if ($isSubTask) @selected($tache->priorite_id) @endif>
                                                        {{ $priorite->titre }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group-content-right">
                                        {{-- <label class="mb-2">Annotations</label> --}}

                                        <div class="editorBox">
                                            <textarea name="description" id="textarea-edit" cols="30" rows="4"
                                                class="form-control form-control-tache-annotation" placeholder="Saisisez votre annotation...">
                                    </textarea>

                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div id="dropzone-container" class="mt-2">
                                                    <div class="d-flex justify-content-center align-items-center"
                                                        id="dropzone">
                                                        <i class="fi fi-rr-clip"></i>

                                                        <p class="ms-4">Glissez-déposez vos fichiers ici ou cliquez pour
                                                            les
                                                            importer.
                                                            (Max 1Mo)
                                                        </p>
                                                    </div>
                                                    <div class="dropzone-preview" style="display: none">
                                                        <ul class="dropzone-preview-list"></ul>
                                                    </div>
                                                    <input type="file" name="documents[]" multiple />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mt-3 d-flex justify-content-end mt-lg-4">
                                                    <a href="{{ url()->previous() }}" class="btn me-3"
                                                        style="padding: 10px 24px; font-size: 14px">Annuler</a>
                                                    <button class="btn btn-add" style="padding: 10px 24px">Créer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/jdikasaDropZone/dist/js/jdikasaDropZone.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.select2').select2({
                width: "100%",
            });

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

                $('.assignation-item-append .assignation-item').last().find('select').addClass(
                    'select-assigne');
                $('.assignation-item-append .assignation-item').last().find('select').addClass('select2');
                $('.assignation-item-append .assignation-item').last().find('input').addClass(
                    'tache-target');
                $('.assignation-item-append .assignation-item').last().find('.select2').select2({
                    width: "100%"
                });
            });

            $('body').on('click', '.btn-add-objectif', function() {
                var template = $(this).parent().parent().find('.objectif-item-template');
                $(this).parent().parent().find('.objectif-item-append').append(template.html());
                var input = $('.objectif-item-append > div').last().find('input');
                var oldInput = $(this).parent().parent().find('.tache-target').last();
                if (oldInput) {
                    input.attr('name', oldInput.attr('name'));
                } else {
                    input.attr('name', input.data('name'));
                }
                input.attr('required', true);
                input.removeAttr('data-name');
                input.addClass('tache-target');
            });

            $('body').on('click', '.btn-remove-objectif', function() {
                $(this).parent().remove();
            });

            $('body').on('click', '.btn-remove-assignation', function() {
                $(this).parent().parent().remove();
            });

            $('body').on('change', '.select-assigne', function(e) {
                var inputs = $(this).parent().parent().find('.tache-target');
                inputs.attr('name', 'objects[' + e.target.value + '][]');
            });

            $('.echeance-toggle').on('change', function() {
                if ($(this).is(":checked")) {
                    $('.echeance').removeClass('d-none');
                    $(this).parent().parent().find('label').text('Avec échéance');
                } else {
                    $('.echeance').addClass('d-none');
                    $(this).parent().parent().find('label').text('Sans échéance');
                }
            });

            // Vérifier si la case à cocher est cochée au chargement de la page
            if ($('.echeance-toggle').is(":checked")) {
                $('.echeance').removeClass('d-none'); // Afficher les blocs de date
            }
        });

        const useDarkMode = localStorage.getItem("data-theme") == 'dark';
        const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;
        tinymce.init({
            selector: 'textarea#textarea-edit',
            plugins: 'preview autolink visualblocks visualchars image link table nonbreaking advlist lists wordcount spellchecker',
            mobile: {
                plugins: 'preview importcss searchreplace autolink autosave save visualblocks visualchars fullscreen image link media template codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap charmap emoticons spellchecker'
            },
            menubar: false,
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange |  preview | image link table | spellchecker',
            toolbar_sticky: true,
            spellchecker_language: 'fr_FR',
            height: 455,
            image_caption: true,
            toolbar_mode: 'sliding',
            skin: useDarkMode ? 'oxide-dark' : 'oxide',
            content_css: useDarkMode ? 'dark' : 'default',
        })
    </script>
@endsection

{{-- <style>
    .content .form-control {
        font-size: 12px;
        color: var(--colorTitre);
        border: none !important;
    }

    .content .form-select {
        border: none !important;
    }
</style> --}}
