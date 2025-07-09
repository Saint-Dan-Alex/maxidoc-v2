<div class="content-scanner">
    <div class="nav-tools">
        <div class="row w-100 ms-0">
            <div class="col-lg-8">
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false" style="font-size: 14px; color: var(--colorTitre)">
                            {{ $selectedDocName }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton1"
                            style="">
                            <li>
                                {{-- wire:click="switchDoc('{{ files($courrier->document?->document)->link }}')" --}}
                                <a class="dropdown-item btn-doc" href="javascript:void(0)"
                                    data-url="{{ files($courrier->document?->document)->link }}"
                                    data-name="{{ files($courrier->document?->document)->name }}"
                                    >
                                    <i class="fi fi-rr-file me-1"></i>
                                    {{ files($courrier->document?->document)->name }} (original)
                                </a>
                            </li>
                            @foreach ($courrier->traitements as $traitement)
                                @if ($traitement->document_url)
                                    <li>
                                        {{-- wire:click="switchDoc('{{ files($traitement->document_url)->link }}')" --}}
                                        <a class="dropdown-item btn-doc" href="javascript:void(0)"
                                        data-url="{{ files($traitement->document_url)->link }}"
                                        data-name="{{ files($traitement->document_url)->name }}"
                                        >
                                            <i class="fi fi-rr-file me-1"></i>
                                            {{ files($traitement->document_url)->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
            {{-- <div class="col-lg-4">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-default" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                        aria-controls="offcanvasRight">Gérer les fichiers</button>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="container-fluid pt-5" wire:ignore>
        <iframe id="viewer" src="{{ files($selectedDoc)->link }}" frameborder="0" class="w-100"></iframe>
    </div>
</div>

@push('livewireScripts')
    <script>

        $('.btn-doc').on('click', function () {
            var url = $(this).data('url');
            var name = $(this).data('name');
            @this.selectedDoc = url;
            @this.selectedDocName = name;
            $('#viewer').prop('src', url);
        });

    </script>
@endpush
