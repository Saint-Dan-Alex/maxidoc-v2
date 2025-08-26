<div class="modal fade" id="documentUploadModal" tabindex="-1" aria-labelledby="documentUploadModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" id="documentUploadModalLabel">
                <i class="fi fi-rr-paperclip me-2"></i>
                <span>Ajouter une pièce jointe</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info bg-light-info border-0 text-info mb-4">
                <i class="fi fi-rr-info-circle me-2"></i> Formats acceptés : images (JPG, PNG) et PDF (max 10Mo)
            </div>
            
            <form wire:submit.prevent="addFichier" id="fileUploadForm">
                <div class="form-group row g-2">
                    <div class="col-12">
                        <div class="border-2 border-dashed rounded p-4 text-center bg-light" style="cursor: pointer; border-color: #e0e0e0;" onclick="document.getElementById('documentFile').click()">
                            <i class="fi fi-rr-cloud-upload-alt text-muted" style="font-size: 2.5rem;"></i>
                            <p class="mt-2 mb-1">Glissez-déposez votre fichier ici ou</p>
                            <span class="btn btn-sm btn-outline-primary mb-0">
                                <i class="fi fi-rr-folder-open me-1"></i> Parcourir
                            </span>
                            <input type="file" 
                                   wire:model="file" 
                                   id="documentFile" 
                                   class="d-none" 
                                   accept="image/*,.pdf" 
                                   required>
                            <p class="small text-muted mt-2 mb-0">Taille maximale : 10 Mo</p>
                            @error('file')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    @if($filePreview)
                        <div class="col-12 mt-3">
                            <div class="border rounded p-3 bg-light">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0 fw-bold">Aperçu</h6>
                                    <button type="button" class="btn-close" wire:click="$set('file', null)" aria-label="Fermer"></button>
                                </div>
                                @if(str_ends_with(strtolower($file->getClientOriginalName()), '.pdf'))
                                    <div class="text-center p-3 bg-white rounded">
                                        <i class="fi fi-rr-file-pdf text-danger" style="font-size: 3rem;"></i>
                                        <p class="mb-0 mt-2 text-truncate">{{ $file->getClientOriginalName() }}</p>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <img src="{{ $filePreview }}" class="img-fluid rounded shadow-sm" style="max-height: 200px;" alt="Aperçu du document">
                                        <p class="small text-muted mt-2 mb-0">{{ $file->getClientOriginalName() }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="form-group row mt-4">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="btn btn-primary" 
                                {{ !$file ? 'disabled' : '' }}
                                wire:loading.attr="disabled">
                            <i class="fi fi-rr-upload me-1"></i>
                            Ajouter la pièce jointe
                            <span class="spinner-border spinner-border-sm ms-1 d-none" 
                                  role="status" 
                                  wire:loading
                                  wire:target="addFichier" 
                                  wire:loading.class.remove="d-none">
                                <span class="visually-hidden">Chargement...</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

@push('livewireScripts')
<script>
    document.addEventListener('livewire:load', function() {
        // Initialiser le modal
        const modalElement = document.getElementById('documentUploadModal');
        let modal = null;
        
        if (modalElement) {
            modal = new bootstrap.Modal(modalElement, {
                backdrop: true,
                keyboard: true,
                focus: true
            });

            // Gestionnaire d'événement personnalisé pour ouvrir le modal
            Livewire.on('openDocumentUploadModal', function () {
                if (modal) {
                    modal.show();
                }
            });

            // Gestionnaire pour la fermeture du modal
            Livewire.on('closeDocumentUploadModal', function () {
                if (modal) {
                    modal.hide();
                }
                // Réinitialiser le formulaire
                const form = document.getElementById('fileUploadForm');
                if (form) {
                    form.reset();
                }
            });

            // Réinitialiser le formulaire quand le modal est fermé
            modalElement.addEventListener('hidden.bs.modal', function () {
                Livewire.emit('resetFileInput');
            });
        }
    });
</script>
@endpush
