$(document).ready(function() {
var top;
var bottom;
var left;
var right;
var mouse_down = false;
var meta_down;
var multiple_drag;
var start_pos;
var currentPageId = 1;

/* ------------------------------handlers--------------------------- */
var togglePageClass = function(e) {
	unbindThemAll();
	var selectorKey = 0;
	if ($.client.os == "Mac") {selectorKey = e.metaKey;}
	if ($.client.os !== "Mac") {selectorKey = e.ctrlKey;}
	if (selectorKey) {
		$(this).toggleClass("selected"); 
		$("#update").append("selected");
	}
	bindThemAll();
};

var logoutFromMenu = function(){window.location="../logout.php";};

var editModule= function(){ 
	width = 400;
	height = 250;
	open(width, height);
	$("#popup-content").load("ajax/"+this.id+".php");
};

var permissions = function(e){
	width = 400;
	height = 400;
	open(width, height);
	$("#popup-content").load("ajax/"+this.id+".php");


};

var termPopup = function(){ 
	width = 1000;
	height = 500;
	open(width, height);
	open();
	$("#popup-content").load("ajax/term.php");
};

var assessmentDataPopup = function(e){ // edit button function
/* 	e.stopPropagation(); */
	width = 1000;
	height = 500;
	open(width, height);
	$("#popup-content").load("ajax/assessment-data.php");
};

var newPage = function(){ 
	unbindThemAll();
	$.ajax({
		type: "POST",
			url: "ajax/new_page.php",
			success: function(phpfile){
			$("#update").append(phpfile);
			}
		});	
	bindThemAll();
};

var keyboard = function(e) {if (e.keyCode == '27') //escape event listener
		{
		if($("#fadebackground:visible").length !==0)
			{close();} // if a popup is up, this closes it
		}
		if (e.keyCode == '112') {$("#update").toggle();}
};

var selectorStart = function(e){
	mouse_down = true;
	$("#selector").css("background-color", "#666666");
	$(".page").removeClass("selected");
	$("#selector").hide();
	left = e.pageX;
	top = e.pageY;
	
	return false;
}; 

var selectorMove = function(e){
	if (mouse_down) {
		right = e.pageX;
		bottom = e.pageY;
		width = Math.abs(right-left);
		height = Math.abs(bottom-top);
		if (left>right) {l = right;} else {l=left;}
		if (bottom<top) {t = bottom;} else {t=top;}
		$("#selector").css({
			"top":t,
			"left":l,
			"width":width,
			"height":height
		}).show();
	}
return false;
};


var selectorEnd = function(e){
	if (mouse_down) {
		mouse_down = false;
		right = e.pageX;
		bottom = e.pageY;
		width = Math.abs(right-left);
		height = Math.abs(bottom-top);
		if (left>right) {left = right;}
		if (bottom<top) {top = bottom;}
		
		t = Math.floor(top/60)*60;
 		l = Math.floor(left/210)*210;
 		
 		width = width + left - l;
 		height = height + top - t;
		width = Math.ceil(width/210)*210;
 		height = Math.ceil(height/60)*60;
 		if (width < 210) {width = 210;}
 		if (height < 60) {height = 60;}
		
		$("#selector").css({
			"top":t,
			"left":l,
			"width":width,
			"height":height
		}).hide();
		
		$.ajax({
				type: "POST",
					url: "actions/select_pages.php",
					data: "top="+t+"&left="+l+"&width="+width+"&height="+height,
					success: function(phpfile){
					$("#update").html(phpfile);}
				});
		return false;
	}
	
}; 

var editPage = function(){
	id=this.id.substr(4);
	window.location="page/page.php?page_id="+id;
};

var deletePage = function(e){
	e.stopImmediatePropagation();
	unbindThemAll();
	id=this.id.substr(6);
	var answer = confirm("This action cannot be undone. All associated links to this page will also be deleted. Are you sure you want to delete this page? ")
		if(answer) {
			$("#update").load("actions/delete_page.php?page_id="+id);
			$("#"+id).fadeOut();
		}
		else {}
	bindThemAll();
};

var pageRelation = function(e){
	e.stopImmediatePropagation();
	relation_id = this.id.substr(5);
	unbindThemAll();
	width = 700;
	height = 150;
	open(width, height);
	$.ajax({
		type: "POST",
			url: "ajax/page_relation.php",
			data: "relation_id="+relation_id,
			success: function(phpfile){
			$("#popup-content").append(phpfile);
			}
		});
	bindThemAll();
};


var relatePage = function(){
	$(this).draggable({
	revert: true,
	start: function(event, ui) {unbindThemAll();},
	stop: function(event, ui) {bindThemAll();}
});
};

var closeOnClick = function(){close();}; 

var termChange = function(){
	console.log("function triggered");
	$('#edit_this_term').submit();
	value=$('#edit_this_term').serialize();
	term_id = $("input#term_id").val();
	term = $("input#term").val();
	definition = $("textarea#definition").val();
	
	$('.'+term_id).html(term);
	$('.'+term_id+'D').html(definition);

	$.ajax({
		type: "POST",
		url: "actions/term_change.php",
		data: value,
		success: function(phpfile){
		$("#update-status").html(phpfile);
		}
	});
};

var closeOnClick = function(){close();}; 

var newTerm = function() {
	console.log("new term clicked");
	$.ajax({
		type: "POST",
		url: "actions/new_term.php",
		success: function(phpfile){
		$("#popup-content").load('ajax/term.php');
		}
	});

};

var assessment = function(){
	width = 1000;
	height = 600;
	open(width, height);
	$("#popup-content").load("ajax/"+this.id+".php");


};

var newItem = function(){
	$("#backAssessment").show();
	$("#assessment-shutters").scrollTo("#step1",800);
	$("#newItem").hide();
};

var backAssessment = function(){
	$("#backAssessment, #tostep1, #tostep3, #addItem, #saveItem	").hide();
	$("#newItem").show();
	$("#assessmentList").load("ajax/assessmentList.php");
	$("#assessment-shutters").scrollTo("#assessmentList" ,800);

};

var fillInTheBlank = function(){
	$("#step2").load("ajax/fillInTheBlank.php");
	$("#assessment-shutters").scrollTo("#step2",800);
	$("#tostep3").show();
};

var shortAnswer = function(){
	$("#step2").load("ajax/shortAnswer.php");
	$("#assessment-shutters").scrollTo("#step2",800);
	$("#tostep3").show();
};

var trueOrFalse = function(){
	$("#step2").load("ajax/trueOrFalse.php");
	$("#assessment-shutters").scrollTo("#step2",800);
	$("#tostep3").show();
};

var multipleChoice = function(){
	$("#step2").load("ajax/multipleChoice.php");
	$("#assessment-shutters").scrollTo("#step2",800);
	$("#tostep3").show();
};

var tostep3 = function() {
	stem = $("#stem").val();
	assessment_id = $("#assessment_id").val();
	data = "assessment_id="+assessment_id+"&stem="+stem;
	
	for (i=0;i<8;i++) {
	if ($("#choice"+i).val()) {data=data+"&choice"+i+"="+$("#choice"+i).val();}
	}
	
	$.ajax({
		type: "POST",
			url: "ajax/step3.php",
			data: data,
			success: function(phpfile){
				$("#step3").html(phpfile);
				$("#assessment-shutters").scrollTo("#step3",800);
				$("#tostep3").hide();
				$("#addItem").show();
			}
		});
};

var addItem = function() {
	assessment_id = $("#assessment_id").val();
	assessment_answer = $("#assessment_answer").val();
	assessment_page = $("#assessment_page").val();
	
	$.ajax({
		type: "POST",
			url: "ajax/finish_assessment.php",
			data: "assessment_id="+assessment_id+"&assessment_answer="+assessment_answer+"&assessment_page="+assessment_page,
			success: function(phpfile){
				$("#step4").html(phpfile);
				
			}
		});
	$("#assessmentList").load("ajax/assessmentList.php");
				$("#assessment-shutters").scrollTo("#assessmentList",800);
	$("#addItem, #backAssessment").hide();
	$("#newItem").show();
	
};

var editItem = function() {
	$("#assessment-shutters").scrollTo("#step4",800);
$("#newItem").hide();
$("#backAssessment, #saveItem").show();
	id = this.id.substr(4);
	$.ajax({
		type: "POST",
		url: "ajax/edit_item.php",
		data: "id="+id,
		success: function(phpfile) {
			$("#step4").html(phpfile);
		}
	});
};

var saveItem = function() {
	console.log("hello");
	assessment_id = $("#assessment_idEdit").val();
	assessment_text = $("#stemEdit").val();
	assessment_page = $("#assessment_pageEdit").val();
	assessment_answer = $("#assessment_answerEdit").val();
	data = "assessment_id="+assessment_id+"&assessment_answer="+assessment_answer+"&assessment_page="+assessment_page+"&assessment_text="+assessment_text;
	
	for (i=0;i<8;i++) {
		if ($("#choice"+i).val()) {data=data+"&choice"+i+"="+$("#choice"+i).val();}
	}
	
	$.ajax({
		type: "POST",
		url: "actions/save_item.php",
		data: data,
		success: function(phpfile) {
			$("#update").html(phpfile);
			$("#saveItemStatus").text("This item has been saved.");
		}
	});
};

var hidePageRightClick = function() {
	$("#pageRightClick").hide();
};

var editPage2 = function() {
	console.log(currentPageId);
	window.location="page/page.php?page_id="+currentPageId;
};

/* --------------------------end-handlers--------------------------- */

resizeGrid(lowest, rightest);
$(window).resize(function(){
	resizeGrid(lowest, rightest);
});

$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();});


$(".page").bind("contextmenu", function(e){
	currentPageId = this.id;
	console.log(currentPageId);
	$("#pageRightClick").css({
	"left" : e.pageX,
	"top" : e.pageY	
	}).show();
	return false;
});

/* actions for dragging pages */
$(".page").live('mouseover', function () {
	
	$(this).draggable({
	start: function(event, ui) {
		
		if ($(this).hasClass('selected')) {
			multiple_drag = true;
			start_pos = $(this).position()
			$(this).addClass('dragger');
		}
		else {$(".selected").removeClass('selected');}
		unbindThemAll();
		$(".line").fadeOut();
	},
	drag: function(event, ui) {
/* 		$.ajax({type: "POST", url: "actions/change_lines.php", data: "page="+this.id, success: function(phpfile){$("#update").append(phpfile);}}); */
	},
	stop: function(event, ui) {
		bindThemAll();
		$(this).removeClass('temp-new-page');
 		var Stoppos = $(this).position();
 		
 		t = Math.round(Stoppos.top/60)*60;
 		l = Math.round(Stoppos.left/210)*210;
 		if (t<120){t=120;}
 		if (l<210){l=210;} 
 		$(this).css({"top" : t, "left" : l});
 		if (multiple_drag) {
 			top_dis = t-start_pos.top;
 			left_dis = l- start_pos.left;
 			dragger = false;
 			movingMany(top_dis, left_dis, dragger);
 			
 		}
 		
			$.ajax({
				type: "POST",
				url: "actions/change_location.php",
				data: "page="+this.id+"&top="+t+"&left="+l,
				success: function(phpfile){
				$("#update").append(phpfile);}
			});
		
		if (multiple_drag) {/* location.reload(true); */}
		$(".selected").removeClass('dragger');
		$(".line").fadeIn();
	}
});
});


/* sets pages and droppable regions */
$(".page").droppable({
	
	accept: ".relate",
	drop: function(event, ui) {
	child = this.id;
	parent = $(ui.draggable).attr("id").substr(6);
	
	$.ajax({
		type: "POST",
			url: "actions/add_relation.php",
			data: "parent="+parent+"&child="+child,
			success: function(phpfile){
			$("#update").append(phpfile);}
		});
	}

});

$("#fadebackground, .close-icon").click(closeOnClick)




$("#update").draggable();




bindThemAll();

function bindThemAll() {
	console.log("bound");
	$("body").bind("click",hidePageRightClick);
	$(".page").click(togglePageClass);
	$("#logoutFromMenu").click(logoutFromMenu);
	$("#edit").click(editModule);
	$("#permissions").click(permissions);
	$("#terms").click(termPopup);
	$("#assessment_data").click(assessmentDataPopup);
	$("#new_page").click(newPage);
	$('html').keyup(keyboard);
	$("#mapgrid").mousedown(selectorStart);
	$("#mapgrid").mousemove(selectorMove);
	$("html").mouseup(selectorEnd);
	$(".edit-page").live('click', editPage);
	$("#editPage2").live('click', editPage2);
	$(".delete").live('click', deletePage);
	$(".arrow").live('click', pageRelation);
	$(".relate").live('mouseover', relatePage);
	$("#term-change").live('click', termChange);
	$("#new-term").live('click', newTerm);
	$("#assessment").click(assessment);
	$("#newItem").live('click', newItem);
	$("#backAssessment").live('click', backAssessment);
	$("#fillInTheBlank").live('click',fillInTheBlank);
	$("#shortAnswer").live('click',shortAnswer);
	$("#trueOrFalse").live('click',trueOrFalse);
	$("#multipleChoice").live('click',multipleChoice);
	$("#tostep3").live('click', tostep3);
	$("#addItem").live('click', addItem);
	$(".editItem").live('click', editItem);
	$("#saveItem").live('click', saveItem);

}

function unbindThemAll() {
	console.log("unbound");
	$("body").unbind("click",hidePageRightClick);
	$(".page").unbind('click', togglePageClass);
	$("#logoutFromMenu").unbind('click', logoutFromMenu);
	$("#edit").unbind('click', editModule);
	$("#permissions").unbind('click', permissions);
	$("#terms").unbind('click', termPopup);
	$("#assessment_data").unbind('click', assessmentDataPopup);
	$("#new_page").unbind('click', newPage);
	$('html').unbind('keyup', keyboard);
	$("#mapgrid").unbind('mousedown', selectorStart);
	$("#mapgrid").unbind('mousemove', selectorMove);
	$("html").unbind('mouseup', selectorEnd);
	$(".edit-page").unbind('click', editPage);
	$(".delete").unbind('click', deletePage);
	$(".arrow").unbind('click', pageRelation);
	$(".relate").unbind('mouseover', relatePage);
	$("#term-change").unbind('click', termChange);
	$("#new-term").unbind();
	$("#assessment").unbind();
	$("#backAssessment").unbind();
	$("#fillInTheBlank").unbind();
	$("#shortAnswer").unbind();
	$("#trueOrFalse").unbind();
	$("#multipleChoice").unbind();
	$("#tostep3").unbind();
	$("#addItem").unbind();
	$(".editItem").unbind();
	$("#saveItem").unbind();

}



}); //end of document.ready




function movingMany (top_dis, left_dis, dragger) {
	$(".selected").each(function(){
	 			
	 			if (!$(this).hasClass('dragger')) {
	 			pos_page = $(this).position();
	 			new_top = pos_page.top+top_dis;
	 			new_left =pos_page.left+left_dis ;
	 			if (new_top<120) {new_top = 120;/* top_dis = top_dis + 120 + new_top; dragger = true; movingMany(top_dis, left_dis, dragger); return; */}
	 			if (new_left<210) {new_left = 210;/* left_dis = left_dis + 210 + new_left; dragger = true; movingMany(top_dis, left_dis, dragger); return; */}

	 			$(this).css({"top" : new_top, "left" :new_left });
	 			
	 			$.ajax({
					type: "POST",
					url: "actions/change_location.php",
					data: "page="+this.id+"&top="+new_top+"&left="+new_left,
					success: function(phpfile){
					$("#update").append(phpfile);}
				});
	 			}
	 		});
/* 	 if (dragger) {$(this).animate({"top" : new_top, "left" :new_left });} */
}

function close() { // closes popup
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

function update_module() { // loads php to update module
	if(!$("#module_name").val()) {alert("You must have a module name");$("#module_name_label").css("color" , "red");return false;}

	value=$('form').serialize();
		$.ajax({
		type: "POST",
			url: "actions/edit.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			
			topic = $("input[name=module_topic]").val();
			name = $("input[name=module_name]").val();
			$("#header").html(topic+": "+name);
			close();
			}
		});
}

function update_relation() { // loads php to update module
	value=$('form').serialize();
		$.ajax({
		type: "POST",
			url: "actions/update_relation.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			close();
			}
		});
}

function delete_relation() { // loads php to update module
	value=$('form').serialize();
		$.ajax({
		type: "POST",
			url: "actions/delete_relation.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			close();
			}
		});
}

function line(parent, child, relation_id) { //draws lines

	var parentPos = $("#"+parent).position();
	var childPos = $("#"+child).position();
	
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
	
	newtop = parentPos.top-half+h+25;
	left = childPos.left+((parentPos.left-childPos.left)/2)+100;
	
	
	$("#line"+relation_id).css({
	"height" : myheight,
	"top" : newtop,
	"left" : left,
	"-webkit-transform" : "rotate("+angle+"deg)", 
	"-moz-transform" :  "rotate("+angle+"deg)"
	});
	
	$("#arrow"+relation_id).css({
	"top": half
	});
}

function resizeGrid(lowest,rightest) {
	l=lowest+60;
	r=rightest+210;
	mheight = window.innerHeight;
	mwidth = window.innerWidth;
	if (mwidth < r) {width = r;} else {width=mwidth-20;}
	if (mheight < l) {height = l;} else {height=mheight-20;}
	$("#mapgrid").css({"height":height, "width":width});
}


