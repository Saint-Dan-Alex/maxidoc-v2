<div class="col-12">
    <h6>Ajouter une pièce jointe</h6>
</div>

<div wire:ignore>
    <form id="fileUploadForm" wire:submit.prevent="addFichier">
        <div class="mb-3">
            <label for="documentFile" class="form-label">Sélectionner un document</label>
            <select class="form-select" id="documentFile" required>
                <option value="" selected disabled>Sélectionnez un fichier...</option>
                <option value="upload">Téléverser un fichier</option>
                <!-- Add more options if needed -->
            </select>
            
            <div id="fileInputContainer" class="mt-3" style="display: none;">
                <input type="file" id="fileInput" class="form-control" accept="image/*,.pdf" required>
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
        <div class="modal-content" style="pointer-events: auto;">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation requise</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir ajouter ce document ? Cette action est irréversible.</p>
                <p class="text-muted small">Le fichier sera traité et ne pourra pas être supprimé après enregistrement.</p>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Annuler
                </button>
                <button type="button" id="confirmUpload" class="btn btn-primary">
                    <i class="fas fa-check me-1"></i> Confirmer l'ajout
                </button>
            </div>
        </div>
    </div>
</div>

@push('livewireScripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const documentSelect = document.getElementById('documentFile');
        const fileInputContainer = document.getElementById('fileInputContainer');
        const fileInput = document.getElementById('fileInput');
        const submitBtn = document.getElementById('submitBtn');
        const confirmationModalElement = document.getElementById('confirmationModal');
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
        let selectedFile = null;

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
                selectedFile = this.files[0];
                submitBtn.disabled = false;
                
                // Use Imagick to process the file
                processFileWithImagick(selectedFile);
            } else {
                submitBtn.disabled = true;
            }
        });

        // Handle form submission
        document.getElementById('fileUploadForm').addEventListener('submit', function(e) {
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
                    document.getElementById('confirmUpload').click();
                }
            }
        });

        // Handle confirmation
        const confirmButton = document.getElementById('confirmUpload');
        if (!confirmButton) return;
        
        confirmButton.addEventListener('click', function() {
            // Show loading state
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            
            submitText.textContent = 'Traitement...';
            submitSpinner.classList.remove('d-none');
            submitBtn.disabled = true;
            
            // Submit the form via Livewire with error handling
            @this.call('addFichier', selectedFile, function() {
                // This is a workaround to ensure proper 'this' context
                return new Promise((resolve, reject) => {
                    // This will be handled by Livewire's response
                    window.livewire.resolveUpload = resolve;
                    window.livewire.rejectUpload = reject;
                    
                    // Add a timeout to handle cases where the upload hangs
                    window.uploadTimeout = setTimeout(() => {
                        reject(new Error('Le téléversement a pris trop de temps. Veuillez réessayer.'));
                    }, 30000); // 30 secondes timeout
                });
            })
            .then(() => {
                    // Reset form on success
                    resetForm();
                    if (confirmationModal) {
                        confirmationModal.hide();
                        // Force remove backdrop if still present
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => backdrop.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                    }
                    // Show success message
                    const toast = document.createElement('div');
                    toast.className = 'position-fixed bottom-0 end-0 p-3';
                    toast.style.zIndex = '9999';
                    toast.innerHTML = `
                        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header bg-success text-white">
                                <strong class="me-auto">Succès</strong>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Fermer"></button>
                            </div>
                            <div class="toast-body">
                                Le fichier a été ajouté avec succès.
                            </div>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    setTimeout(() => {
                        toast.remove();
                    }, 5000);
                })
                .catch(error => {
                    console.error('Error uploading file:', error);
                    alert('Une erreur est survenue lors du téléversement du fichier : ' + (error.message || 'Erreur inconnue'));
                })
                .finally(() => {
                    if (submitText) submitText.textContent = 'Enregistrer';
                    if (submitSpinner) submitSpinner.classList.add('d-none');
                    if (submitBtn) submitBtn.disabled = false;
                });
        });

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
            documentSelect.value = '';
            fileInput.value = '';
            fileInputContainer.style.display = 'none';
            submitBtn.disabled = true;
            selectedFile = null;
        }
    });
</script>
@endpush
