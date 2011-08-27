$("document").ready(function(){
	$(".choice").live("click", showData);
	$(".close-icon, #fadebackground").live("click", function(){close();});	
});

var showData = function(){
	open(800,600);
	story = this.id;
	$("#popup-content").load("ajax/worksheet-data.php?story="+story);
}

function open(width, height) {
	$("popup").css({
		"width" : width,
		"height" : height
	});
	$("#popup, #fadebackground").fadeIn();
}

function close(){
	$("#popup-content").html("");
	$("#popup, #fadebackground").fadeOut();
}