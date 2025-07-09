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
                            <h6 style="font-size: 16px;font-weight:500!important">
                                <span class="text-decoration-underline" style="text-transform: uppercase">Ordre de mission N° DG/019/2023</span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-body mt-5" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
                <div class="content-text-letter">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                            <span class="text-decoration-underline" style="text-transform: uppercase">NOM ET POSTNOM</span>
                                            
                                        </h6>
                                        <span>:</span>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                        <span>NOM ET POSTNOM</span>, Matricule : 43822
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                            <span class="text-decoration-underline" style="text-transform: uppercase">COTE D'EMPLOI</span>
                                            
                                        </h6>
                                        <span>:</span>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                        <span>C17</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                            <span class="text-decoration-underline" style="text-transform: uppercase">FONCTION</span>
                                            
                                        </h6>
                                        <span>:</span>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                        <span>SECRETAIRE GENERAL</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <p style="font-size: 16px">Est chargé d'une mission de service à GOMA (DR/Nord-Kivu)</p>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                            <span class="text-decoration-underline" style="text-transform: uppercase">DIREE DE LA MISSION</span>
                                            
                                        </h6>
                                        <span>:</span>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                        <span>Six (06) Jours</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                            <span  style="text-transform: uppercase">DATE DE PART</span>
                                            
                                        </h6>
                                        <span>:</span>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                        <span>OPEN</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                            <span  style="text-transform: uppercase">FINANCEMENT</span>
                                            
                                        </h6>
                                        <span>:</span>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <h6 style="font-size: 16px;font-weight:500!important" class="mb-0">
                                        <span>Budget d'exploitation REGIDESO S.A</span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <p style="font-size: 16px">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Deserunt expedita officia ex voluptatibus voluptate? Enim perspiciatis est labore nemo explicabo aliquam, eos harum cupiditate fugit ipsa suscipit, dicta cumque illo?</p>
                        </div>
                        <div class="col-12">
                            <div class="date" style="margin-top: 50px;text-align: end; margin-right: 100px;">
                                Fait à Kinshasa, le 12 JUIL 2023
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block-signateurs">
                    <div class="row g-3 g-lg-4 mt-5 justify-content-center">
                        {{-- <div class="col-6">
                            <div class="text-center">
                                <span style="font-size: 16px">
                                    Le Directeur Général adjoint
                                </span>
                                <h6 style="margin-top: 40px; font-size: 16px;">
                                    Jean-Bosco MWAKA INDELE
                                </h6>
                            </div>
                        </div> --}}
                        <div class="col-6">
                            <div class="text-center">
                                <span style="font-size: 16px">
                                   le Directeur Général
                                </span>
                                <h6 style="margin-top: 40px; font-size: 16px;font-weight:500!important">
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
