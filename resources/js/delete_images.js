window.onload = function () {
    $("#deleteRecipe").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);

        const slug = button.data("slug");
        const id = button.data("id");
        console.log(id);
        console.log(slug);
        $("#deleteImageButton").on("click", function () {
            deleteImage(slug, id);
        });
    });
};

function deleteImage(slug, image_id) {
    const url = "/receta/" + slug + "/" + image_id + "/delete";
    const data = new URLSearchParams();
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    data.append('_token', csrf);
    fetch(url, {
        method: "POST",
        body: data,
    }).then(function (res) {
        if (res.status == 503) {
            console.log($("#delete-" + image_id));
            $("#delete-" + image_id).after(
                '<div class="alert alert-danger mt-3 ml-5 mr-5" role="alert">La receta debe tener por lo menos una imagen...</div>'
            );
            $("#delete-" + image_id).remove();
        } else {
            $("#img-" + image_id).fadeOut();
            $("#delete-" + image_id).fadeOut();
            $("#update-" + image_id).fadeOut();
        }
    });
};
