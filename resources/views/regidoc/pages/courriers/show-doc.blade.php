@extends('regidoc.layouts.layout-doc')

@section('style')
    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 150px;
        }

        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>
@endsection

@section('content')
    <div class="block-scanner"> 

        @livewire('courrier.show-courrier-data', ['courrier' => $find_document])
        @livewire('courrier.gestion-document', ['courrier' => $find_document])

    </div>

    @livewire('taches.add-courrier-tache-modal', ['courrier' => $find_document])

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Gestion de fichier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <h6 class="mb-4">Ajout des fichiers</h6>
            <div class="row g-2">
                <div class="col-12">
                    <div class="block-file block-import-doc">
                        <label for="file-select" data-bs-toggle="modal" data-bs-target="#modal-select-document">
                            <i class="fi fi-rr-clip"></i>
                            <p> Cliquez pour ici joindre un fichier</p>
                            <i class="bi bi-plus-lg"></i>
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle w-100" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="true" style="font-size: 14px;">
                            Répondre au document
                        </button>
                        <ul class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownMenuButton1"
                            data-popper-placement="bottom-end">
                            <li>
                                <a class="dropdown-item" href="#">
                                    Accusé de réception
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Prendre en charge
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas-footer">
            <div class="d-flex justify-content-end">
                <button class="btn btn-add">Valider</button>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHisto" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Activités sur le document</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="block-activity">
                @php
                    $historiques = $find_document?->document?->revisionHistory ?? collect();
                    $historiques->push($find_document->revisionHistory);
                    $historiques->push($find_document->history);
                    $historiques->push($find_document?->document?->history);
                    $historiques = $historiques->flatten();
                    $historiques = $historiques->reject(function ($historique) {
                        return $historique == null;
                    });
                    $historiques = $historiques->sortBy('created_at')->reverse();
                @endphp
                @foreach($historiques ?? [] as $history)
                    @if ($history instanceOf (new \Venturecraft\Revisionable\Revision))
                        @if($history->key == 'created_at' && !$history->old_value)
                            @if ($history->revisionable_type == 'App\Models\Courrier')
                                <div class="items-activity">
                                    <div class="avatar-activ">
                                        <img src="{{ imageOrDefault($history->userResponsible()->agent->image) }}" alt="">
                                    </div>
                                    <p class="agent">
                                        <span>{{ $history->userResponsible()->agent->prenom.' '.$history->userResponsible()->agent->nom }}</span>
                                        - {{ $history->userResponsible()->agent->service?->titre }}
                                    </p>
                                    <p>Création de ce courrier</p>
                                    <div class="date">{{ $history->newValue() }}</div>
                                </div>
                            @elseif ($history->revisionable_type == 'App\Models\Document')
                                <div class="items-activity">
                                    <div class="avatar-activ">
                                        <img src="{{ imageOrDefault($history->userResponsible()->agent->image) }}" alt="">
                                    </div>
                                    <p class="agent">
                                        <span>{{ $history->userResponsible()->agent->prenom.' '.$history->userResponsible()->agent->nom }}</span>
                                        - {{ $history->userResponsible()->agent->service?->titre }}
                                    </p>
                                    <p>Numérisation des documents du courrier</p>
                                    <div class="date">{{ $history->newValue() }}</div>
                                </div>
                            @endif
                        @else
                            @if ($history->revisionable_type == 'App\Models\Courrier')
                                <div class="items-activity">
                                    <div class="avatar-activ">
                                        <img src="{{ imageOrDefault($history->userResponsible()->agent->image) }}" alt="">
                                    </div>
                                    <p class="agent">
                                        <span>{{ $history->userResponsible()->agent->prenom.' '.$history->userResponsible()->agent->nom }}</span>
                                        - {{ $history->userResponsible()->agent->service?->titre }}
                                    </p>
                                    <p>
                                        A apporté des modifications sur {{ $history->fieldName() }} de ce courrier
                                    </p>
                                    <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}</div>
                                </div>
                            @elseif ($history->revisionable_type == 'App\Models\Document')
                                <div class="items-activity">
                                    <div class="avatar-activ">
                                        <img src="{{ imageOrDefault($history->userResponsible()->agent->image) }}" alt="">
                                    </div>
                                    <p class="agent">
                                        <span>{{ $history->userResponsible()->agent->prenom.' '.$history->userResponsible()->agent->nom }}</span>
                                        - {{ $history->userResponsible()->agent->service?->titre }}
                                    </p>
                                    <p>
                                        A apporté des modifications sur {{ $history->fieldName() }} du document de ce courrier
                                    </p>
                                    <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}</div>
                                </div>
                            @endif
                        @endif
                    @else
                        <div class="items-activity">
                            <div class="avatar-activ">
                                <img src="{{ imageOrDefault($history->userResponsible->agent->image) }}" alt="">
                            </div>
                            <p class="agent">
                                <span>{{ $history->userResponsible->agent->prenom.' '.$history->userResponsible->agent->nom }}</span>
                                - {{ $history->userResponsible->agent->service?->titre }}
                            </p>
                            <p>{{ $history->description }}</p>
                            <div class="date">
                                {{ $history->created_at->format('d/m/Y H:i:s') }}
                            </div>
                        </div>
                    @endif
                @endforeach

                {{-- <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div>
                <div class="items-activity">
                    <p class="agent"><span>#John Doe</span> - Service informatique</p>
                    <p>a apporté des modifications sur ce fichier</p>
                    <div class="date">Il y 3min</div>
                </div> --}}

            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComment" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Annotations</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="all-comments" style="overflow: hidden; height: auto!important;">
                <div class="block-scroll" id="tache-commentaires">
                    @php
                        $comments = $find_document->traitements;
                    @endphp
                    @forelse ($comments as $comment)
                        <div class="block-comment commentaires">
                            <div class="block-info-comment d-flex">
                                <div class="avatar-comment commentaires">
                                    <img src="{{ imageOrDefault($comment->agent->image) }}"
                                        alt="Photo profil">
                                </div>
                                <div class="name-comment commentaires">
                                    <h6 class="mb-0">
                                        {{ $comment->agent->prenom.' '.$comment->agent->nom }}
                                        <span> - {{ $comment->agent->direction->titre }}</span>
                                    </h6>
                                    <p>{{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="comment commentaires mt-2">
                                {!! $comment->note !!}
                            </div>
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-new-archive" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Archiver</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">
                        <form action="{{ route('regidoc.documents.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="from_archive" id="" value="true">
                            <input type="hidden" name="old_file" id="" value="{{ $find_document->file }}">
                            <div class="">
                                <div>
                                    <div class="my-3 col-lg-12">
                                        <input type="hidden" class="form-control" placeholder="Denomination"
                                            name="titre" value="{{ $find_document->title }}">
                                    </div>
                                </div>
                                <div>
                                    <div class="my-3 col-lg-12">
                                        <input type="hidden" class="form-control" placeholder="Réference"
                                            name="reference" value="{{ $find_document->reference }}">
                                    </div>
                                </div>
                                <div class="my-3 col-lg-12">
                                    <label for="">Classeur</label>
                                    <select name="classeur" id="" class="form-control" required>
                                        <option value="" selected>Sélectionnez</option>
                                        @foreach ($classeurs as $classeur)
                                            <option value="{{ $classeur->id }}">{{ $classeur->titre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <div class="my-3 col-lg-12">
                                        <label for="">Dossier</label>
                                        <select name="dossier_id" id="" class="form-control">
                                            <option value="" selected>Sélectionner un dossier</option>
                                            @foreach ($dossiers as $dossier)
                                                <option value="{{ $dossier->id }}">{{ $dossier->titre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add" type="submit" data-bs-dismiss="modal"
                                    aria-label="Close">Archiver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-signature" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Signer</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">Dessiner</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab"
                                aria-controls="pills-profile" aria-selected="false">Image</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab" tabindex="0">
                            <canvas id="canvas"></canvas>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab" tabindex="0">
                            <div class="block-up-img w-100" style="height: 150px;">
                                <input type="file" id="file-img" accept=".jpg,.png" name="image">
                                <label for="file-img" class="dashed mb-0" id="label-5">
                                    <svg viewBox="0 0 801.19 537.98">
                                        <g id="Calque_2" data-name="Calque 2">
                                            <g id="Calque_1-2" data-name="Calque 1">
                                                <path
                                                    d="M754.28,264.59A159.67,159.67,0,0,0,648.9,217.87c.58-.77,1.13-1.55,1.68-2.34A76.4,76.4,0,0,0,531.91,120,195.87,195.87,0,0,0,351.32,0C256.06,0,176.7,68,159.12,158.11,68.79,173.41,0,252,0,346.7,0,452.34,85.64,538,191.28,538c1.43,0,2.85,0,4.27-.05s2.82.05,4.24.05H642.14A161.47,161.47,0,0,0,796.75,415.41c.12-.47.23-.94.34-1.41a160.45,160.45,0,0,0-42.81-149.41ZM499.56,296.45c-5.09,11.64-15.11,15.75-27.19,15.78-13.62,0-27.23.24-40.84-.06-6.1-.14-8.07,2.22-8,8.13.27,16.07.1,32.13.1,51.47-.93,15.74,1.62,34.84-1.34,53.79-3.89,25-25.87,43.75-50.7,43.4a51.73,51.73,0,0,1-50.17-43.18c-1.85-10.85-1.11-21.72-1.19-32.58-.16-23.69-.35-47.38.12-71.06.16-8-2.58-10.36-10.31-10-12.77.54-25.58.22-38.37.11-11.93-.1-22.14-3.65-27.34-15.48-5.4-12.28-.77-22.17,8-30.91q49.93-49.95,100-99.87c12.27-12.17,26.86-12.3,39-.23q50.48,50,100.53,100.44C500.41,274.72,504.71,284.65,499.56,296.45Z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    <p>
                                        Cliquez pour téléverser la photo
                                    </p>
                                </label>
                                <div class="img d-none" id="img_block"
                                    style="position: absolute; top: 50%; left:50%; width: 98%; height: 98%; background:#fff;border-radius: 12px; z-index: 1; pointer-events: none; transform: translate(-50%, -50%);">
                                    <img src="" alt="" id="sign-img" class="d-block m-auto"
                                        style="width: 80%; height: 100%; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="modal-dossier" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header ">

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">

                        <form action="{{ route('regidoc.documents.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row g-3">
                                <div class="col-12 text-center">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                        <span>Selection du dossier</span>
                                    </h5>
                                    <p class="mb-0">Selectionnez le dossier dans lequel</p>
                                </div>
                                <div class="col-12">
                                    <select name="" id="" class="select2">
                                        <option value="0">Sectionnez un dossier</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 text-end mb-4">
                                    <button class="btn btn-add w-100 mt-0" type="submit">Validerr</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    @can('Signer un courrier')
        <a href="{{ route('regidoc.courriers.signer', $find_document->id) }}" class="btn btn-primary btn-float-single" style="position: fixed; z-index: 999;">Signer ce document</a>
    @endcan
@endsection
@section('javascript')
    <script>
        const input = document.getElementById('file-img');
        const img = document.getElementById('sign-img');
        const img_block = document.getElementById('img_block');
        // const loader = document.getElementById('avatar-loader');

        input.addEventListener('change', () => {
            const file = input.files[0];
            const reader = new FileReader();

            // reader.addEventListener('loadstart', () => {
            //     loader.classList.remove('d-none');
            // });

            reader.addEventListener('load', () => {
                img.src = reader.result;
                img_block.classList.remove('d-none');
            });

            reader.readAsDataURL(file);
        });
        document.addEventListener('livewire:load', () => {
            Livewire.onPageExpired((response, message) => location.reload())
        })
    </script>
@endsection
