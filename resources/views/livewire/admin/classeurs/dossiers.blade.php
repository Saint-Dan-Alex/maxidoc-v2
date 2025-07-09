<div>
    <div class="header bg-blend-lighten pb-6">
        <div class="header-body">
            <div class="row">
                <div class="col-md-9 mb-4">
                    <div class="breadcrumb"><a href="{{route('dige.index')}}"><span>Dashboard</span> </a> <span>> Classeurs </span></div>
                        <h6 class="h2 text-gray d-inline-block mb-0">Les dossier du classeur {{$classeur_name}}</h6>
                    </div>
                    <div class="col-md-3 ">
                        <button class="btn btn-primary rounded-pill w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#adddossier" aria-controls="adddossier">Ajouter un dossier</button>
                    </div>
                </div>
            </div>
            <div class="row">
                @if (count($dossiers) == null )
                    <h1 class="text-center text-gray justify-content-center mt-5">Pas de dossiers <br> pour ce classeur</h1>
                    @include('components.admin.modals.archive.dossiers.dossier-add')
                @else
                    @foreach ($dossiers as $dossier )
                        <div class="col-md-6" id="{{$dossier->name}}">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="float-right text-end">
                                        <a href="" data-bs-toggle="modal" data-bs-target="#supclasseur_{{$dossier->id}}">
                                            <i class="fas fa-times-circle fs-4 text-danger m-3 cursor-pointer"></i>
                                        </a>
                                        <!-- Modal -->
                                            <div wire:ignore.self class="modal fade" id="supclasseur_{{$dossier->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Suppression</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form action="{{route('dossiers.delete')}}" method="post">
                                                            @csrf
                                                            <input type="hidden" value="{{$dossier->id}}" name="id">
                                                            <span class="text-center fw-bold">
                                                                Voulez-vous vraiment supprimer {{$dossier->name ?? ''}}  ?
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

                                    </div>
                                    <div class="col-md-5 ">
                                        <a href="{{route('viewdocument',['document'=>$dossier->id])}}" class="">
                                            <img src="{{asset('assets\img\gallery\dossier-bleu.png')}}" class="img-fluid rounded-start w-100  fit-contain mt-5 mr-3 ml-3 " alt="...">
                                        </a>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body" >
                                            <span ><b>Intitulé</b> </span>
                                            <h5 class="card-title">{{$dossier->name ??''}}</h5>
                                            <span> <b>Réference</b> </span>
                                            <h5 class="card-title">{{$dossier->reference ??''}}</h5>
                                            <div>
                                                <span> Déscription </span>
                                                <div>
                                                    <span class="card-text text-gray"> <b>{{Str::substr($dossier->description,0,21)}}...</b> </span>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="card-text"><small class="text-muted">Créé par : <b>{{$dossier->personnel->nom ??''}}</b> </small></span>
                                            </div>
                                            <div>
                                                <span class="card-text"><small class="text-muted">Date : {{$dossier->created_at->format('d-m-Y')}}</small></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row mb-3 p-3">
                                        <div class="col-md-10">
                                            <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#modifie" aria-controls="modifie" wire:click.prevent="edite({{$dossier->id}})">Modifier</button>
                                            <button class="btn btn-info btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#edite" aria-controls="edite" wire:click.prevent="edite({{$dossier->id}})">Détail</button>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="{{route('viewdocument',['document'=>$dossier->id])}}" class="btn btn-primary btn-sm float-right">Ouvrir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @include('components.admin.modals.archive.dossiers.dossiers')
                        @endforeach

                    @endif
                    <div class="row">
                        <div class="container">
                            <div class="col-md-11">
                                <div class="col-md-1 float-end ">
                                    <span class=" ">
                                        {{-- {!!$dossiers->links()!!} --}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

