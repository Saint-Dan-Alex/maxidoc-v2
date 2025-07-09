@extends('regidoc.layouts.master')

@section('content')
    <div class="container-fluid px-lg-4">
        <a href="javascript:history.back()" class="back">
            <i class="bi bi-chevron-left"></i>
            <div class="tooltip-indicator">
                Retour
            </div>
        </a>
        {{-- <h1 class="mb-1">{{ Str::ucfirst($classeur->titre) }}</h1>
        <p class="mb-1 text-muted text-sm" style="font-size: 14px;">Ref: {{ $classeur->reference }}</p>
        <p class="text-muted" style="font-size: 14px;">Créé le: {{ $classeur->created_at->format('d/m/Y') }}</p> --}}
        <div class="row g-lg-3">
            @livewire('document.dossiers', ['classeur' => $classeur])
        </div>
    </div>

    <div class="modal fade" id="modal-new-archive-dossier" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Créer un dossier</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">
                        <form action="{{ route('regidoc.dossiers.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="classeur_id" id="" value="{{ $classeur->id }}">
                            <div class="row g-3">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" placeholder="Réference" name="reference"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <input type="text" class="form-control" placeholder="Denomination" name="titre"
                                        required>
                                </div>
                                <div class="col-lg-12">
                                    <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                        rows="5"></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex">
                                        <span>Confidentiel</span>
                                        <div class="form-check form-switch ms-3">
                                            <input class="form-check-input" type="checkbox" value="0" role="switch"
                                                id="check-date" name="confidentiel">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 password d-none">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <input type="password" name="password" id="" placeholder="Mot de passe"
                                                class="form-control mb-2">
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <input type="password" name="password_confirm" id=""
                                                placeholder="Confirmez le mot de passe" class="form-control mb-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn-add">Créer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($dossiers as $dossier)
        <div class="offcanvas offcanvas-end" tabindex="-1" id="detail-dossier-{{ $dossier->id }}"
            aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header" style="flex-direction: column;">
                <div class="d-flex justify-content-between w-100">
                    <div class="text-star">
                        <h5 id="offcanvasRightLabel" class="mb-1">Détails du dossier </h5>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">
                                Créé le:
                            </span>
                            {{ $dossier->created_at->isoFormat('LLLL') }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            <span style="display: inline-block" class="me-1">Par: </span>
                            {{ $dossier->author?->nom }} {{ $dossier->author?->nom }}
                        </p>
                        <p class="mb-1 d-flex" style="font-size: 12px">
                            {{-- <span style="display: inline-block" class="me-1">Departement: </span>  --}}
                            {{-- {{ $dossier->author?->fonction()->departement?->libelle }} --}}
                        </p>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
            </div>
            <div class="offcanvas-body">
                <div class="block-progress">
                    <div class="card card-notification card-campaing">
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Référence :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $dossier->reference }}
                            </h6>
                        </div>
                        <div class="text-star d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 date">
                                Dénomination :
                            </h6>
                            <h6 class="mb-0 date">
                                {{ $dossier->titre }}
                            </h6>
                        </div>
                    </div>

                    <div class="card card-notification card-campaing">
                        <div class="text-star">
                            <h6 class="mb-3 date">
                                Description
                            </h6>
                            <p style="font-size: 12px;" class="mb-0">
                                {{ $dossier->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-footer">
                <div class="d-flex justify-content-end">
                    {{-- <button class="btn" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-{{ $dossier->id }}">Supprimer</button> --}}
                    {{-- <button class="btn">Modifier</button> --}}
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-edit-archive-dossier-{{ $dossier->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Modifier un dossier</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row g-4">
                            <form action="{{ route('regidoc.dossiers.update', $dossier) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="classeur_id" id="" value="{{ $classeur->id }}">
                                <div class="row g-3">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Réference"
                                            name="reference" value="{{ $dossier->reference }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Denomination"
                                            name="titre" value="{{ $dossier->titre }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea name="description" class="form-control" id="description" placeholder="description" cols="30"
                                            rows="5">{{ $dossier->description }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex">
                                            <span>Confidentiel</span>
                                            <div class="form-check form-switch ms-3">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $dossier->confidentiel }}" role="switch" id="check-date"
                                                    name="confidentiel" @checked($dossier->confidentiel)>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 password @if (!$dossier->confidentiel) d-none @endif">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <input type="password" name="password" id=""
                                                    placeholder="Mot de passe" class="form-control mb-1">
                                                @if ($dossier->confidentiel)
                                                    <small style="font-size: 11px">Laisser vide pour conserver l'ancien</small>
                                                @endif
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <input type="password" name="password_confirm" id=""
                                                    placeholder="Confirmez le mot de passe" class="form-control mb-2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-end">
                                        <button type="submit" class="btn btn-add">Enregistre</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-delete-dossier-{{ $dossier->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Êtes-vous sûr de vouloir supprimer ce dossier ?</h5>
                            <p>Cette action est irréversible.</p>
                        </div>
                        <form action="{{ route('regidoc.dossiers.destroy', $dossier) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mb-3 block-btn d-flex justify-content-center">
                                <a href="#" class="btn btn-cancel me-4" data-bs-dismiss="modal"
                                    aria-label="Close">Annuler</a>
                                <button class="btn btn-delete">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-pass-dossier-{{ $dossier->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center content-text">
                            <i data-feather="trash"></i>
                            <h5>Autorisation</h5>
                            <p>Veuillez saisir le mot de passe pour accéder au dossier</p>
                        </div>
                        <form action="{{ route('regidoc.dossiers.access') }}" method="POST">
                            @csrf
                            <div class="form-group row g-3 align-items-center">
                                <input type="hidden" name="dossier_id" id="" value="{{ $dossier->id }}">
                                <div class="col-12 position-relative">
                                    <label for="password" class="mb-3">Mot de passe</label>
                                    <input type="password" class="form-control form-control-validation"
                                        placeholder="Mot de passe" name="password">
                                </div>
                                <div class="col-12 d-flex mt-2 justify-content-end">
                                    <button class="btn btn-add">{{ __('Accéder') }}</button>
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
        $(document).ready(function() {
            $('input[name=confidentiel]').on('change', function() {
                if ($(this).val() == 0) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }

                if ($(this).val() == 1) {
                    $('.password').removeClass('d-none');
                } else {
                    $('.password').addClass('d-none');
                }
            });
        });
    </script>
@endsection
