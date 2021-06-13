if (
    document.getElementById("ingredients") &&
    document.getElementById("preparation")
) {
    document.getElementById("ingredients").innerHTML = document
        .getElementById("ingredients")
        .getAttribute("value");
    document.getElementById("preparation").innerHTML = document
        .getElementById("preparation")
        .getAttribute("value");

    $("#text-comment").on("keypress", function () {
        var limit = 150;
        $("#text-comment").attr("maxlength", limit);
        var init = $(this).val().length;

        if (init < limit) {
            init++;
            $("#char-limit").text(init + "/" + limit);
        }
    });
}
