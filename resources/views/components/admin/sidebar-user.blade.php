<div class="sidebar">
    <div class="content-sidebar">
        <div class="logo">
            <a href="/">
                <div class="block-logo">
                    <img src="{{ asset('assets/img/logos/logo-ads1.svg') }}" alt="">
                    <img src="{{ asset('assets/img/logos/logo-ads1.svg') }}">
                </div>
                <div class="name-entreprise">
                    <h6>Name brand</h6>
                    <p>Direction générale</p>
                </div>
            </a>
        </div>
        <div class="block-btn">
            <button class="btn-add btn w-100" data-bs-toggle="modal" data-bs-target="#modal-new-personnel"><i
                    class="fi fi-rr-plus"></i> Ajouter un employé</button>
        </div>
        <div class="block-search">
            <form action="">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fi fi-rr-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Recherche" aria-label="Username"
                        aria-describedby="basic-addon1">
                </div>

            </form>
        </div>
        <ul class="nav nav-tabs mx-lg-3 mb-3 list-nav" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active pt-0" id="home-tab" data-bs-toggle="tab" data-bs-target="#person-active"
                    type="button" role="tab" aria-controls="departement" aria-selected="false">Actifs</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link pt-0" id="profile-tab" data-bs-toggle="tab" data-bs-target="#person-active"
                    type="button" role="tab" aria-controls="division" aria-selected="false">Archivés</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="person-active" role="tabpanel" aria-labelledby="home-tab">
                <div class="block-personnels">
                    <ul class="nav nav-tabs all-person" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="true">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/1.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade" id="person-active" role="tabpanel" aria-labelledby="home-tab">
                <div class="block-personnels">
                    <ul class="nav nav-tabs all-person" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="true">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/1.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#block-details-person" type="button" role="tab"
                                aria-controls="block-details-person" aria-selected="false">
                                <div class="block-detail-person d-flex align-items-center">
                                    <div class="avatar-person">
                                        <img src="{{ asset('assets/img/team/2.jpg') }}" alt="">
                                    </div>
                                    <div class="name-person">
                                        <h6>John Doe</h6>
                                        <p>Agent</p>
                                    </div>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
