<div>
    <div class="modal fade" id="traitement-modal" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog"
        wire:ignore>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Traitement courier </span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <div class="d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:80%; width:90%; background-color:rgba(255,255,255,0.95)" wire:loading
                        wire:target="validerTraitement, annulerTraitement" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div> --}}
                    <form wire:submit.prevent='validerTraitement'>
                        <div>
                            <div class="form-group row g-3">

                                <div class="col-12">
                                    <label>Traitement à effectuer</label>
                                    <div wire:ignore.self>
                                        <select class="form-select form-control select2"
                                            aria-label="Default select example" name="traitement_id"
                                            data-placeholder="Selectionner">
                                            <option value="" selected disabled>Selectionnez</option>
                                            @foreach ($traitements as $traitement)
                                                <option value="{{ $traitement->id }}" @selected($courrier->traitement_id == $traitement->id)>
                                                    {{ $traitement->titre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 priote_field" wire:ignore.self>
                                    <label class="col-5 col-form-label">Priorité</label>
                                    <div wire:ignore>
                                        <select class="form-select form-control select2"
                                            aria-label="Default select example" name="priorite"
                                            data-placeholder="Selectionner"
                                            data-get-items-route="{{ route('regidoc.ajax.typescourriers') }}"
                                            data-get-items-field="titre" data-method="get" data-label="titre"
                                            data-related-model="Priorite">
                                            @foreach ($priorites as $priorite)
                                                <option value="{{ $priorite->id }}" @selected($priorite->id == $courrier->priorite_id)>
                                                    {{ $priorite->titre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @if (!Auth::user()->agent->isSecretaire())
                                    <div class="col-12 block_echeances" wire:ignor>
                                        <div wire:ignore class="d-flex align-items-center">
                                            <label for="check-date" class="mb-0">Avec date
                                                d'échéance</label>
                                            <div class="form-check form-switch ms-2 mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="check-date" name="check-date" wire:model="checkEcheance">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 date-limite d-none">
                                        <label>Date d'échéance</label>
                                        <div>
                                            <input type="date" class="form-control" id="inputPassword"
                                                name="date-limite" wire:model="stat.date_limite"
                                                min="{{ now()->format('d-m-Y') }}">
                                        </div>
                                    </div>
                                    <div class="col-12" wire:ignore>
                                        <label class="form-label">Commentaires</label>
                                        <textarea name="content" wire:model='commentaire' class="form-control" cols="30" rows="3"></textarea>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="d-flex justify-content-end align-items-center mt-3">
                                        <a href="javascript:void(0)" class="btn"
                                            wire:click="annulerTraitement">Annuler</a>
                                        <button class="btn btn-add mt-0" type="submit"
                                            wire:loading.attr='disabled'>
                                            Valider
                                            <span class="spinner-border spinner-border-white text-success d-none ms-1"
                                                role="status"
                                                wire:target="validerTraitement"
                                                wire:loading.class.remove="d-none"
                                                style="font-size: 2px !important; width:10px;height:10px">
                                                <span class="sr-only"></span>
                                            </span>
                                        </button>
                                    </div>
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
    {{-- <script src="{{ asset('assets/js/ckbox/ckeditor.js') }}"></script> --}}
    <script>
        bootstrap.Modal.prototype.enforceFocus = function() {
            $(document)
                .off('focusin.bs.modal') // guard against infinite focus loop
                .on('focusin.bs.modal', $.proxy(function(e) {
                    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                        this.$element.focus()
                    }
                }, this))
        }

        $('select[name=priorite]').on('change', function(e) {
            var data = e.target.value;
            @this.setPriorite(data);
        });

        $('select[name=traitement_id]').on('change', function(e) {
            var data = e.target.value;
            @this.setTraitement(data);
        });

        $('.selectCopie').on('change', function(e) {
            var data = $(this).val();
            @this.setCopie(data);
        });

        // function setEntrat(data) {
        //     if (data == 2 || data == 3) {
        //         $('.exped_extern').addClass('d-none');
        //         $('.exped_intern').removeClass('d-none');
        //         $('.block_traitant').removeClass('d-none');
        //         $('.block_initiateur').removeClass('d-none');
        //         $('.block_echeance').removeClass('d-none');
        //         $('.select_doc').removeClass('d-none');
        //         $('#destination2').addClass('d-none');
        //         $('.categorie_field').addClass('d-none');
        //         $('.priote_field').removeClass('d-none');
        //         $('.datearrive_field').removeClass('d-none');
        //         $('.nature_field').removeClass('d-none');
        //     } else {
        //         $('.exped_extern').removeClass('d-none');
        //         $('.exped_intern').addClass('d-none');
        //         $('.block_traitant').addClass('d-none');
        //         $('.block_initiateur').addClass('d-none');
        //         $('.block_echeance').addClass('d-none');
        //         $('.select_doc').addClass('d-none');
        //         $('.categorie_field').removeClass('d-none');
        //         $('.priote_field').removeClass('d-none');
        //         $('.datearrive_field').removeClass('d-none');
        //         $('.nature_field').removeClass('d-none');
        //         $('#destination2').removeClass('d-none');
        //     }

        //     if (data == 2) {
        //         $('.priote_field').addClass('d-none');
        //         $('.datearrive_field').addClass('d-none');
        //         $('.block_echeance').addClass('d-none');
        //         $('.nature_field').addClass('d-none');
        //     }
        // }

        $('.selectCopie').select2({
            tags: $(this).data('tags') ? $(this).data('tags') : false,
            placeholder: $(this).data('placeholder'),
            language: "fr",
            maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
            width: '100%',
            dropdownParent: $('#traitement-modal')
        });

        $('.select2').select2({
            tags: $(this).data('tags') ? $(this).data('tags') : false,
            placeholder: $(this).data('placeholder'),
            language: "fr",
            maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
            width: '100%',
            dropdownParent: $('#traitement-modal') // Spécifiez l'élément de la modale comme parent de la liste déroulante
        });

        $('#check-date').on('change', function() {
            if (this.checked) {
                $('.date-limite').removeClass('d-none');
                $('.date-limite').find('input').val('')
                @this.set('stat.date_limite', '');
            } else {
                $('.date-limite').addClass('d-none');
            }
        })
        Livewire.on('updated', (message) => {
            $('.select2').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
                width: '100%',
                dropdownParent: $('#traitement-modal') // Spécifiez l'élément de la modale comme parent de la liste déroulante
            });
            $('.selectCopie').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
                width: '100%',
                dropdownParent: $('#traitement-modal')
            });
        });
        Livewire.on('traitementDone', function() {
            $('.modal.show').modal('hide');
            $('.assistant-trait').remove();
        })

        Livewire.on('annulationDone', function() {
            $('#traitement-modal').modal('hide');
        })
    </script>
@endpush
