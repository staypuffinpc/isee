<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/isee/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../db.php');
$user_id=$_SESSION['user_id'];


$query="Insert into Pages (id, story, page_author, page_created, page_top, page_left) Values (NULL, '$story','$user_id',NOW(), 200, 450)";
$list_query = mysql_query($query) or die(mysql_error()); //execute query
$lastItemID = mysql_insert_id();
$new_page = "<div class='page temp-new-page' id='".$lastItemID."'>".$new_pages['page_name']."<div class='edit-page' id='edit".$lastItemID."'></div><div class='delete' id='delete".$lastItemID."'></div><div class='relate' id='relate".$lastItemID."' title='Add New Connection'></div></div>";
echo "New Page. <br />";

?>

Page Created <br />

<script>
	$("#mainbody").append("<? echo $new_page; ?>");
	lastItemID = <? echo $lastItemID; ?>;
	$("#"+lastItemID).droppable({
	
	accept: ".relate, .start-finish",
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
		$("#"+this.id).append("<div class='start-finish' id='start'>Start</div>");
		$.ajax({
			type: "POST",
			url: "actions/update_start.php",
			data: "page_id="+this.id,
			success: function(phpfile){
				$("#update").html(phpfile);
			}	
		
		
		});
	}
	if ($(ui.draggable).attr('id') == "finish") {
		console.log("finish");
		$("#finish").remove();
		$("#"+this.id).append("<div class='start-finish' id='finish'>Finish</div>");
		$.ajax({
			type: "POST",
			url: "actions/update_finish.php",
			data: "page_id="+this.id,
			success: function(phpfile){
				$("#update").html(phpfile);
			}	
		
		
		});
	}	
	}

});
/* end set droppable */
</script>
</body>
</html>