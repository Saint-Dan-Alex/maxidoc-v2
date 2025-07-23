@extends('regidoc.layouts.master')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Compléter les informations du courrier</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('regidoc.dashboard') }}">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('regidoc.courriers.index') }}">Courriers</a></li>
                        <li class="breadcrumb-item active">Compléter</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Détails du courrier</h3>
                        </div>
                        
                        <form id="completeForm" action="{{ route('regidoc.courriers.complete', $courrier->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Objet du courrier <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                                   id="title" name="title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="expediteur">Expéditeur <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('expediteur') is-invalid @enderror" 
                                                   id="expediteur" name="expediteur" value="{{ old('expediteur') }}" required>
                                            @error('expediteur')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="reference_courrier">Référence <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('reference_courrier') is-invalid @enderror" 
                                                   id="reference_courrier" name="reference_courrier" value="{{ old('reference_courrier') }}" required>
                                            @error('reference_courrier')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_du_courrier">Date du courrier <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('date_du_courrier') is-invalid @enderror" 
                                                   id="date_du_courrier" name="date_du_courrier" value="{{ old('date_du_courrier', now()->format('Y-m-d')) }}" required>
                                            @error('date_du_courrier')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="date_arrive">Date d'arrivée <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('date_arrive') is-invalid @enderror" 
                                                   id="date_arrive" name="date_arrive" value="{{ old('date_arrive', now()->format('Y-m-d')) }}" required>
                                            @error('date_arrive')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nature_id">Nature du courrier <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('nature_id') is-invalid @enderror" 
                                                    id="nature_id" name="nature_id" required>
                                                <option value="">Sélectionner une nature</option>
                                                @foreach($natures as $nature)
                                                    <option value="{{ $nature->id }}" {{ old('nature_id') == $nature->id ? 'selected' : '' }}>
                                                        {{ $nature->titre }}
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
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="categorie_id">Catégorie <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('categorie_id') is-invalid @enderror" 
                                                    id="categorie_id" name="categorie_id" required>
                                                <option value="">Sélectionner une catégorie</option>
                                                @foreach($categories as $categorie)
                                                    <option value="{{ $categorie->id }}" {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}>
                                                        {{ $categorie->titre }}
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
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="priorite_id">Priorité</label>
                                            <select class="form-control select2" id="priorite_id" name="priorite_id">
                                                <option value="">Sélectionner une priorité</option>
                                                @foreach($priorites as $priorite)
                                                    <option value="{{ $priorite->id }}" {{ old('priorite_id') == $priorite->id ? 'selected' : '' }}>
                                                        {{ $priorite->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="objet">Objet détaillé <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('objet') is-invalid @enderror" 
                                                      id="objet" name="objet" rows="3" required>{{ old('objet') }}</textarea>
                                            @error('objet')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="confidentiel" name="confidentiel" value="1" {{ old('confidentiel') ? 'checked' : '' }}>
                                                <label for="confidentiel" class="custom-control-label">Courrier confidentiel</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="traitement_id">Traitement</label>
                                            <select class="form-control select2" id="traitement_id" name="traitement_id">
                                                <option value="">Sélectionner un type de traitement</option>
                                                @foreach($traitements as $traitement)
                                                    <option value="{{ $traitement->id }}" {{ old('traitement_id') == $traitement->id ? 'selected' : '' }}>
                                                        {{ $traitement->titre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Document scanné</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="document" name="document" accept=".pdf,.jpg,.jpeg,.png" disabled>
                                                    <label class="custom-file-label" for="document">Le document a déjà été téléchargé</label>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">Format acceptés: PDF, JPG, PNG (Max: 10MB)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Enregistrer les informations
                                </button>
                                <a href="{{ route('regidoc.courriers.index') }}" class="btn btn-default float-right">
                                    <i class="fas fa-times"></i> Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            // Initialiser Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            // Gérer l'affichage du nom du fichier dans l'input file
            bsCustomFileInput.init();

            // Soumission du formulaire
            $('#completeForm').on('submit', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const submitBtn = form.find('button[type="submit"]');
                const originalBtnText = submitBtn.html();
                
                // Désactiver le bouton et afficher un indicateur de chargement
                submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Enregistrement...');
                
                // Envoyer la requête AJAX
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Rediriger vers la page de détail du courrier
                            window.location.href = response.redirect;
                        } else {
                            // Afficher le message d'erreur
                            toastr.error(response.message);
                            submitBtn.prop('disabled', false).html(originalBtnText);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Une erreur est survenue lors de l\'enregistrement';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Afficher les erreurs de validation
                            const errors = xhr.responseJSON.errors;
                            errorMessage = 'Veuillez corriger les erreurs suivantes :<br>' + 
                                Object.values(errors).map(error => error[0]).join('<br>');
                        }
                        
                        toastr.error(errorMessage);
                        submitBtn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });
        });
    </script>
@endpush
