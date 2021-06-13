function vote_up_handler(id) {
    console.log('up');
    const url = '/receta/' + id + '/vote-up';
    const data = new URLSearchParams();
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    data.append('_token', csrf);
    fetch(url, {
        method: "POST",
        body: data,
    }).then(function(res) {
        const votos = document.getElementsByClassName('vote');

        for (let i = 0; i < votos.length; i++) {
            let voto = votos[i];
            if (voto.getAttribute('recipe-id') == id) {
                let recipe_votes = parseInt(voto.getAttribute('recipe-votes')) + 1;

                voto.setAttribute('recipe-votes', recipe_votes);
                voto.innerHTML = "<i class='fas fa-heart'></i> " + recipe_votes;
            }
        }
    })
}

function vote_down_handler(id) {
    console.log('down');
    const url = '/receta/' + id + '/vote-down';
    const data = new URLSearchParams();
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    data.append('_token', csrf);
    fetch(url, {
        method: "POST",
        body: data,
    }).then(function(res) {
        const votos = document.getElementsByClassName('vote');

        for (let i = 0; i < votos.length; i++) {
            let voto = votos[i];
            if (voto.getAttribute('recipe-id') == id) {
                let recipe_votes = parseInt(voto.getAttribute('recipe-votes')) - 1;

                voto.setAttribute('recipe-votes', recipe_votes);
                voto.innerHTML = "<i class='far fa-heart'></i> " + recipe_votes;
            }
        }

    })

}

// $(".vote-up").each(function(){
//     $(this).one("click", vote_up_handler)
// });
// $(".vote-down").each(function(){
//     $(this).one("click", vote_down_handler)
// });











jQuery.fn.clickToggle = function(a, b) {
    return this.on("click", function(ev) { [b, a][this.$_io ^= 1].call(this, ev) })
};
  

$(".vote-down").each(function(){
    $(this).clickToggle(function(ev) {
        const id = $(this).attr('recipe-id');
        vote_down_handler(id);
    }, 
    function(ev) {
        const id = $(this).attr('recipe-id');
        vote_up_handler(id);
    });
});

$(".vote-up").each(function(){
    $(this).clickToggle(function(ev) {
        const id = $(this).attr('recipe-id');
        vote_up_handler(id);
    }, 
    function(ev) {
        const id = $(this).attr('recipe-id');
        vote_down_handler(id);
    });
});