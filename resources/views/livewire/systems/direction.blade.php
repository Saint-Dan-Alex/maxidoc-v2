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
        <div class="row">
            <div class="col-lg-4">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                </path>
                            </svg>
                            {{-- <i class="fi fi-rr-filter me-2"></i> {{ $filterText }} --}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(6)'>Lieu
                                    d'Affectation</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                    modification</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 ms-auto">
                <div class="d-flex justify-content-end align-items-center">

                    <a href="#" class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-direction"
                        style="flex: 0 0 auto">
                        Ajouter
                    </a>
                </div>
            </div>
        </div>

        {{-- @livewire('datatable.datatable', [
            'model' => \App\Models\Direction::class,
            'options' => [
                'headers' => [
                    'Code',
                    'Nom',
                    'Lieu',
                    'Responsable',
                    'Responsable Adjoint',
                    'Nbr Agents',
                ],
                'headers' => [
                    'code',
                    'titre',
                    'Lieu',
                    'Responsable',
                    'Responsable Adjoint',
                    'Nbr Agents',
                ],
            ]
        ]) --}}

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Lieu</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Responsable Adjoint</th>
                        <th scope="col">Nbr Agents</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($directions as $direction)
                        <tr>
                            <td> {{ $direction->code }} </td>
                            <td class="text-truncate"> {{ $direction->titre }} </td>
                            <td> {{ $direction->lieu->titre }} </td>
                            <td> {{ $direction->responsable?->prenom . ' ' . $direction->responsable?->nom }} </td>
                            <td> {{ $direction->adjoint?->prenom . ' ' . $direction->adjoint?->nom }} </td>
                            <td> {{ $direction->agents->count() }} </td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table" wire:ignore>
                                    {{-- <a href="#" class="btn btn-primary  p-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-show-direction-{{ $direction->id }}"><i
                                            class="fi fi-rr-eye"></i>
                                        Voir</a> --}}
                                    <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-direction-{{ $direction->id }}"><i
                                            class="fi fi-rr-pencil"></i>
                                        Editer</a>
                                    <form action="{{ route('regidoc.directions.destroy', $direction) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger  p-2"><i
                                                class="fi fi-rr-trash"></i>
                                            Supprimer</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="text-center col-12">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px"
                                        class="">
                                    <p>Aucune direction trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {!! $directions->links() !!}
    </div>


</div>

