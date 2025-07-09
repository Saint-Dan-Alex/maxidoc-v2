<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
    {{-- @include('regidoc.layouts.partials.head.styles')
    <script src="{{ asset('assets/js/pdfjs/pdf.js') }}"></script>
    <script src="{{ asset('assets/js/pdfjs/pdf.worker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.16.0/pdf-lib.min.js"></script>
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
            overflow-x: scroll;
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
            background: #dd5500;
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
            width: 0px;
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
            border: 1px solid #eee;
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
    </style> --}}
</head>

<body>
    @php
        // redirect the user to the home page
        // (new \App\Http\Controllers\HomeController)->redirectUserToHomePage();
    @endphp
    <script>
        // redirect to a page
        redirect('/')
        function redirect(url) {
            window.location.href = url;
        }

    </script>
    {{-- @php
        dd(Storage::files('public/images/August2023')[0]);
    @endphp --}}
    {{-- <div class="sidebar">
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
                        <a href="{{-- route('archives') -}}"
                            class="{{ request()->is('archives/classeurs') ? 'active' : '' }}">
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
                        <a href="#">
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
                </div> -}}
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
                    </div> -}}
                    <div class="name-file">
                        <p class="mb-0">
                            <i class="fi fi-rr-file"></i> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fuga
                            eum ut sint?
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="gap-3 d-flex justify-content-end">
                        <button class="save_pdf btn ">Enregistrer</button>
                        <div class="border-start">
                            <button class="btn show-vignette">
                                <i class="fi-sr-file"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="text-center col-lg-10">
                    <div id="pdf-contents" data-spy="scroll" data-target="#vignet-container" data-offset="0"
                        class="scrollspy-example">
                        <div id="pdf-loader">Loading document ...</div>
                        {{-- <canvas id="pdf-canvas" class="w-100"></canvas> --}}
                        {{-- <canvas id="pdf-canvas" width="743px"></canvas> --}}
                        {{-- <div class="text-layer"></div> --}}
                        {{-- <div class="image-container">
                            <img src="#" alt="signature" class="sign-img">
                        </div> --}}
                        {{-- <div id="page-loader">Loading page ...</div> -}}
                    </div>

                </div>
                <div class="col-2">
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
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Dessiner</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Image</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="pt-2 tab-pane fade show active" id="pills-home" role="tabpanel"
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
                <div class="pt-3 tab-pane fade" id="pills-profile" role="tabpanel"
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

    @include('regidoc.layouts.partials.head.scripts')
    {{-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script> -}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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

        let __PDF_DOC,
            __CURRENT_PAGE,
            __TOTAL_PAGES,
            __PAGE_RENDERING_IN_PROGRESS = 0;

        var url = "{{ asset('assets/pdfs/documents/2.pdf') }}";

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
                // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
                const ratio = Math.max(window.devicePixelRatio || 1, 1);

                // console.log(page.getViewport(1).width);
                canvas.width = page.getViewport(1).width;

                var scale_required = canvas.width / page.getViewport(1).width * ratio;
                //__CANVAS.width / page.getViewport(1).width;


                // Get viewport of the page at required scale
                var viewport = page.getViewport(scale_required);

                // Set canvas height
                canvas.height = viewport.height;

                var renderContext = {
                    canvasContext: canvas.getContext('2d'),
                    viewport: viewport
                };

                // Render the page contents in the canvas
                page.render(renderContext).then(function() {
                    __PAGE_RENDERING_IN_PROGRESS = 0;

                    // Re-enable Prev & Next buttons
                    // $("#pdf-next, #pdf-prev").removeAttr('disabled');

                    // Show the canvas and hide the page loader
                    // $("#pdf-canvas").show();
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

                var scale_vignette_required = vignetteCanvas.width / page.getViewport(1).width * ratio;

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
                    if (data.image !== '') {
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
                $('.modal-signature').css({
                    width: '100%'
                });
            }
        }

        function saveImage(image) {
            $.ajax({
                url: "test.html",
                method: 'post',
                success: function(data) {}
            });
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
                    $(this).addClass('active');
                    $('.modal-signature').css({
                        width: '100%',
                    });
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
            const img = document.getElementById('sign-img');
            var imgData = img.src;
            var imgElement = document.createElement('img');

            var signatureElement = document.querySelector('.signature:not(.dropped-true).active');
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
                        $('.modal-signature').addClass('d-none');
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

                        imgElement.addClass('img-fluid');
                        imgElement.attr('src', data.image_url);

                        $(signatureElement).append(imgElement);

                        signatureElement.style.left = event.clientX + 5 + 'px';
                        signatureElement.style.top = event.clientY + 5 + 'px';

                        $('.modal-signature').addClass('d-none');
                    }
                });
            }

            // $('.sign-img').attr('src', imgData);
            // $('.modal-signature').addClass('d-none');

            // var canvas_offset = $("#pdf-contents").offset();

            // $(".sign-img").imageResize();
            // $(".jQuery-image-resize").draggable({
            //     appendTo: "#pdf-contents",
            //     scroll: true,
            //     containment: [canvas_offset.left, canvas_offset.top + 50, canvas_offset.left + (__CANVAS
            //         .width - $(".jQuery-image-resize").width()), __CANVAS.height],
            //     cursor: "crosshair"
            // });

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
                    x: x,
                    y: (page.getHeight() - y) - imgHeight,
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

                // Create a link to download the modified PDF
                const downloadLink = document.createElement('a');
                downloadLink.href = URL.createObjectURL(modifiedPdfBlob);
                downloadLink.download = 'modified_pdf.pdf';

                // Trigger the download link
                downloadLink.click();
            });
        }
    </script> --}}
</body>

</html>
