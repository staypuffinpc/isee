

$(document).ready(function() {
$("#item-list").load("ajax/assessmentList.php");
var data = "action=sorting";		

$("#item-list").sortable({
	start: function(event, ui){$(".ui-state-highlight").css("height", $(ui.helper).height());},
	helper: "clone",
	opacity: 0.4,
	revert: true,
	placeholder: 'ui-state-highlight',
	stop: function() {
		updateOrder();
	}
});

$(":input[type=text], input[type=radio]").attr("disabled", true);
$("textarea").attr({"disabled": true});

$(".type, .textShort").live("click", function(){
	$(this).next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle().next().slideToggle();

});

$(".ce").live("focus", function(){$("#item-list").sortable({"disabled": true});});
$(".ce").live("mouseover", function(){$("#item-list").sortable({"disabled": true});});
$(".ce").live("mouseout", function(){$("#item-list").sortable({"disabled": false});});

$(".ce").live("blur", function(){
	$("#item-list").sortable({"disabled": false});
	item = this;
	text = $(this).html();
	info=$(this).attr("class").split(" ");
	$.ajax({
		type: "POST",
		url: "actions/updateItem.php",
		data: "text="+text+"&field="+info[1]+"&id="+info[2],
		success: function(phpfile) {
			$("#update").html(phpfile);
			if (info[1] == "text") {
				if (text.length > 88) {
				text = text.substr(0, 87)+" . . . ";
				}
				$(item).parent().prev().text(" - "+text);
			}
		}
	});
});

$("select").live("change", function(){
	id = $(this).attr('class');
	page = $(this).val();
	$.ajax({
		type: "POST",
		url: "actions/updatePage.php",
		data: "id="+id+"&page="+page,
		success: function(phpfile) {
			$("#update").html(phpfile);
		
		}
		
	
	});
});

$("input[type=checkbox]").live("change", function(){
	id = $(this).attr("class");
	if ($(this).attr("checked") == "checked") {
		embedded = 1;
		$(this).parent().parent().prev().prev().prev().prev().prev().prev().html("embedded").css({"padding": "1px", "display": "none"});
	} 
	else {
	embedded = 0;
			$(this).parent().parent().prev().prev().prev().prev().prev().prev().html("").css({"padding": "0px", "display": "none"});

	}
	
	$.ajax({
		type: "POST",
		url: "actions/updateEmbedded.php",
		data: "embedded="+embedded+"&id="+id,
		success: function(phpfile) {
			$("#update").html(phpfile);
		}
	});
});	

$(".ce").live("keypress", function(e){
		if (e.keyCode == "13") {
			e.preventDefault();
			$(this).blur();
			$("#item-list").sortable({"disabled": false});
		}
});
$(".ce").live("keyup", function(e){
	if (e.keyCode == '27') {$(this).blur();}
});

$(".newItem").live("click", function(){
	type = this.id;
	$.ajax({
		type: "POST",
		url: "actions/newItem.php",
		data: "type="+type,
		success: function(phpfile) {
			$("#update").html(phpfile);
		}
	});
});

$(".delete").live("click", function(){
	var item=this;
	var answer = confirm("This action cannot be undone.Are you sure you want to delete this item? ")
	if(answer){
	assessment_id = this.id.substr(6);
	$(this).parent().remove();
	$.ajax({
		type: "POST",
		url: "actions/delete_item.php",
		data: "assessment_id="+assessment_id,
		success: function(phpfile){
			$("#update").html(phpfile);
			updateOrder();
			
		}
	});
	}
});
$("html").keyup(function(e){
	if (e.keyCode == '112') {$("#update").toggle();}
	
});

/* ------------------------------handlers--------------------------- */
var logoutFromMenu = function(){window.location="../../logout.php";};


$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();});


$("#update").draggable();

function updateOrder() {
console.log("updating order");
		$("ul#item-list li").each(function(){
			data = data+"&"+this.id+"="+$(this).index();
				
		});
		$('li > div.number').each(function(i) {
			var $this = $(this); 
   			$this.text(i+1+". ");
		});

		$.ajax({
			type: "POST",
			url: "actions/update_order.php",
			data: data,
			success: function(phpfile){
			$("#update").append(phpfile);}
		});	
}




$("#logoutFromMenu").click(logoutFromMenu);



}); 