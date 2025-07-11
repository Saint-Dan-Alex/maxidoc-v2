<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

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
    @yield('styles')
    @livewireScripts()
</head>

<body>
    @php
        $docToShow = '';
        $nameDocToShow = '';
        $docToShowId = '';
        if ($courrier->traitements->count()) {
            if ($courrier->traitements->last()->document_url) {
                $docToShow = str_replace('\\', '/', files($courrier->traitements->last()->document_url)->link);
                $nameDocToShow = files($courrier->traitements->last()->document_url)->name;
                // $docToShowId = $tache->documents->last()->id;
            } else {
                $docToShow = str_replace('\\', '/', files($courrier->document?->document)->link);
                $nameDocToShow = files($courrier->document?->document)->name;
                $docToShowId = $courrier->document?->id;
            }
        } else {
            $docToShow = str_replace('\\', '/', files($courrier->document?->document)->link);
            $nameDocToShow = files($courrier->document?->document)->name;
            $docToShowId = $courrier->document?->id;
        }
    @endphp

    <div class="sidebar">
        <div class="px-3 py-3 logo text-start d-flex align-items-center justify-content-between">
            <h6 class="mb-0" style="color: var(--colorTitre)">Aperçu du courrier</h6>
        </div>

        <div class="content-sidebar">
            <div class="block-links">
                @livewire('courrier.accuser-reception', ['courrier' => $courrier])
                @php
                    $aTraite = $courrier->traitements->where('agent_id', Auth::user()->agent->id)->count() > 0;

                    $aTraite = $aTraite || ($courrier->type_id != 1 && $courrier->parent_id != null);

                    if (Auth::user()->agent->isDG() || Auth::user()->agent->isDelegue()) {
                        $aTraite = $aTraite && $courrier->mark_as_done == 1;
                    }
                    // dd($aTraite);

                    $hasSeen = false;
                    foreach ($courrier->etapes as $etape) {
                        if ($etape->pivot->view_by == Auth::user()->id) {
                            $hasSeen = true;
                            break;
                        }
                    }
                @endphp
                <ul class="lists">
                    @if ($courrier->type_id != 2)
                        {{-- <li class="assistant-trait @if (!($hasSeen && (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) && $courrier->author->id != Auth::user()->agent->id && !$aTraite)) d-none @endif"> --}}
                        @php
                            $dgaSecretaires = \App\Models\Direction::find(1)
                                ->dgaSecretaires->pluck('responsable_id')
                                ->toArray();
                            $dgaAssistants = \App\Models\Direction::find(1)
                                ->dgaAssistanats->pluck('responsable_id')
                                ->toArray();
                        @endphp
                        @if (!in_array(Auth::user()->agent->id, $dgaSecretaires) && !in_array(Auth::user()->agent->id, $dgaAssistants))
                            <li class="assistant-trait @if (
                                !(
                                    $hasSeen &&
                                    (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) &&
                                    $courrier->author->id != Auth::user()->agent->id &&
                                    !$aTraite
                                )) d-none @endif">
                                <a data-bs-toggle="modal" data-bs-target="#traitement-modal" href="javascript:void(0)"
                                    class="dropdown-item">
                                    <span class="d-flex align-items-center">
                                        <i class="fi fi-rr-hourglass-end"></i>
                                    </span>
                                    <span class="title">
                                        Traiter
                                    </span>
                                </a>
                            </li>
                        @endif
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
                                Détails du courrier
                            </span>
                        </a>
                    </li>

                    @can('Suivi des courriers')
                        <li>
                            <a class="dropdown-item" href="javascrip:void(0)" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasHisto" aria-controls="offcanvasRight">
                                <i class="fi fi-rr-list"></i>
                                <span class="title">Historique des activités</span>
                            </a>
                        </li>
                    @endcan

                    @if ($courrier->type_id != 2)
                        @can('Assigner une tâche')
                            @if ($courrier->document)
                                @if (!Auth::user()->agent->isSecretaire())
                                    @if (!Auth::user()->agent->isDGA())
                                        <li>
                                            <a href="javascript:void(0)" data-bs-target="#dga-modal" data-bs-toggle="modal"
                                                @class(['dropdown-item', 'btn disabled' => $aTraite]) @disabled($aTraite)>
                                                <span class="d-flex align-items-center">
                                                    <svg viewBox="0 0 24 24" width="512" height="512">
                                                        <path
                                                            d="M19,4h-1.1c-.46-2.28-2.48-4-4.9-4h-2c-2.41,0-4.43,1.72-4.9,4h-1.1C2.24,4,0,6.24,0,9v10c0,2.76,2.24,5,5,5h14c2.76,0,5-2.24,5-5V9c0-2.76-2.24-5-5-5ZM11,2h2c1.3,0,2.42,.84,2.83,2h-7.66c.41-1.16,1.52-2,2.83-2Zm11,17c0,1.65-1.35,3-3,3H5c-1.65,0-3-1.35-3-3V9c0-1.65,1.35-3,3-3h14c1.65,0,3,1.35,3,3v10Zm-4.85-7.1c.54,.54,.85,1.3,.85,2.1s-.31,1.55-.88,2.12l-2.39,2.56c-.2,.21-.46,.32-.73,.32-.24,0-.49-.09-.68-.27-.4-.38-.43-1.01-.05-1.41l2.16-2.32H7c-.55,0-1-.45-1-1s.45-1,1-1H15.43l-2.16-2.32c-.38-.4-.35-1.04,.05-1.41,.4-.38,1.04-.35,1.41,.05l2.41,2.59Z" />
                                                    </svg>
                                                </span>
                                                <span class="title">
                                                    Transmettre au DGA
                                                </span>
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'direction', 'courrier_id' => $courrier->id]) }}"
                                            @class(['dropdown-item', 'btn disabled' => $aTraite]) @disabled($aTraite)>
                                            <span class="d-flex align-items-center">
                                                <svg viewBox="0 0 24 24" width="512" height="512">
                                                    <path
                                                        d="M19,4h-1.1c-.46-2.28-2.48-4-4.9-4h-2c-2.41,0-4.43,1.72-4.9,4h-1.1C2.24,4,0,6.24,0,9v10c0,2.76,2.24,5,5,5h14c2.76,0,5-2.24,5-5V9c0-2.76-2.24-5-5-5ZM11,2h2c1.3,0,2.42,.84,2.83,2h-7.66c.41-1.16,1.52-2,2.83-2Zm11,17c0,1.65-1.35,3-3,3H5c-1.65,0-3-1.35-3-3V9c0-1.65,1.35-3,3-3h14c1.65,0,3,1.35,3,3v10Zm-4.85-7.1c.54,.54,.85,1.3,.85,2.1s-.31,1.55-.88,2.12l-2.39,2.56c-.2,.21-.46,.32-.73,.32-.24,0-.49-.09-.68-.27-.4-.38-.43-1.01-.05-1.41l2.16-2.32H7c-.55,0-1-.45-1-1s.45-1,1-1H15.43l-2.16-2.32c-.38-.4-.35-1.04,.05-1.41,.4-.38,1.04-.35,1.41,.05l2.41,2.59Z" />
                                                </svg>
                                            </span>
                                            <span class="title">
                                                Assigner à une direction
                                            </span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'agent', 'courrier_id' => $courrier->id]) }}"
                                            @class(['dropdown-item', 'btn disabled' => $aTraite]) @disabled($aTraite)>
                                            <span class="d-flex align-items-center">
                                                <svg viewBox="0 0 24 24" width="512" height="512">
                                                    <path
                                                        d="M15,6c0-3.309-2.691-6-6-6S3,2.691,3,6s2.691,6,6,6,6-2.691,6-6Zm-6,4c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm-.008,4.938c.068,.548-.32,1.047-.869,1.116-3.491,.436-6.124,3.421-6.124,6.946,0,.552-.448,1-1,1s-1-.448-1-1c0-4.531,3.386-8.37,7.876-8.93,.542-.069,1.047,.32,1.116,.869Zm13.704,4.195l-.974-.562c.166-.497,.278-1.019,.278-1.572s-.111-1.075-.278-1.572l.974-.562c.478-.276,.642-.888,.366-1.366-.277-.479-.887-.644-1.366-.366l-.973,.562c-.705-.794-1.644-1.375-2.723-1.594v-1.101c0-.552-.448-1-1-1s-1,.448-1,1v1.101c-1.079,.22-2.018,.801-2.723,1.594l-.973-.562c-.48-.277-1.09-.113-1.366,.366-.276,.479-.112,1.09,.366,1.366l.974,.562c-.166,.497-.278,1.019-.278,1.572s.111,1.075,.278,1.572l-.974,.562c-.478,.276-.642,.888-.366,1.366,.186,.321,.521,.5,.867,.5,.169,0,.341-.043,.499-.134l.973-.562c.705,.794,1.644,1.375,2.723,1.594v1.101c0,.552,.448,1,1,1s1-.448,1-1v-1.101c1.079-.22,2.018-.801,2.723-1.594l.973,.562c.158,.091,.33,.134,.499,.134,.346,0,.682-.179,.867-.5,.276-.479,.112-1.09-.366-1.366Zm-5.696,.866c-1.654,0-3-1.346-3-3s1.346-3,3-3,3,1.346,3,3-1.346,3-3,3Z" />
                                                </svg>
                                            </span>
                                            <span class="title">
                                                Assigner à un agent
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endcan

                        @can('Signer un courrier')
                            @if (!Auth::user()->agent->isSecretaire())
                                <li>
                                    <a href="{{ route('regidoc.documents.sign', ['doc_id' => $courrier->document?->id, 'is_original' => true, 'courrier_id' => $courrier->id]) }}{{-- route('regidoc.courriers.signer',$courrier) --}}"
                                        @class(['dropdown-item signature_btn', 'btn disabled' => $aTraite]) @disabled($aTraite)>
                                        {{-- <a href="{{ route('regidoc.courriers.signer', $courrier) }}" @class(['dropdown-item', 'btn disabled' => $aTraite])
                                        @disabled($aTraite)> --}}
                                        <span class="d-flex align-items-center">
                                            <svg viewBox="0 0 24 24" width="512" height="512">
                                                <path
                                                    d="M9,16h1.59c1.07,0,2.07-.42,2.83-1.17L23.12,5.12c.57-.57,.88-1.32,.88-2.12s-.31-1.55-.88-2.12c-1.17-1.17-3.07-1.17-4.24,0L9.17,10.59c-.76,.76-1.17,1.76-1.17,2.83v1.59c0,.55,.45,1,1,1ZM21.71,2.29c.19,.19,.29,.44,.29,.71s-.1,.52-.29,.71l-1.29,1.29-1.41-1.41,1.29-1.29c.39-.39,1.02-.39,1.41,0ZM10,13.41c0-.53,.21-1.04,.59-1.41l7-7,1.41,1.41-7,7c-.38,.38-.88,.59-1.41,.59h-.59v-.59Zm14,9.59c0,.55-.45,1-1,1-1.54,0-2.29-1.12-2.83-1.95-.5-.75-.75-1.05-1.17-1.05-.51,0-.9,.44-1.51,1.15-.7,.83-1.57,1.85-3.03,1.85s-2.32-1.03-3-1.87c-.58-.7-.96-1.13-1.46-1.13-.39,0-.63,.25-1.16,.91-.72,.88-1.71,2.09-3.84,2.09-2.76,0-5-2.24-5-5s2.24-5,5-5c.55,0,1,.45,1,1s-.45,1-1,1c-1.65,0-3,1.35-3,3s1.35,3,3,3c1.18,0,1.67-.6,2.29-1.36,.6-.73,1.34-1.64,2.71-1.64,1.47,0,2.32,1.03,3,1.87,.58,.7,.96,1.13,1.46,1.13s.9-.44,1.51-1.15c.7-.83,1.57-1.85,3.03-1.85s2.29,1.12,2.83,1.95c.5,.75,.75,1.05,1.17,1.05,.55,0,1,.45,1,1Z" />
                                            </svg>
                                        </span>
                                        <span class="title">
                                            Signer
                                        </span>
                                    </a>
                                </li>
                            @endif
                        @endcan


                        @can('Valider un courrier')
                            @if($courrier->statut_id != 3 && $courrier->statut_id != 4)
                            <li>
                                <a href="javascript:void(0)" class="dropdown-item btn-valider-courrier" data-id="{{ $courrier->id }}">
                                    <span class="d-flex align-items-center">
                                        <svg viewBox="0 0 24 24" width="512" height="512">
                                            <path d="M9,16.17L4.83,12l-1.42,1.41L9,19L21,7l-1.41-1.41L9,16.17z"/>
                                        </svg>
                                    </span>
                                    <span class="title">
                                        Valider
                                    </span>
                                </a>
                            </li>
                            @endif
                        @endcan

                        @can('Partager un courrier')
                            @if (!Auth::user()->agent->isSecretaire())
                                <li>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#modal-new-task-ass"
                                        @class(['dropdown-item', 'btn disabled' => $aTraite]) @disabled($aTraite)>
                                        <i class="fi fi-rr-share"></i>
                                        <span class="title"> Partager pour traitement</span>
                                    </a>
                                </li>
                            @endif
                        @endcan
                    @endif

                        @can('Rejeter un courrier')
                            @if($courrier->statut_id != 3 && $courrier->statut_id != 4)
                            <li>
                                <a href="javascript:void(0)" class="dropdown-item btn-rejeter-courrier" data-id="{{ $courrier->id }}">
                                    <span class="d-flex align-items-center">
                                        <svg viewBox="0 0 24 24" width="512" height="512">
                                            <path d="M16,8a1,1,0,0,0-1.414,0L12,10.586,9.414,8A1,1,0,0,0,8,9.414L10.586,12,8,14.586A1,1,0,0,0,9.414,16L12,13.414,14.586,16A1,1,0,0,0,16,14.586L13.414,12,16,9.414A1,1,0,0,0,16,8Z"/>
                                            <path d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10.011,10.011,0,0,1,12,22Z"/>
                                        </svg>
                                    </span>
                                    <span class="title">
                                        Rejeter
                                    </span>
                                </a>
                            </li>
                            @endif
                        @endcan

                    @can('Annoter un courrier')
                        @if (
                            $hasSeen &&
                                (Auth::user()->agent->isAssistant() || Auth::user()->agent->isSecretaire()) &&
                                $courrier->author->id != Auth::user()->agent->id &&
                                !$aTraite)
                            <li>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-new-annotation"
                                    @class(['dropdown-item', 'btn disabled' => $aTraite]) @disabled($aTraite)>
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
                        @endif
                    @endcan
                </ul>
            </div>
        </div>

    </div>
    <div id="page-load" class="d-none">
        <div class="backdrop fade"></div>
        <div class="parent-modal">
            <div class="dialog dialog-centered">
                <div class="content-modal">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="load-spiner">
                            </div>
                            <div class="text-stared">
                                <h6 class="mb-0" style="color:var(--colorTitre)!important;">
                                    Chargement en cours...
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div id="pdf-main-container" class="d-flex flex-column" data-docid="{{ $docToShowId }}"
        data-url="{{ $docToShow }}" data-name="{{ $nameDocToShow }}" data-courrier="{{ $courrier->id }}"
        @if ($courrier->confidentiel) data-code="{{ $courrier->document?->password }}" @endif>
        <div id="pdf-meta" class="nav-tools-page">
            <div class="row w-100 ms-0 align-items-center g-3 g-lg-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center justify-content-between justify-content-sm-start">
                        {{-- <a href="{{ route('regidoc.courriers.index') }}" class="mb-0 back me-3">
                            <i class="fi fi-rr-angle-left"></i>
                            <div class="tooltip-indicator">
                                Retour
                            </div>
                        </a> --}}
                        <a href="{{ url()->previous() }}" class="mb-0 back me-3">
                            <i class="fi fi-rr-angle-left"></i>
                            <div class="tooltip-indicator">
                                Retour
                            </div>
                        </a>
                        @livewire('courrier.traitement-doc-select', ['courrier' => $courrier])
                        <div class="menu-action d-flex d-lg-none">
                            <i class="fi fi-rr-menu-burger"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="gap-2 pb-2 gap-lg-3 d-flex justify-content-end align-items-center pb-sm-0">
                        @can('Annoter un courrier')
                            @if (!Auth::user()->agent->isSecretaire())
                                <a href="#" class="link-action" data-bs-toggle="modal"
                                    data-bs-target="#modal-add-annotation">
                                    <div class="card card-btnCourier ">
                                        <button class="btn btn-primary btn-addCourier text-white">
                                            <i class="fi fi-rr-plus"></i>
                                            <div class="tooltip-btn">
                                                Ajouter une annotation
                                            </div>
                                        </button>
                                    </div>
                                </a>
                            @endif
                        @endcan
                        <div class=" annotation-btn-float">
                            <button class="btn show-vignette">
                                <i class="fi fi-rr-comment-quote"></i>
                                <div class="tooltip-btn">
                                    Voir les annotations
                                </div>
                            </button>
                        </div>
                        @if ($courrier->type_id == 1)
                            @if ((Auth::user()->agent->isDG() || Auth::user()->agent->isDelegue()) && $courrier->mark_as_done != 1)
                                <a href="{{ route('regidoc.courriers.traitement', $courrier) }}"
                                    class="save_pdf btn "><i class="fi fi-rr-check"></i>
                                    <span class="ms-1 d-none d-sm-inline-block">
                                        Marquer comme traité
                                    </span>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-grow-1">
            <div class="container-fluid">
                <div class="row justify-content-end">
                    <div class="mx-auto text-center col-lg-9">

                        @if (
                            $courrier->traitement &&
                                (Auth::user()->agent->isDG() || Auth::user()->agent->isDelegue()) &&
                                $courrier->traitements->where('agent_id', Auth::user()->agent->id)->count() <= 0)
                            <div class="d-flex  align-items-center block-action-doc mt-2" style="max-width: 100%">
                                <p class="mb-0 d-inline-flex g-2 align-items-center">
                                <div class="content-scanner-iconFileBox">
                                    <img class="content-scanner-iconFileBox-image me-4"
                                        src="{{ asset('assets/images/icons/accuse-reception--.png') }}"
                                        alt="file icon" />
                                </div>
                                {{-- <i class="fi fi-rr-magic-wand"></i> --}}
                                Document transmis pour {{ Str::ucfirst($courrier->traitement->titre ?? '') }}
                                </p>
                                <div class="d-flex align-items-center ms-auto">
                                    @php
                                        $url = 'javascript:void(0)';
                                        $attributs = '';
                                        $text = 'Exécuter';
                                        switch ($courrier->traitement->id) {
                                            case 1:
                                                $url =
                                                    '/system/documents/sign/task?doc_id=' .
                                                    $courrier->document?->id .
                                                    '&is_original=1&courrier_id=' .
                                                    $courrier->id; //route('regidoc.courriers.signer', $courrier->id);
                                                break;
                                            case 2:
                                                $attributs = 'data-bs-toggle="modal" data-bs-target="#modal-a-asigner"';
                                                break;
                                            case 3:
                                                $attributs = 'data-bs-toggle="modal" data-bs-target="#modal-a-traiter"';
                                                break;

                                            default:
                                                $attributs = 'data-bs-toggle="modal" data-bs-target="#modal-a-traiter"';
                                                break;
                                        }

                                    @endphp
                                    @if (!$aTraite)
                                        <a href="{{ $url != 'javascript:void(0)' ? url($url) : $url }}"
                                            class="btn btn-light" {!! $attributs !!}>
                                            {{ $text }}
                                        </a>
                                    @endif
                                </div>
                                {{-- @endif --}}
                            </div>
                        @endif

                        <div id="pdf-contents" class="mt-3" style="width: 100%!important">
                            {{-- <div id="pdf-loader">Loading document ...</div> --}}
                            @if ($courrier->confidentiel)
                                <div class="p-5 text-center bg-white confidentiel-doc position-relative mx-auto">
                                    <i class="fi fi-rr-lock"></i>
                                    <h5>Ce document est crypté</h5>
                                    <div class="w-50 mx-auto mt-3">
                                        <p>Veuillez saisir le code secret</p>
                                        <input type="text" class="form-control code-confident"
                                            placeholder="Code confidentiel">
                                        <small class="text-danger code-error-label d-none">Mot de pass incorect</small>
                                        <button
                                            class="btn btn-primary mt-3 text-white w-100 validate-code">Valider</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @include('components.pdf-tools')

                    </div>



                    @livewire('courrier.annotation-list', ['courrier' => $courrier])

                </div>
            </div>
        </div>



    </div>

    <div class="back-overplay"></div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasInfoDoc" aria-labelledby="offcanvasRightLabel"
        style="width: 550px;">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Détails du courrier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="fi fi-rr-cross"></i>
            </button>
        </div>
        <div class="offcanvas-body">

            <div class="block-moreInfo-doc h-100" style="background: var(--bgContent);">
                <div class="row g-2">

                    @php
                        $courrierViewers = $courrier->etapes
                            ->map(function ($etape) {
                                $agent = \App\Models\User::find($etape->pivot->view_by)?->agent;
                                // if ($agent && !$agent->is(Auth::user()->agent)) {
                                //     return $agent;
                                // }
                                return $agent;
                            })
                            ->reject(function ($agent) {
                                return $agent == null;
                            });
                        $courrierViewers = $courrierViewers->push($courrier->author);
                        $courrierViewers = $courrierViewers->unique();
                    @endphp

                    <div class="col-12">
                        <h6 class="mb-2 title-info">Intervenants</h6>
                    </div>

                    {{-- @if ($courrierViewers->count()) --}}

                    <div class="col-12">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-6">
                                    <span style="font-size: 13px; color: var(--colorParagraph)">Accusées
                                        réceptions</span>
                                </div>
                                <div class="col-lg-6">
                                    {{-- @foreach ($courrierViewers->accuseReceptions() as $agentViewed) --}}
                                    @forelse ($courrier->accuseReceptions as $accuseReception)
                                        @if ($accuseReception->user && $accuseReception->user->agent)
                                            <div class="detailCourierUserInfosBox">
                                                <div class="avatarDetailCourier">
                                                    <img class="avatarDetailCourier-avatar"
                                                        src="{{ imageOrDefault($accuseReception->user->agent?->image) }}"
                                                        alt="image profil">
                                                </div>

                                                <p style="font-size: 14px; color: var(--colorTitre)" class="mb-2">
                                                    {{ Str::ucfirst($accuseReception->user->agent->prenom ?? '') . ' ' . Str::ucfirst($accuseReception->user->agent->nom ?? '') }}
                                                    <small
                                                        class="d-block">({{ $accuseReception->user->agent->poste?->titre }})</small>
                                                </p>
                                            </div>
                                        @endif
                                    @empty

                                        <p style="font-size: 13px; color: var(--colorTitre)">Pas d'accusé de réception
                                            pour le moment.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>


                    @if ($courrier->followers->count())
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">En copie</span>
                                    </div>
                                    <div class="col-lg-6">
                                        @foreach ($courrier->followers->unique() as $follower)
                                            <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                                {{ Str::ucfirst($follower->prenom ?? '') . ' ' . Str::ucfirst($follower->nom ?? '') }}
                                            </p>
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif
                    <hr class="mt-4">

                    <div class="col-12">
                        <h6 class="mt-3 mb-2 title-info">Informations générales</h6>
                    </div>

                    @if ($courrier->title)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">Titre</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ Str::ucfirst($courrier->title ?? '') }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($courrier->reference_courrier)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">Référence</span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ Str::ucfirst($courrier->reference_courrier ?? '') }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($courrier->expediteur || $courrier->externExpediteur)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Expéditeur
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            @if ($courrier->type_id == 3 || $courrier->type_id == 2)
                                                {{ $courrier->expediteur?->prenom }}
                                                {{ $courrier->expediteur?->nom }}
                                            @else
                                                {{ $courrier->externExpediteur?->nom }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($courrier->categorie)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Catégorie
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ Str::ucfirst($courrier->categorie->title) }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($courrier->type)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Type de document
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ Str::ucfirst($courrier->type->titre ?? '') }}
                                        </p>
                                    </div>
                                </div>


                            </div>
                        </div>
                    @endif

                    @if ($courrier->traitement)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Traitement à effectuer
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ Str::ucfirst($courrier->traitement->titre ?? '') }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($courrier->priorite)
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
                                            {{ Str::ucfirst($courrier->priorite->titre ?? '') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if ($courrier->statut_id === 3)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Statut
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <span class="badge bg-success">Validé</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($courrier->date_du_courrier)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Date du courrier
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $courrier->date_du_courrier->isoFormat('LL') }}
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endif

                    @if ($courrier->date_arrive)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Date de réception
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $courrier->date_arrive?->isoFormat('LL') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($courrier->date_fin)
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
                                            {{ $courrier->date_fin?->isoFormat('LL') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($courrier->service)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Service initiateur
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $courrier->service?->titre }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($courrier->objet)
                        <div class="col-12">
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <span style="font-size: 13px; color: var(--colorParagraph)">
                                            Objet
                                        </span>
                                    </div>
                                    <div class="col-lg-6">
                                        <p style="font-size: 13px; color: var(--colorTitre)" class="mb-0">
                                            {{ $courrier->objet }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($courrier->author)
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
                                            {{ Str::ucfirst($courrier->author->poste?->titre ?? '') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    @can('Suivi des courriers')
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHisto" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header align-items-center">
                <h5 class="offcanvas-title" id="offcanvasRightLabel">Historique des activités</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            <div class="offcanvas-body">
                <div class="block-activity">
                    @php
                        $historiques = collect();
                        if ($courrier->document) {
                            // $historiques = $historiques->merge($courrier->document->revisionHistory);
                            $historiques = $historiques->merge($courrier->document->history);
                        }
                        // $historiques = $historiques->merge($courrier->revisionHistory);
                        $historiques = $historiques->merge($courrier->history);
                        $historiques = $historiques->sortByDesc('created_at');
                        $historiquesGroup = $historiques->groupBy('user_id');
                        $revision = new \Venturecraft\Revisionable\Revision();
                    @endphp
                    @foreach ($historiquesGroup as $user_id => $historiques)
                        @php
                            $user = \App\Models\User::find($user_id);
                        @endphp
                        <div class="items-activity">

                            <div class="avatar-activ">
                                <img src="{{ imageOrDefault($user?->agent->image) }}" alt="">
                            </div>
                            <p class="agent">
                                <span>{{ $user?->agent->prenom . ' ' . $user?->agent->nom }}</span>
                                - {{ $user?->agent?->poste?->titre }}
                            </p>
                            @foreach ($historiques ?? [] as $history)
                                @if ($history instanceof $revision)
                                    @if ($history->key == 'created_at' && !$history->old_value)
                                        <div class="mt-2 block-dot-line">
                                            @if ($history->revisionable_type == 'App\Models\Courrier')
                                                <div class="dot-line">
                                                    <p>Création de ce courrier</p>
                                                    <div class="date">{{ $history->newValue() }}</div>
                                                </div>
                                            @elseif ($history->revisionable_type == 'App\Models\Document')
                                                <div class="dot-line">
                                                    <p>Numérisation des documents du courrier</p>
                                                    <div class="date">{{ $history->newValue() }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="mt-2 block-dot-line">
                                            @if ($history->revisionable_type == 'App\Models\Courrier')
                                                <div class="dot-line">
                                                    <p>
                                                        Modification sur {{ $history->fieldName() }} du courrier
                                                    </p>
                                                    <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            @elseif ($history->revisionable_type == 'App\Models\Document')
                                                <div class="dot-line">
                                                    <p>
                                                        Modification sur {{ $history->fieldName() }} du document de ce
                                                        courrier
                                                    </p>
                                                    <div class="date">{{ $history->created_at->format('d/m/Y H:i:s') }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <div class="mt-2 block-dot-line">
                                        <div class="block-dot-line-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                                viewBox="0 0 48 48">
                                                <circle cx="24" cy="24" r="21" fill="currentColor" />
                                                <path fill="#ffffff"
                                                    d="M34.6 14.6L21 28.2l-5.6-5.6l-2.8 2.8l8.4 8.4l16.4-16.4z" />
                                            </svg>
                                        </div>
                                        <div class="dot-line">
                                            <p> <span> {{ $history->description }}</span></p>
                                            <div class="date">
                                                {{ $history->created_at->format('d/m/Y H:i:s') }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endcan

    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComment" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header align-items-center">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Annotations</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="all-comments" style="overflow: hidden; height: auto!important;">
                <div class="block-scroll" id="tache-commentaires">
                    @php
                        $comments = $courrier->traitements;
                    @endphp
                    @forelse ($comments as $comment)
                        <div class="block-comment commentaires">
                            <div class="block-info-comment d-flex">
                                <div class="avatar-comment commentaires">
                                    <img src="{{ imageOrDefault($comment->agent->image) }}" alt="Photo profil">
                                </div>
                                <div class="name-comment commentaires">
                                    <h6 class="mb-0">
                                        {{ $comment->agent->prenom . ' ' . $comment->agent->nom }}
                                        <span> - {{ $comment->agent->direction->titre }}</span>
                                    </h6>
                                    <p>{{ $comment->created_at->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                            <div class="mt-2 comment commentaires">
                                {!! $comment->note !!}
                            </div>
                        </div>
                    @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div> --}}tools

    <div class="modal fade" id="modal-new-archive" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Archiver</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-4">
                        <form action="{{ route('regidoc.documents.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="from_archive" id="" value="true">
                            <input type="hidden" name="old_file" id="" value="{{ $courrier->file }}">
                            <div class="">
                                <div>
                                    <div class="my-3 col-lg-12">
                                        <input type="hidden" class="form-control" placeholder="Denomination"
                                            name="titre" value="{{ $courrier->title }}">
                                    </div>
                                </div>
                                <div>
                                    <div class="my-3 col-lg-12">
                                        <input type="hidden" class="form-control" placeholder="Réference"
                                            name="reference" value="{{ $courrier->reference }}">
                                    </div>
                                </div>
                                <div class="my-3 col-lg-12">
                                    <label for="">Classeur</label>
                                    <select name="classeur" id="" class="form-control" required>
                                        <option value="" selected>Sélectionnez</option>
                                        @foreach ($classeurs as $classeur)
                                            <option value="{{ $classeur->id }}">{{ $classeur->titre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <div class="my-3 col-lg-12">
                                        <label for="">Dossier</label>
                                        <select name="dossier_id" id="" class="form-control">
                                            <option value="" selected>Sélectionnez</option>
                                            @foreach ($dossiers as $dossier)
                                                <option value="{{ $dossier->id }}">{{ $dossier->titre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-end">
                                <button class="btn btn-add" type="submit" data-bs-dismiss="modal"
                                    aria-label="Close">Archiver</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-sm" id="modal-confidentiel" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-2">
                        <div class="col-12">
                            <div class="text-center">
                                <h6>
                                    Souhaitez-vous que ce courrier soit confidentiel ?
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 from-group row">
                        <div class="mb-3 col-lg-12">
                            <div class="d-flex justify-content-between gap-2">
                                <button class="btn btn-sm btn-light w-50" data-bs-dismiss="modal"
                                    aria-label="Close">Annuler</button>
                                <a href="{{ route('regidoc.courriers.confidentiel', $courrier) }}"
                                    class="mt-0 btn btn-add w-50">Valider</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-sm" id="modal-noconfidentiel" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row g-2">
                        <div class="col-12">
                            <div class="text-center">
                                <h6>
                                    Souhaitez-vous que ce courrier soit non confidentiel ?
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 from-group row">
                        <div class="mb-3 col-lg-12">
                            <div class="d-flex justify-content-between gap-2">
                                <button class="btn btn-sm btn-light w-50" data-bs-dismiss="modal"
                                    aria-label="Close">Annuler</button>
                                <a href="{{ route('regidoc.courriers.nonconfidentiel', $courrier) }}"
                                    class="mt-0 btn btn-add w-50">Valider</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('Valider un courrier')
        <div class="modal fade" id="modal-validation" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Valider</span>
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
                                    <p>Etes-vous sûr de vouloir valider ce courrier ?</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 from-group row">
                            <div class="mb-3 col-lg-12 text-end">
                                <button class="btn btn-sm btn-light" data-bs-dismiss="modal"
                                    aria-label="Close">Annuler</button>
                                <button class="mt-0 btn btn-add btn-valider">Valider</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('Rejeter un courrier')
        <div class="modal fade" id="modal-reject" tabindex="-1" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                            <span>Rejeter</span>
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
                        {{-- <form wire:submit.prevent="saveNote"> --}}
                        <div class="form-group row g-2">
                            <div class="col-lg-12">
                                <label for="">Direction en charge du suivi</label>
                                <select name="direction_id" id="" class="form-control" required>
                                    <option value="" selected disabled>Sélectionnez</option>
                                    @foreach ($directions as $direction)
                                        <option value="{{ $direction->id }}">{{ $direction->titre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="note">Note</label>
                                <textarea name="note" id="note" cols="30" rows="5" class="form-control"
                                    placeholder="Saisissez vos annotations ici" required></textarea>
                            </div>
                        </div>
                        <div class="mt-3 from-group row">
                            <div class="mb-3 col-lg-12 text-end">
                                <button type="reset" class="btn btn-cansel" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="mt-0 btn btn-add btn-rejeter">Enregistrer</button>
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('Partager un courrier')
        @livewire('taches.add-courrier-tache-modal', ['courrier' => $courrier])
    @endcan

    {{-- @can('Annoter un courrier') --}}
    @livewire('courrier.annotation-modal', ['courrier' => $courrier])

    @livewire('courrier.annotation-modal-add', ['courrier' => $courrier])


    {{-- @endcan --}}

    @can('Assigner une tâche')
        @if (!Auth::user()->agent->isDGA())
            @livewire('courrier.dga-modal', ['courrier' => $courrier])
        @endif
    @endcan

    <div class="modal fade" id="modal-delete-annotation" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center content-text">
                        <i data-feather="trash"></i>
                        <h5>Voulez-vous supprimer cette annotation ?</h5>
                        <p>Cette action est irréversible.</p>
                    </div>
                    <div class="mb-3 block-btn d-flex justify-content-center">
                        <button class="btn btn-cancel me-4" data-bs-dismiss="modal"
                            aria-label="Close">Annuler</button>
                        <button class="btn btn-delete" wire:click="deleteAnnotation">Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- @livewire('courrier.traitement-modal', ['courrier' => $courrier]) --}}
    <div class="modal fade" id="traitement-modal" aria-labelledby="exampleModalLabel" aria-modal="true"
        role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Precisez le type de traitement à effectuer sur le courrier </span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="traitement-form">
                        @csrf
                        <input type="hidden" name="courrier_id" id="courrier_id" value="{{ $courrier->id }}">
                        <div class="form-group row g-3">
                            <div class="col-12">
                                <label for="traitement_id">Traitement à effectuer</label>
                                <select class="form-select form-control select2" name="traitement_id"
                                    id="traitement_id" required>
                                    <option value=null disabled selected>Sélectionnez</option>
                                    @foreach ($traitements as $traitement)
                                        <option value="{{ $traitement->id }}" @selected($courrier->traitement && $courrier->traitement->id == $traitement->id)>
                                            {{ $traitement->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 priote_field">
                                <label for="priorite_id">Priorité</label>
                                <select class="form-select form-control select2" aria-label="Default select example"
                                    name="priorite_id" data-placeholder="Sélectionnez" required>
                                    <option value=null disabled selected>Sélectionnez</option>
                                    @foreach ($priorites as $priorite)
                                        <option value="{{ $priorite->id }}" @selected($courrier->priorite && $courrier->priorite->id == $priorite->id)>
                                            {{ $priorite->titre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if (!Auth::user()->agent->isSecretaire())
                                <div class="col-12 block_echeances">
                                    <div class="d-flex align-items-center">
                                        <label for="check-date" class="mb-0">Ajouter une échéance</label>
                                        <div class="form-check form-switch ms-2 mb-0">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="check-date" name="check-date">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 date-limite d-none">
                                    <label for="date-limite">Date d'échéance</label>
                                    <input type="date" class="form-control" id="date_limite" name="date_limite"
                                        min="{{ now()->format('d-m-Y') }}">
                                </div>

                                <div class="col-12">
                                    <label for="commentaire">Commentaires</label>
                                    <textarea name="commentaire" class="form-control" rows="3"></textarea>
                                </div>
                            @endif

                        </div>

                        <div class="col-12">
                            <div class="d-flex gap-2 mt-4">
                                <button type="reset" class="btn btn-cansel w-50"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-add mt-0 w-50" id="submit-traitement">Valider</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-a-asigner" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Traitements</span>
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
                        <div class="col-6">
                            <a href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'direction', 'courrier_id' => $courrier->id]) }}"
                                id="download"
                                class="btn btn-action-doc d-flex flex-column h-100 w-100 @if ($courrier->confidentiel) disabled @endif"
                                @if ($courrier->confidentiel) title="Coursier confidentiel" @endif>
                                <svg viewBox="0 0 24 24" width="512" height="512" class="mx-auto mb-2">
                                    <path
                                        d="M19,4h-1.1c-.46-2.28-2.48-4-4.9-4h-2c-2.41,0-4.43,1.72-4.9,4h-1.1C2.24,4,0,6.24,0,9v10c0,2.76,2.24,5,5,5h14c2.76,0,5-2.24,5-5V9c0-2.76-2.24-5-5-5ZM11,2h2c1.3,0,2.42,.84,2.83,2h-7.66c.41-1.16,1.52-2,2.83-2Zm11,17c0,1.65-1.35,3-3,3H5c-1.65,0-3-1.35-3-3V9c0-1.65,1.35-3,3-3h14c1.65,0,3,1.35,3,3v10Zm-4.85-7.1c.54,.54,.85,1.3,.85,2.1s-.31,1.55-.88,2.12l-2.39,2.56c-.2,.21-.46,.32-.73,.32-.24,0-.49-.09-.68-.27-.4-.38-.43-1.01-.05-1.41l2.16-2.32H7c-.55,0-1-.45-1-1s.45-1,1-1H15.43l-2.16-2.32c-.38-.4-.35-1.04,.05-1.41,.4-.38,1.04-.35,1.41,.05l2.41,2.59Z" />
                                </svg>
                                Assigner à une direction
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'agent', 'courrier_id' => $courrier->id]) }}"
                                id="download" class="btn btn-action-doc d-flex flex-column h-100 w-100">
                                <svg viewBox="0 0 24 24" width="512" height="512" class="mx-auto mb-2">
                                    <path
                                        d="M15,6c0-3.309-2.691-6-6-6S3,2.691,3,6s2.691,6,6,6,6-2.691,6-6Zm-6,4c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm-.008,4.938c.068,.548-.32,1.047-.869,1.116-3.491,.436-6.124,3.421-6.124,6.946,0,.552-.448,1-1,1s-1-.448-1-1c0-4.531,3.386-8.37,7.876-8.93,.542-.069,1.047,.32,1.116,.869Zm13.704,4.195l-.974-.562c.166-.497,.278-1.019,.278-1.572s-.111-1.075-.278-1.572l.974-.562c.478-.276,.642-.888,.366-1.366-.277-.479-.887-.644-1.366-.366l-.973,.562c-.705-.794-1.644-1.375-2.723-1.594v-1.101c0-.552-.448-1-1-1s-1,.448-1,1v1.101c-1.079,.22-2.018,.801-2.723,1.594l-.973-.562c-.48-.277-1.09-.113-1.366,.366-.276,.479-.112,1.09,.366,1.366l.974,.562c-.166,.497-.278,1.019-.278,1.572s.111,1.075,.278,1.572l-.974,.562c-.478,.276-.642,.888-.366,1.366,.186,.321,.521,.5,.867,.5,.169,0,.341-.043,.499-.134l.973-.562c.705,.794,1.644,1.375,2.723,1.594v1.101c0,.552,.448,1,1,1s1-.448,1-1v-1.101c1.079-.22,2.018-.801,2.723-1.594l.973,.562c.158,.091,.33,.134,.499,.134,.346,0,.682-.179,.867-.5,.276-.479,.112-1.09-.366-1.366Zm-5.696,.866c-1.654,0-3-1.346-3-3s1.346-3,3-3,3,1.346,3,3-1.346,3-3,3Z" />
                                </svg>
                                Assigner à un agent
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-a-traiter" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
                        <span>Traitements</span>
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
                            {{-- <a href="{{ route('regidoc.courriers.signer', $courrier) }}?is_paraphe=1"
                                class="flex-row gap-3 btn btn-action-doc d-flex justify-content-center align-items-center w-100"> --}}
                            <a href="{{ route('regidoc.documents.sign', ['doc_id' => $courrier->document?->id, 'is_original' => true, 'courrier_id' => $courrier->id]) }}"
                                class="flex-row gap-3 btn btn-action-doc d-flex justify-content-center align-items-center w-100">
                                <svg viewBox="0 0 24 24" width="512" height="512">
                                    <path
                                        d="M9,16h1.59c1.07,0,2.07-.42,2.83-1.17L23.12,5.12c.57-.57,.88-1.32,.88-2.12s-.31-1.55-.88-2.12c-1.17-1.17-3.07-1.17-4.24,0L9.17,10.59c-.76,.76-1.17,1.76-1.17,2.83v1.59c0,.55,.45,1,1,1ZM21.71,2.29c.19,.19,.29,.44,.29,.71s-.1,.52-.29,.71l-1.29,1.29-1.41-1.41,1.29-1.29c.39-.39,1.02-.39,1.41,0ZM10,13.41c0-.53,.21-1.04,.59-1.41l7-7,1.41,1.41-7,7c-.38,.38-.88,.59-1.41,.59h-.59v-.59Zm14,9.59c0,.55-.45,1-1,1-1.54,0-2.29-1.12-2.83-1.95-.5-.75-.75-1.05-1.17-1.05-.51,0-.9,.44-1.51,1.15-.7,.83-1.57,1.85-3.03,1.85s-2.32-1.03-3-1.87c-.58-.7-.96-1.13-1.46-1.13-.39,0-.63,.25-1.16,.91-.72,.88-1.71,2.09-3.84,2.09-2.76,0-5-2.24-5-5s2.24-5,5-5c.55,0,1,.45,1,1s-.45,1-1,1c-1.65,0-3,1.35-3,3s1.35,3,3,3c1.18,0,1.67-.6,2.29-1.36,.6-.73,1.34-1.64,2.71-1.64,1.47,0,2.32,1.03,3,1.87,.58,.7,.96,1.13,1.46,1.13s.9-.44,1.51-1.15c.7-.83,1.57-1.85,3.03-1.85s2.29,1.12,2.83,1.95c.5,.75,.75,1.05,1.17,1.05,.55,0,1,.45,1,1Z" />
                                </svg>
                                Signer
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'direction', 'courrier_id' => $courrier->id]) }}"
                                id="download"
                                class="btn btn-action-doc d-flex flex-column h-100 w-100 @if ($courrier->confidentiel) disabled @endif"
                                @if ($courrier->confidentiel) title="Coursier confidentiel" @endif>
                                <svg viewBox="0 0 24 24" width="512" height="512" class="mx-auto mb-2">
                                    <path
                                        d="M19,4h-1.1c-.46-2.28-2.48-4-4.9-4h-2c-2.41,0-4.43,1.72-4.9,4h-1.1C2.24,4,0,6.24,0,9v10c0,2.76,2.24,5,5,5h14c2.76,0,5-2.24,5-5V9c0-2.76-2.24-5-5-5ZM11,2h2c1.3,0,2.42,.84,2.83,2h-7.66c.41-1.16,1.52-2,2.83-2Zm11,17c0,1.65-1.35,3-3,3H5c-1.65,0-3-1.35-3-3V9c0-1.65,1.35-3,3-3h14c1.65,0,3,1.35,3,3v10Zm-4.85-7.1c.54,.54,.85,1.3,.85,2.1s-.31,1.55-.88,2.12l-2.39,2.56c-.2,.21-.46,.32-.73,.32-.24,0-.49-.09-.68-.27-.4-.38-.43-1.01-.05-1.41l2.16-2.32H7c-.55,0-1-.45-1-1s.45-1,1-1H15.43l-2.16-2.32c-.38-.4-.35-1.04,.05-1.41,.4-.38,1.04-.35,1.41,.05l2.41,2.59Z" />
                                </svg>
                                Assigner à une direction
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('regidoc.taches.create', ['doc' => $courrier->document->id, 'to' => 'agent', 'courrier_id' => $courrier->id]) }}"
                                id="download" class="btn btn-action-doc d-flex flex-column h-100 w-100">
                                <svg viewBox="0 0 24 24" width="512" height="512" class="mx-auto mb-2">
                                    <path
                                        d="M15,6c0-3.309-2.691-6-6-6S3,2.691,3,6s2.691,6,6,6,6-2.691,6-6Zm-6,4c-2.206,0-4-1.794-4-4s1.794-4,4-4,4,1.794,4,4-1.794,4-4,4Zm-.008,4.938c.068,.548-.32,1.047-.869,1.116-3.491,.436-6.124,3.421-6.124,6.946,0,.552-.448,1-1,1s-1-.448-1-1c0-4.531,3.386-8.37,7.876-8.93,.542-.069,1.047,.32,1.116,.869Zm13.704,4.195l-.974-.562c.166-.497,.278-1.019,.278-1.572s-.111-1.075-.278-1.572l.974-.562c.478-.276,.642-.888,.366-1.366-.277-.479-.887-.644-1.366-.366l-.973,.562c-.705-.794-1.644-1.375-2.723-1.594v-1.101c0-.552-.448-1-1-1s-1,.448-1,1v1.101c-1.079,.22-2.018,.801-2.723,1.594l-.973-.562c-.48-.277-1.09-.113-1.366,.366-.276,.479-.112,1.09,.366,1.366l.974,.562c-.166,.497-.278,1.019-.278,1.572s.111,1.075,.278,1.572l-.974,.562c-.478,.276-.642,.888-.366,1.366,.186,.321,.521,.5,.867,.5,.169,0,.341-.043,.499-.134l.973-.562c.705,.794,1.644,1.375,2.723,1.594v1.101c0,.552,.448,1,1,1s1-.448,1-1v-1.101c1.079-.22,2.018-.801,2.723-1.594l.973,.562c.158,.091,.33,.134,.499,.134,.346,0,.682-.179,.867-.5,.276-.479,.112-1.09-.366-1.366Zm-5.696,.866c-1.654,0-3-1.346-3-3s1.346-3,3-3,3,1.346,3,3-1.346,3-3,3Z" />
                                </svg>
                                Assigner à un agent
                            </a>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-action-doc d-flex flex-column h-100 w-100"
                                data-bs-target="#modal-validation" data-bs-toggle="modal">
                                <i class="fi fi-rr-check"></i>
                                Valider le document
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-action-doc d-flex flex-column h-100 w-100"
                                data-bs-target="#modal-reject" data-bs-toggle="modal">
                                <svg viewBox="0 0 24 24" width="512" height="512" class="mx-auto mb-2">
                                    <path
                                        d="M16,8a1,1,0,0,0-1.414,0L12,10.586,9.414,8A1,1,0,0,0,8,9.414L10.586,12,8,14.586A1,1,0,0,0,9.414,16L12,13.414,14.586,16A1,1,0,0,0,16,14.586L13.414,12,16,9.414A1,1,0,0,0,16,8Z" />
                                    <path
                                        d="M12,0A12,12,0,1,0,24,12,12.013,12.013,0,0,0,12,0Zm0,22A10,10,0,1,1,22,12,10.011,10.011,0,0,1,12,22Z" />
                                </svg>
                                Rejeter
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('regidoc.layouts.partials.head.scripts')
    @yield('scripts')
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
    <script>
        $(document).ready(function() {
            // Gestion du clic sur le bouton de validation
            $(document).on('click', '.btn-valider-courrier', function(e) {
                e.preventDefault();
                
                const courrierId = $(this).data('id');
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                
                // Demander confirmation
                if (!confirm('Êtes-vous sûr de vouloir valider ce courrier ?')) {
                    return;
                }
                
                // Afficher un message de chargement
                alert('Traitement en cours...');
                
                // Envoyer la requête AJAX
                $.ajax({
                    url: '/courriers/' + courrierId + '/valider',
                    type: 'POST',
                    data: {
                        _token: csrfToken
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            // Recharger la page pour afficher les mises à jour
                            location.reload();
                        } else {
                            alert('Erreur: ' + (response.message || 'Une erreur inconnue est survenue'));
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Une erreur est survenue lors de la validation du courrier';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += ': ' + xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            });
            
            // Gestion du clic sur le bouton de rejet
            $(document).on('click', '.btn-rejeter-courrier', function(e) {
                e.preventDefault();
                
                const courrierId = $(this).data('id');
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                
                // Demander la raison du rejet
                const raison = prompt('Veuillez indiquer la raison du rejet :');
                if (raison === null || raison.trim() === '') {
                    alert('La raison du rejet est obligatoire.');
                    return;
                }
                
                // Demander confirmation
                if (!confirm('Êtes-vous sûr de vouloir rejeter ce courrier ?')) {
                    return;
                }
                
                // Afficher un message de chargement
                alert('Traitement en cours...');
                
                // Envoyer la requête AJAX
                $.ajax({
                    url: '/courriers/' + courrierId + '/rejeter',
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        raison: raison
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            // Recharger la page pour afficher les mises à jour
                            location.reload();
                        } else {
                            alert('Erreur: ' + (response.message || 'Une erreur inconnue est survenue'));
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Une erreur est survenue lors du rejet du courrier';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage += ': ' + xhr.responseJSON.message;
                        }
                        alert(errorMessage);
                    }
                });
            });

            // Enforce focus within the modal
            $('#traitement-modal').on('shown.bs.modal', function() {
                $(this).find('.form-control:first').focus();
                // Réactiver le bouton de soumission lorsque la modale est rouverte
                $('#submit-traitement').prop('disabled', false).text('Valider');
            });
            
            // Désactiver le bouton de soumission pendant la requête AJAX
            $(document).on('submit', '#traitement-form', function() {
                $('#submit-traitement').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Traitement...');
            });
            $('#traitement-form').submit(function(e) {
                e.preventDefault();
                $('page-load').removeClass('d-none');
                
                // Afficher les données du formulaire dans la console
                const formData = $(this).serializeArray();
                console.log('Données du formulaire:', formData);
                
                $.ajax({
                    url: "{{ route('regidoc.courriers.saveTraitement', $courrier) }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Réponse du serveur:', response);
                        if (response.success) {
                            Livewire.emit('alert', 'success', 'Traitement effectué avec succès');
                            $('page-load').addClass('d-none');
                            $('#traitement-modal').modal('hide');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            console.error('Erreur dans la réponse:', response);
                            Livewire.emit('alert', 'error', response.message || 'Une erreur est survenue');
                            $('page-load').addClass('d-none');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erreur lors de la soumission du formulaire:', xhr.responseText);
                        let errorMessage = 'Une erreur est survenue lors du traitement';
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            } else if (xhr.status === 422 && response.errors) {
                                // Gestion des erreurs de validation
                                errorMessage = Object.values(response.errors).flat().join('\n');
                            }
                        } catch (e) {
                            console.error('Erreur lors de l\'analyse de la réponse:', e);
                        }
                        
                        Livewire.emit('alert', 'error', errorMessage);
                        $('page-load').addClass('d-none');
                        // Ne pas recharger la page en cas d'erreur
                    }
                });
            });

            // Event handlers for select elements
            $('select[name=priorite]').on('change', function(e) {
                var priorite = e.target.value;
                // Process priorite change here (e.g., send AJAX request)
            });

            $('select[name=traitement_id]').on('change', function(e) {
                var traitementId = e.target.value;
                // Process traitementId change here (e.g., update other fields)
            });

            $('.selectCopie').on('change', function(e) {
                var copie = $(this).val();
                // Process copie change here (e.g., create copies)
            });

            // Checkbox for date limite
            $('#check-date').on('change', function() {
                $('.date-limite').toggleClass('d-none', !this.checked);
                // Process date limite change here
            });

            // Initialize Select2 elements
            $('.select2').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
                width: '100%',
                dropdownParent: $('#traitement-modal')
            });

            $('.selectCopie').select2({
                tags: $(this).data('tags') ? $(this).data('tags') : false,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                maximumSelectionLength: $(this).data('max-selection') ? $(this).data('max-selection') :
                    null,
                width: '100%',
                dropdownParent: $('#traitement-modal')
            });


        });
    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js?v=1"></script>
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

        Livewire.on('documentChanged', function(evt) {
            url = evt.doc;
            docId = evt.doc_id;
            is_original = evt.is_original;
            courrier_id = evt.courrier_id;
            // showPDF(url);
            changDoc(url, null, docId, null, is_original, courrier_id)
        });


        $('.show-vignette').on('click', function() {
            if ($('.vignette-column').width() == 0) {

                // $('.vignette-column').parent().removeClass('justify-content-center');
                // $('.vignette-column').parent().addClass('justify-content-end');

                $('.vignette-column').css({
                    width: '25%',
                    opacity: '1'
                })

                $('.vignette-column').addClass('border-start');
            } else {

                $('.vignette-column').css({
                    width: '0px',
                    opacity: '0'
                })
                $('.vignette-column').removeClass('border-start');
            }
        });

        Livewire.on('assistantSeen', function(evt) {
            $('.assistant-trait').removeClass('d-none');
        });
    </script>


</body>

</html>

{{-- <style>
  
</style> --}}
