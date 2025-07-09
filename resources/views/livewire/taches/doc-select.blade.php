<div class="name-file">
    <div class="dropdown">
        <button class="btn dropdown-toggle mb-0" id="dropdownMenuButton1"
            data-bs-toggle="dropdown" aria-expanded="false"
            style="font-size: 12px; white-space: nowrap; color: var(--colorTitre); overflow: hidden; text-overflow: ellipsis; font-weight: 500 !important;">
            {{ $selected }}
        </button>
        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton1" style="">
            @if ($tache->document?->document)
                <li>
                    <a class="dropdown-item btn-doc" href="javascript:void(0)"
                        data-url="{{ files($tache->documents?->document)->link }}"
                        data-name="{{ files($tache->documents?->document)->name }}"
                        wire:click="selectDoc({{ $tache->documents?->document }},{{ $tache->documents?->id }}, true)">
                        <i class="fi fi-rr-file me-1"></i>
                        {{ files($tache->documents?->document)->name }} (original)
                    </a>
                </li>
            @endif

            @foreach ($tache->documents as $document)
                @if ($document->document)
                    <li>
                        <a class="dropdown-item btn-doc btn-doc-list" href="javascript:void(0)"
                            data-url="{{ files($document->document)->link }}"
                            data-name="{{ files($document->document)->name }}"
                            wire:click="selectDoc({{ $document->document }},{{ $document->id }}, false)">
                            <i class="fi fi-rr-file me-1"></i>
                            {{ files($document->document)->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
