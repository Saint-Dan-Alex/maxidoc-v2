@extends('regidoc.layouts.master')

@section('content')
    <div class="block-letter flex-column">

        <div class="inner-letter admin"
            style="padding: 80px 40px;padding-top: 60px; width: 793px;
        max-width: 100%;
        min-height: 1122px;
        background-color: white;display: flex;
        flex-direction: column;
        font-size: 15px;
        position: relative;
        z-index: 1;
        overflow: hidden;box-shadow: 0 5px 18px rgba(0, 0, 0, 0.05);">
            <div class="footer-card"></div>
            <div class="block-header">
                <div class="row g-lg-2 g-1">
                    <div class="col-7">
                        <div class="logo">
                            <img src="{{ asset('assets/images/logoDefault.png') }}" alt="logo regideso" style="width: 140px">
                        </div>
                        <p style="color:black; margin-bottom: 0; margin-top: 7px;font-size: 14px">N° d'impôt :</p>
                    </div>
                    <div class="col-5">
                        <p style="text-transform: uppercase; color:black; margin-bottom: 0;font-size: 14px">Boulevard du 30 juin</p>
                        <p style="text-transform: uppercase; color:black; margin-bottom: 0;font-size: 14px">N°59-63, Kinshasa I</p>
                        <p style="color:black; margin-bottom: 0;font-size: 14px">B.P.12599 id. Nat. 01-D3501-A 01918K</p>
                        <p style="color:black; margin-bottom: 0;font-size: 14px">Téléphone : (+243) 810800890</p>
                        <p style="color:black; margin-bottom: 0;font-size: 14px">E-mail : courrier@regidesordc.com</p>
                    </div>
                    <div class="col-10 text-end">
                        <div class="title-table"
                            style="display: inline-block;color:black;font-size: 20px;font-family: 'Roboto-bold';">
                            Bon de Commande <span style="font-style: italic; font-size: 16px">N°/ 10100/044/2023</span>
                        </div>
                    </div>
                    <div class="col-8">
                        <p style="color:black; margin-bottom: 0;font-size: 14px">Nom Fournisseur : DAKOTA AVIATION</p>
                    </div>
                    <div class="col-9 text-end">
                        <p style="color:black; margin-bottom: 0; font-size: 14px">DATE : 22/04/2023</p>
                    </div>
                    <div class="col-12">
                        <p style="color:black; margin-bottom: 0;font-size: 14px">Adresse : Av. MILITANT, AIROPORT DE NDOLO KIN RDC</p>
                    </div>
                </div>
            </div>
            <div class="block-body" style="margin-top: 30px;">
                <table class="table table-bordered"
                    style="caption-side: bottom;border-collapse: collapse;border-color: black;margin-bottom: 0;">
                    <thead>
                        <tr>
                            <th scope="col" 
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Quantité</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Unité</th>
                                <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                DESCRIPTION </th>
                                <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                               Remise</th>
                               <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Prix unitaire <br> USD TTC</th>
                                <th scope="col" colspan="2"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Prix total <br> USD TTC</th>
                        </tr>
                    </thead>
                    <tbody class="tbodyContent">
                        <tr class="row-table">
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important;text-align: end; resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important;text-align: end; resize: vertical;"></textarea>
                            </td>
                            <td colspan="2">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important;text-align: end; resize: vertical;"></textarea>
                            </td>
                            <td colspan="2">
                                <div class="block-add-row" style="height: 100%;position: relative;">
                                    <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: end;resize: vertical;"></textarea>
                                    <a href="#" class="btn-add-row"
                                        style="position: absolute; display: flex; align-items: center; justify-content: center; width: 20px; height: 20px;background: #edf0f6; color: black; font-size: 10px; border-radius: 100%; bottom: -18px;right:-17px;">
                                        <i class="fi fi-rr-plus"></i>
                                    </a>
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="6" style="text-align: center; color: black;font-family: 'Roboto-bold';vertical-align: middle">
                                TOTAL GENERAL TTC
                            </td>
                            <td colspan="3">
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                    style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: end; resize: vertical;"></textarea>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <th scope="col" 
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Réquisition N° du</th>
                            <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Introduite <br> par </th>
                                <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Service uitlisateur </th>
                                <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                               Imputation</th>
                               <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Destination</th>
                                <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Délai de livraison</th>
                                <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                Mode de paiement</th>
                                <th scope="col"
                                style="font-family:'Roboto-bold'; font-size:13px; font-weight: normal; color: black;text-align: center; vertical-align: top; padding: 2px;">
                                A transporter <br> par</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important;text-align: center; resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important;text-align: center;resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: center;resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: center;resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important;text-align: center; resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: center;resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: center; resize: vertical;"></textarea>
                            </td>
                            <td>
                                <textarea name="" id="" cols="30" rows="2" class="form-control p-0"
                                style="border:none;font-size: 14px; color: black;background: #fff!important; text-align: center; resize: vertical;"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p style="color:black; margin-bottom: 0;font-size: 14px; margin-top: 10px">Nous disons : Dollars américains Cent quatre vingt deux mille sept cents.</p>
            </div>
            <div class="row g-3 g-lg-4" style="margin-top: 30px; display: flex;">
                <div class="col-6" style="width: 50%">
                    <div class="text-center" style="text-align: center">
                        <span>
                            Le chef de Services D'Exploitation
                        </span>
                        <h6 style="font-weight: 400!important">
                            Jean-Louis Dikasa
                        </h6>
                    </div>
                </div>
                <div class="col-6" style="width: 50%">
                    <div class="text-center">
                        <span>
                            Le chef de Services D'Importation
                        </span>
                        <h6 style="font-weight: 400!important">
                            Francis ISASI
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.querySelector('.btn-add-row').addEventListener('click', function (e) {
            e.preventDefault();

            // Sélectionnez la ligne à cloner
            const rowToClone = document.querySelector('.row-table');

            // Clonez la ligne
            const clonedRow = rowToClone.cloneNode(true);
             // Effacez le contenu des zones de texte clonées
             const clonedTextareas = clonedRow.querySelectorAll('textarea');
            clonedTextareas.forEach(function (textarea) {
                textarea.value = ''; // Effacez le contenu
            });
            // Ajoutez la ligne clonée à la table
            const table = document.querySelector('.tbodyContent');
            table.appendChild(clonedRow);
        });
</script>
@endsection