<div>
    <div class="modal fade" id="modal-doc-share" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog"
        wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Partager ce document</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" wire:poll>
                    <div class="d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:80%; width:90%; background-color:rgba(255,255,255,0.95)"
                        wire:loading="" wire:target="stat.to" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <form wire:submit.prevent="savePartager">
                        <div class="form-group row g-lg-3 g-3">
                            @php
                                $poste = Auth::user()->agent?->poste;
                            @endphp

                            <div class="col-12">
                                <div
                                    class="block-radios d-flex align-item-center flex-wrap gap-1 justify-content-between">
                                    <div class="item-radio d-flex align-items-center justify-content-between">
                                        <input type="radio" name="to" id="direction" value="1"
                                            wire:model='stat.to'>
                                        <label for="direction">À une autre direction</label>
                                        <div class="bubble-ratio"></div>
                                        <div class="block-dashed-sm"></div>
                                    </div>

                                    <div class="item-radio d-flex align-items-center justify-content-between">
                                        <input type="radio" name="to" id="agent" value="2"
                                            wire:model='stat.to'>
                                        <label for="agent">À un agent de ma direction</label>
                                        <div class="bubble-ratio"></div>
                                        <div class="block-dashed-sm"></div>
                                    </div>
                                </div>
                            </div>

                            @php
                                $concernedAgents = Auth::user()->agent->direction->agents;
                            @endphp

                            @if ($stat['to'] == 1)
                                <div class="col-12">
                                    <label for="">Direction</label>
                                    <select class="form-select select-agent" name="direction_id"
                                        aria-label="Default select example" required wire:model='stat.direction_id'>
                                        <option value="" selected disabled>Selectionnez</option>
                                        @foreach ($directions as $direction)
                                            <option value="{{ $direction->id }}">
                                                {{ $direction->titre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif($stat['to'] == 2)
                                <div class="col-12">
                                    <label for="">Agent</label>
                                    <select class="form-select select-agent select2" name="agent_id"
                                        aria-label="Default select example" required wire:model='stat.agent_id'>
                                        <option value="" selected disabled>Selectionnez</option>
                                        @foreach ($concernedAgents as $agent)
                                            <option value="{{ $agent->id }}">
                                                {{ $agent->nom . ' ' . $agent->prenom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif



                            <div class="col-lg-12">
                                <label for="">Commentaires</label>
                                <textarea name="note" id="" cols="30" rows="5" class="form-control" wire:model='stat.note'></textarea>
                            </div>

                        </div>
                        <div class="from-group row">
                            <div class="col-lg-12 text-end mb-3" wire:ignore>
                                {{-- @disabled(($stat['to'] == '' || $stat['to'] == 0) && ($stat['traitement_id']) == '') --}}
                                <button type="reset" class="btn btn-cansel flex-grow-1"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-add w-100" wire:loading.attr="disabled"
                                    wire:target="savePartager">
                                    Partager
                                    <span
                                        class="spinner-border spinner-border-white text-success ms-1 d-none btn-loader"
                                        role="status" style="font-size: 10px !important; width:14px;height:14px"
                                        wire:loading wire:target="savePartager" wire:loading.class.remove="d-none">
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
        Livewire.on('finishPartage', function() {
            var moadal = bootstrap.Modal.getInstance($('#modal-doc-share'));
            // console.log(moadal)
            moadal.hide();
            // setTimeout(() => {
            // }, 3000);
        });

        // bootstrap.Modal.prototype.enforceFocus = function () {
        //     $(document)
        //     .off('focusin.bs.modal') // guard against infinite focus loop
        //     .on('focusin.bs.modal', $.proxy(function (e) {
        //         if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
        //             this.$element.focus()
        //         }
        //     }, this))
        // }

        // bootstrap.Modal.Default.keyboard = false;
        $(document).ready(function() {
            // bootstrap.Modal.Constructor.prototype.enforceFocus = true;
            $('.select2').select2({
                dropdownParent: $('#modal-doc-share'),
                width: '100%',
                placeholder: $(this).data('placeholder')
            });

            $('.tag').select2({
                dropdownParent: $('#modal-doc-share'),
                width: '100%',
                placeholder: $(this).data('placeholder'),
                tags: true,
                allowClear: false,
            });

            $('.add-agent').on('click', function() {
                // var clone = $('.element:last-child').clone();
                var parent = $('.parent-tache');
                var clone = $('.element').last().clone();
                clone.addClass('mt-2');
                parent.append(clone);

                clone.find('span.select2').remove();
                clone.find('a').last().removeClass('d-none');

                clone.find('span.select2').remove();
                var input = clone.find('select.tag');
                input.removeClass("select2-hidden-accessible");
                input.removeAttr('data-select2-id');
                input.removeAttr('tabindex');
                input.removeAttr('aria-hidden');
                input.find('option').remove();
                input.select2({
                    tags: true,
                    placeholder: $(this).data('placeholder'),
                    allowClear: true,
                    dropdownParent: $('#modal-doc-share'),
                });
                selectAgent();
            });

            $('body').on('click', '.element-remove', function() {
                $(this).parent().remove();
                if ($('.element').length == 1) {
                    $('.element').find('a').last().addClass('d-none');
                }
            });

            selectAgent();

            function selectAgent() {
                $('.select-agent').on('change', function() {
                    var element = $(this).parent();
                    var tache = element.find('select.tag');
                    tache.attr('name', 'taches[' + $(this).val() + '][]');
                });
            }
        });
    </script>
@endpush
