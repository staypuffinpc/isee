$(document).ready(function() {
	height = $("#hiddenDiv").height();
	$("textarea#content").css({"height":height});
	$("#menu").draggable();
	$("#menuToggle").toggle(function() {$("#menu").fadeOut();$(this).html("Show Menu");}, function() {$("#menu").fadeIn();$(this).html("Hide Menu");});
	$("#borrowToggle").toggle(
		function(){
			$(this).html("Hide Content Borrower");
			xinha_editors.content.sizeEditor(window.innerWidth/2-210); 
			xinha_editors.references.sizeEditor(window.innerWidth/2-210); 

			$("#page1").css({"width" : "50%", "margin-left" : 0, "left" : 0});
			$("#borrowedContentPane").show();
		},
		function(){
			$(this).html("View Content Borrower");
			xinha_editors.content.sizeEditor(694); 
			xinha_editors.references.sizeEditor(694); 
			$("#page1").animate({"width" : "904", "margin-left" : "-452px", "left" : "50%"});
			$("#borrowedContentPane").hide();
		}
	
	);
	$("#imageCreator").click(function(){
		popup(this.id, 1100, 600);	
	});
	
	$("#contentBorrower").click(function(){
		popup(this.id, 1100, 600);
	});
	
	$(".close-icon, #fadebackground").click(function(){close();});
	$("#navigation_choices").sortable({
		placeholder: 'ui-state-highlight',
		stop: function() {updateNavigationOrder();}
	});
	$("#addSubheading").click(function(){addSubheading();});
	$(".page_stem, .page_link, .page_punctuation").live("click", function(){$(this).attr('contenteditable','true');this.focus(); });
	$(".page_stem, .page_link, .page_punctuation").keypress(function(e){
		if (e.keyCode == 13) {$(this).blur();}
	});
	
	$(".page_stem, .page_link, .page_punctuation").live("blur", function(){
		theclass = $(this).attr("class");
		theclassarray = theclass.split(" ");
		text = $(this).html();

	$.ajax({
			type: "POST",
			url: "actions/updateLinks.php",
			data: "id="+theclassarray[1]+"&text="+text+"&class="+theclassarray[0],
			success: function(phpfile) {
				$("#update").html(phpfile);
			}
		});
	});
	
	$(".deleteLink").live("click", function(){
		parent = this;
		var answer = confirm("This action cannot be undone. Are you sure you want to delete this item?");
		if (answer) {
			id = this.id.substr(6);
			$.ajax({
				type: "POST",
				url: "actions/deleteLink.php",
				data: "id="+id,
				success: function(phpfile) {
					$("#update").html(phpfile);
					$(parent).parent().remove();			
				}
			});
		}
	});
});

function addSubheading() {
	var text = prompt("Please enter Subheading text.");
	$.ajax({
		type: "POST",
		url: "actions/addSubheading.php",
		data: "text="+text,
		success: function(phpfile){
			$("#navigation_choices").append(phpfile);
		}
	});
}

function updateNavigationOrder() {
	data = "action=sorting";
	$("ul#navigation_choices li").each(function(){
		data = data+"&"+this.id+"="+$(this).index();
	});
	$.ajax({
		type: "POST",
		url: "actions/update_order.php",
		data: data,
		success: function(phpfile){
		$("#update").append(phpfile);}
	});	
}

function popup(id, width, height) {
	$("#popup").css({
		"width": width,
		"height": height,
		"left" : "50%",
		"top" : "50%",
		"margin-left" : -1*width/2,
		"margin-top" :-1*height/2
	});
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