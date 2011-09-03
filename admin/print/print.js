$("document").ready(function(){
var current_element;
var name="";
$(".casestudy").append("<div class='casestudy-title'>case study</div>");
/* 	$(".exampleinaction").append("<div class='exampleinaction-title'>example in action</div>"); */
	$(".example").append("<div class='example-title'>example</div>");
	$(".review").append("<div class='review-title'>review</div>");
	$(".thoughtprovokingquestion").append("<div class='thoughtprovokingquestion-title'>think about it</div>");
	$(".thoughtprovokingquestion").append("<div class='question2-img'><img src='../../img/question2.jpg' /></div>");
	$(".tip").append("<div class='tip-title'>tip</div>");
	$(".keytakeaway").append("<div class='keytakeaway-title'><img src='../../img/key.jpg' /></div>");
	$(".essentialquestion").append("<div class='essentialquestion-title'><img src='../../img/question1.jpg' /></div>");


$("html").click(function(){
	$("#saves, #pageRightClick").hide();
	$(".selected").each(function(){$(this).removeClass("selected");});
});



var top = $("#item-list").offset().top + $("#item-list").height();
$("#quick-instructions").css("top", top);

$("ul#item-list").sortable({
	stop: function(){updateOrder();}
});
$("#content").sortable();
if ($.browser.webkit) {
$("img").mousedown(function(e){
	if (event.preventDefault) event.preventDefault();
});
}
$("img").draggable();
$("#content p, #content div, #content img, #content h1, #content h2, #content h3, #content h4, #content h5, #content h6, #content span ").blur(function(){$(this).attr("contenteditable", false)});
$("#content p, #content div, #content img, #content h1, #content h2, #content h3, #content h4, #content h5, #content h6, #content span ").live("contextmenu", function(e){
	$(".selected").each(function(){$(this).removeClass('selected');});
	current_element = this;
	$(this).addClass('selected');
	$("#pageRightClick").css({
	"left" : e.pageX,
	"top" : e.pageY	
	}).show();
	$("#removeMe").click(function(){$(current_element).remove();$("#pageRightClick").hide();});
	$("#editMe").click(function(){
		$(current_element).attr("contenteditable", true)
		.removeClass('selected')
		.css({
			"cursor": "text",
			"-moz-user-select": "text",
			"-khtml-user-select": "text",
			"-webkit-user-select": "text",
			"-o-user-select": "text",
			"user-select": "text"
		
		});
		$("#content").sortable({disabled: true});
		$(current_element).focus();
		$("#pageRightClick").hide();});

	return false;
});

$("#content").click(function(){
	$("#pageRightClick").hide();
	$(".selected").each(function(){
		$(this).removeClass('selected');
	});
	$("#content").sortable({disabled: false});

});

$("#save").click(function(){
	
	var name = prompt("Please give this saved version a name. Please note that if the name already exists, it will be replaced with this version.");
	
	data = $("#content").html();
	$.ajax({
		type: "POST",
		url: "actions/save.php",
		data: "name="+name+"&data="+data,
		success: function(phpfile){
			$("#update").html(phpfile);
		}
	});
	saved='true';
});


$("#load").click(function(){
	left = $(this).offset().left;
	$.ajax({
		type: "POST",
		url: "ajax/saves.php",
		success: function(phpfile){
			$("#saves").html(phpfile).css({"left":left}).show();
		
		}
	});
	
});

$(".saved").live("click", function(){
	$.ajax({
		type: "POST",
		url: "ajax/load-saved.php",
		data: "id="+this.id,
		success: function(phpfile){
			$("#content").html(phpfile);
		}
	});

});



});






function updateOrder() {
console.log("updating order");
		data = "sorting=now";
		$("ul#item-list li").each(function(){
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