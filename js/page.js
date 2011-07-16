$(document).ready(function() {
	height = $("#hiddenDiv").height();
	$("textarea#content").css({"height":height});
	$("#menu").draggable();
	$("#menuToggle").toggle(function() {$("#menu").fadeOut();$(this).html("Show Menu");}, function() {$("#menu").fadeIn();$(this).html("Hide Menu");});

	$("#imageCreator").click(function(){
		popup(this.id);	
	});
	$(".close-icon, #fadebackground").click(function(){close();});

});



function popup(id) {
	$.ajax({
		type: "POST",
		url: "ajax/"+id+".php",
		success: function(phpfile){
			$("#popup-content").html(phpfile);
			$("#popup, #fadebackground").fadeIn();
		}
	});
}

function close() {
	$("#popup, #fadebackground").fadeOut();
}

function update_page() { // loads php to update module
	$('form').submit();
	$.ajax({
		type: "POST",
			url: "actions/update_page.php",
			data: $('form').serialize(),
			success: function(phpfile){
			$("#update").html(phpfile);
			}
		});
}
function update_exit() { // loads php to update module
	update_page();
	setTimeout("window.location='../index.php'",2000);

}

function view(page_id) { // loads php to update module
		$('form').submit();
	$.ajax({
		type: "POST",
			url: "actions/update_page.php",
			data: $('form').serialize(),
			success: function(phpfile){
			$("#update").html(phpfile);
			window.location='../../story/index.php?page_id='+page_id;

			}
		});

}