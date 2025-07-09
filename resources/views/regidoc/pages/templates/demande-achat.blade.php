@extends('regidoc.layouts.master')

@section('content')
    <div class="block-letter flex-column">

        <div class="inner-letter admin"
            style="padding: 80px 40px;padding-top: 60px;min-width: 793px; width: 870px;
        max-width: 100%;
        min-height: 1172px;
        background-color: white;display: flex;
        flex-direction: column;
        font-size: 15px;
        position: relative;
        z-index: 1;
        overflow: hidden;box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);">
            <div class="footer-card"></div>
            <div class="block-header">
                <div class="row g-lg-5 g-3">
                    <div class="col-6">
                        <div class="logo">
                            <img src="{{ asset('assets/images/logoDefault.png') }}" alt="logo regideso" style="width: 170px">
                        </div>
                        <h5 style="color: black; font-size: 14px; margin-top: 20px;">DIRECTION DES APPROVISIONNEMENTS</h5>
                    </div>
                    <div class="col-12 text-center">
                        <div class="title-table"
                            style="display: inline-block;text-transform: uppercase; color:black; text-decoration:underline; font-size: 20px;font-family: 'Roboto-bold';">
                            Demande d'achat
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-body" style="margin-top: 30px;">
                <table class="table table-bordered"
                    style="caption-side: bottom;border-collapse: collapse;border-color: black;margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th scope="col" rowspan="3"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                N° <br> ITEMS</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;"
                                colspan="2">IMPUTATION:</th>
                            <th scope="col" colspan="2">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: end; padding: 2px; vertical-align: top">
                                NUMERO:</th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:14px; font-weight: normal; color: black;text-align: end; padding: 2px; vertical-align: top">
                                <input type="text" class="form-control p-0"
                                    style="border:none;font-size: 14px;color: black;background: #fff!important">
                            </th>
                        </tr>
                        <tr style="font-size: 14px">
                            <th scope="col" class="text-center" colspan="4" rowspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: middle;padding: 2px;">
                                TEXTES ET SPECIFICATIONS TECHNIQUES</th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: end; padding: 2px;vertical-align: top">
                                DESTINATION:</th>
                            <th scope="col" colspan="2" style="padding: 2px;vertical-align: top">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:14px; font-weight: normal; color: black; text-align: center; vertical-align: middle;padding: 2px;">
                                UNITE</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:14px; font-weight: normal; color: black; text-align: center;padding: 2px;">
                                Stocks <br> en place</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:14px; font-weight: normal; color: black; text-align: center;padding: 2px;">
                                QTE <br> Demandée</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:14px; font-weight: normal; color: black; text-align: center;padding: 2px;">
                                période de <br> Couverture</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" style="padding: 2px;">
                                <input type="text" class="form-control p-0"
                                    style="border:none;font-size: 14px;background: #fff!important">
                            </th>
                            <td colspan="4" style="padding: 2px">
                                <textarea name="" id="" cols="30" rows="3" class="form-control p-0"
                                    style="border:none;font-size: 14px;color: black;background: #fff!important"></textarea>
                            </td>
                            <td style="padding: 2px">
                                <input type="text" class="form-control p-0"
                                    style="border:none;font-size: 14px;color: black; text-align: center;background: #fff!important">
                            </td>
                            <td style="padding: 2px">
                                <input type="text" class="form-control p-0"
                                    style="border:none;font-size: 14px;color: black; text-align: center;background: #fff!important">
                            </td>
                            <td style="padding: 2px">
                                <input type="text" class="form-control p-0"
                                    style="border:none;font-size: 14px;color: black; text-align: center;background: #fff!important">
                            </td style="padding: 2px">
                            <td style="padding: 2px">
                                <div class="block-add-row" style="height: 100%;position: relative;">
                                    <input type="text" class="form-control p-0"
                                        style="border:none;font-size: 14px;color: black; text-align: center;background: #fff!important">
                                    <a href="#" class="btn-add-row"
                                        style="position: absolute; display: flex; align-items: center; justify-content: center; width: 20px; height: 20px;background: #edf0f6; color: black; font-size: 10px; border-radius: 100%; bottom: -53px;right:-10px;">
                                        <i class="fi fi-rr-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: middle; padding: 2px;">
                                JUSTIFICATION</th>
                            <th scope="col" colspan="11">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="3"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: middle; padding: 2px;">
                                SPECIFICATIONS ANNEXES</th>
                            <th scope="col" colspan="10">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <th scope="col" rowspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Date <br> d'émission</th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                DEMANDEUR</th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                Chef de Sce</th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                Chef de Div</th>
                            <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                DIRECTEUR</th>
                        </tr>
                        <tr>
                            <th scope="col" rowspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Nom <br> <br> <br> Signature</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                            <th scope="col" rowspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                Nom <br> <br> <br> Signature</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                            <th scope="col" rowspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                Nom <br> <br> <br> Signature</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                            <th scope="col" rowspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                Nom <br> <br> <br> Signature</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important"></textarea>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                <input type="date" class="form-control p-0"
                                    style="border:none;font-size: 14px;color: black;background: #fff!important">
                            </th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                            </th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                            </th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                            </th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center;vertical-align: top; padding: 2px;">
                            </th>
                        </tr>
                    </tbody>

                </table>
                <div style="display: flex; width: 50%">
                    <table class="table table-bordered"
                        style="caption-side: bottom;border-collapse: collapse;border-color: black; margin-top: 20px;">
                        <thead>
                            <tr>
                                <th scope="col" colspan="7"
                                    style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: left; vertical-align: top; padding: 2px;width: 360px">
                                    Nombres d'articles demandés
                                </th>
                                <td style="padding: 2px" colspan="5">
                                    <input class="form-control p-0"
                                        style="border:none;font-size: 14px;color: black; background: #fff!important">
                                </td>
                            </tr>
                            <tr>
                                <th scope="col" colspan="7"
                                    style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: left; vertical-align: top; padding: 2px;width: 360px">
                                    N° d'enregistrement DAP
                                </th>
                                <td style="padding: 2px" colspan="5">
                                    <input class="form-control p-0"
                                        style="border:none;font-size: 14px;color: black;background: #fff!important">
                                </td>
                            </tr>
                            <tr>
                                <th scope="col" colspan="7"
                                    style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: left; vertical-align: top; padding: 2px;width: 360px">
                                    Date d'enregistrement à la DAP
                                </th>
                                <td style="padding: 2px" colspan="5">
                                    <input
                                        class="form-control p-0"style="border:none;font-size: 14px;color: black;background: #fff!important">
                                </td>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
            {{-- <div class="row g-3 g-lg-4 mt-5">
                <div class="col-6">
                    <div class="text-center">
                        <span>
                            Le chef de Services D'Exploitation
                        </span>
                        <h6>
                            Jean-Louis Dikasa
                        </h6>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-center">
                        <span>
                            Le chef de Services D'Importation
                        </span>
                        <h6>
                            Francis ISASI
                        </h6>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="block-footer">
                <div class="d-flex align-items-center justify-content-center">
                    <img src="{{asset('assets/images/footer.png')}}" alt="" class="img-footer">
                </div>
            </div> --}}
        </div>
    </div>
@endsection
