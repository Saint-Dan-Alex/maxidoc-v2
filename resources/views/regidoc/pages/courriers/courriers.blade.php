@extends('regidoc.layouts.master')

@section('content')
    @include('regidoc.layouts.partials.loader')
    <div class="card card-lg" wire:loading.remove>
        <div class="d-flex align-items-center text-star">
            {{-- <a href="{{ route('regidoc.home') }}" class="back mb-0">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a> --}}
            <h1 class="mb-3">Boîte de réception</h1>

            {{-- <p class="mb-0">
                Vous avez {{ $files->where('type_id', 2)->count() }} courriers envoyés,
                {{ $files->where('type_id', 1)->count() }} Courriers réçus
            </p> --}}
        </div>
        {{-- 
        <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div>
        --}}
    </div>
    <div class="container-fluid px-lg-2">
        {{-- , ['courriers' => $files] --}}
        {{-- @livewire('courrier.index-courrier') --}}
        @livewire('courrier.des-courriers')
    </div>

    <div class="modal fade" id="modal-delete-contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="trash"></i>
                        <h5>Etes-vous sûr ?</h5>
                        <p>Cette action est irreversible</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                        <button class="btn btn-delete">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
