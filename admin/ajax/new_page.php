<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/project/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/301/project/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$module = $_SESSION['module'];
include_once('../db.php');
$user_id=$_SESSION['user_id'];


$query="Insert into Pages (id, module, page_author, page_created, page_top, page_left) Values (NULL, '$module','$user_id',NOW(), 200, 450)";
$list_query = mysql_query($query) or die(mysql_error()); //execute query
$lastItemID = mysql_insert_id();
$new_page = "<div class='page temp-new-page' id='".$lastItemID."'>".$new_pages['page_name']."<div class='edit-page' id='edit".$lastItemID."'></div><div class='delete' id='delete".$lastItemID."'></div><div class='relate' id='relate".$lastItemID."' title='Add New Connection'></div></div>";
echo "New Page. <br />";

?>
<!DOCTYPE >
<html>
<head>




</head>
<body>
Page Created <br />

<script>
	$("#mainbody").append("<? echo $new_page; ?>");
	lastItemID = <? echo $lastItemID; ?>;
	$("#"+lastItemID).droppable({
	
	accept: ".relate",
	drop: function(event, ui) {
	alert("test");
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
/* end set droppable */
</script>
</body>
</html>