@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Historiques des sessions</h1>
            <p class="mb-0">
                Voir les informations des sessions
            </p>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-2 block-top-margin">


        <div class="mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.log-session')
            </div>
        </div>
    </div>
@endsection
