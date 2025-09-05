<div>
    @php
        $hasSeen = false;
        if ($courrier->type_id == 3) {
            // Pour les courriers internes, on vérifie s'il y a un accusé de réception
            $hasSeen = \App\Models\AccuseReception::where('courrier_id', $courrier->id)
                ->where('user_id', Auth::user()->id)
                ->exists();
        } else {
            // Vérification standard pour les autres types de courriers
            foreach ($courrier->etapes as $etape) {
                if ($etape->pivot->view_by == Auth::user()->id) {
                    $hasSeen = true;
                    break;
                }
            }
        }
    @endphp
    
    {{-- Débogage de la valeur de hasSeen --}}
    @php \Log::info('AccuserReception - hasSeen value', ['hasSeen' => $hasSeen, 'courrier_id' => $courrier->id, 'user_id' => Auth::id()]); @endphp

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
