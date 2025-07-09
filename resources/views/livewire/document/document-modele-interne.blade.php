<div>
    <div class="inner-letter admin"id="page1" wire:poll.keep-alive
        style="padding-top: 50px; height: 1122px;overflow:hidden;
        background-image:url({{ asset('assets/img.png') }});
        background-size: cover;
            background-repeat: no-repeat;
            background-position: top"
            >
        <div class="bande"
            style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1;
                margin-bottom: 50px;"
            data-html2canvas-ignore="true">
            <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso"
                style="
            width: 100%;user-select: none; pointer-events: none;">
        </div>
        {{-- <div class="logo-card" style="position: absolute; width: 100%; height: 100%; left: 0px; top: 0px;right:0px;0px
                z-index: -1; display: flex; justify-content: end;" wire:ignore>
            <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso"
                style="position: absolute;
            width: 45%;
            top: 390px;pointer-events: none;user-select: none">
        </div> --}}
        <div class="block-header">
            <div class="mt-1 row g-lg-4 g-3">
                <div class="col-6" contenteditable="false">
                    <div class="logo">
                        <img src="{{ asset('assets/images/logoLetter.png') }}" alt="logo regideso" style="width: 170px;">
                    </div>
                </div>
                <div class="col-6">

                    <div class="block-desti">
                        <p class="mb-0" style="font-size: 16px;">
                            A {{ $dest ?? ' Monsieur FRANCIS ISASI' }}
                        </p>
                        <p class="mb-0" style="font-size: 16px;">
                            Matricule: {{ $dest_mat ?? '16611' }}
                        </p>
                        <p class="mb-0" style="font-size: 16px;">
                            {{ $deste_poste ?? 'Informaticien' }}
                        </p>
                        <h6 class="mt-1" style="font-weight: 500!important">
                            <span
                                class="text-decoration-underline">{{ $direction ?? 'C/° REGIDESO S.A/DCK - NORD/OUEST' }}</span>
                        </h6>
                        <p class="mb-0" style="font-size: 16px;">
                            {{ $division ?? 'C.I :DRK-OUEST' }}
                        </p>
                        <p class="mb-0" style="font-size: 16px;">
                            {{ $section ? 'S/C de ' . $section : '' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="code-letter">
                        {{ $reference ?? ' REF / 001 / 2023' }}
                    </div>
                </div>
                <div class="col-lg-6">

                    <div class="date-letter text-end" style="margin-right: 60px">
                        <span class="loc-pic">{{ $lieu_date ?? 'Kinshasa, 06/06/2023' }}</span>

                    </div>
                </div>
                <div class="col-lg-12 ">
                    <p>{{ $directeur ?? 'Monsieur' }}</p>
                    <div class="mt-4 block-concerne d-flex align-items-baseline">
                        <span class="text-decoration-underline"
                            style="flex: 0 0 auto; font-size: 16px;font-family: 'Roboto-bold', sans-serif;">OBJET
                            :</span>
                        <h6 class="mb-0 ms-1 text-decoration-underline" style="font-size: 16px;font-weight: 500!important">
                            {{ $concerne ?? ' VOTRE  DEMISSION' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 block-body" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
            <div class="content-text-letter">
                {!! $body ??
                    "<p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>" !!}
            </div>
            <div class="block-signateurs" style="padding-bottom: 100px;">
                <div class="my-5 row g-3 g-lg-4 justify-content-center">
                    {{-- <div class="col-6">
                        <div class="text-center">
                            <span>
                                Le chef de Services D'Exploitation
                            </span>
                            <h6>
                                Jean-Louis Dikasa
                            </h6>
                        </div>
                    </div> --}}
                    <div class="col-6">
                        <div class="text-center">
                            <span style="font-size: 16px">
                                {{ $exp_fonction ?? 'Le Directeur Général' }}
                            </span>
                            <h6 style="font-size: 16px; font-weight: 500!important">
                                {{ $exp_name ?? 'David THILUMBA MUTOMBO' }}
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

    <div class="inner-letter admin"id="page2"
        style="padding-top: 50px; height: 1122px;overflow:hidden;
        background-image:url({{ asset('assets/img.png') }});
        background-size: cover;
            background-repeat: no-repeat;
            background-position: top"
            >
        <div class="bande"
            style="position: absolute; width: 50%; top: 0; right: 0; z-index: -1;
                margin-bottom: 50px;"
            data-html2canvas-ignore="true">
            <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso"
                style="
            width: 100%;user-select: none; pointer-events: none;">
        </div>
        <div class="block-header">
            <div class="mt-1 row g-lg-4 g-3">
                <div class="col-lg-12 ">
                    <p>{{ $directeur ?? 'Monsieur' }}</p>
                    <div class="mt-4 block-concerne d-flex align-items-baseline">
                        <span class="text-decoration-underline"
                            style="flex: 0 0 auto; font-size: 16px;font-family: 'Roboto-bold', sans-serif;">OBJET
                            :</span>
                        <h6 class="mb-0 ms-1 text-decoration-underline" style="font-size: 16px;font-weight: 500!important">
                            {{ $concerne ?? ' VOTRE  DEMISSION' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 block-body" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
            <div class="content-text-letter">
                {!! $body ??
                    "<p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style='text-indent: 60px'>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>" !!}
            </div>
            <div class="block-signateurs" style="padding-bottom: 100px;">
                <div class="my-5 row g-3 g-lg-4 justify-content-center">
                    {{-- <div class="col-6">
                        <div class="text-center">
                            <span>
                                Le chef de Services D'Exploitation
                            </span>
                            <h6>
                                Jean-Louis Dikasa
                            </h6>
                        </div>
                    </div> --}}
                    <div class="col-6">
                        <div class="text-center">
                            <span style="font-size: 16px">
                                {{ $exp_fonction ?? 'Le Directeur Général' }}
                            </span>
                            <h6 style="font-size: 16px; font-weight: 500!important">
                                {{ $exp_name ?? 'David THILUMBA MUTOMBO' }}
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

</div>
