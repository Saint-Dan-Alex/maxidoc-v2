<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création du document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body> 
    <div class="content-scanner">
        <div class="pt-5 pb-3 container-fluid ps-2" id="pdf-main-container">
            <div class="mb-4"></div>
            <div class="nav-tools-page" id="pdf-meta"
                style="position: fixed;top: 0;left: 470px;right: 0;width: calc(100vw - 470px);z-index: 3;">
                <div class="row align-items-center ms-0 w-100">
                    <div class="col-lg-4 ps-0">
                    </div>

                    <div class="col-lg-4">
                    </div>

                    <div class="col-lg-4">
                    </div>
                </div> 
            </div> 
            <div class="block-letter"
                 style="width: 100%;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        gap: 20px;">
                <div>
                    <div class="admin mt-1 d-none" id="page-template"
                         style="width: 793px; max-width: 100%; height: 1030px;
                                background-color: var(--whiteColor);
                                background-image: url({{ asset('assets/images/cadre2.png')}});
                                background-size: 353px 671px;
                                background-repeat: no-repeat;
                                background-position: right top;
                                background-position-x: 100%;
                                background-position-y: 85%;
                                box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);
                                display: flex;
                                flex-direction: column;
                                font-size: 12px;
                                position: relative;
                                z-index: 1;
                                overflow: hidden;
                                padding-top: 60px;">

                        <div class="bande"
                            style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1; margin-bottom: 50px;"
                            data-html2canvas-ignore="true">
                            <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso"
                                style="width: 100%;user-select: none; pointer-events: none;">
                        </div> 
                        <div class="mt-4 block-body" contenteditable="true" data-maxheight="947"
                            data-signatureheight="800">

                        </div> 
                        <div class="block-footer" id="footer"
                            style="position: absolute;
                                    display: flex;
                                    flex-direction: column;
                                    width: 100%;
                                    left: 0;
                                    bottom: 0;
                                    z-index: -1;
                                    padding-top:30px;
                                    ">
                            {{-- <img src="{{ asset('assets/images/footer1.png') }}" alt=""
                                class="img-footer"
                                style="width: 80%;margin-bottom:30px;pointer-events: none; user-select: none"
                                data-html2canvas-ignore="true">
                            <img src="{{ asset('assets/images/footer3.png') }}" alt=""
                                style="width: 100%;pointer-events: none; user-select: none" id="bound"
                                data-html2canvas-ignore="true"> --}}
                        </div>

                    </div>

                    <div class="inner-letter admin" id="page1"
                        style="width: 793px; max-width: 100%; height: 1030px;
                                background-color: var(--whiteColor);
                                background-image: url({{ asset('assets/images/cadre2.png')}};
                                background-size: 353px 671px;
                                background-repeat: no-repeat;
                                background-position: right top; /
                                background-position-x: 100%;
                                background-position-y: 85%;
                                box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);
                                display: flex;
                                flex-direction: column;
                                font-size: 12px;
                                position: relative;
                                z-index: 1;
                                overflow: hidden;
                                padding-top: 60px;">

                        <div class="bande"
                            style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1; margin-bottom: 50px;"
                            data-html2canvas-ignore="true">
                            <img src="{{ asset('assets/images/band.png')}}" alt="bande regideso"
                                style="width: 100%;user-select: none; pointer-events: none;">
                        </div> 
                        <div class="block-header">
                            <div class="mt-1 row g-lg-4 g-3">
                                <div class="col-6">
                                    <div class="logo">
                                        <img src="{{ asset('assets/images/logoLetter.png')}}"
                                            alt="logo regideso"
                                            style="width: 170px; pointer-events: none; user-select: none">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="copy-block">
                                        <h6>
                                            <span class="text-decoration-underline">Copie pour
                                                Information</span> :
                                        </h6>
                                        <ul class="copy-list">
                                            {{-- @forelse ($copies as $copie)
                                                <li>
                                                    {{ $copie }}
                                                </li> 
                                            @endforelse
                                            <br> --}}
                                        </ul>
                                        <h6 class="location">
                                            ({{ $lieu_copie }})
                                        </h6>
                                    </div>
                                    <hr width="70%" style="margin-top: 2px; margin-bottom: 2px;">
                                    <div class="block-desti">
                                        <p class="mb-0 me-2">
                                            {{ $dest}} à <span
                                                class="f fw-bold">{{ $ville }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="code-letter">
                                        {{ $reference }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="date-letter text-end me-5 pe-2">
                                        <span class="loc-pic">{{ $lieu_date}}</span>

                                    </div>
                                </div>
                                <div class="col-lg-8 ">
                                    <div class="mt-4 block-concerne d-flex align-items-baseline">
                                        <span class="text-decoration-underline fw-bold"
                                            style="flex: 0 0 auto;">CONCERNE
                                        </span>
                                        <span style="margin-right:5px;margin-left:5px; ">:</span>
                                        <h6 class="mb-0 ms-1 fw-bold text-decoration-underline">
                                            {{ $objet}}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 block-body" data-maxheight="621"
                            data-signatureheight="463"> 
                            {!! nl2br($content)!!}
                        </div>
                        <div class="my-4 row justify-content-end block-signature">
                            <div class="col-6">
                                {{-- @forelse ($cosignataires as $index => $cosignataire)
                                    <div class="mb-5 text-center">
                                        <span>
                                            {{ $cosignataire['dest_fonction'] ?? "Le chef de Services D'Importation" }}
                                        </span>
                                        <h6>
                                            {{ $cosignataire['dest_name'] ?? 'Francis ISASI' }}
                                        </h6>
                                        <div class="mx-auto signatureContainer w-75 ui-droppable ui-state-highlight"
                                            style="height: 70px" >
                                        </div>
                                    </div>
                                @empty

                                @endforelse --}}
                            </div>
                            <div class="col-6">
                                <div class="text-center mb-">
                                    <span>
                                        {{ $exp_fonction}}
                                    </span>
                                    <h6>
                                        {{ $exp_name }}
                                    </h6>
                                    <div class="mx-auto signatureContainer w-75" style="height: 70px">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="block-footer" id="footer"
                            style="position: absolute;
                                    display: flex;
                                    flex-direction: column;
                                    width: 100%;
                                    left: 0;
                                    bottom: 0;
                                    z-index: -1;
                                    padding-top:30px;">
                            {{-- <img src="{{ asset('assets/images/footer1.png')}}" alt=""
                                class="img-footer"
                                style="width: 80%;margin-bottom:30px;pointer-events: none; user-select: none"
                                data-html2canvas-ignore="true">
                            <img src="{{ asset('assets/images/footer3.png')}}" alt=""
                                style="width: 100%;pointer-events: none; user-select: none" id="bound"
                                data-html2canvas-ignore="true"> --}}
                        </div> 
                    </div>
                </div> 
            </div>
        </div>
    </div>
</body>
</html>