<div wire:key="annotation-modal-container">
    <div class="modal modal-sm fade modal-piece" id="modal-add-annotation" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Annotation</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveNote">
                        <div class="form-group row g-2">
                            <div class="col-lg-12">
                                <textarea name="note" id="" cols="30" rows="5" class="form-control" wire:model.defer='stat.note'
                                    placeholder="Laissez une annotation"></textarea>
                            </div>
                        </div>
                        <div class="from-group row mt-4">
                            <div class="col-lg-12 text-end mb-3">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-cansel w-50"
                                        data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-add mt-0 w-50">Enregistrer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('livewireScripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.addEventListener('close-modal', function() {
                var modalEl = document.getElementById('modal-add-annotation');
                if (modalEl) {
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    } else {
                        // Fallback jQuery
                        $(modalEl).modal('hide');
                    }
                }
                // Nettoyage forcé au cas où
                $('.modal-backdrop').remove();
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
            });

            Livewire.on('addAnnotation', function() {
                var modalEl = document.getElementById('modal-add-annotation');
                if (modalEl) {
                    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    modal.show();
                }
            });
        });
    </script>
@endpush
