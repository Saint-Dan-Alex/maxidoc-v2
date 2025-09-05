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

// Fonctions pour gérer le loader
function showLoader() {
    const loader = document.getElementById('document-loader');
    const pdfContents = document.getElementById('pdf-contents');
    
    if (loader && pdfContents) {
        // S'assurer que le conteneur du PDF a une position relative
        if (window.getComputedStyle(pdfContents).position === 'static') {
            pdfContents.style.position = 'relative';
        }
        
        // Positionner le loader dans le conteneur PDF
        loader.style.display = 'flex';
        loader.style.position = 'absolute';
        loader.style.top = '0';
        loader.style.left = '0';
        
        // Ajouter une légère animation d'apparition
        setTimeout(() => {
            loader.style.opacity = '1';
        }, 10);
    }
}

function hideLoader() {
    const loader = document.getElementById('document-loader');
    if (loader) {
        // Ajouter une animation de disparition
        loader.style.opacity = '0';
        
        // Masquer après l'animation
        setTimeout(() => {
            loader.style.display = 'none';
        }, 300); // Correspond à la durée de la transition CSS
    }
}

// Show the pdf document.
showPDF(url);

// Handle window resize for responsive PDF display
let resizeTimeout;
$(window).on('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        if (typeof __CURRENT_PAGE !== 'undefined' && __CURRENT_PAGE > 0) {
            // Get all canvas elements and re-render the current page
            $('.pdf-page').each(function() {
                const pageNumber = parseInt($(this).attr('id').split('-')[1]);
                if (pageNumber === __CURRENT_PAGE) {
                    const canvas = $(this).find('canvas')[0];
                    const textLayer = $(this).find('.text-layer')[0];
                    showPage(canvas, null, textLayer, pageNumber);
                }
            });
        }
    }, 250); // Debounce resize events for better performance
});

function showPDF(pdf_url) {
    const file_extension = typeof pdf_url === 'string' ? pdf_url.split('.').pop().toLowerCase() : '';
    const isImage = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'svg'].includes(file_extension);

    if (isImage) {
        const pdfContents = $("#pdf-contents");
        pdfContents.empty();
        const imgHtml = `
            <div class="d-flex flex-column align-items-center justify-content-center p-4" style="min-height: 500px;">
                
                <div class="img-container" style="max-width: 100%; max-height: 70vh; overflow: auto; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; background-color: #f8f9fa;">
                    <img src="${pdf_url}" class="img-fluid" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" alt="Aperçu de l'image">
                </div>
                <div class="mt-3">
                    <a href="${pdf_url}" class="btn btn-primary btn-sm" download>
                        <i class="fi fi-rr-download me-1"></i> Télécharger
                    </a>
                </div>
            </div>
        `;
        pdfContents.html(imgHtml);
        hideLoader(); // Assurez-vous que le loader est masqué
        return; // Arrêter l'exécution pour les images
    }

    console.log('Début du chargement du PDF, URL brute :', pdf_url);
    
    const pdfContents = $("#pdf-contents");
    
    // Initialiser le conteneur PDF
    if (pdfContents.length) {
        // Vider le contenu précédent
        pdfContents.empty();
        
        // Créer un conteneur pour le loader s'il n'existe pas
        if ($('#document-loader').length === 0) {
            const loaderHtml = `
                <div id="document-loader" class="loader-overlay">
                    <div class="loader-content">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                        <div class="loader-text">Chargement du document en cours...</div>
                    </div>
                </div>
            `;
            pdfContents.append(loaderHtml);
        }
        
        // Afficher le loader
        showLoader();
    } else {
        console.error('Conteneur PDF non trouvé');
        return;
    }
    
    // Vérifier si l'URL est valide
    if (!pdf_url) {
        const errorMsg = 'Aucune URL de document fournie';
        console.error(errorMsg);
        pdfContents.html('<div class="alert alert-danger m-3"><h5>Erreur de chargement</h5><p>' + errorMsg + '</p></div>');
        hideLoader();
        return;
    }
    
    // Nettoyer l'URL
    if (typeof pdf_url === 'string') {
        // Supprimer les échappements et guillemets
        pdf_url = pdf_url.replace(/\\/g, '/').replace(/^["\[\]{}]|["\[\]{},]$/g, '');
        
        // Corriger les doubles 'documents' dans l'URL
        pdf_url = pdf_url.replace(/(\/storage\/documents\/?)documents\//, '$1');
        
        // S'assurer que l'URL commence par /storage/
        if (!pdf_url.startsWith('http') && !pdf_url.startsWith('/storage/')) {
            if (pdf_url.startsWith('documents/')) {
                pdf_url = '/storage/' + pdf_url;
            } else if (pdf_url.startsWith('/documents/')) {
                pdf_url = '/storage' + pdf_url.substring(1);
            } else {
                pdf_url = '/storage/documents/' + pdf_url;
            }
        }
        
        // Ajouter le protocole et le domaine si nécessaire (pour les URL relatives)
        if (!pdf_url.startsWith('http') && !pdf_url.startsWith(window.location.origin)) {
            // Si c'est un chemin absolu, ajouter le domaine
            if (pdf_url.startsWith('/')) {
                pdf_url = window.location.origin + pdf_url;
            } else {
                // Sinon, construire l'URL complète à partir de la base
                const baseUrl = window.location.origin + '/storage/documents/';
                pdf_url = baseUrl + pdf_url;
            }
        }
    }
    
    console.log('URL du PDF après nettoyage :', pdf_url);
    
    // Mettre à jour les attributs de téléchargement
    $(".pdf-tools #download").attr("href", pdf_url);
    $(".pdf-tools #download").attr("download", pdf_url);

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
                
                // Cacher le loader une fois le chargement terminé
                hideLoader();
            } else {
                showPage(null, null, null, 1);
            }
        })
        .catch(function (error) {
            console.error('Erreur lors du chargement du PDF:', error);
            
            // Message d'erreur plus détaillé
            let errorMessage = 'Ce fichier n\'est pas un pdf  ';
            
            // Cacher le loader en cas d'erreur
            hideLoader();
            
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
        // Get the container width and calculate the scale factor
        var container = $(canvas).closest('#pdf-contents');
        var containerWidth = container.width() - 40; // 20px padding on each side
        
        // Get the viewport at 100% scale to calculate the proper scale factor
        var viewport = page.getViewport(1.0);
        var scale = containerWidth / viewport.width;
        
        // Apply the scale to get a properly sized viewport
        viewport = page.getViewport(scale);
        
        // Support HiDPI-screens
        var outputScale = window.devicePixelRatio || 1;

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
        const file_url = url[index].link;
        const id = url[index].id;
        const tache_id = url[index].tache_id;
        const file_extension = file_url.split('.').pop().toLowerCase();
        const isImage = ['png', 'jpg', 'jpeg'].includes(file_extension);
        const isPdf = file_extension === 'pdf';

        // Create common elements
        var content = document.createElement("div");
        content.classList.add("text-center", "mb-3");
        content.style.width = "150px";
        content.style.display = "inline-block";
        content.style.margin = "0 10px 15px 0";
        content.style.verticalAlign = "top";

        var a = document.createElement("a");
        a.setAttribute("href", "javascript:void(0)");
        a.classList.add("d-block", "vignette-page", "text-decoration-none");
        a.style.border = "1px solid #dee2e6";
        a.style.borderRadius = "4px";
        a.style.overflow = "hidden";
        a.style.backgroundColor = "#f8f9fa";
        a.style.height = "150px";
        a.style.display = "flex";
        a.style.alignItems = "center";
        a.style.justifyContent = "center";
        
        // Set click handler
        a.setAttribute(
            "onclick",
            'changDoc("' + file_url + '", this, ' + id + ", " + tache_id + ", " + (index == 0 ? 1 : 0) + "); return false;"
        );

        var span = document.createElement("span");
        span.classList.add("d-block", "small", "mt-2");
        span.innerText = index > 0 ? "Pièce jointe " + index : "Document original";

        if (isImage) {
            // Handle image files (PNG, JPG, JPEG)
            var img = document.createElement("img");
            img.src = file_url;
            img.style.maxWidth = "100%";
            img.style.maxHeight = "100%";
            img.style.objectFit = "contain";
            img.alt = "Aperçu de l'image";
            a.appendChild(img);
            
            // Add image-specific styling
            a.style.padding = "10px";
            
            content.appendChild(a);
            content.appendChild(span);
            parentContainer.append(content);
        } else if (isPdf) {
            // Handle PDF files
            var pdfContainer = document.createElement("div");
            pdfContainer.style.position = "relative";
            pdfContainer.style.width = "100%";
            pdfContainer.style.height = "100%";
            
            var pdfIcon = document.createElement("i");
            pdfIcon.className = "fi fi-rr-file-pdf";
            pdfIcon.style.fontSize = "3rem";
            pdfIcon.style.color = "#dc3545";
            pdfIcon.style.marginBottom = "10px";
            
            var pdfText = document.createElement("div");
            pdfText.innerText = "Aperçu PDF";
            pdfText.style.fontSize = "0.8rem";
            pdfText.style.color = "#6c757d";
            
            pdfContainer.appendChild(pdfIcon);
            pdfContainer.appendChild(pdfText);
            a.appendChild(pdfContainer);
            
            // Add PDF-specific styling
            a.style.padding = "20px 10px";
            a.style.textAlign = "center";
            
            content.appendChild(a);
            content.appendChild(span);
            parentContainer.append(content);
            
            // Load PDF preview in the background
            PDFJS.getDocument({ url: file_url })
                .then(function(pdf_doc) {
                    return pdf_doc.getPage(1);
                })
                .then(function(page) {
                    var viewport = page.getViewport(1.0);
                    var canvas = document.createElement("canvas");
                    var context = canvas.getContext("2d");
                    
                    // Adjust canvas dimensions
                    var containerWidth = 140; // Width of the container minus padding
                    var scale = containerWidth / viewport.width;
                    var scaledViewport = page.getViewport(scale);
                    
                    canvas.width = scaledViewport.width;
                    canvas.height = scaledViewport.height;
                    
                    // Render PDF page to canvas
                    page.render({
                        canvasContext: context,
                        viewport: scaledViewport
                    }).promise.then(function() {
                        // Replace icon with PDF preview
                        pdfContainer.innerHTML = '';
                        pdfContainer.style.padding = '0';
                        canvas.style.maxWidth = '100%';
                        canvas.style.height = 'auto';
                        pdfContainer.appendChild(canvas);
                        
                        // Adjust container height to fit content
                        a.style.height = 'auto';
                        a.style.minHeight = '150px';
                    });
                })
                .catch(function(error) {
                    console.error("Erreur lors du chargement de l'aperçu PDF:", error);
                });
        } else {
            // Handle other file types
            var fileIcon = document.createElement("i");
            fileIcon.className = "fi fi-rr-file";
            fileIcon.style.fontSize = "3rem";
            fileIcon.style.color = "#6c757d";
            fileIcon.style.marginBottom = "10px";
            
            var fileText = document.createElement("div");
            fileText.innerText = file_extension.toUpperCase();
            fileText.style.fontSize = "0.7rem";
            fileText.style.color = "#6c757d";
            
            a.appendChild(fileIcon);
            a.appendChild(fileText);
            a.style.padding = "20px 10px";
            a.style.textAlign = "center";
            
            content.appendChild(a);
            content.appendChild(span);
            parentContainer.append(content);
        }
    }
}

// Initialiser les vignettes au chargement du document
$(document).ready(function() {
    const $docVignette = $(".doc-vignette");
    if ($docVignette.length > 0) {
        const urls = $docVignette.data("url");
        if (urls && urls.length > 0) {
            showFirstPageImg(urls, $docVignette[0]);
        }
    }
});

function changDoc(
    url,
    element,
    docId,
    tache_id = null,
    is_original = false,
    courrier_id = null
) {
    // Vider le conteneur
    $("#pdf-contents").empty();
    
    // Mettre à jour les liens de téléchargement
    $(".pdf-tools #download").attr("href", url);
    $(".pdf-tools #download").attr("download", url);
    
    // Vérifier le type de fichier
    const file_extension = url.split('.').pop().toLowerCase();
    const isImage = ['png', 'jpg', 'jpeg', 'gif', 'bmp', 'svg'].includes(file_extension);
    
    // Si c'est une image, l'afficher directement
    if (isImage) {
        const imgHtml = `
            <div class="d-flex flex-column align-items-center justify-content-center p-4" style="min-height: 500px;">
                <div class="text-center mb-4">
                    <h4>Visualisation de l'image</h4>
                    <p class="text-muted">${url.split('/').pop()}</p>
                </div>
                <div class="img-container" style="max-width: 100%; max-height: 70vh; overflow: auto; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px; background-color: #f8f9fa;">
                    <img src="${url}" class="img-fluid" style="max-width: 100%; height: auto; display: block; margin: 0 auto;" alt="Aperçu de l'image">
                </div>
                <div class="mt-3">
                    <a href="${url}" class="btn btn-primary btn-sm" download>
                        <i class="fi fi-rr-download me-1"></i> Télécharger
                    </a>
                </div>
            </div>
        `;
        $("#pdf-contents").html(imgHtml);
    } else {
        // Pour les PDF, utiliser la fonction showPDF existante
        showPDF(url);
    }

    // Mettre à jour la navigation
    $(".vignette-page").removeClass("active");
    if (element) {
        $(element).addClass("active");
    }
    
    // Mettre à jour le bouton de signature si nécessaire
    if (docId) {
        let signatureUrl = "/system/documents/sign/task?doc_id=" + docId + "&is_original=" + is_original;
        if (tache_id) {
            signatureUrl += "&tache_id=" + tache_id;
        }
        if (courrier_id) {
            signatureUrl += "&courrier_id=" + courrier_id;
        }
        $(".signature_btn").attr("href", signatureUrl);
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
