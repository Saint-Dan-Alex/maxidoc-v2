@extends('regidoc.layouts.layout-doc')
@section('style')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 300px;
        }

        .ck-content .image {
            /* block images */
            max-width: 80%;
            margin: 20px auto;
        }

        .block-letter .inner-letter .bande {
            position: absolute;
            width: 50%;
            top: 0;
            right: 0;
            z-index: -1;
        }

        .block-letter .inner-letter .logo-card {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: -1;
            display: flex;
            justify-content: end;
        }

        .block-letter .inner-letter .footer-card {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: -1;
        }

        .block-letter .inner-letter .lines {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            z-index: -1;
            display: flex;
            align-items: end;
        }

        .icon-circle {
            display: inline-block;
            width: 24px;
            /* Largeur souhaitée du cercle */
            height: 24px;
            /* Hauteur souhaitée du cercle */
            background-color: green;
            /* Couleur du cercle */
            border-radius: 50%;
            /* Pour créer un cercle */
            text-align: center;
            line-height: 24px;
            /* Pour centrer le contenu vertical */
        }

        .text-layer>div::selection {
            background: #dd5500;
        }

        .image-container {
            position: absolute;
            top: 100%;
            left: 100%;
            transform: translate(-110%, -170%);
            z-index: 9999;
        }

        .image-container img {
            width: 200px;
            /* Set an initial width */
            height: auto;
            /* Preserve aspect ratio */
            resize: both;
            overflow: auto;
            object-fit: cover;
        }

        .ui-resizable-sw,
        .ui-resizable-ne,
        .ui-resizable-nw,
        .ui-resizable-se {
            border: 1px solid #999999;
        }

        .ui-resizable-n,
        .ui-resizable-s {
            height: 9px;
            width: 9px;
            left: 49%;
            border: 1px solid #999;
        }

        .ui-resizable-e,
        .ui-resizable-w {
            height: 9px;
            width: 9px;
            top: 41%;
            border: 1px solid #999;
        }

        .ui-icon-gripsmall-diagonal-se {
            background-position: initial;
        }

        .ui-icon {
            width: 9px;
            height: 9px;
            background: none !important;
        }

        .ui-resizable-se {
            right: -5px;
            bottom: -5px;
        }

        .signature {
            position: fixed;
            z-index: 1025;
            width: 175px;
            height: 75px;
        }

        .signature.dropped-true {
            border: none;
        }

        .signature.dropped-true:hover {
            border: 1px solid #eee;
        }

        .signature.dropped-true img {
            cursor: pointer;
        }

        .signature.dropped-true button {
            display: none;
        }

        .signature.dropped-true:hover button {
            display: initial;
        }

        /* .page {
            width: 210mm;  Largeur d'une feuille A4 
            height: 297mm; /* Hauteur d'une feuille A4 
            margin: 20mm auto; /* Marges sur la feuille, ajustez en fonction de votre besoin 
            padding: 20mm; /* Espaces internes /
            box-sizing: border-box;
            overflow: hidden; / Pour éviter que le contenu dépasse la page 
        }

        @media print {
            .page {
                page-break-after: always; / S'assurer qu'une page s'imprime séparément /
            }
        } */

    </style>
@endsection
@section('content')
    <div id="page-load" style="display: none">
        <div class="backdrop fade"></div>
        <div class="parent-modal">
            <div class="dialog dialog-centered">
                <div class="content-modal">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="load-spiner">
                            </div>
                            <div class="text-stared">
                                <h6 class="mb-0" style="color:var(--colorTitre)!important;">
                                    Enregistrement en cours...
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-options" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="px-2 pt-2 pb-2 modal-body px-lg-4 pb-lg-4">
                    <div class="d-flex align-items-center w-100 badge-xxl green">
                        <span class="icon-circle-check" style="flex: 0 0 auto">
                            <i class="text-white fi fi-rr-check"></i>
                        </span>
                        <p>
                            Vous avez généré votre document avec succès. <br> Choisissez votre prochaine action.
                        </p>
                    </div>
                    <div class="row g-lg-3 g-2">
                        <div class="col-6">
                            <button id="download" class="btn btn-action-doc d-flex flex-column h-100">
                                <i class="fi fi-rr-download"></i>
                                Enregistrer et sauvegarder sur l'ordinateur
                            </button>
                        </div>
                        <div class="col-6">
                            <button id="save" class="btn btn-action-doc d-flex flex-column h-100"><i
                                    class="fi fi-rr-folder-download"></i>Enregistrer dans vos documents REGIDOCS</button>
                        </div>
                        <div class="col-6">
                            <button id="sendCourrier" class="btn btn-action-doc d-flex flex-column h-100">
                                <i class="fi fi-rr-paper-plane"></i>
                                Joindre à un courrier interne
                            </button>
                        </div>
                        <div class="col-6">
                            <button id="sendTask" class="btn btn-action-doc d-flex flex-column h-100">
                                <i class="fi fi-rr-list-check"></i>
                                Joindre à une nouvelle tâche
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="saveForm" action="{{ route('documents.saveDoc') }}" method="POST" style="display:
    none">
        @csrf
        <input type="hidden" name="textSelected" id="textSelectedInput">
        <input type="hidden" name="fileName" id="fileNameInput">
    </form>

    <form id="saveForm" action="{{ route('documents.saveDoc') }}" method="POST">
        @csrf
        <input type="hidden" name="textSelected" id="textSelectedInput">
        <input type="hidden" name="fileName" id="fileNameInput">
    </form>

    <div class="block-scanner">
        @livewire('document.create-doc-form', ['doc_type' => $doc_type, 'brouillon' => $brouillon])
    </div>

    
@endsection

@section('javascript')
    {{-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-html2canvas@latest/dist/jspdf-html2canvas.min.js"></script> --}}

    <script src="{{ asset('vendor/jsPDF/html2canvas.min.js') }}"></script>
    <script src="{{ asset('vendor/jsPDF/jspdf.umd.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#check-date').on('click', function() {
                // var parent = $('#inputPassword').parent().parent();
                $('.date-limite').toggleClass('d-none');

                // console.log($(this).val());
                // $('#inputPassword').attr('required');
            });

            $('input[name=confidentiel]').on('click', function() {
                // var parent = $('#inputPassword').parent().parent();
                // $('.date-limite').toggleClass('d-none');
                console.log($(this));
            });

        });

        window.jsPDF = window.jspdf.jsPDF;
        var loader = document.getElementById('page-load');
        Livewire.on('downloadPDF', function() {
            loader.style.display = "block";
            Convert_HTML_To_PDF();
        });

        Livewire.on('downloadLetterPDF', function() {
            loader.style.display = "block";
             Convert_Letter_HTML_To_PDF();
            // test();
        });

        Livewire.on('downloadFooterPDF', function() {
            loader.style.display = "block";
            // Convert_Letter_HTML_To_PDF();
            Convert_HTML_FOOTER_To_PDF();
        });

        Livewire.on('addRow', function() {
            // console.log('Loading....................');
            createRow();
        });

        function createRow() {
            var btn = document.querySelector('#btn-add-row');

            // Sélectionnez la ligne à cloner
            const rowToClone = document.querySelector('.row-table');

            // Clonez la ligne
            const clonedRow = rowToClone.cloneNode(true);
            // Effacez le contenu des zones de texte clonées
            const clonedTextareas = clonedRow.querySelectorAll('textarea');
            const clonedInputs = clonedRow.querySelectorAll('input');
            clonedTextareas.forEach(function(textarea) {
                textarea.value = ''; // Effacez le contenu
            });

            clonedInputs.forEach(function(input) {
                input.value = ''; // Effacez le contenu
            });
            // Ajoutez la ligne clonée à la table
            const table = document.querySelector('.tbodyContent');
            table.appendChild(clonedRow);
        }

        function captureContentAsImage(callback) {

            var elementHTML = document.querySelector("#doc_save");
            html2canvas(elementHTML).then(function(canvas) {
                callback(canvas.toDataURL("image/jpeg"));
            });
        }

        $('.btn-test').on('click', function() {
            // duplicateImage();
            test();
        })

        function test() {
            const bande = $('.bande img');
            // const goutte = $('.logo-card img');
            const footer = $('.block-footer .img-footer');
            const bound = $('#bound');
            const signatures = document.querySelectorAll('#doc_save .signature');
            $(signatures).css({
                position: "static",
                marginLeft: $(signatures).data('x') + 'px'
            });
            // console.log($(signatures).parent());
            $('.signatureContainer').removeClass('ui-state-highlight');

            var elementHTML = document.querySelector("#doc_save");
            let myimage = "{{ asset('assets/img2.png') }}";



            // jsPDF: {
            //     unit: 'pt',
            //     format: 'a4',
            // },
            // // html2canvas: {
            // //     imageTimeout: 15000,
            // //     logging: true,
            // //     useCORS: false,
            // // },
            // // imageType: 'image/jpeg',
            // // imageQuality: 1,
            // margin: {
            //     top: 80,//80, 60, 80, 50
            //     right: 50,
            //     bottom: 80,
            //     left: 50,
            // },
            // watermark: {
            //     src: myimage,
            //     // scale: 0.5
            // },
            // // autoResize: true,
            // // output: 'jspdf-generate.pdf',


            // const options = {
            //     jsPDF: {
            //         unit: 'pt',
            //         format: 'a4'
            //     },
            //     watermark: myimage,
            //     margin: [80, 50, 80, 50],
            //     imageQuality: 1
            //     // {
            //     //     top: 80,
            //     //     right: 50,
            //     //     bottom: 80,
            //     //     left: 50,
            //     // }
            // };

            // const pages = document.getElementsByClassName('page');

            // html2PDF(elementHTML, {
            //     jsPDF: {
            //         format: 'a4',
            //     },
            //     watermark: {
            //         src: myimage,
            //         handler({
            //             pdf,
            //             imgNode,
            //             pageNumber,
            //             totalPageNumber
            //         }) {
            //             var pageSize = pdf.internal.pageSize;
            //             const props = pdf.getImageProperties(imgNode);
            //             // do something...
            //             pdf.addImage(imgNode, 'PNG', 0, 0, pageSize.width, pageSize.height);
            //         },
            //     },
            //     // watermark: myimage,
            //     imageType: 'image/jpeg',
            //     output: './pdf/generate.pdf'
            // });

            // var pdf = html2PDF();
            // html2PDF(elementHTML,
            // options)
            // // .outputPdf()
            // .output('blob')
            // .then(function (pdfData) {
            //     // customSave(pdfData, 'custom.pdf');
            //     savePDFToStorage(pdfData);
            // });

            // html2PDF(elementHTML, {
            //     jsPDF: {
            //         unit: 'pt',
            //         format: 'a4'
            //     },
            //     watermark: myimage,
            //     output: 'jspdf-generate.pdf',
            //     init: function() {},
            //     success: function(pdf) {
            //         var pdfData = pdf.output('blob');
            //         // savePDFToStorage(pdfData);
            //         pdf.save(this.output);
            //     }
            // });

            var doc = new jsPDF('p', 'pt', 'a3', true, true);

            doc.internal.events.subscribe('addPage', function() {
                pageSize = view.doc.internal.pageSize;
                doc.addImage(myimage, 'PNG', 0, 0, pageSize.width, pageSize.height);
            });

            doc.html(elementHTML, {
                callback: function(pdf) {
                    var totalPages = pdf.internal.getNumberOfPages();
                    for (let i = 1; i <= totalPages; i++) {

                        pdf.setPage(i);

                        pdf.addImage(
                            bande.attr('src'),
                            'PNG',
                            pdf.internal.pageSize.getWidth() / 2,
                            0,
                            pdf.internal.pageSize.getWidth() / 2,
                            56
                        );

                        console.log(pdf.internal.pageSize.getHeight());

                        pdf.addImage(
                            footer.attr('src'),
                            'PNG',
                            (pdf.internal.pageSize.getWidth() / 2) - (((pdf.internal.pageSize.getWidth() *
                                    80) /
                                100) / 2),
                            pdf.internal.pageSize.getHeight() - 60,
                            (pdf.internal.pageSize.getWidth() * 80) / 100,
                            33
                        );

                        pdf.addImage(
                            bound.attr('src'),
                            'PNG',
                            0,
                            pdf.internal.pageSize.getHeight() - 16,
                            pdf.internal.pageSize.getWidth(),
                            16
                        );

                    }

                    // for (let j = 0; j <= signatures.length; j++) {
                    // pdf.addImage(
                    //     $(signatures[0]).find('img').attr('src'),
                    //     'PNG',
                    //     $(signatures[0]).data('x'),
                    //     $(signatures[0]).data('y'),
                    //     $(signatures[0]).width(),
                    //     $(signatures[0]).height()
                    // );
                    // }

                    // Enregistrer le PDF
                    var pdfData = pdf.output('blob');
                    savePDFToStorage(pdfData);
                },
                margin: [80, 60, 80, 50],
                fontSize: 12,
                autoPaging: 'text',
                // x: 50,
                // y: 0,
            });

        }

        function getDecimalPart(number) {
            // Use the modulo operator (%) to get the integer part
            const integerPart = Math.floor(number);

            // Subtract the integer part from the original number to get the decimal part
            const decimalPart = number - integerPart;

            return decimalPart;
        }

        function Convert_HTML_To_PDF() {
            var doc = new jsPDF('p', 'pt', 'a3', true, true);
            var elementHTML = document.querySelector("#doc_save");
            elementHTML.addClass = 'p-0';
            elementHTML.style.padding = '30px';
            doc.html(elementHTML, {
                callback: function(doc) {
                    // Save the PDF
                    var pdfData = doc.output('blob');
                    savePDFToStorage(pdfData);
                    // doc.save('doc.pdf');

                },
                margin: [20, 20, 20, 20],
                fontSize: 12,
                autoPaging: 'text',
                x: 20,
                y: 20,
            });
            elementHTML.removeClass = 'p-0';
        }

        function Convert_HTML_FOOTER_To_PDF() {
            const footer = $('.block-footer .img-footer');
            var doc = new jsPDF('p', 'pt', 'a3', true);
            var elementHTML = document.querySelector("#doc_save");
            doc.html(elementHTML, {
                callback: function(pdf) {
                    var totalPages = pdf.internal.getNumberOfPages();
                    for (let i = 1; i <= totalPages; i++) {

                        pdf.setPage(i);

                        pdf.addImage(
                            footer.attr('src'),
                            'PNG',
                            (pdf.internal.pageSize.getWidth() / 2) - (((pdf.internal.pageSize.getWidth() *
                                    80) /
                                100) / 2),
                            pdf.internal.pageSize.getHeight() - 60,
                            (pdf.internal.pageSize.getWidth() * 80) / 100,
                            33
                        );
                    }

                    // Enregistrer le PDF
                    var pdfData = pdf.output('blob');
                    savePDFToStorage(pdfData);
                },
                margin: [50, 50, 80, 50],
                // margin: [30, 50, 80, 30],
                fontSize: 12,
                autoPaging: 'text',

            });
        }

        function Convert_Letter_HTML_To_PDF() {
            var doc = new jsPDF('p', 'pt', 'a3', true);
            var elementHTML = document.querySelector("#doc_save");
            var footerHtml = document.querySelector('#footer');
            var bodyHtml = document.querySelector('#block-body');
            var bound = document.querySelector("#bound");
            footerHtml.style.height = "0px";
            bodyHtml.style.paddingRight = "30px";
            bodyHtml.style.paddingLeft = "20px";
            // Convertir l'élément footer en image base64 en utilisant html2canvas
            captureContentAsImage(function(footerImageData) {
                doc.html(elementHTML, {
                    callback: function(doc) {
                        var pageCount = doc.internal.getNumberOfPages();

                        // Ajouter le pied de page sur chaque page
                        for (var i = 1; i <= pageCount; i++) {
                            doc.setPage(i); // Sélectionner la page i

                            if (i === 1) {
                                // Première page : pas de marge supérieure
                                doc.addImage(footerImageData, 'JPEG', 0, doc.internal.pageSize.height -
                                    80,
                                    doc.internal.pageSize.width, 80);
                            } else {
                                doc.addImage(footerImageData, 'JPEG', 0, doc.internal.pageSize.height -
                                    80,
                                    doc.internal.pageSize.width, 80);
                            }
                        }

                        // Enregistrer le PDF
                        var pdfData = doc.output('blob');
                        savePDFToStorage(pdfData);
                    },
                    margin: [0, 0, 20, 0],
                    fontSize: 12,
                    autoPaging: 'text',
                    x: 50,
                    y: 0,
                });
            });
        }

        function captureContentAsImage(callback) {
            var footerElement = document.querySelector("#footer"); // Pied de page
            var bodyElement = document.querySelector("#block-body"); // Pied de page
            var bound = document.querySelector("#bound");
            footerElement.style.height = "146.59375px";
            bound.style.width = "793px";
            html2canvas(footerElement).then(function(canvas) {
                callback(canvas.toDataURL("image/jpeg"));
                footerElement.style.height = "0px";
                bound.style.width = "300px";
                bodyElement.style.paddingRight = "30px";
                bodyElement.style.paddingLeft = "20px";
            });
        }


        async function savePDFToStorage(pdfData) {
            var selectElement = document.getElementById("type_id");
            var selectedText = "{{ $template }}";
            var fileName = "{{ Str::random(10) }}";

            // var data = await new Blob([pdfData], {
            //     type: 'application/pdf'
            // });
            // var data = pdfData;

            var formData = new FormData();
            formData.append('pdfFile', pdfData, fileName + '.pdf');
            formData.append('textSelected', selectedText);
            // console.log(formData);
            $.ajax({
                url: "{{ route('documents.storeNew') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    loader.style.display = "none";
                    var modal = new bootstrap.Modal('#modal-options', {
                        keyboard: false,
                    });
                    modal.show();
                    $('#download').click(function() {
                        // Créez un lien d'ancrage (élément <a>) pour le téléchargement du fichier
                        var downloadLink = document.createElement("a");
                        downloadLink.href = URL.createObjectURL(
                            pdfData); // Crée une URL objet pour le Blob
                        downloadLink.download = selectedText + "{{ date('_dmYHi') }}" +
                            ".pdf"; // Spécifie le nom de fichier lors du téléchargement

                        // Ajoutez le lien d'ancrage à la page (temporairement)
                        document.body.appendChild(downloadLink);

                        // Simule le clic sur le lien pour déclencher le téléchargement
                        downloadLink.click();

                        // Libère la ressource URL après le téléchargement
                        URL.revokeObjectURL(downloadLink.href);

                        // Ouvrez le modal après le téléchargement
                        window.location.href = "{{ route('regidoc.documents.createNew') }}";
                    })
                    $('#save').click(function() {
                        // Mise à jour des valeurs des champs cachés
                        $('#textSelectedInput').val(selectedText);
                        $('#fileNameInput').val(fileName);

                        // Soumission du formulaire
                        $('#saveForm').submit();
                    });


                    $('#sendCourrier').click(function() {
                        window.location.href =
                            "{{ route('regidoc.courriers.create', ['newdoc' => true]) }}" +
                            "&textSelected=" + encodeURIComponent(selectedText) +
                            "&fileName=" + encodeURIComponent(fileName);
                    })
                    $('#sendTask').click(function() {
                        window.location.href =
                            "{{ route('regidoc.taches.create', ['newdoc' => true]) }}" +
                            "&textSelected=" + encodeURIComponent(selectedText) +
                            "&fileName=" + encodeURIComponent(fileName);
                    })
                },
                error: function(error) {
                    console.error("Erreur lors de l'enregistrement du PDF : ",
                        error);
                    loader.style.display = "none";
                }
            });
        }

        loader.style.display = "none";


    // document.addEventListener('DOMContentLoaded', function () {
    //     let pages = document.querySelectorAll('.page');
    //     pages.forEach(page => {
    //         // Si la hauteur de la page dépasse la hauteur définie (A4), il faut la diviser
    //         while (page.scrollHeight > page.clientHeight) {
    //             let lastChild = page.lastElementChild;
    //             if (lastChild) {
    //                 // Créer une nouvelle page pour transférer l'excédent
    //                 let newPage = document.createElement('div');
    //                 newPage.classList.add('page');
                    
    //                 // Transférer l'excédent vers la nouvelle page
    //                 newPage.appendChild(lastChild);
    //                 page.parentNode.insertBefore(newPage, page.nextSibling);
    //             }
    //         }
    //     });
    // });

    </script>

    {{-- <div wire:scroll="scrollHandler">Contenu défilable</div> --}}
    {{-- public function scrollHandler($event)
    {
        // Vous pouvez accéder à la position du défilement via $event['scrollTop']
        $scrollPosition = $event['scrollTop'];

        // Faites quelque chose avec la position du défilement...
    } --}}
@endsection
