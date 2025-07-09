@extends('regidoc.layouts.master')

@section('content')
    <div class="container-fluid px-lg-4">
        <a href="javascript:history.back()" class="back">
            <i class="bi bi-chevron-left"></i>
            <div class="tooltip-indicator">
                Retour
            </div>
        </a>
        {{-- <h1 class="mb-1">{{ Str::ucfirst($classeur->titre) }}</h1>
        <p class="mb-1 text-muted text-sm" style="font-size: 14px;">Ref: {{ $classeur->reference }}</p>
        <p class="text-muted" style="font-size: 14px;">Créé le: {{ $classeur->created_at->format('d/m/Y') }}</p> --}}
        <div class="row g-lg-3">
            <div class="">
                <div class="col-lg-12 mb-4">
                    <div class="card card-table position-relative" style="overflow: inherit">
                        <div class="m-0 d-none position-absolute loader-card d-flex justify-content-center"
                            style="z-index: 2; left:5px; right:5px; top:5px; bottom:5px; background-color: rgba(255,255,255,0.95)"
                            wire:loading wire:target="filter, changeFilter, changeDate" wire:loading.class.remove="d-none">
                            <div class="m-auto text-center">
                                <div class="spinner-border " role="status" style="color: var(--primaryColor)">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
            
                        <div class="row align-items-center g-1 g-lg-2">
                            <div class="col-lg-5 col-sm-4">
                                <h4>Classeurs </h4>
                            </div>
                           
                        </div>
                        <hr class="mb-4">
                        <div class="row g-2 g-lg-3"> 
                                <div class="col-lg-4 col-sm-4 col-xxl-3 col-xl-3 col-12">
                                    <div class="col-folder">
                                        <a href=#>
                                            <div class="d-flex align-items-center" wire:ignore> 
                                                    <img src="{{ asset('assets/images/icons/folderAds.png') }}" alt="" class="me-2"> 
                                                <div class="text-star">
                                                    <h6>{{ Str::ucfirst('Courriers') }}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
            
                                <div class="col-lg-4 col-sm-4 col-xxl-3 col-xl-3 col-12">
                                    <div class="col-folder">
                                        <a href=#>
                                            <div class="d-flex align-items-center" wire:ignore> 
                                                    <img src="{{ asset('assets/images/icons/folderAds.png') }}" alt="" class="me-2"> 
                                                <div class="text-star">
                                                    <h6>{{ Str::ucfirst('Tâches') }}</h6>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div> 
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('input[name=confidentiel]').on('change', function() {
                if ($(this).val() == 0) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }

                if ($(this).val() == 1) {
                    $('.password').removeClass('d-none');
                } else {
                    $('.password').addClass('d-none');
                }
            });
        });
    </script>
@endsection
