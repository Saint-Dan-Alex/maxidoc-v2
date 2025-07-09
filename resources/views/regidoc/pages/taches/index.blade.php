@extends('regidoc.layouts.master')

@section('styles')
    <style>
        .icon.avatar {
            width: 34px;
            height: 34px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--whiteColor);
            border-radius: 100%;
            font-size: 14px;
            margin-right: 10px;
            overflow: hidden;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            cursor: default;
            padding-left: 0px;
            padding-right: 0px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            display: block
        }

        .content .card-table .block-taks.task::before {
            display: none;
        }

        .content .card-table .block-taks .dropdown-menu {
            left: auto !important;
            right: 0 !important;
            transform: none !important;
        }
    </style>
@endsection

@section('content')
    <div class="card card-lg">
        <div class="d-flex align-items-center text-star">
            {{-- <a href="{{ route('regidoc.home') }}" class="back mb-0">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a> --}}
            <h1 class="mb-0 ">Gestion de tâches</h1>
            {{-- <a href="{{ route('regidoc.taches.create') }}" class="btn btn-add btn-add-hover ms-auto "
                    style="flex: 0 0 auto; transform: none!important">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus d-flex d-sm-none d-lg-none">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Créer une tâche</span>
                </a> --}}
            {{-- <p>
                {{ Auth::user()->name . ', ' }}vous avez
                @if (Auth::user()->agent->isDG())
                    {{ $num }} {{ $num > 0 ? 'taches créées' : 'tache créée' }}
                @else
                    {{ $num }} {{ $num > 0 ? 'taches assignées' : 'tache assignée' }}
                @endif
            </p> --}}
        </div>
        {{-- <div class="block-circle">
            <div class="circle-white"></div>
            <div class="circle-white"></div>
            <div class="circle-white"></div>
        </div> --}}
    </div>
    <div class="container-fluid px-lg-2 mt-3">
        {{--  @livewire('taches.index-tache') --}}
        @livewire('taches.des-taches')
    </div>
    @livewireScripts

    @foreach ($taches as $key => $tache)
        {{-- <div class="offcanvas offcanvas-end offcanvas-task" tabindex="-1" id="detail-task-{{ $tache->id }}" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header align-items-center" style=";border: none; padding-left:35px;padding-right: 35px;">
                <div class="d-flex gap-2 w-100 align-items-center">
                    @if (Auth::user()->agent->isDG() || Auth::id() == $tache->user_id)
                        @if ($tache->tache_statut_id == 3)
                            <small class="badge-task normal">Tâche terminée</small>
                        @else
                            @if ($tache->documents->count())
                                @if (!(Auth::user()->agent->isSecretaire() && $tache->isForDirection()))
                                    <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn text-white" style="background: var(--primaryColor)">
                                        Voir
                                    </a>
                                @endif
                            @endif
                        @endif
                        @if ($tache->tache_statut_id == 3)
                            <a href="{{ route('regidoc.taches.remettreEncours', $tache->id) }}" class="btn">Relancer la tâche</a>
                        @else
                            <a href="{{ route('regidoc.taches.finish', $tache->id) }}" class="btn">Marquer comme terminée</a>
                        @endif
                    @else
                        @if ($tache->tache_statut_id == 3)
                            <small class="badge-task normal">Tâche terminée</small>
                        @else
                            @if ($tache->documents)
                                @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                                @else
                                    <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn">
                                        Traiter
                                    </a>
                                @endif
                            @endif
                        @endif

                        @if ($tache->parent_id == null && $tache->tache_statut_id != 3)
                            @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                            @else
                                <a href="{{ route('regidoc.taches.create', ['parent_id' => $tache->id]) }}" class="btn">
                                    Créer une sous-tâche
                                </a>
                            @endif
                        @endif
                    @endif
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                    style="transform: scale(.8)">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            <div class="offcanvas-body">
                <div class="pt-0 block-detail-task">
                    <div class="d-flex w-100 align-items-baseline">
                        <h4 class="mb-0 pe-3 title-task" style="word-break: break-all">{{ $tache->titre }}</h4>
                        <div class="d-flex align-items-center ms-auto" style="flex: 0 0 auto">
                            <div
                                class="badge-task @if ($tache->priorite_id == 1) normal @elseif($tache->priorite_id == 2) urgent @else absolu @endif">
                                {{ $tache->priorite?->titre }}
                            </div>
                            @if ($tache->user_id == Auth::id())
                                <div class="dropdown">
                                    <button class="px-0 btn btn-end ms-2" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fi fi-rr-menu-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="">
                                        <li><a class="dropdown-item"
                                                href="{{ route('regidoc.taches.edit', $tache->id) }}">Modifier</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modal-add-objectifs-{{ $tache->id }}">Ajouter un
                                                objectif</a></li>
                                        <li>
                                            <a class="dropdown-item delete" href="#" data-bs-toggle="modal"
                                                data-bs-target="#modal-add-objectifs-{{ $tache->id }}"
                                                data-id="{{ $tache->id }}">Supprimer</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    @livewire('taches.tache-info', ['tache' => $tache], key($tache->id))
                     <hr>
                    @livewire('taches.tache-pane', ['tache' => $tache], key($tache->id))

                </div>
            </div>
        </div> --}}

        @livewire('taches.add-tache-participant-modal', ['tache' => $tache], key($tache->id))

        @foreach ($tache->objectifs as $objectif)
            @livewire('taches.edit-tache-participant-modal', ['objectif' => $objectif], key($objectif->id))
        @endforeach
    @endforeach

    <div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="power"></i>
                        <h5>Suppression</h5>
                        <p>Souhaitez-vous supprimer cette tâche ?</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-between w-100">
                        <button class="btn btn-cancel" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                        <form method="POST" action="#" class="p-0" id="delete_form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete">
                                Supprimer
                            </button>
                            {{-- <button class="btn btn-add">
                                    Annuler
                                </button> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // $('#form-message').submit(function(event) {
        // event.preventDefault();

        // var elements = $('.form-block');

        // console.log($(elements).find('input').serialize());

        // $('#modal-load').modal('show');

        // for (let i = 0; i < elements.length; i++) {
        //     const element = elements[i];
        //     data = $(element).find('select, input').serialize();
        //     // console.log(elements.length + 1);
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     })
        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: "post",
        //         data: data,
        //         success: function(data) {
        //             console.log(data);
        //             $('#modal-load').modal('hide');
        //             $('#modal_add_vente').modal('hide');
        //             $('#modal_add_vente').on('hidden.bs.modal', function() {
        //                 location.reload();
        //             })
        //         },
        //         error: function(error) {
        //             $('#modal-load').modal('hide');
        //             console.log(error);
        //         }
        //     });
        // }
        // });

        $('.delete').on('click', function(e) {
            $('#delete_form')[0].action = '{{ route('regidoc.taches.destroy', '__id') }}'.replace('__id', $(this)
                .data('id'));
            $('#modal-delete').modal('show');
        });


        $(document).ready(function() {

            $('.check-cible').on('click', function(event) {
                cible = $(this).data('cible');

                if ($(this).prop("checked")) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: '/gestion-taches/tache/cible/check',
                        type: "post",
                        data: cible,
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    $.ajax({
                        url: '/gestion-taches/tache/cible/uncheck',
                        type: "post",
                        data: cible,
                        success: function(data) {
                            console.log(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });

            $('#form-messagddde').submit(function(event) {
                event.preventDefault();

                var elements = $('.input-form-comment');
                var data = $(elements).find('input').serialize();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    url: $(this).attr('action'),
                    type: "post",
                    data: data,
                    success: function(data) {
                        $('#comment-text').val('');

                        // $('#tache-commentaires').empty();

                        // const comments = document.getElementById('tache-commentaires');
                        // comments.innerHTML = "";

                        // for(let i = 0; i < data.length; i++) {
                        //     comments.innerHTML += `
                    //     <div class="block-comment {{-- $commentaire->user_id==Auth::user()->id?'block-comment-me':'' --}} commentaires">
                    //         <div class="block-info-comment d-flex">
                    //             <div class="avatar-comment commentaires">
                    //                 <img src="{{-- asset('assets/images/profils/'.$commentaire->user->avatar) --}}" alt="Photo profil">
                    //             </div>
                    //             <div class="name-comment commentaires">
                    //                 <h6>{{-- $commentaire->user->prenom.''.$commentaire->user->nom --}}
                    //                 </h6>
                    //                 <p>{{-- $commentaire->created_at->diffForHumans() --}}</p>
                    //             </div>
                    //         </div>
                    //         <div class="comment commentaires">
                    //             <p>{{-- $commentaire->message --}}</p>
                    //         </div>
                    //     </div>
                    //     `;

                        //     // console.log(data[i]['message']);

                        //     // comments.innerHTML += `<div>${data[i]['message']}</div>`;
                        // }
                        console.log(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $('#comment-form').submit(function(event) {
                event.preventDefault();
                // const token = document.querySelector('meta[name="csrf-token"]').content;
                const url = this.getAttribute('action');

                var elements = $('#comment-form');
                var value = $(elements).find('input').serialize();

                /* const value = document.getElementById('value').value;
                // fetch(url, {
                //     headers : {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     },
                //     method : "post",
                //     body : JSON.stringtify({
                //         value: value
                //     })
                // }).then(response => {
                //     response.json().then(data => {
                //         console.log(data)
                //     })
                // }).catch(error => {
                //     console.log(error)
                // });*/

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    url: $(this).attr('action'),
                    type: "get",
                    data: value,
                    success: function(data) {
                        const comments = document.getElementById('posts');
                        comments.innerHTML = '';

                        for (let i = 0; i < data.length; i++) {
                            console.log(data[i]['message']);

                            comments.innerHTML = `<div>${data[i]['message']}</div>`;
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });

                // console.log(value);

            });

        });
    </script>
@endsection
