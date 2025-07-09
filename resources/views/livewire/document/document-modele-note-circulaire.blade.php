<div class="inner-letter admin" id="doc_save" wire:poll.keep-alive style="padding-top: 60px; overflow:hidden">

    <div class="bande"
        style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1;
            margin-bottom: 50px;"
        data-html2canvas-ignore="true">
        <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso"
            style="
        width: 100%;user-select: none; pointer-events: none;">
    </div>
    <div class="logo-card"
        style="position: absolute; width: 100%; height: 100%; left: 0px; top: 0px;right:0px;0px
            z-index: -1; display: flex; justify-content: end;"
        wire:ignore>
        <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso"
            style="position: absolute;
        width: 45%;
        top: 390px;pointer-events: none;user-select: none">
    </div>
    <div class="block-header">
        <div class="row g-lg-4 g-3 mt-1">
            <div class="col-6">
                <div class="logo">
                    <img src="{{ asset('assets/images/logoLetter.png') }}" alt="logo regideso" style="width: 170px;">
                </div>
            </div>
            <div class="col-6">
                <div class="copy-block">
                    <h6 style="font-size: 16px;font-weight: 500!important">
                        <span class="text-decoration-underline" style="text-transform: uppercase">Note circulaire N°
                            {{ $reference ?? 'DG/019/2023' }}</span>
                    </h6>
                    <h6 style="font-size: 16px;margin-top: 50px;font-weight: 500!important">
                        <span class="text-decoration-underline">Destinataires:</span>
                    </h6>
                    <ul class="copy-list">
                        @forelse ($copies ?? [] as $copie)
                            <li>
                                {{ $copie }}
                            </li>
                        @empty
                            <li>
                                Ensemble du Personnel
                            </li>
                            <li>
                                Ensemble du Personnel
                            </li>
                            <li>
                                Ensemble du Personnel
                            </li>
                        @endforelse
                        <br>
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="block-concerne d-flex mt-4 align-items-baseline">
                    <span class="text-decoration-underline"
                        style="flex: 0 0 auto; font-size: 16px;font-family: 'Roboto-bold', sans-serif;">CONCERNE
                        :</span>
                    <h6 class="mb-0 ms-1 text-decoration-underline" style="font-size: 16px;font-weight: 500!important">
                        {{ $concerne ?? 'CREATION DES EMPLOIS A LA DIRECTION GENERALE DE lA REGIDESO SA' }}
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
            <div class="date" style="margin-top: 50px;text-align: end; margin-right: 100px;">
                Fait à {{ $lieu_date ?? 'Kinshasa, le 12 JUIL 2023' }}
            </div>
        </div>
        <div class="block-signateurs" style="padding-bottom: 50px;">
            <div class="row g-3 g-lg-4 my-5 justify-content-center">
                <div class="col-6">
                    <div class="text-center mb-5">
                        <span>
                            {{ $dest_fonction ?? 'Le Directeur Général Adjoint' }}
                        </span>
                        <h6>
                            {{ $dest_name ?? 'Jean-Bosco MWAKA' }}
                        </h6>
                    </div>
                </div>
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
            style="width: 80%;margin-bottom:30px;pointer-events: none; user-select: none"
            data-html2canvas-ignore="true">
        <img src="{{ asset('assets/images/footer3.png') }}" alt=""
            style="width: 100%;pointer-events: none; user-select: none" id="bound" data-html2canvas-ignore="true">
    </div>

</div>
