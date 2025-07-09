<div class="sidebar sidebar-mobile sidebar-person">
    <div class="logo">
        <a href="/">
            <div class="block-logo">
                <img src="{{ asset('assets/regidoc/logo-regidoc2.svg') }}" alt="">
                <img src="{{ asset('assets/regidoc/logo-icon-regidoc2.svg') }}">
            </div>
        </a>

    </div>
    <div class="content-sidebar">
        <div class="block-btn">
            <button class="btn-add btn w-100" data-bs-toggle="modal" data-bs-target="#modal-new-personnel"><i
                    class="fi fi-rr-plus"></i> Ajouter un employé</button>
        </div>
        <div class="block-search">
            {{-- <form action="">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fi fi-rr-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Recherche" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

            </form> --}}
        </div>
        <ul class="mb-3 nav nav-tabs mx-lg-3 list-nav" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="pt-0 nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#person-active"
                    type="button" role="tab" aria-controls="departement" aria-selected="false">Actifs</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="pt-0 nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#person-inactive"
                    type="button" role="tab" aria-controls="division" aria-selected="false">Inactifs</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="person-active" role="tabpanel" aria-labelledby="home-tab">
                <div class="block-personnels">
                    <ul class="nav nav-tabs all-person" id="myTab" role="tablist">
                        @forelse ($agents->where('statut_id', 1) as $key => $agent)
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link click-panel-active @if ($loop->first) active @endif"
                                    id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#block-details-person-{{ $agent->id }}" type="button"
                                    role="tab" aria-controls="block-details-person" aria-selected="true">
                                    <div class="block-detail-person d-flex align-items-center">
                                        <div class="avatar-person">
                                            <img src="{{ imageOrDefault($agent->image) }}" alt="">
                                        </div>
                                        <div class="name-person">
                                            <h6>{{ $agent->prenom . ' ' . $agent->nom }}</h6>
                                            <p>{{ $agent->poste?->titre }}</p>
                                        </div>
                                    </div>
                                </button>
                            </li>
                        @empty
                            <li class="nav-item" role="presentation">
                                Aucun employé n'est actif !
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="person-inactive" role="tabpanel" aria-labelledby="home-tab">
                <div class="block-personnels">
                    <ul class="nav nav-tabs all-person" id="myTab" role="tablist">
                        @if ($users->where('statut_id', '!=', '1')->count() < 1)
                            <li class="nav-item" role="presentation">
                                Aucun employé est inactif !
                            </li>
                        @else
                            @foreach ($users->where('statut_id', '!=', '1') as $key => $user)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link click-panel-inactive {{ $key == 0 ? 'active' : '' }}"
                                        id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#block-details-person-active-{{ $user->id }}" type="button"
                                        role="tab" aria-controls="block-details-person" aria-selected="true">
                                        <div class="block-detail-person d-flex align-items-center">
                                            <div class="avatar-person">
                                                <img src="{{ imageOrDefault($user->agent->image) }}" alt="">
                                            </div>
                                            <div class="name-person">
                                                <h6>{{ $user->prenom . ' ' . $user->nom }}</h6>
                                                <p>{{ $user->poste?->titre }}</p>
                                            </div>
                                        </div>
                                    </button>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
