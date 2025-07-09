@extends('layouts.app')

{{-- @section('search')
    @livewire('search-dossier',['classer_id'=>$classer_id])
@endsection --}}
@section('content')
    <!-- Topnav -->
    @if(Session::has('success'))

        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
 
    @endif
    <div>
        <div class="pb-6 header bg-blend-lighten">
            <div class="">
                <div class="header-body">
                    <div class="row">
                        <div class="mb-4 col-md-10">

                            <div class="breadcrumb"><a href="/"><span>Dashboard</span> </a> <span>> Classeurs </span></div>
                            <h6 class="mb-0 h2 text-gray d-inline-block">Les dossiers </h6>
                        </div>
                        <div class="col-md-2">
                            <button class="ml-5 btn rounded-3 btn-primary btn-sm w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#adddossierall" aria-controls="adddossierall">Ajouter</button>

                        </div>
                    </div>

                </div>
                <div class="row">

                    @if (count($dossiers) == null )
                        <h1 class="mt-5 text-center text-gray justify-content-center">Pas de dossiers <br> pour cet dossier</h1>
                        @include('components.archives.new-dossier')
                    @else
                        @foreach ($dossiers as $dossier )

                            <div class="col-md-6" id="{{$dossier->name}}">
                                <div class="mb-3 card" style="max-width: 540px;">
                                    <div class="row g-0">
                                        <div class="float-right text-end">
                                            <a href="" data-bs-toggle="modal" data-bs-target="#supclasseur_{{$dossier->id}}">
                                                <i class="m-3 cursor-pointer fas fa-times-circle fs-4 text-danger"></i>
                                            </a>
                                            <!-- Modal -->
                                                <div wire:ignore.self class="modal fade" id="supclasseur_{{$dossier->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Suppression</h5>
                                                                <button type="button" class="btn rounded-3-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <form action="{{route('dossiers.delete')}}" method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{$dossier->id}}" name="id">
                                                                <span class="text-center fw-bold d-block">
                                                                    Voulez-vous vraiment supprimer {{$dossier->name ?? ''}}  ? <br>
                                                                    en le supprimant vous allez aussi supprimer les documents qui en fait partie.
                                                                </span>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn rounded-3 btn-primary btn-sm" data-dismiss="modal" aria-label="Close">Annuler</button>
                                                                    <button type="submit" class="btn rounded-3 btn-danger btn-sm">Supprimer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            {{-- end modal --}}
                                        </div>
                                        <div class="col-md-5 ">
                                            <a href="" class="">
                                                <img src="{{asset('assets\img\gallery\dossier-bleu.png')}}" class="mt-5 mr-3 img-fluid rounded-start w-100 fit-contain " alt="...">
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
                                        <div class="p-3 mb-3 row">

                                            <div class="col-md-10">
                                                <button class="btn rounded-3 btn-secondary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#modifie_{{$dossier->id}}" aria-controls="modifie">Modifier</button>

                                                <button class="btn rounded-3 btn-info btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#edite_{{$dossier->id}}" aria-controls="edite">Détail</button>

                                            </div>
                                            <div class="col-md-2">

                                                <a href="{{route('viewdocument',['document'=>$dossier->id])}}" class="float-right btn rounded-3 btn-primary btn-sm">Ouvrir</a>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            @include('components.archives.dossiersall')
                        @endforeach
                    @endif
                    <div class="row">
                        <div class="container-fluid">
                            <div class="col-md-12">
                                <div class="col-md-1 float-end ">
                                    <span class="">
                                        {!!$dossiers->links()!!}
                                    </span>
                                </div>
                            </div>
                       </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
