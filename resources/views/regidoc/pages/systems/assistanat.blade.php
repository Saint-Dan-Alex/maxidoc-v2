@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1>assistant</h1>
            <p class="text-star-subtitle mb-0">
                Gérer les secretaires des directions
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
                @livewire('systems.assistanat')
            </div>
        </div>
    </div>
@endsection
