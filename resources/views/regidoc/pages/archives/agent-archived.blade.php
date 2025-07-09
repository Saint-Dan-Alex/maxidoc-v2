@extends('regidoc.layouts.master')
@section('content')
    <div class="container-fluid px-lg-4">
        {{-- <h1 class="mb-0">{{ Str::ucfirst($doc->titre) }}</h1>
        <p class="mb-0">Ref: {{ Str::ucfirst($doc->reference) }}</p>
        <p>Créé le: {{ $doc->created_at->format('d/m/Y') }}</p> --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="javascript:history.go(-1)" class="back mb-0">
                <i class="fi fi-rr-angle-left"></i>
            </a>
            <div class="block-btns btns-actions">
                <a href="{{ route('regidoc.rh.agent.desarchived', ['agent' => $agent->id, 'doc' => $doc->id]) }}"
                    class="btn">
                    <i class="fi fi-rr-box"></i> Desarchiver l'agent
                </a>
            </div>
        </div>
        <div class="row g-lg-3">
            <div class="col-lg-12">
                <div class="card card-table card-profil card-profil-sm h-100">
                    <div class="block-user-info">
                        <div class="row g-3 align-items-center">
                            <div class="col-lg-4">
                                <div class="d-flex">
                                    <div class="avatar-user">
                                        <img src="{{ imageOrDefault($agent->image) }}" alt="photo de profil"
                                            id="img-profil-user">
                                    </div>

                                    <div class="text-star">
                                        <h4>{{ $agent?->nom }}</h4>
                                        <p class="mb-0">{{ $agent?->poste?->titre }}</p>
                                        <p class="mb-0">Matricule: {{ $agent?->matricule }} </p>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-6 text-star">
                                        <h5></h5>

                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="details-contact">
                                    <div class="details">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <div class="block-detail-sm">
                                                    <div class="icon">
                                                        <i class="fi fi-rr-envelope"></i>
                                                    </div>
                                                    <div class="infos">
                                                        <p>Email</p>
                                                        <h6>
                                                            {{ $agent->user->email }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="block-detail-sm">
                                                    <div class="icon">
                                                        <i class="fi fi-rr-phone-call"></i>
                                                    </div>
                                                    <div class="phone">
                                                        <p>Téléphone</p>
                                                        <h6>
                                                            {{ $agent?->adresse?->phone }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="block-detail-sm">
                                                    <div class="icon">
                                                        <i class="fi fi-rr-marker"></i>
                                                    </div>
                                                    <div class="infos">
                                                        <p>Adresse</p>
                                                        <h6>
                                                            {{ $agent?->adresse?->residence }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-table card-profil">
                    <div class="info-lg pt-0">
                        <h2>Infos personnelles</h2>
                        <div class="row g-3">
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Nom</p>
                                    <h6>{{ $agent?->nom }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Post-nom</p>
                                    <h6>{{ $agent?->post_nom }}</h6>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Prenom </p>
                                    <h6>{{ $agent?->prenom }}</h6>
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Sexe</p>
                                    <h6>{{ $agent?->sexe }}</h6>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Lieu de naissance</p>
                                    <h6>{{ $agent?->lieu_naiss }}</h6>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Date de naissance</p>
                                    <h6>
                                        {{ $agent?->date_naiss }}
                                    </h6>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Province d'origine</p>
                                    <h6>{{ $agent?->province }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Ville d'origine</p>
                                    <h6>{{ $agent?->ville }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Nationalité</p>
                                    <h6>{{ $agent?->nationalite }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Etat civil</p>
                                    <h6>{{ $agent?->etat_civil }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Nombre d'enfants</p>
                                    <h6>{{ $agent?->nbr_enfants }}</h6>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="info-lg">
                        <h2>Infos professionnelles</h2>
                        <div class="row g-3">
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Direction</p>
                                    <h6>{{ $agent?->direction->titre }}</h6>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Division</p>
                                    <h6>{{ $agent?->division->libelle }}</h6>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Service </p>
                                    <h6>{{ $agent?->service->titre }}</h6>
                                </div>
                            </div>


                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Fonction</p>
                                    <h6>{{ $agent?->poste?->titre }}</h6>
                                </div>

                            </div>
                            <div class="col-lg-3">
                                <div class="items">
                                    <p>Matricule</p>
                                    <h6>{{ $agent?->matricule }}</h6>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
