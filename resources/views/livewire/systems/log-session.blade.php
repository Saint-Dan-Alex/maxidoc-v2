<div class="col-lg-12">
    {{-- <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ url()->previous() }}" class="back">
            <i class="fi fi-rr-angle-left"></i> Retour
        </a>
        
    </div> --}}

    <div class="card card-table pt-5" style="overflow: inherit">
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
            <div class="col-lg-7 ms-auto">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche" style="border:none;"
                    wire:model='search'>
                <div class="dropdown">
                    <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                            <path
                                d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                            </path>
                        </svg>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Connexion</a>
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>Déconnexion</a></li>
                    </ul>
                </div>
                </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">IP Address</th>
                        <th scope="col">Connecxion</th>
                        <th scope="col">Deconnexion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>    
                            <td> {{ $log->authenticatable->name }} </td>
                            <td> {{ $log->ip_address }} </td>
                            <td>
                                <div class="badge">
                                    {{ $log->login_at }}
                                </div>
                            </td>
                            <td>
                                <div class="badge badge-red">
                                    {{ $log->logout_at }}
                                </div>
                            </td>
                        </tr>
                    @empty

                        <tr>
                            <td colspan="5">
                                <div class="text-center col-12">
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px"
                                        class="">
                                    <p>Aucun log trouvé</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
