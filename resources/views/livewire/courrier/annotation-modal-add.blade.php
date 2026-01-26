<div>
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
                                <textarea name="note" id="" cols="30" rows="5" class="form-control" wire:model='stat.note'
                                    placeholder="Laissez une annotation"></textarea>
                            </div>
                        </div>
                        <div class="from-group row mt-4">
                            <div class="col-lg-12 text-end mb-3">
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-cansel w-50"
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
        Livewire.on('annotationSaved', function() {
            $('#modal-add-annotation').modal('hide');
        });

        Livewire.on('addAnnotation', function() {
            $('#modal-add-annotation').modal('show');
        });

        $(document).ready(function() {
            var $modalAnnot = $('#modal-add-annotation');
            if ($modalAnnot.length) {
                $modalAnnot.appendTo('body');
            }
        });
    </script>
@endpush
