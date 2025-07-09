<div class="mt-3 block-folder">
    <ul class="mb-3 nav nav-tabs" id="myTab" role="tablist" wire:ignore>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $pan == 1 ? 'active' : '' }}" id="profile-tab" data-bs-toggle="tab"
                data-bs-target="#tache-{{ $tache->id }}" type="button" role="tab" aria-controls="tache"
                aria-selected="true" wire:click='changeTab(1)'>Liste de objectifs</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $pan == 2 ? 'active' : '' }}" id="home-tab" data-bs-toggle="tab"
                data-bs-target="#comment-{{ $tache->id }}" type="button" role="tab" aria-controls="comment"
                aria-selected="false" wire:click='changeTab(2)'>Commentaires</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $pan == 3 ? 'active' : '' }}" id="home-tab" data-bs-toggle="tab"
                data-bs-target="#fichier-{{ $tache->id }}" type="button" role="tab" aria-controls="fichier"
                aria-selected="false" wire:click='changeTab(3)'>Fichiers
                partagés</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ $pan == 1 ? 'show active' : '' }}" id="tache-{{ $tache->id }}" role="tabpanel"
            aria-labelledby="home-tab" wire:ignore.self>
            <h6 class="mt-4">
                Progression de la tâche assignée
            </h6>
            <div class="block-progress-bar d-flex align-items-center justify-content-between">
                <div
                    class="content-bar @if ($pourcentage < 50) red @elseif($pourcentage >= 50 && $pourcentage < 80) orange @else green @endif">
                    <div class="bar" style="width: {{ $pourcentage }}%">

                    </div>
                </div>

                <div class="pourc d-flex">
                    <p class="mb-0">{{ number_format($pourcentage, 0) }}%</p>
                </div>
            </div>
            <h6 class="mt-4 mb-0">
                Objectifs assignés
            </h6>
            <div class="py-3 block-item">
                @if ($tache->parent_id == null)
                    <small style="color: var(--colorParagraph); font-size:13px;" class="d-block mb-3">
                        Cochez pour notifier au DG que vous avez fini avec les annotations 
                    </small>
                @endif
                @foreach ($tache->objectifs as $objectif)
                    <div class="form-check">
                        <input type="checkbox" name="objectif" wire:click='objetcifChangeStatut({{ $objectif->id }})'
                            class="form-check-input check-cible" {{ $objectif->statut == 1 ? 'checked' : '' }}
                            @disabled($objectif->agent_id != Auth::user()->agent->id) id="objectif-{{ $objectif->id }}">
                        <label class="form-check-label ms-2 col-12" for="objectif-{{ $objectif->id }}">
                            @if ($objectif->agent_id != Auth::user()->agent->id)
                                @if ($objectif->statut == 1)
                                    <strike>
                                        {!! $objectif->libelle !!}
                                    </strike>
                                @else
                                    {!! $objectif->libelle !!}
                                @endif
                                <span class="text-end"> -
                                    {{ $objectif?->agent?->nom . ' ' . $objectif?->agent?->prenom }} |
                                </span>
                            @else
                                @if ($objectif->statut == 1)
                                    <strike>
                                        {!! $objectif->libelle !!}
                                    </strike>
                                @else
                                    {!! $objectif->libelle !!}
                                @endif
                                <span class="text-end"> -
                                    {{ $objectif->agent?->nom . ' ' . $objectif?->agent?->prenom }}
                                </span>
                            @endif
                            {{-- @if ($objectif->user_id == Auth::id()) --}}
                            {{-- <a href="#" class="btn btn-sm btn-delete">
                                    <i class="fi fi-rr-trash"></i>
                                </a> --}}
                            {{-- @endif --}}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="tab-pane fade {{ $pan == 2 ? 'show active' : '' }}" id="comment-{{ $tache->id }}"
            role="tabpanel" aria-labelledby="home-tab" wire:ignore.self>
            <div class="all-comments">
                <h6 class="mb-2">
                    {{ $commentaires->count() }} commentaire(s)
                </h6>
                <form wire:submit.prevent="addCommentaire">
                    <div class="form-group">
                        <textarea wire:model="message" class="form-control" rows="2" placeholder="Ajouter un commentaire..."></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-add mt-2" @disabled($activec)>Envoyer</button>
                    </div>
                </form>
                <div class="block-scroll" id="tache-commentaires">
                    @if ($commentaires->count() == 0)
                        <div class="file d-flex">
                            <div class="name-file">
                                Aucun commentaire pour l'instant !
                            </div>
                        </div>
                    @else
                        @foreach ($commentaires as $commentaire)
                            <div
                                class="block-comment {{ $commentaire->user_id == Auth::id() ? 'block-comment-me' : '' }} commentaires">
                                <div class="block-info-comment d-flex">
                                    <div class="avatar-comment commentaires">
                                        <img src="{{ imageOrDefault($commentaire->user->agent->image) }}"
                                            alt="Photo profil">
                                    </div>
                                    <div class="name-comment commentaires">
                                        <h6 class="mb-0">
                                            {{ $commentaire->user->agent->prenom . ' ' . $commentaire->user->agent->nom }}
                                        </h6>
                                        <p>{{ $commentaire->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="comment commentaires mt-2">
                                    <p>{{ $commentaire->message }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>



        </div>

        <div class="tab-pane fade {{ $pan == 3 ? 'show active' : '' }}" id="fichier-{{ $tache->id }}"
            role="tabpanel" aria-labelledby="home-tab" wire:ignore.self>
            <div class="block-scroll-file">
                <form wire:submit.prevent="addFichier" enctype="multipart/form-data" class="mb-3 mt-4">
                    <div class="form-group row align-items-center g-2 g-lg-1">
                        <div class="col-lg-9">
                            <input type="file" wire:model="file" class="form-control" required
                                accept=".pdf,.png,.jpg,.jpeg" id="file_pane">
                            @error('file')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-3">
                            <div class="text-end">
                                <button type="submit" class="btn btn-add w-100" @disabled($activef)>
                                    Ajouter
                                    <div class="spinner-border d-none spinner-border-sm" role="status" wire:loading
                                        wire:loading.remove.class="d-none" wire:target="addFichier"
                                        style="border-color: white; border-right-color: transparent;"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @if ($fichiers->count() == 0)
                    <div class="file d-flex">
                        <div class="name-file">
                            Aucun fichier téléversé !
                        </div>
                    </div>
                @else
                    <h6 class="mb-3">
                        {{ $fichiers->count() }} fichier(s)
                    </h6>
                    <div class="row g-2">
                        @foreach ($fichiers as $fichier)
                            @php
                                $val = Str::endsWith(files($fichier->document)->link, '.pdf');
                            @endphp
                            <div class="col-lg-6">
                                <div class="file-upload-task d-flex align-items-center">
                                    <a href="{{ $val ? route('regidoc.documents.showDoc', ['fichier_id' => $fichier->id, 'tache_id' => $tache->id]) : files($fichier->document)->link }}"
                                        class="d-flex align-items-center link-show-doc"
                                        title="{{ $fichier->libelle }}" target="_blank">
                                        <div class="icon me-1" style="flex: 0 0 auto">
                                            <i class="fi fi-rr-file"></i>
                                        </div>
                                        <div class="name-file">
                                            <h6 class="mb-0">{{ $fichier->libelle }}</h6>
                                        </div>
                                    </a>

                                    @if (!$val)
                                        <a href="{{ files($fichier->document)->link }}"
                                            class="link-download-doc d-flex align-items-center justify-content-center">
                                            <i class="fi fi-rr-download"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </div>

                @endif
            </div>


        </div>

    </div>
</div>
