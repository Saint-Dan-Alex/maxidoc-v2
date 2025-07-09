@extends('layouts.app')

@section('search')
    @livewire('search-departement')
@endsection
@section('content')
    <div class="header bg-blend-lighten pb-6">
        <div class="header-body">
            <div class="row">

                <div class="col-md-9 mb-4">
                    <div class="breadcrumb"><a href="{{route('dige.index')}}"><span>Dashboard</span> </a> <span>> Classeurs </span></div>
                        <h6 class="h2 text-gray d-inline-block mb-0">Direction des réssources humaines </h6>
                    </div>
                    <div class="col-md-3 ">
                        <button class="btn btn-primary rounded-pill shadow w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#add" aria-controls="adddossier">Ajouter un personnel</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Topnav -->
                @if(Session::has('success'))

                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>

                @endif
                    @foreach ($personels as $user )
                        <div class="col-md-6" id="{{$user->name}}">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">


                                    <div class="float-right text-end">

                                        <a href="" data-bs-toggle="modal" data-bs-target="#supclasseur_{{$user->id}}">
                                            <i class="fas fa-times-circle fs-4 text-danger m-3 cursor-pointer"></i>
                                        </a>

                                    </div>
                                    {{-- Detail --}}
                                    <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="detail_{{$user->id}}" aria-labelledby="offcanvasRightLabel">
                                        <div class="shadow" style="height: 100%;">
                                            <div class="offcanvas-header">
                                                <h5 id="offcanvasRightLabel">Détail du personnel {{$user->name}}</h5>
                                                <button type="button" class="btn-close text-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                            </div>
                                            <div class="card-header row position-relative mt-5 ">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-4">
                                                    <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="{{asset('assets\img\gallery\user.jpg')}}" width="200" alt="" /></div>

                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                        </div>
                                        <div class="offcanvas-body d-flex justify-content-center">

                                            <div class="modal-body">

                                                <input type="hidden" name="created" value="{{ Auth::user()->id }}">
                                                <div class="form-group">


                                                    <label for="name" class="">Nom Complet :

                                                        <span> <b class="card-title">{{$user->name ?? 'Non specifié'}} {{$user->postnom ?? 'Non specifié'}}</b> {{$user->prenom ?? 'Non specifié'}} </span>

                                                    </label><br>
                                                    <label for="name" class="">Fonction :

                                                        <span> <b class="card-title">{{$user->fonction->name ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Matricule :

                                                        <span> <b class="card-title">{{$user->matricule ?? 'N U'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Departement :

                                                        <span> <b class="card-title">{{$user->personnel->departement->nom ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Division :

                                                        <span> <b class="card-title">{{$user->personnel->division->denomination ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Date de naissance :

                                                        <span> <b class="card-title">{{$user->personnel->date_naissance ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Lieu de naissance :

                                                        <span> <b class="card-title">{{$user->personnel->lieu_naissance ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Etat-civile :

                                                        <span> <b class="card-title">{{$user->personnel->etat_civil ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Nationalité :

                                                        <span> <b class="card-title">{{$user->personnel->nationalite ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Adresse-complet :

                                                        <span> <b class="card-title">{{$user->personnel->adresse ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Telephone :

                                                        <span> <b class="card-title">{{$user->personnel->telephone ?? 'Non specifié'}}</b> </span>

                                                    </label><br>

                                                    <label for="name" class="">Adresse-Email :

                                                        <span> <b class="card-title">{{$user->personnel->email ?? 'Non specifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Etat du compte de l’agent :

                                                        <span> <b class="card-title">{{$user->personnel->statut->name ?? 'Non spécifié'}}</b> </span>

                                                    </label><br>
                                                    <label for="name" class="">Déscription :

                                                        <span class="fs-1"> {{$user->personnel->description ?? 'Non spécifié'}}</span>

                                                    </label><br>
                                                    <label for="name" class="">Créé par :

                                                        <span class="card-title"> <b>{{$user->personnel->creator->name ?? 'Non spécifié'}}</b> </span>

                                                    </label><br>

                                                    {{-- <label for="name" class="">Mis a jour par :

                                                        <span class="card-title"> <b>{{$user->update ?? 'Non spécifié'}}</b> </span>

                                                    </label><br> --}}


                                                    <label for="name" class="">Date de creation :

                                                        <span class="card-title"> <b>{{$user->personnel->created_at ?? 'Non spécifié'}}</b> </span>

                                                    </label><br>


                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="offcanvas" aria-label="Close">Annuler</button>
                                                    {{-- <a href="" class="btn btn-primary btn-sm">Profile</a> --}}
                                                    <button type="button" class="btn btn-secondary" data-bs-toggle="offcanvas" data-bs-target="#modifier_{{$user->id}}">Modifier</button>
                                                </div>

                                            </div>



                                        </div>

                                    </div>
                                    <!-- Modal -->
                                    <div wire:ignore.self class="modal fade" id="supclasseur_{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Suppression</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="" method="post">
                                                    @csrf
                                                    <input type="hidden" value="{{$user->id}}" name="id">
                                                    <span class="text-center fw-bold">
                                                        Voulez-vous vraiment supprimer {{$user->name ?? 'Non spécifié'}}  ?
                                                    </span>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- end modal --}}
                                    <div class="col-md-5 ">
                                        {{-- <a href="" class="">
                                            <img src="{{asset('assets\img\gallery\profil.png')}}" class="img-fluid rounded-start w-100  fit-contain m-2" alt="...">
                                        </a> --}}
                                        <div class="avatar status-online">
                                            <img src="{{asset('assets\img\gallery\profil.png')}}" class="img-fluid rounded-start w-100  fit-contain m-2" alt="...">

                                        </div>

                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body" >

                                            <span ><b>Nom</b> </span>
                                            <h5 class="card-title">{{$user->name ?? 'Non spécifié'}}</h5>
                                            <span> <b>E-mail</b> </span>
                                            <h5 class="card-title">{{$user->email ?? 'Pas d\'e-mail'}}</h5>
                                            <div>
                                                <div>
                                                    <span> <b>Fonction</b>
                                                        <h5 class="card-text text-gray"> {{$user->fonction->name ?? 'Pas de fonction'}} </h5>

                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="card-text"><small class="text-muted">Matricule : <b>{{$user->matricule ?? 'Pas de matricule'}}</b> </small></span>
                                            </div>
                                            <div>
                                                <span class="card-text"><small class="text-muted">Date : {{$user->created_at->format('d-m-Y h : i : s')}} </small></span>
                                            </div>

                                            @if(Cache::has('user-is-online-' . $user->id))
                                                <span class="text-success"><b>Connecté(e)</b> </span>
                                            @else
                                                <span class="text-secondary"><b>Déconnecté(e)</b> </span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3 p-3">
                                        <div class="col-md-10">
                                            <button class="btn btn-secondary btn-sm rounded-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#modifier_{{$user->id}}" aria-controls="modifie" >Modifier</button>
                                            <button class="btn btn-info btn-sm rounded-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#detail_{{$user->id}}" aria-controls="edite" >Détail</button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="/" class="btn btn-primary btn-sm float-right rounded-3">Ouvrir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Modifier --}}
                        <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="modifier_{{$user->id}}" aria-labelledby="offcanvasRightLabel">
                            <div class="mb-1" style="">
                                <div class="offcanvas-header">
                                    <h5 id="offcanvasRightLabel">Modification du personnel {{$user->name}}</h5>
                                    <button type="button" class="btn-close text-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>

                                </div>
                            </div>
                            <div class="offcanvas-body">

                                <div class="offcanvas-body justify-content-center">
                                    <form method="POST" action="{{route('personnels.updates')}}">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="update" value="{{$user->id}}">
                                            <div class="col-md-12 form-group">
                                                <label for="name" class="">Username</label>
                                                <input type="text" class="form-control w-100" name="matricule" value="{{$user->name}}"  required="required">
                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="name" class="">Département</label>
                                                <select required="" name="departement" class="form-control">
                                                    <option value="{{$user->personnel->departement?->id ?? 'Non spécifié'}}" selected disabled>{{$user->personnel->departement->nom ?? 'Selectionner un departement'}}</option>

                                                    @foreach ($departements as $departement)
                                                        <option value="{{$departement?->id ?? 'Non spécifié'}}">{{$departement->nom ?? 'Non spécifié'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{-- <div class="col-md-12 form-group">
                                                <label for="name" class="">Division</label>
                                                <select  name="division" class="form-control" id="" required="">
                                                    <option value="" selected disabled></option>
                                                    @foreach ($divisions_all as $division)
                                                        <option value="{{$division->id ?? 'Non spécifié'}}" >{{$division->denomination ?? 'Non spécifié'}}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                            <div class="col-md-12 form-group">
                                                <label for="name" class="">Fonction</label>
                                                <select  name="fonction" class="form-control" id="" required="">
                                                    <option value="{{$user->fonction->id ?? 'Non spécifié'}}" selected disabled>{{$user->fonction->name ?? 'Non spécifié'}}</option>
                                                    @foreach ($fonctions as $fonction)
                                                        <option value="{{$fonction->id}}">{{$fonction->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-md-12 form-group">
                                                <label for="etat" class="">Etat du compte de l’agent</label>
                                                <select required="required" name="etat" class="form-control" id="">
                                                    <option value="{{$user->personnel->statut->id ?? ''}}" selected disabled>{{$user->personnel->statut->name ?? 'selectionnner'}}</option>
                                                    @foreach ($etats as $etat)
                                                        <option value="{{$etat->id}}">{{$etat->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="modal-footer mt-2">
                                                <button type="button" class="btn btn-primary rounded-3" data-bs-dismiss="offcanvas" aria-label="Close">Annuler</button>
                                                <button type="submit" class="btn btn-secondary rounded-3">Modifier</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>

                    @endforeach

                    <div class="row">
                        <div class="container">
                            <div class="col-md-11">
                                <div class="col-md-1 float-end ">
                                    <span class=" ">
                                        {{-- {!!$users->links()!!} --}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ajout --}}

        <div wire:ignore.self class="offcanvas offcanvas-end" tabindex="-1" id="add" aria-labelledby="offcanvasRightLabel">
            <div class="shadow" style="height: 100%;">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Ajouter un personnel</h5>
                    <button type="button" class="btn-close text-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="card-header row position-relative mt-6 ">
                    <div class="col-md-3"></div>
                    <div class="col-md-4">
                        <div class="avatar avatar-5xl avatar-profile"><img class="rounded-circle img-thumbnail shadow-sm" src="{{asset('assets\img\gallery\user.jpg')}}" width="200" alt="" /></div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>
            <div class="offcanvas-body">
                <div class="">
                    <form method="POST" action="{{route('personnels.store')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-body row">
                            <input type="hidden" name="created" value="{{ Auth::user()->id }}">
                            <div class="col-md-12 form-group">
                                <label for="name" class="">Nom Complet</label>
                                <input type="text" required="required" class="form-control w-100" name="nom"  required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="name" class="">Profile</label>
                                <input type="file" required="required" class="form-control w-100" name="profil">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Département</label>
                                <select required="required" name="departement" class="form-control" id="" required="required">
                                    @foreach ($departements as $departement)
                                        <option value="{{$departement?->id ?? 'Non specifié'}}">{{$departement->nom ?? 'Non specifié'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Division</label>
                                <select required="required" name="division" class="form-control" id="" required="required">
                                    @foreach ($divisions_all as $division)
                                        <option value="{{$division->id ?? 'Non specifié'}}">{{$division->denomination ?? 'Non specifié'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="name" class="">Fonction</label>
                                <select required="required" name="fonction" class="form-control" id="" required="required">
                                    @foreach ($fonctions as $fonction)
                                        <option value="{{$fonction->id}}">{{$fonction->name}}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-6 form-group">
                                <label for="name" class="">Username</label>
                                <input type="text" class="form-control w-100" name="matricule"  required="required">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Sexe</label>
                                <select required="required" name="sexe" class="form-control" id="" required="required">
                                    @foreach ($sexes as $sexe)
                                        <option value="{{$sexe->id}}">{{$sexe->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12 form-group">
                                <label for="name" class="">Télephone</label>
                                <input type="text" class="form-control w-100" name="telephone">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Nationationalité</label>
                                <input type="text" class="form-control w-100" name="nationalite">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Date de naissance</label>
                                <input type="date" class="form-control w-100" name="date_naissance"  required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Lieu de naissance</label>
                                <input type="text" class="form-control w-100" name="lieu_naissance"  required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="name" class="">Etat-civil</label>
                                <select required="required" name="etat" class="form-control" id="">

                                    <option value="celibataire">Célibataire</option>
                                    <option value="marie">Marié(e)</option>

                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="name" class="">Adresse Complet</label>
                                <input type="text" class="form-control w-100" name="adresse">
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="content" class="">Email</label>
                                <input type="text" class="form-control w-100" name="email">
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="content" class="">Mot de passe</label>
                                <input type="text" class="form-control w-100" name="password"  required>
                            </div>

                            <div class="modal-footer mt-2">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas" aria-label="Close">Annuler</button>
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>

                        </div>

                    </form>
                </div>

            </div>
        </div>
@endsection


