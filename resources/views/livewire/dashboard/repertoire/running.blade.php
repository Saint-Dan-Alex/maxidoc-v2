<div class="col-lg-12">
    <div class="card card-table" style="overflow: inherit">
        <div class="d-none position-absolute loader-card d-flex justify-content-center m-0"
            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
            wire:loading wire:target="filter, changeFilter" wire:loading.class.remove="d-none">
            <div class="text-center m-auto">
                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                    <span class="sr-only"></span>
                </div>
            </div>
        </div>
        <div class="row g-3">
            {{-- 
            <div class="col-lg-6 col-sm-6 col-xl-8">
                <h4>Courriers en cours de traitement</h4>
            </div> --}}
            {{-- Filtres --}}
            <div class="row g-3 align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center">
                            <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                                style="border:none;" wire:model='search'>
                        </div>
                    </div>

                </div>
                <div class="col-12 col-md-6 col-sm-6 col-lg-6">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <div class="input-group block-input-filter">
                            {{-- <select id="filtre-lieu" class="form-select form-control"  name="lieus"
                                wire:model.debounce.500ms = "lieuFilter">
                                <option value="null" selected disabled>Lieu</option>
                                <option value="">Toutes</option>
                                @foreach ($lieus as $lieu)
                                    <option value={{ $lieu->id}} @selected(Auth::user()->agent->lieu->id == $lieu->id)>{{ $lieu->titre }}</option>
                                @endforeach    
                            </select>   --}}
                            {{-- <select id="filtre-departement" wire:model="directionFilter" class="form-select form-control" name='direction_select'>
                                <option value="" selected disabled>Direction</option>
                                <option value="">Tous</option>
                                @foreach ($directions as $direction)
                                    <option value="{{ $direction->id }}">{{ $direction->titre }}</option>
                                @endforeach
                            </select>
                        
                            <select id="filtre-division" wire:model="divisionFilter" class="form-select form-control" name='division_select'>
                                <option value="" selected disabled>Division</option>
                                <option value="">Toutes</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->libelle }}</option>
                                @endforeach
                            </select>
                        
                            <select id="filtre-agent" wire:model="agentFilter" class="form-select form-control" name='agent_select'>
                                <option value="" selected disabled>Agent</option>
                                <option value="">Tous</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->nom . ' ' . $agent->prenom . ' ' . $agent->post_nom }}</option>
                                @endforeach
                            </select>
                            
                            <select name="datep" id="jour" class="form-select form-control"
                                wire:model.debounce.500ms = 'selectedDay'>
                                <option value="null" selected disabled>Jour</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}">
                                        {{ now()->day($i)->isoFormat('DD') }}
                                    </option>
                                @endfor
                            </select> 
                            <select name="datep" id="mois" class="form-select form-control"
                                wire:model.debounce.500ms = 'selectedMonth'>
                                <option value="null" selected disabled>Mois</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">
                                        {{ now()->month($i)->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="datep" id="annee" class="form-select form-control"
                                style="border-right: none" wire:model.debounce.500ms = 'selectedYear'>
                                <option value="null" selected disabled>Année</option>
                                {{-- @for ($i = 1990; $i < ((int) now()->year) + 1; $i++) 
                                @for ($i = ((int) now()->year); $i > 1990; $i--)
                                    <option value="{{ $i }}">
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select> 
                            <button class="btn btn-add refresh-filter btn-search-sm" type="button"
                                id="" wire:click="refreshSelection">
                                <i class="fi fi-rr-refresh"></i>
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr class="mt-3 mb-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">N° d'enregistrement</th>
                        <th scope="col">Expediteur</th>
                        <th scope="col">Destinataire</th>
                        <th scope="col">Accusées réceptions</th>
                        <th scope="col">Date du courrier</th>
                        <th scope="col">Type</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courriers as $courrier)
                        <tr @class(['', 'tr-no-read' => !$courrier->isViewed()])>
                            @if ($courrier->type->titre === 'Sortant')
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
                            @endif

                            @if ($courrier->type->titre === 'Entrant')
                                <td class="text-truncate title-file-box-table-data">
                                    <span class="mail-entry-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                            viewBox="0 0 24 24">
                                            <path fill="currentColor"
                                                d="M11 4h2v12l5.5-5.5l1.42 1.42L12 19.84l-7.92-7.92L5.5 10.5L11 16z" />
                                        </svg>
                                    </span>
                                    {{ $courrier->title }}
                                </td>
                            @endif

                            @if ($courrier->type->titre === 'Interne')
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
                            @endif
                            <td>{{ $courrier->reference_interne }}</td>
                            <td>
                                @if ($courrier->type_id == 1)
                                    {{ $courrier->externExpediteur->nom ?? 'N/D' }}
                                @elseif($courrier->type_id == 3)
                                    {{ $courrier->service->titre ?? 'N/D' }}
                                @else
                                    Regideso S.A
                                @endif
                            </td>
                            <td>
                                @if ($courrier->type_id == 2)
                                    {{ $courrier->externDestinateur->nom ?? 'N/D' }}
                                @elseif($courrier->type_id == 3)
                                    {{ $courrier->toDirection->titre ?? 'N/D' }}
                                @else
                                    Regideso S.A
                                @endif
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
                                                    data-bs-target="#detail-personnel" aria-controls="offcanvasRight">
                                                    <div class="tooltip-team">
                                                        {{ $follower->poste?->titre }}</div>
                                                    <img src="{{ imageOrDefault($follower->image) }}" alt="">
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
                                                    <span>4+</span>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    aria-labelledby="dropdownMenuButton2" style="">
                                                    <div class="list-users">
                                                        @foreach ($others as $agent)
                                                            <div class="content-user d-flex align-items-center">
                                                                <div class="avatar" style="flex: 0 0 auto">
                                                                    <img src="{{ imageOrDefault($agent?->image) }}"
                                                                        alt="{{ $agent->prenom }} {{ $agent->nom }}">
                                                                </div>
                                                                <div class="name">
                                                                    {{ $agent->prenom }}
                                                                    {{ $agent->nom }} <br>
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
                            <td>{{ $courrier->created_at->format('d/m/Y') }}</td>
                            <td>{{ $courrier->type->titre }}</td>
                            <td>
                                <div @class([
                                    'badge',
                                    'badge-gray' => $courrier->statut_id == 1,
                                    'badge-yellow' => $courrier->statut_id == 2,
                                    'badge-green' => $courrier->statut_id == 3,
                                ])>
                                    {{ $courrier->statut?->libelle ?? 'Inconnu' }}
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center td-empty">
                                <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px"
                                    class="">
                                <br>
                                Aucun courrier numérisé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (count($courriers))
            {{ $courriers->links() }}
        @endif
    </div>
</div>

@section('scripts')
    {{-- <script>
    $('select[name=lieu_id]').on('change', function(e) {
            livewire.emit('changeLieu', e.target.value);
        });

        $('select[name=direction_select]').on('change', function(e) {
            livewire.emit('updatedDirectionFilter', e.target.value);
        });

        $('select[name=division_select]').on('change', function(e) {
            livewire.emit('updatedDivisionFilter', e.target.value);
        });

        $('select[name=sevice_id]').on('change', function(e) {
            // console.log(e);
            livewire.emit('changeService', e.target.value);
        });

        $('select[name=section_id]').on('change', function(e) {
            livewire.emit('changeSection', e.target.value);
        });
</script> --}}
@endsection
