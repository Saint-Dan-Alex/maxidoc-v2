$("#dropzone").on("dragover", function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().addClass("dragover");
});

$("#dropzone").on("dragleave", function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().removeClass("dragover");
});

$("#dropzone").on("drop", function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().removeClass("dragover");
    var files = event.originalEvent.dataTransfer.files;
    if (files.length > 0) {
        $(this).parent().addClass("has-file");
        handleDropFiles(files);
        handleFilesPreview(files);
    }
});

$("#dropzone").on("click", function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).parent().addClass("dragover");
    $(this).parent().find('input').trigger("click");
});

$("#dropzone").parent().find('input').on('change', function(event) {
    $(this).parent().removeClass("dragover");
    var files = event.target.files;
    if (files.length > 0) {
        $(this).parent().addClass("has-file");
        handleFilesPreview(files);
    }
});

function handleDropFiles(files) {
    $("#dropzone").parent().find('input').prop('files', files);
}

function loadImages(files) {
    var imagePromises = [];
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();
        var promise = new Promise(function(resolve, reject) {
            reader.onload = function(e) {
                resolve(e.target.result);
            }
            reader.onerror = function(e) {
                reject(e);
            }
            reader.readAsDataURL(file);
        });
        imagePromises.push(promise);
    }
    return Promise.all(imagePromises);
}

function handleFilesPreview(files) {
    $('.dropzone-preview').show();
    var list = $('.dropzone-preview-list');

    loadImages(files).then(function(imageUrls) {
        console.log(files);
        console.log(imageUrls);

        for (let index = 0; index < imageUrls.length; index++) {
            var imageUrl = imageUrls[index];
            var file = files[index];

            var item = $("<li>", {
                class: "dropzone-preview-list-item"
            });
            var imagePreview = $("<img>", {
                class: "dropzone-preview-image"
            });
            var icon = $("<i>", {
                class: "fi fi-rr-file dropzone-preview-icon"
            });
            var name = $("<small>", {
                class: "dropzone-preview-name"
            });

            let filename = file.name;
            if (filename.length >= 12) {
                let splitName = filename.split('.');
                filename = splitName[0].substring(0, 12) + "... ." + splitName[1];
                name.text(filename);
            }

            if (file.type.match('image.*')) {
                imagePreview.attr('src', imageUrl);

                item.append(imagePreview);
                item.append(name);
                list.append(item);

            } else {
                item.append(icon);
                item.append(name);
                list.append(item);
            }
        }
    }).catch(function(error) {
        console.log(error);
    });
}
