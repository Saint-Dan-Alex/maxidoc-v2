<div class="name-file">
    <div class="dropdown">
        <button class="btn dropdown-toggle mb-0" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"
            style="font-size: 12px; white-space: nowrap; color: var(--colorTitre); overflow: hidden; text-overflow: ellipsis; font-weight: 500 !important;">
            {{ $selected }}
        </button>
        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton1" style="">
            @foreach ($tache->documents as $document)
                <li>
                    <a class="dropdown-item btn-doc btn-doc-list" href="javascript:void(0)"
                        data-url="{{ files($document->document)->link }}"
                        data-name="{{ files($document->document)->name }}"
                        wire:click="selectDoc({{ $document->document }})">
                        <i class="fi fi-rr-file me-1"></i>
                        {{ files($document->document)->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
