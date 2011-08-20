var definitionShow = "off";

function line(parent, child, relation_id) { //draws lines
	
	if ($("#"+child).length && $("#"+parent).length && $("#"+parent).hasClass("inactive") == false) {
	var parentPos = $("#"+parent).offset();
	var childPos = $("#"+child).offset();
		
	var theight = childPos.top - parentPos.top;
	
	twidth = parentPos.left - childPos.left;
	height = theight*theight + twidth*twidth;
	
	myheight = Math.sqrt(height);
	myheight = Math.round(myheight);
	
	angle = Math.asin(theight/myheight);
	angle = angle*180/Math.PI;
	
	if (childPos.left>parentPos.left) {angle = angle-90;} else {angle= Math.abs(angle-90);}
	half = myheight/2;
	
	h = Math.cos(angle*Math.PI/180)*half;
	
	newtop = parentPos.top-half+h+25-38;
	left = childPos.left+((parentPos.left-childPos.left)/2)+100;
	
	
	$("#line"+relation_id).css({
		"height" : myheight,
		"top" : newtop,
		"left" : left,
		"-webkit-transform" : "rotate("+angle+"deg)", 
		"-moz-transform" :  "rotate("+angle+"deg)"
	});
	
	$("#arrow"+relation_id).css({"top": half});
	
	if ($("#"+child).hasClass("inactive")) {
		$("#line"+relation_id).css({"background-color": "#cccccc", "z-index" : 1});
		$("#line"+relation_id+" .arrow").css({"background-image": "url(../img/arrowg.png)" });
	}
}
else {$("#line"+relation_id).hide();}
}

function main() {
	$.ajax({
		type: "POST",
		url: "ajax/assessmentEm.php",
/* 		data: "user="+user+"&page="+page, */
		success: function(phpfile) {
		/*
alert(user);
		alert(page);
*/
		$("#assessment").html(phpfile);
	}
	
	
	});

	/* $("#assessment").load("ajax/assessmentEm.php"); */

	$("#footer li img, #footer li p").css("opacity",".5");
	$("#page2").hide("slow", function(){$("#page1").fadeIn();});
	$("#back-button").hide();
	status = 0;
	$('#page-instructions').hide();
}

function close() {
	$("#fadebackground, .popup, #user").fadeOut();
	definitionShow = "off";
}

function update_answer (user, name, value, module){
	$.ajax({
   		type: "GET",
   		url: "actions/update_answer.php",
   		data: "user="+user+"&name="+name+"&value="+value+"&module="+module,
   		success: function(phpfile){
   			$("#update").html(phpfile);
   			console.log("function running");
		} //end anonymous function
	}); //end ajax call
}

function definition (term)
{		
	word = $(term).html();
$.ajax({
		
   		type: "GET",
   		url: "actions/get_definition.php",
   		data: "term="+word,
   		success: function(phpfile){
   			var p = $(term);
			var position = p.position();
			width = $(term).width();
			if (position.top > 300) {var top = position.top-175;} else {var top = position.top+60;}
			if (position.left > 800) {var left = position.left+width-200;} else {var left = position.left;}
			
			$("#definition").animate({"top" : top,"left" :left});

			$("#definition-content").html(phpfile);
			$("#definition").fadeIn();
			$("#definition").draggable();
			definitionShow = "on";
		} //end anonymous function
	}); //end ajax call	
}

function assessment_announce(n) {
	$("body").append("<audio autoplay='true'><source src='unlock.wav' type='audio/wav' />Your browser does not support the audio element.</audio>");
	$("#assessment_announce_window").slideToggle().delay(1000).fadeOut(5000);
}

function instructions() {
	$("#fadebackground").fadeIn();
	$("#popup").fadeIn();


}

function google_analytics() {
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23109189-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
}

function showPageInstructions() {
if ($("#page1:visible").length !==0) {return;}
			else {
				$("#page-instructions").toggle();
				if ($("#page-instructions:visible").length !=0) {instructionsShowing = true;}
				else {instructionsShowing = false;}
				$.ajax({
					type: 	"POST",
					url:	"actions/instructionsShowing.php",
					data:	"instructionsShowing="+instructionsShowing,
					success:function(phpfile){
						$("#update").html(phpfile);
					}
				});
			}
}

$(document).ready(function(){
	Scroller('viewport');
	Scroller('instructions');
	google_analytics();
	$("a.tracker").click(function(){
		_gaq.push(['_trackEvent', 'Navigation link', this.id, this.id+' navigation link was clicked']);
	});
	$("#page1").show();
	$("#page-instructions").draggable();
	//footer event listner
	$("#footer li").click(function(){
		$("textarea, :input").blur();
		_gaq.push(['_trackEvent', 'Footer', this.id, this.id+' in the footer was clicked.']);
		if (status !== this.id) {
		if (this.id == "map") {$("#page2").css({"margin-left":0, "left":0});}
			else {$("#page2").css({"margin-left":"-350px", "left":"50%"});}
		
		$("#footer li img, #footer li p").css("opacity","0.5");
		
		if ($("#page1:visible").length !== 0) {
			$("#"+this.id+" img, #"+this.id+" p").css("opacity","1");
			$("#back-button").show();
			$("#page1").hide("fast", function(){$("#page2").show();});
			$("#page2").load("ajax/"+this.id+".php");
			$("#page-instructions-text").html($('.'+this.id+'Instructions').html());
			if (instructionsShowing== true) {$("#page-instructions").show();}
			status = this.id;
		}
		else {
			$("#"+this.id+" img, #"+this.id+" p").css("opacity","1");
			$("#page-instructions").hide();
			$("#page2").html(" ");
			$("#page2").hide("fast",function(){$("#page2").show();});
			$("#page2").load("ajax/"+this.id+".php");
			$("#page-instructions-text").html($('.'+this.id+'Instructions').html());
			if (instructionsShowing == true) {$("#page-instructions").show();}
			status = this.id;
		}
		}
		else {main();}
	});

	$("#back-button").click(function(){$("textarea, :input").blur();main();}); //back button event listener
	
	/*  key listener */
	$('html').keyup(function(event) {
		if (event.target.nodeName == "TEXTAREA" || event.target.nodeName == "INPUT") {return false;}
		if (event.keyCode == '68'){ // m key
			window.location="../dashboard/index.php";
		}
		
		if (event.keyCode == '27') {// escape key
		$("textarea, :input").blur();

		if($("#fadebackground:visible").length !==0)
			{close();} // if a popup is up, this closes it
			else { // if not then it escapes the navigation
			if ($("#page1:visible").length !==0) {return;}
			else {main();}
			}
		}
		if (event.keyCode == '73') { // i key
			showPageInstructions();
		}
	
	
	});//escape key event listener
	
		
	$("#options-button").click(function() { // options-button event listener
		$("textarea, :input").blur();
		$("#fadebackground").fadeIn();
		$("#user").slideToggle("slow");
	});
		
	$("#fadebackground,.close-icon").click(function(){close();}); //close event listener
	$("#mainMenu").click(function(){window.location="../dashboard/index.php";});//main menu event listener
	$("#logout").click(function(){window.location="../logout.php";});//logout event listener
		
	$(".keyterm").click(function(){
		
		definition(this);
	});
	//ajax loading div
/* 	$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();}); */

	$('#ajax').hide().ajaxStart(function() {$(this).css({"opacity": "0.7"}).fadeIn();}).ajaxStop(function() {$(this).fadeOut();});
	
	$("#viewinstructions").click(function(){$("#user").hide();instructions();});
	$("#progressClear").click(function(){
		var answer = confirm("This action cannot be undone. All your progress will be erased. Are you sure you want to clear your progress? ")
		if(answer) {
			$("#update").load("actions/progressClear.php");
		}
		else {}
	
	});
	$("#assessmentClear").click(function(){
		var answer = confirm("This action cannot be undone. All your answers will be erased. Are you sure you want to clear your answers? ")
		if(answer) {
			$("#update").load("actions/assessmentClear.php");
		}
		else {}
	
	});
	
	$(":input, textarea").live('change', function(){
		update_answer(user,this.name,this.value,module);
	});
	
	
	$(".casestudy").append("<div class='casestudy-title'>case study</div>");
/* 	$(".exampleinaction").append("<div class='exampleinaction-title'>example in action</div>"); */
	$(".example, .exampleinaction").append("<div class='example-title'>example</div>");
	$(".review").append("<div class='review-title'>review</div>");
	$(".thoughtprovokingquestion").append("<div class='thoughtprovokingquestion-title'>think about it</div>");
	$(".thoughtprovokingquestion").append("<div class='question2-img'><img src='../img/question2.jpg' /></div>");
	$(".tip").append("<div class='tip-title'>tip</div>");
	$(".keytakeaway").append("<div class='keytakeaway-title'><img src='../img/key.jpg' /></div>");
	$(".essentialquestion").append("<div class='essentialquestion-title'><img src='../img/question1.jpg' /></div>");
	

});




	
