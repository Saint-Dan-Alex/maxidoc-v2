<div class="col-lg-12">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="px-0 card card-table">
        <div class="px-lg-3 px-2 row align-items-center g-2">
            <div class="col-lg-7 col-sm-6">
                <h4 class="no-padding no-margin badge-card">Courriers internes</h4>
            </div>
            <div class="col-lg-5 d-flex align-items-center justify-content-end col-sm-6">

            </div>
        </div>
        <hr class="mb-0">

        <div class="d-content-table position-relative" style="overflow: hidden">
            <div class="table-responsive">
                <div class="d-none position-absolute d-flex loader-card justify-content-center"
                    style="z-index: 2; height:80%; width:95%; background-color:rgba(255,255,255,0.95)" wire:loading=""
                    wire:target="search" wire:loading.class.remove="d-none">
                    <div class="m-auto text-center">
                        <div class="spinner-border text-success" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">N° d'enregistrement</th>
                            <th scope="col">Service initiateur</th>
                            <th scope="col">Destinataire</th>
                            <th scope="col">Accusées réceptions</th>
                            @can('Definir le traitement')
                                <th scope="col">Priorité</th>
                            @endcan
                            <th scope="col">Date du courrier</th>
                            <th scope="col">Date de réception</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courriers as $courrier)
                            <tr @class(['', 'tr-no-read' => !$courrier->isViewed()])>
                                <td class="text-truncate title-file-box-table-data">
                                    <span class="mail-internal-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="M8 3L4 7l4 4M4 7h16m-4 14l4-4l-4-4m4 4H4" />
                                        </svg>
                                    </span>
                                    {{ $courrier->title ?? 'Non définie' }}
                                </td>
                                <td> {{ $courrier->reference_interne ?? 'Non définie' }} </td>
                                <td>
                                    {{ $courrier->service->titre ?? 'N/D' }}
                                </td>
                                <td>
                                    {{ $courrier->toDirection->titre ?? 'N/D' }}
                                </td>
                                <td class="text-nowrap">
                                    @if ($courrier->followers->unique()->count())
                                        <div class="box-avatar d-flex align-items-center">
                                            @php
                                                $others = collect();
                                            @endphp
                                            @foreach ($courrier->followers->unique() as $follower)
                                                @if ($loop->index < 4)
                                                    <div class="cursor-pointer avatar-team" data-bs-toggle="offcanvas"
                                                        data-bs-target="#detail-personnel"
                                                        aria-controls="offcanvasRight">
                                                        <div class="tooltip-team">
                                                            {{-- {{ $follower->prenom }} {{ $follower->nom }} --}}
                                                            {{ $follower->poste?->titre }}
                                                        </div>
                                                        <img src="{{ imageOrDefault($follower->image) }}"
                                                            alt="">
                                                    </div>
                                                @else
                                                    @php
                                                        $others->push($follower);
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (count($others))
                                                <div class="dropdown">
                                                    <div class="cursor-pointer avatar-team plus d-flex align-items-center justify-content-center"
                                                        data-bs-toggle="dropdown" aria-expanded="false"
                                                        style="margin-right: 0">
                                                        <span>
                                                            4+
                                                        </span>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="dropdownMenuButton2" style="">
                                                        <div class="list-users">
                                                            @foreach ($others as $agent)
                                                                <div class="content-user d-flex align-items-center">
                                                                    <div class="avatar" style="flex: 0 0 auto">
                                                                        <img src="{{ imageOrDefault($agent->image) }}"
                                                                            alt="{{ $agent->prenom }} {{ $agent->nom }}">
                                                                    </div>
                                                                    <div class="name">
                                                                        {{ $agent->prenom }} {{ $agent->nom }} <br>
                                                                        {{ $agent->poste?->libelle }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        Aucun
                                    @endif
                                </td>

                                @can('Definir le traitement')
                                    <td>
                                        <div @class([
                                            'badge-priority',
                                            'badge-priority-gray' =>
                                                $courrier->priorite_id != 1 &&
                                                $courrier->priorite_id != 2 &&
                                                $courrier->priorite_id != 3,
                                            'normal badge-priority-normal' => $courrier->priorite_id == 1,
                                            'urgent  badge-priority-red' => $courrier->priorite_id == 4,
                                            'absolute badge-priority-yellow' => $courrier->priorite_id == 3,
                                            'important badge-priority-green' => $courrier->priorite_id == 2,
                                        ])>
                                            {{ $courrier->priorite?->titre ?? 'Non définie' }}
                                        </div>
                                    </td>
                                @endcan
                                {{-- @can('Definir le traitement')
                                    <td>
                                        <div class="badge {{ $courrier->priorite_id == 1 ? 'normal badge-green' : ($courrier->priorite_id == 2 ? 'urgent badge-red' : ($courrier->priorite_id == 3 ? 'absolute badge-yellow' : 'badge-gray')) }}">
                                            <i class="fi fi-sr-flag" style="font-size: 16px;"></i>
                                            <div class="tooltip-team">
                                                {{ $courrier->priorite?->titre ?? 'Non définie' }}
                                            </div>
                                        </div>
                                    </td> 
                                @endcan --}}
                                <td>
                                    {{ $courrier->created_at->format('d/m/Y') ?? 'Non définie' }}
                                </td>
                                <td>
                                    @if ($courrier->accuseReceptions->isNotEmpty())
                                        {{ $courrier->accuseReceptions->last()->created_at->format('d/m/Y') }}
                                    @else
                                        <span>Aucun</span>
                                    @endif
                                </td>
                                <td>
                                    <div @class([
                                        'badge',
                                        'badge-gray' => $courrier->statut_id == 1,
                                        'badge-yellow' => $courrier->statut_id == 2,
                                        'badge-green' => $courrier->statut_id == 3,
                                    ])>
                                        {{ $courrier->statut?->libelle ?? 'N/D' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if (
                                            ($courrier->isIntern() && in_array(Auth::user()->agent->id, $courrier->destinateurs->pluck('id')->toArray())) ||
                                                in_array(Auth::user()->agent->id, $courrier->followers->pluck('id')->toArray()) ||
                                                $courrier->created_by == Auth::user()->agent->id)
                                            <a href="{{ route('regidoc.courriers.show', $courrier) }}" class="btn">
                                                <i class="fi fi-rr-eye"></i>
                                                <div class="tooltip-btn">Voir détails</div>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            @empty
                                <td colspan="8" class="text-center">
                                    Aucun courrier entrant
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
