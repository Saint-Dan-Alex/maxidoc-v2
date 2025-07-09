


{{-- modal modifier --}}
<div class=" modal fade " id="modifierModal" tabindex="-1" aria-labelledby="modifierModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="container">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier un personnel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                @livewire('humanres.personnels.update-form',
                    [
                        'directions' => $directions,
                        'fonctions' => $fonctions,
                        'roles' => $roles,
                        'genres' => $genres,
                        'divisions' => $divisions,
                    ])
            </div>
        </div>
    </div>
</div>



{{-- detail --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="detail-personnel" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header" style="flex-direction: column;">
        <div class="d-flex justify-content-between w-100">
            <div class="text-star">
                <h5 id="offcanvasRightLabel" class="mb-1">Détails du personnel </h5>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block" class="me-1">Créé le: </span> 22 Jav 2022</p>
                <p class="mb-1 d-flex" style="font-size: 12px"><span style="display: inline-block" class="me-1">Par: </span> John Doe</p>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>
    <div class="offcanvas-body">
        <div class="block-progress">
            <div class="card card-notification card-campaing">
                <div class="avatar-user">
                    <img src="{{asset('assets/img/team/1.jpg')}}" alt="photo de profil">
                    <span class="etat unactive">Suspendu</span>
                </div>
                <div class="text-star">

                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Nom complet
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Lieu de naissance
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Date de naissance
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Adresse
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Etat civil
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Nationalite
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Téléphone
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Email
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>

            <div class="card card-notification card-campaing">
                <div class="text-star">

                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Fonction
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">20 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Matricule
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Département
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Division
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Etat civil
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Nationalite
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Téléphone
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
                <div class="text-star">
                    <h6 class="date d-flex justify-content-between align-items-center mb-0">
                        Email
                    </h6>
                    <p style="font-size: 12px;" class="mb-0">40 contacts</p>
                </div>
            </div>
        </div>

    </div>
    <div class="offcanvas-footer">
        <div class="d-flex justify-content-end">
            <button class="btn">Modifier</button>
            <button class="btn">Supprimer</button>
        </div>
    </div>

</div>
<!-- Modal suspendre-->
<div class="modal fade" id="suspModal" tabindex="-1" aria-labelledby="suspendreLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-sm modal-dialog-centered modal-white">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suspModalLabel">Suspendre un personnel</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-info">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center text-danger">Voulez-vous suspendre un personnel ?</h1>
            </div>
            <form method="POST" action="{{route('personnels.suspend')}}">
                @csrf
                <input required="required" type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Suspendre</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- Modal supp -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-sm modal-dialog-centered modal-white">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Supprimer un personnel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-info">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center text-danger">Voulez-vous supprimer un personnel ?</h1>
            </div>
            <form  method="POST" action="{{ route('personnels.delete') }}">
                @csrf
                <input required="required" type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </form>

        </div>
    </div>
</div>

 <!-- Modal activer-->
 <div class="modal fade" id="activeModal" tabindex="-1" aria-labelledby="suspendreLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-sm modal-dialog-centered modal-white">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="suspModalLabel">Activer un personnel</h5>
                <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-info">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center text-success">Voulez-vous activer ?</h1>
            </div>
            <form method="POST" action="{{route('personnels.active')}}">
                @csrf
                <input required="required" type="hidden" name="id" id="id">
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Activer</button>
                </div>
            </form>
        </div>
    </div>
</div>

     {{-- view personal --}}
<div class=" modal fade " id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Détails du Personnel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="personnal-info-data">
                    <div class="row mb-4">
                        <div class="col-sm-3">
                            <img id="pd-avatar" src="{{ asset("assets/img/brand/user.jpg") }}" alt="user" class="w-100 picture-detail border-info border-2" />
                        </div>

                        <div class="col-sm-8 coldata">
                            <div class="">
                                <h3 class="">Informations personnelles</h3>
                            </div>
                            <div class="mt-3">
                                <span></i>Etat du compte : <b class="text-green">ACTIF</b></span>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-sm-6"><div><span id="pd-name">Nom : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-postnom">Post-nom : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-prenom">Prénom : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-nationalite">Nationalité : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-etatcivil">État-civil : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-adresse">Adresse : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-email">E-mail : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-sexe">Sexe : <b></b></span></div></div>
                                    <div class="col-sm-6"><div><span id="pd-phone">Téléphone : <b></b></span></div></div>
                                    <div class="col"><div><span id="pd-naissance">Date et lieu de naissance : <b></b></span></div></div>
                                </div>

                                <div class="mt-3 mb-3">
                                    <h2 class="">Informations professionnelles</h2>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><div><span id="pd-matricule">Matricule : <b></b></span></div></div>
                                    <div class="col-md-6"><div><span id="pd-fonction">Fonction : <b></b></span></div></div>
                                    <div class="col-md-6"><div><span id="pd-departement">Département : <b></b></span></div></div>
                                    <div class="col-md-6"><div><span id="pd-division">Division : <b></b></span></div></div>
                                    <div class="col-md-6"><div><span id="pd-niveau">Niveau d'accès : <b></b></span></div></div>
                                    <div class="col-md-6"><div><span id="pd-engagement">Date d'engagement: <b></b></span></div></div>
                                </div>

                                <div class="mt-4">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                    <button id="btn-edit" class="btn btn-info" data-toggle="modal" data-target="#modifierModal" data-dismiss="modal" data-id=""  data-personnel="" ><i class="bi bi-pencil-square pr-2"></i>Modifier ces informations</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
