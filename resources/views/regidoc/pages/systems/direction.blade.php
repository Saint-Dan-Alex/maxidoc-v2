 {{-- @dd($lieus) --}}
@extends('layouts.app-settings')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Direction</h1>
            <p class="text-star-subtitle mb-0">Gérer les directions</p>
        </div>
    </div>

    <div class="container-fluid px-lg-2 block-top-margin">
        <div class="mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.direction', ['directions' => $directions])
            </div>
        </div>
    </div>

    {{-- MODALE AJOUT --}}
    <div class="modal fade" id="modal-new-direction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('regidoc.directions.store') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une Direction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">
                        <div class="col-12">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Code" required>
                        </div>
                        <div class="col-12">
                            <label>Titre</label>
                            <input type="text" name="libelle" class="form-control" placeholder="Nom de la direction" required>
                        </div>
                        <div class="col-12">
                            <label>Lieu</label>
                            <select name="lieu_id" class="form-control select2Bis" data-placeholder="Sélectionner le lieu" required>
                                <option value="">Sélectionner</option>
                                @foreach ($lieus as $lieu)
                                    <option value="{{ $lieu->id }}">{{ $lieu->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 position-relative">
                            <label>Responsable</label>
                            <select name="responsable_id" class="form-control select2Bis" data-placeholder="Sélectionner le responsable">
                                <option value="">Sélectionner</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->prenom }} {{ $agent->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12 position-relative mt-3">
                            <label>Responsable Adjoint</label>
                            <select name="adjoint_id" class="form-control select2Bis" data-placeholder="Sélectionner le responsable adjoint">
                                <option value="">Sélectionner</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->prenom }} {{ $agent->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12 text-end">
                            <button class="btn btn-add">Ajouter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- MODALES MODIFICATION --}}
    @foreach ($directions as $direction)
        <div class="modal fade" id="modal-edit-direction-{{ $direction->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('regidoc.directions.update', $direction->id) }}" method="POST" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier une Direction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row g-4">
                            <div class="col-12">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" value="{{ $direction->code }}" required>
                            </div>
                            <div class="col-12">
                                <label>Titre</label>
                                <input type="text" name="libelle" class="form-control" value="{{ $direction->titre }}" required>
                            </div>
                            <div class="col-12 position-relative">
                                <label>Responsable</label>
                                <select name="responsable_id" class="form-control select2Bis" data-placeholder="Sélectionner le responsable">
                                    <option value="">Sélectionner</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected($direction->responsable_id == $agent->id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-12 position-relative mt-3">
                                <label>Responsable Adjoint</label>
                                <select name="adjoint_id" class="form-control select2Bis" data-placeholder="Sélectionner le responsable adjoint">
                                    <option value="">Sélectionner</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}" @selected($direction->adjoint_id == $agent->id)>
                                            {{ $agent->prenom }} {{ $agent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            
                            <div class="col-12 text-end">
                                <button class="btn btn-add">Modifier</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@endsection

