<div class="inner-letter" id="doc_save" wire:poll.keep-alive>
    <div class="block-header">
        <div class="row g-lg-4 g-3">
            <div class="col-7">
                <div class="logo">
                    <img src="{{ asset('assets/regidoc/default-logo.png') }}" style="width: 180px;" alt="">
                </div>
            </div>
            <div class="col-5">
                <div class="copy-block">
                    <h6>
                        <span class="text-decoration-underline">Copie pour Information</span> :
                    </h6>
                    <ul class="copy-list">
                        @forelse ($copies ?? [] as $copie)
                            <li>
                                {{ $copie }}
                            </li>
                            <br>
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
                    </ul>
                    <br>
                    <h6 class="location">
                        ({{ $lieu_copie ?? 'Tous à Kinshasa' }})
                    </h6>
                </div>
                <hr width="60%" style="margin-top: 2px; margin-bottom: 2px;">
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
                <div class="block-concerne d-flex mt-4 align-items-baseline">
                    <span class="text-decoration-underline fw-bold" style="flex: 0 0 auto;">CONCERNE
                    </span>
                    <span style="margin-right:5px;margin-left:5px; "> : </span>
                    <h6 class="mb-0 ms-1 fw-bold text-decoration-underline">

                        {{ $concerne ?? 'Lorem ipsum dolor sit amet consectetur adipisicing elit.' }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <div class="block-body flex-grow-1 mt-4">
        {!! $body ??
            '<p>
                                                                                                                                                                                                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                                                                                                                                    Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat,
                                                                                                                                                                                                                                    earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                <p>
                                                                                                                                                                                                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                                                                                                                                    Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat,
                                                                                                                                                                                                                                    earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                <p>
                                                                                                                                                                                                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                                                                                                                                    Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat,
                                                                                                                                                                                                                                    earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                <p>
                                                                                                                                                                                                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                                                                                                                                    Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat,
                                                                                                                                                                                                                                    earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                <p>
                                                                                                                                                                                                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                                                                                                                                                                                                    Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit fugiat,
                                                                                                                                                                                                                                    earum blanditiis eos inventore dolorem culpa molestias dolor!
                                                                                                                                                                                                                                </p>
                                                                                                                                                                                                                                ' !!}
    </div>
    <div class="row g-3 g-lg-4 mt-5">
        <div class="col-6">
            <div class="text-center">
                <span>
                    {{ $exp_fonction ?? "Le chef de Services D'Exploitation" }}
                </span>
                <h6>
                    {{ $exp_name ?? 'Jean-Louis Dikasa' }}
                </h6>
            </div>
        </div>
        @foreach ($cosignataires as $index => $cosignataire)
            <div class="col-6">
                <div class="text-center">
                    <span>
                        {{ $cosignataire['dest_fonction'] ?? "Le chef de Services D'Importation" }}
                    </span>
                    <h6>
                        {{ $cosignataire['dest_name'] ?? 'Francis ISASI' }}
                    </h6>
                </div>
            </div>
        @endforeach

    </div>
    <div class="block-footer">
    </div>
</div>
