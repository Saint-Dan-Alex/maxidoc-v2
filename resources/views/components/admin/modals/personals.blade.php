
<div wire:ignore.self class="modal fade" id="modal-suspend" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
        <div class="modal-body">
            <div class="content-text text-center">
                <i data-feather="power"></i>
                <h5>Are you sure ?</h5>
                <p>This action can't be undone.</p>
            </div>
            <div class="block-btn d-flex justify-content-center mb-3">
                <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                <button class="btn btn-delete">Suspendre</button>
            </div>
        </div>
    </div>
    </div>
</div>

{{-- departement --}}
{{-- <div wire:ignore.self class="modal fade" id="modal-new-departement" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
            <span>Creér un département</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group row g-4">
                <div class="col-lg-12">
                    <input wire:model="name" type="text" class="form-control" placeholder="Dénomination" name="denomination">
                </div>
                <div class="col-lg-12">
                    <input type="text" wire:model="description" class="form-control" placeholder="Déscription" name="decription">
                </div>

                <div class="col-lg-12">
                    <select wire:model="chef_id" class="form-control text-black"  name="chef_id" required>
                        <option value="" selected="true" >Selectionner un chef de la division</option>
                        @foreach ($personnels as $user)
                            <option value="{{ $user->id}}">{{ $user->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-12 text-end">
                    <button class="btn btn-add" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="storeDepartement()">Créer</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div> --}}
{{-- modifier --}}
{{-- <div wire:ignore.self class="modal fade" id="modal-Modifier-departement" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
            <span>Modifier un département</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group row g-4">
                <div class="col-lg-12">
                    <input wire:model="name" type="text" class="form-control" value="{{ $name ?? ''}}" name="denomination">
                </div>
                <div class="col-lg-12">
                    <input type="text" wire:model="description" value="{{ $description ?? '' }}" class="form-control" name="decription">
                </div>

                <div class="col-lg-12">
                    <select wire:model="chef_id" class="form-control text-black"  name="chef_id">
                        <option value="">{{ $nameChef ?? 'Non renseigné'}}</option>
                        @foreach ($personnels as $user)
                            <option value="{{ $user->id}}">{{ $user->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-12 text-end">
                    {{-- <button class="btn btn-add" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="UpdateDepartement({{ $departement?->id ?? ''}})">Modifier</button> -}}
                </div>
            </div>
        </div>
    </div>
    </div>
</div> --}}
{{-- division --}}
{{-- <div wire:ignore.self class="modal fade" id="modal-new-division" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
            <span>Creér une division</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="#" method="#">
                {{-- @csrf -}}

                <div class="form-group row g-4">
                    <div class="col-lg-12">
                        <input wire:model="name" type="text" class="form-control" placeholder="Dénomination" name="denomination" required>
                    </div>
                    <div class="col-lg-12">
                        <input type="text" wire:model="description" class="form-control" placeholder="Déscription" name="decription">
                    </div>
                    <div class="col-lg-12">
                        <select wire:model="departement_id" name="departement_id" id="depart" class="form-control" required>
                            <option value="" selected disabled>Selectionner un département</option>
                            {{-- @foreach ($departements as $depart)
                                <option value="{{ $depart->id }}">{{ $depart->nom }}</option>
                            @endforeach -}}
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <select wire:model="chef_id" class="form-control"  name="chef_id" required>
                            <option value="" selected >Selectionner un chef de la division ( Facutatif)</option>
                            @foreach ($personnels as $user)
                                <option value="{{ $user->id}}">{{ $user->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12 text-end">
                        <button class="btn btn-add"  data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="storeDivision()">Créer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
</div> --}}
{{-- end division --}}
{{-- fonction --}}
{{-- <div  wire:ignore.self class="modal fade" id="modal-new-fonction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div  wire:ignore.self class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
            <span>Creér une Fonction</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group row g-4">
                <div class="col-lg-12">
                    <input wire:model="name" type="text" class="form-control" placeholder="Dénomination" name="denomination">
                </div>
                <div class="col-lg-12">
                    <input type="text" wire:model="description" class="form-control" placeholder="Déscription" name="decription">
                </div>
                <div class="col-lg-12 text-end">
                    <button class="btn btn-add" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="storeFonction()">Créer</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div> --}}
{{-- end fonction --}}
<div wire:ignore.self  class="modal fade" id="modal-new-personnel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div  wire:ignore.self class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
            <span>Créer un Personnel</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="form-group row g-4">
                <div class="col-lg-12">
                    <input wire:model="name" type="text" class="form-control" placeholder="Nom" >
                </div>
                <div class="col-lg-12">
                    <input wire:model="postnom" type="text" class="form-control" placeholder="Post-nom" >
                </div>
                <div class="col-lg-12">
                    <input wire:model="prenom" type="text" class="form-control" placeholder="Prenom" >
                </div>
                <div class="col-lg-12">
                    <input wire:model="email" type="email" class="form-control" placeholder="E-mail" >
                </div>
                <div class="col-lg-12">
                    <input wire:model="matricule" type="text" class="form-control" placeholder="matricule" >
                </div>
                <div class="col-lg-12">
                    <input wire:model="nationalite" type="text" class="form-control" placeholder="nationalité" >
                </div>
                <div class="col-lg-12">
                    <select wire:model="etat_civil"   class="form-control">
                        <option value=""  >Sélectionnez</option>
                        <option value="1" >Marie(e)</option>
                        <option value="2" >Célibateur</option>
                    </select>
                </div>
                <div class="col-lg-12">
                    <select wire:model="sexe" name="sexe"  class="form-control">
                        <option value="" selected >Sélectionnez</option>
                        <option value="1" >Masculin</option>
                        <option value="2" >Feminin</option>
                    </select>
                </div>

                <div class="col-lg-12">
                    <select wire:model="departement_id" name="departement_id" id="depart" class="form-control">
                        <option value="" selected >Sélectionnez</option>
                        {{-- @foreach ($departements as $depart)
                            <option value="{{ $depart->id }}" > <a href="/" wire:click.prevent ="division({{ $depart->id }})">{{ $depart->nom }}</a> </option>
                        @endforeach --}}
                    </select>
                </div>
                
                <div class="col-lg-12">
                    <select wire:model="fonction" name="fonction" id="depart" class="form-control">
                        <option value="" selected >Sélectionnez</option>
                        @foreach ($fonctions as $fonction)
                            <option value="{{ $fonction->id }}">{{ $fonction->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-12 text-end">
                    <button class="btn btn-add" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent="storePersonnel()">Créer</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
{{-- modal --}}
{{-- <div wire:ignore.self class="modal fade" id="modal-delete-pers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
        <div class="modal-body">
            {{-- <form action="{{  }}" method="post"> -}}
                <div class="content-text text-center">
                    <i data-feather="trash"></i>
                    <h5>Are you sure ? </h5>
                    <p>This action can't be undone.</p>
                </div>
                <div class="block-btn d-flex justify-content-center mb-3">
                    <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent ="empty()">Annuler</button>
                    <button class="btn btn-delete" data-bs-dismiss="modal" aria-label="Close" wire:click.prevent ="update">Supprimer</button>
                </div>
            {{-- </form> -}}
        </div>
    </div>
    </div>
</div> --}}
