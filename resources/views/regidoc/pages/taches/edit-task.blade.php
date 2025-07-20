@extends('regidoc.layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jdikasaDropZone/dist/css/jdikasaDropZone.css') }}">
    <script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js?v1') }}"></script>
@endsection

@section('content')
    <div id="editTaskPage"> {{-- Changed ID to reflect edit page --}}

        <div class="container-fluid px-lg-4">
            <div class="d-flex align-items-center mb-3">
                <a href="{{ url()->previous() }}" class="back mb-0">
                    <i class="fi fi-rr-angle-left"></i>
                    <div class="tooltip-indicator">
                        Retour
                    </div>
                </a>
                <h4 class="no-padding no-margin ms-2 mb-0">
                    {{ $isSubTask ? 'Modification de la sous-tâche' : 'Modification de la tâche' }}
                </h4>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-table card-new-task-lg">
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
                        {{-- Form action for update --}}
                        <form action="{{ route('regidoc.taches.update', $tache->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT') {{-- Method Spoofing for PUT request --}}

                            <div class="form-group row ">
                                <div class="form-group-content">
                                    <div class="form-group-content-left">
                                        <div class="row g-3">
                                            {{-- Hidden inputs --}}
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
                                            <input type="hidden" name="task_id" value="{{ $tache->id }}"> {{-- Task ID for update --}}

                                            <div class="col-lg-12 mb-2 mt-2">
                                                <label class="mb-2">Titre</label>
                                                <input type="text" name="titre" class="form-control"
                                                    placeholder="Titre de la tâche"
                                                    value="{{ old('titre', $tache->titre) }}" required>
                                            </div>

                                         

                                            <div class="col-12 mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" id="permission-9" name="echeance"
                                                            class="echeance-toggle form-check-input" value="1"
                                                            @if ($tache->date_debut || $tache->date_fin) checked @endif> {{-- Check if dates exist --}}
                                                    </div>
                                                    <label for="permission-9" class="mb-0" style="font-size: 14px">
                                                        {{ $tache->date_debut || $tache->date_fin ? 'Avec échéance' : 'Ajouter une échéance' }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mb-2 echeance @if (!$tache->date_debut && !$tache->date_fin) d-none @endif"> {{-- Hide if no dates --}}
                                                <label class="mb-2">Date de début</label>
                                                <input type="datetime-local" class="form-control"
                                                    placeholder="Objectif assigné" name="date_debut"
                                                    value="{{ old('date_debut', $tache->date_debut ? \Carbon\Carbon::parse($tache->date_debut)->format('Y-m-d\TH:i') : '') }}">
                                            </div>
                                            <div class="col-lg-12 mb-2 echeance @if (!$tache->date_debut && !$tache->date_fin) d-none @endif"> {{-- Hide if no dates --}}
                                                <label class="mb-2">Date d'échéance</label>
                                                <input type="datetime-local" class="form-control"
                                                    placeholder="Objectif assigné" name="date_fin"
                                                    value="{{ old('date_fin', $tache->date_fin ? \Carbon\Carbon::parse($tache->date_fin)->format('Y-m-d\TH:i') : '') }}">
                                            </div>

                                            <div class="col-lg-12">
                                                <label class="mb-2">Priorité</label>
                                                <select class="form-select select2" aria-label="Default select example"
                                                    name="priorite_id" required>
                                                    <option selected disabled value="">Sélectionnez</option>
                                                    @foreach ($priorites as $priorite)
                                                        <option value="{{ $priorite->id }}"
                                                            @selected(old('priorite_id', $tache->priorite_id) == $priorite->id)>
                                                            {{ $priorite->titre }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-content-right">
                                        <div class="editorBox">
                                            <textarea name="description" id="textarea-edit" cols="30" rows="4"
                                                class="form-control form-control-tache-annotation" placeholder="Saisisez votre annotation...">{{ old('description', $tache->description) }}</textarea>
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
                                                    <button class="btn btn-add"
                                                        style="padding: 10px 24px">Enregistrer les modifications</button>
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

            // Initialize select2 for existing assignation items
            $('.assignation-item-append .select2').select2({
                width: "100%"
            });


            $('body').on('click', '.btn-add-agent', function() {
                let template = $('.assignation-item-template');
                let newAssignationItem = $(template.html()); // Create a new jQuery object from the template HTML

                // Append the new item to the container
                $('.assignation-item-append').append(newAssignationItem);

                // Find elements within the *newly added* item
                var input = newAssignationItem.find('input[data-name]').first();
                var select = newAssignationItem.find('select[data-name]').first();

                // Set attributes for the new input
                if (input.length) {
                    input.attr('name', input.data('name'));
                    input.attr('required', true);
                    input.removeAttr('data-name');
                    input.addClass('tache-target'); // Add class for targeting
                }

                // Set attributes and initialize select2 for the new select
                if (select.length) {
                    select.attr('name', select.data('name'));
                    select.attr('required', true);
                    select.removeAttr('data-name');
                    select.addClass('select-assigne'); // Add class for targeting
                    select.addClass('select2'); // Add select2 class
                    select.select2({
                        width: "100%"
                    });
                }
            });

            $('body').on('click', '.btn-add-objectif', function() {
                var parentAssignationItem = $(this).closest('.assignation-item'); // Find the parent assignation item
                var template = parentAssignationItem.find('.objectif-item-template');
                parentAssignationItem.find('.objectif-item-append').append(template.html());

                var input = parentAssignationItem.find('.objectif-item-append > div').last().find('input');
                var selectTarget = parentAssignationItem.find('.select-assigne'); // Get the associated select for naming

                if (selectTarget.length && selectTarget.val()) {
                    input.attr('name', 'objects[' + selectTarget.val() + '][]');
                } else {
                    // Fallback if no target selected (should ideally not happen if select is required)
                    input.attr('name', input.data('name')); // Use data-name for new items
                }
                input.attr('required', true);
                input.removeAttr('data-name');
                input.addClass('tache-target');
            });


            $('body').on('click', '.btn-remove-objectif', function() {
                $(this).closest('.objectif-item').remove(); // Use closest to remove the correct parent div
            });

            $('body').on('click', '.btn-remove-assignation', function() {
                $(this).closest('.assignation-item').remove(); // Use closest to remove the correct parent div
            });

            $('body').on('change', '.select-assigne', function(e) {
                var assignationItem = $(this).closest('.assignation-item');
                var inputs = assignationItem.find('.tache-target'); // Select only inputs within THIS assignation item
                inputs.attr('name', 'objects[' + e.target.value + '][]');
            });

            $('.echeance-toggle').on('change', function() {
                if ($(this).is(":checked")) {
                    $('.echeance').removeClass('d-none');
                    $(this).parent().parent().find('label').text('Avec échéance');
                } else {
                    $('.echeance').addClass('d-none');
                    $(this).parent().parent().find('label').text('Ajouter une échéance');
                }
            });

            // Set initial state for echeance toggle on page load
            // The `checked` attribute for the checkbox is set in Blade based on $tache->date_debut or $tache->date_fin
            if ($('.echeance-toggle').is(":checked")) {
                $('.echeance').removeClass('d-none'); // Show date blocks if checked
                $('.echeance-toggle').parent().parent().find('label').text('Avec échéance');
            } else {
                $('.echeance').addClass('d-none'); // Hide date blocks if not checked
                $('.echeance-toggle').parent().parent().find('label').text('Ajouter une échéance');
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
            // Populate TinyMCE with existing content
            setup: function(editor) {
                editor.on('init', function() {
                    editor.setContent(`{{ old('description', $tache->description) }}`);
                });
            }
        })
    </script>
@endsection