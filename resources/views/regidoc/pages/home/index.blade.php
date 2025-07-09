@extends('regidoc.layouts.master')

@section('content')
    @can('Voir le tableau de bord')
        <div class="card card-lg">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-star" style="margin-bottom: 20px;">
                        <h1>Tableau de bord</h1>
                    </div>
                    {{-- <div class="mt-3 row mt-md-4">
                        <div class="col-lg-12">
                            <div class="block-info-formule d-flex">
                                <div class="icon avatar">
                                    <img src="{{ imageOrDefault(Auth::user()->agent?->image) }}"
                                        alt="photo de {{ Auth::user()->agent?->nom }}">
                                </div>
                                <div class="text">
                                    <h5>{{ Str::ucfirst(Auth::user()->agent?->prenom) }}
                                        {{ Str::upper(Auth::user()->agent?->nom) }}</h5>
                                    <h6>{{ Str::ucfirst(Auth::user()->agent?->poste?->titre) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-5">
                        <img src="{{ asset('assets/img/svg.svg') }}" alt="" class="svg">
                    </div>
                    {{-- <div class="block-circle">
                        <div class="circle-white"></div>
                        <div class="circle-white"></div>
                        <div class="circle-white"></div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="container-fluid px-lg-2 block-top-margin">

            <div class="row g-lg-2 g-2">

                @include('regidoc.pages.home.widgets.top-cards')

                {{-- <div class="col-lg-3">
                    <div class="card card-sm ">
                        <div class="content-text">
                            <div class="icon icon-call">
                                <div class="bg" style="background: #e5deba;"></div>
                                <i class="fi fi-rr-folder"></i>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5>Dossiers</h5>

                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <h3>{{-- count($dossiers) -}}</h3>
                                <a href="{{-- route('viewdossiers') -}}">Voir plus <i data-feather="chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-lg-12">
                    @livewire('dasheboard.courrier-table')
                </div> --}}
                @include('regidoc.pages.home.widgets.courriers.entrants')

                @include('regidoc.pages.home.widgets.courriers.sortants')

                @include('regidoc.pages.home.widgets.courriers.internes')

                {{-- @include('regidoc.pages.home.widgets.taches-nouvelles')

                @include('regidoc.pages.home.widgets.taches-en-cours') --}}

            </div>

            {{-- <div class="px-0 mb-2 card card-table mb-md-3">
                <div class="block-band"></div>
                <div class="px-4 pt-0 header-title">
                    <div class="row">
                        <div class="col">
                            <h4 class="no-padding no-margin">Documents à valider</h4>
                        </div>
                    </div>
                </div>

                <div class="px-3 block-scroll-lg">
                    <div class="block-taks valid">
                        <div class="icon-xs">
                            <i class="fi fi-rr-document"></i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="block-detail">
                                    <h6>Document</h6>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-taks valid">
                        <div class="icon-xs">
                            <i class="fi fi-rr-document"></i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="block-detail">
                                    <h6>Document</h6>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-taks valid">
                        <div class="icon-xs">
                            <i class="fi fi-rr-document"></i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="block-detail">
                                    <h6>Document</h6>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="px-0 mb-2 card card-table mb-md-3">
                <div class="block-band"></div>
                <div class="px-4 pt-0 header-title">
                    <div class="row">
                        <div class="col">
                            <h4 class="no-padding no-margin">Documents à signer</h4>
                        </div>
                    </div>
                </div>

                <div class="px-3 block-scroll-lg">
                    <div class="block-taks valid">
                        <div class="icon-xs">
                            <i class="fi fi-rr-document"></i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="block-detail">
                                    <h6>Document</h6>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-taks valid">
                        <div class="icon-xs">
                            <i class="fi fi-rr-document"></i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="block-detail">
                                    <h6>Document</h6>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-taks valid">
                        <div class="icon-xs">
                            <i class="fi fi-rr-document"></i>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="block-detail">
                                    <h6>Document</h6>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card card-users card-table">
                <div class="block-band"></div>
                <div class="pt-0 header-title">
                    <div class="row">
                        <div class="col">
                            <h4 class="no-padding no-margin">Taux de presence</h4>

                        </div>

                    </div>

                </div>
                <div class="d-flex justify-content-between">
                    <div class="block-progress-circle">
                        <div class="pourcent">
                            <span>20</span>
                            <span>%</span>
                        </div>
                    </div>
                    <div class="block-progress-circle-sm">
                        <div class="pourcent">
                            <span>80</span>
                            <span>%</span>
                        </div>
                    </div>
                </div>
                <div class="block-label d-flex">
                    <div class="block w-50 d-flex align-items-center">
                        <span></span> Connectés
                    </div>
                    <div class="block w-50 d-flex align-items-center">
                        <span></span> Non connectés
                    </div>
                </div>
                <div class="block-scroll-sm">
                    @for ($i = 0; $i < 12; $i++)
                        <div class="mt-3 block-users">

                            <div class="block-title d-flex justify-content-between align-center">
                                <h6 class="mb-0">Département</h6>
                                <p>
                                    5 Membres
                                </p>
                            </div>

                            <div class="block-avatar d-flex align-items-end justify-content-between">
                                <p class="mb-0">
                                    4 Connectés
                                </p>
                                <div class="block-user d-flex" style="z-index:1">
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
                                    <div class="user">
                                        <img src="{{ asset('assets/img/team/1.jpg') }}" alt="image profil">
                                    </div>
                                    <div class="user badge-plus">
                                        <i data-feather="plus"></i>
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endfor
                </div>

            </div> --}}
        </div>
    @else
        <div class="text-center">
            <h1>Bienvenu sur MaxiDoc, votre logiciel de gestion électronique de courrier.</h1>
            <p>Veillez contacter un administrateur pour la configuration de votre espace de travail.</p>
        </div>
    @endcan
@endsection
