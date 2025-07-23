@extends('regidoc.layouts.layout-doc')

@section('style')
    <style>
        .upload-options {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .upload-option {
            background: #fff;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .upload-option:hover {
            border-color: var(--primaryColor);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .upload-option i {
            font-size: 3rem;
            color: var(--primaryColor);
            margin-bottom: 1rem;
        }
        
        .upload-option h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .upload-option p {
            color: #666;
            margin-bottom: 0;
        }
        
        .upload-form {
            display: none;
            margin-top: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .upload-active {
            display: block;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            color: var(--primaryColor);
            margin-bottom: 1.5rem;
            text-decoration: none;
        }
        
        .btn-back i {
            margin-right: 0.5rem;
        }
        
        .file-upload-wrapper {
            position: relative;
            width: 100%;
            margin-top: 1rem;
        }
        
        .file-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }
        
        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed #ccc;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            border-color: var(--primaryColor);
            background: rgba(var(--primaryRGB), 0.05);
        }
        
        .file-upload-label i {
            font-size: 2.5rem;
            color: var(--primaryColor);
            margin-bottom: 1rem;
        }
        
        .file-upload-label p {
            margin: 0;
            color: #666;
        }
        
        .file-upload-label .file-name {
            margin-top: 0.5rem;
            font-weight: 500;
            color: var(--primaryColor);
        }
        
        .btn-upload {
            margin-top: 1.5rem;
            padding: 0.75rem 2rem;
            background-color: var(--primaryColor);
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .btn-upload:hover {
            background-color: var(--primaryDarkColor);
        }
        
        .btn-upload:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <a href="{{ route('regidoc.courriers.index') }}" class="btn-back">
                    <i class="fi fi-rr-arrow-left"></i>
                    Retour à la liste des courriers
                </a>
                <h2 class="mb-4">Déposer un nouveau document</h2>
                <p class="text-muted">Sélectionnez une méthode pour déposer votre document. Les informations détaillées pourront être complétées ultérieurement par un assistant.</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <form id="uploadForm" action="{{ route('regidoc.courriers.upload-initial') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="upload-options">
                        <div class="upload-option" id="scanOption">
                            <i class="fi fi-rr-print"></i>
                            <h3>Scanner un document</h3>
                            <p>Connectez un scanner pour numériser un document papier</p>
                            <div class="upload-form" id="scanForm">
                                <div class="alert alert-info">
                                    <i class="fi fi-rr-info"></i>
                                    Assurez-vous que votre scanner est correctement connecté et allumé.
                                </div>
                                <button type="button" class="btn btn-primary" id="startScan">
                                    <i class="fi fi-rr-camera"></i> Démarrer la numérisation
                                </button>
                                <input type="hidden" name="is_scan" id="is_scan" value="0">
                            </div>
                        </div>
                        
                        <div class="upload-option" id="uploadOption">
                            <i class="fi fi-rr-upload"></i>
                            <h3>Importer un fichier</h3>
                            <p>Téléchargez un document depuis votre ordinateur</p>
                            <div class="upload-form" id="uploadFormContainer">
                                <div class="file-upload-wrapper">
                                    <input type="file" id="document" name="document" class="file-upload-input" accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="document" class="file-upload-label">
                                        <i class="fi fi-rr-file-import"></i>
                                        <p>Glissez-déposez votre fichier ici ou cliquez pour le sélectionner</p>
                                        <span class="file-name" id="fileName"></span>
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Formats acceptés : PDF, JPG, PNG (Max. 10 Mo)</small>
                            </div>
                        </div>
                        
                        <div class="upload-option" id="selectOption">
                            <i class="fi fi-rr-document"></i>
                            <h3>Sélectionner un document existant</h3>
                            <p>Choisissez un document déjà téléchargé dans votre espace de stockage</p>
                            <div class="upload-form" id="selectForm">
                                <select class="form-select" id="existingDocument" name="existing_document">
                                    <option value="">Sélectionnez un document</option>
                                    <!-- Les documents seront chargés ici dynamiquement -->
                                </select>
                                <button type="button" class="btn btn-outline-secondary mt-3" id="refreshDocs">
                                    <i class="fi fi-rr-refresh"></i> Actualiser la liste
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                            <i class="fi fi-rr-upload"></i> Déposer le document
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/scannerjs/scanner.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanOption = document.getElementById('scanOption');
            const uploadOption = document.getElementById('uploadOption');
            const selectOption = document.getElementById('selectOption');
            const scanForm = document.getElementById('scanForm');
            const uploadForm = document.getElementById('uploadFormContainer');
            const selectForm = document.getElementById('selectForm');
            const fileInput = document.getElementById('document');
            const fileName = document.getElementById('fileName');
            const submitBtn = document.getElementById('submitBtn');
            const isScanInput = document.getElementById('is_scan');
            const existingDocument = document.getElementById('existingDocument');
            const refreshBtn = document.getElementById('refreshDocs');
            
            // Gérer le clic sur une option d'upload
            [scanOption, uploadOption, selectOption].forEach(option => {
                option.addEventListener('click', function(e) {
                    // Ne pas déclencher si on clique sur un élément à l'intérieur du formulaire
                    if (e.target.closest('.upload-form') || e.target === submitBtn) {
                        return;
                    }
                    
                    // Réinitialiser tous les formulaires
                    [scanForm, uploadForm, selectForm].forEach(form => {
                        form.classList.remove('upload-active');
                    });
                    
                    // Désactiver tous les champs de formulaire
                    document.querySelectorAll('.upload-form input, .upload-form select').forEach(field => {
                        field.disabled = true;
                    });
                    
                    // Activer le formulaire correspondant
                    const formId = this.id.replace('Option', 'Form');
                    const activeForm = document.getElementById(formId);
                    if (activeForm) {
                        activeForm.classList.add('upload-active');
                        // Activer les champs du formulaire actif
                        activeForm.querySelectorAll('input, select').forEach(field => {
                            field.disabled = false;
                        });
                    }
                    
                    // Activer le bouton de soumission si un document est déjà sélectionné
                    checkFormValidity();
                    
                    // Mettre à jour l'option sélectionnée visuellement
                    [scanOption, uploadOption, selectOption].forEach(opt => {
                        opt.style.borderColor = opt === this ? 'var(--primaryColor)' : '#e0e0e0';
                    });
                });
            });
            
            // Gérer la sélection d'un fichier
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileName.textContent = this.files[0].name;
                    checkFormValidity();
                }
            });
            
            // Gérer la sélection d'un document existant
            existingDocument.addEventListener('change', function() {
                checkFormValidity();
            });
            
            // Vérifier si le formulaire est valide
            function checkFormValidity() {
                const isScanSelected = scanForm.classList.contains('upload-active') && isScanInput.value === '1';
                const isFileSelected = uploadForm.classList.contains('upload-active') && fileInput.files && fileInput.files[0];
                const isDocSelected = selectForm.classList.contains('upload-active') && existingDocument.value !== '';
                
                submitBtn.disabled = !(isScanSelected || isFileSelected || isDocSelected);
            }
            
            // Gérer le clic sur le bouton de numérisation
            const startScanBtn = document.getElementById('startScan');
            if (startScanBtn) {
                startScanBtn.addEventListener('click', function() {
                    // Code pour démarrer la numérisation
                    alert('Fonctionnalité de numérisation à implémenter');
                    // Pour l'instant, on simule une numérisation réussie
                    isScanInput.value = '1';
                    checkFormValidity();
                    
                    // Mettre à jour l'interface
                    startScanBtn.innerHTML = '<i class="fi fi-rr-check"></i> Document scanné avec succès';
                    startScanBtn.classList.remove('btn-primary');
                    startScanBtn.classList.add('btn-success');
                });
            }
            
            // Gérer le clic sur le bouton d'actualisation des documents
            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    // Code pour actualiser la liste des documents
                    alert('Actualisation de la liste des documents à implémenter');
                });
            }
            
            // Empêcher la soumission du formulaire si aucun document n'est sélectionné
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    alert('Veuillez sélectionner un document à déposer.');
                }
            });
            
            // Initialiser le glisser-déposer
            const dropArea = document.querySelector('.file-upload-label');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropArea.classList.add('highlight');
            }
            
            function unhighlight() {
                dropArea.classList.remove('highlight');
            }
            
            dropArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                
                if (files.length) {
                    fileInput.files = files;
                    fileName.textContent = files[0].name;
                    checkFormValidity();
                }
            }
        });
    </script>
@endpush
