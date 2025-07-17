<div class="px-2 py-1 shadow-sm sticky-top pdf-tools rounded-pill  pdf-tools-modified">

    <!-- Toolbar Left -->
    <div id="toolbarViewerLeft" class="gap-2 d-flex align-items-center">
        <div class="d-flex">
            <button class="toolbarButton btn" title="Page précédente" id="previous">
                <span class="fi fi-rr-angle-up icon-pdf-tools"></span>
            </button>
            <div class="splitToolbarButtonSeparator border-end"></div>
            <button class="toolbarButton btn" title="Page suivante" id="next">
                <span class="fi fi-rr-angle-down icon-pdf-tools"></span>
            </button>
        </div>

        <input type="number" id="pageNumber" class="toolbarField form-control text-center" title="Page"
            value="1" min="1" max="1" tabindex="15" style="width: 60px; height: 32px;"
            autocomplete="off">

        <span id="numPages" class="toolbarLabel text-nowrap"></span>
    </div>

    <!-- Toolbar Middle -->
    <div id="toolbarViewerMiddle" class="d-flex">
        <div class="splitToolbarButton d-flex">
            <button id="zoomOut" class="toolbarButton btn" title="Zoom arrière" tabindex="21">
                <span class="fi fi-rr-minus icon-pdf-tools"></span>
            </button>
            <div class="splitToolbarButtonSeparator border-end"></div>
            <button id="zoomIn" class="toolbarButton btn" title="Zoom avant" tabindex="22">
                <span class="fi fi-rr-plus icon-pdf-tools"></span>
            </button>
        </div>

        <select id="scaleSelect" class="form-select form-control" title="Zoom" tabindex="23" style="height: 32px;">
            <option id="pageAutoOption" value="auto" selected>Zoom auto</option>
            <option id="customScaleOption" value="custom" hidden>Personnalisé</option>
            <option value="0.5">50%</option>
            <option value="0.75">75%</option>
            <option value="1">100%</option>
            <option value="1.25">125%</option>
            <option value="1.5">150%</option>
            <option value="2">200%</option>
            <option value="3">300%</option>
            <option value="4">400%</option>
        </select>
    </div>

    <!-- Toolbar Right -->
    <div id="toolbarViewerRight" class="d-flex gap-2">
        <button class="toolbarButton btn" title="Rechercher" id="search">
            <span class="fi fi-rr-search icon-pdf-tools"></span>
        </button>

        @can('Imprimer un document')
            <button id="print" class="toolbarButton btn hiddenMediumView" title="Imprimer" tabindex="32">
                <span class="fi fi-rr-print icon-pdf-tools"></span>
            </button>
        @endcan

        @can('Telecharger un document')
            <a id="download" class="toolbarButton btn" title="Télécharger" tabindex="33" href="#" download>
                <span class="fi fi-rr-download icon-pdf-tools"></span>
            </a>
        @endcan
    </div>
</div>
