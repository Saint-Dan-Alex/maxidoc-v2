<div class="inner-letter admin" id="doc_save" wire:poll.keep-alive style="padding-top: 60px; overflow:hidden">
    <div class="bande"
        style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1;
            margin-bottom: 50px;"
        data-html2canvas-ignore="true">
        <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso" style="
        width: 100%;user-select: none; pointer-events: none;">
    </div>
    <div class="logo-card" style="position: absolute; width: 100%; height: 100%; left: 0px; top: 0px;right:0px;0px
            z-index: -1; display: flex; justify-content: end;" wire:ignore>
        <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso"
            style="position: absolute;
        width: 45%;
        top: 390px;pointer-events: none;user-select: none">
    </div>
    <div class="block-header">
        <div class="row g-lg-4 mt-1 g-3">
            <div class="col-6">
                <div class="logo">
                    <img src="{{ asset('assets/images/logoLetter.png') }}" alt="logo regideso" style="width: 170px;">
                </div>
            </div>
            <div class="col-6">
                <div class="copy-block">
                    <h6 style="font-size: 16px;font-weight:500!important">
                        <span class="text-decoration-underline" style="text-transform: uppercase">Ordre de mission N°
                            {{ $reference ?? 'DG/019/2023' }}</span>
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <div id="block-body" class="block-body mt-5" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
        <div class="content-text-letter">
            <div class="row g-3">
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                    <span class="text-decoration-underline" style="text-transform: uppercase">NOM ET
                                        POSTNOM</span>

                                </h6>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                {!! $dest ?? '<span>FRANCIS ISASI</span>, Matricule : 43822' !!}
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                    <span class="text-decoration-underline" style="text-transform: uppercase">COTE
                                        D'EMPLOI</span>

                                </h6>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                <span>{{ $dest_mat ?? 'C17' }}</span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                    <span class="text-decoration-underline"
                                        style="text-transform: uppercase">FONCTION</span>

                                </h6>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                <span>{{ $deste_poste ?? 'SECRETAIRE GENERAL' }}</span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p style="font-size: 16px">
                        {{ $concerne ?? "Est chargé d'une mission de service à GOMA (DR/Nord-Kivu)" }}</p>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                    <span class="text-decoration-underline" style="text-transform: uppercase">DUREE DE
                                        LA MISSION</span>

                                </h6>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                <span>{{ $direction ?? 'Six (06) Jours' }}</span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                    <span style="text-transform: uppercase">DATE DE PART</span>

                                </h6>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                <span>{{ $date ?? 'OPEN' }}</span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                    <span style="text-transform: uppercase">FINANCEMENT</span>

                                </h6>
                                <span>:</span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                <span>{{ $location ?? "Budget d'exploitation REGIDESO S.A" }}</span>
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    {!! $body ??
                        '<p style="font-size: 16px">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt
                                                                                                        expedita officia ex voluptatibus voluptate? Enim perspiciatis est labore nemo explicabo aliquam,
                                                                                                        eos harum cupiditate fugit ipsa suscipit, dicta cumque illo?</p>' !!}
                </div>
                <div class="col-12">
                    <div class="date" style="margin-top: 50px;text-align: end; margin-right: 100px;">
                        Fait à {{ $lieu_date ?? ' Kinshasa, le 12 JUIL 2023' }}
                    </div>
                </div>
            </div>
        </div>
        <div class="block-signateurs">
            <div class="row g-3 g-lg-4 my-5 justify-content-center">
                <div class="col-6">
                    <div class="text-center mb-">
                        <span>
                            {{ $exp_fonction ?? 'Le Directeur Général' }}
                        </span>
                        <h6>
                            {{ $exp_name ?? 'David TSHILUMBA' }}
                        </h6>
                    </div>
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
        padding-top:30px;
        ">
        <img src="{{ asset('assets/images/footer1.png') }}" alt="" class="img-footer"
            style="width: 80%;margin-bottom:30px;pointer-events: none; user-select: none" data-html2canvas-ignore="true">
        <img src="{{ asset('assets/images/footer3.png') }}" alt="" style="width: 100%;pointer-events: none; user-select: none" id="bound"
            data-html2canvas-ignore="true">
    </div>

</div>
