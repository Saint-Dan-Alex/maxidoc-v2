<div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                <span>Partager ce document pour traitement</span>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit.prevent="savePartager">
                <div class="form-group row g-2">

                    <div class="col-12">
                        <div class="col-12">
                            <div class="block-radios d-flex align-item-center flex-wrap gap-1 justify-content-between">
                                <div class="item-radio d-flex align-items-center justify-content-between">
                                    <input type="radio" name="to" id="direction" value="1"
                                        wire:model='stat.to'>
                                    <label for="direction">À une direction</label>
                                    <div class="bubble-ratio"></div>
                                    <div class="block-dashed-sm"></div>
                                </div>

                                <div class="item-radio d-flex align-items-center justify-content-between">
                                    <input type="radio" name="to" id="agent" value="2"
                                        wire:model='stat.to'>
                                    <label for="agent">À un agent (Uniquement les agents de votre direction)</label>
                                    <div class="bubble-ratio"></div>
                                    <div class="block-dashed-sm"></div>
                                </div>
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
                                aria-label="Default select example" required wire:model.defer='stat.direction_id'>
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
                            <select class="form-select select-agent" name="agent_id" aria-label="Default select example"
                                required wire:model.defer='stat.agent_id'>
                                <option value="" selected disabled>Selectionnez</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">
                                        {{ $agent->nom . ' ' . $agent->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="col-12">
                        <label for="">Traitement</label>
                        <select class="form-select select-agent" name="traitements" aria-label="Default select example"
                            required wire:model.defer='stat.traitement_id'>
                            <option value="" selected disabled>Selectionnez</option>
                            @foreach ($traitements as $traitement)
                                <option value="{{ $traitement->id }}">
                                    {{ $traitement->titre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label for="">Commentaires</label>
                        <textarea name="note" id="" cols="30" rows="5" class="form-control" wire:model.defer='stat.note'></textarea>
                    </div>

                </div>
                <div class="from-group row">
                    <div class="col-lg-12 text-end mb-3">
                        <button type="submit" class="btn btn-add w-100" wire:loading.attr="disabled"
                            wire:target="savePartager">
                            Partager
                            <span class="spinner-border spinner-border-white text-success ms-1 d-none btn-loader"
                                role="status" style="font-size: 10px !important; width:14px;height:14px" wire:loading
                                wire:target="savePartager" wire:loading.class.remove="d-none">
                                <span class="sr-only"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function() {
        $('.select-agent').select2({
            placeholder: "Selectionnez",
            allowClear: true,
            width: '100%',
        });
    });

    document.addEventListener('livewire:load', function() {
        Livewire.hook('message.processed', (message, component) => {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                var bsModal = new bootstrap.Modal(modal);
            });
        });
    });
</script>
