@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Direction</h1>
            <p class="text-star-subtitle mb-0">
                Gérer les directions
            </p>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-2 block-top-margin">

        <div class="mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.direction', ['directions' => $directions])
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-new-direction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter une Direction</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.directions.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Code</label>
                                <input type="text" name="code" class="form-control" placeholder="Code" required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="libelle" class="form-control" placeholder="Nom du Direction"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Lieu</label>
                                <select name="lieu_id" class="form-control select2Bis" required
                                    data-placeholder="Selectionner">
                                    <option value="">Selectionnez le lieu</option>
                                    @foreach ($lieus as $lieu)
                                        <option value="{{ $lieu->id }}">
                                            {{ $lieu->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control select2" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents') }}" data-get-items-field="nom"
                                    data-method="get" data-label="prenom,nom,post_nom" data-related-model="Agent">
                                    {{-- <option value="">Selectionnez le responsable</option> --}}
                                    {{-- @foreach ($users as $user)
                                    <option value="{{ $user->agent?->id }}">
                                        {{ $user->agent?->prenom . ' ' . $user->agent?->nom }} </option>
                                @endforeach --}}
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable Ajoint</label>
                                <select name="adjoint_id" class="form-control select2" data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents') }}" data-get-items-field="nom"
                                    data-method="get" data-label="prenom,nom,post_nom" data-related-model="Agent">
                                </select>
                            </div>
                            {{-- <div class="col-lg-12">
                            <label for="">Description</label>
                            <textarea name="description" class="form-control" cols="30" rows="5"></textarea>
                        </div> --}}
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($directions->get() as $direction)
        <div class="modal fade" id="modal-edit-direction-{{ $direction->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier une Direction</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('regidoc.directions.update', $direction->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="">Code</label>
                                    <input type="text" name="code" class="form-control" value="{{ $direction->code }}"
                                        placeholder="Code de Direction" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="libelle" class="form-control"
                                        value="{{ $direction->titre }}" placeholder="Nom de Direction" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Lieu</label>
                                    <select name="lieu_id" class="form-control select2Bis" required
                                        data-placeholder="Selectionner">
                                        <option value="">Selectionnez le lieu</option>
                                        @foreach ($lieus as $lieu)
                                            <option value="{{ $lieu->id }}" @selected($direction->lieu_id == $lieu->id)>
                                                {{ $lieu->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-id="{{ $direction->id }}">
                                        <option value="{{ $direction->responsable_id }}">
                                            {{ $direction->responsable?->prenom . ' ' . $direction->responsable?->nom . ' ' . $direction->responsable?->post_nom }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable Adjoint</label>
                                    <select name="adjoint_id" class="form-control select2"
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get" data-label="prenom,nom,post_nom"
                                        data-related-model="Agent" data-id="{{ $direction->id }}">
                                        <option value="{{ $direction->responsable_id }}">
                                            {{ $direction->adjoint?->prenom . ' ' . $direction->adjoint?->nom . ' ' . $direction->adjoint?->post_nom }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <button class="btn btn-add">Modifier</button>
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
    <script>
        $('select.select2').each(function() {
            console.log($(this).data('get-items-route'));
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

        $('.select2Bis').each(function() {
            $(this).select2({
                placeholder: $(this).data('placeholder'),
                language: "fr",
                width: '100%',
                dropdownParent: $(this).parent()
            });
        });
    </script>
@endsection
