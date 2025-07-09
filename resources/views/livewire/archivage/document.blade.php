<div class="col-lg-12">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <p class="bg-white p-2 rounded">
            Archives/<span style="color: darkgray;">{{ Auth::user()->agent?->direction?->titre }}</span>/
            {{ $dossier->classeur->created_at->format('Y') . '/' . $dossier->classeur->titre . '/' }}
            <span class="text-primary text-capitalize"> {{ $dossier->titre }} </span>
        </p>
        {{-- <a href="@if (count($documents)) {{ route('regidoc.archive-classeurs.archive-dossiers.show', [$documents[0]->dossier->classeur, $documents[0]->dossier]) }} @else {{ back() }} @endif"
            class="back">
            <i class="fi fi-rr-angle-left"></i> Retour
        </a> --}}
        {{-- <div class="col-10 d-flex align-items-center justify-content-end"> --}}

        {{-- <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#modal-new-archive-document">Ajouter</button> --}}
        {{-- </div> --}}
    </div>
    <div class="pb-5 card card-table" style="overflow:inherit">
        <div class="row">
            <div class="col-lg-7">
                <p class="mb-0"><small>Dossier</small></p>
                <h4 class="mb-1">{{ Str::ucfirst($dossier->titre) }}</h4>
            </div>
            <div class="col-lg-5">
                <div class="d-flex align-items-center">
                    <input type="text" class="form-control me-2 input-search-card" placeholder="Recherche"
                        style="border:none;" wire:model='search'>
                    <div class="dropdown">
                        <button class="btn btn-filter" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{-- <i class="fi fi-rr-filter me-2"></i> {{ $filterText }} --}}
                            <svg data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path
                                    d="M24,3c0,.55-.45,1-1,1H1c-.55,0-1-.45-1-1s.45-1,1-1H23c.55,0,1,.45,1,1ZM15,20h-6c-.55,0-1,.45-1,1s.45,1,1,1h6c.55,0,1-.45,1-1s-.45-1-1-1Zm4-9H5c-.55,0-1,.45-1,1s.45,1,1,1h14c.55,0,1-.45,1-1s-.45-1-1-1Z">
                                </path>
                            </svg>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(1)'>Par
                                    défaut</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(2)'>A -
                                    Z</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(3)'>Z -
                                    A</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(4)'>Date
                                    d'ajout</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0)" wire:click='changeFilter(5)'>Date de
                                    modification
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-0 mb-4">
        <div class="row g-3 g-lg-5">
            @forelse ($documents as $document)
                <div class="col-lg-3">
                    <div class="col-folder">
                        @if (Str::startsWith($document->reference, 'DAA/'))
                            @php
                                $url = json_decode($document?->document);
                            @endphp
                        @endif
                        <a
                            href="{{ Str::startsWith($document->reference, 'DAA/') ? route($url->url, ['agent' => $url->agent, 'doc' => $url->doc]) : route('regidoc.archive-documents.show', $document) }}">
                            <div class="d-flex align-items-center">
                                @if (Str::startsWith($document->reference, 'DAA/') == false)
                                    <img src="{{ fileIcon($document?->document) }}" alt=""
                                        class="me-2 img-file">
                                @else
                                    <img src="{{ asset('assets/regidoc/icon.png') }}" alt=""
                                        class="me-2 img-file">
                                @endif
                                <div class="text-star">

                                    <h6 class="text-capitalize">{{ Str::ucfirst($document->titre) }}</h6>
                                    <p>Reférence : {{ Str::ucfirst($document->reference) }}</p>
                                    <p>Ajouté le: {{ $document->created_at->format('d/m/Y h:i') }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center col-12">
                    <p>Aucun document trouvé</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
