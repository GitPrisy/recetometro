const comment = document.getElementById("send-comment");
if(comment){
    comment.addEventListener("click", function() {
        const user = this.getAttribute('user-name');
        const time = this.getAttribute('time');
        send_comment(user, time);
    });
}


function send_comment(user, time) {
    const url = "/receta/comment";
    const text = document.getElementById("text-comment").value;
    const recipe_id = document.getElementById("recipe-comment").value;
    const data = new URLSearchParams();
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    data.append('_token', csrf);
    data.append("text", text);
    data.append("recipe_id", recipe_id);
    fetch(url, {
        method: "POST",
        body: data,
    }).then(function () {
        $("#comments").prepend(
            '<p class="text-primary fw-bold d-inline-block">'+user+'</p><small class="d-inline-block text-right" style="width: 90%;">'+time+'</small><p>' +
                text +
                "</p><hr>"
        );
        $("#text-comment").val("");
    });
}
