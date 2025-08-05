@extends('layouts.app-settings')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1>Catégories de courrier</h1>
            <p class="text-star-subtitle mb-0">
                Gérer les catégories de courrier pour le classement des documents
            </p>
        </div>
    </div>
    
    <div class="container-fluid px-lg-2 block-top-margin">
        <div class="mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.courrier-category')
            </div>
        </div>
    </div>
@endsection
