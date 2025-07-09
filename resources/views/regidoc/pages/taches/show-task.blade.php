<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<!--
    # Project developed by Newtech Consulting SARL
    # Contact : Tél: +(243) 977 776 901
                Email: contact@newtech-rdc.net
                Adresse: 374 avenue Colonel Mondjiba C/Ngaliema, Q/Basoko, Réf/Galerie St.Pierre
                Kinshasa - RDC
-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MaxiDoc | Gestion électronique des courriers</title>


    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('assets/regidoc/icon.ico') }}" type="image/x-icon">
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

        /* .vignette-column {
            /* overflow: hidden; */
        /* width: 100%; */
        /* padding: 0; /
            transition: .3s ease-in-out;
        }

        #vignet-container {
            overflow-y: scroll;
            height: calc(100vh - 71px);
        }

        .signature {
            position: fixed;
            /* pointer-events: none; Make the signature element ignore mouse events /
            z-index: 1041;
            /* display: none; */
        /* border: 1px solid #eee; /
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
        } */


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

        .vignette-page img {
            transition: .5s linear all;
        }

        .vignette-page:hover img {
            transform: scale(1.1);
        }

        .vignette-page.active img {
            border: 2px solid var(--primaryColor) !important;
        }

        .btn-primary .spinner-border {
            border-color: #fff !important;
            border-right-color: transparent !important;
        }

        .btn-loading {
            pointer-events: none;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }
    </style>
    @yield('styles')
    @livewireScripts()
</head>

<body>
    @php
        $docToShow = '';
        $nameDocToShow = '';
        $docToShowId = '';
        if ($tache?->documents->last()) {
            $docToShow = str_replace('\\', '/', files($tache->documents->last()->document)->link);
            $nameDocToShow = files($tache->documents->last()->document)->name;
            $docToShowId = $tache->documents->last()->id;
        }
        // dd(class_exists('imagick'));
    @endphp

    {{-- <div class="sidebar">

        <div class="logo text-start d-flex align-items-center justify-content-between py-3 px-3">
            <h6 class="mb-0" style="color: var(--colorTitre)">Détails de la tâche</h6>
        </div>

        <div class="content-sidebar">
            <div class="block-links">

                <ul class="lists">
                    @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                    @else
                        @if ($tache->documents->first())
                            <li>
                                <a href="{{ route('regidoc.documents.sign', ['doc_id' => $tache->documents->last()?->id, 'tache_id' => $tache->id, 'is_original' => $tache->documents->count() <= 1]) }}"
                                    @class([
                                        'signature_btn',
                                        'btn disabled' => $tache->tache_statut_id == 3,
                                    ]) @disabled($tache->tache_statut_id == 3)>
                                    <span class="d-flex align-items-center">
                                        <svg viewBox="0 0 24 24" width="512" height="512">
                                            <path
                                                d="M9,16h1.59c1.07,0,2.07-.42,2.83-1.17L23.12,5.12c.57-.57,.88-1.32,.88-2.12s-.31-1.55-.88-2.12c-1.17-1.17-3.07-1.17-4.24,0L9.17,10.59c-.76,.76-1.17,1.76-1.17,2.83v1.59c0,.55,.45,1,1,1ZM21.71,2.29c.19,.19,.29,.44,.29,.71s-.1,.52-.29,.71l-1.29,1.29-1.41-1.41,1.29-1.29c.39-.39,1.02-.39,1.41,0ZM10,13.41c0-.53,.21-1.04,.59-1.41l7-7,1.41,1.41-7,7c-.38,.38-.88,.59-1.41,.59h-.59v-.59Zm14,9.59c0,.55-.45,1-1,1-1.54,0-2.29-1.12-2.83-1.95-.5-.75-.75-1.05-1.17-1.05-.51,0-.9,.44-1.51,1.15-.7,.83-1.57,1.85-3.03,1.85s-2.32-1.03-3-1.87c-.58-.7-.96-1.13-1.46-1.13-.39,0-.63,.25-1.16,.91-.72,.88-1.71,2.09-3.84,2.09-2.76,0-5-2.24-5-5s2.24-5,5-5c.55,0,1,.45,1,1s-.45,1-1,1c-1.65,0-3,1.35-3,3s1.35,3,3,3c1.18,0,1.67-.6,2.29-1.36,.6-.73,1.34-1.64,2.71-1.64,1.47,0,2.32,1.03,3,1.87,.58,.7,.96,1.13,1.46,1.13s.9-.44,1.51-1.15c.7-.83,1.57-1.85,3.03-1.85s2.29,1.12,2.83,1.95c.5,.75,.75,1.05,1.17,1.05,.55,0,1,.45,1,1Z" />
                                        </svg>
                                    </span>
                                    <span class="title">
                                        Demander eSignature
                                    </span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a data-bs-toggle="offcanvas" href="#offcanvasInfoDoc" class="dropdown-item">
                                <span class="d-flex align-items-center">
                                    <svg viewBox="0 0 24 24" width="512" height="512">
                                        <path
                                            d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10.011,10.011,0,0,1,12,22Z" />
                                        <path d="M12,10H11a1,1,0,0,0,0,2h1v6a1,1,0,0,0,2,0V12A2,2,0,0,0,12,10Z" />
                                        <circle cx="12" cy="6.5" r="1.5" />
                                    </svg>
                                </span>
                                <span class="title">
                                    Détails de la tâche
                                </span>
                            </a>
                        </li>
                        <li class="assistant-trait">
                            <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasObj" aria-controls="offcanvasRight"
                                href="javascript:void(0)" class="dropdown-item" @class(['', 'btn disabled' => $tache->tache_statut_id == 3])
                                @disabled($tache->tache_statut_id == 3)>
                                <span class="d-flex align-items-center">
                                    <i class="fi fi-rr-list-check fi-rr"></i>
                                </span>
                                <span class="title">
                                    Tâches à réaliser
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasAnno" aria-controls="offcanvasRight"
                                @class(['', 'btn disabled' => $tache->tache_statut_id == 3]) @disabled($tache->tache_statut_id == 3)>
                                <span class="d-flex align-items-center">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="m22.75,9.693c.806.914,1.25,2.088,1.25,3.307v5c0,2.757-2.243,5-5,5H5c-2.757,0-5-2.243-5-5v-5c0-2.757,2.243-5,5-5h4c.553,0,1,.448,1,1s-.447,1-1,1h-4c-1.654,0-3,1.346-3,3v5c0,1.654,1.346,3,3,3h14c1.654,0,3-1.346,3-3v-5c0-.731-.267-1.436-.75-1.984-.365-.414-.326-1.046.089-1.412.413-.364,1.045-.326,1.411.088ZM5,15.5c0,.828.672,1.5,1.5,1.5s1.5-.672,1.5-1.5-.672-1.5-1.5-1.5-1.5.672-1.5,1.5Zm6.5,1.5c.828,0,1.5-.672,1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5,1.5.672,1.5,1.5,1.5Zm.5-6v-1.586c0-1.068.416-2.073,1.172-2.828L18.879.879c1.17-1.17,3.072-1.17,4.242,0,.566.566.879,1.32.879,2.121s-.313,1.555-.879,2.122l-5.707,5.707c-.755.755-1.76,1.172-2.828,1.172h-1.586c-.553,0-1-.448-1-1Zm2-1h.586c.534,0,1.036-.208,1.414-.586l5.707-5.707c.189-.189.293-.44.293-.707s-.104-.518-.293-.707c-.391-.391-1.023-.39-1.414,0l-5.707,5.707c-.372.373-.586.888-.586,1.414v.586Z" />
                                    </svg>
                                </span>
                                <span class="title">
                                    Annotations
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="javascrip:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComment"
                                aria-controls="offcanvasRight" @class(['', 'btn disabled' => $tache->tache_statut_id == 3])
                                @disabled($tache->tache_statut_id == 3)>
                                <span class="d-flex align-items-center">
                                    <i class="fi fi-rr-comments"></i>
                                </span>
                                <span class="title">
                                    Commentaires
                                </span>
                            </a>
                        </li>
                        <li>
                            <a data-bs-toggle="offcanvas" href="#offcanvasDoc" class="dropdown-item">
                                <span class="d-flex align-items-center">
                                    <i class="fi fi-rr-file"></i>
                                </span>
                                <span class="title">
                                    Pièces jointes
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div> --}}

    <div id="pdf-main-container" class="container-doc" data-docid="{{ $docToShowId }}" data-url="{{ $docToShow }}"
        data-name="{{ $nameDocToShow }}"
        @if ($tache->courrier) data-courrier="{{ $tache->courrier->id }}" @endif>
        <div id="pdf-meta" class="nav-tools-page nav-tache">
            <div class="row w-100 ms-0 align-items-center g-2 g-lg-3">
                <div class="col-lg-2 d-none">
                    <div class="d-flex align-items-center justify-content-between justify-content-sm-start">
                        {{-- @livewire('doc-select', ['tache' => $tache]) --}}
                        <div class="menu-action d-flex d-lg-none">
                            <i class="fi fi-rr-menu-burger"></i>
                        </div>

                        <div class="menu-action d-flex d-lg-none">
                            <i class="fi fi-rr-menu-burger"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="content-link-nav d-flex align-items-center">
                        <div class="links-nav d-flex align-items-center gap-2">
                            @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                            @else
                                @if ($tache->documents->first())
                                    <a href="{{ route('regidoc.documents.sign', ['doc_id' => $tache->documents->last()?->id, 'tache_id' => $tache->id, 'is_original' => $tache->documents->count() <= 1]) }}"
                                        class="link-nav" @disabled($tache->tache_statut_id == 3)>
                                        <svg viewBox="0 0 24 24" width="512" height="512">
                                            <path
                                                d="M9,16h1.59c1.07,0,2.07-.42,2.83-1.17L23.12,5.12c.57-.57,.88-1.32,.88-2.12s-.31-1.55-.88-2.12c-1.17-1.17-3.07-1.17-4.24,0L9.17,10.59c-.76,.76-1.17,1.76-1.17,2.83v1.59c0,.55,.45,1,1,1ZM21.71,2.29c.19,.19,.29,.44,.29,.71s-.1,.52-.29,.71l-1.29,1.29-1.41-1.41,1.29-1.29c.39-.39,1.02-.39,1.41,0ZM10,13.41c0-.53,.21-1.04,.59-1.41l7-7,1.41,1.41-7,7c-.38,.38-.88,.59-1.41,.59h-.59v-.59Zm14,9.59c0,.55-.45,1-1,1-1.54,0-2.29-1.12-2.83-1.95-.5-.75-.75-1.05-1.17-1.05-.51,0-.9,.44-1.51,1.15-.7,.83-1.57,1.85-3.03,1.85s-2.32-1.03-3-1.87c-.58-.7-.96-1.13-1.46-1.13-.39,0-.63,.25-1.16,.91-.72,.88-1.71,2.09-3.84,2.09-2.76,0-5-2.24-5-5s2.24-5,5-5c.55,0,1,.45,1,1s-.45,1-1,1c-1.65,0-3,1.35-3,3s1.35,3,3,3c1.18,0,1.67-.6,2.29-1.36,.6-.73,1.34-1.64,2.71-1.64,1.47,0,2.32,1.03,3,1.87,.58,.7,.96,1.13,1.46,1.13s.9-.44,1.51-1.15c.7-.83,1.57-1.85,3.03-1.85s2.29,1.12,2.83,1.95c.5,.75,.75,1.05,1.17,1.05,.55,0,1,.45,1,1Z" />
                                        </svg>
                                        Demander eSignature
                                    </a>
                                @endif
                                <a href="#offcanvasAnno" class="link-nav" data-bs-toggle="offcanvas">
                                    <svg viewBox="0 0 24 24">
                                        <path
                                            d="m22.75,9.693c.806.914,1.25,2.088,1.25,3.307v5c0,2.757-2.243,5-5,5H5c-2.757,0-5-2.243-5-5v-5c0-2.757,2.243-5,5-5h4c.553,0,1,.448,1,1s-.447,1-1,1h-4c-1.654,0-3,1.346-3,3v5c0,1.654,1.346,3,3,3h14c1.654,0,3-1.346,3-3v-5c0-.731-.267-1.436-.75-1.984-.365-.414-.326-1.046.089-1.412.413-.364,1.045-.326,1.411.088ZM5,15.5c0,.828.672,1.5,1.5,1.5s1.5-.672,1.5-1.5-.672-1.5-1.5-1.5-1.5.672-1.5,1.5Zm6.5,1.5c.828,0,1.5-.672,1.5-1.5s-.672-1.5-1.5-1.5-1.5.672-1.5,1.5.672,1.5,1.5,1.5Zm.5-6v-1.586c0-1.068.416-2.073,1.172-2.828L18.879.879c1.17-1.17,3.072-1.17,4.242,0,.566.566.879,1.32.879,2.121s-.313,1.555-.879,2.122l-5.707,5.707c-.755.755-1.76,1.172-2.828,1.172h-1.586c-.553,0-1-.448-1-1Zm2-1h.586c.534,0,1.036-.208,1.414-.586l5.707-5.707c.189-.189.293-.44.293-.707s-.104-.518-.293-.707c-.391-.391-1.023-.39-1.414,0l-5.707,5.707c-.372.373-.586.888-.586,1.414v.586Z" />
                                    </svg>
                                    Annotations
                                </a>
                                <a href="#offcanvasComment" class="link-nav" data-bs-toggle="offcanvas">
                                    <i class="fi fi-rr-comments"></i>
                                    Commentaires
                                </a>
                                <a href="#offcanvasDoc" class="link-nav" data-bs-toggle="offcanvas">
                                    <i class="fi fi-rr-clip"></i>
                                    Pièce jointes
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="gap-2 pb-2 gap-lg-3 d-flex justify-content-end align-items-center pb-sm-0">

                        {{-- @if (Auth::user()->agent->isDG() || Auth::id() == $tache->user_id)
                            @if ($tache->tache_statut_id == 3)
                                <small class="badge-task normal">Tâche terminée</small>
                            {{-- @else --}}
                        {{-- @if ($tache->documents->count())
                                    @if (!(Auth::user()->agent->isSecretaire() && $tache->isForDirection()))
                                        <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn text-white" style="background: var(--primaryColor)">
                                            Voir
                                        </a>
                                    @endif
                                @endif -}}
                            @endif
                            @if ($tache->tache_statut_id == 3)
                                <a href="{{ route('regidoc.taches.finish', $tache->id) }}" class="btn">Relancer la tâche</a>
                            @else
                                <a class="save_pdf btn " data-bs-toggle="modal" data-bs-target="#modal-validation">
                                    <i class="fi fi-rr-check"></i>
                                    <span class="d-none d-sm-inline-block">
                                        Marquer comme terminée
                                    </span>
                                </a>
                            @endif
                        @endif --}}

                        @if (Auth::user()->agent->isDG() || Auth::id() == $tache->user_id)
                            @if ($tache->tache_statut_id == 3)
                                <small class="badge-task-lg normal">Tâche terminée</small>
                            @endif

                            @if ($tache->tache_statut_id == 3)
                                <a href="{{ route('regidoc.taches.remettreEncours', $tache->id) }}"
                                    class="btn btn-conf-on">
                                    Relancer la tâche
                                </a>
                            @else
                                <a href="javascript:void(0)" data-bs-target="#modal-endtask" data-bs-toggle="modal"
                                    class="btn btn-conf-on">
                                    Cloturer la tâche
                                </a>
                            @endif
                        @else
                            @if ($tache->tache_statut_id == 3)
                                <small class="badge-task-lg normal">Tâche terminée</small>
                                {{-- @else
                                @if ($tache->documents)
                                    @if (Auth::user()->agent->isSecretaire() && $tache->isForDirection())
                                    @else
                                        <a href="{{ route('regidoc.taches.show', $tache) }}" class="btn">
                                            Traiter
                                        </a>
                                    @endif
                                @endif --}}
                            @endif

                            @if ($tache->parent_id == null && $tache->tache_statut_id != 3)
                                @if (!(Auth::user()->agent->isSecretaire() && $tache->isForDirection()))
                                    <a href="{{ route('regidoc.taches.create', ['parent_id' => $tache->id]) }}"
                                        class="btn btn-conf-on">
                                        Créer une sous-tâche
                                    </a>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="mx-auto text-center col-12" style="display: flex; justify-content: center;">
                    <div id="pdf-contents" class="text-center mx-auto mt-3" style="width: 100%!important">
                        <div id="pdf-loader">Chargement en cours...</div>
                    </div>
                    @if (!$tache->documents->first())
                        <div class="bg-white my-4 d-flex justify-content-center align-items-center mx-auto"
                            style="height: calc(100vh - 180px); width: 714px">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/sad.gif') }}" alt="" width="70px"
                                    class="">
                                <p>Aucun document n'est attaché à cette tâche</p>
                            </div>
                        </div>
                    @endif
                </div>
                @include('components.pdf-tools')
            </div>
        </div>
    </div>
    <div class="sidebar-tache left d-flex flex-column">
        <div class="header d-flex align-items-center" style="padding-top: 10px">
            <a href="javascript:history.back()" class="mb-0 back me-3">
                <i class="fi fi-rr-angle-left"></i>
                <div class="tooltip-indicator">
                    Retour
                </div>
            </a>
            <h5 class="mb-0">Tâches à réaliser</h5>
        </div>
        <div class="body flex-grow-1 pt-1">
            <div class="all-comments" style="overflow: hidden; height: auto!important;">
                @livewire('taches.objectif-check', ['tache' => $tache], key($tache->id))
            </div>
        </div>
    </div>
    <div class="sidebar-tache right d-flex flex-column">
        <div class="header d-flex align-items-center">
            <h5 class="mb-0">Détailles de la tâche</h5>
        </div>
        <div class="body flex-grow-1 pt-0" style="overflow: hidden!important">
            <div class="block-moreInfo-doc h-100" style="background: var(--bgContent);">
                <div class="row g-2">

                    <div class="col-12">
                        <h6 class="mb-2 title-info">Informations générales</h6>
                    </div>

                    <div class="col-12 col-tache">
                        <div class="block-panel-lg mb-2">
                            @livewire('taches.tache-info', ['tache' => $tache], key($tache->id))
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">Titre</span>
                                </div>
                                <div class="col-lg-12">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ Str::ucfirst($tache->titre ?? '') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">N° de référence</span>
                                </div>
                                <div class="col-lg-12">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        @if ($tache->courrier || $tache->parent_id)
                                            {{ $tache->parent_id ? 'Tâche / ' . Str::ucfirst($tache->tacheParent->titre) : 'Courrier / ' . Str::ucfirst($tache->courrier->reference_interne) }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Priorité
                                    </span>
                                </div>
                                <div class="col-lg-12">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ Str::ucfirst($tache->priorite->titre ?? '') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Date de la tâche
                                    </span>
                                </div>
                                <div class="col-lg-12">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ $tache->created_at?->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    @if ($tache->date_fin)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Date d'échéance
                                        </span>
                                    </div>
                                    <div class="col-lg-12">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $tache->date_fin?->isoFormat('LL') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Objet
                                    </span>
                                </div>
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {!! $tache->description !!} 
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Ajouté par
                                    </span>
                                </div>
                                <div class="col-lg-12">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ Str::ucfirst($tache->user?->agent?->nom . ' ' . $tache->user?->agent?->post_nom ?? ('' . $tache->user?->agent?->prenom ?? '')) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-12">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Période
                                    </span>
                                </div>
                                <div class="col-12">
                                    <p>
                                        {{ $tache->date_fin ? 'Du' . $tache->date_debut?->format('d/m/Y') : $tache->date_debut?->format('d-m-Y') }}
                                        {{ $tache->date_fin ? 'Au ' . $tache->date_fin?->format('d/m/Y') : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="back-overplay"></div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasInfoDoc" aria-labelledby="offcanvasRightLabel"
        style="width: 550px;">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Informations de la tâche</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body">

            <div class="block-moreInfo-doc h-100" style="background: var(--bgContent);">
                <div class="row g-2">

                    <div class="col-12">
                        <h6 class="mb-2 title-info">Informations générales</h6>
                    </div>

                    <div class="col-12 col-tache">
                        <div class="block-panel-lg mb-2">
                            @livewire('taches.tache-info', ['tache' => $tache], key($tache->id))
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">Titre</span>
                                </div>
                                <div class="col-lg-6">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ Str::ucfirst($tache->titre ?? '') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">Référence</span>
                                </div>
                                <div class="col-lg-6">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        @if ($tache->courrier || $tache->parent_id)
                                            {{ $tache->parent_id ? 'Tâche / ' . Str::ucfirst($tache->tacheParent->titre) : 'Courrier / ' . Str::ucfirst($tache->courrier->reference_interne) }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Priorité
                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ Str::ucfirst($tache->priorite->titre ?? '') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Date de la tâche
                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ $tache->created_at?->isoFormat('LL') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    @if ($tache->date_fin)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Date d'échéance
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $tache->date_fin?->isoFormat('LL') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Objet
                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {!! $tache->description !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">
                                        Ajouté par
                                    </span>
                                </div>
                                <div class="col-lg-6">
                                    <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                        {{ Str::ucfirst($tache->user?->agent?->nom . ' ' . $tache->user?->agent?->post_nom ?? ('' . $tache->user?->agent?->prenom ?? '')) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAnno" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                Annotations
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="all-comments">
                <div class="annot-block mt-2">
                    {!! $tache->description !!}
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasObj" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                Objectifs
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="all-comments" style="overflow: hidden; height: auto!important;">
                @livewire('taches.objectif-check', ['tache' => $tache], key($tache->id))
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComment" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                Commentaires
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body pe-0" style="overflow-y: hidden">
            @livewire('taches.tache-commentaire-pane', ['tache_id' => $tache->id])
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDoc" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">
                Les pièces jointes
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body">
            @livewire('taches.tache-document-pane', ['tache' => $tache])
            <hr>
            @php
                $urls = [];
                foreach ($tache->documents as $document) {
                    array_push($urls, [
                        'link' => files($document->document)->link,
                        'id' => $document->id,
                        'tache_id' => $tache->id ?? '',
                    ]);
                }
            @endphp
            <h6 class="mb-4">Toutes les pièces jointes</h6>
            <div class="doc-vignette d-flex gap-1 flex-wrap" data-url="{{ json_encode($urls) }}"></div>
        </div>
    </div>

    <div class="modal fade modal-sm" id="modal-endtask" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-2">
                        <div class="col-12">
                            <div class="text-center">
                                <h6>Vous êtes sur le point de mettre fin à cette tâche. Souhaitez-vous le confirmer ?
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 from-group row">
                        <div class="mb-3 col-lg-12">
                            <div class="d-flex justify-content-between gap-2">
                                <button class="btn btn-sm btn-light w-50" data-bs-dismiss="modal"
                                    aria-label="Close">Annuler</button>
                                <a href="{{ route('regidoc.taches.finish', $tache->id) }}"
                                    class="mt-0 btn btn-add w-50">Valider</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-validation" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Confirmation</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:80%; width:90%; background-color:rgba(255,255,255,0.95)"
                        wire:loading="" wire:target="filter" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row g-2">
                        <div class="col-12">
                            <div class="text-center">
                                <p>Vous êtes sur le point de valider ce traitement. Souhaitez-vous le confirmer ?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Close">Annuler</button>
                    <a href="{{ route('regidoc.taches.finish', $tache->id) }}" class="btn btn-add mt-0">Valider</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-reject" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Rejeter le document</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-none position-absolute d-flex loader-card justify-content-center"
                        style="z-index: 2; height:90%; width:90%; background-color:rgba(255,255,255,0.95)"
                        wire:loading="" wire:target="filter" wire:loading.class.remove="d-none">
                        <div class="m-auto text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row g-2">
                        <div class="col-lg-12">
                            <label for="note">Note</label>
                            <textarea name="note" id="note" cols="30" rows="5" class="form-control"
                                placeholder="Saisissez vos annotations ici" required></textarea>
                        </div>
                    </div>
                    <div class="from-group row mt-3">
                        <div class="col-lg-12 text-end mb-3">
                            <button type="reset" class="btn btn-cansel" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-add mt-0 btn-rejeter">Enregistrer</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- @livewire('taches.add-tache-participant-modal', ['tache' => $tache], key($tache->id)) --}}

    @include('regidoc.layouts.partials.head.scripts')
    @yield('scripts')
    @stack('scripts')
    @stack('livewireScripts')
    @if (session()->get('session') && json_decode(session()->get('session'))->name != '')
        @if (json_decode(session()->get('session'))->statut == 'success')
            <div class="message-flash success">
                <div class="content-text d-flex">
                    <div class="icon">
                        <i class="bi bi-check"></i>
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'warnig')
            <div class="message-flash warning">
                <div class="content-text d-flex">
                    <div class="icon">
                        <i data-feather="alert-circle"></i>
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @elseif(json_decode(session()->get('session'))->statut == 'error')
            <div class="message-flash error">
                <div class="content-text d-flex">
                    <div class="icon">
                        <i data-feather="x-circle"></i>
                    </div>
                    <div class="text-star">
                        <h6>{{ json_decode(session()->get('session'))->name }}</h6>
                        <p>{{ json_decode(session()->get('session'))->message }}</p>
                    </div>
                </div>
            </div>
        @endif

    @endif

    @livewire('livewire-alert')

    {{-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> --}}
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/showPDF.js') }}"></script>

    <script>
        window.addEventListener('alert', event => {
            $('.message-flash.wire').addClass('show')
            setTimeout(() => {
                $('.message-flash.wire').removeClass('show')
            }, 5000);
        });

        @if (session()->get('session') && json_decode(session()->get('session'))->name != '')
            $('.message-flash:not(.wire)').addClass('show')
            setTimeout(() => {
                $('.message-flash:not(.wire)').removeClass('show')
            }, 10000);
        @endif
    </script>

    <script>
        // Livewire.on('documentAdded', (e) => {
        //     $(".doc-vignette").empty();
        //     showFirstPageImg(e, $(".doc-vignette"));
        // });

        Livewire.on('documentChanged', function(evt) {
            $('#pdf-contents').empty();
            url = evt.doc;
            showPDF(url);
        });

        Livewire.on('assistantSeen', function(evt) {
            $('.assistant-trait').removeClass('d-none');
        });

        Livewire.on('pageExpired', function(response, message) {
            location.reload()
        });
        $('.block-action-doc').click(function() {
            $('.all-annot').addClass('show')
            $('.back-overplay').addClass('show')
            $('body').addClass('overflow-hidden')
        })
        $('.menu-action').click(function() {
            $('.sidebar').addClass('sidebar-respo')
            $('.back-overplay').addClass('show')
            $('body').addClass('overflow-hidden')
        })
        $('.back-overplay, .close-parent').click(function() {
            $('.back-overplay').removeClass('show')
            $('.all-annot').removeClass('show')
            $('body').removeClass('overflow-hidden')
            $('.sidebar').removeClass('sidebar-respo')
        })

        document.addEventListener('livewire:load', function() {
            var inputFileParam = document.querySelectorAll('.file-param');
            $(inputFileParam).each(function() {
                $(this).on('change', function() {
                    const fichiers = this.files;
                    const parent = $(this).parent();

                    if (fichiers.length > 0) {
                        const fichier = fichiers[0];
                        let namefile = fichier.name;
                        let splitName = namefile.split('.');
                        namefile = splitName[0].substring(0, 12) + "... ." + splitName[1];
                        $(parent).find('span').text(namefile);
                        $(parent).find('span').addClass('opacity');
                    }
                });
            });

            Livewire.on('documentAdded', function() {
                $('.btn-file-action').prop('disabled',
                    false); // Assurez-vous de réactiver le bouton après le chargement.
            });
        });
    </script>
</body>

</html>
