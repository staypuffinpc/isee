$("document").ready(function(){
	$(".choice").live("click", showData);
	$(".close-icon, #fadebackground").live("click", function(){close();});	
});

var showData = function(){
	open(800,600);
	module = this.id;
	$("#popup-content").load("ajax/assessment-data.php?module="+module);
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