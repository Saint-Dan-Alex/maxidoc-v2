<div>
    <div class="modal fade" id="modal-new-annotation" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog" wire:ignore>
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
                                <textarea name="note" id="" cols="30" rows="5" class="form-control" wire:model='stat.note' placeholder="Saisissez vos annotations ici"></textarea>
                            </div>
                        </div>
                        <div class="from-group row mt-3">
                            <div class="col-lg-12 text-end mb-3">
                                <button type="reset" class="btn btn-cansel" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-add mt-0">Enregistrer</button>
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

        Livewire.on('editAnnotation', function () {
            var modal = new bootstrap.Modal(document.getElementById('modal-new-annotation'));
            modal.show();
        });

        Livewire.on('annotationSaved', function () {
            var modal = bootstrap.Modal.getInstance(document.getElementById('modal-new-annotation'));
            if (modal) {
                modal.hide();
            }
        });

        
    </script>
@endpush
