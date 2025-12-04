<div class="name-file">
    <div class="dropdown">
        <button class="btn dropdown-toggle mb-0" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false"
            style="font-size: 12px; white-space: nowrap; color: var(--colorTitre); overflow: hidden; text-overflow: ellipsis; font-weight: 500 !important;">
            {{ $selected }}
        </button>

            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton1" style="">
                @php
                    $showDocumentFirst = $courrier->type_id == 1; // Afficher le document principal en premier pour le type 1
                @endphp

                @if ($showDocumentFirst && $courrier->document?->document)
                    <li class="dropdown-header">Document principal</li>
                    <li>
                        <a class="dropdown-item btn-doc" href="javascript:void(0)"
                            data-url="{{ files($courrier->document->document)->link }}"
                            data-name="{{ files($courrier->document->document)->name }}"
                            wire:click="selectDoc({{ $courrier->document->document }},{{ $courrier->document->id }}, true)">
                            <i class="fi fi-rr-file me-1"></i>
                            {{ files($courrier->document->document)->name }} (original)
                        </a>
                    </li>
                @endif

                {{-- @if($courrier->traitements->count() > 0)
                    <li class="dropdown-header {{ !$showDocumentFirst || !$courrier->document?->document ? '' : 'mt-2' }}">Versions du document</li>
                    @foreach ($courrier->traitements as $traitement)
                        @if ($traitement->document_url)
                            <li>
                                <a class="dropdown-item btn-doc btn-doc-list" href="javascript:void(0)"
                                    data-url="{{ files($traitement->document_url)->link }}"
                                    data-name="{{ files($traitement->document_url)->name }}"
                                    wire:click="selectDoc({{ $traitement->document_url }},{{ $traitement->id }}, false)">
                                    <i class="fi fi-rr-file me-1"></i>
                                    {{ files($traitement->document_url)->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif --}}
                
                @if (!$showDocumentFirst && $courrier->document?->document)
                    <li class="dropdown-header mt-2">Document principal</li>
                    <li>
                        <a class="dropdown-item btn-doc" href="javascript:void(0)"
                            data-url="{{ files($courrier->document->document)->link }}"
                            data-name="{{ files($courrier->document->document)->name }}"
                            wire:click="selectDoc({{ $courrier->document->document }},{{ $courrier->document->id }}, true)">
                            <i class="fi fi-rr-file me-1"></i>
                            {{ files($courrier->document->document)->name }} (original)
                        </a>
                    </li>
                @endif

                @if($piecesJointes->count() > 0)
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-header">Pièces jointes</li>
                    @foreach ($piecesJointes as $pieceJointe)
                        <li>
                            <a class="dropdown-item btn-doc btn-doc-list" href="javascript:void(0)"
                                data-url="{{ $pieceJointe->url }}"
                                data-name="{{ $pieceJointe->nom }}"
                                wire:click="selectDoc({{ json_encode(['id' => $pieceJointe->id]) }}, {{ $pieceJointe->id }}, false, true)">
                                <i class="fi fi-rr-paperclip me-1"></i>
                                {{ $pieceJointe->nom }}
                            </a>
                        </li>
                    @endforeach
                @endif

                @if($tacheDocuments->count() > 0)
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-header">Pièces jointes</li>
                    @foreach ($tacheDocuments as $tacheDoc)
                        @if($tacheDoc->document)
                            <li>
                                <a class="dropdown-item btn-doc btn-doc-list" href="javascript:void(0)"
                                    data-url="{{ files($tacheDoc->document)->link }}"
                                    data-name="{{ files($tacheDoc->document)->name }}"
                                    wire:click="selectDoc({{ $tacheDoc->document }}, {{ $tacheDoc->id }}, false)">
                                    <i class="fi fi-rr-document me-1"></i>
                                    {{ files($tacheDoc->document)->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
    </div>
</div>
