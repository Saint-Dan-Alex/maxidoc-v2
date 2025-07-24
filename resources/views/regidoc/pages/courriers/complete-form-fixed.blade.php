@extends('regidoc.layouts.master')

@push('styles')
<style>
    .sidebar-doc {
        position: fixed;
        left: 0;
        top: 0;
        width: 55%;
        height: 100vh;
        overflow-y: auto;
        padding: 20px;
        background: #fff;
        z-index: 1000;
    }
    
    .content-scanner {
        position: fixed;
        right: 0;
        top: 0;
        width: 45%;
        height: 100vh;
        background: #f8f9fa;
        border-left: 1px solid #dee2e6;
        overflow-y: auto;
        padding: 20px;
    }
    
    .required:after {
        content: " *";
        color: #dc3545;
    }
    
    /* Styles pour les petits écrans */
    @media (max-width: 991.98px) {
        .sidebar-doc {
            width: 100%;
            position: relative;
            height: auto;
        }
        
        .content-scanner {
            position: relative;
            width: 100%;
            height: auto;
            min-height: 300px;
        }
    }
</style>
@endpush

@section('content')
<div id="createMailPage">
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex align-items-center">
            <a href="{{ route('regidoc.courriers.index') }}" class="btn-back">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">Retour</div>
            </a>
            <h4 class="ms-2">Compléter le courrier</h4>
        </div>
        
        <form action="{{ route('regidoc.courriers.complete', $courrier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body-siderbar">
                <div class="form-group row g-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Veuillez compléter les informations du courrier
                        </div>
                    </div>

                    <!-- Informations générales -->
                    <div class="col-12">
                        <h5 class="title-info">Informations générales</h5>
                    </div>

                    <!-- Objet du courrier -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label required">Objet du courrier</label>
                            <div class="col-7">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       name="title" value="{{ old('title', $courrier->title ?? '') }}" required>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Référence courrier -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label">Référence courrier</label>
                            <div class="col-7">
                                <input type="text" class="form-control @error('reference') is-invalid @enderror" 
                                       name="reference" value="{{ old('reference', $courrier->reference ?? '') }}">
                                @error('reference')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- N° d'enregistrement -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label">N° d'enregistrement</label>
                            <div class="col-7">
                                <input type="text" class="form-control" value="{{ $courrier->reference_interne ?? '' }}" disabled>
                                <input type="hidden" name="reference_interne" value="{{ $courrier->reference_interne ?? '' }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nature du courrier -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label required">Nature du courrier</label>
                            <div class="col-7">
                                <select class="form-control select2 @error('nature_id') is-invalid @enderror" 
                                        name="nature_id" required>
                                    <option value="">Sélectionnez une nature</option>
                                    @foreach($natures as $nature)
                                        <option value="{{ $nature->id }}" 
                                            {{ old('nature_id', $courrier->nature_id ?? '') == $nature->id ? 'selected' : '' }}>
                                            {{ $nature->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nature_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Catégorie -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label required">Catégorie</label>
                            <div class="col-7">
                                <select class="form-control select2 @error('categorie_id') is-invalid @enderror" 
                                        name="categorie_id" required>
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $categorie)
                                        <option value="{{ $categorie->id }}"
                                            {{ old('categorie_id', $courrier->categorie_id ?? '') == $categorie->id ? 'selected' : '' }}>
                                            {{ $categorie->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Expéditeur -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label required">Expéditeur</label>
                            <div class="col-7">
                                <select class="form-control select2 @error('expediteur_id') is-invalid @enderror" 
                                        name="expediteur_id" required>
                                    <option value="">Sélectionnez un expéditeur</option>
                                    @foreach($expediteurs as $expediteur)
                                        <option value="{{ $expediteur->id }}"
                                            {{ old('expediteur_id', $courrier->expediteur_id ?? '') == $expediteur->id ? 'selected' : '' }}>
                                            {{ $expediteur->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('expediteur_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date du courrier -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label required">Date du courrier</label>
                            <div class="col-7">
                                <input type="date" class="form-control @error('date_courrier') is-invalid @enderror" 
                                       name="date_courrier" 
                                       value="{{ old('date_courrier', isset($courrier->date_courrier) ? $courrier->date_courrier->format('Y-m-d') : '') }}" 
                                       required>
                                @error('date_courrier')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date d'arrivée -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label">Date d'arrivée</label>
                            <div class="col-7">
                                <input type="date" class="form-control" 
                                       value="{{ $courrier->date_arrive->format('Y-m-d') ?? now()->format('Y-m-d') }}" 
                                       disabled>
                                <input type="hidden" name="date_arrive" 
                                       value="{{ $courrier->date_arrive ?? now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Confidentialité -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label">Confidentiel</label>
                            <div class="col-7">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_confidentiel" 
                                           id="is_confidentiel" value="1"
                                           {{ old('is_confidentiel', $courrier->is_confidentiel ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_confidentiel">
                                        Marquer comme confidentiel
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pièce jointe -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-form-label">Pièce jointe</label>
                            <div class="col-7">
                                <input type="file" class="form-control @error('piece_jointe') is-invalid @enderror" 
                                       name="piece_jointe" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                                @error('piece_jointe')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @if($courrier->pieceJointe)
                                    <div class="mt-2">
                                        <a href="{{ $courrier->pieceJointe->getUrl() }}" target="_blank" class="text-primary">
                                            <i class="fas fa-paperclip me-1"></i> {{ $courrier->pieceJointe->file_name }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Objet détaillé -->
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-12 mb-2">Objet détaillé</label>
                            <div class="col-12">
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="4">{{ old('description', $courrier->description ?? '') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-sidebar">
                <a href="{{ route('regidoc.courriers.index') }}" class="btn btn-concel">Annuler</a>
                <button type="submit" class="btn btn-valid">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>

    <!-- Aperçu du document -->
    <div class="content-scanner">
        @if(isset($courrier->document) && $courrier->document->exists)
            <iframe src="{{ $courrier->document->getUrl() }}#toolbar=0" 
                   frameborder="0" 
                   class="w-100" 
                   style="height: 100%; min-height: 600px;"></iframe>
        @else
            <div class="block-no-file">
                <div class="content-scanner-iconFileBox">
                    <img class="content-scanner-iconFileBox-image" 
                         src="{{ asset('assets/images/icons/maxidoc.png') }}" 
                         alt="Aperçu du document">
                </div>
                <h4 class="content-scanner-title">Aucun document joint</h4>
                <p class="content-scanner-subtitle">L'aperçu du document apparaîtra ici</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialisation des sélecteurs Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            language: 'fr',
            placeholder: 'Sélectionnez une option',
            allowClear: true
        });
        
        // Gestion de la prévisualisation du document
        $('input[type="file"]').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('.content-scanner iframe').attr('src', e.target.result);
                    $('.block-no-file').addClass('d-none');
                    $('iframe').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
