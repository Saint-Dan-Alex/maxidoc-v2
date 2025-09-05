<div class="col-12">
    <h6>Ajouter une pièce jointe</h6>
</div>

<div wire:ignore>
    <form id="fileUploadForm" action="{{ route('taches.documents.store', $tache) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="documentFile" class="form-label">Sélectionner un document</label>
            <select class="form-select" id="documentFile" required>
                <option value="" selected disabled>Sélectionnez un fichier...</option>
                <option value="upload">Téléverser un fichier</option>
            </select>
            
            <div id="fileInputContainer" class="mt-3" style="display: none;">
                <input type="file" name="file" id="fileInput" class="form-control" accept="image/*,.pdf" required>
                <div class="form-text">Formats acceptés : images et PDF</div>
            </div>
        </div>
        
        <button type="submit" id="submitBtn" class="btn btn-primary" disabled>
            <span id="submitText">Enregistrer</span>
            <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status">
                <span class="visually-hidden">Chargement...</span>
            </span>
        </button>
    </form>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true" style="z-index: 9999;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center" id="confirmationModalLabel">
                    <i class="fi fi-rr-document-signed me-2"></i>
                    <span>Confirmation d'ajout</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-start mb-3">
                    <i class="fi fi-rr-info text-primary me-3 mt-1"></i>
                    <div>
                        <p class="mb-2">Veuillez vérifier l'aperçu du document avant confirmation :</p>
                        <div id="documentPreview" class="text-center mt-3" style="min-height: 200px; background-color: #f8f9fa; border-radius: 4px; border: 1px dashed #dee2e6; display: flex; align-items: center; justify-content: center;">
                            <div class="py-4">
                                <i class="fi fi-rr-file-upload fs-1 text-muted mb-2 d-block"></i>
                                <span class="text-muted">Aperçu du document</span>
                            </div>
                        </div>
                        <p class="small text-muted mt-3 mb-0">
                            <i class="fi fi-rr-shield-check me-1"></i> 
                            Le document sera traité et ne pourra pas être supprimé après enregistrement.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fi fi-rr-cross-small me-1"></i> Annuler
                </button>
                <button type="button" id="confirmUpload" class="btn btn-primary">
                    <i class="fi fi-rr-check me-1"></i> Confirmer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('assets/js/pdfjs/pdf.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const documentSelect = document.getElementById('documentFile');
        const fileInputContainer = document.getElementById('fileInputContainer');
        const fileInput = document.getElementById('fileInput');
        const submitBtn = document.getElementById('submitBtn');
        const confirmationModalElement = document.getElementById('confirmationModal');
        const form = document.getElementById('fileUploadForm');
        let confirmationModal = null;
        
        // Initialize modal only if the element exists and Bootstrap is available
        if (confirmationModalElement && typeof bootstrap !== 'undefined') {
            confirmationModal = new bootstrap.Modal(confirmationModalElement, {
                backdrop: 'static',
                keyboard: false
            });
            
            // Ensure modal is in the body to prevent z-index issues
            document.body.appendChild(confirmationModalElement);
        }

        // Show file input when 'Téléverser un fichier' is selected
        documentSelect.addEventListener('change', function() {
            if (this.value === 'upload') {
                fileInputContainer.style.display = 'block';
                submitBtn.disabled = true; // Désactiver le bouton jusqu'à ce qu'un fichier soit sélectionné
                // Réinitialiser l'aperçu
                document.getElementById('documentPreview').innerHTML = `
                    <div class="py-4">
                        <i class="fi fi-rr-file-upload fs-1 text-muted mb-2 d-block"></i>
                        <span class="text-muted">Aperçu du document</span>
                    </div>`;
            } else {
                fileInputContainer.style.display = 'none';
                submitBtn.disabled = false;
            }
        });

        // Handle file selection
        fileInput.addEventListener('change', async function(e) {
            if (this.files && this.files[0]) {
                // Reset preview
                const previewContainer = document.getElementById('documentPreview');
                previewContainer.innerHTML = `
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </div>`;

                const file = this.files[0];
                const fileType = file.type;
                const isPdf = fileType === 'application/pdf';
                const isImage = fileType.startsWith('image/');

                if (isImage) {
                    // Preview for images
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `
                            <img src="${e.target.result}" class="img-fluid" style="max-height: 300px; object-fit: contain;" alt="Aperçu du document">
                            <div class="text-center mt-2">
                                <small class="text-muted">${file.name}</small>
                            </div>`;
                        submitBtn.disabled = false;
                    };
                    reader.readAsDataURL(file);
                } else if (isPdf) {
                    // Preview for PDFs using server-side Imagick
                    const formData = new FormData();
                    formData.append('file', file);
                    
                    try {
                        const response = await fetch('{{ route("taches.generatePdfPreview") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (data.success && data.preview_url) {
                            previewContainer.innerHTML = `
                                <img src="${data.preview_url}" class="img-fluid" style="max-height: 300px; object-fit: contain;" alt="Aperçu du document">
                                <div class="text-center mt-2">
                                    <small class="text-muted">${file.name}</small>
                                </div>`;
                        } else {
                            throw new Error(data.message || 'Erreur lors de la génération de l\'aperçu');
                        }
                    } catch (error) {
                        console.error('Erreur lors de la génération de l\'aperçu PDF :', error);
                        previewContainer.innerHTML = `
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center text-muted">
                                    <i class="fi fi-rr-file-pdf fs-1 d-block mb-2"></i>
                                    <span>Impossible de générer l'aperçu du PDF</span>
                                    <p class="small mt-2">${error.message || ''}</p>
                                </div>
                            </div>`;
                    }
                } else {
                    // For unsupported file types
                    previewContainer.innerHTML = `
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <div class="text-center text-muted">
                                <i class="fi fi-rr-file fs-1 d-block mb-2"></i>
                                <span>Format non supporté pour l'aperçu</span>
                                <p class="small mt-2">${file.name}</p>
                            </div>
                        </div>`;
                }
                submitBtn.disabled = false;
                // Display file preview if needed
                if (this.files[0].type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Handle image preview if needed
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            } else {
                submitBtn.disabled = true;
            }
        });

        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (documentSelect.value === 'upload' && !fileInput.files.length) {
                alert('Veuillez sélectionner un fichier à téléverser.');
                return false;
            }
            
            // Check if modal is initialized
            if (confirmationModal) {
                confirmationModal.show();
            } else {
                // Fallback if modal fails
                if (confirm('Êtes-vous sûr de vouloir ajouter ce document ? Cette action est irréversible.')) {
                    submitForm();
                }
            }
        });

        // Handle confirmation
        const confirmButton = document.getElementById('confirmUpload');
        if (confirmButton) {
            confirmButton.addEventListener('click', submitForm);
        }
        
        function submitForm() {
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            const formData = new FormData(form);
            
            // Show loading state
            submitText.textContent = 'Traitement...';
            submitSpinner.classList.remove('d-none');
            submitBtn.disabled = true;
            
            // Submit the form via AJAX
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then((data) => {
                // Reset form
                form.reset();
                fileInputContainer.style.display = 'none';
                submitBtn.disabled = true;
                documentSelect.value = '';
                
                // Hide modal if exists
                if (confirmationModal) {
                    confirmationModal.hide();
                    // Force remove backdrop if still present
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => backdrop.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                }
                
                // Emit an event to refresh the parent component
                window.dispatchEvent(new CustomEvent('document-uploaded', { detail: data }));
                
                // Show success message in URL hash to be displayed after page reload
                const successMessage = encodeURIComponent(data.message || 'Le document a été ajouté avec succès.');
                window.location.href = window.location.pathname + '?success=' + successMessage;
            })
            .catch(error => {
                console.error('Erreur lors du téléversement:', error);
                let errorMessage = 'Une erreur est survenue lors du téléversement du fichier';
                
                if (error.message) {
                    errorMessage += ': ' + error.message;
                } else if (error.errors && error.errors.file) {
                    errorMessage = error.errors.file[0];
                } else if (error.error) {
                    errorMessage = error.error;
                }
                
                alert(errorMessage);
            })
            .finally(() => {
                // Reset button state
                const submitText = document.getElementById('submitText');
                const submitSpinner = document.getElementById('submitSpinner');
                
                if (submitText) submitText.textContent = 'Enregistrer';
                if (submitSpinner) submitSpinner.classList.add('d-none');
                if (submitBtn) submitBtn.disabled = false;
            });
        }

        // Process file with Imagick (client-side preview)
        function processFileWithImagick(file) {
            // This is a client-side preview. Actual Imagick processing should be done server-side.
            // Here we're just showing a basic preview for images.
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You could show a preview here if needed
                    console.log('Image preview generated');
                };
                reader.readAsDataURL(file);
            } else if (file.type === 'application/pdf') {
                console.log('PDF file selected - will be processed server-side with Imagick');
            }
        }

        // Reset form
        function resetForm() {
            if (documentSelect) documentSelect.value = '';
            if (fileInput) fileInput.value = '';
            if (fileInputContainer) fileInputContainer.style.display = 'none';
            if (submitBtn) submitBtn.disabled = true;
        }
    });
</script>
@endpush
