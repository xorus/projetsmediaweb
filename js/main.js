$(window).bind("resize",function(){
    IlluphisaDesignResponse();
})

function IlluphisaDesignResponse() { // wrapper height = window height
	var offset = $("header").height();
    if($(this).width() >= 1200) offset = 0;

	$('#wrapper').css('height', $( window ).height() - offset);
}

$( document ).ready(function() {
	IlluphisaDesignResponse();
});