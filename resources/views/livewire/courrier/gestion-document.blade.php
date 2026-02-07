<style>
    #pdf-main-container {
        padding-left: 0 !important;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: var(--bgContent, #f8f9fa);
        width: 100%;
        position: relative;
    }

    #pdf-contents {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px 0;
        overflow-y: auto;
    }

    .pdf-canvas {
        box-sizing: border-box;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        max-width: 100%;
        height: auto !important;
        display: block;
        margin: 0 auto;
    }

    .pdf-page {
        position: relative;
        margin-bottom: 25px;
        display: flex;
        justify-content: center;
        width: fit-content;
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .pdf-tools-modified {
        display: flex !important;
        width: fit-content !important;
        min-width: unset !important;
        margin: 10px auto !important;
        padding: 5px 20px !important;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(0,0,0,0.1) !important;
        position: sticky !important;
        top: 10px !important;
        z-index: 1000;
        justify-content: center !important;
        gap: 20px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }

    .pdf-tools-modified #toolbarViewerLeft,
    .pdf-tools-modified #toolbarViewerMiddle,
    .pdf-tools-modified #toolbarViewerRight {
        min-width: unset !important;
        width: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        gap: 10px !important;
    }

    .pdf-tools-modified #toolbarViewerLeft::after,
    .pdf-tools-modified #toolbarViewerMiddle::after {
        display: none !important;
    }

    .text-layer {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        opacity: 0.2;
        line-height: 1.0;
        margin: auto;
        width: 100%;
        height: 100%;
    }

    .text-layer > div {
        color: transparent;
        position: absolute;
        white-space: pre;
        cursor: text;
        transform-origin: 0% 0%;
    }
</style>
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
        <div id="pdf-main-container" 
             style="width: 100%; min-height: 80vh;"
             data-url="{{ files($selectedDoc)->link }}" 
             data-name="{{ $selectedDocName }}" 
             data-courrier="{{ $courrier->id }}" 
             data-tache="" 
             data-docid="" 
             data-code="" 
             data-original="true">
            <div id="pdf-contents" style="width: 100%; height: 100%; min-height: 80vh;">
            </div>
            @include('components.pdf-tools')
        </div>
    </div>
</div>

@push('livewireScripts')
    <script>
        $('.btn-doc').on('click', function () {
            var url = $(this).data('url');
            var name = $(this).data('name');
            @this.selectedDoc = url;
            @this.selectedDocName = name;
            
            const pdfContainer = document.querySelector('#pdf-main-container');
            if (pdfContainer) {
                pdfContainer.setAttribute('data-url', url);
                if (typeof showPDF === 'function') {
                    showPDF(url);
                } else if (typeof changDoc === 'function') {
                    changDoc(url);
                }
            }
        });
    </script>
@endpush
