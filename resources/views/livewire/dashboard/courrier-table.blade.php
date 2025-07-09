<div class="px-0 card card-table">
    <div class="px-3 row px-lg-4">
        <div class="col-lg-7">
            <h4 class="no-padding no-margin">Courrier en cours de traitement</h4>
        </div>
        <div class="col-lg-5 d-flex align-items-center justify-content-end">
            <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche" style="border:none;">
            <div class="dropdown">
                <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- <i class="fi fi-rr-filter"></i> --}}
                    <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                        <path
                            d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z" />
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                    @foreach ($filters as $key => $filter)
                        <li>
                            <a class="dropdown-item" href="javascrip:void(0)" wire:click='filter({{ $key }})'>
                                {{ $filter }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <hr class="mb-0">
    {{-- <hr class="mb-0"> --}}
    <div class="d-content-table" style="overflow: hidden">
        <div class="table-responsive">
            <div class="d-none position-absolute d-flex loader-card justify-content-center"
                style="z-index: 2; height:80%; width:95%; background-color:rgba(255,255,255,0.95)" wire:loading
                wire:target="filter" wire:loading.class.remove="d-none">
                <div class="m-auto text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
            </div>
            {{-- <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Département</th>
                        <th scope="col">Référence</th>
                        <th scope="col">Expediteur</th>
                        <th scope="col">Destinataire</th>
                        <th scope="col">Priorite</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courrierGroups as $key => $type)
                        <tr class="bg-lightBlue">
                            <td colspan="7" class="text-center fw-bold">
                                Courrier {{ $type->titre }}
                            </td>
                        </tr>
                        @forelse ($type->courriers as $courrier)
                            <tr>
                                <td>Informatique</td>
                                <td>Photoshop</td>
                                <td>Photoshop</td>
                                <td class="text-nowrap">
                                    Pedrien Kinkani
                                    <div class="box-avatar d-flex align-items-center">
                                        <div class="cursor-pointer avatar-team" data-bs-toggle="offcanvas"
                                            data-bs-target="#detail-personnel" aria-controls="offcanvasRight">
                                            <div class="tooltip-team">
                                                Pedrien Kinkani
                                            </div>
                                            <img src="{{ asset('assets/img/team/1.jpg') }}" alt="">
                                        </div>
                                        <div class="cursor-pointer avatar-team" data-bs-toggle="offcanvas"
                                            data-bs-target="#detail-personnel" aria-controls="offcanvasRight">
                                            <div class="tooltip-team">
                                                Pedrien Kinkani
                                            </div>
                                            <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                        </div>
                                        <div class="avatar-team">
                                            <div class="tooltip-team">
                                                Pedrien Kinkani
                                            </div>
                                            <img src="{{ asset('assets/img/team/3.jpg') }}" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="badge bg-danger">
                                        Urgent
                                    </div>
                                </td>
                                <td>
                                    01/01/1999
                                </td>
                                <td>
                                    <a href="#" class="btn btn-default btn-sm">
                                        Traiter
                                    </a>
                                    <a href="#" class="btn btn-default btn-sm">
                                        Classer
                                    </a>
                                    <a href="#" class="btn btn-default btn-sm">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center td-empty">
                                    <i class="bi bi-file-x"></i> <br>
                                    Aucun courrier {{ $type->titre }} n'est en cours de traitement
                                </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr class="bg-light">
                            <td colspan="7" class="text-center fw-bold">
                                Courrier entrant
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-center">
                                Aucun courrier entrant n'est en cours de traitement
                            </td>
                        </tr>
                        <tr class="bg-light">
                            <td colspan="7" class="text-center fw-bold">
                                Courrier sortant
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-center">
                                Aucun courrier sortant n'est en cours de traitement
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table> --}}
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Département</th>
                        <th scope="col">Référence</th>
                        <th scope="col">Expediteur</th>
                        <th scope="col">Destinataire</th>
                        <th scope="col">Priorite</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courrierGroups->where('id', 2) as $key => $type)
                        <tr class="bg-lightBlue">
                            <td colspan="7" class="text-center fw-bold">
                                Courrier {{ $type->titre }}
                            </td>
                        </tr>
                        @php
                            $courriers = $type->courriers->filter(function ($courrier) {
                                return ($courrier->isIntern() && $courrier->destinateur && $courrier->destinateur->is(Auth::user()->agent)) || in_array(Auth::user()->agent->id, $courrier->followers->pluck('id')->toArray());
                            });
                        @endphp
                        @forelse ($courriers as $courrier)
                            <tr>
                                <td>
                                    @if ($courrier->isIntern())
                                        {{ $courrier->service?->titre ?? 'Non definie' }}
                                    @else
                                        @if ($courrier->externDestinateur)
                                            Societé : {{ $courrier->externDestinateur->societe }}
                                        @else
                                            Inconnu
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{ $courrier->reference }}
                                </td>
                                <td>
                                    @if ($courrier->isIntern())
                                        {{ $courrier->expediteur ? $courrier->expediteur?->prenom . ' ' . $courrier->expediteur?->nom : 'Aucun' }}
                                    @else
                                        {{ $courrier->externExpediteur ? $courrier->externExpediteur->prenom . ' ' . $courrier->externExpediteur->nom : 'Aucun' }}
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <div class="box-avatar d-flex align-items-center">
                                        @foreach ($courrier->followers as $follower)
                                            <div class="cursor-pointer avatar-team">
                                                <div class="tooltip-team">
                                                    {{ $follower->prenom }} {{ $follower->nom }}
                                                </div>
                                                <img src="{{ imageOrDefault($follower->image) }}" alt="">
                                            </div>
                                            @if (count($courrier->followers) <= 1)
                                                <span class="name">
                                                    {{ $follower->prenom }} {{ $follower->nom }}
                                                </span>
                                            @endif
                                            {{-- @if ($courrier->isIntern())
                                                <span class="name">
                                                    {{ $courrier->destinateur ? $courrier->destinateur->prenom . ' ' . $courrier->destinateur->nom : 'Aucun' }}
                                                </span>
                                            @else
                                                <span class="name">
                                                    {{ $courrier->externDestinateur ? $courrier->externDestinateur->prenom . ' ' . $courrier->externDestinateur->nom : 'Aucun' }}
                                                </span>
                                            @endif --}}
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="badge bg-danger">
                                        {{ $courrier->priorite?->titre }}
                                    </div>
                                </td>
                                <td>
                                    {{ $courrier->created_at }}
                                </td>
                                <td>
                                    @if ($courrier->isIntern() && $courrier->destinateur && $courrier->destinateur->is(Auth::user()->agent))
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="btn btn-default btn-sm">
                                                <div class="tooltip-btn">
                                                    Traiter
                                                </div>
                                                <i class="fi fi-rr-treasure-chest"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-sm">
                                                <div class="tooltip-btn">
                                                    Classer
                                                </div>
                                                <i class="fi fi-rr-box"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-sm">
                                                <div class="tooltip-btn">
                                                    Supprimer
                                                </div>
                                                <i class="fi fi-rr-trash"></i>
                                            </a>
                                        </div>
                                    @elseif(in_array(Auth::user()->agent->id, $courrier->followers->pluck('id')->toArray()))
                                        <a href="{{ route('regidoc.courriers.show', $courrier) }}"
                                            class="btn">
                                            <i class="fi fi-rr-eye"></i>
                                                <div class="tooltip-btn">Voir détails</div>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Aucun courrier {{ $type->titre }} n'est en cours de traitement
                                </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Aucun courrier sortant n'est en cours de traitement
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
