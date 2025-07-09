<!DOCTYPE html>
<html lang="en">

<!--
    # Project developed by Newtech Consulting SARL
    # Contact : Tél: +(243) 977 776 901
                Email: contact@newtech-rdc.net
                Adresse: 374 avenue Colonel Mondjiba C/Ngaliema, Q/Basoko, Réf/Galerie St.Pierre
                Kinshasa - RDC
-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>MaxiDoc | Gestion Électronique des Documents et Courriers</title>
    @include('regidoc.layouts.partials.head.styles')
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
            z-index: 1025;
            /* display: none; */
            /* border: 1px solid #eee; */
            width: 155px;
            height: 75px;
        }

        .signature.tampon {
            width: 175px;
            height: 175px;
        }


        .signature.dropped-true {
            border: none;
        }

        .signature.dropped-true:hover {
            border: 1px solid #eee;
        }

        .signature.dropped-true img {
            cursor: pointer;
            height: 100%;
            width: 100%;
            /* padding: 10px 0px; */
            object-fit: contain;
        }

        .signature img {
            cursor: pointer;
            height: 100%;
            width: 100%;
            /* padding: 10px 0px; */
            object-fit: contain;
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
    @php
        $docToShow = null;
        $nameDocToShow = null;
        $idDocToShow = null;
        if ($courrier->traitements->count()) {
            if ($courrier->traitements->last()->document_url) {
                $docToShow = files($courrier->traitements->last()->document_url)->link;
                $nameDocToShow = files($courrier->traitements->last()->document_url)->name;
                $idDocToShow = $courrier->traitements->last()->id;
            } else {
                $docToShow = files($courrier->document?->document)->link;
                $nameDocToShow = files($courrier->document?->document)->name;
                $idDocToShow = $courrier->document?->id;
            }
        } else {
            $docToShow = files($courrier->document?->document)->link;
            $nameDocToShow = files($courrier->document?->document)->name;
        }
    @endphp

    <div id="pdf-main-container" class="ps-0" data-doc="{{ $idDocToShow }}" data-url="{{ $docToShow }}"
        data-name="{{ $nameDocToShow }}" data-courrier="{{ $courrier->id }}">

        <div id="pdf-meta" class="nav-tools-page">
            <div class="row w-100 ms-0 align-items-center">
                <div class="col-lg-3">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('regidoc.courriers.show', $courrier) }}" class="mb-0 back me-3">
                            <i class="fi fi-rr-angle-left"></i>
                            <div class="tooltip-indicator">
                                Retour
                            </div>
                        </a>
                        <div class="name-file">
                            <p class="mb-0">
                                {{ files($courrier->document?->document)->name }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="tool-nav">
                        <div class="d-flex align-items-center justify-content-center">

                            <a href="javascript:void(0)" class="btn-tools btn btn-signer">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M9,16h1.59c1.07,0,2.07-.42,2.83-1.17L23.12,5.12c.57-.57,.88-1.32,.88-2.12s-.31-1.55-.88-2.12c-1.17-1.17-3.07-1.17-4.24,0L9.17,10.59c-.76,.76-1.17,1.76-1.17,2.83v1.59c0,.55,.45,1,1,1ZM21.71,2.29c.19,.19,.29,.44,.29,.71s-.1,.52-.29,.71l-1.29,1.29-1.41-1.41,1.29-1.29c.39-.39,1.02-.39,1.41,0ZM10,13.41c0-.53,.21-1.04,.59-1.41l7-7,1.41,1.41-7,7c-.38,.38-.88,.59-1.41,.59h-.59v-.59Zm14,9.59c0,.55-.45,1-1,1-1.54,0-2.29-1.12-2.83-1.95-.5-.75-.75-1.05-1.17-1.05-.51,0-.9,.44-1.51,1.15-.7,.83-1.57,1.85-3.03,1.85s-2.32-1.03-3-1.87c-.58-.7-.96-1.13-1.46-1.13-.39,0-.63,.25-1.16,.91-.72,.88-1.71,2.09-3.84,2.09-2.76,0-5-2.24-5-5s2.24-5,5-5c.55,0,1,.45,1,1s-.45,1-1,1c-1.65,0-3,1.35-3,3s1.35,3,3,3c1.18,0,1.67-.6,2.29-1.36,.6-.73,1.34-1.64,2.71-1.64,1.47,0,2.32,1.03,3,1.87,.58,.7,.96,1.13,1.46,1.13s.9-.44,1.51-1.15c.7-.83,1.57-1.85,3.03-1.85s2.29,1.12,2.83,1.95c.5,.75,.75,1.05,1.17,1.05,.55,0,1,.45,1,1Z" />
                                </svg>
                                <div class="tooltip-indicator">
                                    Signature
                                </div>
                            </a>

                            <a href="javascript:void(0)" class="btn btn-toolsbtn-tampon btn-tampon">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M12,24c-1.626,0-3.16-.714-4.208-1.959-1.54,.176-3.127-.405-4.277-1.555-1.149-1.15-1.729-2.74-1.59-4.362-1.211-.964-1.925-2.498-1.925-4.124s.714-3.16,1.96-4.208c-.175-1.537,.405-3.127,1.555-4.277,1.15-1.15,2.737-1.733,4.361-1.59,.964-1.21,2.498-1.925,4.124-1.925s3.16,.714,4.208,1.959c1.542-.173,3.127,.405,4.277,1.555,1.149,1.15,1.729,2.74,1.59,4.362,1.211,.964,1.925,2.498,1.925,4.124s-.714,3.16-1.96,4.208c.175,1.537-.405,3.127-1.555,4.277-1.151,1.15-2.741,1.726-4.361,1.59-.964,1.21-2.498,1.925-4.124,1.925Zm-4.127-3.924c.561,0,1.081,.241,1.448,.676,.668,.793,1.644,1.248,2.679,1.248s2.011-.455,2.679-1.248c.403-.479,.99-.721,1.616-.67,1.034,.087,2.044-.28,2.776-1.012,.731-.731,1.1-1.743,1.012-2.776-.054-.624,.19-1.213,.67-1.617,.792-.667,1.247-1.644,1.247-2.678s-.455-2.011-1.247-2.678c-.479-.403-.724-.993-.67-1.617,.088-1.033-.28-2.045-1.012-2.776s-1.748-1.094-2.775-1.012c-.626,.056-1.214-.191-1.617-.669-.668-.793-1.644-1.248-2.679-1.248s-2.011,.455-2.679,1.248c-.404,.479-.993,.719-1.616,.67-1.039-.09-2.044,.28-2.776,1.012-.731,.731-1.1,1.743-1.012,2.776,.054,.624-.19,1.213-.67,1.617-.792,.667-1.247,1.644-1.247,2.678s.455,2.011,1.247,2.678c.479,.403,.724,.993,.67,1.617-.088,1.033,.28,2.045,1.012,2.776,.732,.731,1.753,1.095,2.775,1.012,.057-.005,.113-.007,.169-.007Zm4.928-4.941l4.739-4.568c.397-.383,.409-1.017,.025-1.414-.383-.397-1.016-.409-1.414-.026l-4.752,4.581c-.391,.391-1.022,.391-1.44-.025l-2.278-2.117c-.402-.375-1.036-.353-1.413,.052-.376,.404-.353,1.037,.052,1.413l2.252,2.092c.586,.586,1.357,.879,2.126,.879,.765,0,1.526-.289,2.104-.866Z" />
                                </svg>
                                <div class="tooltip-indicator">
                                    Tampon
                                </div>
                            </a>
                            <a href="#" class="btn btn-tools">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M9,12c3.309,0,6-2.691,6-6S12.309,0,9,0,3,2.691,3,6s2.691,6,6,6Zm0-10c2.206,0,4,1.794,4,4s-1.794,4-4,4-4-1.794-4-4,1.794-4,4-4Zm1.75,14.22c-.568-.146-1.157-.22-1.75-.22-3.86,0-7,3.14-7,7,0,.552-.448,1-1,1s-1-.448-1-1c0-4.962,4.038-9,9-9,.762,0,1.519,.095,2.25,.284,.535,.138,.856,.683,.719,1.218-.137,.535-.68,.856-1.218,.719Zm12.371-4.341c-1.134-1.134-3.11-1.134-4.243,0l-6.707,6.707c-.755,.755-1.172,1.76-1.172,2.829v1.586c0,.552,.448,1,1,1h1.586c1.069,0,2.073-.417,2.828-1.172l6.707-6.707c.567-.567,.879-1.32,.879-2.122s-.312-1.555-.878-2.121Zm-1.415,2.828l-6.708,6.707c-.377,.378-.879,.586-1.414,.586h-.586v-.586c0-.534,.208-1.036,.586-1.414l6.708-6.707c.377-.378,1.036-.378,1.414,0,.189,.188,.293,.439,.293,.707s-.104,.518-.293,.707Z" />
                                </svg>
                                <div class="tooltip-indicator">
                                    Initiales
                                </div>
                            </a>
                            <a href="#" class="btn btn-tools">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M19,2h-1V1c0-.552-.448-1-1-1s-1,.448-1,1v1H8V1c0-.552-.448-1-1-1s-1,.448-1,1v1h-1C2.243,2,0,4.243,0,7v12c0,2.757,2.243,5,5,5h4c.552,0,1-.448,1-1s-.448-1-1-1H5c-1.654,0-3-1.346-3-3V10H23c.552,0,1-.448,1-1v-2c0-2.757-2.243-5-5-5Zm3,6H2v-1c0-1.654,1.346-3,3-3h14c1.654,0,3,1.346,3,3v1Zm-3.121,4.879l-5.707,5.707c-.755,.755-1.172,1.76-1.172,2.829v1.586c0,.552,.448,1,1,1h1.586c1.069,0,2.073-.417,2.828-1.172l5.707-5.707c.567-.567,.879-1.32,.879-2.122s-.312-1.555-.878-2.121c-1.134-1.134-3.11-1.134-4.243,0Zm2.828,2.828l-5.708,5.707c-.377,.378-.879,.586-1.414,.586h-.586v-.586c0-.534,.208-1.036,.586-1.414l5.708-5.707c.377-.378,1.036-.378,1.414,0,.189,.188,.293,.439,.293,.707s-.104,.518-.293,.707Zm-16.707-1.707c0-.552,.448-1,1-1h7c.552,0,1,.448,1,1s-.448,1-1,1H6c-.552,0-1-.448-1-1Zm6,4c0,.552-.448,1-1,1H6c-.552,0-1-.448-1-1s.448-1,1-1h4c.552,0,1,.448,1,1Z" />
                                </svg>
                                <div class="tooltip-indicator">
                                    Date de signature
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="gap-3 d-flex justify-content-end">
                        <button id="saveButtone" class="save_pdf btn disabled" disabled>Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-doc-pdf d-flex w-100 flex-column flex-lg-row">
            <div class="content-doc-pdf flex-grow-1">
                <div class="container-fluid">
                    <div class="row justify-items-center justify-content-center">
                        <div class="text-center col-lg-9">
                            <div id="pdf-contents" data-spy="scroll" data-target="#vignet-container" data-offset="0"
                                class="scrollspy-example text-center mx-auto">
                                <div id="pdf-loader">Loading document ...</div>

                            </div>
                        </div>
                        {{-- <div class="col-4">
                            <div class="px-2 content-doc-annot px-lg-3 d-">
                                <div class="block-anotation d-flex flex-column annot-block">
                                    <div class="item-anotation position-relative comment">
                                        {{-- <div class="dropdown position-absolute" style="right: 5px; top: 5px;">
                                            <button class="p-0 btn d-flex align-items-center justify-content-center" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="true" style="font-size: 14px; width: 28px; height: 28px">
                                                <i class="fi fi-rr-menu-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1" data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-edit-classeur-1">
                                                        <i class="fi fi-rr-edit"></i> Modifier
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-1">
                                                        <i class="fi fi-rr-trash"></i>Supprimer
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> -}}
                                        <div class="mb-2 d-flex info-user-an align-items-center">
                                            <div class="avatar">
                                                <img src="{{ asset('assets/regidoc/default.png') }}" alt="image profil">
                                            </div>
                                            <div class="content-name">
                                                <h6>John Doe</h6>
                                                {{-- <div class="date">16/05/2023</div> -}}
                                            </div>
                                        </div>
                                        <div class="content-anotation">
                                            <textarea name="" id="" cols="30" rows="3" class="form-control" placeholder="Commentaire"></textarea>
                                            <div class="mt-2 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-default">Annuler</button>
                                                <button class="btn btn-sm btn-primary">Commenter</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-anotation position-relative">
                                        <div class="dropdown position-absolute" style="right: 5px; top: 5px;">
                                            <button class="p-0 btn d-flex align-items-center justify-content-center"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="true"
                                                style="font-size: 14px; width: 28px; height: 28px">
                                                <i class="fi fi-rr-menu-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton1"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-classeur-1">
                                                        <i class="fi fi-rr-edit"></i> Modifier
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-classeur-1">
                                                        <i class="fi fi-rr-trash"></i>Supprimer
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mb-2 d-flex info-user-an">
                                            <div class="avatar">
                                                <img src="{{ asset('assets/regidoc/default.png') }}" alt="image profil">
                                            </div>
                                            <div class="content-name">
                                                <h6>John Doe</h6>
                                                <div class="date">16/05/2023</div>
                                            </div>
                                        </div>
                                        <div class="content-anotation">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita
                                                aperiam
                                                exercitationem eius? Sint ipsam possimus totam quaerat, quis animi quam
                                                labore cum
                                                nostrum, maxime voluptatum debitis. Error voluptas quas similique?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="item-anotation position-relative">
                                        <div class="dropdown position-absolute" style="right: 5px; top: 5px;">
                                            <button class="p-0 btn d-flex align-items-center justify-content-center"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="true"
                                                style="font-size: 14px; width: 28px; height: 28px">
                                                <i class="fi fi-rr-menu-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton1"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-classeur-1">
                                                        <i class="fi fi-rr-edit"></i> Modifier
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-classeur-1">
                                                        <i class="fi fi-rr-trash"></i>Supprimer
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mb-2 d-flex info-user-an">
                                            <div class="avatar">
                                                <img src="{{ asset('assets/regidoc/default.png') }}" alt="image profil">
                                            </div>
                                            <div class="content-name">
                                                <h6>John Doe</h6>
                                                <div class="date">16/05/2023</div>
                                            </div>
                                        </div>
                                        <div class="content-anotation">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita
                                                aperiam
                                                exercitationem eius? Sint ipsam possimus totam quaerat, quis animi quam
                                                labore cum
                                                nostrum, maxime voluptatum debitis. Error voluptas quas similique?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="item-anotation position-relative">
                                        <div class="dropdown position-absolute" style="right: 5px; top: 5px;">
                                            <button class="p-0 btn d-flex align-items-center justify-content-center"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                aria-expanded="true"
                                                style="font-size: 14px; width: 28px; height: 28px">
                                                <i class="fi fi-rr-menu-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="dropdownMenuButton1"
                                                data-popper-placement="bottom-end">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-edit-classeur-1">
                                                        <i class="fi fi-rr-edit"></i> Modifier
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                        data-bs-target="#modal-delete-classeur-1">
                                                        <i class="fi fi-rr-trash"></i>Supprimer
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mb-2 d-flex info-user-an">
                                            <div class="avatar">
                                                <img src="{{ asset('assets/regidoc/default.png') }}" alt="image profil">
                                            </div>
                                            <div class="content-name">
                                                <h6>John Doe</h6>
                                                <div class="date">16/05/2023</div>
                                            </div>
                                        </div>
                                        <div class="content-anotation">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita
                                                aperiam
                                                exercitationem eius? Sint ipsam possimus totam quaerat, quis animi quam
                                                labore cum
                                                nostrum, maxime voluptatum debitis. Error voluptas quas similique?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="col-2 border-start">
                            <div class="position-fixed d-flex justify-content-end">
                                <div class="vignette-column">
                                    <div id="vignet-container" class="py-3 d-flex flex-column align-items-center">
                                    </div>
                                </div>
                            </div>
                        </div> --}}
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
                <li class="nav-item nom-signature" role="presentation">
                    <button class="nav-link" id="nom-signature-tab" data-bs-toggle="pill"
                        data-bs-target="#nom-signature" type="button" role="tab" aria-controls="nom-signature"
                        aria-selected="false">Nom</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="pt-2 tab-pane dessin-tab fade show active" id="pills-home" role="tabpanel"
                    aria-labelledby="pills-home-tab" tabindex="0">
                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <div class="d-flex align-items-center me-4">
                            <span style="font-size: 14px; color: var(--colorParagraph)">Couleur</span>
                            <div class="dropdown">
                                <a href="#"
                                    class="d-flex align-items-center block-show-pallete block-show-pallete-design ms-1"
                                    id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="bubble"></div>
                                    <i class="fi fi-rr-angle-down ms-2"
                                        style="font-size: 11px; color: var(--colorTitre);"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2"
                                    data-bs-popper="none" style="min-width: 140px">
                                    <div class="block-pallete-colors block-pallete-design">
                                        <div class="content-pallete d-flex align-center flex-wrap gap-2">
                                            <div class="bubble-color active"
                                                style="--fondBubble:#000; background: var(--fondBubble)"
                                                data-color="#000"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#0f14e1; background: var(--fondBubble)"
                                                data-color="#0f14e1"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#00a4ff; background: var(--fondBubble)"
                                                data-color="#00a4ff"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#00d3a1; background: var(--fondBubble)"
                                                data-color="#00d3a1"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#ff0070; background: var(--fondBubble)"
                                                data-color="#ff0070"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#ff6c44; background: var(--fondBubble)"
                                                data-color="#ff6c44"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#ffba3b; background: var(--fondBubble)"
                                                data-color="#ffba3b"></div>
                                            <div class="bubble-color"
                                                style="--fondBubble:#d700ab; background: var(--fondBubble)"
                                                data-color="#d700ab"></div>
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            {{-- <select name="color" id="color" class="form-control form-select ms-1">
                                <option value="rgb(0, 0, 0)" selected>noir</option>
                                <option value="rgb(255, 0, 0)">rouge</option>
                                <option value="rgb(66, 133, 244)">bleu</option>
                            </select> --}}
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
                        style="border:2px dashed #e5e4ec;border-radius:12px"></canvas>

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

                <div class="pt-2 tab-pane nom-signature-pane fade" id="nom-signature" role="tabpanel"
                    aria-labelledby="nom-signature-tab" tabindex="0">
                    <div class="my-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span style="font-size: 14px; color: var(--colorParagraph)">Nom</span>
                            <input type="text" class="form-control ms-1" name="user-name" id="user-name"
                                value="{{ Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom }}">
                        </div>
                        <div class="d-flex align-items-center mx-2">
                            <span style="font-size: 14px; color: var(--colorParagraph)">Police</span>
                            <select name="police" id="color" class="form-control form-select ms-1">
                                <option value="Arty Signature" selected>Arty Signature</option>
                                <option value="Brittany Signature">Brittany Signature</option>
                                <option value="Alifiyah">Alifiyah</option>
                                <option value="Christine-Signature">Christine Signature</option>
                                <option value="Photograph Signature">Photograph Signature</option>
                                <option value="Raffa">Raffa</option>
                            </select>
                        </div>
                        <div class="d-flex flex-grow-1 justify-content-end">
                            <div class="d-flex align-items-center me-4">
                                <span style="font-size: 14px; color: var(--colorParagraph)">Couleur</span>
                                <div class="dropdown">
                                    <a href="#"
                                        class="d-flex align-items-center block-show-pallete block-show-pallete-name ms-1"
                                        id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="bubble"></div>
                                        <i class="fi fi-rr-angle-down ms-2"
                                            style="font-size: 11px; color: var(--colorTitre);"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2"
                                        data-bs-popper="none" style="min-width: 140px">
                                        <div class="block-pallete-colors block-pallete-name">
                                            <div class="content-pallete d-flex align-center flex-wrap gap-2">
                                                <div class="bubble-color active"
                                                    style="--fondBubble:#000; background: var(--fondBubble)"
                                                    data-color="#000"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#0f14e1; background: var(--fondBubble)"
                                                    data-color="#0f14e1"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#00a4ff; background: var(--fondBubble)"
                                                    data-color="#00a4ff"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#00d3a1; background: var(--fondBubble)"
                                                    data-color="#00d3a1"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#ff0070; background: var(--fondBubble)"
                                                    data-color="#ff0070"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#ff6c44; background: var(--fondBubble)"
                                                    data-color="#ff6c44"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#ffba3b; background: var(--fondBubble)"
                                                    data-color="#ffba3b"></div>
                                                <div class="bubble-color"
                                                    style="--fondBubble:#d700ab; background: var(--fondBubble)"
                                                    data-color="#d700ab"></div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                                {{-- <select name="color2" id="color" class="form-control form-select ms-1">
                                    <option value="rgb(0, 0, 0)" selected>noir</option>
                                    <option value="rgb(255, 0, 0)">rouge</option>
                                    <option value="rgb(66, 133, 244)">bleu</option>
                                </select> --}}
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center"
                        style="border:2px dashed #e5e4ec;border-radius:12px; width:100%; height:300px">
                        <div class="signature-name-container">
                            <h1 style="font-size: 80px"></h1>
                        </div>
                    </div>

                    <div class="mt-4 mb-3 d-flex justify-content-end">
                        {{-- <button class="btn btn-default clear-name">Effacer</button> --}}
                        <button class="btn btn-add valid-name">Valider</button>
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
                    <div class="d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; top:-35px;left:0;right:0;bottom:20px; background-color:rgba(255,255,255,0.95)">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 row g-lg-3 g-2">
                        <div class="col-12">
                            <label for="agent_id">Ajouter des signataires <small>(optionnel)</small></label>
                            <select name="agent_id" id="agent_id" class="form-control select2">
                                <option value="">Selectionner</option>
                                @foreach ($agents as $agent)
                                    <option value="">{{ $agent->prenom }} {{ $agent->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row g-lg-3 g-2">
                        <div class="col-12">
                            <button id="saveCourrier"
                                class="flex-row gap-3 btn btn-action-doc d-flex justify-content-center align-items-center w-100">
                                {{-- <i class="fi fi-rr-upload"></i> --}}
                                <i class="fi fi-rr-disk"></i>
                                Enregistrer le traitement
                            </button>
                        </div>
                        {{-- <div class="col-6">
                            <button id="download" class="btn btn-action-doc d-flex flex-column h-100">
                                <i class="fi fi-rr-download"></i>
                                Enregistrer et sauvegarder sur l'ordinateur
                            </button>
                        </div>
                        <div class="col-6">
                            <button id="save" class="btn btn-action-doc d-flex flex-column h-100">
                                <i class="fi fi-rr-folder-download"></i>
                                Sauvegarder dans vos documents
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-error" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Erreur</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex loader-card justify-content-center">
                        <div class="m-auto text-center">
                            <p>Veuillez tout d'abord poser une action</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-sm fade" id="modal-password" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                {{-- <div class="modal-header ">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
                <div class="modal-body pt-0">
                    <div class="d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; top:-35px;left:0;right:0;bottom:20px; background-color:rgba(255,255,255,0.95)">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-lg-2 g-2">
                        <div class="col-12">
                            <input type="text" name="pass" id="pass">
                            <input type="hidden" name="imgData" id="imgData">
                            <i class="fi fi-rr-envelope-download icon-modal"></i>
                            <h5 style="font-size: 20px">Veuillez consulter votre boite de réception.</h5>
                            <p style="font-size: 16px">ddUn code de confirmation temporaire a été envoyé à
                                <span style="color: var(--colorTitre); font-family: 'Roboto-bold')">
                                    {{ Auth::user()->email }}
                                </span>
                            </p>
                        </div>
                        <div class="col-12 position-relative">
                            <input type="password" class="form-control form-control-validation input-password"
                                placeholder="Mot de passe" name="password" id="password" style="height: 44px;">
                            {{-- <i class="fi fi-rr-lock-alt position-absolute icon-form"></i> --}}
                            <div class="btn-show-password show-password" id="show-password">
                                <div>
                                    <i class="fi fi-rr-eye"></i>
                                    <i class="fi fi-rr-eye-crossed"></i>
                                </div>
                                <div class="tooltip-team">
                                    <span>Voir</span>
                                    <span>Cacher</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="error-message">
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="javascript:void(0)" class="link resend-code"
                                style="font-size: 14px; color:var(--primaryColor)">Renvoyer mon code</a>
                        </div>
                        <div class="col-12 text-end">
                            <button class="btn btn-add btn-valid-password">Suivant</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="waiting-password" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="d-flex align-items-center flex-column"
                        style="background-color:rgba(255,255,255,0.95)">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                        <p class="text-center">Veillez patienter, <br> nous préparons votre espace
                            <strong>eSignature</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('regidoc.layouts.partials.head.scripts')
    {{-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script> --}}
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
    <script src="{{ asset('vendor/jsPDF/html2canvas.min.js') }}"></script>
    <script src="{{ asset('assets/js/showPDF.js') }}"></script>
    <script src="{{ asset('assets/js/signature.js') }}"></script>

    <script>
        const btnShowPassword = document.querySelectorAll('.show-password');
        btnShowPassword.forEach(btnClick => {
            $(btnClick).click(function() {
                $(this).toggleClass('show');
                const inputPassword = $(this).parent().find('.input-password');
                if ($(inputPassword).attr('type') == 'password') {
                    $(inputPassword).attr('type', 'text')
                } else {
                    $(inputPassword).attr('type', 'password')
                }
            });
        });

        bootstrap.Modal.prototype.enforceFocus = function() {
            $(document)
                .off('focusin.bs.modal') // guard against infinite focus loop
                .on('focusin.bs.modal', $.proxy(function(e) {
                    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                        this.$element.focus()
                    }
                }, this));
        }

        $('.select2').select2({
            tags: $(this).data('tags') ? $(this).data('tags') : false,
            placeholder: $(this).data('placeholder'),
            language: "fr",
            maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
            width: "100%",
            dropdownParent: $('#modal-action-save')
        });



        document.addEventListener('livewire:load', () => {
            Livewire.onPageExpired((response, message) => {
                location.reload()
            })
        })
    </script>
</body>

</html>
