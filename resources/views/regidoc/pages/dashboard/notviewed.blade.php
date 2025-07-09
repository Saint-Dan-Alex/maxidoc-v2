@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="d-flex align-items-center text-star" wire:loading.remove>
            <a href="{{ route('regidoc.home') }}" class="back mb-0">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h1 class="mb-0 ms-2">Nouveaux courriers</h1>
            <a href='{{ route('regidoc.courriers.create') }}' class="btn btn-add btn-add-hover ms-auto"
                    style="flex: 0 0 auto;">
                    Numériser un courrier
                </a>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-2 mt-3">
        @livewire('dashboard.repertoire.not-viewed')
    </div>

    <div class="modal fade" id="modal-delete-contact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="trash"></i>
                        <h5>Voulez-vous supprimer ce contact ?</h5>
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
