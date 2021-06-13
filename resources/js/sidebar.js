$("#logout-a").click(function (event) {
    event.preventDefault();
    $("#logout-form").submit();
});

$("#sidebar-button-open").on("click", function () {
    $("#sidebar-menu").width("250px");
    $("#sidebar-menu").click(function (e) {
        e.stopPropagation();
    });
});

$("#sidebar-button-close").on("click", function () {
    $("#sidebar-menu").width("0px");
});

$(document).click(function () {
    if ($("#sidebar-menu").width() >= 200) {
        $("#sidebar-menu").width("0px");
    }
});

$(document).ready(function(){
	$('.go-top').click(function(){
		$('body, html').animate({
			scrollTop: '0px'
		}, 300);
	});

	$(window).scroll(function(){
		if( $(this).scrollTop() > 0 ){
			$('.go-top').slideDown(300);
		} else {
			$('.go-top').slideUp(300);
		}
	});

});