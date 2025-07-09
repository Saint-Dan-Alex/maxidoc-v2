<div class="col-lg-12">

    <div class="card card-table" style="overflow: inherit">
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche" style="border:none;"
                        wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                </path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                    modification</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ms-auto d-flex align-items-center justify-content-end">

                <a href="#" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-secretariat">
                    Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Direction</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($secretariats as $secretariat)
                        <tr>
                            <td class="text-truncate"> {{ $secretariat->titre }} </td>
                            <td class="text-truncate"> {{ $secretariat->direction?->titre }} </td>
                            <td> {{ $secretariat->user?->name }} </td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table">
                                    {{-- <a href="#" class="btn btn-primary text-white p-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-show-secretariat-{{ $secretariat->id }}"><i
                                            class="fi fi-rr-eye"></i>
                                        Voir</a> --}}
                                    <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-secretariat-{{ $secretariat->id }}"><i
                                            class="fi fi-rr-pencil"></i>
                                        Editer</a>
                                    <form action="{{ route('regidoc.secretariats.destroy', $secretariat) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fi fi-rr-trash"></i>
                                            Supprimer</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="5">
                                <div class="text-center col-12">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px"
                                        class="">
                                    <p>Aucun departement trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {!! $secretariats->links() !!}
    </div>

    <div class="modal fade" id="modal-new-secretariat" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter une secretariat</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.secretariats.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="titre" class="form-control" placeholder="Nom du secretariat"
                                    required>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Direction</label>
                                <select name="direction_id" class="form-control select2Bis" required
                                    data-placeholder="Selectionner">
                                    <option value=""></option>
                                    @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}"> {{ $direction->titre }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="">Responsable</label>
                                <select name="responsable_id" class="form-control select2" required
                                    data-placeholder="Selectionner"
                                    data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                    data-get-items-field="nom" data-method="get"
                                    data-label="prenom,nom,post_nom"
                                    data-related-model="Agent">
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-3">
                                    <div>
                                        <label for="dg">Secretaire DG</label>
                                        <input type="radio" name="for" id="dg" value="1">
                                    </div>
                                    <div>
                                        <label for="dga">Secretaire DGA</label>
                                        <input type="radio" name="for" id="dga" value="2">
                                    </div>
                                    <div>
                                        <label for="direction">Secretaire Direction</label>
                                        <input type="radio" name="for" id="direction" value="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add">Ajouter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($secretariats as $secretariat)
        <div class="modal fade" id="modal-edit-secretariat-{{ $secretariat->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier un secretariat</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('regidoc.secretariats.update', $secretariat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control"
                                        value="{{ $secretariat->titre }}" placeholder="Nom du secretariat" required>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Direction</label>
                                    <select name="direction_id" class="form-control select2Bis" required>
                                        <option value="">Selectionnez la direction</option>
                                        @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}" @selected($secretariat->direction_id == $direction->id)>
                                                {{ $direction->titre }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="">Responsable</label>
                                    <select name="responsable_id" class="form-control select2" required
                                        data-placeholder="Selectionner"
                                        data-get-items-route="{{ route('regidoc.ajax.getAgents') }}"
                                        data-get-items-field="nom" data-method="get"
                                        data-label="prenom,nom,post_nom"
                                        data-related-model="Agent">
                                        <option value="{{ $secretariat->responsable_id }}">{{ $secretariat->responsable?->prenom.' '.$secretariat->responsable?->nom.' '.$secretariat->responsable?->post_nom }}</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <label for="dg">Secretaire DG</label>
                                            <input type="radio" name="for" id="dg" value="1" @checked($secretariat->for_dg)>
                                        </div>
                                        <div>
                                            <label for="dga">Secretaire DGA</label>
                                            <input type="radio" name="for" id="dga" value="2" @checked($secretariat->for_dga)>
                                        </div>
                                        <div>
                                            <label for="direction">Secretaire Direction</label>
                                            <input type="radio" name="for" id="direction" value="3" @checked($secretariat->for_dg != 1 && $secretariat->for_dga != 1)>
                                        </div>
                                    </div>
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
</div>

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
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
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
