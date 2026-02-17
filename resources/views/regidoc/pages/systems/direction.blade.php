 {{-- @dd($lieus) --}}
@extends('layouts.app-settings')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Direction</h1>
            <p class="text-star-subtitle mb-0">Gérer les directions</p>
        </div>
    </div>

    @if (session()->has('session'))
        @php $flash = json_decode(session()->get('session')); @endphp
        @if ($flash)
            <div class="message-flash {{ $flash->statut }} show">
                <div class="content-text d-flex justify-content-center  gap-2">
                    <div class="content-text-imageBox d-flex justify-content-center align-items-center">
                        @if ($flash->statut === 'success')
                            <img src="{{ asset('assets/images/icons/iconvert-maxidoc.svg') }}" alt="icon success">
                        @elseif ($flash->statut === 'warnig' || $flash->statut === 'warning')
                            <img src="{{ asset('assets/images/icons/iconorange-maxidoc.svg') }}" alt="icon warning">
                        @else
                            <img src="{{ asset('assets/images/icons/error-icon.png') }}" alt="icon error">
                        @endif
                    </div>
                    <div class="text-star">
                        <h6>{{ $flash->name ?? 'Information' }}</h6>
                        <p>{{ $flash->message ?? '' }}</p>
                    </div>
                </div>
            </div>
            @php Session::forget('session'); @endphp
        @endif
    @endif

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
                        <div class="col-12 mb-3">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Code" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label>Titre</label>
                            <input type="text" name="libelle" class="form-control" placeholder="Nom de la direction" required>
                        </div>
                        <div class="col-12 position-relative mb-3">
                            <label for="add-lieu-ids">Lieux d'affectation</label>
                            <select name="lieu_ids[]" id="add-lieu-ids" class="form-control select2Bis" data-placeholder="Sélectionner les lieux" multiple required>
                                @foreach ($lieus as $lieu)
                                    <option value="{{ $lieu->id }}">{{ $lieu->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 position-relative mb-3">
                            <label>Responsable</label>
                            <select name="responsable_id" class="form-control select2Bis" data-placeholder="Sélectionner le responsable">
                                <option value=""></option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->prenom }} {{ $agent->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12 position-relative mb-3">
                            <label>Responsable Adjoint</label>
                            <select name="adjoint_id" class="form-control select2Bis" data-placeholder="Sélectionner le responsable adjoint">
                                <option value=""></option>
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

    {{-- MODALES MODIFICATION - DÉPLACÉES DANS LE COMPOSANT LIVEWIRE --}}
    {{-- Les modales sont maintenant gérées dans resources/views/livewire/systems/direction.blade.php --}}
<style>
    /* Style pour les labels et les sélecteurs dans les modaux */
    .modal .form-group label {
        display: block;
        width: 100%;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    
    .modal .form-group .select2-container {
        width: 100% !important;
    }
    
    .modal .select2-container--default .select2-selection--single,
    .modal .select2-container--default .select2-selection--multiple {
        min-height: 45px;
        padding: 5px 12px;
        background-color: #ffffff !important;
        border: 1px solid #adb5bd !important; /* Gris plus foncé et net */
        border-radius: 8px;
        transition: all 0.2s ease-in-out;
        cursor: text;
    }

    .modal .select2-container--default .select2-selection--single:hover,
    .modal .select2-container--default .select2-selection--multiple:hover {
        border-color: #6c757d !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .modal .select2-container--default.select2-container--focus .select2-selection--single,
    .modal .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: var(--primaryColor) !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .modal .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }

    .modal .select2-container--default .select2-selection--multiple .select2-selection__rendered {
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .modal .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: var(--primaryColor);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 2px 8px;
        margin: 0;
    }

    .modal .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
    }
    
    /* Ajustement de la largeur du menu déroulant */
    .select2-dropdown {
        min-width: 300px !important;
    }
    
    /* Ajustement de la largeur du conteneur du select */
    .select2-container {
        width: 100% !important;
    }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialisation de Select2 pour les modaux
        function initSelect2() {
            $('.select2Bis').each(function() {
                $(this).select2({
                    placeholder: $(this).data('placeholder') || 'Sélectionner...',
                    language: "fr",
                    dropdownParent: $(this).closest('.modal'), // Assure que le menu déroulant s'affiche correctement dans le modal
                    allowClear: true,
                    width: '100%',
                    // Pour avoir l'apparence de multiple mais avec une seule sélection
                    templateResult: function(data) {
                        return data.text;
                    },
                    templateSelection: function(data) {
                        return data.text;
                    }
                });
            });
        }

        // Initialisation au chargement de la page
        initSelect2();

        // Réinitialisation des champs du modal d'ajout quand il est fermé
        $('#modal-new-direction').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('.select2Bis').val(null).trigger('change'); // Réinitialise les sélecteurs Select2
        });

        // Les modales d'édition sont maintenant gérées dans le composant Livewire
    });
</script>

@endpush

@endsection

