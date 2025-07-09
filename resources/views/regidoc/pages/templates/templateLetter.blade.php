@extends('regidoc.layouts.master')

@section('content')
    <div class="block-letter flex-column">
        <div class="inner-letter admin" style="padding-top: 60px;overflow:hidden">
            <div class="bande">
                <img src="{{ asset('assets/images/band.png') }}" alt="bande regideso">
            </div>
            <div class="logo-card">
                <img src="{{ asset('assets/images/cadre2.png') }}" alt="logo regideso">
            </div>
            <div class="footer-card"></div>
            <div class="lines">
                <img src="{{ asset('assets/images/footer3.png') }}" alt="">
            </div>
            <div class="block-header">
                <div class="row g-lg-4 g-3 mt-1">
                    <div class="col-6">
                        <div class="logo">
                            <img src="{{ asset('assets/images/logoLetter.png') }}" alt="logo regideso"
                                style="width: 170px;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="copy-block">
                            <h6 style="font-size: 16px;font-weight: 500!important;">
                                <span class="text-decoration-underline">Copie pour Information</span> :
                            </h6>
                            <ul class="copy-list">
                                <li style="font-size: 16px">
                                    Lorem ipsum dolor sit, amet consectetur.
                                </li>
                                <li style="font-size: 16px">
                                    Lorem ipsum dolor sit, amet consectetur.
                                </li>
                                <li style="font-size: 16px">
                                    Lorem ipsum dolor sit, amet consectetur.
                                </li>
                            </ul>
                            <h6 class="location" style="font-size: 16px;font-weight: 500!important;">
                                (Tous à Kinshasa)
                            </h6>
                        </div>
                        <hr>
                        <div class="block-desti">
                            <p class="mb-0" style="font-size: 16px">
                                A John Doe, directeur général à <span style="font-family: 'Roboto-bold', sans-serif;">Kinshasa</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="code-letter" style="font-size: 16px;">
                            REF/001/2023
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="date-letter text-end me-">
                            <span class="loc-pic" style="font-size: 16px">Kinshasa, 11/06/2023</span>

                        </div>
                    </div>
                    <div class="col-lg-12 ">
                        <div class="block-concerne d-flex mt-4 align-items-baseline">
                            <span class="text-decoration-underline" style="flex: 0 0 auto; font-size: 16px;font-family: 'Roboto-bold', sans-serif;">CONCERNE
                                :</span>
                            <h6 class="mb-0 ms-1 fw-bold text-decoration-underline" style="font-size: 16px; font-weight: 500!important">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-body mt-4" style="flex-grow: 1; display: flex; flex-direction: column; padding-bottom: 20px;">
                <div class="content-text-letter">
                    <p style="text-indent: 80px">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style="text-indent: 80px">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style="text-indent: 80px">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style="text-indent: 80px">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                    <p style="text-indent: 80px">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Ut a perferendis similique eius laudantium! Similique, debitis, quod beatae ipsum laborum suscipit
                        fugiat,
                        earum blanditiis eos inventore dolorem culpa molestias dolor!
                    </p>
                </div>
                <div class="block-signateurs">
                    <div class="row g-3 g-lg-4 mt-2">
                        <div class="col-6">
                            <div class="text-center">
                                <span style="font-size: 16px">
                                    Le chef de Services D'Exploitation
                                </span>
                                <h6 style="font-size: 16px; font-weight: 500!important">
                                    Jean-Louis Dikasa
                                </h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <span style="font-size: 16px">
                                    Le chef de Services D'Importation
                                </span>
                                <h6 style="font-size: 16px; font-weight: 500!important">
                                    Francis ISASI
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
{{-- @section('scripts')
    <script>
        const blockLetter = document.querySelector('.block-letter');
        const innerLetter = document.querySelectorAll('.inner-letter');
        const bande = document.querySelector('.bande');
        const blockHeader = document.querySelector('.block-header');
        const blockSignature = document.querySelector('.block-signateurs');
        const maxHeight = 1000; // Hauteur maximale de la feuille

        innerLetter.forEach(innerLetterThis => {
            // Fonction pour dupliquer la feuille
            function duplicateLetter() {
                const newInnerLetter = innerLetterThis.cloneNode(true);
                blockLetter.appendChild(newInnerLetter);
                // Réinitialisez le contenu du content-text-letter à vide
                lastParagraph = newInnerLetter.querySelector('.content-text-letter p:last-child')
                console.log(lastParagraph);
                const contentTextLetter = newInnerLetter.querySelector('.content-text-letter');
                contentTextLetter.textContent = "";
                contentTextLetter.appendChild(lastParagraph)
                // Retirez les classes "bande" et "block-header" du contenu cloné
                const newBande = newInnerLetter.querySelector('.bande');
                if (newBande) {
                    newBande.style.display = 'none';
                }
                const newBlockHeader = newInnerLetter.querySelector('.block-header');
                if (newBlockHeader) {
                    newBlockHeader.style.display = 'none';
                }
                return newInnerLetter;
            }

            // Fonction pour vérifier la hauteur du contenu
            function checkContentHeight() {
                if (innerLetterThis.scrollHeight > innerLetterThis.clientHeight) {
                    duplicateLetter();
                }
            }

            // Vérifiez la hauteur du contenu lorsqu'il y a une mise à jour du contenu
            innerLetterThis.addEventListener('DOMSubtreeModified', checkContentHeight);

            // Vérifiez la hauteur initiale du contenu
            window.addEventListener('load', checkContentHeight);
        });
    </script>
    
@endsection --}}
