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
                    <h6 style="font-size: 16px; text-align: end; font-weight: 500!important">
                        <span class="text-decoration-underline">MESSAGE-EMAIL</span>
                    </h6>
                </div>
                <div class="block-desti" style="margin-top: 80px">
                    <p class="mb-0" style="text-transform: uppercase; text-align: end">
                        Siège de {{ $direction ?? 'lubumbashi' }}
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="code-letter" style="margin-top: 15px">
                    {{ $reference ?? 'REF/001/2023' }}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="date-letter text-end me-" style="margin-top: 15px">
                    <span class="loc-pic">{{ $lieu_date ?? 'Kinshasa, 11/06/2023' }}</span>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="block-concerne d-flex mt-4 align-items-baseline">
                    <span class="text-decoration-underline"
                        style="flex: 0 0 auto; font-size: 16px;font-family: 'Roboto-bold', sans-serif;">CONCERNE
                        :</span>
                    <h6 class="mb-0 ms-1 fw-bold text-decoration-underline"
                        style="font-size: 16px;font-weight:500!important">

                        {{ $concerne ?? "Paiement décompte final et frais de retour de voyage de l'agent NGANDU MANGALA" }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <div class="block-body mt-4" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
        <div class="content-text-letter">
            {!! $body ??
                '<p style="text-indent: 88px;">
                                                                                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                            Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                                                                                                                            fugiat,
                                                                                                                            earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                        </p>
                                                                                                                        <p style="text-indent: 88px;">
                                                                                                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                            Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                                                                                                                            fugiat,
                                                                                                                            earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                        </p>' !!}
        </div>
        <div class="block-signateurs" style="padding-bottom: 50px;">
            <div class="row g-3 g-lg-4 my-5 justify-content-center">
                <div class="col-6">
                    <div class="text-center mb-5">
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
