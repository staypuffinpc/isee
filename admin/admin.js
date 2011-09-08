$(document).ready(function() {

var top;
var bottom;
var left;
var right;
var mouse_down = false;
var meta_down;
var multiple_drag;
var start_pos;

/* ------------------------------handlers--------------------------- */
var togglePageClass = function(e) {
	$("#pageRightClick").hide();
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

var editStory= function(){ 
	width = 400;
	height = 300;
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


var newPage = function(e){ 
	unbindThemAll();
	e.stopImmediatePropagation();
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
		if (e.keyCode == '112') {console.log("update");$("#update").toggle();}
};

var selectorStart = function(e){
	console.log("selector-start");
	$("#pageRightClick").hide();
	mouse_down = true;
	$("#selector").css("background-color", "#666666");
	$(".page").removeClass("selected");
	$("#selector").hide();
	left = e.pageX;
	top = e.pageY;
	
	return false;
}; 

var selectorMove = function(e){
	console.log("selector-move");

	if (mouse_down) {
		unbindThemAll();
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
	bindThemAll();
	}
return false;
};


var selectorEnd = function(e){
	if (mouse_down) {
		unbindThemAll();
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
					$("#update").html(phpfile);
					bindThemAll();}
				});
		return false;
	}
	
}; 

var editPage = function(e){
	e.stopImmediatePropagation();
	left=document.body.scrollLeft;
	top=document.body.scrollTop;
	if ($(this).parent().attr("class").indexOf("page")== -1){id=$(this).parent().attr("class");}
	else {id=this.id.substr(4);}
	window.location=("page/page.php?page_id="+id+"&left="+left+"&top="+top);
};

var deletePage = function(e){
	e.stopImmediatePropagation();
	unbindThemAll();
	if ($(this).parent().attr("class").indexOf("page")== -1){id=$(this).parent().attr("class");}
	else {id=this.id.substr(6);}
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
	unbindThemAll();
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
		bindThemAll();
		}
	});
};

var closeOnClick = function(){close();}; 

var newTerm = function(e) {
	unbindThemAll();
	e.stopImmediatePropagation();
	console.log("new term clicked");
	$.ajax({
		type: "POST",
		url: "actions/new_term.php",
		success: function(phpfile){
		$("#popup-content").load('ajax/term.php?term='+phpfile);
		bindThemAll();
		}
	});

};
var hidePageRightClick = function() {
	$("#pageRightClick").hide();
};


var editTerm = function() {
	id = this.id;
	openInTermEditor(id);
}

var startMover = function(e) {
/* 	$(".page").draggable("disabled",true); */
	$(this).draggable({
	revert: "invalid",
	start: function(event, ui){unbindThemAll();},
	stop: function(event, ui){bindThemAll();/* $(".page").draggable("disabled", false) */;}
	
	});
		
}
/* actions for dragging pages */

var moveThePage = function () {

	$(this).draggable({
	

	start: function(event, ui) {
		
		if ($(this).hasClass('selected')) {
			multiple_drag = true;
			start_pos = $(this).position()
			$(this).addClass('dragger');
			unbindThemAll();
		}
		else {$(".selected").removeClass('selected');}
		$(".line").fadeOut();
	},
	drag: function(event, ui) {/* 		$.ajax({type: "POST", url: "actions/change_lines.php", data: "page="+this.id, success: function(phpfile){$("#update").append(phpfile);}}); */
	},
	stop: function(event, ui) {
		bindThemAll();
		$(this).removeClass('temp-new-page');
 		var Stoppos = $(this).position();
 		t = Math.round(Stoppos.top/60)*60;l = Math.round(Stoppos.left/210)*210;
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
}

var deleteTerm = function(e) {
	e.stopImmediatePropagation();
	var answer = confirm("Are you sure you want to delete this term?");
	if (answer) {
		info = $(this).attr('class').split(" "),
		$.ajax({
			type: "POST",
			url: "actions/deleteTerm.php",
			data: "term_id="+info[1],
			success:function(phpfile){$("#update").html(phpfile);$("#"+info[1]).remove();}
		});
	}
}

var findTerms = function(e) {
	e.stopImmediatePropagation();
	var answer = confirm("This will attempt to add all key terms from your that don't have definitions to the list. Are you sure you want to continue?");
	if (answer) {
		$.ajax({
			url: "actions/findTerms.php",
			success:function(phpfile) {$("#update").html(phpfile);$("#popup-content").load("ajax/term.php");}
		
		});
	}
}

var showContextmenu = function(e){
	$("#pageRightClick").css({
	"left" : e.pageX,
	"top" : e.pageY	
	}).show().removeClass().addClass(this.id);
	return false;
}

var toggleFinish = function(e) {
	e.stopImmediatePropagation();
	id=$(this).parent().attr("class");
	
$.ajax({
		type: "POST",
		url: "actions/toggleFinish.php",
		data: "id="+id,
		success: function(phpfile){
			$("update").html(phpfile);
			if ($("#"+id+" div").last().attr("class") == "start-finish-summary finish") 
				{$("#"+id+" div").last().remove();} 
			else 
				{$("#"+id).append("<div class='start-finish-summary finish'>Finish</div>");}
		}
	});

}
/* --------------------------end-handlers--------------------------- */

resizeGrid(lowest, rightest);
$(window).resize(function(){
	resizeGrid(lowest, rightest);
});

$("#ajax").ajaxStart(function (){$(this).show();}).ajaxStop(function () {$(this).hide();bindThemAll();});
$("#fadebackground, .close-icon").click(closeOnClick)
$("#update").draggable();
$("#mapgrid").click(function(){});




/* sets pages and droppable regions */
$(".page").droppable({
	accept: ".relate, #start, #summary",
	drop: function(event, ui) {
	if ($(ui.draggable).hasClass("relate")) {
		console.log('relate');
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
	if ($(ui.draggable).attr('id') == "start") {
		console.log("start");
		$("#start").remove();
		$("#"+this.id).append("<div class='start-finish-summary' id='start' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Start</div>");
		$.ajax({
			type: "POST",
			url: "actions/update_start.php",
			data: "page_id="+this.id,
			success: function(phpfile){
				$("#update").html(phpfile);
				bindThemAll();
			}	
		
		
		});
	}
	if ($(ui.draggable).attr('id') == "summary") {
		console.log("summary");
		$("#summary").remove();
		$("#"+this.id).append("<div class='start-finish-summary' id='Summary' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Summary</div>");
		$.ajax({
			type: "POST",
			url: "actions/update_summary.php",
			data: "page_id="+this.id,
			success: function(phpfile){
				$("#update").html(phpfile);
				bindThemAll();
			}	
		
		
		});
	}
	}

});


$(".page").live("contextmenu", showContextmenu);



/* binding and unbinding functions */
bindThemAll();

function bindThemAll() {
	console.log("bound");
	$("body").bind("click",hidePageRightClick);
	$(".page").click(togglePageClass);
	$("#logoutFromMenu").click(logoutFromMenu);
	$("#edit").click(editStory);
	$("#permissions").click(permissions);
	$("#terms").click(termPopup);
	$("#new_page").click(newPage);
	$('html').keyup(keyboard);
	$("#mapgrid").mousedown(selectorStart);
	$("#mapgrid").mousemove(selectorMove);
	$("html").mouseup(selectorEnd);
	$(".edit-page, #edit-page").live('click', editPage);
	$(".delete, #delete").live('click', deletePage);
	$(".arrow").live('click', pageRelation);
	$(".relate").live('mouseover', relatePage);
	$("tr.clickable-item").live("click", editTerm);
	$("#term-change").live('click', termChange);
	$("#new-term").live('click', newTerm);
	$("#start").live("click", startMover);
	$("#summary").live("click", startMover);
	$(".page").live('mouseover', moveThePage);
	$(".deleteTerm").live("click", deleteTerm);
	$("#findTerms").live("click", findTerms);
	$("#toggleFinish").live("click", toggleFinish);
	
}

function unbindThemAll() {
	console.log("unbound");
	$("body").unbind("click",hidePageRightClick);
	$(".page").unbind('click', togglePageClass);
	$("#logoutFromMenu").unbind('click', logoutFromMenu);
	$("#edit").unbind('click', editStory);
	$("#permissions").unbind('click', permissions);
	$("#terms").unbind('click', termPopup);
	$("#new_page").unbind('click', newPage);
	$('html').unbind('keyup', keyboard);
	$("#mapgrid").unbind('mousedown', selectorStart);
	$("#mapgrid").unbind('mousemove', selectorMove);
	$("html").unbind('mouseup', selectorEnd);
	$(".edit-page, #edit-page").unbind('click', editPage);
	$(".delete, #delete").unbind('click', deletePage);
	$(".arrow").unbind('click', pageRelation);
	$(".relate").unbind('mouseover', relatePage);
	$("tr.clickable-item").unbind();
	$("#term-change").unbind('click', termChange);
	$("#new-term").unbind();
	$("#start").unbind();
	$("#summary").unbind();
	$(".deleteTerm").unbind();
	$("#findTerms").unbind();
	$("#toggleFinish").unbind("click", toggleFinish);
}

/* end of binding functions */

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

function update_story() { // loads php to update story
	if(!$("#story_name").val()) {alert("You must have a story name");$("#story_name_label").css("color" , "red");return false;}

	value=$('form').serialize();
		$.ajax({
		type: "POST",
			url: "actions/edit.php",
			data: value,
			success: function(phpfile){
			$("#update").append(phpfile);
			
			topic = $("input[name=story_topic]").val();
			name = $("input[name=story_name]").val();
			$("#header").html(topic+": "+name);
			close();
			}
		});
}

function update_relation() { // loads php to update story
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

function delete_relation() { // loads php to update story
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

function openInTermEditor(id) {
$.ajax({
	type: "POST",
	url: "ajax/term_editor.php",
	data: "term_id="+id,
	success: function(phpfile){
		$("#tabular-data-info").html(phpfile);
	}
});

}

