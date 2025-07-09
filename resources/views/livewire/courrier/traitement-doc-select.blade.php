<div class="name-file">
    <div class="dropdown">
        <button class="btn dropdown-toggle mb-0" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false"
            style="font-size: 12px; white-space: nowrap; color: var(--colorTitre); overflow: hidden; text-overflow: ellipsis; font-weight: 500 !important;">
            {{ $selected }}
        </button>

        @if($courrier->type_id == 1)
            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton1" style="">
                @if ($courrier->document?->document)
                    <li>
                        <a class="dropdown-item btn-doc" href="javascript:void(0)"
                            data-url="{{ files($courrier->document?->document)->link }}"
                            data-name="{{ files($courrier->document?->document)->name }}"
                            wire:click="selectDoc({{ $courrier->document?->document }},{{ $courrier->document?->id }}, true)">
                            <i class="fi fi-rr-file me-1"></i>
                            {{ files($courrier->document?->document)->name }} (original)
                        </a>
                    </li>
                @endif

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
            </ul>
        @elseif ($courrier->type_id == 2)
            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton1" style="">
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
                @if ($courrier->document?->document)
                    <li>
                        <a class="dropdown-item btn-doc" href="javascript:void(0)"
                            data-url="{{ files($courrier->document?->document)->link }}"
                            data-name="{{ files($courrier->document?->document)->name }}"
                            wire:click="selectDoc({{ $courrier->document?->document }},{{ $courrier->document?->id }}, true)">
                            <i class="fi fi-rr-file me-1"></i>
                            {{ files($courrier->document?->document)->name }} (original)
                        </a>
                    </li>
                @endif
            </ul>
        @endif
    </div>
</div>
