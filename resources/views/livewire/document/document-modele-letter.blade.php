<div>
    <div class="admin mt-1 d-none" id="page-template"
        style="width: 793px; max-width: 100%; height: 1030px;
        background-color: var(--whiteColor);
        background-image: url({{ asset('assets/images/cadre2.png') }});
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
        padding-top: 60px;"
        wire:ignore.self>

        <div class="bande" style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1; margin-bottom: 50px;"
            data-html2canvas-ignore="true">
            <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso"
                style="width: 100%;user-select: none; pointer-events: none;">
        </div>
        {{-- <div wire:ignore class="position-relative" style="left:0px;right: 0px; top:0; z-index: -1"
            data-html2canvas-ignore="true"> --}}
        {{-- <div class="logo-card"
                style="position: absolute; width:100%; height: 970px; left: 0px; top: 0px; right:0px; z-index: -1; display: flex; justify-content: end;"
                wire:ignor>
                <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso"
                    style="position: absolute;
                width: 45%; right:0px;
                top: 310px; pointer-events: none;user-select: none;z-index: -1">
            </div> --}}
        {{-- </div> --}}

        <div class="mt-4 block-body" contenteditable="true"
            data-maxheight="947" data-signatureheight="800">
            {!! $body ??
                '
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!</p>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!</p>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!</p>
                        ' !!}
        </div>
        {{-- <div class="my-4 row justify-content-end block-signature">
            <div class="col-6">
                @foreach ($cosignataires as $index => $cosignataire)
                    <div class="mb-5 text-center">
                        <span>
                            {{ $cosignataire['dest_fonction'] ?? "Le chef de Services D'Importation" }}
                        </span>
                        <h6>
                            {{ $cosignataire['dest_name'] ?? 'Francis ISASI' }}
                        </h6>
                        <div class="mx-auto cosignature signatureContainer w-75" style="height: 70px" wire:ignore>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-6" wire:ignore.self>
                <div class="text-center mb-">
                    <span>
                        {{ $exp_fonction ?? "Le chef de Services D'Exploitation" }}
                    </span>
                    <h6>
                        {{ $exp_name ?? 'Jean-Louis Dikasa' }}
                    </h6>
                    <div class="mx-auto signatureContainer w-75" style="height: 70px" wire:ignore>
                    </div>
                </div>
            </div>
        </div> --}}

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
                style="width: 100%;pointer-events: none; user-select: none" id="bound"
                data-html2canvas-ignore="true">
        </div>

    </div>

    <div class="inner-letter admin" id="page1"
        style="width: 793px; max-width: 100%; height: 1030px;
            background-color: var(--whiteColor);
            background-image: url({{ asset('assets/images/cadre2.png') }});
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
            padding-top: 60px;"
        wire:ignore.self>

        <div class="bande" style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1; margin-bottom: 50px;"
            data-html2canvas-ignore="true">
            <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso"
                style="width: 100%;user-select: none; pointer-events: none;">
        </div>
        {{-- <div wire:ignore class="position-relative" style="left:0px;right: 0px; top:0; z-index: -1"
            data-html2canvas-ignore="true"> --}}
        {{-- <div class="logo-card"
                style="position: absolute; width:100%; height: 970px; left: 0px; top: 0px; right:0px; z-index: -1; display: flex; justify-content: end;"
                wire:ignor>
                <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso"
                    style="position: absolute;
                width: 45%; right:0px;
                top: 310px; pointer-events: none;user-select: none;z-index: -1">
            </div> --}}
        {{-- </div> --}}

        {{-- STXT(H2;TROUVE(" "; H2); LEN(DROITE(H2; TROUVE(" "; H2) + 1))) --}}
        {{-- =STXT(H2;TROUVE(" ";  H2) + 1; LEN(H2) -  TROUVE(" ";  H2) ) --}}
        {{-- =STXT(H2; TROUVE(" ";  H2) + 1; LENB(H2) -  TROUVE(" ";  H2) ) --}}

        {{-- <div class="lines"
                style="position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: -1;
            display: flex;
            align-items: end;">
                <img src="{{ asset('assets/images/footer3.png') }}" alt="" style="width: 100%;" id="bound">
            </div> --}}
        <div class="block-header">
            <div class="mt-1 row g-lg-4 g-3">
                <div class="col-6">
                    <div class="logo">
                        <img src="{{ asset('assets/images/logoLetter.png') }}" alt="logo regideso"
                            style="width: 170px; pointer-events: none; user-select: none">
                    </div>
                </div>
                <div class="col-6">
                    <div class="copy-block">
                        <h6>
                            <span class="text-decoration-underline">Copie pour Information</span> :
                        </h6>
                        <ul class="copy-list">
                            @forelse ($copies ?? [] as $copie)
                                <li>
                                    {{ $copie }}
                                </li>
                            @empty
                                <li>
                                    Lorem ipsum dolor sit, amet consectetur.
                                </li>
                                <li>
                                    Lorem ipsum dolor sit, amet consectetur.
                                </li>
                                <li>
                                    Lorem ipsum dolor sit, amet consectetur.
                                </li>
                            @endforelse
                            <br>
                        </ul>
                        <h6 class="location">
                            ({{ $lieu_copie ?? 'Tous à Kinshasa' }})
                        </h6>
                    </div>
                    <hr width="70%" style="margin-top: 2px; margin-bottom: 2px;">
                    <div class="block-desti">
                        <p class="mb-0 me-2">
                            {{ $dest ?? 'A John Doe, directeur général' }} à <span
                                class="f fw-bold">{{ $ville ?? 'Kinshasa' }}</span>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="code-letter">
                        {{ $reference ?? 'REF / 001 / 2023' }}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="date-letter text-end me-5 pe-2">
                        <span class="loc-pic">{{ $lieu_date ?? 'Kinshasa, 11/06/2023' }}</span>
                        {{-- <span class="date"> 11/06/2023</span> --}}
                    </div>
                </div>
                <div class="col-lg-8 ">
                    <div class="mt-4 block-concerne d-flex align-items-baseline">
                        <span class="text-decoration-underline fw-bold" style="flex: 0 0 auto;">CONCERNE
                        </span>
                        <span style="margin-right:5px;margin-left:5px; ">:</span>
                        <h6 class="mb-0 ms-1 fw-bold text-decoration-underline">

                            {{ $concerne ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit.' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 block-body" contenteditable="true"
            data-maxheight="621" data-signatureheight="463">
            {!! $body ??
                '
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat, earum blanditiis eos inventore dolorem culpa molestias dolor!</p>
            ' !!}
        </div>
        <div class="my-4 row justify-content-end block-signature">
            <div class="col-6">
                @foreach ($cosignataires as $index => $cosignataire)
                    <div class="mb-5 text-center">
                        <span>
                            {{ $cosignataire['dest_fonction'] ?? "Le chef de Services D'Importation" }}
                        </span>
                        <h6>
                            {{ $cosignataire['dest_name'] ?? 'Francis ISASI' }}
                        </h6>
                        <div class="mx-auto cosignature signatureContainer w-75" style="height: 70px" wire:ignore>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-6" wire:ignore.self>
                <div class="text-center mb-">
                    <span>
                        {{ $exp_fonction ?? "Le chef de Services D'Exploitation" }}
                    </span>
                    <h6>
                        {{ $exp_name ?? 'Jean-Louis Dikasa' }}
                    </h6>
                    <div class="mx-auto signatureContainer w-75" style="height: 70px" wire:ignore>
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
                style="width: 100%;pointer-events: none; user-select: none" id="bound"
                data-html2canvas-ignore="true">
        </div>

    </div>
</div>
