<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Creator</title>
    <link href="{{asset("assets/css/bootstrap.min.css")}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{asset("assets/css/uicons-regular-rounded.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/uicons-solid-rounded.css")}}">
    <link rel="stylesheet" href="{{asset("vendor/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/main.css")}}">
    <link rel="stylesheet" href="{{asset("assets/css/theme.css")}}">
</head>

<body>
    <div class="block-scanner">
        <form action="{{ route('generate.pdf') }}" method="POST">
            @csrf
            <div class="sidebar-doc">
                <div class="header-sidebar d-flex">
                    <a href="{{ url()->previous() }}" style="font-size: 14px; color: var(--colorTitle)" class="btn-back">
                        <i class="fi fi-rr-angle-left"></i>
                        <div class="tooltip-indicator">
                            Retour
                        </div>
                    </a>
                    <h4 class="ms-2">Créer un document </h4>
                </div>
                <div class="body-siderbar">
                    <div class="form-group row g-2" id="form-input">
                        <div class="col-12">
                            <h4 style="color: var(--colorTitre); font-size: 22px;"> Lettre officielle </h4>
                            <hr>
                            <h5 class="mb-0 title-info">Détails du Document</h5>
                        </div> 
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Référence</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="ref" 
                                        required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            {{-- <div class="row">
                                <label class="col-5 col-form-label">Copie</label>
                                <div class="col-7" >
                                    <select class="form-select form-control selectCopie select2-hidden-accessible"
                                        aria-label="Default select example" name="copie[]" id="2"
                                        data-placeholder="Selectionner" multiple 
                                        wire:change="changeCopie" data-select2-id="2" tabindex="-1" aria-hidden="true">
                                    </select>
                                </div>
                            </div> --}}
                        </div> 
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Lieu des personnes en copie</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="lieu_copie" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Destinataire</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="dest"  required>
                                </div>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Ville</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="ville" required
                                         placeholder="Ville">
                                </div>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Lieu et date</label>
                                <div class="col-7">
                                    <input type="text" class="form-control" name="lieu_date" required
                                         placeholder="ex : Kinshasa, 30/06/1960">
                                </div>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Objet</label>
                                <div class="col-7">
                                    <textarea name="objet" id="objet" cols="30" rows="3" class="form-control" style="resize: none"
                                        placeholder="Objet du document"></textarea>
                                </div>
                            </div>
                        </div> 
                        <div class="col-12" wire:ignore>
                            <label class="form-label">Contenu</label>
                            <textarea name="content" class="form-control body" id="editor" cols="30" rows="5" wire:ignore.self>
                                
                            </textarea>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <label class="col-5 col-form-label">Signataire</label>
                                <div class="col-7">
                                    <input type="text" class="mb-2 form-control" name="exp_fonction"
                                        required 
                                        placeholder="Fonction du Signataire">
                                    <input type="text" class="form-control" name="exp_name" required
                                         placeholder="Nom du Signataire">
                                </div>
                            </div> 
                        </div>
                        <div class="col-12">
                        </div>
                        {{-- <div class="col-12">
                            <a href="javascript:void(0)" wire:click="addCosignataire" class="btn-plus-rounded"><i
                                    class="fi fi-rr-plus me-1" style="font-size: 12px"></i> Ajouter un signataire
                            </a>
                        </div> --}}
                        <div> 
                                {{-- <div class="row">
                                    <div class="col-7"> 
                                        <input type="text" class="mb-2 form-control" name="cosignataires[0][dest_fonction]"  
                                          placeholder="Fonction du CoSignataire"> 
                                      <input type="text" class="form-control" name="cosignataires[0][dest_name]"  
                                            placeholder="Nom du CoSignataire"> 
                                    </div>
                                </div> --}}
                        </div> 
                    </div>
                </div>
                <div class="footer-sidebar">
                    <button type='submit' class="btn btn-valid">
                        <span>Prévisualiser le PDF</span> 
                    </button>
                </div>
            </div>
        </form>
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
                                {{-- body --}}
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
                                <img src="{{ asset('assets/images/footer1.png') }}" alt=""
                                    class="img-footer"
                                    style="width: 80%;margin-bottom:30px;pointer-events: none; user-select: none"
                                    data-html2canvas-ignore="true">
                                <img src="{{ asset('assets/images/footer3.png') }}" alt=""
                                    style="width: 100%;pointer-events: none; user-select: none" id="bound"
                                    data-html2canvas-ignore="true">
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
                                                <li>
                                                    Lorem ipsum dolor sit, amet consectetur.
                                                </li>
                                                <li>
                                                    Lorem ipsum dolor sit, amet consectetur.
                                                </li>
                                                <li>
                                                    Lorem ipsum dolor sit, amet consectetur.
                                                </li>
                                                <br>
                                            </ul>
                                            <h6 class="location">
                                                (Tous à Kinshasa)
                                            </h6>
                                        </div>
                                        <hr width="70%" style="margin-top: 2px; margin-bottom: 2px;">
                                        <div class="block-desti">
                                            <p class="mb-0 me-2">
                                                à <span class="f fw-bold"></span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="code-letter">

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="date-letter text-end me-5 pe-2">
                                            <span class="loc-pic">Kinshasa, 11/06/2023</span>

                                        </div>
                                    </div>
                                    <div class="col-lg-8 ">
                                        <div class="mt-4 block-concerne d-flex align-items-baseline">
                                            <span class="text-decoration-underline fw-bold"
                                                style="flex: 0 0 auto;">CONCERNE
                                            </span>
                                            <span style="margin-right:5px;margin-left:5px; ">:</span>
                                            <h6 class="mb-0 ms-1 fw-bold text-decoration-underline"></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 block-body" contenteditable="true" data-maxheight="621"
                                data-signatureheight="463"> 
                            </div>
                            <div class="my-4 row justify-content-end block-signature">
                                <div class="col-6">
                                </div>
                                <div class="col-6" >
                                    <div class="text-center mb-">
                                        <span>

                                        </span>
                                        <h6>

                                        </h6>
                                        <div class="mx-auto signatureContainer w-75 ui-droppable ui-state-highlight"
                                            style="height: 70px" >
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
                                <img src="{{ asset('assets/images/footer1.png')}}" alt=""
                                    class="img-footer"
                                    style="width: 80%;margin-bottom:30px;pointer-events: none; user-select: none"
                                    data-html2canvas-ignore="true">
                                <img src="{{ asset('assets/images/footer3.png')}}" alt=""
                                    style="width: 100%;pointer-events: none; user-select: none" id="bound"
                                    data-html2canvas-ignore="true">
                            </div> 
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        
    </div>
    <script src="{{ asset("assets/js/jquery-3.6.0.min.js")}}"></script>
    <script src="{{ asset("assets/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{ asset("vendor/select2/js/select2.min.js")}}"></script>
    <script>
        $('.selectCopie').select2({
                tags: true,
                placeholder: $(this).data('placeholder'),
                language: "fr",
                width: '100%',
            });
    </script>
</body> 
</html>
