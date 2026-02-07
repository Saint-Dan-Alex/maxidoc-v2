<div class="block-activity-container h-100 d-flex flex-column">
    <div class="d-flex justify-content-end mb-3 pe-3">
        <a href="{{ route('regidoc.taches.export-historique', $tache_id) }}" class="btn btn-sm btn-outline-primary" target="_blank" title="Exporter l'historique en PDF">
            <i class="fi fi-rr-file-pdf"></i>
            Exporter l'historique en PDF
        </a>
    </div>
    <div class="block-scroll flex-grow-1 pe-3" id="tache-historique" style="overflow-y: auto">
        <div class="block-activity">
            @forelse ($historiques_list as $user_id => $historiques)
                @php
                    $user = \App\Models\User::find($user_id);
                @endphp
                <div class="items-activity">
                    <div class="avatar-activ">
                        <img src="{{ imageOrDefault($user?->agent?->image) }}" alt="" style="width: 28px; height: 28px; border-radius: 100%; object-fit: cover;">
                    </div>
                    <p class="agent">
                        <span>{{ $user?->agent ? $user->agent->prenom . ' ' . $user->agent->nom : 'Utilisateur inconnu' }}</span>
                        @if($user?->agent?->poste)
                            - {{ $user->agent->poste->titre }}
                        @endif
                    </p>
                    @foreach ($historiques ?? [] as $history)
                        <div class="mt-2 block-dot-line">
                            <div class="block-dot-line-icon" style="color: #10b981;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14px" height="14px"
                                    viewBox="0 0 48 48">
                                    <circle cx="24" cy="24" r="21" fill="currentColor" />
                                    <path fill="#ffffff"
                                        d="M34.6 14.6L21 28.2l-5.6-5.6l-2.8 2.8l8.4 8.4l16.4-16.4z" />
                                </svg>
                            </div>
                            <div class="dot-line">
                                <p><span style="font-weight: 300; font-size: 13px;">{{ $history->description }}</span></p>
                                <div class="date" style="font-size: 11px; color: var(--colorParagraph); opacity: 0.8; margin-top: 2px;">
                                    {{ $history->created_at->format('d/m/Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="block-empty-offcanvas h-100 d-flex flex-column justify-content-center align-items-center">
                    <div class="name-file d-flex flex-column align-items-center">
                        <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px" class="mb-1">
                        <p style="font-size: 12px; color: var(--colorParagraph)">Aucun historique disponible pour cette tâche.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Surpasse certains styles si nécessaire pour l'offcanvas des tâches */
    .block-activity {
        padding-left: 20px;
        position: relative;
    }
    .items-activity {
        margin-bottom: 25px;
    }
    .avatar-activ {
        left: -14px !important;
        top: 0;
        z-index: 2;
    }
    .agent {
        margin-bottom: 10px !important;
        font-size: 13px;
    }
    .agent span {
        font-weight: 600;
        color: var(--colorTitre);
    }
    .block-dot-line-icon {
        position: absolute;
        left: -20px;
        top: 3px;
        z-index: 2;
        background: white;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #tache-historique::-webkit-scrollbar {
        width: 4px;
    }
    #tache-historique::-webkit-scrollbar-track {
        background: transparent;
    }
    #tache-historique::-webkit-scrollbar-thumb {
        background: rgba(0,0,0,0.1);
        border-radius: 10px;
    }
</style>
