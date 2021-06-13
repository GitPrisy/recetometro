function loadMore(page) {
    $.ajax({
        url: "?page=" + page,
        type: "get",
        beforeSend: function () {
            $(".auto-load").show();
        },
    })
        .done(function (data) {
            if (typeof data.html == "undefined") {
                return;
            }
            $(".auto-load").hide();
            $("#post-data").append(data.html);
        })
        .fail(function (data) {
            if (typeof data.html == "undefined") {
                $(".auto-load").html(
                    "No se han encontrado más recetas en esta página..."
                );
                return;
            }
            $(".auto-load").hide();
            $("#post-data").append(data.html);
        });
}

var page = 1;
$(document).scroll(function () {
    if (
        $(window).scrollTop() + window.innerHeight >=
        $(document).height() - 200
    ) {
        if (page < $("#post-data").attr("pages")) {
            page++;
            loadMore(page);
        }
    }
});
