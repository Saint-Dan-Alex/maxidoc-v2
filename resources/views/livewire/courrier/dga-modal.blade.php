<div>
    <div class="modal fade" id="dga-modal" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog" wire:ignore>
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Traitement par le DGA</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="send">
                        <div class="from-group row mt-3">
                            <div class="col-lg-12 text-center mb-3">
                                {{-- confirmation message --}}
                                <p>
                                    Vous êtes sur le point de partager ce document avec le DGA. Souhaitez-vous le
                                    confirmer ?
                                </p>
                            </div>
                        </div>
                        <div class="from-group row mt-3">
                            <div class="col-lg-12 text-center mb-3 d-flex gap-2 ">
                                <button type="reset" class="btn btn-cansel flex-grow-1"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-add mt-0 flex-grow-1"
                                    wire:loading.attr='disabled'>
                                    Valider
                                    <span class="spinner-border spinner-border-white text-success d-none ms-1"
                                        role="status" wire:target="send" wire:loading.class.remove="d-none"
                                        style="font-size: 2px !important; width:10px;height:10px">
                                        <span class="sr-only"></span>
                                    </span>
                                </button>
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
        Livewire.on('courrierSent', function() {
            $('#dga-modal').modal('hide');
        });
    </script>
@endpush
