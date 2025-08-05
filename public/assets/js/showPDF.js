$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

let __PDF_DOC,
    __CURRENT_PAGE,
    __TOTAL_PAGES,
    __PAGE_RENDERING_IN_PROGRESS = 0;

let url = $("#pdf-main-container").data("url");
let docName = $("#pdf-main-container").data("name");
let courrier_id = $("#pdf-main-container").data("courrier");
let tache_id = $("#pdf-main-container").data("tache");
let docId = $("#pdf-main-container").data("docid");
let code = $("#pdf-main-container").data("code");

showPDF(url);

function showPDF(pdf_url) {
    // Nettoyer l'URL
    if (typeof pdf_url === 'string') {
        // Supprimer les échappements et guillemets
        pdf_url = pdf_url.replace(/\\/g, '').replace(/^"|"$/g, '');
        
        // Corriger les doubles 'documents' dans l'URL
        pdf_url = pdf_url.replace(/(\/storage\/documents\/?)documents\//, '$1');
    }
    
    console.log('Tentative de chargement du PDF depuis :', pdf_url);
    
    const pdfContents = $("#pdf-contents");
    $(".pdf-tools #download").attr("href", pdf_url);
    $(".pdf-tools #download").attr("download", pdf_url);

    // Vérifier si l'URL est valide
    if (!pdf_url) {
        const errorMsg = 'Aucune URL de document fournie';
        console.error(errorMsg);
        pdfContents.html('<div class="alert alert-danger m-3"><h5>Erreur de chargement</h5><p>' + errorMsg + '</p></div>');
        return;
    }

    PDFJS.getDocument({
        url: pdf_url,
        // Activer CORS si nécessaire
        // withCredentials: true,
        // httpHeaders: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(function (pdf_doc) {
            __PDF_DOC = pdf_doc;
            __TOTAL_PAGES = __PDF_DOC.numPages;

            // Hide the pdf loader and show pdf container in HTML
            // $("#pdf-loader").hide();
            $("#pdf-contents").show();
            $("#pageNumber").attr("max", __TOTAL_PAGES);
            $("#numPages").text(
                "sur " +
                    __TOTAL_PAGES +
                    " " +
                    (__TOTAL_PAGES > 1 ? "pages" : "page")
            );

            if ($(".confidentiel-doc").length <= 0) {
                // $('#pdf-contents').empty();
                for (var i = 1; i <= __TOTAL_PAGES; i++) {
                    var pdfPage = document.createElement("div");
                    pdfPage.classList.add("pdf-page");
                    pdfPage.setAttribute("id", "page-" + i);

                    var canvas = document.createElement("canvas");
                    // canvas.setAttribute('width', '595px');
                    canvas.setAttribute("data-page", i);
                    canvas.classList.add("pdf-canvas");
                    canvas.classList.add("mb-2");

                    $(pdfPage).append(canvas);

                    var textLayer = document.createElement("div");
                    textLayer.classList.add("text-layer");
                    $(pdfPage).append(textLayer);

                    var annotationLayer = document.createElement("div");
                    annotationLayer.classList.add("annotationLayer");
                    $(pdfPage).append(annotationLayer);

                    // Suppression du loader de page

                    $("#pdf-contents").append(pdfPage);

                    var vignettePage = document.createElement("div");
                    vignettePage.classList.add("vignette-page");

                    var vignetteLink = document.createElement("a");
                    vignetteLink.setAttribute("href", "#page-" + i);

                    var vignetteCanvas = document.createElement("canvas");
                    vignetteCanvas.setAttribute("width", "140px");
                    vignetteCanvas.classList.add("mb-2");

                    $(vignetteLink).append(vignetteCanvas);
                    $(vignettePage).append(vignetteLink);

                    $("#vignet-container").append(vignettePage);

                    $("#page-" + i).droppable();

                    $("#page-" + i).on("drop", function (event, ui) {
                        $(ui.draggable).attr(
                            "data-page",
                            $(this).find("canvas").data("page")
                        );

                        var droppableOffset = $(this).offset();
                        var draggablePosition = ui.draggable.position();

                        // Calculate the position of the draggable relative to the droppable
                        var relativeLeft =
                            draggablePosition.left - droppableOffset.left;
                        var relativeTop =
                            draggablePosition.top - droppableOffset.top;

                        $(ui.draggable).attr("data-x", relativeLeft);
                        $(ui.draggable).attr("data-y", relativeTop);

                        $(".save_pdf").removeClass("disabled");
                        $(".save_pdf").removeAttr("disabled");
                    });

                    // Show the first page
                    showPage(canvas, vignetteCanvas, textLayer, i);
                }
            } else {
                showPage(null, null, null, 1);
            }
        })
        .catch(function (error) {
            console.error('Erreur lors du chargement du PDF:', error);
            
            // Message d'erreur plus détaillé
            let errorMessage = 'Ce fichier n\'est pas un pdf  ';
            
            if (error.name === 'MissingPDFException') {
                errorMessage += 'Le fichier PDF est introuvable à l\'emplacement spécifié. ';
                errorMessage += 'Veuillez vérifier que le fichier existe bien à l\'URL : ' + pdf_url;
            } else if (error.name === 'InvalidPDFException') {
                errorMessage += 'Le fichier PDF est corrompu ou n\'est pas un PDF valide.';
            } else if (error.message && error.message.includes('NetworkError')) {
                errorMessage += 'Erreur réseau lors du chargement du document. ';
                errorMessage += 'Veuillez vérifier votre connexion internet ou contacter l\'administrateur.';
            } else {
                errorMessage += 'Erreur : ' + (error.message || 'Erreur inconnue');
            }
            
            // Fonction pour obtenir l'icône et le type de fichier à partir de l'URL
            function getFileInfo(url) {
                if (!url) return { icon: 'file.png', type: 'fichier', extension: '' };
                
                const extension = url.split('.').pop().toLowerCase();
                const fileTypes = {
                    // Images
                    'jpg': { icon: 'Fichier-image.png', type: 'Image', extension: 'JPG' },
                    'jpeg': { icon: 'Fichier-image.png', type: 'Image', extension: 'JPEG' },
                    'png': { icon: 'Fichier-image.png', type: 'Image', extension: 'PNG' },
                    'gif': { icon: 'Fichier-image.png', type: 'Image', extension: 'GIF' },
                    'bmp': { icon: 'Fichier-image.png', type: 'Image', extension: 'BMP' },
                    'svg': { icon: 'Fichier-image.png', type: 'Image', extension: 'SVG' },
                    // Documents
                    'pdf': { icon: 'Fichier-pdf.png', type: 'Document', extension: 'PDF' },
                    'doc': { icon: 'Fichier-word.png', type: 'Document', extension: 'DOC' },
                    'docx': { icon: 'Fichier-word.png', type: 'Document', extension: 'DOCX' },
                    'xls': { icon: 'Fichier-excel.png', type: 'Feuille de calcul', extension: 'XLS' },
                    'xlsx': { icon: 'Fichier-excel.png', type: 'Feuille de calcul', extension: 'XLSX' },
                    'ppt': { icon: 'Fichier-pptx.png', type: 'Présentation', extension: 'PPT' },
                    'pptx': { icon: 'Fichier-pptx.png', type: 'Présentation', extension: 'PPTX' },
                    // Archives
                    'zip': { icon: 'Fichier-zip.png', type: 'Archive', extension: 'ZIP' },
                    'rar': { icon: 'Fichier-zip.png', type: 'Archive', extension: 'RAR' },
                    '7z': { icon: 'Fichier-zip.png', type: 'Archive', extension: '7Z' }
                };
                
                if (fileTypes[extension]) {
                    return fileTypes[extension];
                } else {
                    return { 
                        icon: 'file.png', 
                        type: 'Fichier', 
                        extension: extension.toUpperCase() 
                    };
                }
            }
            
            // Obtenir les informations sur le fichier
            const fileInfo = getFileInfo(pdf_url);
            const fileName = pdf_url.split('/').pop() || 'document';
            
            // Afficher l'interface de téléversement de fichier en cas d'erreur
            const errorHtml = `
                <div class="d-flex flex-column align-items-center justify-content-center p-5" style="height: 100%; min-height: 400px;">
                    <div class="block-file block-import-doc text-center" style="max-width: 500px; width: 100%; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 2rem;">
                        <!-- Logo MaxiDoc en haut -->
                        <div class="mb-4">
                            <img src="/assets/images/icons/maxidoc.png" alt="MaxiDoc" style="height: 45px; width: auto; margin-bottom: 1.5rem;">
                        </div>
                        
                        <div class="content-wrapper" style="padding: 0 1.5rem;">
                            <!-- 1. Message d'erreur principal -->
                            <p class="mb-4" style="font-size: 1.1rem; color: #333; line-height: 1.6;">
                                Le fichier fourni n’est pas un document PDF. Veuillez cliquer sur le bouton de téléchargement pour le visualiser. 
                            </p>
                            
                            <!-- 2. Format du fichier -->
                            <div class="file-format mb-4" style="background: #f8f9fa; padding: 12px 15px; border-radius: 6px; border-left: 3px solid #4361ee;">
                                <span style="color: #6c757d; font-size: 0.95rem;">Format du fichier : </span>
                                <strong style="color: #2b2d42; font-size: 1rem;">${fileInfo.extension}</strong>
                            </div>
                            
                            <!-- 3. Icône du type de fichier -->
                            <div class="file-icon-container" style="margin: 2rem auto; width: 120px; height: 140px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px; padding: 1.5rem;">
                                <img src="/assets/img/icons/${fileInfo.icon}" alt="${fileInfo.type}" style="width: 64px; height: 64px; margin-bottom: 12px;">
                                <div class="file-extension" style="font-size: 0.9rem; color: #6c757d; background: #e9ecef; padding: 3px 10px; border-radius: 12px; margin-top: 8px;">
                                    .${fileInfo.extension.toLowerCase()}
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>`;
                
            $("#pdf-contents").html(errorHtml);
        });
}

function showPage(canvas, vignetteCanvas, textLayer, page_no) {
    __PAGE_RENDERING_IN_PROGRESS = 1;
    __CURRENT_PAGE = page_no;

    // Disable Prev & Next buttons while page is being loaded
    $("#pdf-next, #pdf-prev").attr("disabled", "disabled");

    // While page is being rendered hide the canvas and show a loading message
    $("#pdf-canvas").hide();
    $(".page-loader.page-" + page_no).show();

    // Update current page in HTML
    $("#pdf-current-page").text(page_no);

    // Fetch the page
    __PDF_DOC.getPage(page_no).then(function (page) {
        // Support HiDPI-screens.
        var outputScale = window.devicePixelRatio || 1;

        var scale = outputScale > 1 ? 1.5 : 1.2;

        var viewport = page.getViewport(scale);

        if ($(".confidentiel-doc").length <= 0) {
            var context = canvas.getContext("2d");

            canvas.width = Math.floor(viewport.width * outputScale);
            canvas.height = Math.floor(viewport.height * outputScale);
            canvas.style.width =
                Math.floor(viewport.width * outputScale) + "px";
            // canvas.style.height = Math.floor(viewport.height * outputScale) + "px";

            // $(canvas).parent().parent().css({
            //     minWidth: Math.floor(viewport.width) + "px"
            // })
            $(canvas)
                .parent()
                .css({
                    width: Math.floor(viewport.width) + "px",
                });
            $(canvas).parent().addClass("mx-auto");

            $(".block-action-doc").css({
                margin: "0px",
                marginBottom: "20px",
                width: Math.floor(viewport.width) + "px",
            });
            $(".block-action-doc").addClass("mx-auto");

            var transform =
                outputScale !== 1
                    ? [outputScale, 0, 0, outputScale, 0, 0]
                    : null;

            var renderContext = {
                canvasContext: context,
                transform: transform,
                viewport: viewport,
            };

            // Render the page contents in the canvas
            page.render(renderContext)
                .then(function () {
                    __PAGE_RENDERING_IN_PROGRESS = 0;

                    // Re-enable Prev & Next buttons
                    // $("#pdf-next, #pdf-prev").removeAttr('disabled');

                    // Show the canvas and hide the page loader
                    // $("#pdf-canvas").show();
                    $(".page-loader.page-" + page_no).hide();

                    // setupAnnotations(page, viewport, canvas, $(canvas).parent().find('.annotationLayer'))

                    // Return the text contents of the page after the pdf has been rendered in the canvas
                    return page.getTextContent();
                })
                .then(function (textContent) {
                    // Get canvas offset
                    var canvas_offset = $(canvas).offset();

                    // Clear HTML for text layer
                    $(textLayer).html("");

                    // Assign the CSS created to the text-layer element
                    $(textLayer).css({
                        left: "0px",
                        top: "0px",
                        height: "100%", //canvas.height + 'px',
                        width: Math.floor(viewport.width) + "px", //canvas.width + 'px'
                    });

                    // Pass the data to the method for rendering of text over the pdf canvas.
                    PDFJS.renderTextLayer({
                        textContent: textContent,
                        container: $(textLayer).get(0),
                        viewport: viewport,
                        textDivs: [],
                    });
                });
        } else {
            // canvas.style.width = Math.floor(viewport.width) + "px";
            // canvas.style.height = Math.floor(viewport.height) + "px";
            $(".confidentiel-doc").css({
                width: Math.floor(viewport.width) + "px",
                height: Math.floor(viewport.height) + "px",
                marginBottom: "20px",
            });
        }
    });
}

function showFirstPageImg(url = [], parentContainer) {
    for (let index = 0; index < url.length; index++) {
        const pdf_url = url[index].link;
        const id = url[index].id;
        const tache_id = url[index].tache_id;

        PDFJS.getDocument({
            url: pdf_url,
        })
            .then(function (pdf_doc) {
                var imgPage = document.createElement("img");
                imgPage.classList.add("img-fluid");

                var span = document.createElement("span");
                span.classList.add("d-block");

                var content = document.createElement("div");
                content.classList.add("text-center");

                var a = document.createElement("a");
                a.setAttribute("href", "javascript:void(0)");
                a.classList.add("d-block");
                a.classList.add("vignette-page");
                if (index == 0) {
                    span.innerText = "(Original)";
                }
                a.setAttribute(
                    "onclick",
                    'changDoc("' +
                        pdf_url +
                        '", this, ' +
                        id +
                        ", " +
                        tache_id +
                        ", " +
                        (index == 0 ? 1 : 0) +
                        ")"
                );

                var canvas = document.createElement("canvas");

                // Show the first page
                pdf_doc.getPage(1).then(function (page) {
                    // Support HiDPI-screens.
                    var outputScale = window.devicePixelRatio || 1;

                    var scale = outputScale > 1 ? 1.5 : 1.2;

                    var viewport = page.getViewport(scale);

                    var context = canvas.getContext("2d");

                    canvas.width = Math.floor(viewport.width * outputScale);
                    canvas.height = Math.floor(viewport.height * outputScale);
                    canvas.style.width =
                        Math.floor(viewport.width * outputScale) + "px";

                    var transform =
                        outputScale !== 1
                            ? [outputScale, 0, 0, outputScale, 0, 0]
                            : null;

                    var renderContext = {
                        canvasContext: context,
                        transform: transform,
                        viewport: viewport,
                    };

                    // Render the page contents in the canvas
                    page.render(renderContext).then(function () {
                        // Return the text contents of the page after the pdf has been rendered in the canvas
                        // return page.getTextContent();
                        var imgData = canvas.toDataURL("image/png");
                        imgPage.setAttribute("src", imgData);
                        imgPage.style.width = "120px";
                        imgPage.classList.add("border");

                        a.append(imgPage);
                        if (index > 0) {
                            span.innerText = "Pièce jointe " + index;
                        }
                        if (index == url.length - 1) {
                            a.classList.add("active");
                        }
                        content.append(a);
                        content.append(span);
                        parentContainer.append(content);
                    });
                });
                // }
            })
            .catch(function (error) {
                console.log(error);
                // If error re-show the upload button
                // $("#pdf-loader").hide();
                // $("#upload-button").show();

                // alert(error.message);
            });
    }
}

if ($(".doc-vignette") !== undefined) {
    showFirstPageImg($(".doc-vignette").data("url"), $(".doc-vignette"));
}

function changDoc(
    url,
    element,
    docId,
    tache_id = null,
    is_original = false,
    courrier_id = null
) {
    $("#pdf-contents").empty();
    $(".pdf-tools #download").attr("href", url);
    $(".pdf-tools #download").attr("download", url);
    showPDF(url);

    $(".vignette-page").removeClass("active");
    if (element) {
        $(element).addClass("active");
    }
    $(".signature_btn").attr(
        "href",
        "/system/documents/sign/task?doc_id=" +
            docId +
            "&is_original=" +
            is_original
    );
    if (tache_id) {
        $(".signature_btn").attr(
            "href",
            $(".signature_btn").attr("href") + "&tache_id=" + tache_id
        );
    }
    if (courrier_id) {
        $(".signature_btn").attr(
            "href",
            $(".signature_btn").attr("href") + "&courrier_id=" + courrier_id
        );
    }
}

$(".validate-code").on("click", function () {
    if ($(".code-confident").val() == code) {
        $("#pdf-contents").empty();
        showPDF(url);
        $(".code-error-label").addClass("d-none");
    } else {
        $(".code-error-label").removeClass("d-none");
    }
});

if (window.Livewire !== undefined) {
    Livewire.on("documentAdded", (e) => {
        $(".doc-vignette").empty();
        showFirstPageImg(e, $(".doc-vignette"));
    });
}

function gotToPage(numPage) {
    // S'assurer que le numéro de page est un entier
    numPage = parseInt(numPage);
    
    // Mettre à jour l'affichage du numéro de page (commence à 1)
    $("#pageNumber").val(numPage);
    
    // Faire défiler vers le haut de la page
    $('html, body').animate({
        scrollTop: 0
    }, 100, function() {
        // Une fois le défilement terminé, faire défiler vers l'élément
        const pageElement = document.getElementById("page-" + numPage);
        if (pageElement) {
            pageElement.scrollIntoView({
                behavior: "smooth",
                block: "start", // Fait défiler vers le haut de l'élément
                inline: "nearest"
            });
        }
    });
}

$("#pageNumber").on("change", function () {
    gotToPage($(this).val());
});

// previous btn
$("#previous").on("click", function () {
    let currentPage = parseInt($("#pageNumber").val());
    if (currentPage > 1) {
        gotToPage(currentPage - 1);
    }
});

// next btn
$("#next").on("click", function () {
    let currentPage = parseInt($("#pageNumber").val());
    if (currentPage < __TOTAL_PAGES) {
        gotToPage(currentPage + 1);
    }
});

// Mise à jour du numéro de page lors du défilement
let scrollTimeout;
$(window).on("scroll", function () {
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(function() {
        let currentScroll = $(window).scrollTop();
        let closestPage = 1;
        let minDistance = Number.MAX_SAFE_INTEGER;
        
        $("#pdf-contents > div").each((index, element) => {
            const elementTop = $(element).offset().top;
            const distance = Math.abs(elementTop - currentScroll - 100); // 100px de marge pour le header
            
            if (distance < minDistance) {
                minDistance = distance;
                closestPage = index + 1; // +1 car les pages commencent à 1
            }
        });
        
        // Mettre à jour uniquement si différent de la valeur actuelle
        if (parseInt($("#pageNumber").val()) !== closestPage) {
            $("#pageNumber").val(closestPage);
        }
    }, 100); // Délai pour éviter les calculs trop fréquents
});

$("#print").on("click", function () {
    // Vérifier si l'élément #pdf-contents existe
    const pdfContents = document.getElementById('pdf-contents');
    if (!pdfContents) {
        console.error("Élément #pdf-contents introuvable");
        alert("Impossible de trouver le contenu à imprimer");
        return;
    }

    // Vérifier s'il y a des canvas à imprimer
    const allCanvas = pdfContents.querySelectorAll('canvas');
    if (allCanvas.length === 0) {
        console.error("Aucun canvas trouvé pour l'impression");
        alert("Aucun document à imprimer");
        return;
    }

    // Afficher un indicateur de chargement
    const originalButtonText = $(this).html();
    $(this).html('<i class="fas fa-spinner fa-spin"></i> Préparation de l\'impression...').prop('disabled', true);

    // Appeler la fonction d'impression avec un léger délai pour permettre à l'UI de se mettre à jour
    setTimeout(() => {
        try {
            imprimerTousLesCanvas();
        } catch (error) {
            console.error("Erreur lors de l'impression :", error);
            alert("Une erreur est survenue lors de l'impression : " + error.message);
        } finally {
            // Réactiver le bouton dans tous les cas
            $(this).html(originalButtonText).prop('disabled', false);
        }
    }, 100);
});

// Fonction pour imprimer tous les canvas
function imprimerTousLesCanvas() {
    try {
        const allCanvas = document.querySelectorAll('#pdf-contents canvas');
        if (!allCanvas || allCanvas.length === 0) {
            throw new Error("Aucun canvas trouvé pour l'impression");
        }

        const printWindow = window.open('', '_blank');
        if (!printWindow) {
            throw new Error("Impossible d'ouvrir une nouvelle fenêtre. Veuillez désactiver votre bloqueur de fenêtres popup.");
        }

        // Créer le contenu HTML de base avec des styles d'impression
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Impression de document</title>
                    <style>
                        @page {
                            size: A4;
                            margin: 0.5cm;
                        }
                        body {
                            margin: 0;
                            padding: 0;
                            font-family: Arial, sans-serif;
                        }
                        .page-container {
                            page-break-after: always;
                            margin-bottom: 20px;
                        }
                        .page-container:last-child {
                            page-break-after: auto;
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                            display: block;
                            margin: 0 auto;
                        }
                        @media print {
                            .no-print {
                                display: none !important;
                            }
                            body {
                                padding: 0;
                                margin: 0;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="no-print" style="text-align: center; padding: 20px; background: #f5f5f5; margin-bottom: 20px;">
                        <h2>Aperçu avant impression</h2>
                        <p>Utilisez la fonction d'impression de votre navigateur (Ctrl+P ou Cmd+P)</p>
                        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; margin: 10px;">
                            Imprimer
                        </button>
                        <button onclick="window.close()" style="padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin: 10px;">
                            Fermer
                        </button>
                    </div>
        `);

        // Ajouter chaque canvas comme une image
        allCanvas.forEach((canvas, index) => {
            try {
                const imgData = canvas.toDataURL('image/png');
                printWindow.document.write(`
                    <div class="page-container">
                        <img src="${imgData}" alt="Page ${index + 1}" style="max-width: 100%; height: auto;">
                    </div>
                `);
            } catch (error) {
                console.error(`Erreur lors de la conversion du canvas ${index + 1}:`, error);
            }
        });

        // Fermer les balises HTML
        printWindow.document.write('</body></html>');
        
        // Fermer le document
        printWindow.document.close();

        // Attendre que le contenu soit chargé avant d'imprimer
        printWindow.onload = function() {
            // Donner le focus à la fenêtre d'impression
            printWindow.focus();
            
            // Ne pas lancer l'impression automatiquement pour permettre l'aperçu
            // L'utilisateur peut utiliser le bouton d'impression dans la fenêtre
            // printWindow.print();
        };

    } catch (error) {
        console.error("Erreur lors de l'impression :", error);
        alert("Erreur lors de l'impression : " + error.message);
        
        // Fermer la fenêtre d'impression si elle a été ouverte
        if (printWindow) {
            printWindow.close();
        }
        
        throw error; // Propager l'erreur pour une gestion ultérieure
    }
}
