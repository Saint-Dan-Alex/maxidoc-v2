<div class="shadow-sm sticky-top pdf-tools rounded-pill pdf-tools-modified" style="gap: 10px !important; padding: 5px 15px !important;">
    <!-- Toolbar Left -->
    <div id="toolbarViewerLeft-offcanvas" class="gap-1 d-flex align-items-center">
        <div class="d-flex">
            <button class="toolbarButton btn p-1" title="Page précédente" id="previous-offcanvas">
                <span class="fi fi-rr-angle-up" style="font-size: 14px;"></span>
            </button>
            <button class="toolbarButton btn p-1" title="Page suivante" id="next-offcanvas">
                <span class="fi fi-rr-angle-down" style="font-size: 14px;"></span>
            </button>
        </div>
        <span id="numPages-offcanvas" class="toolbarLabel text-nowrap small"></span>
    </div>

    <!-- Toolbar Middle -->
    <div id="toolbarViewerMiddle-offcanvas" class="d-flex gap-1">
        <button id="zoomOut-offcanvas" class="toolbarButton btn p-1" title="Zoom arrière">
            <span class="fi fi-rr-minus" style="font-size: 14px;"></span>
        </button>
        <button id="zoomIn-offcanvas" class="toolbarButton btn p-1" title="Zoom avant">
            <span class="fi fi-rr-plus" style="font-size: 14px;"></span>
        </button>
    </div>

    <!-- Toolbar Right -->
    <div id="toolbarViewerRight-offcanvas" class="d-flex gap-1">
        @can('Imprimer un document')
            <button id="print-offcanvas" class="toolbarButton btn p-1" title="Imprimer">
                <span class="fi fi-rr-print" style="font-size: 14px;"></span>
            </button>
        @endcan
    </div>
</div>
