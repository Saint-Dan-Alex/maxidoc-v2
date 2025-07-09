<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
    @include('regidoc.layouts.partials.head.styles')
    <script src="{{ asset('assets/js/pdfjs/pdf.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.16.0/pdf-lib.min.js"></script>
    <script src="{{ asset('assets/js/pdfjs/pdf.worker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        #upload-button {
            width: 150px;
            display: block;
            margin: 20px auto;
        }

        #file-to-upload {
            display: none;
        } 


        #pdf-loader {
            display: none;
            text-align: center;
            color: #999999;
            font-size: 13px;
            line-height: 100px;
            height: 100px;
            position: absolute;
        }

        #pdf-contents {
            display: none;
            position: relative;
            /* overflow-x: scroll; */
            text-align: center;
        }

        #pdf-meta {
            margin: 0 0 20px 0;
        }

        #pdf-current-page {
            display: inline;
        }

        #pdf-total-pages {
            display: inline;
        }

        .pdf-canvas {
            box-sizing: border-box;
        }

        .page-loader {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            display: flex;
            justify-content: center;
        }

        .page-loader img {
            width: 70px;
            height: 70px;
            margin: auto;
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
        }

        .text-layer>div {
            color: transparent;
            position: absolute;
            white-space: pre;
            cursor: text;
            transform-origin: 0% 0%;
        }

        .text-layer>div::selection {
            background: rgb(221, 85, 0);
        }

        .image-container {
            position: absolute;
            top: 100%;
            left: 100%;
            transform: translate(-110%, -170%);
            z-index: 9999;
        }

        .image-container img {
            width: 200px;
            /* Set an initial width */
            height: auto;
            /* Preserve aspect ratio */
            resize: both;
            overflow: auto;
            object-fit: cover;
        }

        .ui-resizable-sw,
        .ui-resizable-ne,
        .ui-resizable-nw,
        .ui-resizable-se {
            border: 1px solid #999999;
        }

        .ui-resizable-n,
        .ui-resizable-s {
            height: 9px;
            width: 9px;
            left: 49%;
            border: 1px solid #999;
        }

        .ui-resizable-e,
        .ui-resizable-w {
            height: 9px;
            width: 9px;
            top: 41%;
            border: 1px solid #999;
        }

        .ui-icon-gripsmall-diagonal-se {
            background-position: initial;
        }

        .ui-icon {
            width: 9px;
            height: 9px;
            background: none !important;
        }

        .ui-resizable-se {
            right: -5px;
            bottom: -5px;
        }

        .pdf-page {
            position: relative;
        }

        .vignette-column {
            overflow: hidden;
            width: 100%;
            padding: 0;
            transition: width .3s ease-in-out;
        }

        #vignet-container {
            overflow-y: scroll;
            height: calc(100vh - 71px);
        }

        .signature {
            position: fixed;
            /* pointer-events: none; Make the signature element ignore mouse events */
            z-index: 1041;
            /* display: none; */
            /* border: 1px solid #eee; */
            width: 175px;
            height: 75px;
        }

        .signature.dropped-true {
            border: none;
        }

        .signature.dropped-true:hover {
            border: 1px solid #eee;
        }

        .signature.dropped-true img {
            cursor: pointer;
        }

        .signature.dropped-true button {
            display: none;
        }

        .signature.dropped-true:hover button {
            display: initial;
        }


        /* annotation */
        .pdf-content {
            border: 1px solid #000000;
        }

        .annotationLayer>a {
            display: block;
            position: absolute;
        }

        .annotationLayer>a:hover {
            opacity: 0.2;
            background: #ff0;
            box-shadow: 0px 2px 10px #ff0;
        }

        .annotText>div {
            z-index: 200;
            position: absolute;
            padding: 0.6em;
            max-width: 20em;
            background-color: #FFFF99;
            box-shadow: 0px 2px 10px #333;
            border-radius: 7px;
        }

        .annotText>img {
            position: absolute;
            opacity: 0.6;
        }

        .annotText>img:hover {
            opacity: 1;
        }

        .annotText>div>h1 {
            font-size: 1.2em;
            border-bottom: 1px solid #000000;
            margin: 0px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="content-sidebar">
            <div class="logo text-start">
                <a href="{{ url()->previous() }}" class="gap-2 d-flex align-items-center">
                    <i class="fi fi-rr-angle-left"></i>
                    <span>Retour</span>
                </a>
            </div>
            <div class="block-links">
                <ul class="lists">
                    <li>
                        <span class="tooltip-sm">
                            Signature
                        </span>
                        <a href="javascript:void(0)" class="btn-signer">
                            <span>
                                <i class="fi fi-rr-pencil fi-rr"></i>
                                <i class="fi fi-sr-pencil fi-sr"></i>
                            </span>
                            <span class="title">
                                Ma signature
                            </span>
                        </a>
                    </li>

                    <li>
                        <span class="tooltip-sm">
                            Initiales
                        </span>
                        <a href="javascript:void(0)">
                            <span>
                                <i class="fi fi-rr-box fi-rr"></i>
                                <i class="fi fi-sr-box fi-sr"></i>
                            </span>
                            <span class="title">
                                Initiales
                            </span>
                        </a>
                    </li>

                    <li>
                        <span class="tooltip-sm">
                            Tampon
                        </span>
                        <a href="javascript:void(0)" class="btn-tampon">
                            <span>
                                <i class="fi fi-rr-settings-sliders fi-rr"></i>
                                <i class="fi fi-sr-settings-sliders fi-sr"></i>
                            </span>
                            <span class="title">
                                Tampon
                            </span>
                        </a>
                    </li>

                    <li>
                        <span class="tooltip-sm">
                            Date de la signature
                        </span>
                        <a href="#">
                            <span>
                                <i class="fi fi-rr-calendar fi-rr"></i>
                                <i class="fi fi-sr-calendar fi-sr"></i>
                            </span>
                            <span class="title">
                                Date de la signature
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="pdf-main-container">

        <div id="pdf-meta" class="nav-tools-page">
            <div class="row w-100 ms-0 align-items-center">
                {{-- <div class="col-lg-4">
                    <div class="name-file">
                        <p class="mb-0">
                            <i class="fi fi-rr-file"></i> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fuga eum ut sint?
                        </p>
                    </div>
                </div> --}}
                <div class="col-lg-8">
                    {{-- <div class="d-flex justify-content-start align-items-center">
                        <button id="pdf-prev" class="btn btn-tools">
                            <i class="fi fi-rr-angle-left"></i>
                            <div class="tooltip-indicator">
                                Précedent
                            </div>
                        </button>
                        <div id="page-count-container" class="mx-3">Page <div id="pdf-current-page"></div> /
                            <div id="pdf-total-pages"></div>
                        </div>
                        <button id="pdf-next" class="btn btn-tools">
                            <i class="fi fi-rr-angle-right"></i>
                            <div class="tooltip-indicator">
                                Suivant
                            </div>
                        </button>
                    </div> --}}
                    <div class="name-file">
                        <p class="mb-0">
                            <i class="fi fi-rr-file"></i>
                            {{ files($courrier->document?->document)->name }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="gap-3 d-flex justify-content-end">
                        <button class="save_pdf btn ">Enregistrer</button>
                        {{-- <button id="saveButton">Save Annotations</button> --}}
                        <div class="border-start">
                            <button class="btn show-vignette" id="saveButton">
                                <i class="fi-sr-file"></i>
                            </button>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-lg-10 text-center">
                    <div id="pdf-contents" data-spy="scroll" data-target="#vignet-container" data-offset="0"
                        class="scrollspy-example">
                        <div id="pdf-loader">Loading document ...</div>
                        {{-- <canvas id="pdf-canvas" class="w-100"></canvas> --}}
                        {{-- <canvas id="pdf-canvas" width="743px"></canvas> --}}
                        {{-- <div class="text-layer"></div> --}}
                        {{-- <div class="image-container">
                            <img src="#" alt="signature" class="sign-img">
                        </div> --}}
                        {{-- <div id="page-loader">Loading page ...</div> --}}
                        {{-- <canvas id="pdfCanvas"></canvas> --}}
                    </div>

                </div>
                <div class="col-2 border-start">
                    <div class="position-fixed d-flex justify-content-end">
                        <div class="vignette-column">
                            <div id="vignet-container" class="py-3 d-flex flex-column align-items-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal-signature position-fixed d-flex align-items-center justify-content-center"
        style="left:0;right:0;top:0;bottom:0;background: rgba(0, 0, 0, 0.5); z-index: 99999; width:0px; overflow:hidden">
        <div class="p-4 bg-white border rounded-lg w-50 block-content-modal">
            <button type="button" class="btn-close"></button>
            <h5 class="mt-2 mb-4">Signer le document</h5>
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item dessin" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Dessiner</button>
                </li>
                <li class="nav-item import-image" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Image</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="pt-2 tab-pane dessin-tab fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <div class="d-flex align-items-center me-4">
                            <span style="font-size: 14px; color: var(--colorParagraph)">Couleur</span>
                            <select name="color" id="color" class="form-control form-select ms-1">
                                <option value="rgb(0, 0, 0)" selected>noir</option>
                                <option value="rgb(255, 0, 0)">rouge</option>
                                <option value="rgb(66, 133, 244)">bleu</option>
                            </select>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="" style="font-size: 14px; color: var(--colorParagraph)">Taille</span>
                            <select name="size" id="size" class="form-control form-select ms-1">
                                <option value="noir" selected>12</option>
                                <option value="red">14</option>
                                <option value="blue">16</option>
                            </select>
                        </div>
                    </div>

                    <canvas id="canvas_signature_pad" height="150px" width="586px"
                        style="border:2px dashed rgb(180, 178, 178);border-radius:12px"></canvas>

                    <div class="mt-4 mb-3 d-flex justify-content-end">
                        <button class="btn btn-default clear-canevas">Effacer</button>
                        <button class="btn btn-add valid-canevas">Valider</button>
                    </div>
                </div>

                <div class="pt-3 tab-pane fade import-image-tab" id="pills-profile" role="tabpanel"
                    aria-labelledby="pills-profile-tab" tabindex="0">
                    <div class="block-up-img w-100" style="height: 150px;">
                        <input type="file" id="file-img" accept=".jpg,.png" name="image">
                        <label for="file-img" class="mb-0 dashed" id="label-5">
                            <svg viewBox="0 0 801.19 537.98">
                                <g id="Calque_2" data-name="Calque 2">
                                    <g id="Calque_1-2" data-name="Calque 1">
                                        <path
                                            d="M754.28,264.59A159.67,159.67,0,0,0,648.9,217.87c.58-.77,1.13-1.55,1.68-2.34A76.4,76.4,0,0,0,531.91,120,195.87,195.87,0,0,0,351.32,0C256.06,0,176.7,68,159.12,158.11,68.79,173.41,0,252,0,346.7,0,452.34,85.64,538,191.28,538c1.43,0,2.85,0,4.27-.05s2.82.05,4.24.05H642.14A161.47,161.47,0,0,0,796.75,415.41c.12-.47.23-.94.34-1.41a160.45,160.45,0,0,0-42.81-149.41ZM499.56,296.45c-5.09,11.64-15.11,15.75-27.19,15.78-13.62,0-27.23.24-40.84-.06-6.1-.14-8.07,2.22-8,8.13.27,16.07.1,32.13.1,51.47-.93,15.74,1.62,34.84-1.34,53.79-3.89,25-25.87,43.75-50.7,43.4a51.73,51.73,0,0,1-50.17-43.18c-1.85-10.85-1.11-21.72-1.19-32.58-.16-23.69-.35-47.38.12-71.06.16-8-2.58-10.36-10.31-10-12.77.54-25.58.22-38.37.11-11.93-.1-22.14-3.65-27.34-15.48-5.4-12.28-.77-22.17,8-30.91q49.93-49.95,100-99.87c12.27-12.17,26.86-12.3,39-.23q50.48,50,100.53,100.44C500.41,274.72,504.71,284.65,499.56,296.45Z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                            <p style="font-size: 14px; color:var(--colorParagraph)" class="mb-0">
                                Cliquez pour importer l'image de votre signature
                            </p>
                        </label>
                        <div class="img d-none" id="img_block"
                            style="position: absolute; top: 50%; left:50%; width: 98%; height: 98%; background:#fff;border-radius: 12px; z-index: 1; pointer-events: none; transform: translate(-50%, -50%);">
                            <img src="" alt="" id="sign-img" class="m-auto d-block"
                                style="object-fit: contain; width: 80%; height: 100%;">
                        </div>
                    </div>
                    <div class="mt-4 mb-3 d-flex justify-content-end">
                        <button class="btn btn-default">Effacer</button>
                        <button class="btn btn-add btn-valid-img">Valider</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-action-save" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Enregistrement</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

    @include('regidoc.layouts.partials.head.scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    {{-- <script>
        // Initialize pdf.js
        const pdfjsLib = window['pdfjs-dist/build/pdf'];

        // Initialize pdf-lib
        const { PDFDocument, rgb } = PDFLib;

        let pdfDoc;
        let annotations = [];

        // Load and render PDF using pdf.js
        async function renderPdf(url) {
            const loadingTask = pdfjsLib.getDocument(url);
            const pdf = await loadingTask.promise;

            pdfDoc = await PDFDocument.create();

            for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                const page = await pdf.getPage(pageNum);
                const canvas = document.createElement('canvas');
                // const viewport = page.getViewport({
                //     scale: 1.0
                // });
                const viewport = page.getViewport(1.0);

                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };
                await page.render(renderContext).then(function(textContent) {
                    // Get canvas offset
                    var canvas_offset = $(canvas).offset();

                    // Clear HTML for text layer
                    $(textLayer).html('');

                    // Assign the CSS created to the text-layer element
                    $(textLayer).css({
                        left: '0px',
                        top: '-10px',
                        height: canvas.height + 'px',
                        width: canvas.width + 'px'
                    });

                    // Pass the data to the method for rendering of text over the pdf canvas.
                    PDFJS.renderTextLayer({
                        textContent: textContent,
                        container: $(textLayer).get(0),
                        viewport: viewport,
                        textDivs: []
                    });

                });

                // Draw annotations on canvas
                const pageAnnotations = annotations.filter(ann => ann.pageNum === pageNum);
                pageAnnotations.forEach(ann => {
                    context.beginPath();
                    context.rect(ann.x, ann.y, ann.width, ann.height);
                    context.strokeStyle = 'red';
                    context.lineWidth = 2;
                    context.stroke();
                });

                document.querySelector('#pdf-contents').appendChild(canvas);
                // document.body.appendChild(canvas);
            }
        }

        // Handle text selection and annotation
        document.addEventListener('mouseup', () => {
            const selectedText = window.getSelection().toString();
            if (selectedText) {
                const comment = prompt('Add a comment:');
                if (comment) {
                    const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
                    const canvasRect = document.getElementById('pdfCanvas').getBoundingClientRect();
                    const annotation = {
                        pageNum: 1, // Page number
                        x: boundingRect.left - canvasRect.left,
                        y: boundingRect.top - canvasRect.top,
                        width: boundingRect.width,
                        height: boundingRect.height,
                        comment: comment,
                    };
                    annotations.push(annotation);

                    // Update canvas with annotation
                    renderPdfWithAnnotations();
                }
            }
        });

        // Render PDF with annotations
        function renderPdfWithAnnotations() {
            const canvas = document.getElementById('pdfCanvas');
            const context = canvas.getContext('2d');
            const viewport = pdfDoc.getPages()[0].getViewport({
                scale: 1.0
            });
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Draw PDF content from pdf-lib
            pdfDoc.getPages()[0].draw(context);

            // Draw annotations
            const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
            pageAnnotations.forEach(ann => {
                context.beginPath();
                context.rect(ann.x, ann.y, ann.width, ann.height);
                context.strokeStyle = 'red';
                context.lineWidth = 2;
                context.stroke();
            });
        }

        // Save annotations to the PDF using pdf-lib
        document.getElementById('saveButton').addEventListener('click', async () => {
            annotations.forEach(ann => {
                const page = pdfDoc.getPages()[0];
                const textAnnotation = page.drawText(ann.comment, {
                    x: ann.x,
                    y: ann.y - 10,
                    size: 10,
                    color: rgb(255, 0, 0),
                });
            });

            const pdfBytes = await pdfDoc.save();

            // Update canvas with annotations
            renderPdfWithAnnotations();
        });

        // Load and render the PDF when the page loads
        renderPdf("{{ files($courrier->document?->document)->link }}");
    </script> --}}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const canvas = document.getElementById("canvas_signature_pad");
        const signaturePad = new SignaturePad(canvas);
        signaturePad.penColor = $('select[name="color"]').val();

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // otherwise isEmpty() might return incorrect value
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

        $('select[name="color"]').on('change', function() {
            signaturePad.penColor = $(this).val();
        });

        $('.clear-canevas').on('click', function() {
            signaturePad.clear();
        });

        $('.btn-close').click(function() {
            $('.signature.dropped-true.active').removeClass('active');
            $('.modal-signature').css({
                width: '0px'
            });
        })

        const input = document.getElementById('file-img');
        const img = document.getElementById('sign-img');
        const img_block = document.getElementById('img_block');

        input.addEventListener('change', () => {
            const file = input.files[0];
            const reader = new FileReader();

            reader.addEventListener('load', () => {
                img.src = reader.result;
                img_block.classList.remove('d-none');
            });

            reader.readAsDataURL(file);
        })

        // Initialize pdf.js
        const pdfjsLib = window['pdfjs-dist/build/pdf'];

        // Initialize pdf-lib
        const {
            PDFDocument,
            rgb
        } = PDFLib;

        let annotations = [{
            pageNum: 1, // Page number
            x: 87,
            y: 445,
            width: 100,
            height: 15,
            comment: 'test',
        }];
        let __PDF_DOC,
            __CURRENT_PAGE,
            __TOTAL_PAGES,
            __PAGE_RENDERING_IN_PROGRESS = 0;

        // var url = "{{ asset('assets/pdfs/documents/2.pdf') }}";
        var url = "{{ files($courrier->document?->document)->link }}";

        showPDF(url);

        function showPDF(pdf_url) {
            $("#pdf-loader").show();

            PDFJS.getDocument({
                url: pdf_url
            }).then(function(pdf_doc) {
                __PDF_DOC = pdf_doc;
                __TOTAL_PAGES = __PDF_DOC.numPages;

                // Hide the pdf loader and show pdf container in HTML
                $("#pdf-loader").hide();
                $("#pdf-contents").show();
                $("#pdf-total-pages").text(__TOTAL_PAGES);

                for (var i = 1; i <= __TOTAL_PAGES; i++) {

                    var pdfPage = document.createElement('div');
                    pdfPage.classList.add('pdf-page');
                    pdfPage.setAttribute('id', 'page-' + i);

                    var canvas = document.createElement('canvas');
                    // canvas.setAttribute('width', '595px');
                    canvas.setAttribute('data-page', i);
                    canvas.classList.add('pdf-canvas');
                    canvas.classList.add('mb-2');
                    $(pdfPage).append(canvas);

                    var textLayer = document.createElement('div');
                    textLayer.classList.add('text-layer');
                    $(pdfPage).append(textLayer);

                    var annotationLayer = document.createElement('div');
                    annotationLayer.classList.add('annotationLayer');
                    $(pdfPage).append(annotationLayer);

                    var loader = document.createElement('div');
                    loader.classList.add('page-loader');
                    loader.classList.add('page-' + i);

                    var loaderIcon = document.createElement('img');
                    loaderIcon.src = "{{ asset('assets/images/loader.svg') }}";
                    $(loader).append(loaderIcon);

                    $(pdfPage).append(loader);

                    $('#pdf-contents').append(pdfPage);

                    var vignettePage = document.createElement('div');
                    vignettePage.classList.add('vignette-page');

                    var vignetteLink = document.createElement('a');
                    vignetteLink.setAttribute('href', '#page-' + i);

                    var vignetteCanvas = document.createElement('canvas');
                    vignetteCanvas.setAttribute('width', '140px');
                    vignetteCanvas.classList.add('mb-2');

                    $(vignetteLink).append(vignetteCanvas);
                    $(vignettePage).append(vignetteLink);

                    $('#vignet-container').append(vignettePage);

                    $("#page-" + i).droppable();

                    $("#page-" + i).on("drop", function(event, ui) {

                        $(ui.draggable).attr('data-page', $(this).find('canvas').data('page'));

                        var droppableOffset = $(this).offset();
                        var draggablePosition = ui.draggable.position();

                        // Calculate the position of the draggable relative to the droppable
                        var relativeLeft = draggablePosition.left - droppableOffset.left;
                        var relativeTop = draggablePosition.top - droppableOffset.top;

                        $(ui.draggable).attr('data-x', relativeLeft);
                        $(ui.draggable).attr('data-y', relativeTop);

                    });

                    // Show the first page
                    showPage(canvas, vignetteCanvas, textLayer, i);
                }

            }).catch(function(error) {
                // If error re-show the upload button
                $("#pdf-loader").hide();
                $("#upload-button").show();

                alert(error.message);
            });
        }

        function showPage(canvas, vignetteCanvas, textLayer, page_no) {
            __PAGE_RENDERING_IN_PROGRESS = 1;
            __CURRENT_PAGE = page_no;

            // Disable Prev & Next buttons while page is being loaded
            $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

            // While page is being rendered hide the canvas and show a loading message
            $("#pdf-canvas").hide();
            $(".page-loader.page-" + page_no).show();

            // Update current page in HTML
            $("#pdf-current-page").text(page_no);

            // Fetch the page
            __PDF_DOC.getPage(page_no).then(function(page) {

                // Support HiDPI-screens.
                var outputScale = window.devicePixelRatio || 1;

                var scale = outputScale > 1 ? 1.5 : 1.2;

                var viewport = page.getViewport(scale);

                var context = canvas.getContext('2d');

                canvas.width = Math.floor(viewport.width * outputScale);
                canvas.height = Math.floor(viewport.height * outputScale);
                canvas.style.width = Math.floor(viewport.width) + "px";
                canvas.style.height = Math.floor(viewport.height) + "px";

                $(canvas).parent().css({
                    width: Math.floor(viewport.width) + "px",
                    height: Math.floor(viewport.height) + "px",
                    margin: '10px auto',
                });

                var transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] :
                    null;

                var renderContext = {
                    canvasContext: context,
                    transform: transform,
                    viewport: viewport
                };

                // Render the page contents in the canvas
                page.render(renderContext).then(function() {
                    __PAGE_RENDERING_IN_PROGRESS = 0;

                    // Show the canvas and hide the page loader
                    $(".page-loader.page-" + page_no).hide();

                    // Return the text contents of the page after the pdf has been rendered in the canvas
                    return page.getTextContent();
                }).then(function(textContent) {
                    // Get canvas offset
                    var canvas_offset = $(canvas).offset();

                    // Clear HTML for text layer
                    $(textLayer).html('');

                    // Assign the CSS created to the text-layer element
                    $(textLayer).css({
                        left: '0px',
                        top: '8px',
                        height: canvas.height + 'px',
                        width: canvas.width + 'px'
                    });

                    // Pass the data to the method for rendering of text over the pdf canvas.
                    PDFJS.renderTextLayer({
                        textContent: textContent,
                        container: $(textLayer).get(0),
                        viewport: viewport,
                        textDivs: []
                    });

                    // Draw annotations on canvas
                    const pageAnnotations = annotations.filter(ann => ann.pageNum === page_no);
                    pageAnnotations.forEach(ann => {
                        createSelection($(canvas).parent().find('.annotationLayer')[0], ann.width,
                            ann.height, ann.x, ann.y, null)
                        createCommentElement($(canvas).parent().find('.annotationLayer')[0], $(
                            canvas).width(), ann.y)
                        // textContent.beginPath();
                        // textContent.rect(ann.x, ann.y, ann.width, ann.height);
                        // textContent.strokeStyle = 'red';
                        // textContent.lineWidth = 2;
                        // textContent.stroke();
                    });

                });

                var scale_vignette_required = vignetteCanvas.width / page.getViewport(1).width * outputScale;

                // Get viewport of the page at required scale
                var vignettevViewport = page.getViewport(scale_vignette_required);

                // Set canvas height
                vignetteCanvas.height = vignettevViewport.height;

                var renderVignetteContext = {
                    canvasContext: vignetteCanvas.getContext('2d'),
                    viewport: vignettevViewport
                };
                page.render(renderVignetteContext);
            });
        }

        // Handle text selection and annotation
        document.addEventListener('mouseup', () => {
            const selectedText = window.getSelection().toString();
            if (selectedText && $('.comment-btn-popover').length == 0) {

                const pdfContents = document.getElementById('pdf-contents');
                const selectionTextLayer = getParentElementOfSelectedText();
                const selectionCanvas = $(selectionTextLayer).hasClass('pdf-page') ? $(selectionTextLayer)
                    .find('canvas')[0] : $(selectionTextLayer).parent().parent().find('canvas')[0];

                const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
                const canvasRect = selectionCanvas.getBoundingClientRect();

                // I create a popover element
                const popover = document.createElement('div');
                popover.style.position = 'absolute';
                popover.style.zIndex = '1';
                popover.style.left = (boundingRect.right + 5) +
                    'px'; //(boundingRect.left + canvasRect.left) + 'px'; //canvasRect.right+'px';
                popover.style.top = (boundingRect.top - canvasRect.top) + 50 + 'px';
                popover.style.width = '50px';
                popover.style.height = '100px';
                popover.style.display = 'flex';
                popover.style.justifyContent = 'center';
                popover.style.alignItems = 'center';
                popover.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                popover.classList.add('comment-btn-popover');

                // I create a button to add to the popover
                const button = document.createElement('button');
                button.style.width = '50px';
                button.style.height = '100px';
                button.style.display = 'flex';
                button.style.justifyContent = 'center';
                button.style.alignItems = 'center';
                button.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                button.style.color = 'white';
                button.innerText = 'Add';

                // I add the button to the popover
                popover.appendChild(button);

                // I add the popover to the document
                document.body.appendChild(popover);

                button.addEventListener('click', handleNewCommentBTN);

                // alert($('#pdf-contents').width());
                // const comment = prompt('Add a comment:');
                // if (comment) {
                //     const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
                //     const canvasRect = document.getElementById('pdfCanvas').getBoundingClientRect();
                //     const annotation = {
                //         pageNum: 1, // Page number
                //         x: boundingRect.left - canvasRect.left,
                //         y: boundingRect.top - canvasRect.top,
                //         width: boundingRect.width,
                //         height: boundingRect.height,
                //         comment: comment,
                //     };
                //     annotations.push(annotation);

                //     // Update canvas with annotation
                //     renderPdfWithAnnotations();
                // }
            }
            if (!selectedText && $('.comment-btn-popover').length > 0) {
                $('.comment-btn-popover').remove();
            }
        });

        function getParentElementOfSelectedText() {
            const selection = window.getSelection();

            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                const parentElement = range.commonAncestorContainer.parentElement;
                return parentElement;
            }

            return null;
        }

        function handleNewCommentBTN(evt) {
            const selectionTextLayer = getParentElementOfSelectedText();
            const selectionCanvas = $(selectionTextLayer).hasClass('pdf-page') ? $(selectionTextLayer)
                .find('canvas')[0] : $(selectionTextLayer).parent().parent().find('canvas')[0];
            const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
            const canvasRect = selectionCanvas.getBoundingClientRect();
            const annotationLayer = $(selectionCanvas).parent().find('.annotationLayer')[0];
            var btn = $(this);

            // width: boundingRect.width,
            //     height: boundingRect.height,
            //     left: boundingRect.left - canvasRect.left + 'px',
            //     top: boundingRect.top - canvasRect.top + 'px',

            createSelection(annotationLayer, boundingRect.width, boundingRect.height, boundingRect.left - canvasRect.left,
                boundingRect.top - canvasRect.top, btn);
            // left: canvasRect.width - (250 * 5) / 100 + 'px',
            //     top: (boundingRect.top - canvasRect.top) + 'px',
            createCommentElement(annotationLayer, canvasRect.width, (boundingRect.top - canvasRect.top));
        }

        function createSelection(annotationLayer, width, height, left, top, btn) {
            var selectionElement = document.createElement('div');
            $(selectionElement).css({
                position: 'absolute',
                backgroundColor: 'rgba(221, 85, 0, 0.3)',
                width: width,
                height: height,
                left: left + 'px',
                top: top + 'px',
            });

            selectionElement.classList.add('selection');
            selectionElement.classList.add('selection-' + $('.selection').length);

            annotationLayer.append(selectionElement);
            window.getSelection().removeAllRanges();
            if (btn !== null) {

                btn.parent().remove();
            }
        }

        function createCommentElement(annotationLayer, left, top) {

            var commentElement = document.createElement('div');
            $(commentElement).addClass('shadow rounded border p-2 comment comment-' + $('.comment').length)
            $(commentElement).data('link-to', 'selection-' + $('.comment').length);

            $(commentElement).css({
                position: 'absolute',
                backgroundColor: '#fff',
                width: '250px',
                minHeight: '40px',
                left: left - (250 * 5) / 100 + 'px',
                top: top + 'px',
                zIndex: '1',
            });

            var commentElementHeader = document.createElement('div');
            commentElementHeader.style.display = 'flex';
            commentElementHeader.classList.add('gap-2');

            var commentElementHeaderImg = document.createElement('img');
            commentElementHeaderImg.style.width = '40px';
            commentElementHeaderImg.style.height = '40px';
            commentElementHeaderImg.classList.add('rounded-circle')
            commentElementHeaderImg.src = '{{ imageOrDefault(Auth::user()->agent->image) }}'

            var commentElementHeaderUserName = document.createElement('div');
            var commentElementHeaderH6 = document.createElement('h6');
            commentElementHeaderH6.style.margin = '0px';
            commentElementHeaderH6.innerText = '{{ Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom }}';

            var commentElementHeaderSmall = document.createElement('small');
            commentElementHeaderSmall.innerText = '{{ Auth::user()->agent->direction->titre }}';

            commentElementHeaderUserName.append(commentElementHeaderH6);
            commentElementHeaderUserName.append(commentElementHeaderSmall);

            commentElementHeader.append(commentElementHeaderImg);
            commentElementHeader.append(commentElementHeaderUserName);

            var commentElementBody = document.createElement('div');
            $(commentElementBody).addClass('py-2')
            var commentElementBodyTextarea = document.createElement('textarea');
            $(commentElementBodyTextarea).addClass(' form-control')
            $(commentElementBodyTextarea).attr('placeholder', 'Votre texte ici')

            commentElementBody.append(commentElementBodyTextarea);

            var commentElementFooter = document.createElement('div');
            commentElementFooter.classList.add('text-end');

            var commentElementFooterBtnRemove = document.createElement('button');
            commentElementFooterBtnRemove.innerText = 'remove';
            $(commentElementFooterBtnRemove).addClass('btn btn-sm me-2');
            commentElementFooter.append(commentElementFooterBtnRemove);

            var commentElementFooterBtnSave = document.createElement('button');
            commentElementFooterBtnSave.innerText = 'save';
            $(commentElementFooterBtnSave).addClass('btn btn-sm btn-primary');
            commentElementFooter.append(commentElementFooterBtnSave);

            commentElement.append(commentElementHeader);
            commentElement.append(commentElementBody);
            commentElement.append(commentElementFooter);
            // annotationLayer.append(commentElement);
            addToLayer(annotationLayer, commentElement);
        }

        function addToLayer(annotationLayer, commentElement) {
            var comments = document.querySelectorAll('.annotationLayer .comment');
            // annotationLayer.removeChild(commentElement)
            if (comments.length === 0) {
                annotationLayer.appendChild(commentElement);
            } else {
                let inserted = false;

                for (let i = 0; i < comments.length; i++) {
                    const currentItem = comments[i];
                    const rect = currentItem.getBoundingClientRect();
                    const spaceAbove = i === 0 ? rect.top : rect.top - comments[i - 1].getBoundingClientRect().bottom;

                    var elementTop = parseFloat(commentElement.style.top);
                    console.log(rect.top + rect.height, elementTop);

                    if (rect.top <= elementTop && rect.bottom >= elementTop) {
                        annotationLayer.insertBefore(commentElement, currentItem);
                        // for (let j = 0; j < comments.length; j++) {
                        //     if (condition) {

                        //     }
                        // }
                    }



                    // currentItem.style.top = commentElement.offsetHeight + 'px';
                    // commentElement.style.backgroundColor = 'red';

                    // if (spaceAbove >= commentElement.offsetHeight) {
                    //     commentElement.style.backgroundColor = 'red';
                    //     annotationLayer.insertBefore(commentElement, currentItem);
                    //     currentItem.style.top = commentElement.offsetHeight + 'px';
                    //     inserted = true;
                    //     break;
                    // }
                }

                if (!inserted) {
                    annotationLayer.appendChild(commentElement);
                }
            }

            // // while (comments[0]) {
            //     // $(annotationLayer).find(comments).remove();
            //     // annotationLayer.removeChild(comments[0]);
            // // }

            // // Créez un tableau pour stocker les éléments triés
            // const sortedElements = [];

            // // if (comments.length > 0) {

            //     // Bouclez à travers les éléments et obtenez leurs positions
            //     comments.forEach(comment => {
            //         const rect = comment.getBoundingClientRect();
            //         sortedElements.push({
            //             comment,
            //             top: rect.top
            //         });
            //     });


            //     // Triez les éléments en fonction de leurs positions "top"
            //     sortedElements.sort((a, b) => a.top - b.top);

            //     // Maintenant, insérez les éléments triés dans le conteneur cible tout en évitant le chevauchement
            //     const sortedContainer = annotationLayer; //document.getElementById('annotationLayer');
            //     let previousBottom = Number.NEGATIVE_INFINITY;

            //     sortedElements.forEach((item, index) => {
            //         const rect = item.comment.getBoundingClientRect();
            //         const overlap = rect.top < previousBottom;
            //         console.log(index);
            //         if (overlap) {
            //             const overlapHeight = previousBottom - rect.top;
            //             item.comment.style.transform = `translateY(-${overlapHeight}px)`;
            //             item.comment.style.backgroundColor = 'red'
            //         }

            //         sortedContainer.appendChild(item.comment);
            //         previousBottom = rect.bottom;
            //     });
            // // }

        }

        // Render PDF with annotations
        async function renderPdfWithAnnotations() {

            var allCanvas = document.querySelectorAll('#pdf-contents canvas');

            const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
            console.log(pageAnnotations);

            allCanvas.forEach(canvas => {
                const context = canvas.getContext('2d');
                pageAnnotations.forEach(ann => {
                    context.beginPath();
                    context.rect(ann.x, ann.y, ann.width, ann.height);
                    context.strokeStyle = 'red';
                    context.lineWidth = 2;
                    context.stroke();
                });
                canvas.context = context;
            });

            // const pdfDoc = await PDFDocument.create()
            // // const timesRomanFont = await pdfDoc.embedFont(StandardFonts.TimesRoman)

            // const page = pdfDoc.addPage()
            // const { width, height } = page.getSize()

            // const canvas = document.getElementById('pdfCanvas');
            // const context = canvas.getContext('2d');
            // canvas.height = height;
            // canvas.width = width;

            // const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
            // pageAnnotations.forEach(ann => {
            //     context.beginPath();
            //     context.rect(ann.x, ann.y, ann.width, ann.height);
            //     context.strokeStyle = 'red';
            //     context.lineWidth = 2;
            //     context.stroke();
            // });

            // page.draw(context);

            // console.log(width);

            // const response = await fetch(url);
            // const pdfBytes = await response.blob();

            // // Convert the Blob to an ArrayBuffer
            // const buffer = await new Response(pdfBytes).arrayBuffer();

            // // Load the PDF using pdf-lib
            // const pdfDoc = await PDFLib.PDFDocument.load(buffer);

            // const canvas = document.getElementById('pdfCanvas');
            // const context = canvas.getContext('2d');
            // const pdfPage = pdfDoc.getPages()[0];
            // pdfPage.draw(context);

            // __PDF_DOC.getPage(1).then(function(page) {
            //     const viewport = page.getViewport(1.0);
            //     canvas.height = viewport.height;
            //     canvas.width = viewport.width;

            //     // Draw PDF content from pdf-lib
            //     pdfPage.draw(context);
            //     // Draw annotations
            //     const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
            //     pageAnnotations.forEach(ann => {
            //         context.beginPath();
            //         context.rect(ann.x, ann.y, ann.width, ann.height);
            //         context.strokeStyle = 'red';
            //         context.lineWidth = 2;
            //         context.stroke();
            //     });

            //     // console.log(page.getViewport(1.0));
            // });



        }

        // Save annotations to the PDF using pdf-lib
        document.getElementById('saveButton').addEventListener('click', async () => {
            annotations.forEach(ann => {
                const page = pdfDoc.getPages()[0];
                const textAnnotation = page.drawText(ann.comment, {
                    x: ann.x,
                    y: ann.y - 10,
                    size: 10,
                    color: rgb(255, 0, 0),
                });
            });

            const pdfBytes = await pdfDoc.save();

            // Update canvas with annotations
            renderPdfWithAnnotations();
        });

        $('.show-vignette').on('click', function() {
            if ($('.vignette-column').width() == 0) {

                $('.vignette-column').css({
                    width: '100%'
                })

                $('.vignette-column').parent().parent().addClass('border-start');
            } else {

                $('.vignette-column').css({
                    width: '0px'
                })
                $('.vignette-column').parent().parent().removeClass('border-start');
            }
        });

        $('.btn-signer').on('click', function(event) {
            $.ajax({
                url: "{{ route('regidoc.ajax.signature') }}",
                method: 'get',
                success: function(data) {
                    if (data.image !== '' && data.image !== undefined) {
                        var signatureElement = createSignatureElement();
                        var imgElement = document.createElement('img');
                        $(imgElement).addClass('w-100 h-100');
                        $(imgElement).css({
                            objectFit: 'contain',
                        })
                        $(imgElement).attr('src', data.image);

                        $(signatureElement).append(imgElement);
                        signatureElement.style.left = event.clientX + 5 + 'px';
                        signatureElement.style.top = event.clientY + 5 + 'px';
                    } else {
                        newSignatureImage();
                    }
                }
            });

        });

        $('.btn-tampon').on('click', function(event) {
            $.ajax({
                url: "{{ route('regidoc.ajax.tampon') }}",
                method: 'get',
                success: function(data) {
                    if (data.image !== '' && data.image !== undefined) {
                        var signatureElement = createSignatureElement();
                        signatureElement.classList.add('tampon');
                        var imgElement = document.createElement('img');
                        $(imgElement).addClass('w-100 h-100');
                        $(imgElement).css({
                            objectFit: 'contain',
                        })
                        $(imgElement).attr('src', data.image);

                        $(signatureElement).append(imgElement);
                        signatureElement.style.left = event.clientX + 5 + 'px';
                        signatureElement.style.top = event.clientY + 5 + 'px';
                    } else {
                        newTamponImage();
                    }
                }
            });
        });


        function createSignatureElement() {
            if ($('.signature:not(.dropped-true)').length == 0) {
                var signatureElement = document.createElement('div');
                signatureElement.classList.add('signature');
                signatureElement.style.position = 'fixed';
                // signatureElement.width = '150';
                // signatureElement.height = '75';

                var removeBtn = document.createElement('button');
                removeBtn.classList.add('btn');
                removeBtn.classList.add('btn-danger');
                removeBtn.classList.add('btn-sm');
                removeBtn.classList.add('rounded-circle');
                removeBtn.classList.add('remove-btn');
                $(removeBtn).text('x');
                $(removeBtn).css({
                    position: 'absolute',
                    right: 0
                });

                $(signatureElement).append(removeBtn);

                $(signatureElement).draggable();
                $('body').append(signatureElement);

                return signatureElement;
            }
        }

        function newSignatureImage() {
            if ($('.signature:not(.dropped-true)').length == 0) {

                $('.modal-signature').find('.dessin').removeClass('d-none');
                $('.modal-signature').find('.dessin-tab').addClass('active');
                $('.modal-signature').find('.dessin-tab').addClass('show');
                $('.modal-signature').find('.dessin-tab').removeClass('d-none');

                $('.modal-signature').find('.import-image-tab').removeClass('active');
                $('.modal-signature').find('.import-image-tab').removeClass('show');
                $('.modal-signature').find('.import-image button').removeClass('active');

                $('.modal-signature').addClass('signature-modal');
                $('.modal-signature').removeClass('tampon-modal');
                $('.modal-signature').css({
                    width: '100%'
                });
            }
        }

        function newTamponImage() {
            if ($('.signature:not(.dropped-true)').length == 0) {

                $('.modal-signature').find('.dessin').addClass('d-none');
                $('.modal-signature').find('.dessin-tab').removeClass('active');
                $('.modal-signature').find('.dessin-tab').removeClass('show');
                $('.modal-signature').find('.dessin-tab').addClass('d-none');

                $('.modal-signature').find('.import-image-tab').addClass('active');
                $('.modal-signature').find('.import-image-tab').addClass('show');
                $('.modal-signature').find('.import-image button').addClass('active');

                $('.modal-signature').removeClass('signature-modal');
                $('.modal-signature').addClass('tampon-modal');
                $('.modal-signature').css({
                    width: '100%'
                });

            }
        }

        // Event handlers for tracking mouse movement on the document
        $(document).on('mousemove', function(event) {
            var signatureElement = document.querySelector('.signature:not(.dropped-true)');
            if (signatureElement !== null) {
                // console.log(signatureElement);
                // Set the position of the signature element to the current mouse position
                signatureElement.style.left = event.clientX + 5 + 'px';
                signatureElement.style.top = event.clientY + 5 + 'px';

                // signatureElement.style.left = ((event.clientX + 5) + window.scrollX) + 'px';
                // signatureElement.style.top = ((event.clientY + 5) + window.scrollY) + 'px';
            }
        });

        $("body").on("click", ".text-layer", function() {

            // Get the first draggable element (you can modify this selector based on your actual draggable elements)
            var draggableElement = $(".signature:not(.dropped-true)").first();

            // Check if the draggable element exists and is draggable
            if (draggableElement.length > 0 && draggableElement.hasClass("ui-draggable")) {

                $(draggableElement).addClass('dropped-true');
                $(draggableElement).resizable({
                    // aspectRatio: true,
                    autoHide: true,
                    handles: "n, e, s, w, ne, se, sw, nw"
                });

                $(draggableElement).css({
                    position: 'absolute',
                    left: (event.clientX) + window.scrollX + 'px',
                    top: (event.clientY) + window.scrollY + 'px'
                })

                $('.signature').find('img').on('dblclick', function() {
                    $(this).parent().addClass('active');
                    if ($(this).hasClass('tampon')) {
                        newTamponImage();
                    } else {
                        newSignatureImage();
                    }
                });

                // Simulate the drop event on the droppable area
                $(this).parent().trigger("drop", {
                    draggable: $(draggableElement),
                    helper: $(draggableElement),
                    offset: {
                        top: $(draggableElement).offset().top,
                        left: $(draggableElement).offset().left
                    },
                    position: {
                        top: $(draggableElement).offset().top,
                        left: $(draggableElement).offset().left
                    }
                });

                $('.remove-btn').on('click', function() {
                    $(this).parent().remove();
                })
            }

        });

        $('.valid-canevas').on('click', function() {
            var signatureElement = document.querySelector('.signature.dropped-true.active');
            var imgData = signaturePad.toDataURL();

            if (signatureElement !== null) {
                $.ajax({
                    url: "{{ route('regidoc.ajax.signature.save') }}",
                    method: 'post',
                    data: {
                        'image': imgData,
                    },
                    success: function(data) {
                        var imgElement = $(signatureElement).find('img');
                        imgElement.addClass('img-fluid');
                        imgElement.attr('src', data.image_url);
                        $(signatureElement).append(imgElement);
                        $('.modal-signature').css({
                            width: '0px'
                        });
                        $(signatureElement).removeClass('active');
                    }
                });
            } else {
                $.ajax({
                    url: "{{ route('regidoc.ajax.signature.save') }}",
                    method: 'post',
                    data: {
                        'image': imgData,
                    },
                    success: function(data) {
                        var signatureElement = createSignatureElement();
                        var imgElement = document.createElement('img');

                        $(imgElement).addClass('img-fluid');
                        $(imgElement).attr('src', data.image_url);

                        $(signatureElement).append(imgElement);

                        $('.modal-signature').css({
                            width: '0px'
                        });
                    }
                });
            }

        });

        $('.btn-valid-img').on('click', function() {
            var signatureElement = document.querySelector('.signature.dropped-true.active');

            const img = document.getElementById('sign-img');
            var imgData = img.src;

            var ajaxUrl = $('.modal-signature').hasClass('tampon-modal') ?
                "{{ route('regidoc.ajax.tampon.save') }}" :
                "{{ route('regidoc.ajax.signature.save') }}";
            if (signatureElement !== null) {
                $.ajax({
                    url: ajaxUrl,
                    method: 'post',
                    data: {
                        'image': imgData,
                    },
                    success: function(data) {
                        var imgElement = $(signatureElement).find('img');
                        imgElement.addClass('img-fluid');
                        imgElement.attr('src', data.image_url);
                        $(signatureElement).append(imgElement);
                        $('.modal-signature').css({
                            width: '0px'
                        });
                        $(signatureElement).removeClass('active');
                    }
                });
            } else {
                $.ajax({
                    url: ajaxUrl,
                    method: 'post',
                    data: {
                        'image': imgData,
                    },
                    success: function(data) {
                        var signatureElement = createSignatureElement();
                        var imgElement = document.createElement('img');

                        $(imgElement).addClass('img-fluid');
                        $(imgElement).attr('src', data.image_url);

                        $(signatureElement).append(imgElement);

                        $('.modal-signature').css({
                            width: '0px'
                        });
                    }
                });
            }
        });

        // Handle button click to insert an image into the PDF
        $('.save_pdf').on('click', function() {
            loadPDF(url);
        });

        async function loadPDF(url) {
            var signatureElements = document.querySelectorAll('.signature.dropped-true');

            // Fetch the PDF file from the server
            const response = await fetch(url);
            const pdfBytes = await response.blob();

            // Convert the Blob to an ArrayBuffer
            const buffer = await new Response(pdfBytes).arrayBuffer();

            // Load the PDF using pdf-lib
            const pdfDoc = await PDFLib.PDFDocument.load(buffer);

            for (var index = 0; index < signatureElements.length; index++) {
                const signatureElement = signatureElements[index];

                const pngImageBytes = await fetch($(signatureElement).find('img').attr('src')).then((res) => res
                    .arrayBuffer());
                const pngImage = await pdfDoc.embedPng(pngImageBytes)
                // const pngDims = pngImage.scale(0.5)
                const page = pdfDoc.getPages()[$(signatureElement).data('page') - 1];

                var y = $(signatureElement).data('y');
                var x = $(signatureElement).data('x');

                var imgWidth = $(signatureElement).find('img').width();
                var imgHeight = $(signatureElement).find('img').height();

                page.drawImage(pngImage, {
                    x: (x - imgWidth / 2) - 40,
                    y: (page.getHeight() - y) + imgHeight / 2,
                    width: imgWidth,
                    height: imgHeight,
                });
            }

            await pdfDoc.save().then(function(modifiedPdfBytes) {
                // Convert the modified PDF bytes to a Blob
                const modifiedPdfBlob = new Blob([
                    modifiedPdfBytes
                ], {
                    type: 'application/pdf'
                });

                var modalAction = new Bootstrap.modal(document.getElementById('modal-action-save'));
                modalAction.show();

                // $.ajax({
                //     url: ajaxUrl,
                //     method: 'post',
                //     data: {
                //         'image': imgData,
                //     },
                //     success: function(data) {
                //         var imgElement = $(signatureElement).find('img');
                //         imgElement.addClass('img-fluid');
                //         imgElement.attr('src', data.image_url);
                //         $(signatureElement).append(imgElement);
                //         $('.modal-signature').css({
                //             width: '0px'
                //         });
                //         $(signatureElement).removeClass('active');
                //     }
                // });

                // // Create a link to download the modified PDF
                // const downloadLink = document.createElement('a');
                // downloadLink.href = URL.createObjectURL(modifiedPdfBlob);
                // downloadLink.download = 'modified_pdf.pdf';

                // // Trigger the download link
                // downloadLink.click();
            });
        }
    </script>
</body>

</html>
