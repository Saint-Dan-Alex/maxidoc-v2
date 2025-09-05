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
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <label class="mb-2">Titre de la tâche</label>
                                                <input type="text" class="form-control" name="titre"
                                                    value="{{ old('titre', $tache->titre) }}" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="mb-2">Date d'échéance</label>
                                                <input type="date" class="form-control" name="date_echeance"
                                                    value="{{ old('date_echeance', $tache->date_echeance ? $tache->date_echeance->format('Y-m-d') : '') }}"
                                                    min="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="mb-2">Heure d'échéance</label>
                                                <input type="time" class="form-control" name="heure_echeance"
                                                    value="{{ old('heure_echeance', $tache->heure_echeance) }}" required>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="mb-2">Assignation</label>
                                                <div class="assignation-item-append">
                                                    @foreach (old('assigne_id', $tache->assignes->pluck('id')->toArray() ?? []) as $index => $assigneId)
                                                        <div class="assignation-item mb-2">
                                                            <div class="input-group">
                                                                <select class="form-select select2" name="assigne_id[]"
                                                                    required>
                                                                    <option value="" selected disabled>Sélectionnez un
                                                                        agent</option>
                                                                    @foreach ($agents as $agent)
                                                                        <option value="{{ $agent->id }}"
                                                                            @selected($agent->id == $assigneId)>
                                                                            {{ $agent->full_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($index > 0)
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-remove-assignation"
                                                                        type="button">
                                                                        <i class="fi fi-rr-cross-small"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-agent">
                                                    <i class="fi fi-rr-plus"></i> Ajouter un autre agent
                                                </button>
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
                                                class="form-control form-control-tache-annotation" placeholder="Saisisez votre annotation...">{{ old('description', strip_tags($tache->description)) }}</textarea>
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
                let newAssignationItem = $(template.html());

                $('.assignation-item-append').append(newAssignationItem);

                var input = newAssignationItem.find('input[data-name]').first();
                var select = newAssignationItem.find('select[data-name]').first();

                if (input.length) {
                    input.attr('name', input.data('name'));
                    input.attr('required', true);
                    input.removeAttr('data-name');
                    input.addClass('tache-target');
                }

                if (select.length) {
                    select.attr('name', select.data('name'));
                    select.attr('required', true);
                    select.removeAttr('data-name');
                    select.addClass('select-assigne');
                    select.addClass('select2');
                    select.select2({
                        width: "100%"
                    });
                }
            });

            $('body').on('click', '.btn-remove-assignation', function() {
                $(this).closest('.assignation-item').remove();
            });

            // Handle file dropzone
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.querySelector('input[type="file"]');
            const preview = document.querySelector('.dropzone-preview');
            const previewList = document.querySelector('.dropzone-preview-list');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                dropzone.classList.add('highlight');
            }

            function unhighlight() {
                dropzone.classList.remove('highlight');
            }

            dropzone.addEventListener('drop', handleDrop, false);
            fileInput.addEventListener('change', handleFiles, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles({ target: { files } });
            }

            function handleFiles(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    preview.style.display = 'block';
                    previewList.innerHTML = '';
                    
                    Array.from(files).forEach(file => {
                        const li = document.createElement('li');
                        li.textContent = file.name;
                        previewList.appendChild(li);
                    });
                }
            }

            dropzone.addEventListener('click', () => {
                fileInput.click();
            });
        });

        // TinyMCE initialization
        const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;
        tinymce.init({
            selector: 'textarea#textarea-edit',
            plugins: 'preview autolink visualblocks visualchars image link table nonbreaking advlist lists wordcount spellchecker',
            mobile: {
                menubar: true,
                plugins: 'autosave preview autolink visualblocks visualchars image link table nonbreaking advlist lists wordcount spellchecker',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment'
            },
            menubar: 'file edit view insert format tools table tc help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            height: 300,
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    </script>
    
    <!-- Template for new assignation items -->
    <div class="assignation-item-template d-none">
        <div class="assignation-item mb-2">
            <div class="input-group">
                <select class="form-select select2" data-name="assigne_id[]" required>
                    <option value="" selected disabled>Sélectionnez un agent</option>
                    @foreach ($agents as $agent)
                        <option value="{{ $agent->id }}">
                            {{ $agent->full_name }}
                        </option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-outline-danger btn-remove-assignation" type="button">
                    <i class="fi fi-rr-cross-small"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
