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
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.05), -2px -2px 5px rgba(0, 0, 0, 0.05);
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
            overflow-x: auto;
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
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.05), -2px -2px 5px rgba(0, 0, 0, 0.05);
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
            object-fit: contain;
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
            /* overflow: hidden; */
            /* width: 100%; */
            /* padding: 0; */
            transition: .3s ease-in-out;
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

        .pdf-canvas {
            max-width: 100%;
        }

        .text-layer {
            max-width: 100%;
        }

        .back-overplay {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1031;
            display: none;
            opacity: 0;
            visibility: hidden;
            transition: .3s;
            pointer-events: none;
        }

        .sidebar {
            z-index: 1032;

        }

        .back-overplay.show {
            opacity: 1;
            visibility: visible;
            pointer-events: visible;
        }

        .close-parent {
            color: var(--colorParagraph);
            font-size: 14px;
        }

        .menu-action {
            width: 32px;
            height: 32px;
            align-items: center;
            justify-content: center;
            color: var(--colorTitre);
            cursor: pointer;
        }

        @media(max-width: 567px) {
            #pdf-contents {
                min-width: 100% !important;
            }

            .sidebar {
                width: 90% !important;
            }

            .back-overplay {
                display: block;
            }

            #pdf-main-container .nav-tools-page .save_pdf,
            #pdf-main-container .nav-tools-page .btn-conf-on {
                width: 50%;
            }

            .annotation-btn-float {
                position: fixed;
                bottom: 20px;
                border: none !important;
                right: 20px;
            }

            .annotation-btn-float .btn {
                background: var(--primaryColor);
                color: white;
                border-radius: 8px;
            }

            .annotation-btn-float .btn .tooltip-btn {
                display: none;
            }

            .all-annot {
                position: fixed !important;
                top: 0 !important;
                right: 0;
                height: 100% !important;
                width: 90%;
                z-index: 1032;
                background: var(--bg-card);
                padding: 20px;
                opacity: 0;
                transform: translateX(100%);
                transition: .3s;
            }

            .all-annot.show {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    @php
        if ($isTraitement) {
            $docToShow = str_replace('\\', '/', files($doc->document_url)->link);
            $nameDocToShow = files($doc->document_url)->name;
            $idDocToShow = $doc->id;
        } else {
            $docToShow = str_replace('\\', '/', files($doc->document)->link);
            $nameDocToShow = files($doc->document)->name;
            $idDocToShow = $doc->id;
        }
    @endphp

    {{-- <div class="sidebar">
        <div class="px-3 py-3 logo text-start d-flex align-items-center justify-content-between">
            <h6 class="mb-0">Aperçu du document</h6>
            <div class="dropdown">
                <button class="p-0 btn d-flex align-items-center justify-content-center" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="true" style="font-size: 14px; width: 28px; height: 28px">
                    <i class="fi fi-rr-menu-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1" data-popper-placement="bottom-end">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-edit-classeur-1">
                            Partager ce document
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal-delete-classeur-1">
                            Historique des activités
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content-sidebar">

            <div class="block-links">
                <ul class="lists">
                    <li>
                        <a href="#">
                            <span>
                                <i class="fi fi-rr-pencil fi-rr"></i>
                            </span>
                            <span class="title">
                                Assigner à une direction
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span>
                                <i class="fi fi-rr-box fi-rr"></i>
                            </span>
                            <span class="title">
                                Assigner à un agent
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="javascript:void(0)">
                            <span>
                                <i class="fi fi-rr-pencil fi-rr"></i>
                            </span>
                            <span class="title">
                                Signer le document
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="#">
                            <span>
                                <i class="fi fi-rr-info fi-rr"></i>
                            </span>
                            <span class="title">Détails du document
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <a href="#" class="link-action">
            <div class="card card-sm pointer" data-bs-toggle="modal" data-bs-target="#modal-new-task">
                <div class="text-center">
                    <span>
                       Classer le document
                    </span>
                </div>
            </div>
        </a>
    </div> --}}

    <div id="pdf-main-container" class="ps-0" data-original="{{ $is_original }}" data-doc="{{ $idDocToShow }}"
        data-url="{{ $docToShow }}" data-name="{{ $nameDocToShow }}" data-tache="{{ $tache?->id }}"
        data-courrier="{{ $courrier?->id }}" data-traitement="{{ $isTraitement }}">

        <div id="pdf-meta" class="nav-tools-page">
            <div class="row w-100 ms-0 align-items-center">
                {{-- <div class="col-lg-4">
                    <div class="name-file">
                        <p class="mb-0">
                            <i class="fi fi-rr-file"></i> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fuga eum ut sint?
                        </p>
                    </div>
                </div> --}}
                <div class="col-lg-3">
                    <div class="d-flex align-items-center">
                        <a href="javascript:history.back()" class="back mb-0 me-3">
                            <i class="fi fi-rr-angle-left"></i>
                            <div class="tooltip-indicator">
                                Retour
                            </div>
                        </a>
                        <div class="name-file w-75">
                            <p class="mb-0 text-truncate">
                                {{ $nameDocToShow }}
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
                                    Signer
                                </div>
                            </a>

                            {{-- <a href="javascript:void(0)" class="btn btn-toolsbtn-tampon btn-tampon">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M12,24c-1.626,0-3.16-.714-4.208-1.959-1.54,.176-3.127-.405-4.277-1.555-1.149-1.15-1.729-2.74-1.59-4.362-1.211-.964-1.925-2.498-1.925-4.124s.714-3.16,1.96-4.208c-.175-1.537,.405-3.127,1.555-4.277,1.15-1.15,2.737-1.733,4.361-1.59,.964-1.21,2.498-1.925,4.124-1.925s3.16,.714,4.208,1.959c1.542-.173,3.127,.405,4.277,1.555,1.149,1.15,1.729,2.74,1.59,4.362,1.211,.964,1.925,2.498,1.925,4.124s-.714,3.16-1.96,4.208c.175,1.537-.405,3.127-1.555,4.277-1.151,1.15-2.741,1.726-4.361,1.59-.964,1.21-2.498,1.925-4.124,1.925Zm-4.127-3.924c.561,0,1.081,.241,1.448,.676,.668,.793,1.644,1.248,2.679,1.248s2.011-.455,2.679-1.248c.403-.479,.99-.721,1.616-.67,1.034,.087,2.044-.28,2.776-1.012,.731-.731,1.1-1.743,1.012-2.776-.054-.624,.19-1.213,.67-1.617,.792-.667,1.247-1.644,1.247-2.678s-.455-2.011-1.247-2.678c-.479-.403-.724-.993-.67-1.617,.088-1.033-.28-2.045-1.012-2.776s-1.748-1.094-2.775-1.012c-.626,.056-1.214-.191-1.617-.669-.668-.793-1.644-1.248-2.679-1.248s-2.011,.455-2.679,1.248c-.404,.479-.993,.719-1.616,.67-1.039-.09-2.044,.28-2.776,1.012-.731,.731-1.1,1.743-1.012,2.776,.054,.624-.19,1.213-.67,1.617-.792,.667-1.247,1.644-1.247,2.678s.455,2.011,1.247,2.678c.479,.403,.724,.993,.67,1.617-.088,1.033,.28,2.045,1.012,2.776,.732,.731,1.753,1.095,2.775,1.012,.057-.005,.113-.007,.169-.007Zm4.928-4.941l4.739-4.568c.397-.383,.409-1.017,.025-1.414-.383-.397-1.016-.409-1.414-.026l-4.752,4.581c-.391,.391-1.022,.391-1.44-.025l-2.278-2.117c-.402-.375-1.036-.353-1.413,.052-.376,.404-.353,1.037,.052,1.413l2.252,2.092c.586,.586,1.357,.879,2.126,.879,.765,0,1.526-.289,2.104-.866Z" />
                                </svg>
                                <div class="tooltip-indicator">
                                    Tampon
                                </div>
                            </a> --}}
                            <a href="#" class="btn btn-tools btn-paraphe">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M9,12c3.309,0,6-2.691,6-6S12.309,0,9,0,3,2.691,3,6s2.691,6,6,6Zm0-10c2.206,0,4,1.794,4,4s-1.794,4-4,4-4-1.794-4-4,1.794-4,4-4Zm1.75,14.22c-.568-.146-1.157-.22-1.75-.22-3.86,0-7,3.14-7,7,0,.552-.448,1-1,1s-1-.448-1-1c0-4.962,4.038-9,9-9,.762,0,1.519,.095,2.25,.284,.535,.138,.856,.683,.719,1.218-.137,.535-.68,.856-1.218,.719Zm12.371-4.341c-1.134-1.134-3.11-1.134-4.243,0l-6.707,6.707c-.755,.755-1.172,1.76-1.172,2.829v1.586c0,.552,.448,1,1,1h1.586c1.069,0,2.073-.417,2.828-1.172l6.707-6.707c.567-.567,.879-1.32,.879-2.122s-.312-1.555-.878-2.121Zm-1.415,2.828l-6.708,6.707c-.377,.378-.879,.586-1.414,.586h-.586v-.586c0-.534,.208-1.036,.586-1.414l6.708-6.707c.377-.378,1.036-.378,1.414,0,.189,.188,.293,.439,.293,.707s-.104,.518-.293,.707Z" />
                                </svg>

                                <div class="tooltip-indicator">
                                    Parapher
                                </div>
                            </a>
                            <a href="javascript:void(0)" href="#" class="btn btn-tools btn-edit-sign">
                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="m22.698,15.704c.209.773.104,1.583-.295,2.277s-1.046,1.192-1.819,1.4c-.772.208-1.583.104-2.277-.295l-.449-.259c-.842.72-1.811,1.279-2.857,1.649v.522c0,1.654-1.346,3-3,3s-3-1.346-3-3v-.522c-1.047-.37-2.016-.93-2.857-1.649l-.45.259c-.693.398-1.503.503-2.276.295s-1.42-.706-1.819-1.401c-.399-.693-.504-1.503-.295-2.276.208-.773.706-1.42,1.401-1.819l.45-.259c-.102-.543-.153-1.088-.153-1.626s.052-1.083.153-1.626l-.451-.259c-.694-.399-1.192-1.046-1.4-1.819-.209-.773-.104-1.583.295-2.277s1.046-1.192,1.819-1.4c.771-.209,1.583-.104,2.277.295l.449.259c.842-.72,1.811-1.279,2.857-1.649v-.522c0-1.654,1.346-3,3-3,1.067,0,2.063.574,2.598,1.499.277.479.113,1.09-.364,1.366-.481.278-1.092.113-1.366-.364-.179-.31-.511-.501-.867-.501-.552,0-1,.448-1,1v1.262c0,.456-.309.854-.75.968-1.237.32-2.361.969-3.25,1.877-.319.326-.818.394-1.213.168l-1.091-.627c-.231-.133-.498-.169-.759-.099-.258.069-.474.235-.606.467-.134.232-.169.501-.099.759.069.258.235.474.467.606l1.094.629c.395.228.586.693.465,1.133-.171.621-.258,1.246-.258,1.857s.087,1.236.258,1.857c.121.439-.07.905-.465,1.133l-1.093.629c-.232.133-.398.349-.468.606-.07.258-.035.526.099.758.133.232.349.398.606.468.259.069.527.034.758-.099l1.092-.627c.393-.226.893-.16,1.213.168.889.908,2.013,1.557,3.25,1.877.441.113.75.512.75.968v1.262c0,.552.448,1,1,1s1-.448,1-1v-1.262c0-.456.309-.854.75-.968,1.237-.32,2.361-.969,3.25-1.877.319-.326.82-.393,1.213-.168l1.091.627c.232.134.499.169.759.099.258-.069.474-.235.606-.467.134-.232.169-.501.099-.759-.069-.258-.235-.474-.467-.606l-1.094-.629c-.395-.228-.586-.693-.465-1.133.171-.621.258-1.246.258-1.857,0-.553.447-1,1-1s1,.447,1,1c0,.538-.052,1.083-.153,1.626l.451.259c.694.399,1.192,1.046,1.4,1.819Zm.423-10.583l-7.414,7.414c-.944.944-2.2,1.465-3.535,1.465h-1.172c-.553,0-1-.447-1-1v-1.172c0-1.335.521-2.591,1.465-3.535L18.879.879c1.17-1.17,3.072-1.17,4.242,0s1.17,3.072,0,4.242Zm-3.724.896l-1.414-1.414-5.104,5.104c-.559.559-.879,1.332-.879,2.121v.172h.172c.789,0,1.562-.32,2.121-.879l5.104-5.104Zm2.31-3.724c-.391-.391-1.023-.391-1.414,0l-.896.896,1.414,1.414.896-.896c.39-.39.39-1.024,0-1.414Z" />
                                </svg>
                                <div class="tooltip-indicator">
                                    Editer la signature
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="gap-3 d-flex justify-content-end">
                        <button id="saveButtone" class="save_pdf btn disabled" disabled>Enregistrer</button>
                        {{-- <form action="{{ route('regidoc.courriers.saveSignature', $courrier->id) }}" method="post"
                            enctype="multipart/form-data" id="form_to_sumit">
                            @csrf
                            <input type="file" name="new_pdf" id="new_pdf_data" class="d-none">
                        </form>
                        <div class="border-start">
                            <button class="btn show-vignette">
                                <i class="fi fi-rr-menu-burger"></i>
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="container-doc-pdf d-flex w-100 flex-column flex-lg-row">
            <div class="content-doc-pdf flex-grow-1">
                <div class="container-fluid">
                    <div class="row justify-content-center">
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

        {{-- <div class="container-fluid">
            <div class="row justify-content-end">

                <div class="col-lg-3 border-start">

                    <div class="position-fixed d-flex justify-content-end">
                        <div class="vignette-column">
                            <div id="vignet-container" class="py-3 d-flex flex-column align-items-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="modal-paraphe position-fixed d-flex align-items-center justify-content-center"
        style="left:0;right:0;top:0;bottom:0;background: rgba(0, 0, 0, 0.5); z-index: 99999; width:0%; overflow:hidden">
        <div class="p-4 bg-white border rounded-lg w-50 block-content-modal position-relative">
            <button type="button" class="btn-close" style="z-index: 10"></button>
            <h5 class="mt-2 mb-4">Parapher le document</h5>
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item dessin" role="presentation">
                    <button class="nav-link active" id="paraphe-dessin-tab" data-bs-toggle="pill"
                        data-bs-target="#paraphe-dessin" type="button" role="tab" aria-controls="paraphe-dessin"
                        aria-selected="true">Paraphe</button>
                </li>
                <li class="nav-item paraphe-nom" role="presentation">
                    <button class="nav-link" id="paraphe-nom-tab" data-bs-toggle="pill" data-bs-target="#paraphe-nom"
                        type="button" role="tab" aria-controls="paraphe-nom"
                        aria-selected="false">Initiaux</button>
                </li>
            </ul>
            <div class="tab-content" id="paraphe-tabContent">
                <div class="pt-2 tab-pane paraphe-dessin-tab fade show active" id="paraphe-dessin" role="tabpanel"
                    aria-labelledby="paraphe-dessin-tab" tabindex="0">
                    <div class="mb-3 d-flex justify-content-end align-items-center">
                        <div class="d-flex align-items-center me-4">
                            <span style="font-size: 14px; color: var(--colorParagraph)">Couleur</span>
                            <div class="dropdown">
                                <a href="#"
                                    class="d-flex align-items-center block-show-pallete block-show-pallete-design ms-1"
                                    id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="bubble"></div>
                                    <i class="fi fi-rr-angle-down ms-2"
                                        style="font-size: 11px; color: var(--colorTitre);"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton3"
                                    data-bs-popper="none" style="min-width: 140px">
                                    <div class="block-pallete-colors block-pallete-design-paraphe">
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

                    <canvas id="canvas_paraphe_pad" height="150px" width="586px"
                        style="border:2px dashed #e5e4ec;border-radius:12px"></canvas>

                    <div class="mt-4 mb-3 d-flex justify-content-end">
                        <button class="btn btn-default clear-canevas">Effacer</button>
                        <button class="btn btn-add valid-canevas2">Valider</button>
                    </div>

                </div>

                <div class="pt-2 tab-pane paraphe-nom-pane fade" id="paraphe-nom" role="tabpanel"
                    aria-labelledby="paraphe-nom-tab" tabindex="0">
                    <div class="my-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @php
                                $name = '';
                                if (Auth::user()->agent->prenom) {
                                    $name .= Auth::user()->agent->prenom[0];
                                }
                                if (Auth::user()->agent->nom) {
                                    $name .= Auth::user()->agent->nom[0];
                                }
                                if (Auth::user()->agent->post_nom) {
                                    $name .= Auth::user()->agent->post_nom[0];
                                }
                            @endphp
                            <span style="font-size: 14px; color: var(--colorParagraph)">Nom</span>
                            <input type="text" class="form-control ms-1" name="user-name" id="user-name-paraphe"
                                value="{{ $name }}">
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
                        <div class="signature-name-container2">
                            <h1 style="font-size: 80px"></h1>
                        </div>
                    </div>

                    <div class="mt-4 mb-3 d-flex justify-content-end">
                        <button class="btn btn-add valid-name2">Valider</button>
                    </div>
                </div>
            </div>
            <div class="d-none paraphe-loader d-flex align-items-center flex-column w-100 h-100 position-absolute justify-content-center"
                style="background-color:rgba(255,255,255,0.98); top:0;left:0;right:0;bottom:0;border-radius: 24px;z-index:9">
                <div class="text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <p class="text-center">Veillez patienter, nous préparons votre
                    <strong>Paraphe</strong>
                </p>
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
                        <button class="btn btn-add btn-change">Enregistrer</button>
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
                            <input type="text" class="form-control ms-1" name="user-name" id="user-name-signature"
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
            <div class="d-none signature-loader d-flex align-items-center flex-column w-100 h-100 position-absolute justify-content-center"
                style="background-color:rgba(255,255,255,0.98); top:0;left:0;right:0;bottom:0;border-radius: 24px;z-index:9">
                <div class="text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only"></span>
                    </div>
                </div>
                <p class="text-center">Veillez patienter, nous préparons votre
                    <strong>Signature</strong>
                </p>
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

                    <div class="row g-lg-3 g-2">
                        <div class="col-12">
                            @if ($tache)
                                <button id="saveTache"
                                    class="flex-row gap-3 btn btn-action-doc d-flex justify-content-center align-items-center w-100">
                                    <i class="fi fi-rr-disk"></i>
                                    Enregistrer le traitement
                                </button>
                            @else
                                <button id="saveCourrier"
                                    class="flex-row gap-3 btn btn-action-doc d-flex justify-content-center align-items-center w-100">
                                    <i class="fi fi-rr-disk"></i>
                                    Enregistrer le traitement
                                </button>
                            @endif
                        </div>
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
                            <p>Veuillez d'abord poser une action</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-esignature fade" id="modal-password" tabindex="-1" aria-labelledby="exampleModalLabel">
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
                            <input type="hidden" name="action" id="action">
                            <input type="hidden" name="pass" id="pass">
                            <input type="hidden" name="imgData" id="imgData">



                            <div class="row">
                                <div class="col-2">
                                    <div class="icon-esignature ">
                                        <img src="{{ asset('assets/regidoc/security-icon-maxidoc.png') }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="col-10 modal-esignature-title">
                                    <h5 style="font-size: 20px">Veuillez consulter votre boite de réception.</h5>
                                </div>
                            </div>
                            {{-- <i class="fi fi-rr-envelope-download icon-modal"></i> --}}

                            <p class=" modal-esignature-textHelp" style="font-size: 16px">Un code de confirmation
                                temporaire a été envoyé à {{ Auth::user()->email }}
                                {{-- <span >
                                    
                                </span> --}}
                            </p>
                        </div>
                        <div class="col-12 code-confirmation-box  position-relative">
                            {{-- <input type="password" class="form-control form-control-validation input-password"
                                name="password" id="password" style="height: 46px; width:100%"> --}}


                            <input type="text" maxlength="1" size="1" min="0" max="9"
                                class="form-control form-control-validation input-password" name="passwordNumber1"
                                id="passwordNumber1" pattern="[0-9]{1}">
                            <input type="text" maxlength="1" size="1" min="0" max="9"
                                class="form-control form-control-validation input-password" name="passwordNumber2"
                                id="passwordNumber2" pattern="[0-9]{1}">
                            <input type="text" maxlength="1" size="1" min="0" max="9"
                                class="form-control form-control-validation input-password" name="passwordNumber3"
                                id="passwordNumber3" pattern="[0-9]{1}">
                            <input type="text" maxlength="1" size="1" min="0" max="9"
                                class="form-control form-control-validation input-password" name="passwordNumber4"
                                id="passwordNumber4" pattern="[0-9]{1}">
                            <input type="text" maxlength="1" size="1" min="0" max="9"
                                class="form-control form-control-validation input-password" name="passwordNumber5"
                                id="passwordNumber5" pattern="[0-9]{1}">

                            <input type="text" maxlength="1" size="1" min="0" max="9"
                                class="form-control form-control-validation input-password" name="passwordNumber6"
                                id="passwordNumber6" pattern="[0-9]{1}">




                            {{-- <i class="fi fi-rr-lock-alt position-absolute icon-form"></i> --}}
                            {{-- <div class="btn-show-password show-password" id="show-password">
                                <div>
                                    <i class="fi fi-rr-eye"></i>
                                    <i class="fi fi-rr-eye-crossed"></i>
                                </div>
                                <div class="tooltip-team">
                                    <span>Voir</span>
                                    <span>Cacher</span>
                                </div>
                            </div> --}}
                        </div>
                        <div class="col-12 error-message-modal-esignature-box-hidden">
                            <span class="error-message-modal-esignature-box-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M12 16.462q.262 0 .439-.177q.176-.177.176-.439q0-.261-.177-.438T12 15.23t-.438.177t-.177.438t.177.439t.438.177m0-3.308q.214 0 .357-.144t.143-.356v-5q0-.213-.144-.356t-.357-.144t-.356.144t-.143.356v5q0 .212.144.356t.357.144M12.003 21q-1.867 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.709-3.51Q4.417 6.85 5.63 5.634t2.857-1.925T11.997 3t3.51.709q1.643.708 2.859 1.922t1.925 2.857t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709M12 20q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8" />
                                </svg>
                            </span>
                            <div class="error-message">
                            </div>
                        </div>
                        <div class="col-12">
                            <a href="javascript:void(0)" class="link resend-code"
                                style="font-size: 14px; color:var(--primaryColor)">Renvoyer mon code</a>
                        </div>
                        <div class="col-12 text-end d-flex justify-content-center align-items-center g-3 gap-3">
                            <a class="btn btn-cansel flex-grow-1" href="javascript:history.back()" class="back mb-0">
                                Retour
                            </a>
                            <button class="btn btn-next-esignature  btn-valid-password flex-grow-1">Suivant</button>
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
                {{-- <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Mot de passe</span>
                    </h5>
                </div> --}}
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

        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        bootstrap.Modal.prototype.enforceFocus = function() {
            $(document)
                .off('focusin.bs.modal') // guard against infinite focus loop
                .on('focusin.bs.modal', $.proxy(function(e) {
                    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                        this.$element.focus()
                    }
                }, this));
        }

        // $('.select2').select2({
        //     tags: $(this).data('tags') ? $(this).data('tags') : false,
        //     placeholder: $(this).data('placeholder'),
        //     language: "fr",
        //     maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') : null,
        //     width: "100%",
        //     dropdownParent: $('#modal-action-save')
        // });

        // const canvas = document.getElementById("canvas_signature_pad");
        // const signaturePad = new SignaturePad(canvas);

        // function initSignaturePad() {
        //     signaturePad.minWidth = 1.6;
        //     signaturePad.maxWidth = 2.5;
        //     signaturePad.penColor = $('.block-pallete-design .bubble-color').data('color');
        //     resizeCanvas();
        // }
        // initSignaturePad()

        // function resizeCanvas() {
        //     const ratio = Math.max(window.devicePixelRatio || 1, 1);

        //     canvas.width = canvas.offsetWidth * ratio;
        //     canvas.height = canvas.offsetHeight * ratio;
        //     canvas.getContext("2d").scale(ratio, ratio);
        //     signaturePad.clear();
        //     // otherwise isEmpty() might return incorrect value
        //     // console.log(document.getElementById("pills-profile").getBoundingClientRect());
        //     canvas.width = $('#pills-home').width() //"586";
        //     canvas.height = $('#pills-home').width() / 3; //"150";
        //     $('.block-up-img').css({
        //         height: ($('#pills-profile').width() / 3) + "px"
        //     })
        // }

        // window.addEventListener("resize", resizeCanvas);

        // $('.block-pallete-design .bubble-color').on('click', function() {
        //     $('.block-pallete-design .bubble-color').removeClass('active')
        //     $(this).addClass('active')
        //     signaturePad.penColor = $(this).data('color');
        //     $('.block-show-pallete-design .bubble').css({
        //         background: $(this).data('color'),
        //     })
        // });


        // $('.clear-canevas').on('click', function() {
        //     signaturePad.clear();
        // });

        // $('.signature-name-container h1').css({
        //     fontFamily: "" + $('select[name="police"]').val(),
        //     fontSize: $('select[name="police"]').val() == 'Arty Signature' ? '180px' : '80px',
        //     color: $('select[name="color2"]').val()
        // }).text($('input[name="user-name"]').val())

        // $('select[name="police"]').on('change', function() {
        //     $('.signature-name-container h1').css({
        //         fontFamily: "" + $('select[name="police"]').val(),
        //         fontSize: $('select[name="police"]').val() == 'Arty Signature' ? '180px' : '80px'
        //     })
        // })

        // $('.block-pallete-name .bubble-color').on('click', function() {
        //     $('.block-pallete-name .bubble-color').removeClass('active')
        //     $(this).addClass('active')
        //     $('.signature-name-container h1').css({
        //         color: $(this).data('color')
        //     })
        //     $('.block-show-pallete-name .bubble').css({
        //         background: $(this).data('color'),
        //     })
        // });
        // $('input[name="user-name"]').on('keyup', function() {
        //     console.log($(this).val());
        //     $('.signature-name-container h1').text($(this).val())
        // })

        // $('.btn-close').click(function() {
        //     $('.signature.dropped-true.active').removeClass('active');
        //     $('.modal-signature').css({
        //         width: '0px'
        //     });
        // })

        // const input = document.getElementById('file-img');
        // const img = document.getElementById('sign-img');
        // const img_block = document.getElementById('img_block');

        // input.addEventListener('change', () => {
        //     const file = input.files[0];
        //     const reader = new FileReader();

        //     reader.addEventListener('load', () => {
        //         img.src = reader.result;
        //         img_block.classList.remove('d-none');
        //     });

        //     reader.readAsDataURL(file);
        // })

        // // Initialize pdf.js
        // const pdfjsLib = window['pdfjs-dist/build/pdf'];

        // // Initialize pdf-lib
        // const {
        //     PDFDocument,
        //     rgb
        // } = PDFLib;

        // // let annotations = [];
        // let annotations = [{
        //     pageNum: 1, // Page number
        //     x: 87,
        //     y: 445,
        //     width: 100,
        //     height: 15,
        //     comment: 'test',
        // }];
        // let __PDF_DOC,
        //     __CURRENT_PAGE,
        //     __TOTAL_PAGES,
        //     __PAGE_RENDERING_IN_PROGRESS = 0;

        // var url = "{{ $docToShow }}";
        // console.log(true);

        // showPDF(url);

        // function showPDF(pdf_url) {

        //     $("#pdf-loader").show();

        //     PDFJS.getDocument({
        //         url: pdf_url
        //     }).then(function(pdf_doc) {
        //         __PDF_DOC = pdf_doc;
        //         __TOTAL_PAGES = __PDF_DOC.numPages;

        //         // Hide the pdf loader and show pdf container in HTML
        //         $("#pdf-loader").hide();
        //         $("#pdf-contents").show();
        //         $("#pdf-total-pages").text(__TOTAL_PAGES);

        //         for (var i = 1; i <= __TOTAL_PAGES; i++) {

        //             var pdfPage = document.createElement('div');
        //             pdfPage.classList.add('pdf-page');
        //             pdfPage.setAttribute('id', 'page-' + i);

        //             var canvas = document.createElement('canvas');
        //             // canvas.setAttribute('width', '595px');
        //             canvas.setAttribute('data-page', i);
        //             canvas.classList.add('pdf-canvas');
        //             canvas.classList.add('mb-2');
        //             $(pdfPage).append(canvas);

        //             var textLayer = document.createElement('div');
        //             textLayer.classList.add('text-layer');
        //             $(pdfPage).append(textLayer);

        //             var annotationLayer = document.createElement('div');
        //             annotationLayer.classList.add('annotationLayer');
        //             $(pdfPage).append(annotationLayer);

        //             var loader = document.createElement('div');
        //             loader.classList.add('page-loader');
        //             loader.classList.add('page-' + i);

        //             var loaderIcon = document.createElement('img');
        //             loaderIcon.src = "{{ asset('assets/images/loader.svg') }}";
        //             $(loader).append(loaderIcon);

        //             $(pdfPage).append(loader);

        //             $('#pdf-contents').append(pdfPage);

        //             var vignettePage = document.createElement('div');
        //             vignettePage.classList.add('vignette-page');

        //             var vignetteLink = document.createElement('a');
        //             vignetteLink.setAttribute('href', '#page-' + i);

        //             var vignetteCanvas = document.createElement('canvas');
        //             vignetteCanvas.setAttribute('width', '140px');
        //             vignetteCanvas.classList.add('mb-2');

        //             $(vignetteLink).append(vignetteCanvas);
        //             $(vignettePage).append(vignetteLink);

        //             $('#vignet-container').append(vignettePage);

        //             $("#page-" + i).droppable();

        //             $("#page-" + i).on("drop", function(event, ui) {

        //                 $(ui.draggable).attr('data-page', $(this).find('canvas').data('page'));

        //                 var droppableOffset = $(this).offset();
        //                 var draggablePosition = ui.draggable.position();

        //                 // Calculate the position of the draggable relative to the droppable
        //                 var relativeLeft = draggablePosition.left - droppableOffset.left;
        //                 var relativeTop = draggablePosition.top - droppableOffset.top;

        //                 $(ui.draggable).attr('data-x', relativeLeft);
        //                 $(ui.draggable).attr('data-y', relativeTop);

        //             });

        //             // Show the first page
        //             showPage(canvas, vignetteCanvas, textLayer, i);
        //         }

        //     }).catch(function(error) {
        //         // If error re-show the upload button
        //         $("#pdf-loader").hide();
        //         $("#upload-button").show();

        //         alert(error.message);
        //     });
        // }

        // function showPage(canvas, vignetteCanvas, textLayer, page_no) {
        //     __PAGE_RENDERING_IN_PROGRESS = 1;
        //     __CURRENT_PAGE = page_no;

        //     // Disable Prev & Next buttons while page is being loaded
        //     $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

        //     // While page is being rendered hide the canvas and show a loading message
        //     $("#pdf-canvas").hide();
        //     $(".page-loader.page-" + page_no).show();

        //     // Update current page in HTML
        //     $("#pdf-current-page").text(page_no);

        //     // Fetch the page
        //     __PDF_DOC.getPage(page_no).then(function(page) {

        //         // Support HiDPI-screens.
        //         var outputScale = window.devicePixelRatio || 1;

        //         var scale = outputScale > 1 ? 1.5 : 1.2;

        //         var viewport = page.getViewport(scale);

        //         var context = canvas.getContext('2d');

        //         canvas.width = Math.floor(viewport.width * outputScale);
        //         canvas.height = Math.floor(viewport.height * outputScale);
        //         // canvas.style.width = Math.floor(viewport.width) + "px";
        //         // canvas.style.height = Math.floor(viewport.height) + "px";

        //         // $(canvas).parent().css({
        //         //     width: Math.floor(viewport.width) + "px",
        //         //     height: Math.floor(viewport.height) + "px",
        //         //     margin: '10px auto',
        //         // });

        //         var transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] :
        //             null;

        //         var renderContext = {
        //             canvasContext: context,
        //             transform: transform,
        //             viewport: viewport
        //         };

        //         // Render the page contents in the canvas
        //         page.render(renderContext).then(function() {
        //             __PAGE_RENDERING_IN_PROGRESS = 0;

        //             // Show the canvas and hide the page loader
        //             $(".page-loader.page-" + page_no).hide();

        //             // Return the text contents of the page after the pdf has been rendered in the canvas
        //             return page.getTextContent();
        //         }).then(function(textContent) {
        //             // Get canvas offset
        //             var canvas_offset = $(canvas).offset();

        //             // Clear HTML for text layer
        //             $(textLayer).html('');

        //             // Assign the CSS created to the text-layer element
        //             $(textLayer).css({
        //                 left: '0px',
        //                 top: '8px',
        //                 height: canvas.height + 'px',
        //                 width: canvas.width + 'px'
        //             });

        //             // Pass the data to the method for rendering of text over the pdf canvas.
        //             PDFJS.renderTextLayer({
        //                 textContent: textContent,
        //                 container: $(textLayer).get(0),
        //                 viewport: viewport,
        //                 textDivs: []
        //             });

        //             // // Draw annotations on canvas
        //             // const pageAnnotations = annotations.filter(ann => ann.pageNum === page_no);
        //             // pageAnnotations.forEach(ann => {
        //             //     createSelection($(canvas).parent().find('.annotationLayer')[0], ann.width,
        //             //         ann.height, ann.x, ann.y, null)
        //             //     createCommentElement($(canvas).parent().find('.annotationLayer')[0], $(
        //             //         canvas).width(), ann.y)
        //             //     // textContent.beginPath();
        //             //     // textContent.rect(ann.x, ann.y, ann.width, ann.height);
        //             //     // textContent.strokeStyle = 'red';
        //             //     // textContent.lineWidth = 2;
        //             //     // textContent.stroke();
        //             // });

        //         });

        //         var scale_vignette_required = vignetteCanvas.width / page.getViewport(1).width * outputScale;

        //         // Get viewport of the page at required scale
        //         var vignettevViewport = page.getViewport(scale_vignette_required);

        //         // Set canvas height
        //         vignetteCanvas.height = vignettevViewport.height;

        //         var renderVignetteContext = {
        //             canvasContext: vignetteCanvas.getContext('2d'),
        //             viewport: vignettevViewport
        //         };
        //         page.render(renderVignetteContext);
        //     });
        // }

        // // // Handle text selection and annotation
        // // document.addEventListener('mouseup', () => {
        // //     const selectedText = window.getSelection().toString();
        // //     if (selectedText && $('.comment-btn-popover').length == 0) {

        // //         const pdfContents = document.getElementById('pdf-contents');
        // //         const selectionTextLayer = getParentElementOfSelectedText();
        // //         const selectionCanvas = $(selectionTextLayer).hasClass('pdf-page') ? $(selectionTextLayer)
        // //             .find('canvas')[0] : $(selectionTextLayer).parent().parent().find('canvas')[0];

        // //         const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
        // //         const canvasRect = selectionCanvas.getBoundingClientRect();

        // //         // I create a popover element
        // //         const popover = document.createElement('div');
        // //         popover.style.position = 'absolute';
        // //         popover.style.zIndex = '1';
        // //         popover.style.left = (boundingRect.right + 5) +
        // //             'px'; //(boundingRect.left + canvasRect.left) + 'px'; //canvasRect.right+'px';
        // //         popover.style.top = (boundingRect.top - canvasRect.top) + 50 + 'px';
        // //         popover.style.width = '50px';
        // //         popover.style.height = '100px';
        // //         popover.style.display = 'flex';
        // //         popover.style.justifyContent = 'center';
        // //         popover.style.alignItems = 'center';
        // //         popover.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        // //         popover.classList.add('comment-btn-popover');

        // //         // I create a button to add to the popover
        // //         const button = document.createElement('button');
        // //         button.style.width = '50px';
        // //         button.style.height = '100px';
        // //         button.style.display = 'flex';
        // //         button.style.justifyContent = 'center';
        // //         button.style.alignItems = 'center';
        // //         button.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        // //         button.style.color = 'white';
        // //         button.innerText = 'Add';

        // //         // I add the button to the popover
        // //         popover.appendChild(button);

        // //         // I add the popover to the document
        // //         document.body.appendChild(popover);

        // //         button.addEventListener('click', handleNewCommentBTN);

        // //         // alert($('#pdf-contents').width());
        // //         // const comment = prompt('Add a comment:');
        // //         // if (comment) {
        // //         //     const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
        // //         //     const canvasRect = document.getElementById('pdfCanvas').getBoundingClientRect();
        // //         //     const annotation = {
        // //         //         pageNum: 1, // Page number
        // //         //         x: boundingRect.left - canvasRect.left,
        // //         //         y: boundingRect.top - canvasRect.top,
        // //         //         width: boundingRect.width,
        // //         //         height: boundingRect.height,
        // //         //         comment: comment,
        // //         //     };
        // //         //     annotations.push(annotation);

        // //         //     // Update canvas with annotation
        // //         //     renderPdfWithAnnotations();
        // //         // }
        // //     }
        // //     if (!selectedText && $('.comment-btn-popover').length > 0) {
        // //         $('.comment-btn-popover').remove();
        // //     }
        // // });

        // // function getParentElementOfSelectedText() {
        // //     const selection = window.getSelection();

        // //     if (selection.rangeCount > 0) {
        // //         const range = selection.getRangeAt(0);
        // //         const parentElement = range.commonAncestorContainer.parentElement;
        // //         return parentElement;
        // //     }

        // //     return null;
        // // }

        // // function handleNewCommentBTN(evt) {
        // //     const selectionTextLayer = getParentElementOfSelectedText();
        // //     const selectionCanvas = $(selectionTextLayer).hasClass('pdf-page') ? $(selectionTextLayer)
        // //         .find('canvas')[0] : $(selectionTextLayer).parent().parent().find('canvas')[0];
        // //     const boundingRect = window.getSelection().getRangeAt(0).getBoundingClientRect();
        // //     const canvasRect = selectionCanvas.getBoundingClientRect();
        // //     const annotationLayer = $(selectionCanvas).parent().find('.annotationLayer')[0];
        // //     var btn = $(this);

        // //     // width: boundingRect.width,
        // //     //     height: boundingRect.height,
        // //     //     left: boundingRect.left - canvasRect.left + 'px',
        // //     //     top: boundingRect.top - canvasRect.top + 'px',

        // //     createSelection(annotationLayer, boundingRect.width, boundingRect.height, boundingRect.left - canvasRect.left,
        // //         boundingRect.top - canvasRect.top, btn);
        // //     // left: canvasRect.width - (250 * 5) / 100 + 'px',
        // //     //     top: (boundingRect.top - canvasRect.top) + 'px',
        // //     createCommentElement(annotationLayer, canvasRect.width, (boundingRect.top - canvasRect.top));
        // // }

        // // function createSelection(annotationLayer, width, height, left, top, btn) {
        // //     var selectionElement = document.createElement('div');
        // //     $(selectionElement).css({
        // //         position: 'absolute',
        // //         backgroundColor: 'rgba(221, 85, 0, 0.3)',
        // //         width: width,
        // //         height: height,
        // //         left: left + 'px',
        // //         top: top + 'px',
        // //     });

        // //     selectionElement.classList.add('selection');
        // //     selectionElement.classList.add('selection-' + $('.selection').length);

        // //     annotationLayer.append(selectionElement);
        // //     window.getSelection().removeAllRanges();
        // //     if (btn !== null) {

        // //         btn.parent().remove();
        // //     }
        // // }

        // // function createCommentElement(annotationLayer, left, top) {

        // //     var commentElement = document.createElement('div');
        // //     $(commentElement).addClass('shadow rounded border p-2 comment comment-' + $('.comment').length)
        // //     $(commentElement).data('link-to', 'selection-' + $('.comment').length);

        // //     $(commentElement).css({
        // //         position: 'absolute',
        // //         backgroundColor: '#fff',
        // //         width: '250px',
        // //         minHeight: '40px',
        // //         left: left - (250 * 5) / 100 + 'px',
        // //         top: top + 'px',
        // //         zIndex: '1',
        // //     });

        // //     var commentElementHeader = document.createElement('div');
        // //     commentElementHeader.style.display = 'flex';
        // //     commentElementHeader.classList.add('gap-2');

        // //     var commentElementHeaderImg = document.createElement('img');
        // //     commentElementHeaderImg.style.width = '40px';
        // //     commentElementHeaderImg.style.height = '40px';
        // //     commentElementHeaderImg.classList.add('rounded-circle')
        // //     commentElementHeaderImg.src = '{{ imageOrDefault(Auth::user()->agent->image) }}'

        // //     var commentElementHeaderUserName = document.createElement('div');
        // //     var commentElementHeaderH6 = document.createElement('h6');
        // //     commentElementHeaderH6.style.margin = '0px';
        // //     commentElementHeaderH6.innerText = '{{ Auth::user()->agent->prenom . ' ' . Auth::user()->agent->nom }}';

        // //     var commentElementHeaderSmall = document.createElement('small');
        // //     commentElementHeaderSmall.innerText = '{{ Auth::user()->agent->direction->titre }}';

        // //     commentElementHeaderUserName.append(commentElementHeaderH6);
        // //     commentElementHeaderUserName.append(commentElementHeaderSmall);

        // //     commentElementHeader.append(commentElementHeaderImg);
        // //     commentElementHeader.append(commentElementHeaderUserName);

        // //     var commentElementBody = document.createElement('div');
        // //     $(commentElementBody).addClass('py-2')
        // //     var commentElementBodyTextarea = document.createElement('textarea');
        // //     $(commentElementBodyTextarea).addClass(' form-control')
        // //     $(commentElementBodyTextarea).attr('placeholder', 'Votre texte ici')

        // //     commentElementBody.append(commentElementBodyTextarea);

        // //     var commentElementFooter = document.createElement('div');
        // //     commentElementFooter.classList.add('text-end');

        // //     var commentElementFooterBtnRemove = document.createElement('button');
        // //     commentElementFooterBtnRemove.innerText = 'remove';
        // //     $(commentElementFooterBtnRemove).addClass('btn btn-sm me-2');
        // //     commentElementFooter.append(commentElementFooterBtnRemove);

        // //     var commentElementFooterBtnSave = document.createElement('button');
        // //     commentElementFooterBtnSave.innerText = 'save';
        // //     $(commentElementFooterBtnSave).addClass('btn btn-sm btn-primary');
        // //     commentElementFooter.append(commentElementFooterBtnSave);

        // //     commentElement.append(commentElementHeader);
        // //     commentElement.append(commentElementBody);
        // //     commentElement.append(commentElementFooter);
        // //     // annotationLayer.append(commentElement);
        // //     addToLayer(annotationLayer, commentElement);
        // // }

        // // function addToLayer(annotationLayer, commentElement) {
        // //     var comments = document.querySelectorAll('.annotationLayer .comment');
        // //     // annotationLayer.removeChild(commentElement)
        // //     if (comments.length === 0) {
        // //         annotationLayer.appendChild(commentElement);
        // //     } else {
        // //         let inserted = false;

        // //         for (let i = 0; i < comments.length; i++) {
        // //             const currentItem = comments[i];
        // //             const rect = currentItem.getBoundingClientRect();
        // //             const spaceAbove = i === 0 ? rect.top : rect.top - comments[i - 1].getBoundingClientRect().bottom;

        // //             var elementTop = parseFloat(commentElement.style.top);
        // //             console.log(rect.top + rect.height, elementTop);

        // //             if (rect.top <= elementTop && rect.bottom >= elementTop) {
        // //                 annotationLayer.insertBefore(commentElement, currentItem);
        // //                 // for (let j = 0; j < comments.length; j++) {
        // //                 //     if (condition) {

        // //                 //     }
        // //                 // }
        // //             }



        // //             // currentItem.style.top = commentElement.offsetHeight + 'px';
        // //             // commentElement.style.backgroundColor = 'red';

        // //             // if (spaceAbove >= commentElement.offsetHeight) {
        // //             //     commentElement.style.backgroundColor = 'red';
        // //             //     annotationLayer.insertBefore(commentElement, currentItem);
        // //             //     currentItem.style.top = commentElement.offsetHeight + 'px';
        // //             //     inserted = true;
        // //             //     break;
        // //             // }
        // //         }

        // //         if (!inserted) {
        // //             annotationLayer.appendChild(commentElement);
        // //         }
        // //     }

        // //     // // while (comments[0]) {
        // //     //     // $(annotationLayer).find(comments).remove();
        // //     //     // annotationLayer.removeChild(comments[0]);
        // //     // // }

        // //     // // Créez un tableau pour stocker les éléments triés
        // //     // const sortedElements = [];

        // //     // // if (comments.length > 0) {

        // //     //     // Bouclez à travers les éléments et obtenez leurs positions
        // //     //     comments.forEach(comment => {
        // //     //         const rect = comment.getBoundingClientRect();
        // //     //         sortedElements.push({
        // //     //             comment,
        // //     //             top: rect.top
        // //     //         });
        // //     //     });


        // //     //     // Triez les éléments en fonction de leurs positions "top"
        // //     //     sortedElements.sort((a, b) => a.top - b.top);

        // //     //     // Maintenant, insérez les éléments triés dans le conteneur cible tout en évitant le chevauchement
        // //     //     const sortedContainer = annotationLayer; //document.getElementById('annotationLayer');
        // //     //     let previousBottom = Number.NEGATIVE_INFINITY;

        // //     //     sortedElements.forEach((item, index) => {
        // //     //         const rect = item.comment.getBoundingClientRect();
        // //     //         const overlap = rect.top < previousBottom;
        // //     //         console.log(index);
        // //     //         if (overlap) {
        // //     //             const overlapHeight = previousBottom - rect.top;
        // //     //             item.comment.style.transform = `translateY(-${overlapHeight}px)`;
        // //     //             item.comment.style.backgroundColor = 'red'
        // //     //         }

        // //     //         sortedContainer.appendChild(item.comment);
        // //     //         previousBottom = rect.bottom;
        // //     //     });
        // //     // // }

        // // }

        // function addToLayer(annotationLayer, commentElement) {
        //     annotationLayer.append(commentElement);
        //     // Suppose commentList est votre liste d'éléments de commentaire
        //     const comments = document.querySelectorAll('.annotationLayer .comment');

        //     // Lors de l'ajout d'un nouveau commentaire
        //     const newComment = commentElement;

        //     const commentList = [];

        //     // Bouclez à travers les éléments et obtenez leurs positions
        //     comments.forEach(comment => {
        //         const rect = comment.getBoundingClientRect();
        //         commentList.push({
        //             comment,
        //             top: rect.top
        //         });
        //     });

        //     // Triez la liste des commentaires par position top (du plus petit au plus grand)
        //     commentList.sort((a, b) => a.top - b.top);

        //     var newTop = newComment.getBoundingClientRect().top;

        //     // Trouvez l'index où le nouveau commentaire doit être inséré en fonction de sa position top
        //     let insertIndex = 0;
        //     // console.log(commentList[0].top == newTop);
        //     while (insertIndex < commentList.length && commentList[insertIndex].top < newTop) {
        //         insertIndex++;
        //     }

        //     // Insérez le nouveau commentaire à l'index approprié
        //     commentList.splice(insertIndex, 0, newComment);

        //     // Maintenant, vous pouvez ajuster les positions des commentaires existants situés au-dessus du nouvel élément
        //     for (let i = 0; i < insertIndex; i++) {
        //         commentList[i].top += newComment.getBoundingClientRect().height
        //         commentList[i].comment.top = commentList[i].top
        //         /* ajustement de décalage */
        //         ;
        //     }

        //     // Maintenant, commentList contient les commentaires avec les positions mises à jour

        // }

        // // Render PDF with annotations
        // async function renderPdfWithAnnotations() {

        //     var allCanvas = document.querySelectorAll('#pdf-contents canvas');

        //     const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);

        //     allCanvas.forEach(canvas => {
        //         const context = canvas.getContext('2d');
        //         pageAnnotations.forEach(ann => {
        //             context.beginPath();
        //             context.rect(ann.x, ann.y, ann.width, ann.height);
        //             context.strokeStyle = 'red';
        //             context.lineWidth = 2;
        //             context.stroke();
        //         });
        //         canvas.context = context;
        //     });

        //     // const pdfDoc = await PDFDocument.create()
        //     // // const timesRomanFont = await pdfDoc.embedFont(StandardFonts.TimesRoman)

        //     // const page = pdfDoc.addPage()
        //     // const { width, height } = page.getSize()

        //     // const canvas = document.getElementById('pdfCanvas');
        //     // const context = canvas.getContext('2d');
        //     // canvas.height = height;
        //     // canvas.width = width;

        //     // const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
        //     // pageAnnotations.forEach(ann => {
        //     //     context.beginPath();
        //     //     context.rect(ann.x, ann.y, ann.width, ann.height);
        //     //     context.strokeStyle = 'red';
        //     //     context.lineWidth = 2;
        //     //     context.stroke();
        //     // });

        //     // page.draw(context);

        //     // console.log(width);

        //     // const response = await fetch(url);
        //     // const pdfBytes = await response.blob();

        //     // // Convert the Blob to an ArrayBuffer
        //     // const buffer = await new Response(pdfBytes).arrayBuffer();

        //     // // Load the PDF using pdf-lib
        //     // const pdfDoc = await PDFLib.PDFDocument.load(buffer);

        //     // const canvas = document.getElementById('pdfCanvas');
        //     // const context = canvas.getContext('2d');
        //     // const pdfPage = pdfDoc.getPages()[0];
        //     // pdfPage.draw(context);

        //     // __PDF_DOC.getPage(1).then(function(page) {
        //     //     const viewport = page.getViewport(1.0);
        //     //     canvas.height = viewport.height;
        //     //     canvas.width = viewport.width;

        //     //     // Draw PDF content from pdf-lib
        //     //     pdfPage.draw(context);
        //     //     // Draw annotations
        //     //     const pageAnnotations = annotations.filter(ann => ann.pageNum === 1);
        //     //     pageAnnotations.forEach(ann => {
        //     //         context.beginPath();
        //     //         context.rect(ann.x, ann.y, ann.width, ann.height);
        //     //         context.strokeStyle = 'red';
        //     //         context.lineWidth = 2;
        //     //         context.stroke();
        //     //     });

        //     //     // console.log(page.getViewport(1.0));
        //     // });



        // }

        // // Save annotations to the PDF using pdf-lib
        // // document.getElementById('saveButton').addEventListener('click', async () => {
        // //     annotations.forEach(ann => {
        // //         const page = pdfDoc.getPages()[0];
        // //         const textAnnotation = page.drawText(ann.comment, {
        // //             x: ann.x,
        // //             y: ann.y - 10,
        // //             size: 10,
        // //             color: rgb(255, 0, 0),
        // //         });
        // //     });

        // //     const pdfBytes = await pdfDoc.save();

        // //     // Update canvas with annotations
        // //     renderPdfWithAnnotations();
        // // });

        // // $('.show-vignette').on('click', function() {
        // //     if ($('.vignette-column').width() == 0) {

        // //         $('.vignette-column').css({
        // //             width: '100%'
        // //         })

        // //         $('.vignette-column').parent().parent().addClass('border-start');
        // //     } else {

        // //         $('.vignette-column').css({
        // //             width: '0px'
        // //         })
        // //         $('.vignette-column').parent().parent().removeClass('border-start');
        // //     }
        // // });
        // $('#pills-profile-tab').on('click', function() {
        //     initSignaturePad();
        // })

        // $('.btn-signer').on('click', function(event) {
        //     $('#waiting-password').modal('show');
        //     $.ajax({
        //         url: "{{ route('regidoc.ajax.signature') }}",
        //         method: 'get',
        //         success: function(data) {
        //             // if (data.image !== '' && data.image !== undefined) {
        //             $('#modal-password .modal-body').find('#imgData').val(data.image);
        //             $('#modal-password .modal-body').find('#pass').val(data.password);

        //             $('#waiting-password').modal('hide');
        //             $('#modal-password').modal('show');
        //             // } else {
        //             //     $('#waiting-password').modal('hide');
        //             //     $('#modal-password').modal('show');

        //             //     newSignatureImage();
        //             // }
        //         }
        //     });

        // });

        // $('.resend-code').on('click', function(event) {
        //     $('#modal-password').modal('hide');
        //     $('#waiting-password').modal('show');
        //     $.ajax({
        //         url: "{{ route('regidoc.ajax.signature') }}",
        //         method: 'get',
        //         success: function(data) {
        //             // if (data.image !== '' && data.image !== undefined) {
        //             $('#modal-password .modal-body').find('#imgData').val(data.image);
        //             $('#modal-password .modal-body').find('#pass').val(data.password);

        //             $('#waiting-password').modal('hide');
        //             $('#modal-password').modal('show');
        //             // } else {
        //             //     newSignatureImage();
        //             // }
        //         }
        //     });
        // });

        // $('.btn-valid-password').on('click', function() {

        //     var imgData = $('#modal-password .modal-body').find('#imgData').val()
        //     var password = $('#modal-password .modal-body').find('#pass').val()

        //     if ($('#password').val() == password) {
        //         if (imgData !== '' && imgData !== undefined && imgData !== null) {
        //             var signatureElement = createSignatureElement2();
        //             var imgElement = document.createElement('img');
        //             $(imgElement).addClass('w-100 h-100');
        //             $(imgElement).css({
        //                 objectFit: 'contain',
        //             });

        //             $(imgElement).attr('src', imgData);

        //             $(signatureElement).append(imgElement);
        //             signatureElement.style.left = event.clientX + 5 + 'px';
        //             signatureElement.style.top = event.clientY + 5 + 'px';

        //             $('#modal-password').modal('hide');
        //             $('#modal-password').find('input').val('');
        //             $('.btn-signer').attr('disabled', true);
        //             $('.btn-signer').addClass('disabled');
        //         } else {
        //             newSignatureImage();
        //             $('#modal-password').modal('hide');
        //             $('#modal-password').find('input').val('');
        //         }
        //     } else {
        //         $('#modal-password').find('.error-message').text('Mot de passe incorrect');
        //     }
        // });

        // $('.btn-tampon').on('click', function(event) {

        //     $.ajax({
        //         url: "{{ route('regidoc.ajax.tampon') }}",
        //         method: 'get',
        //         success: function(data) {
        //             if (data.image !== '' && data.image !== undefined) {
        //                 var signatureElement = createSignatureElement2();
        //                 signatureElement.classList.add('tampon');
        //                 var imgElement = document.createElement('img');
        //                 $(imgElement).addClass('w-100 h-100');
        //                 $(imgElement).css({
        //                     objectFit: 'contain',
        //                 })
        //                 $(imgElement).attr('src', data.image);

        //                 $(signatureElement).append(imgElement);
        //                 signatureElement.style.left = event.clientX + 5 + 'px';
        //                 signatureElement.style.top = event.clientY + 5 + 'px';
        //             } else {
        //                 newTamponImage();
        //             }
        //         }
        //     });
        // });

        // function createSignatureElement() {
        //     if ($('.signature:not(.dropped-true)').length == 0) {
        //         var signatureElement = document.createElement('div');
        //         signatureElement.classList.add('signature');
        //         signatureElement.style.position = 'fixed';

        //         var certificate = document.createElement('div');
        //         certificate.classList.add('certificate');

        //         var span1 = document.createElement('span');
        //         span1.innerText = 'Signé avec RegiDocs';

        //         var span2 = document.createElement('span');
        //         span2.innerText = "{{ Str::upper(Str::random(20)) }}";

        //         var signeContainer = document.createElement('div');
        //         signeContainer.classList.add('signe-img-container');
        //         signeContainer.style.position = 'absolute';
        //         // signeContainer.style.width = '100%';
        //         signeContainer.style.height = '80%';
        //         signeContainer.style.top = '50%';
        //         signeContainer.style.left = '25px';
        //         signeContainer.style.transform = 'translateY(-50%)';

        //         certificate.append(span1)
        //         certificate.append(span2)
        //         certificate.append(signeContainer)
        //         signatureElement.append(certificate)

        //         // signatureElement.width = '150';
        //         // signatureElement.height = '75';

        //         var removeBtn = document.createElement('button');
        //         removeBtn.classList.add('btn');
        //         removeBtn.classList.add('btn-danger');
        //         removeBtn.classList.add('btn-sm');
        //         removeBtn.classList.add('rounded-circle');
        //         removeBtn.classList.add('remove-btn');
        //         $(removeBtn).text('x');
        //         $(removeBtn).css({
        //             position: 'absolute',
        //             right: 0
        //         });

        //         $(signatureElement).append(removeBtn);

        //         $(signatureElement).draggable();
        //         $('body').append(signatureElement);

        //         return signatureElement;
        //     }
        // }

        // // function createTampoElement() {
        // //     if ($('.signature:not(.dropped-true)').length == 0) {
        // //         var signatureElement = document.createElement('div');
        // //         signatureElement.classList.add('signature');
        // //         signatureElement.style.position = 'fixed';

        // //         var certificate = document.createElement('div');
        // //         certificate.classList.add('certificate');

        // //         var span1 = document.createElement('span');
        // //         span1.innerText = 'Signé avec RegiDocs';

        // //         var span2 = document.createElement('span');
        // //         span2.innerText = "{{ Str::upper(Str::random(20)) }}";

        // //         var signeContainer = document.createElement('div');
        // //         signeContainer.classList.add('signe-img-container');
        // //         signeContainer.style.position = 'absolute';
        // //         // signeContainer.style.width = '100%';
        // //         signeContainer.style.height = '80%';
        // //         signeContainer.style.top = '50%';
        // //         signeContainer.style.left = '25px';
        // //         signeContainer.style.transform = 'translateY(-50%)';

        // //         certificate.append(span1)
        // //         certificate.append(span2)
        // //         certificate.append(signeContainer)
        // //         signatureElement.append(certificate)

        // //         // signatureElement.width = '150';
        // //         // signatureElement.height = '75';

        // //         var removeBtn = document.createElement('button');
        // //         removeBtn.classList.add('btn');
        // //         removeBtn.classList.add('btn-danger');
        // //         removeBtn.classList.add('btn-sm');
        // //         removeBtn.classList.add('rounded-circle');
        // //         removeBtn.classList.add('remove-btn');
        // //         $(removeBtn).text('x');
        // //         $(removeBtn).css({
        // //             position: 'absolute',
        // //             right: 0
        // //         });

        // //         $(signatureElement).append(removeBtn);

        // //         $(signatureElement).draggable();
        // //         $('body').append(signatureElement);

        // //         return signatureElement;
        // //     }
        // // }

        // function createSignatureElement2() {
        //     if ($('.signature:not(.dropped-true)').length == 0) {
        //         var signatureElement = document.createElement('div');
        //         signatureElement.classList.add('signature');
        //         signatureElement.style.position = 'fixed';

        //         var removeBtn = document.createElement('button');
        //         removeBtn.classList.add('btn');
        //         removeBtn.classList.add('btn-danger');
        //         removeBtn.classList.add('btn-sm');
        //         removeBtn.classList.add('rounded-circle');
        //         removeBtn.classList.add('remove-btn');
        //         $(removeBtn).text('x');
        //         $(removeBtn).css({
        //             position: 'absolute',
        //             right: 0
        //         });

        //         $(signatureElement).append(removeBtn);

        //         $(signatureElement).draggable();
        //         $('body').append(signatureElement);

        //         return signatureElement;
        //     }
        // }

        // function recreateOldSignatureElement(oldSignatureElement) {
        //     var signatureElement = oldSignatureElement;

        //     var certificate = document.createElement('div');
        //     certificate.classList.add('certificate');

        //     var span1 = document.createElement('span');
        //     span1.innerText = 'Signé avec RegiDocs';

        //     var span2 = document.createElement('span');
        //     span2.innerText = "{{ Str::upper(Str::random(20)) }}";

        //     var signeContainer = document.createElement('div');
        //     signeContainer.classList.add('signe-img-container');
        //     signeContainer.style.position = 'absolute';
        //     // signeContainer.style.width = '100%';
        //     signeContainer.style.height = '80%';
        //     signeContainer.style.top = '50%';
        //     signeContainer.style.left = '25px';
        //     signeContainer.style.transform = 'translateY(-50%)';

        //     certificate.append(span1)
        //     certificate.append(span2)
        //     certificate.append(signeContainer)
        //     signatureElement.append(certificate)

        //     // $(signatureElement).draggable();
        //     // $('body').append(signatureElement);

        //     return signatureElement;
        // }

        // function newSignatureImage() {
        //     if ($('.signature:not(.dropped-true)').length == 0) {

        //         $('.modal-signature').find('.dessin').removeClass('d-none');
        //         $('.modal-signature').find('.dessin-tab').addClass('active');
        //         $('.modal-signature').find('.dessin-tab').addClass('show');
        //         $('.modal-signature').find('.dessin-tab').removeClass('d-none');

        //         $('.modal-signature').find('.import-image-tab').removeClass('active');
        //         $('.modal-signature').find('.import-image-tab').removeClass('show');
        //         $('.modal-signature').find('.import-image button').removeClass('active');

        //         $('.modal-signature').addClass('signature-modal');
        //         $('.modal-signature').removeClass('tampon-modal');
        //         $('.modal-signature').css({
        //             width: '100%'
        //         });
        //         initSignaturePad();
        //     }
        // }

        // function newTamponImage() {
        //     if ($('.signature:not(.dropped-true)').length == 0) {

        //         $('.modal-signature').find('.dessin').addClass('d-none');
        //         $('.modal-signature').find('.dessin-tab').removeClass('active');
        //         $('.modal-signature').find('.dessin-tab').removeClass('show');
        //         $('.modal-signature').find('.dessin-tab').addClass('d-none');

        //         $('.modal-signature').find('.import-image-tab').addClass('active');
        //         $('.modal-signature').find('.import-image-tab').addClass('show');
        //         $('.modal-signature').find('.import-image button').addClass('active');

        //         $('.modal-signature').removeClass('signature-modal');
        //         $('.modal-signature').addClass('tampon-modal');
        //         $('.modal-signature').css({
        //             width: '100%'
        //         });

        //         initSignaturePad();

        //     }
        // }

        // // Event handlers for tracking mouse movement on the document
        // $(document).on('mousemove', function(event) {
        //     var signatureElement = document.querySelector('.signature:not(.dropped-true)');
        //     if (signatureElement !== null) {
        //         // console.log(signatureElement);
        //         // Set the position of the signature element to the current mouse position
        //         signatureElement.style.left = event.clientX + 5 + 'px';
        //         signatureElement.style.top = event.clientY + 5 + 'px';

        //         // signatureElement.style.left = ((event.clientX + 5) + window.scrollX) + 'px';
        //         // signatureElement.style.top = ((event.clientY + 5) + window.scrollY) + 'px';
        //     }
        // });

        // $("body").on("click", ".text-layer", function() {

        //     // Get the first draggable element (you can modify this selector based on your actual draggable elements)
        //     var draggableElement = $(".signature:not(.dropped-true)").first();

        //     // Check if the draggable element exists and is draggable
        //     if (draggableElement.length > 0 && draggableElement.hasClass("ui-draggable")) {

        //         $(draggableElement).addClass('dropped-true');
        //         $(draggableElement).resizable({
        //             // aspectRatio: true,
        //             autoHide: true,
        //             handles: "n, e, s, w, ne, se, sw, nw"
        //         });

        //         $(draggableElement).css({
        //             position: 'absolute',
        //             left: (event.clientX) + window.scrollX + 'px',
        //             top: (event.clientY) + window.scrollY + 'px'
        //         })

        //         $('.signature').find('img').on('dblclick', function() {
        //             // console.log($(this).parent().hasClass('tampon'));
        //             if ($(this).hasClass('droped-true')) {
        //                 $(this).addClass('active');
        //             } else {
        //                 $(this).parent().addClass('active');
        //             }
        //             if ($(this).parent().hasClass('tampon')) {
        //                 newTamponImage();
        //             } else {
        //                 newSignatureImage();
        //             }
        //             initSignaturePad()
        //         });

        //         // Simulate the drop event on the droppable area
        //         $(this).parent().trigger("drop", {
        //             draggable: $(draggableElement),
        //             helper: $(draggableElement),
        //             offset: {
        //                 top: $(draggableElement).offset().top,
        //                 left: $(draggableElement).offset().left
        //             },
        //             position: {
        //                 top: $(draggableElement).offset().top,
        //                 left: $(draggableElement).offset().left
        //             }
        //         });

        //         $('.remove-btn').on('click', function() {
        //             $(this).parent().remove();
        //             $('.btn-signer').removeClass('disabled')
        //             $('.btn-signer').attr('disabled', false)
        //         })
        //         initSignaturePad();
        //     }

        // });

        // $('.valid-canevas').on('click', function() {

        //     saveSignatureOrTampon();

        //     // html2canvas(signatureElement, {
        //     //     onrendered: function(canvas) {
        //     //         canvas.classList.add('tmp-canvas')
        //     //         document.body.appendChild(canvas);
        //     //         let leCanvas = document.querySelectorAll(".tmp-canvas")[0];
        //     //         let img = leCanvas.toDataURL("image/png");

        //     //         console.log(img);

        //     //         $.ajax({
        //     //             url: "{{ route('regidoc.ajax.signature.save') }}",
        //     //             method: 'post',
        //     //             data: {
        //     //                 'image': img,
        //     //             },
        //     //             success: function(data) {
        //     //                 console.log(data);
        //     //                 document.body.removeChild(leCanvas)
        //     //                 $(signatureElement).find('.signe-img-container').append(imgElement);
        //     //                 // $('body').append(signatureElement);
        //     //                 $('.modal-signature').css({
        //     //                     width: '0px'
        //     //                 });
        //     //             }
        //     //         });
        //     //     },
        //     //     width: 390,
        //     //     height: 220
        //     // });


        //     // }

        // });

        // $('.valid-name').on('click', function() {
        //     var nameSignatureElement = document.querySelector('.signature-name-container');
        //     html2canvas(nameSignatureElement, {
        //         backgroundColor: null,
        //         allowTaint: true,
        //         scale: 2,
        //         removeContainer: true
        //     }).then(function(canvas) {
        //         canvas.classList.add('tmp-canvas-2')
        //         document.body.appendChild(canvas);
        //         var leCanvas = document.querySelectorAll(".tmp-canvas-2")[0];
        //         let img = leCanvas.toDataURL("image/png");
        //         saveSignatureOrTampon(img);
        //         document.body.remove(canvas);
        //     });
        // });

        // function saveSignatureOrTampon(img = null) {
        //     let oldSignatureElement = document.querySelector('.signature.dropped-true.active');
        //     let signatureElement = null;
        //     var imgData = '';


        //     if (img !== null) {
        //         imgData = img;
        //     } else {
        //         signaturePad.removeBlanks();
        //         imgData = signaturePad.toDataURL();
        //     }

        //     let imgElement = document.createElement('img');

        //     if (oldSignatureElement !== null) {
        //         signatureElement = recreateOldSignatureElement(oldSignatureElement);
        //         $(signatureElement).find('img').remove();
        //         $(imgElement).addClass('img-fluid');
        //         $(imgElement).css({
        //             padding: "10px 0px"
        //         });
        //         $(imgElement).attr('src', imgData);
        //         $(signatureElement).find('.signe-img-container').append(imgElement);
        //     } else {
        //         signatureElement = createSignatureElement();
        //         $(imgElement).addClass('img-fluid');
        //         if (!$('.modal-signature').hasClass('tampon-modal')) {
        //             $(imgElement).css({
        //                 padding: "10px 0px"
        //             });
        //         }
        //         $(imgElement).attr('src', imgData);
        //         $(signatureElement).find('.signe-img-container').append(imgElement);
        //         // signatureElement.classList.add('d-none');
        //     }

        //     $(signatureElement).find('.remove-btn').remove();

        //     if ($('.modal-signature').hasClass('tampon-modal')) {
        //         $(signatureElement).addClass('tampon');
        //     }

        //     let ajaxUrl = $('.modal-signature').hasClass('tampon-modal') ?
        //         "{{ route('regidoc.ajax.tampon.save') }}" :
        //         "{{ route('regidoc.ajax.signature.save') }}";

        //     html2canvas(signatureElement, {
        //         backgroundColor: null,
        //         allowTaint: true,
        //         scale: 2,
        //         removeContainer: true
        //     }).then(function(canvas) {
        //         if (oldSignatureElement === null) {
        //             signatureElement.style.visibility = "hidden";
        //         }

        //         canvas.classList.add('tmp-canvas')
        //         document.body.appendChild(canvas);
        //         let leCanvas = document.querySelectorAll(".tmp-canvas")[0];
        //         let img2 = leCanvas.toDataURL("image/png");

        //         $.ajax({
        //             url: ajaxUrl,
        //             method: 'post',
        //             data: {
        //                 'image': img2,
        //             },
        //             success: function(data) {
        //                 console.log(data);
        //                 $(signatureElement).find('.certificate').remove();
        //                 $(signatureElement).find('.signe-img-container').remove();
        //                 $(signatureElement).find('img').remove();

        //                 var removeBtn = document.createElement('button');
        //                 removeBtn.classList.add('btn');
        //                 removeBtn.classList.add('btn-danger');
        //                 removeBtn.classList.add('btn-sm');
        //                 removeBtn.classList.add('rounded-circle');
        //                 removeBtn.classList.add('remove-btn');
        //                 $(removeBtn).text('x');
        //                 $(removeBtn).css({
        //                     position: 'absolute',
        //                     right: 0
        //                 });

        //                 $(signatureElement).append(removeBtn);
        //                 // signatureElement.classList.remove('d-none');
        //                 signatureElement.style.visibility = "visible";

        //                 var newImg = document.createElement('img');

        //                 $(newImg).addClass('img-fluid');
        //                 $(newImg).attr('src', data.image_url);
        //                 $(signatureElement).append(newImg);

        //                 $('.signature').find('img').on('dblclick', function() {
        //                     if ($(this).hasClass('droped-true')) {
        //                         $(this).addClass('active');
        //                     } else {
        //                         $(this).parent().addClass('active');
        //                     }

        //                     if ($(this).hasClass('tampon')) {
        //                         newTamponImage();
        //                     } else {
        //                         newSignatureImage();
        //                     }
        //                     initSignaturePad();
        //                 });

        //                 document.body.removeChild(leCanvas)

        //                 $('.modal-signature').css({
        //                     width: '0px'
        //                 });
        //                 $('#waiting-password').modal('hide');

        //             }
        //         });
        //     });
        // }

        // SignaturePad.prototype.removeBlanks = function() {
        //     var imgWidth = this._ctx.canvas.width;
        //     var imgHeight = this._ctx.canvas.height;
        //     var imageData = this._ctx.getImageData(0, 0, imgWidth, imgHeight),
        //         data = imageData.data,
        //         getAlpha = function(x, y) {
        //             return data[(imgWidth * y + x) * 4 + 3]
        //         },
        //         scanY = function(fromTop) {
        //             var offset = fromTop ? 1 : -1;

        //             // loop through each row
        //             for (var y = fromTop ? 0 : imgHeight - 1; fromTop ? (y < imgHeight) : (y > -1); y += offset) {

        //                 // loop through each column
        //                 for (var x = 0; x < imgWidth; x++) {
        //                     if (getAlpha(x, y)) {
        //                         return y;
        //                     }
        //                 }
        //             }
        //             return null; // all image is white
        //         },
        //         scanX = function(fromLeft) {
        //             var offset = fromLeft ? 1 : -1;

        //             // loop through each column
        //             for (var x = fromLeft ? 0 : imgWidth - 1; fromLeft ? (x < imgWidth) : (x > -1); x += offset) {

        //                 // loop through each row
        //                 for (var y = 0; y < imgHeight; y++) {
        //                     if (getAlpha(x, y)) {
        //                         return x;
        //                     }
        //                 }
        //             }
        //             return null; // all image is white
        //         };

        //     var cropTop = scanY(true),
        //         cropBottom = scanY(false),
        //         cropLeft = scanX(true),
        //         cropRight = scanX(false);

        //     var relevantData = this._ctx.getImageData(cropLeft, cropTop, cropRight - cropLeft, cropBottom - cropTop);
        //     // this._canvas.width = cropRight-cropLeft;
        //     // this._canvas.height = cropBottom-cropTop;
        //     this._ctx.canvas.width = cropRight - cropLeft;
        //     this._ctx.canvas.height = cropBottom - cropTop;
        //     this._ctx.clearRect(0, 0, cropRight - cropLeft, cropBottom - cropTop);
        //     this._ctx.putImageData(relevantData, 0, 0);
        // };

        // $('.btn-valid-img').on('click', function() {
        //     // var signatureElement = document.querySelector('.signature.dropped-true.active');

        //     const img = document.getElementById('sign-img');
        //     var imgData = img.src;

        //     saveSignatureOrTampon(imgData)

        //     // var ajaxUrl = $('.modal-signature').hasClass('tampon-modal') ?
        //     //     "{{ route('regidoc.ajax.tampon.save') }}" :
        //     //     "{{ route('regidoc.ajax.signature.save') }}";
        //     // if (signatureElement !== null) {
        //     //     $.ajax({
        //     //         url: ajaxUrl,
        //     //         method: 'post',
        //     //         data: {
        //     //             'image': imgData,
        //     //         },
        //     //         success: function(data) {
        //     //             var imgElement = $(signatureElement).find('img');
        //     //             imgElement.addClass('img-fluid');
        //     //             imgElement.attr('src', data.image_url);
        //     //             $(signatureElement).append(imgElement);
        //     //             $('.modal-signature').css({
        //     //                 width: '0px'
        //     //             });
        //     //             $(signatureElement).removeClass('active');
        //     //         }
        //     //     });
        //     // } else {
        //     //     $.ajax({
        //     //         url: ajaxUrl,
        //     //         method: 'post',
        //     //         data: {
        //     //             'image': imgData,
        //     //         },
        //     //         success: function(data) {
        //     //             var signatureElement = createSignatureElement();
        //     //             var imgElement = document.createElement('img');

        //     //             $(imgElement).addClass('img-fluid');
        //     //             $(imgElement).attr('src', data.image_url);

        //     //             $(signatureElement).append(imgElement);

        //     //             $('.modal-signature').css({
        //     //                 width: '0px'
        //     //             });
        //     //         }
        //     //     });
        //     // }
        // });

        // // Handle button click to insert an image into the PDF
        // $('.save_pdf').on('click', function() {
        //     var signatures = document.querySelectorAll('.signature');
        //     if (signatures.length > 0) {
        //         var modal = new bootstrap.Modal($('#modal-action-save'));
        //         modal.show();
        //     } else {
        //         var modal = new bootstrap.Modal($('#modal-error'));
        //         modal.show();
        //     }
        // });

        // // Handle button click to insert an image into the PDF
        // $('#saveCourrier').on('click', function() {
        //     $('.loader-card').removeClass('d-none');
        //     loadPDF(url, "{{ route('regidoc.taches.saveSignature') }}");
        // });

        // async function loadPDF(url, ajaxUrl) {
        //     var signatureElements = document.querySelectorAll('.signature.dropped-true');

        //     // Fetch the PDF file from the server
        //     const response = await fetch(url);
        //     const pdfBytes = await response.blob();

        //     // Convert the Blob to an ArrayBuffer
        //     const buffer = await new Response(pdfBytes).arrayBuffer();

        //     // Load the PDF using pdf-lib
        //     const pdfDoc = await PDFLib.PDFDocument.load(buffer);

        //     for (var index = 0; index < signatureElements.length; index++) {
        //         const signatureElement = signatureElements[index];

        //         const pngImageBytes = await fetch($(signatureElement).find('img').attr('src')).then((res) => res
        //             .arrayBuffer());
        //         const pngImage = await pdfDoc.embedPng(pngImageBytes)
        //         var currentPage = $(signatureElement).data('page');
        //         const page = pdfDoc.getPages()[currentPage - 1];

        //         var pageParent = document.getElementById('page-' + currentPage);

        //         var pageParentX = $(pageParent).width();
        //         var pageParentY = $(pageParent).height();

        //         var facteurX = page.getWidth() / pageParentX;
        //         var facteurY = page.getHeight() / pageParentY;

        //         var imgWidth = $(signatureElement).find('img').width() * facteurX;
        //         var imgHeight = $(signatureElement).find('img').height() * facteurY;

        //         var oldW = $(signatureElement).find('img').width();
        //         var oldH = $(signatureElement).find('img').height();


        //         // var y = $(signatureElement).data('y') + 20;
        //         var y = $(signatureElement).data('y') * facteurY //- imgHeight;
        //         var x = $(signatureElement).data('x') * facteurX //+ (imgWidth / 2);

        //         const signature = {
        //             width: imgWidth,
        //             height: imgHeight,
        //             x: x,
        //             y: y,
        //         };

        //         const imageOptions = getImagePosition(page, signature, 1);

        //         // Add the image to page
        //         page.drawImage(pngImage, imageOptions);

        //     }

        //     await pdfDoc.save().then(async function(modifiedPdfBytes) {
        //         // Convert the modified PDF bytes to a Blob
        //         const modifiedPdfBlob = await new Blob([
        //             modifiedPdfBytes
        //         ], {
        //             type: 'application/pdf'
        //         });

        //         // // Create a link to download the modified PDF
        //         // const downloadLink = document.createElement('a');
        //         // downloadLink.href = URL.createObjectURL(modifiedPdfBlob);
        //         // downloadLink.download = 'modified_pdf.pdf';

        //         // // Trigger the download link
        //         // downloadLink.click();

        //         var formData = new FormData();
        //         formData.append('document', modifiedPdfBlob, "{{-- files($doc->document)->name --}}");
        //         formData.append('tache_id', "{{-- $tache->id --}}");
        //         formData.append('doc_id', "{{-- $doc->id --}}");

        //         $.ajax({
        //             url: ajaxUrl,
        //             method: 'post',
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function(data) {
        //                 const downloadLink = document.createElement('a');
        //                 downloadLink.href =
        //                     "{{-- route('regidoc.documents.showDoc',['fichier_id'=>'file_id','tache_id'=>$tache->id]) --}}"
        //                     .replace('file_id', data.file.id);

        //                 // Trigger the download link
        //                 downloadLink.click();

        //                 $('.loader-card').addClass('d-none');

        //                 $('.modal.show').modal('hide');

        //                 $('#pdf-contents').empty();
        //                 showPDF(data.file);
        //             }

        //         });

        //     });
        // }

        // function getImagePosition(page, image, sizeRatio) {
        //     let pageWidth, pageHeight;
        //     if ([90, 270].includes(page.getRotation().angle)) {
        //         pageWidth = page.getHeight();
        //         pageHeight = page.getWidth();
        //     } else {
        //         pageWidth = page.getWidth();
        //         pageHeight = page.getHeight();
        //     }

        //     if (!image.hasOwnProperty('vpWidth')) {
        //         image['vpWidth'] = pageWidth;
        //     }

        //     const pageRatio = pageWidth / (image.vpWidth * sizeRatio);
        //     const imageWidth = image.width * sizeRatio * pageRatio;
        //     const imageHeight = image.height * sizeRatio * pageRatio;
        //     const imageX = image.x * sizeRatio * pageRatio;
        //     const imageYFromTop = image.y * sizeRatio * pageRatio;

        //     const correction = compensateRotation(
        //         page.getRotation().angle,
        //         imageX,
        //         imageYFromTop,
        //         1,
        //         page.getSize(),
        //         imageHeight
        //     );

        //     return {
        //         width: imageWidth,
        //         height: imageHeight,
        //         x: correction.x,
        //         y: correction.y,
        //         rotate: page.getRotation()
        //     };
        // }

        // function compensateRotation(pageRotation, x, y, scale, dimensions, fontSize) {
        //     // var pageRotation = me.getPageRotation(page);
        //     var rotationRads = pageRotation * Math.PI / 180;

        //     //These coords are now from bottom/left
        //     var coordsFromBottomLeft = {
        //         x: (x / scale)
        //     }
        //     if (pageRotation === 90 || pageRotation === 270) {
        //         coordsFromBottomLeft.y = dimensions.width - ((y + fontSize) / scale);
        //     } else {
        //         coordsFromBottomLeft.y = dimensions.height - ((y + fontSize) / scale);
        //     }

        //     var drawX = null;
        //     var drawY = null;

        //     console.log(pageRotation);

        //     if (pageRotation === 90) {
        //         drawX = coordsFromBottomLeft.x * Math.cos(rotationRads) - coordsFromBottomLeft.y * Math.sin(rotationRads) +
        //             dimensions.width;
        //         drawY = coordsFromBottomLeft.x * Math.sin(rotationRads) + coordsFromBottomLeft.y * Math.cos(rotationRads);
        //     } else if (pageRotation === 180) {
        //         drawX = coordsFromBottomLeft.x * Math.cos(rotationRads) - coordsFromBottomLeft.y * Math.sin(rotationRads) +
        //             dimensions.width;
        //         drawY = coordsFromBottomLeft.x * Math.sin(rotationRads) + coordsFromBottomLeft.y * Math.cos(rotationRads) +
        //             dimensions.height;
        //     } else if (pageRotation === 270) {
        //         drawX = coordsFromBottomLeft.x * Math.cos(rotationRads) - coordsFromBottomLeft.y * Math.sin(rotationRads);
        //         drawY = coordsFromBottomLeft.x * Math.sin(rotationRads) + coordsFromBottomLeft.y * Math.cos(rotationRads) +
        //             dimensions.height;
        //     } else {
        //         //no rotation
        //         drawX = coordsFromBottomLeft.x;
        //         drawY = coordsFromBottomLeft.y;
        //     }

        //     return {
        //         x: drawX,
        //         y: drawY
        //     }
        // }

        document.addEventListener('livewire:load', () => {
            Livewire.onPageExpired((response, message) => {
                alert('test')
                location.reload()
            })
        })
    </script>


</body>

</html>


<script>
    $(function() {
        "use strict";

        var body = $("body");
        var lastCopiedData = null; // Variable pour stocker les données copiées

        // Fonction pour gérer le collage
        function onPaste(e) {
            var clipboardData = e.originalEvent.clipboardData || window.clipboardData;
            var pastedData = clipboardData.getData("text");

            // Vérifie si les données collées sont valides (chiffres uniquement)
            if (/^\d+$/.test(pastedData) && pastedData.length <= 6) {
                e.preventDefault();

                // Récupère les champs dans l'ordre de gauche à droite
                var inputs = body.find("input[name^='passwordNumber']").sort(function(a, b) {
                    return $(a).attr("name").localeCompare($(b).attr("name"));
                });

                pastedData.split("").forEach((char, index) => {
                    if (inputs.eq(index).length) {
                        inputs.eq(index).val(char);
                    }
                });

                // Déplace le focus au dernier champ rempli
                var lastFilledInput = inputs.filter(function() {
                    return $(this).val().length === 1;
                }).last();

                if (lastFilledInput.length) {
                    lastFilledInput.focus();
                }
            }
        }

        // Fonction pour gérer le copiage
        function onCopy(e) {
            var copiedData = window.getSelection().toString();

            console.log("données copiées:", copiedData);


            // Vérifie si les données copiées sont valides (chiffres uniquement)
            if (/^\d+$/.test(copiedData) && copiedData.length <= 6) {
                lastCopiedData = copiedData; // Stocke les données copiées
            }
        }

        // Fonction pour coller automatiquement les données copiées
        function pasteCopiedData() {
            if (lastCopiedData) {
                var inputs = body.find("input[name^='passwordNumber']").sort(function(a, b) {
                    return $(a).attr("name").localeCompare($(b).attr("name"));
                });

                lastCopiedData.split("").forEach((char, index) => {
                    if (inputs.eq(index).length) {
                        inputs.eq(index).val(char);
                    }
                });

                // Déplace le focus au dernier champ rempli
                var lastFilledInput = inputs.filter(function() {
                    return $(this).val().length === 1;
                }).last();

                if (lastFilledInput.length) {
                    lastFilledInput.focus();
                }

                lastCopiedData = null; // Réinitialise les données copiées
            }
        }

        function goToNextInput(e) {
            var key = e.which,
                t = $(e.target),
                sib = t.next("input");

            if (key === 9) { // Tabulation
                return true;
            }

            if (key < 48 || key > 57) { // Autorise uniquement les chiffres
                e.preventDefault();
                return false;
            }

            // Passe au champ suivant si la case actuelle est remplie
            if (t.val().length === 1) {
                if (!sib || !sib.length) {
                    sib = body.find("input").eq(0);
                }
                sib.select().focus();
            }
        }

        function onKeyDown(e) {
            var key = e.which,
                t = $(e.target),
                prev = t.prev("input");

            if (key === 9 || (key >= 48 && key <= 57)) { // Tabulation ou chiffres
                return true;
            }

            if (key === 8) { // Backspace
                e.preventDefault();
                if (t.val() === "" && prev.length) {
                    prev.val("").focus(); // Retour au champ précédent
                } else {
                    t.val(""); // Supprime la valeur actuelle
                }
                return false;
            }

            e.preventDefault();
            return false;
        }

        function onFocus(e) {
            $(e.target).select();
        }

        // Gestion des événements
        body.on("keyup", "input", goToNextInput);
        body.on("keydown", "input", onKeyDown);
        body.on("click", "input", onFocus);
        body.on("paste", "input", onPaste); // Gestion du collage
        body.on("copy", onCopy); // Gestion du copiage

        // Coller automatiquement les données copiées lorsqu'un champ reçoit le focus
        body.on("focus", "input[name^='passwordNumber']", function() {
            pasteCopiedData();
        });
    });
</script>




{{-- <script>
    // Fonction pour mettre à jour la valeur du champ en commentaire
    function updatePassword() {

        // Récupérer toutes les valeurs des inputs numériques
        const inputs = document.querySelectorAll('.input-password');
        let concatenatedValue = '';

        inputs.forEach(input => {
            concatenatedValue += input.value; // Concatenation des valeurs
        });

        // Affecter la valeur concaténée au champ caché
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.value = concatenatedValue;
        }

        console.log("value:", concatenatedValue);

    }

    // Ajouter l'événement input sur tous les champs numériques
    document.querySelectorAll('.input-password').forEach(input => {
        input.addEventListener('input', updatePassword);
    });
</script> --}}
