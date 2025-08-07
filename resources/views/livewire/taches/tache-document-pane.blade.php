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
                <div class="d-flex align-items-start">
                    <i class="fi fi-rr-info text-primary me-3 mt-1"></i>
                    <div>
                        <p class="mb-2">Êtes-vous sûr de vouloir ajouter ce document ?</p>
                        <p class="small text-muted mb-0">
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
                submitBtn.disabled = true; // Disable submit until a file is selected
            } else {
                fileInputContainer.style.display = 'none';
                submitBtn.disabled = false;
            }
        });

        // Handle file selection
        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
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
