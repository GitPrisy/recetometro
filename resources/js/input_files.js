function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        const img = $(input).prev().prev().children(":first");
        reader.onload = function (e) {
            img.attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
$(".image-input").each(function () {
    $(this).change(function () {
        readURL(this);
    });
});
