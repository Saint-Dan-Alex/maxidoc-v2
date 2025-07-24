<div id="createMailPage">
    <div class="sidebar-doc">
        <div class="header-sidebar d-flex align-items-center">
            <a href="{{ route('regidoc.courriers.index') }}" class="btn-back"
                style="font-size: 14px; color: var(--colorTitle)">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h4 class="ms-0 ms-2">Compléter le courrier</h4>
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
                        <div class="row">
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

                    <!-- Suite du formulaire... -->

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
        <div class="container-fluid d-none d-lg-block">
            @if(isset($courrier->document) && $courrier->document->exists)
                <iframe src="{{ $courrier->document->getUrl() }}#toolbar=0" frameborder="0" class="w-100" style="height: 100%; min-height: 600px;"></iframe>
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
</div>

<!-- Styles -->
@push('styles')
<style>
    .required:after {
        content: " *";
        color: #dc3545;
    }
    
    .title-info {
        color: var(--colorTitle);
        font-weight: 600;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
        margin-bottom: 15px;
    }
    
    .btn-concel {
        background-color: #f8f9fa;
        color: #6c757d;
        border: 1px solid #dee2e6;
        padding: 8px 20px;
        border-radius: 4px;
        text-decoration: none;
    }
    
    .btn-valid {
        background-color: var(--primaryColor);
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 4px;
    }
    
    .btn-valid:hover {
        background-color: var(--primaryDarkColor);
        color: white;
    }
    
    .footer-sidebar {
        padding: 15px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
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
    
    .block-no-file {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        color: #6c757d;
    }
    
    .content-scanner-iconFileBox {
        width: 80px;
        margin-bottom: 15px;
    }
    
    .content-scanner-title {
        font-size: 1.2rem;
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .content-scanner-subtitle {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>
@endpush

<!-- Scripts -->
@push('scripts')
<script>
    $(document).ready(function() {
        // Initialisation des sélecteurs
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
                    $('.content-scanner iframe').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush
