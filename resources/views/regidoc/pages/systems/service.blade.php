@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Service</h1>
            <p class="text-star-subtitle mb-0">
                Gérer les services
            </p>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-2 block-top-margin">


        <div class="mt-3 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.service')
            </div>
        </div>
    </div>
@endsection
