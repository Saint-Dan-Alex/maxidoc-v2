@extends('regidoc.layouts.master')

@section('content')
    <div class="card card-lg">
        <div class="text-star">
            <h1 class="text-star-title">Fonction</h1>
            <p class="mb-0 text-star-subtitle mb-0">
                Gérer les fonctions
            </p>
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-2 block-top-margin">


        <div class=" mt-2 row g-lg-3">
            <div class="col-lg-12">
                @livewire('systems.fonction')
            </div>
        </div>
    </div>

    @livewire('systems.fonction-add')

    @foreach ($fonctions as $fonction)
        @livewire('systems.fonction-edit', ['fonction' => $fonction])
        </div>
        <div class="modal fade" id="modal-show-fonction-{{ $fonction->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Liste des Employés</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($fonction->agents as $agent)
                            <ul>
                                <li> {{ $agent->prenom . ' ' . $agent->nom }} <strong> {{ $agent->service?->titre }}
                                    </strong>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
