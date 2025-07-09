@extends('regidoc.layouts.master')

@section('content')
    <div class="block-letter flex-column">
        <div class="inner-letter admin" style="padding-top: 60px; overflow:hidden">
            {{-- <div class="logo-card">
                <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso">
            </div>
            <div class="footer-card"></div>
            <div class="lines">
                <img src="{{ asset('assets/images/footer3.png') }}" alt="">
            </div> --}}
            <div class="block-header">
                <div class="row g-lg-5 g-3">
                    <div class="col-6">
                        <div class="logo">
                            <img src="{{ asset('assets/images/logoLetter.png') }}" alt="logo regideso"
                                style="width: 170px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="copy-block">
                            <h6 style="font-size: 16px;font-weight: 500!important">
                                <span class="text-decoration-underline" style="text-transform: uppercase">Note de service N° DG/019/2023</span>
                            </h6>
                            <h6 style="font-size: 16px;margin-top: 50px;font-weight: 500!important">
                                <span class="text-decoration-underline">Destinataires:</span>
                            </h6>
                            <ul class="copy-list mb-0">
                                <li style="font-size: 16px">
                                    Ensemble du personnel
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="block-concerne d-flex mt-4 align-items-baseline">
                            <span class="text-decoration-underline" style="flex: 0 0 auto; font-size: 16px;font-family: 'Roboto-bold', sans-serif;">CONCERNE
                                :</span>
                            <h6 class="mb-0 ms-1 fw-bold text-decoration-underline" style="font-size: 16px;font-weight: 500!important">
                                CREATION DES EMPLOIS A LA DIRECTION GENERALE DE lA REGIDESO SA
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-body mt-4" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
                <div class="content-text-letter">
                    <p style="text-indent: 88px;">
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
                    </p>
                    <div class="date" style="margin-top: 50px;text-align: end; margin-right: 100px;">
                        Fait à Kinshasa, le 12 JUIL 2023
                    </div>
                </div>
                <div class="block-signateurs">
                    <div class="row g-3 g-lg-4 mt-5 justify-content-center">
                        <div class="col-6">
                            <div class="text-center">
                                <span style="font-size: 16px">
                                    Le Directeur Général adjoint
                                </span>
                                <h6 style="margin-top: 40px; font-size: 16px;font-weight: 500!important">
                                    Jean-Bosco MWAKA INDELE
                                </h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <span style="font-size: 16px">
                                    Pour le Directeur Général
                                </span>
                                <h6 style="margin-top: 40px; font-size: 16px;font-weight: 500!important">
                                    David TSHILUMBA MUTOMBO
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-footer" style="position: absolute; bottom: 56px">
                <img src="{{ asset('assets/images/footer1.png') }}" alt="" class="img-footer">
            </div>

        </div>
    </div>
@endsection
