<div>
    @php
        $hasSeen = false;
        foreach ($courrier->etapes as $etape) {
            if ($etape->pivot->view_by == Auth::user()->id) {
                $hasSeen = true;
                break;
            }
        }
    @endphp

    @if (!Auth::user()->agent->isDG())
        @if (!$hasSeen && $courrier->author->id != Auth::user()->agent->id)
            <div class="p-3 pb-0">
                <button class="btn btn-primary btn-light btn-reception w-100 mb-0" wire:click="accuserReception"
                    wire:loading.attr='disabled'>
                    <span>
                        Accuser réception
                    </span>
                    <span class="d-none spinner-border ms-2" role="status"
                        style="font-size: 11px; height: 12px; width: 12px;"
                        wire:target="accuserReception" wire:loading.class.remove="d-none">
                        <span class="sr-only"></span>
                    </span>
                </button>
            </div>
        @endif
    @endif
</div>
