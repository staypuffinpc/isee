var refresh = false;

function update_height() {

updates_height = $("#updates").height()-36;
	
	$("#updates .content").css({
	"height": updates_height,
	"margin-right": "0px",
	"margin-top" : "0px",
	"padding-top" : "5px"
	
	
	});
}

function update_classes_height () {
	classActionsHeight = $("#class-actions").height();
	height=window.innerHeight;
	classesHeight = height-classActionsHeight-54;
	$("#classes").css("height",classesHeight);
}

function update_stories_height () {
	storiesHeight = $("#story-actions").height();
	storyEditHeight = $("#story-edit").height();
	height=window.innerHeight;
	storiesHeight = height-storiesHeight-54;
	$("#stories").css("height",storiesHeight);
	$("#stories .content").css({
		"height": storiesHeight-74,
		"margin": "0px"
		
		
	});
}

function close() { // closes popup
	if (refresh) {window.location = "index.php";}
	$("#popup-content").html("");
	$("#fadebackground, #popup").fadeOut();
}

function open(width, height) { //opens popup
	$("#popup").css({
		"width": width,
		"height": height,
		"left" : "50%",
		"top" : "50%",
		"margin-left" : -1*width/2,
		"margin-top" :-1*height/2
	});
	$("#fadebackground, #popup").fadeIn();
}

function create_story() {
	if(!$("#module_name").val()) {alert("You must have a story name");$("#module_name_label").css("color" , "red");return false;}
	
	data = $("form").serialize();
	$.ajax({
		type: "POST",
			url: "actions/create_story.php",
			data: data,
			success: function(phpfile){
			$("#update").html(phpfile);}
		});
	window.location = "../admin/index.php";
}

function delete_story(story){
	var answer = confirm("This action cannot be undone. All content associated with this story will be erased and unavailable to all authors and students. Are you sure you want to delete this story? ")
		if(answer) {
			$.ajax({
				type: 	"POST",
				url:	"actions/delete_story.php",
				data:	"story="+story,
				success: function(phpfile){
					$("#popup-content").append(phpfile);
					refresh = true;
					open(300, 300);
					
					}
					
			});
			
		}
		else {}
	
}

function create_class() {
	if(!$("#class_name").val()) {alert("You must have a class name");$("#class_name_label").css("color" , "red");return false;}
	
	data = $("form").serialize();
	$.ajax({
		type: "POST",
			url: "actions/create_class.php",
			data: data,
			success: function(phpfile){
			$("#update").append(phpfile);
			close();
			}
		});

}

$(document).ready(function() {
	update_height();
	update_classes_height();
	update_stories_height();
	$(window).resize(function(){
		update_height();
		update_classes_height();
		update_stories_height();
	});


	$("#logoutFromMenu").click(function(){window.location="../logout.php";});//logout event listener
	$("#new-story").click(function(){
		width = 300;
		height = 180;
		open(width, height);
		$("#popup-content").load("ajax/new-story.php");
	});
	
	$("#create-new-class").click(function(){
		width = 600;
		height = 400;
		open(width, height);
		$("#popup-content").load("ajax/create-new-class.php");
	});
	
	$("#fadebackground, .close-icon").click(close);
	
	$("html").keyup(function(e){
		if (e.keyCode == '27') //escape event listener
		{
			if($("#fadebackground:visible").length !==0)
				{close();} // if a popup is up, this closes it
		}
		if (e.keyCode == '112') {$("#update").toggle();}
	
	});
	$("#enroll-in-new-class").click(function(){alert("I'm sorry, this button is not yet functional.");});


});

