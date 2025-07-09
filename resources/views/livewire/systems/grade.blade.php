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
            <div class="col-lg-5"></div>
            <div class="col-lg-7 d-flex align-items-center justify-content-end">
                <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                    style="border:none;" wire:model='search'>
                <div class="dropdown">
                    <button class="btn btn-filter me-2" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                            <path
                                d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                            </path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                défaut</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A - Z</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z - A</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                d'ajout</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                modification</a></li>
                    </ul>
                </div>
                <a href="#" class="btn btn-add" data-bs-toggle="modal" style="flex: 0 0 auto"
                    data-bs-target="#modal-new-grade">
                    Ajouter
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Responsable</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grades as $grade)
                        <tr>
                            <td> {{ $grade->titre }} </td>
                            <td>
                                <div class="d-flex align-items-center btns-action-table">
                                    {{-- <a href="#" class="btn btn-primary  p-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-show-grade-{{ $grade->id }}"><i
                                            class="fi fi-rr-eye"></i>
                                        Voir</a> --}}
                                    <a href="#" class="btn btn-success  p-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-grade-{{ $grade->id }}"><i
                                            class="fi fi-rr-pencil"></i>
                                        Editer</a>
                                    <form action="{{ route('regidoc.grades.destroy', $grade) }}" method="POST"
                                        style="flex: 0 0 auto">
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
                                    <p>Aucun departement trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
