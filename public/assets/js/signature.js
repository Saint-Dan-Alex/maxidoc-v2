$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  },
});

const canvas = document.getElementById("canvas_signature_pad");
const canvas2 = document.getElementById("canvas_paraphe_pad");
const signaturePad = new SignaturePad(canvas);
const signaturePad2 = new SignaturePad(canvas2);

function initSignaturePad() {
  signaturePad.minWidth = 1.6;
  signaturePad2.minWidth = 1.6;
  signaturePad.maxWidth = 2.5;
  signaturePad2.maxWidth = 2.5;
  signaturePad.penColor = $(".block-pallete-design .bubble-color").data(
    "color"
  );
  signaturePad2.penColor = $(
    ".block-pallete-design-paraphe .bubble-color"
  ).data("color");
  resizeCanvas();
  resizeCanvas2();
}

initSignaturePad();

function resizeCanvas() {
  const ratio = Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);
  signaturePad.clear();
  canvas.width = $("#pills-home").width(); //"586";
  canvas.height = $("#pills-home").width() / 3; //"150";
  $(".block-up-img").css({
    height: $("#pills-profile").width() / 3 + "px",
  });
}
function resizeCanvas2() {
  const ratio = Math.max(window.devicePixelRatio || 1, 1);
  canvas2.width = canvas2.offsetWidth * ratio;
  canvas2.height = canvas2.offsetHeight * ratio;
  canvas2.getContext("2d").scale(ratio, ratio);
  signaturePad2.clear();
  canvas2.width = $("#paraphe-dessin").width(); //"586";
  canvas2.height = $("#paraphe-dessin").width() / 3; //"150";
  // $('.block-up-img').css({
  //     height: ($('#pills-profile').width() / 3) + "px"
  // })
}

window.addEventListener("resize", resizeCanvas);

$(".block-pallete-design .bubble-color").on("click", function () {
  $(".block-pallete-design .bubble-color").removeClass("active");
  $(this).addClass("active");
  signaturePad.penColor = $(this).data("color");
  $(".block-show-pallete-design .bubble").css({
    background: $(this).data("color"),
  });
});

$(".clear-canevas").on("click", function () {
  signaturePad.clear();
});

$(".signature-name-container h1")
  .css({
    fontFamily: "" + $('select[name="police"]').val(),
    fontSize:
      $(".signature-name-container h1")
        .parent()
        .parent()
        .parent()
        .find('select[name="police"]')
        .val() == "Arty Signature"
        ? "180px"
        : "80px",
    color: $(".signature-name-container h1")
      .parent()
      .parent()
      .parent()
      .find('select[name="color2"]')
      .val(),
  })
  .text(
    $(".signature-name-container h1")
      .parent()
      .parent()
      .parent()
      .find('input[name="user-name"]')
      .val()
  );

$(".signature-name-container2 h1")
  .css({
    fontFamily: "" + $('select[name="police"]').val(),
    fontSize:
      $(".signature-name-container2 h1")
        .parent()
        .parent()
        .parent()
        .find('select[name="police"]')
        .val() == "Arty Signature"
        ? "180px"
        : "80px",
    color: $(".signature-name-container2 h1")
      .parent()
      .parent()
      .parent()
      .find('select[name="color2"]')
      .val(),
  })
  .text(
    $(".signature-name-container2 h1")
      .parent()
      .parent()
      .parent()
      .find('input[name="user-name"]')
      .val()
  );

$('select[name="police"]').on("change", function () {
  const container = $(this).closest('.tab-pane');
  const targetH1 = container.find("h1");
  const inputValue = container.find('input[type="text"]').val();
  
  targetH1.css({
    fontFamily: $(this).val(),
    fontSize: $(this).val() == "Arty Signature" ? "180px" : "80px"
  }).text(inputValue);
});

$(".block-pallete-name .bubble-color").on("click", function () {
  $(".block-pallete-name .bubble-color").removeClass("active");
  $(this).addClass("active");
  $(this)
    .parent()
    .parent()
    .parent()
    .parent()
    .parent()
    .parent()
    .parent()
    .parent()
    .find("h1")
    .css({
      color: $(this).data("color"),
    });
  $(".block-show-pallete-name .bubble").css({
    background: $(this).data("color"),
  });
});

$('#user-name-paraphe, #user-name-signature').on("keyup", function () {
  if ($(this).attr('id') === 'user-name-paraphe') {
    $(".signature-name-container2 h1").text($(this).val());
  } else {
    $(".signature-name-container h1").text($(this).val());
  }
});

$(".btn-close").click(function () {
  $(".signature.dropped-true.active").removeClass("active");
  $(".modal-signature").css({
    width: "0px",
  });
});

const input = document.getElementById("file-img");
const img = document.getElementById("sign-img");
const img_block = document.getElementById("img_block");

input.addEventListener("change", () => {
  const file = input.files[0];
  const reader = new FileReader();

  reader.addEventListener("load", () => {
    img.src = reader.result;
    img_block.classList.remove("d-none");
  });

  reader.readAsDataURL(file);
});

// Initialize pdf.js
// const pdfjsLib = window['pdfjs-dist/build/pdf'];

// // Initialize pdf-lib
// const {
//     PDFDocument,
//     rgb
// } = PDFLib;

// // let annotations = [];
// let annotations = [{
//     pageNum: 1, // Page number
//     x: 87,
//     y: 445,
//     width: 100,
//     height: 15,
//     comment: 'test',
// }];
// let __PDF_DOC,
//     __CURRENT_PAGE,
//     __TOTAL_PAGES,
//     __PAGE_RENDERING_IN_PROGRESS = 0;

// let url = $('#pdf-main-container').data('url');
// let docName = $('#pdf-main-container').data('name');
// let courrier_id = $('#pdf-main-container').data('courrier');
// let tache_id = $('#pdf-main-container').data('tache');
let doc_id = $("#pdf-main-container").data("doc");
let is_original = $("#pdf-main-container").data("original");

// showPDF(url);

// function showPDF(pdf_url) {
//     $("#pdf-loader").show();

//     PDFJS.getDocument({
//         url: pdf_url
//     }).then(function(pdf_doc) {
//         __PDF_DOC = pdf_doc;
//         __TOTAL_PAGES = __PDF_DOC.numPages;

//         // Hide the pdf loader and show pdf container in HTML
//         $("#pdf-loader").hide();
//         $("#pdf-contents").show();
//         $("#pdf-total-pages").text(__TOTAL_PAGES);

//         for (var i = 1; i <= __TOTAL_PAGES; i++) {

//             var pdfPage = document.createElement('div');
//             pdfPage.classList.add('pdf-page');
//             pdfPage.setAttribute('id', 'page-' + i);

//             var canvas = document.createElement('canvas');

//             canvas.setAttribute('data-page', i);
//             canvas.classList.add('pdf-canvas');
//             canvas.classList.add('mb-2');
//             $(pdfPage).append(canvas);

//             var textLayer = document.createElement('div');
//             textLayer.classList.add('text-layer');
//             $(pdfPage).append(textLayer);

//             var annotationLayer = document.createElement('div');
//             annotationLayer.classList.add('annotationLayer');
//             $(pdfPage).append(annotationLayer);

//             var loader = document.createElement('div');
//             loader.classList.add('page-loader');
//             loader.classList.add('page-' + i);

//             var loaderIcon = document.createElement('img');
//             loaderIcon.src = "/assets/images/loader.svg";
//             $(loader).append(loaderIcon);

//             $(pdfPage).append(loader);

//             $('#pdf-contents').append(pdfPage);

//             var vignettePage = document.createElement('div');
//             vignettePage.classList.add('vignette-page');

//             var vignetteLink = document.createElement('a');
//             vignetteLink.setAttribute('href', '#page-' + i);

//             var vignetteCanvas = document.createElement('canvas');
//             vignetteCanvas.setAttribute('width', '140px');
//             vignetteCanvas.classList.add('mb-2');

//             $(vignetteLink).append(vignetteCanvas);
//             $(vignettePage).append(vignetteLink);

//             $('#vignet-container').append(vignettePage);

//             $("#page-" + i).droppable();

//             $("#page-" + i).on("drop", function(event, ui) {

//                 $(ui.draggable).attr('data-page', $(this).find('canvas').data('page'));

//                 var droppableOffset = $(this).offset();
//                 var draggablePosition = ui.draggable.position();

//                 // Calculate the position of the draggable relative to the droppable
//                 var relativeLeft = draggablePosition.left - droppableOffset.left;
//                 var relativeTop = draggablePosition.top - droppableOffset.top;

//                 $(ui.draggable).attr('data-x', relativeLeft);
//                 $(ui.draggable).attr('data-y', relativeTop);

//                 $('.save_pdf').removeClass('disabled');
//                 $('.save_pdf').removeAttr('disabled');

//             });

//             // Show the first page
//             showPage(canvas, vignetteCanvas, textLayer, i);
//         }

//     }).catch(function(error) {
//         // If error re-show the upload button
//         $("#pdf-loader").hide();
//         $("#upload-button").show();

//         alert(error.message);
//     });
// }

// function showPage(canvas, vignetteCanvas, textLayer, page_no) {
//     __PAGE_RENDERING_IN_PROGRESS = 1;
//     __CURRENT_PAGE = page_no;

//     // Disable Prev & Next buttons while page is being loaded
//     $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

//     // While page is being rendered hide the canvas and show a loading message
//     $("#pdf-canvas").hide();
//     $(".page-loader.page-" + page_no).show();

//     // Update current page in HTML
//     $("#pdf-current-page").text(page_no);

//     // Fetch the page
//     __PDF_DOC.getPage(page_no).then(function(page) {

//         // Support HiDPI-screens.
//         var outputScale = window.devicePixelRatio || 1;

//         var scale = outputScale > 1 ? 1.5 : 1.2;

//         var viewport = page.getViewport(scale);

//         var context = canvas.getContext('2d');

//         canvas.width = Math.floor(viewport.width * outputScale);
//         canvas.height = Math.floor(viewport.height * outputScale);
//         canvas.style.width = Math.floor(viewport.width) + "px";
//         canvas.style.height = Math.floor(viewport.height) + "px";

//         $(canvas).parent().parent().css({
//             minWidth: Math.floor(viewport.width) + "px"
//         })

//         // canvas.width = Math.floor(viewport.width * outputScale);
//         // canvas.height = Math.floor(viewport.height * outputScale);
//         // canvas.style.width = Math.floor(viewport.width) + "px";
//         // canvas.style.height = Math.floor(viewport.height) + "px";

//         // $(canvas).parent().css({
//         //     width: Math.floor(viewport.width) + "px",
//         //     height: Math.floor(viewport.height) + "px",
//         //     margin: '10px auto',
//         // });

//         var transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] :
//             null;

//         var renderContext = {
//             canvasContext: context,
//             transform: transform,
//             viewport: viewport
//         };

//         // Render the page contents in the canvas
//         page.render(renderContext).then(function() {
//             __PAGE_RENDERING_IN_PROGRESS = 0;

//             // Show the canvas and hide the page loader
//             $(".page-loader.page-" + page_no).hide();

//             // Return the text contents of the page after the pdf has been rendered in the canvas
//             return page.getTextContent();
//         }).then(function(textContent) {
//             // Get canvas offset
//             var canvas_offset = $(canvas).offset();

//             // Clear HTML for text layer
//             $(textLayer).html('');

//             // Assign the CSS created to the text-layer element
//             $(textLayer).css({
//                 left: '0px',
//                 top: '8px',
//                 height: canvas.height + 'px',
//                 width: canvas.width + 'px'
//             });

//             // Pass the data to the method for rendering of text over the pdf canvas.
//             PDFJS.renderTextLayer({
//                 textContent: textContent,
//                 container: $(textLayer).get(0),
//                 viewport: viewport,
//                 textDivs: []
//             });

//             // // Draw annotations on canvas
//             // const pageAnnotations = annotations.filter(ann => ann.pageNum === page_no);
//             // pageAnnotations.forEach(ann => {
//             //     createSelection($(canvas).parent().find('.annotationLayer')[0], ann.width,
//             //         ann.height, ann.x, ann.y, null)
//             //     createCommentElement($(canvas).parent().find('.annotationLayer')[0], $(
//             //         canvas).width(), ann.y)
//             //     // textContent.beginPath();
//             //     // textContent.rect(ann.x, ann.y, ann.width, ann.height);
//             //     // textContent.strokeStyle = 'red';
//             //     // textContent.lineWidth = 2;
//             //     // textContent.stroke();
//             // });

//         });

//         var scale_vignette_required = vignetteCanvas.width / page.getViewport(1).width * outputScale;

//         // Get viewport of the page at required scale
//         var vignettevViewport = page.getViewport(scale_vignette_required);

//         // Set canvas height
//         vignetteCanvas.height = vignettevViewport.height;

//         var renderVignetteContext = {
//             canvasContext: vignetteCanvas.getContext('2d'),
//             viewport: vignettevViewport
//         };
//         page.render(renderVignetteContext);
//     });
// }

// function showFirstPageImg(url = [], parentContainer) {

//     for (let index = 0; index < url.length; index++) {
//         const pdf_url = url[index];

//         PDFJS.getDocument({
//             url: pdf_url
//         }).then(function(pdf_doc) {

//             var imgPage = document.createElement('img');
//             imgPage.classList.add('img-fluid');

//             var span = document.createElement('span');
//             span.classList.add('d-block');

//             var content = document.createElement('div');
//             content.classList.add('text-center');

//             var a = document.createElement('a');
//             a.setAttribute('href', 'javascript:void(0)');
//             a.classList.add('d-block');
//             a.classList.add('vignette-page');
//             if (index == 0) {
//                 span.innerText = '(Original)';
//             }
//             a.setAttribute('onclick', 'changDoc("' + pdf_url + '", this)');

//             var canvas = document.createElement('canvas');

//             // Show the first page
//             pdf_doc.getPage(1).then(function(page) {

//                 // Support HiDPI-screens.
//                 var outputScale = window.devicePixelRatio || 1;

//                 var scale = outputScale > 1 ? 1.5 : 1.2;

//                 var viewport = page.getViewport(scale);

//                 var context = canvas.getContext('2d');

//                 canvas.width = Math.floor(viewport.width * outputScale);
//                 canvas.height = Math.floor(viewport.height * outputScale);
//                 canvas.style.width = Math.floor(viewport.width * outputScale) + "px";

//                 var transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

//                 var renderContext = {
//                     canvasContext: context,
//                     transform: transform,
//                     viewport: viewport
//                 };

//                 // Render the page contents in the canvas
//                 page.render(renderContext).then(function() {
//                     // Return the text contents of the page after the pdf has been rendered in the canvas
//                     // return page.getTextContent();
//                     var imgData = canvas.toDataURL("image/png");
//                     imgPage.setAttribute('src', imgData);
//                     imgPage.style.width = '120px';
//                     imgPage.classList.add('border');

//                     a.append(imgPage);
//                     if (index > 0) {
//                         span.innerText = 'Pièce jointe ' + index;
//                     }
//                     if (index == url.length - 1) {
//                         a.classList.add('active');
//                     }
//                     content.append(a);
//                     content.append(span);
//                     parentContainer.append(content);
//                 });

//             });
//             // }

//         }).catch(function(error) {
//             // If error re-show the upload button
//             // $("#pdf-loader").hide();
//             // $("#upload-button").show();

//             // alert(error.message);
//         });
//     }
// }

// showFirstPageImg($(".doc-vignette").data('url'), $(".doc-vignette"));

// function changDoc(url, element) {
//     $('#pdf-contents').empty();
//     showPDF(url);

//     $('.vignette-page').removeClass('active');
//     $(element).addClass('active');
// }

// Livewire.on('documentAdded', (e) => {
//     $(".doc-vignette").empty();
//     showFirstPageImg(e, $(".doc-vignette"));
// });

function addToLayer(annotationLayer, commentElement) {
  annotationLayer.append(commentElement);
  // Suppose commentList est votre liste d'éléments de commentaire
  const comments = document.querySelectorAll(".annotationLayer .comment");

  // Lors de l'ajout d'un nouveau commentaire
  const newComment = commentElement;

  const commentList = [];

  // Bouclez à travers les éléments et obtenez leurs positions
  comments.forEach((comment) => {
    const rect = comment.getBoundingClientRect();
    commentList.push({
      comment,
      top: rect.top,
    });
  });

  // Triez la liste des commentaires par position top (du plus petit au plus grand)
  commentList.sort((a, b) => a.top - b.top);

  var newTop = newComment.getBoundingClientRect().top;

  // Trouvez l'index où le nouveau commentaire doit être inséré en fonction de sa position top
  let insertIndex = 0;
  while (
    insertIndex < commentList.length &&
    commentList[insertIndex].top < newTop
  ) {
    insertIndex++;
  }

  // Insérez le nouveau commentaire à l'index approprié
  commentList.splice(insertIndex, 0, newComment);

  // Maintenant, vous pouvez ajuster les positions des commentaires existants situés au-dessus du nouvel élément
  for (let i = 0; i < insertIndex; i++) {
    commentList[i].top += newComment.getBoundingClientRect().height;
    commentList[i].comment.top = commentList[i].top;
    /* ajustement de décalage */
  }

  // Maintenant, commentList contient les commentaires avec les positions mises à jour
}

// Render PDF with annotations
async function renderPdfWithAnnotations() {
  var allCanvas = document.querySelectorAll("#pdf-contents canvas");

  const pageAnnotations = annotations.filter((ann) => ann.pageNum === 1);

  allCanvas.forEach((canvas) => {
    const context = canvas.getContext("2d");
    pageAnnotations.forEach((ann) => {
      context.beginPath();
      context.rect(ann.x, ann.y, ann.width, ann.height);
      context.strokeStyle = "red";
      context.lineWidth = 2;
      context.stroke();
    });
    canvas.context = context;
  });
}

$("#pills-profile-tab").on("click", function () {
  initSignaturePad();
});

$(".btn-paraphe").on("click", function (event) {
  $("#waiting-password").modal("show");

  $.ajax({
    // url: "/ajax/signatures/get/user/image",
    url: "/ajax/signatures/get/user/paraphe/image",
    method: "get",
    success: function (data) {
      $("#waiting-password").modal("hide");
      if (!$("#waiting-password").hasClass("show")) {
        $("#modal-password .modal-body").find("#imgData").val(data.image);
        $("#modal-password .modal-body").find("#pass").val(data.password);
        $("#modal-password .modal-body").find("#action").val(data.action);
        $("#modal-password").modal("show");
      } else {
        $("#waiting-password").modal("hide");
        $("#modal-password .modal-body").find("#imgData").val(data.image);
        $("#modal-password .modal-body").find("#pass").val(data.password);
        $("#modal-password .modal-body").find("#action").val(data.action);
        $("#modal-password").modal("show");
      }
    },
  });
});

$(".btn-signer").on("click", function (event) {
  $("#waiting-password").modal("show");
  $.ajax({
    url: "/ajax/signatures/get/user/image",
    method: "get",
    success: function (data) {
      $("#waiting-password").modal("hide");
      if (!$("#waiting-password").hasClass("show")) {
        $("#modal-password .modal-body").find("#imgData").val(data.image);
        $("#modal-password .modal-body").find("#pass").val(data.password);
        $("#modal-password .modal-body").find("#action").val(data.action);
        $("#modal-password").modal("show");
      } else {
        $("#waiting-password").modal("hide");
        $("#modal-password .modal-body").find("#imgData").val(data.image);
        $("#modal-password .modal-body").find("#pass").val(data.password);
        $("#modal-password .modal-body").find("#action").val(data.action);
        $("#modal-password").modal("show");
      }
    },
  });
});

$(".resend-code").on("click", function (event) {
  $("#modal-password").modal("hide");
  $("#waiting-password").modal("show");
  $.ajax({
    url: "/ajax/signatures/get/user/image",
    method: "get",
    success: function (data) {
      $("#modal-password .modal-body").find("#imgData").val(data.image);
      $("#modal-password .modal-body").find("#pass").val(data.password);

      $("#waiting-password").modal("hide");
      $("#modal-password").modal("show");
    },
  });
});

// inputs champs de validation

const inputs = document.querySelectorAll(".input-password");

// Fonction pour mettre à jour la valeur du champ caché
function updatePassword() {
  let concatenatedValue = "";
  inputs.forEach((input) => {
    concatenatedValue += input.value;
  });

  // Gestion de l'événement focus pour permettre la suppression
  inputs.forEach((input, index) => {
    // Effacer la valeur avec Backspace
    input.addEventListener("keydown", (event) => {
      if (event.key === "Backspace" && input.value === "") {
        // Revenir au champ précédent si existant
        if (index > 0) {
          inputs[index - 1].focus();
        }
        event.preventDefault();
      }
    });

    // Passer automatiquement au champ suivant
    input.addEventListener("input", () => {
      if (input.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
      updatePassword(); // Met à jour le champ caché
    });

    // Focus sur le champ courant
    input.addEventListener("focus", () => {
      input.select(); // Sélectionner la valeur actuelle
    });
  });

  return concatenatedValue;
}

$(".btn-valid-password").on("click", function () {
  var imgData = $("#modal-password .modal-body").find("#imgData").val();
  var password = $("#modal-password .modal-body").find("#pass").val();
  var action = $("#modal-password .modal-body").find("#action").val();

  var passwordValue = updatePassword();

  if (passwordValue == password) {
    if (imgData !== "" && imgData !== undefined && imgData !== null) {
      var signatureElement = createSignatureElement2();
      if (action == 1) {
        signatureElement.classList.add("signature");
      } else if (action == 2) {
        signatureElement.classList.add("paraphe");
      } else {
        signatureElement.classList.add("tampon");
      }
      var imgElement = document.createElement("img");
      $(imgElement).addClass("w-100 h-100");
      $(imgElement).css({
        objectFit: "contain",
      });

      $(imgElement).attr("src", imgData);

      $(signatureElement).append(imgElement);
      signatureElement.style.left = event.clientX + 5 + "px";
      signatureElement.style.top = event.clientY + 5 + "px";

      $("#modal-password").modal("hide");
      $("#modal-password").find("input").val("");
      $(".btn-signer").attr("disabled", true);
      $(".btn-signer").addClass("disabled");
    } else {
      if (action == 1) {
        newSignatureImage();
      } else if (action == 2) {
        newParapheImage();
      } else {
        newTamponImage();
      }
      $("#modal-password").modal("hide");
      $("#modal-password").find("input").val("");
    }
  } else {
    const modalPassword = $("#modal-password"); // Réutilisation de la sélection

    // Modification du texte de l'élément ".error-message"
    modalPassword.find(".error-message").text("Mot de passe incorrect");

    // Gestion de la classe pour ".error-message-modal-esignature-box-hidden"
    const blocError = modalPassword.find(
      ".error-message-modal-esignature-box-hidden"
    );

    if (blocError.length > 0) {
      blocError
        .removeClass("error-message-modal-esignature-box-hidden")
        .addClass("error-message-modal-esignature-box");
    }
  }
});

$(".btn-tampon").on("click", function (event) {
  $.ajax({
    url: "/ajax/signatures/get/user/tampon/image",
    method: "get",
    success: function (data) {
      if (data.image !== "" && data.image !== undefined) {
        var signatureElement = createSignatureElement2();
        signatureElement.classList.add("tampon");
        var imgElement = document.createElement("img");
        $(imgElement).addClass("w-100 h-100");
        $(imgElement).css({
          objectFit: "contain",
        });
        $(imgElement).attr("src", data.image);

        $(signatureElement).append(imgElement);
        signatureElement.style.left = event.clientX + 5 + "px";
        signatureElement.style.top = event.clientY + 5 + "px";
      } else {
        newTamponImage();
      }
    },
  });
});

function createSignatureElement() {
  if ($(".signature:not(.dropped-true)").length == 0) {
    var signatureElement = document.createElement("div");
    signatureElement.classList.add("signature");
    signatureElement.style.position = "fixed";

    var certificate = document.createElement("div");
    certificate.classList.add("certificate");

    var span1 = document.createElement("span");
    span1.innerText = "Signé avec Maxidoc";

    var span2 = document.createElement("span");
    span2.innerText = generateRandomString(20);

    var signeContainer = document.createElement("div");
    signeContainer.classList.add("signe-img-container");
    signeContainer.style.position = "absolute";

    signeContainer.style.height = "80%";
    signeContainer.style.top = "50%";
    signeContainer.style.left = "25px";
    signeContainer.style.transform = "translateY(-50%)";

    certificate.append(span1);
    certificate.append(span2);
    certificate.append(signeContainer);
    signatureElement.append(certificate);

    var removeBtn = document.createElement("button");
    removeBtn.classList.add("btn");
    removeBtn.classList.add("btn-danger");
    removeBtn.classList.add("btn-sm");
    removeBtn.classList.add("rounded-circle");
    removeBtn.classList.add("remove-btn");
    $(removeBtn).text("x");
    $(removeBtn).css({
      position: "absolute",
      right: 0,
    });

    $(signatureElement).append(removeBtn);

    $(signatureElement).draggable();
    $("body").append(signatureElement);

    return signatureElement;
  }
}

function generateRandomString(length) {
  const characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  let result = "";

  for (let i = 0; i < length; i++) {
    const randomIndex = Math.floor(Math.random() * characters.length);
    result += characters.charAt(randomIndex);
  }

  return result;
}

function createSignatureElement2() {
  if ($(".signature:not(.dropped-true)").length == 0) {
    var signatureElement = document.createElement("div");
    signatureElement.classList.add("signature");
    signatureElement.style.position = "fixed";

    var removeBtn = document.createElement("button");
    removeBtn.classList.add("btn");
    removeBtn.classList.add("btn-danger");
    removeBtn.classList.add("btn-sm");
    removeBtn.classList.add("rounded-circle");
    removeBtn.classList.add("remove-btn");
    $(removeBtn).text("x");
    $(removeBtn).css({
      position: "absolute",
      right: 0,
    });

    $(signatureElement).append(removeBtn);

    $(signatureElement).draggable();
    $("body").append(signatureElement);

    return signatureElement;
  }
}

function recreateOldSignatureElement(oldSignatureElement) {
  var signatureElement = oldSignatureElement;

  var certificate = document.createElement("div");
  certificate.classList.add("certificate");

  var span1 = document.createElement("span");
  span1.innerText = "Signé avec Maxidoc";

  var span2 = document.createElement("span");
  span2.innerText = generateRandomString(20);

  var signeContainer = document.createElement("div");
  signeContainer.classList.add("signe-img-container");
  signeContainer.style.position = "absolute";
  // signeContainer.style.width = '100%';
  signeContainer.style.height = "80%";
  signeContainer.style.top = "50%";
  signeContainer.style.left = "25px";
  signeContainer.style.transform = "translateY(-50%)";

  certificate.append(span1);
  certificate.append(span2);
  certificate.append(signeContainer);
  signatureElement.append(certificate);

  return signatureElement;
}

function newSignatureImage() {
  if ($(".signature:not(.dropped-true)").length == 0) {
    $(".modal-signature").find(".dessin").removeClass("d-none");
    $(".modal-signature").find(".dessin-tab").addClass("active");
    $(".modal-signature").find(".dessin-tab").addClass("show");
    $(".modal-signature").find(".dessin-tab").removeClass("d-none");

    $(".modal-signature").find(".import-image-tab").removeClass("active");
    $(".modal-signature").find(".import-image-tab").removeClass("show");
    $(".modal-signature").find(".import-image button").removeClass("active");

    $(".modal-signature").addClass("signature-modal");
    $(".modal-signature").removeClass("tampon-modal");
    $(".modal-signature").find(".btn-change").addClass("d-none");
    $(".modal-signature").css({
      width: "100%",
    });
    initSignaturePad();
  }
}

function newTamponImage() {
  if ($(".signature:not(.dropped-true)").length == 0) {
    $(".modal-signature").find(".dessin").addClass("d-none");
    $(".modal-signature").find(".dessin-tab").removeClass("active");
    $(".modal-signature").find(".dessin-tab").removeClass("show");
    $(".modal-signature").find(".dessin-tab").addClass("d-none");

    $(".modal-signature").find(".import-image-tab").addClass("active");
    $(".modal-signature").find(".import-image-tab").addClass("show");
    $(".modal-signature").find(".import-image button").addClass("active");

    $(".modal-signature").removeClass("signature-modal");
    $(".modal-signature").addClass("tampon-modal");
    $(".modal-signature").css({
      width: "100%",
    });

    initSignaturePad();
  }
}
function newParapheImage() {
  if ($(".signature:not(.dropped-true)").length == 0) {
    // $('.modal-paraphe').find('.dessin').addClass('d-none');
    // $('.modal-paraphe').find('.dessin-tab').removeClass('active');
    // $('.modal-paraphe').find('.dessin-tab').removeClass('show');
    // $('.modal-paraphe').find('.dessin-tab').addClass('d-none');

    // $('.modal-paraphe').find('.import-image-tab').addClass('active');
    // $('.modal-paraphe').find('.import-image-tab').addClass('show');
    // $('.modal-paraphe').find('.import-image button').addClass('active');

    // $('.modal-paraphe').removeClass('paraphe-modal');
    // $('.modal-paraphe').addClass('tampon-modal');
    $(".modal-paraphe").css({
      width: "100%",
    });

    initSignaturePad();
  }
}

function signatureEdit() {
  if ($(".signature:not(.dropped-true)").length == 0) {
    $(".modal-signature").find(".dessin").removeClass("d-none");
    $(".modal-signature").find(".dessin-tab").addClass("active");
    $(".modal-signature").find(".dessin-tab").addClass("show");
    $(".modal-signature").find(".dessin-tab").removeClass("d-none");

    $(".modal-signature").find(".import-image-tab").removeClass("active");
    $(".modal-signature").find(".import-image-tab").removeClass("show");
    $(".modal-signature").find(".import-image button").removeClass("active");

    $(".modal-signature").addClass("signature-modal");
    $(".modal-signature").removeClass("tampon-modal");
    $(".modal-signature").find(".valid-canevas").addClass("d-none");
    $(".modal-signature").css({
      width: "100%",
    });

    initSignaturePad();
  }
}

$(".btn-edit-sign").on("click", function () {
  // Call the signatureEdit function to set up the signature editing mode
  signatureEdit();

  // Show the signature modal
  //   $(".modal-signature").modal("show");

  // Clear any existing signature in the canvas
  if (typeof signaturePad !== "undefined") {
    signaturePad.clear();
  }

  // Enable the save button
  $(".valid-canevas").removeClass("d-none");

  // Set focus to the signature pad
  $(".signature-pad").focus();

  // Add a class to indicate edit mode
  $(".modal-signature").addClass("edit-mode");

  // Update any UI elements to reflect edit mode
  $(".modal-signature .modal-title").text("Edit Signature");

  // Optionally, load the existing signature for editing
  loadExistingSignature();

  // Log the action for debugging
  console.log("Signature edit mode activated");
});

// Helper function to load existing signature (you would need to implement this)
function loadExistingSignature() {
  // This is a placeholder. You would typically:
  // 1. Fetch the existing signature data from your server or local storage
  // 2. Load it into the signature pad
  // For example:
  // $.ajax({
  //   url: "/get-existing-signature",
  //   method: "GET",
  //   success: function(data) {
  //     signaturePad.fromDataURL(data.signatureImage);
  //   }
  // });

  $.ajax({
    url: "/ajax/signatures/get/user/image",
    method: "GET",
    success: function (data) {
      signaturePad.fromDataURL(data.signatureImage);
    },
  });
}

// Event handlers for tracking mouse movement on the document
$(document).on("mousemove", function (event) {
  var signatureElement = document.querySelector(
    ".signature:not(.dropped-true)"
  );
  if (signatureElement !== null) {
    signatureElement.style.left = event.clientX + 5 + "px";
    signatureElement.style.top = event.clientY + 5 + "px";
  }
});

$("body").on("click", ".text-layer", function () {
  // Get the first draggable element (you can modify this selector based on your actual draggable elements)
  var draggableElement = $(".signature:not(.dropped-true)").first();

  // Check if the draggable element exists and is draggable
  if (
    draggableElement.length > 0 &&
    draggableElement.hasClass("ui-draggable")
  ) {
    $(draggableElement).addClass("dropped-true");
    $(draggableElement).resizable({
      // aspectRatio: true,
      autoHide: true,
      handles: "n, e, s, w, ne, se, sw, nw",
    });

    $(draggableElement).css({
      position: "absolute",
      left: event.clientX + window.scrollX + "px",
      top: event.clientY + window.scrollY + "px",
    });

    $(".signature")
      .find("img")
      .on("dblclick", function () {
        if ($(this).hasClass("droped-true")) {
          $(this).addClass("active");
        } else {
          $(this).parent().addClass("active");
        }
        if ($(this).parent().hasClass("tampon")) {
          newTamponImage();
        } else if ($(this).parent().hasClass("paraphe")) {
          newParapheImage();
        } else {
          newSignatureImage();
        }
        initSignaturePad();
      });

    // Simulate the drop event on the droppable area
    $(this)
      .parent()
      .trigger("drop", {
        draggable: $(draggableElement),
        helper: $(draggableElement),
        offset: {
          top: $(draggableElement).offset().top,
          left: $(draggableElement).offset().left,
        },
        position: {
          top: $(draggableElement).offset().top,
          left: $(draggableElement).offset().left,
        },
      });

    $(".remove-btn").on("click", function () {
      $(this).parent().remove();
      $(".btn-signer").removeClass("disabled");
      $(".btn-signer").attr("disabled", false);
    });
    initSignaturePad();
  }
});

$(".valid-canevas").on("click", function () {
  saveSignatureOrTampon();
});

$(".valid-canevas2").on("click", function () {
  $(".paraphe-loader").removeClass("d-none");
  saveParaphe();
});

$(".valid-name").on("click", function () {
  $(".signature-loader").removeClass("d-none");
  // var nameSignatureElement = $(this).parent().parent().find('.signature-name-container');
  // console.log(nameSignatureElement);
  var nameSignatureElement = document.querySelector(
    ".signature-name-container"
  );

  html2canvas(nameSignatureElement, {
    backgroundColor: null,
  }).then(function (canvas) {
    canvas.classList.add("tmp-canvas-2");
    document.body.appendChild(canvas);
    var leCanvas = document.querySelectorAll(".tmp-canvas-2")[0];
    let img = leCanvas.toDataURL("image/png");
    // console.log(img);

    saveSignatureOrTampon(img);
  });
});

$(".valid-name2").on("click", function () {
  $(".paraphe-loader").removeClass("d-none");
  var nameSignatureElement = document.querySelector(
    ".signature-name-container2"
  );

  html2canvas(nameSignatureElement, {
    backgroundColor: null,
  }).then(function (canvas) {
    canvas.classList.add("tmp-canvas-2");
    document.body.appendChild(canvas);
    var leCanvas = document.querySelectorAll(".tmp-canvas-2")[0];
    let img = leCanvas.toDataURL("image/png");

    saveParaphe(img);
  });
});

function saveSignatureOrTampon(img = null) {
  let oldSignatureElement = document.querySelector(
    ".signature.dropped-true.active"
  );
  let signatureElement = null;
  var imgData = "";

  if (img !== null) {
    imgData = img;
  } else {
    signaturePad.removeBlanks();
    imgData = signaturePad.toDataURL();
  }

  let imgElement = document.createElement("img");

  if (oldSignatureElement !== null) {
    signatureElement = recreateOldSignatureElement(oldSignatureElement);
    $(signatureElement).find("img").remove();
    $(imgElement).addClass("img-fluid");
    $(imgElement).css({
      padding: "10px 0px",
    });
    $(imgElement).attr("src", imgData);
    $(signatureElement).find(".signe-img-container").append(imgElement);
  } else {
    signatureElement = createSignatureElement();
    $(imgElement).addClass("img-fluid");
    if (!$(".modal-signature").hasClass("tampon-modal")) {
      $(imgElement).css({
        padding: "10px 0px",
      });
    }
    $(imgElement).attr("src", imgData);
    $(signatureElement).find(".signe-img-container").append(imgElement);
    // signatureElement.classList.add('d-none');
  }

  $(signatureElement).find(".remove-btn").remove();

  if ($(".modal-signature").hasClass("tampon-modal")) {
    $(signatureElement).addClass("tampon");
  }

  let ajaxUrl = "";
  if ($(".modal-signature").hasClass("tampon-modal")) {
    ajaxUrl = "/ajax/signatures/save/user/tampon/image";
  } else if ($(".modal-signature").hasClass("paraphe-modal")) {
    ajaxUrl = "/ajax/signatures/save/user/paraphe/image";
  } else {
    ajaxUrl = "/ajax/signatures/save/user/image";
  }
  // $('.modal-signature').hasClass('tampon-modal') ?
  //     "/ajax/signatures/save/user/tampon/image" :
  //     "/ajax/signatures/save/user/image";

  html2canvas(signatureElement, {
    backgroundColor: null,
    // allowTaint: true,
    // scale: 2,
    // removeContainer: true
  }).then(function (canvas) {
    if (oldSignatureElement === null) {
      signatureElement.style.visibility = "hidden";
    }

    canvas.classList.add("tmp-canvas");
    document.body.appendChild(canvas);
    let leCanvas = document.querySelectorAll(".tmp-canvas")[0];
    let img2 = leCanvas.toDataURL("image/png");

    $.ajax({
      url: ajaxUrl,
      method: "post",
      data: {
        image: img2,
      },
      success: function (data) {
        $(signatureElement).find(".certificate").remove();
        $(signatureElement).find(".signe-img-container").remove();
        $(signatureElement).find("img").remove();

        var removeBtn = document.createElement("button");
        removeBtn.classList.add("btn");
        removeBtn.classList.add("btn-danger");
        removeBtn.classList.add("btn-sm");
        removeBtn.classList.add("rounded-circle");
        removeBtn.classList.add("remove-btn");
        $(removeBtn).text("x");
        $(removeBtn).css({
          position: "absolute",
          right: 0,
        });

        $(signatureElement).append(removeBtn);
        // signatureElement.classList.remove('d-none');
        signatureElement.style.visibility = "visible";

        var newImg = document.createElement("img");

        $(newImg).addClass("img-fluid");
        $(newImg).attr("src", data.image_url);
        $(signatureElement).append(newImg);

        $(".signature")
          .find("img")
          .on("dblclick", function () {
            if ($(this).hasClass("droped-true")) {
              $(this).addClass("active");
            } else {
              $(this).parent().addClass("active");
            }

            if ($(this).hasClass("tampon")) {
              newTamponImage();
            } else if ($(this).hasClass("paraphe")) {
              newParapheImage();
            } else {
              newSignatureImage();
            }
            initSignaturePad();
          });

        document.body.removeChild(leCanvas);
        var others = document.querySelectorAll(".tmp-canvas-2");
        others.forEach((element) => {
          document.body.removeChild(element);
        });

        $(".modal-signature").css({
          width: "0px",
        });

        $(".modal-signature #nom-signature").removeClass("active");
        $(".modal-signature #nom-signature").removeClass("show");

        $("#waiting-password").modal("hide");
      },
    });
  });
}

function saveParaphe(img = null) {
  let oldSignatureElement = document.querySelector(
    ".signature.dropped-true.active"
  );
  let signatureElement = null;
  var imgData = "";

  if (img !== null) {
    imgData = img;
  } else {
    signaturePad2.removeBlanks();
    imgData = signaturePad2.toDataURL();
  }

  let imgElement = document.createElement("img");

  if (oldSignatureElement !== null) {
    signatureElement = recreateOldSignatureElement(oldSignatureElement);
    $(signatureElement).find("img").remove();
    $(imgElement).addClass("img-fluid");
    $(imgElement).css({
      padding: "10px 0px",
    });
    $(imgElement).attr("src", imgData);
    $(signatureElement).find(".signe-img-container").append(imgElement);
  } else {
    signatureElement = createSignatureElement();
    $(imgElement).addClass("img-fluid");
    if (!$(".modal-signature").hasClass("tampon-modal")) {
      $(imgElement).css({
        padding: "10px 0px",
      });
    }
    $(imgElement).attr("src", imgData);
    $(signatureElement).find(".signe-img-container").append(imgElement);
    // signatureElement.classList.add('d-none');
  }

  $(signatureElement).find(".remove-btn").remove();

  if ($(".modal-signature").hasClass("tampon-modal")) {
    $(signatureElement).addClass("tampon");
  }

  let ajaxUrl = "/ajax/signatures/save/user/paraphe/image";
  // if($('.modal-signature').hasClass('tampon-modal')){
  //     ajaxUrl = "/ajax/signatures/save/user/tampon/image";
  // }else if($('.modal-signature').hasClass('paraphe-modal')){
  //     ajaxUrl = "/ajax/signatures/save/user/paraphe/image"
  // }else{
  //     ajaxUrl = "/ajax/signatures/save/user/image";
  // }
  // $('.modal-signature').hasClass('tampon-modal') ?
  //     "/ajax/signatures/save/user/tampon/image" :
  //     "/ajax/signatures/save/user/image";

  html2canvas(signatureElement, {
    backgroundColor: null,
    allowTaint: true,
    scale: 2,
    removeContainer: true,
  }).then(function (canvas) {
    if (oldSignatureElement === null) {
      signatureElement.style.visibility = "hidden";
    }

    canvas.classList.add("tmp-canvas");
    document.body.appendChild(canvas);
    let leCanvas = document.querySelectorAll(".tmp-canvas")[0];
    let img2 = leCanvas.toDataURL("image/png");

    $.ajax({
      url: ajaxUrl,
      method: "post",
      data: {
        image: img2,
      },
      success: function (data) {
        $(signatureElement).find(".certificate").remove();
        $(signatureElement).find(".signe-img-container").remove();
        $(signatureElement).find("img").remove();

        var removeBtn = document.createElement("button");
        removeBtn.classList.add("btn");
        removeBtn.classList.add("btn-danger");
        removeBtn.classList.add("btn-sm");
        removeBtn.classList.add("rounded-circle");
        removeBtn.classList.add("remove-btn");
        $(removeBtn).text("x");
        $(removeBtn).css({
          position: "absolute",
          right: 0,
        });

        $(signatureElement).append(removeBtn);
        // signatureElement.classList.remove('d-none');
        signatureElement.style.visibility = "visible";

        var newImg = document.createElement("img");

        $(newImg).addClass("img-fluid");
        $(newImg).attr("src", data.image_url);
        $(signatureElement).append(newImg);

        $(".signature")
          .find("img")
          .on("dblclick", function () {
            if ($(this).hasClass("droped-true")) {
              $(this).addClass("active");
            } else {
              $(this).parent().addClass("active");
            }

            // if ($(this).hasClass('tampon')) {
            //     newTamponImage();
            // } else if ($(this).hasClass('paraphe')) {
            // } else {
            //     newSignatureImage();
            // }
            newParapheImage();
            initSignaturePad();
          });

        document.body.removeChild(leCanvas);
        var others = document.querySelectorAll(".tmp-canvas-2");
        others.forEach((element) => {
          document.body.removeChild(element);
        });

        $(".modal-paraphe").css({
          width: "0px",
        });
        $("#waiting-password").modal("hide");
        $(".paraphe-loader").modal("hide");
      },
    });
  });
}

SignaturePad.prototype.removeBlanks = function () {
  var imgWidth = this._ctx.canvas.width;
  var imgHeight = this._ctx.canvas.height;
  var imageData = this._ctx.getImageData(0, 0, imgWidth, imgHeight),
    data = imageData.data,
    getAlpha = function (x, y) {
      return data[(imgWidth * y + x) * 4 + 3];
    },
    scanY = function (fromTop) {
      var offset = fromTop ? 1 : -1;

      // loop through each row
      for (
        var y = fromTop ? 0 : imgHeight - 1;
        fromTop ? y < imgHeight : y > -1;
        y += offset
      ) {
        // loop through each column
        for (var x = 0; x < imgWidth; x++) {
          if (getAlpha(x, y)) {
            return y;
          }
        }
      }
      return null; // all image is white
    },
    scanX = function (fromLeft) {
      var offset = fromLeft ? 1 : -1;

      // loop through each column
      for (
        var x = fromLeft ? 0 : imgWidth - 1;
        fromLeft ? x < imgWidth : x > -1;
        x += offset
      ) {
        // loop through each row
        for (var y = 0; y < imgHeight; y++) {
          if (getAlpha(x, y)) {
            return x;
          }
        }
      }
      return null; // all image is white
    };

  var cropTop = scanY(true),
    cropBottom = scanY(false),
    cropLeft = scanX(true),
    cropRight = scanX(false);

  var relevantData = this._ctx.getImageData(
    cropLeft,
    cropTop,
    cropRight - cropLeft,
    cropBottom - cropTop
  );

  this._ctx.canvas.width = cropRight - cropLeft;
  this._ctx.canvas.height = cropBottom - cropTop;
  this._ctx.clearRect(0, 0, cropRight - cropLeft, cropBottom - cropTop);
  this._ctx.putImageData(relevantData, 0, 0);
};

$(".btn-valid-img").on("click", function () {
  const img = document.getElementById("sign-img");
  var imgData = img.src;

  saveSignatureOrTampon(imgData);
});

// Handle button click to insert an image into the PDF

$(".save_pdf").on("click", function () {
  var signatures = document.querySelectorAll(".signature");
  if (signatures.length > 0) {
    var modal = new bootstrap.Modal($("#modal-action-save"));
    modal.show();
  } else {
    var modal = new bootstrap.Modal($("#modal-error"));
    modal.show();
  }
});

// Handle button click to insert an image into the PDF
$("#saveCourrier").on("click", function () {
  $(".loader-card").removeClass("d-none");
  loadPDF(url, "/courriers/save/signature");
});

$("#saveTache").on("click", function () {
  console.log(true);
  $(".loader-card").removeClass("d-none");
  loadPDF(url, "/ajax/taches/save/signature");
});

async function loadPDF(url, ajaxUrl) {
  let signatureElements = document.querySelectorAll(".signature.dropped-true");

  // Fetch the PDF file from the server
  const response = await fetch(url);
  const pdfBytes = await response.blob();

  // Convert the Blob to an ArrayBuffer
  const buffer = await new Response(pdfBytes).arrayBuffer();

  // Load the PDF using pdf-lib
  const pdfDoc = await PDFLib.PDFDocument.load(buffer);

  for (var index = 0; index < signatureElements.length; index++) {
    const signatureElement = signatureElements[index];

    const pngImageBytes = await fetch(
      $(signatureElement).find("img").attr("src")
    ).then((res) => res.arrayBuffer());

    const pngImage = await pdfDoc.embedPng(pngImageBytes);
    var currentPage = $(signatureElement).data("page");
    const page = pdfDoc.getPages()[currentPage - 1];

    var pageParent = document.getElementById("page-" + currentPage);

    var pageParentX = $(pageParent).width();
    var pageParentY = $(pageParent).height();

    var facteurX = page.getWidth() / pageParentX;
    var facteurY = page.getHeight() / pageParentY;

    var imgWidth = $(signatureElement).find("img").width() * facteurX;
    var imgHeight = $(signatureElement).find("img").height() * facteurY;

    var oldW = $(signatureElement).find("img").width();
    var oldH = $(signatureElement).find("img").height();

    var y = $(signatureElement).data("y") * facteurY; //- imgHeight;
    var x = $(signatureElement).data("x") * facteurX; //- imgWidth;

    const signature = {
      width: imgWidth,
      height: imgHeight,
      x: x,
      y: y,
    };

    var outputScale = window.devicePixelRatio || 1;
    var scale = outputScale > 1 ? 1.5 : 1.2;

    const imageOptions = getImagePosition(page, signature, scale);

    // Add the image to page
    page.drawImage(pngImage, imageOptions);
  }

  await pdfDoc.save().then(async function (modifiedPdfBytes) {
    // Convert the modified PDF bytes to a Blob
    const modifiedPdfBlob = await new Blob([modifiedPdfBytes], {
      type: "application/pdf",
    });

    var formData = new FormData();
    formData.append("document", modifiedPdfBlob, docName);
    if ($("select[name=agent_id]").val()) {
      formData.append("agent_id", $("select[name=agent_id]").val());
    }
    if (courrier_id) {
      formData.append("courrier_id", courrier_id);
    }
    if (tache_id) {
      formData.append("tache_id", tache_id);
    }
    if (doc_id) {
      formData.append("doc_id", doc_id);
    }
    if (is_original) {
      formData.append("is_original", is_original);
    }

    $.ajax({
      url: ajaxUrl,
      method: "post",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data) {
        // const backBTN = document.createElement('a');
        // backBTN.href = "javascript:history.go(-2)";

        // // Trigger the back btn
        // backBTN.click();
        window.history.go(-1);

        $(".loader-card").addClass("d-none");

        $(".modal.show").modal("hide");

        $("#pdf-contents").empty();
        $(signatureElements).remove();

        showPDF(data.file);
      },
    });
  });
}

function getImagePosition(page, image, sizeRatio) {
  let pageWidth, pageHeight;
  if ([90, 270].includes(page.getRotation().angle)) {
    pageWidth = page.getHeight();
    pageHeight = page.getWidth();
  } else {
    pageWidth = page.getWidth();
    pageHeight = page.getHeight();
  }

  if (!image.hasOwnProperty("vpWidth")) {
    image["vpWidth"] = pageWidth;
  }

  const pageRatio = pageWidth / (image.vpWidth * sizeRatio);
  const imageWidth = image.width * sizeRatio * pageRatio;
  const imageHeight = image.height * sizeRatio * pageRatio;
  const imageX = image.x * sizeRatio * pageRatio;
  const imageYFromTop = image.y * sizeRatio * pageRatio;

  const correction = compensateRotation(
    page.getRotation().angle,
    imageX,
    imageYFromTop,
    1,
    page.getSize(),
    imageHeight
  );

  return {
    width: imageWidth,
    height: imageHeight,
    x: correction.x,
    y: correction.y,
    rotate: page.getRotation(),
  };
}

function compensateRotation(pageRotation, x, y, scale, dimensions, fontSize) {
  // var pageRotation = me.getPageRotation(page);
  var rotationRads = (pageRotation * Math.PI) / 180;

  //These coords are now from bottom/left
  var coordsFromBottomLeft = {
    x: x / scale,
  };
  if (pageRotation === 90 || pageRotation === 270) {
    coordsFromBottomLeft.y = dimensions.width - (y + fontSize) / scale;
  } else {
    coordsFromBottomLeft.y = dimensions.height - (y + fontSize) / scale;
  }

  var drawX = null;
  var drawY = null;

  if (pageRotation === 90) {
    drawX =
      coordsFromBottomLeft.x * Math.cos(rotationRads) -
      coordsFromBottomLeft.y * Math.sin(rotationRads) +
      dimensions.width;
    drawY =
      coordsFromBottomLeft.x * Math.sin(rotationRads) +
      coordsFromBottomLeft.y * Math.cos(rotationRads);
  } else if (pageRotation === 180) {
    drawX =
      coordsFromBottomLeft.x * Math.cos(rotationRads) -
      coordsFromBottomLeft.y * Math.sin(rotationRads) +
      dimensions.width;
    drawY =
      coordsFromBottomLeft.x * Math.sin(rotationRads) +
      coordsFromBottomLeft.y * Math.cos(rotationRads) +
      dimensions.height;
  } else if (pageRotation === 270) {
    drawX =
      coordsFromBottomLeft.x * Math.cos(rotationRads) -
      coordsFromBottomLeft.y * Math.sin(rotationRads);
    drawY =
      coordsFromBottomLeft.x * Math.sin(rotationRads) +
      coordsFromBottomLeft.y * Math.cos(rotationRads) +
      dimensions.height;
  } else {
    //no rotation
    drawX = coordsFromBottomLeft.x;
    drawY = coordsFromBottomLeft.y;
  }

  return {
    x: drawX,
    y: drawY,
  };
}
