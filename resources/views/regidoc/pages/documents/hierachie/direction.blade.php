@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg" style="padding-bottom: 30px">
        <div class="d-flex align-items-center gap-3 mb-lg-4">
            <a href="javascript:history.back()" class="back mb-0">
                <i class="bi bi-chevron-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h1 class="mb-0">Gestion des documents</h1>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-3 block-top-margin">
        <div class="mt-3 row g-lg-3">
            {{-- @livewire('archivage.archivage-dashboard') --}}
            @php
                $module = '';
                $titre = '';
                $url = '';
                $objects = null;
                $mainTitre = '';

                if (Request::has('lieu')) {
                    $objects = $directions;
                    $module = 'direction';
                    $titre = 'titre';
                    $url = '';
                    $mainTitre = 'Direction';
                } elseif (Request::has('direction')) {
                    $objects = $divisions;
                    $module = 'division';
                    $titre = 'libelle';
                    $url = route('regidoc.documents.index');
                    $mainTitre = 'Division';
                } elseif (Request::has('division')) {
                    $objects = $services;
                    $module = 'service';
                    $titre = 'titre';
                    $url = route('regidoc.documents.index', ['direction' => Request::get('division')]);
                    $mainTitre = 'Service';
                } else {
                    $objects = $lieux;
                    $module = 'lieu';
                    $titre = 'titre';
                    $url = '';
                    $mainTitre = 'Lieu d\'affectation';
                }
            @endphp
            <div class="col-lg-12">
                <div class="card card-table">
                    <div class="row g-3">
                        <div class="col-lg-7">
                            <h4>{{ $mainTitre }}</h4>
                        </div>
                        <div class="col-lg-5">
                            <div class="d-flex align-items-center">
                                <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                                    style="border:none;" wire:model='search'>
                                <div class="dropdown">
                                    <button class="btn btn-filter d-flex" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                            <path
                                                d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                            </path>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="javascrip:void(0)"
                                                wire:click="changeFilter('Tous')">Tous</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascrip:void(0)"
                                                wire:click="changeFilter('Classeurs')">Classeurs</a></li>
                                        <li><a class="dropdown-item" href="javascrip:void(0)"
                                                wire:click="changeFilter('Dossiers')">Dossiers</a></li>
                                        <li><a class="dropdown-item" href="javascrip:void(0)"
                                                wire:click="changeFilter('Documents')">Documents</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <div class="row g-4">

                        @forelse ($objects as $key => $object)
                            <div class="col-lg-4 col-xxl-3 col-xl-4 col-6">
                                <div class="col-folder">
                                    <a href="{{ route('regidoc.documents.index', [$module => Str::slug($object->id)]) }}"
                                        title="{{ $object->{$titre} }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/icons/cupboard-regidoc.svg') }}"
                                                alt="">
                                            <div>
                                                <h6>{{ $object->{$titre} }}</h6>
                                                {{-- <p>12 fichiers</p> --}}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center col-12">
                                <p>
                                    <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="35px"
                                        class=""><br>
                                    {{ $module == 'service' ? 'Aucun ' . $module . ' trouvé' : 'Aucune ' . $module . ' trouvée' }}
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
