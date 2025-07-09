<div class="col-lg-12">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="px-0 card card-table">
        <div class="px-lg-3 px-2 row  align-items-center g-2">
            <div class="col-lg-7 col-sm-6">
                <h4 class="no-padding no-margin badge-card badge-green">Courriers sortants</h4>
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
                            <th scope="col">Destinataire</th>
                            <th scope="col">Accusées réceptions</th>
                            <th scope="col">Date du courrier</th>
                            <th scope="col">Date d'émission</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courriers as $courrier)
                            <tr @class(['', 'tr-no-read' => !$courrier->isViewed()])>
                                <td class="text-truncate title-file-box-table-data">
                                    <span class="mail-out-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="m12 4l-.707-.707l.707-.707l.707.707zm1 15a1 1 0 1 1-2 0zM5.293 9.293l6-6l1.414 1.414l-6 6zm7.414-6l6 6l-1.414 1.414l-6-6zM13 4v15h-2V4z" />
                                        </svg>
                                    </span>
                                    {{ $courrier->title }}
                                </td>
                                <td>
                                    {{ $courrier->reference_interne }}
                                </td>
                                <td>
                                    {{ $courrier->externDestinateur->nom ?? 'Inconnu' }}
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
                                <td>
                                    {{ $courrier->created_at->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if ($courrier->accuseReceptions->isNotEmpty())
                                        {{ $courrier->accuseReceptions->last()->created_at->format('d/m/Y') }}
                                    @else
                                        <span>Aucun</span>
                                    @endif
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
