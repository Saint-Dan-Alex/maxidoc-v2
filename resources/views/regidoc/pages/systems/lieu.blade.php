@extends('regidoc.layouts.master')
@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Lieux d'affectation</h1>
            <p class="text-star-subtitle mb-0">
                Gérer les lieux d'affectation
            </p>
        </div>
        <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div>
    </div>
    <div class="container-fluid px-lg-2 block-top-margin">
        <div class="mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.lieu')
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-new-lieu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Ajouter un lieu</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('regidoc.lieux.store') }}" method="POST">
                        @csrf
                        <div class="form-group row g-4">
                            <div class="col-lg-12">
                                <label for="">Titre</label>
                                <input type="text" name="titre" class="form-control" placeholder="Nom du lieu"
                                    required>
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

    {{-- @foreach ($lieus as $lieu)
        <div class="modal fade" id="modal-edit-lieu-{{ $lieu->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier un lieu</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('regidoc.lieux.update', $lieu->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group row g-4">
                                <div class="col-lg-12">
                                    <label for="">Titre</label>
                                    <input type="text" name="titre" class="form-control" value="{{ $lieu->titre }}"
                                        placeholder="Nom du lieu" required>
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
        {{-- <div class="modal fade" id="modal-show-lieu-{{ $lieu->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Liste des Employés</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($lieu->agents as $agent)
                            <ul>
                                <li> {{ $agent->prenom . ' ' . $agent->nom }} <strong> {{ $agent->service?->titre }}
                                    </strong>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> -}}
    @endforeach --}}
@endsection
