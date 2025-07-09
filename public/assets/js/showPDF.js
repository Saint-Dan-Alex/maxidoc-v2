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
    // $("#pdf-loader").show();

    $(".pdf-tools #download").attr("href", pdf_url);
    $(".pdf-tools #download").attr("download", pdf_url);

    PDFJS.getDocument({
        url: pdf_url,
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

                    var loader = document.createElement("div");
                    loader.classList.add("page-loader");
                    loader.classList.add("page-" + i);

                    var loaderIcon = document.createElement("img");
                    loaderIcon.src = "/assets/images/loader.svg";
                    $(loader).append(loaderIcon);

                    $(pdfPage).append(loader);

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
            // If error re-show the upload button
            // $("#pdf-loader").hide();
            // $("#upload-button").show();

            alert(error.message);
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
    // scroll to element
    // console.log(numPage);
    // $('html,body').animate({
    //     scrollTop: $('#page-' + numPage).offset().top - 170
    // }, 400);

    document.getElementById("page-" + numPage).scrollIntoView({
        behavior: "smooth",
        block: "center",
    });
    // var offsetTop = document.getElementById('page-' + numPage).offset().top -
}

$("#pageNumber").on("change", function () {
    gotToPage($(this).val());
});

// previous btn
$("#previous").on("click", function () {
    if ($("#pageNumber").val() > 1) {
        gotToPage($("#pageNumber").val() - 1);
        $("#pageNumber").val($("#pageNumber").val() - 1);
    }
});

// next btn
$("#next").on("click", function () {
    let currentPage = parseInt($("#pageNumber").val());
    if (currentPage < __TOTAL_PAGES) {
        gotToPage(currentPage + 1);
        $("#pageNumber").val(currentPage + 1);
    }
});

$(document).on("scroll", function () {
    $("#pdf-contents > div").each((index, element) => {
        if ($(document).scrollTop() >= element.offsetTop - 170) {
            $("#pageNumber").val(index);
        }
    });
});

$("#print").on("click", function () {

        // var divContents = document.getElementById("pdf-contents").innerHTML; 
        imprimerTousLesCanvas()



    // Remplacez 'your_pdf_file.pdf' par le lien de votre fichier PDF
    // var pdfUrl = 'your_pdf_file.pdf';

    // var content = document.getElementById('pdf-contents');
    // let printWindow = window.open("", "", "width=800,height=600");
    // printWindow.document.write(
    //     "<html><head>"+document.querySelector('head').innerHTML+"</head><body>"
    // );

    // printWindow.document.write(content.innerHTML);

    // printWindow.document.write("</body></html>");
    // printWindow.document.close();

    // // Attendre que l'image soit chargée avant d'initier l'impression
    //   printWindow.onload = function () {
    //     printWindow.print();
    //   };

    // Charger le PDF
    // PDFJS.getDocument(url).promise.then(function (pdf) {
    //     // Créer une fenêtre d'impression
    //     let printWindow = window.open("", "", "width=800,height=600");
    //     //   printWindow.document.open();
    //     printWindow.document.write(
    //         "<html><head><title>Impression PDF</title></head><body>"
    //     );
    //     let parent = document.createElement("div");

    //     //   var printWindow = window.open('', '_blank');
    //     //   printWindow.document.write('<html><head><title>Impression PDF</title></head><body>');

    //     // Imprimer chaque page du PDF
    //     for (var pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
    //         var pdfPage = document.createElement("div");
    //         pdfPage.classList.add("pdf-page");
    //         pdfPage.setAttribute("id", "page-" + pageNum);

    //         var canvas = document.createElement("canvas");
    //         // canvas.setAttribute('width', '595px');
    //         canvas.setAttribute("data-page", pageNum);
    //         canvas.classList.add("pdf-canvas");
    //         canvas.classList.add("mb-2");

    //         $(pdfPage).append(canvas);

    //         var textLayer = document.createElement("div");
    //         textLayer.classList.add("text-layer");
    //         $(pdfPage).append(textLayer);

    //         var annotationLayer = document.createElement("div");
    //         annotationLayer.classList.add("annotationLayer");
    //         $(pdfPage).append(annotationLayer);

    //         var loader = document.createElement("div");
    //         loader.classList.add("page-loader");
    //         loader.classList.add("page-" + pageNum);

    //         var loaderIcon = document.createElement("img");
    //         loaderIcon.src = "/assets/images/loader.svg";
    //         $(loader).append(loaderIcon);

    //         $(pdfPage).append(loader);

    //         $(parent).append(pdfPage);

    //         test(canvas, parent, textLayer, pageNum, pdf, printWindow);

    //         // pdf.getPage(pageNum).then(function (page) {
    //         //   var canvas = document.createElement("canvas");
    //         //   var context = canvas.getContext("2d");

    //         //   // Définir la taille du canevas pour correspondre à la taille de la page
    //         //   var viewport = page.getViewport({ scale: 1.5 });
    //         //   canvas.width = viewport.width;
    //         //   canvas.height = viewport.height;

    //         //   // Dessiner la page sur le canevas
    //         //   page.render({ canvasContext: context, viewport: viewport }).promise.then(function () {
    //         //     // Créer une image de la page
    //         //     var imgData = canvas.toDataURL("image/png");

    //         //     // Ajouter l'image à la fenêtre d'impression
    //         //     // printWindow.document.write('<img src="' + imgData + '">');

    //         //     parent.append(canvas)
    //         //     printWindow.document.write(parent.innerHTML);

    //         //     // Si c'est la dernière page, fermer la fenêtre et lancer l'impression
    //         //     if (pageNum === pdf.numPages) {
    //         //       printWindow.document.write('</body></html>');
    //         //       printWindow.document.close();

    //         //       // Attendre que l'image soit chargée avant d'initier l'impression
    //         //     //   printWindow.onload = function () {
    //         //     //     printWindow.print();
    //         //     //   };
    //         //     }
    //         //   });
    //         // });
    //     }
    // });
});

// Fonction pour imprimer tous les canvas
function imprimerTousLesCanvas() {
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Imprimés</title></head><body>');
    var allCanvas = document.querySelectorAll('#pdf-contents canvas');

    // Ajoutez chaque canvas à la fenêtre d'impression
    for (let index = 0; index < allCanvas.length; index++) {
        const can = allCanvas[index];
        imprimerCanvas(printWindow, can, allCanvas.length);
    }
    // Ajoutez autant de canvas que nécessaire

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
}

// Fonction pour imprimer un canvas spécifique
function imprimerCanvas(printWindow, can, count) {
    printWindow.document.write('<img src="' + can.toDataURL() + '" style="width:'+can.width+'px;height:'+(can.height - (25 * count))+'px">');
}
