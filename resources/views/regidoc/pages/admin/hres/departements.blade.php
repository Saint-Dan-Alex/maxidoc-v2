@extends('layouts.home')
@section('content')
    <div class="container-fluid px-lg-3">
        <div class="row g-lg-3 g-3">
            <div class="col-lg-9">
                <div class="card card-lg">

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text-star">
                                <h1>Bienvenue sur ADS votre logiciel <br> de gestion intélligent.</h1>
                                <p></p>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-6">
                                    <div class="block-info-formule d-flex">
                                        <div class="icon avatar">
                                            <img src="{{ asset('uploads/profiles/' . (Auth::user()->personnel->avatar ?? 'default.png')) }}"
                                                alt="photo profil">
                                        </div>
                                        <div class="text">
                                            <h5>{{ Auth::user()->personnel->nom }}</h5>
                                            <h6>{{ Auth::user()->personnel->fonction->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6">
                                    <div class="block-info-formule d-flex">
                                        <div class="icon">
                                            <i class="fi fi-rr-users fi-rr"></i>
                                        </div>
                                        <div class="text">
                                            <h6></h6>
                                            <h5>10.8k</h5>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-5">

                            <img src="{{ asset('assets/img/svg.svg') }}" alt="" class="svg">

                        </div>
                        <div class="block-circle">
                            <div class="circle-white"></div>
                            <div class="circle-white"></div>
                            <div class="circle-white"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-lg-3 mt-2">
                    <div class="col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="content-text">
                                <div class="icon icon-call">
                                    <div class="bg" style="background: #9abcc5;">

                                    </div>

                                    <i class="fi fi-rr-users"></i>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>Total agents</h5>

                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>100</h3>
                                    <a href="{{ route('dige.departements') }}">Voir plus <i
                                            data-feather="chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="content-text">
                                <div class="icon icon-call">
                                    <div class="bg" style="background: #f79596;"></div>
                                    <i class="fi fi-rr-calendar-clock"></i>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>Pointage</h5>

                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>4</h3>
                                    <div class="block-statuts d-flex align-items-center">
                                        <div class="statut d-flex align-items-center">
                                            <div class="bubble active"></div>
                                            <div>12</div>
                                        </div>
                                        <div class="statut d-flex align-items-center">
                                            <div class="bubble missing"></div>
                                            <div>12</div>
                                        </div>
                                        <div class="statut d-flex align-items-center">
                                            <div class="bubble vacation"></div>
                                            <div>12</div>
                                        </div>
                                        <div class="statut d-flex align-items-center">
                                            <div class="bubble offsite"></div>
                                            <div>12</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-sm h-100">
                            <div class="content-text">
                                <div class="icon icon-call">
                                    <div class="bg" style="background: #b8cbaf;">

                                    </div>

                                    <i class="fi fi-rr-users"></i>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>Demandes d'absence</h5>

                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>100</h3>
                                    <a href="{{ route('dige.departements') }}">Voir plus <i
                                            data-feather="chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card card-users card-table">
                            <div class="block-band"></div>
                            <div class="header-title pt-0">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="no-padding no-margin">Taux de presence</h4>
                                    </div>

                                </div>

                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="present">
                                    <h6 class="mb-0">Non connectés</h6>
                                </div>
                                <div class="indictor-present">
                                    <h5 class="mb-0">15</h5>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="absent">
                                    <h6 class="mb-0">Connectés</h6>
                                </div>
                                <div class="indictor-absent">
                                    <h5 class="mb-0">5</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <ul class="nav nav-tabs mb-0 nav-folder" id="myTab" role="tablist">
                                <li class="nav-item me-1" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#departement" type="button" role="tab"
                                        aria-controls="departement" aria-selected="true">Départements</button>
                                </li>
                                <li class="nav-item me-1" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#division" type="button" role="tab"
                                        aria-controls="division" aria-selected="false">Divisions</button>
                                </li>
                                <li class="nav-item me-1" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#fonction" type="button" role="tab"
                                        aria-controls="fonction" aria-selected="false">Fonctions</button>
                                </li>
                                <li class="nav-item me-1" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#personnel" type="button" role="tab"
                                        aria-controls="personnel" aria-selected="false">Liste du personnel</button>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                                            </li> -->
                            </ul>

                        </div>
                        {{-- departement --}}
                        @livewire('humanres.rh.rh')
                    </div>
                    <div class="col-g-12">
                        <div class="card card-table">
                            <div class="card-header bg-light py-0 px-0" style="background:none!important">
                                <div class="row flex-between-center">
                                    <div class="col-auto">
                                        <h6 class="mb-0">Parité Homme/Femme</h6>
                                    </div>
                                    <div class="col-auto d-flex"><a class="btn btn-link btn-sm me-2" href="#!">Voir
                                            les détails</a>

                                    </div>
                                </div>
                            </div>
                            <div class="card-body  px-0">
                                <!-- Find the JS file for the following chart at: src/js/charts/echarts/top-products.js-->
                                <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                                <div class="echart-bar-top-products " data-echart-responsive="true"></div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-3">
                        
                        <div class="card card-sm ">
                            <div class="content-text">
                                <div class="icon icon-call" >
                                    <div class="bg" style="background: #e5deba;"></div>
                                    <i class="fi fi-rr-folder"></i>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5>Dossiers</h5>
                                    
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3>{{count($dossiers)}}</h3>
                                    <a href="{{route('viewdossiers')}}">Voir plus <i data-feather="chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="calendar mb-3">
                    <div class="calendar-header">
                        <span class="month-picker" id="month-picker">February</span>
                        <div class="year-picker">
                            <span class="year-change" id="prev-year">
                                <pre><i class="fi fi-rr-angle-left"></i></pre>
                            </span>
                            <span id="year">2021</span>
                            <span class="year-change me-0" id="next-year">
                                <pre><i class="fi fi-rr-angle-right"></i></pre>
                            </span>
                        </div>
                    </div>
                    <div class="calendar-body">
                        <div class="calendar-week-day">
                            <div>Dim</div>
                            <div>Lun</div>
                            <div>Mar</div>
                            <div>Mer</div>
                            <div>Jeu</div>
                            <div>Ven</div>
                            <div>Sam</div>
                        </div>
                        <div class="calendar-days"></div>
                    </div>
                    <div class="month-list"></div>
                </div>
                <div class="card card-table  px-0 mb-3">
                    <div class="block-band"></div>
                    <div class="header-title px-4 pt-0">
                        <div class="row">
                            <div class="col">
                                <h4 class="no-padding no-margin">Taches (cette semaine)</h4>

                            </div>

                        </div>

                    </div>

                    <div class="block-scroll-lg px-3">
                        <div class="block-taks">
                            <div class="row">
                                <div class="col-6" data-bs-toggle="offcanvas" data-bs-target="#detail-task"
                                    aria-controls="offcanvasRight">
                                    <div class="block-detail">
                                        <h6>Name tache</h6>
                                        <p>Description</p>
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-end" style="flex-direction:column">
                                    <p>12 janv</p>
                                    <div class="block-user d-flex">
                                        <div class="user">
                                            <span class="online"></span>
                                            <img src="{{ asset('assets/img/team/1.jpg') }}" alt="image profil">
                                        </div>
                                        <div class="user">
                                            <img src="{{ asset('assets/img/team/1.jpg') }}" alt="image profil">
                                        </div>
                                        <div class="user">
                                            <img src="{{ asset('assets/img/team/1.jpg') }}" alt="image profil">
                                        </div>

                                        <div class="user badge-plus">
                                            <i data-feather="plus"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="card card-table  px-0 mb-3">
                    <div class="block-band"></div>
                    <div class="header-title px-4 pt-0">
                        <div class="row">
                            <div class="col">
                                <h4 class="no-padding no-margin">Absences aujourd'hui</h4>

                            </div>

                        </div>

                    </div>
                    <div class="all-absents px-4 mt-2">
                        <div class="block-absent d-flex">
                            <div class="avatar-absent">
                                <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                            </div>
                            <div class="block-details-absent">
                                <h6>Peter Kalala</h6>
                                <p>Malade</p>
                            </div>
                        </div>
                        <div class="block-absent d-flex">
                            <div class="avatar-absent">
                                <img src="{{ asset('assets/img/team/2.jpg') }}" alt="photo profil">
                            </div>
                            <div class="block-details-absent">
                                <h6>Peter Kalala</h6>
                                <p>Non justifiée</p>
                            </div>
                        </div>
                        <div class="block-absent d-flex">
                            <div class="avatar-absent">
                                <img src="{{ asset('assets/img/team/3.jpg') }}" alt="photo profil">
                            </div>
                            <div class="block-details-absent">
                                <h6>Peter Kalala</h6>
                                <p>Malade</p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card card-table  px-0 mb-3">
                    <div class="block-band"></div>
                    <div class="header-title px-4 pt-0">
                        <div class="row">
                            <div class="col">
                                <h4 class="no-padding no-margin">Absences des prochaines jours</h4>

                            </div>

                        </div>

                    </div>
                    <div class="all-absents px-4 mt-2">
                        <div class="block-absent d-flex">
                            <div class="avatar-absent">
                                <img src="{{ asset('assets/img/team/1.jpg') }}" alt="photo profil">
                            </div>
                            <div class="block-details-absent">
                                <h6>Peter Kalala</h6>
                                <p>20 <i class="fi fi-rr-arrow-right"></i> 23 Janv</p>
                            </div>
                        </div>
                        <div class="block-absent d-flex">
                            <div class="avatar-absent">
                                <img src="{{ asset('assets/img/team/2.jpg') }}" alt="photo profil">
                            </div>
                            <div class="block-details-absent">
                                <h6>Peter Kalala</h6>
                                <p>20 <i class="fi fi-rr-arrow-right"></i> 23 Janv</p>
                            </div>
                        </div>
                        <div class="block-absent d-flex">
                            <div class="avatar-absent">
                                <img src="{{ asset('assets/img/team/3.jpg') }}" alt="photo profil">
                            </div>
                            <div class="block-details-absent">
                                <h6>Peter Kalala</h6>
                                <p>20 <i class="fi fi-rr-arrow-right"></i> 23 Janv</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-lg-4">

        <div class="row g-lg-3 mt-3">



            <div class="col-lg-3">



                <!-- <div class="card card-widget-plan mt-3">
                                <h5>Current subscription plan</h5>
                                <h4><sup>$</sup>10/month</h4>
                                <p>Basic plan</p>
                                <div class="text-star">
                                    <a href="#" class="btn-change">Change plan</a>
                                </div>
                                <img src="images/plan3.svg" alt="">
                            </div> -->
            </div>

        </div>
    </div>

    @include('components.admin.modals.personals')
@endsection
