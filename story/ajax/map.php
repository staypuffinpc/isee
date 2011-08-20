<?php
// shows progress of current module for current user //
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
$user_id = $_SESSION['user_id'];
$module = $_SESSION['module'];

$query_module = "Select * from Modules where module_id=$module"; //mysql query variable
$list_module = mysql_query($query_module) or die(mysql_error()); //execute query
$module_info = mysql_fetch_assoc($list_module);//gets info in array

$query_pages = "Select * from Pages where module=$module AND page_top is not null ORDER by page_name ASC"; //mysql query variable
$list_pages = mysql_query($query_pages) or die(mysql_error()); //execute query
$pages = mysql_fetch_assoc($list_pages);//gets info in array

$query_new_pages = "Select * from Pages where module=$module AND page_top is null ORDER by page_name ASC"; //mysql query variable
$list_new_pages = mysql_query($query_new_pages) or die(mysql_error()); //execute query
$new_pages = mysql_fetch_assoc($list_new_pages);//gets info in array

$query_page_relations = "Select * from Page_Relations where page_module=$module"; //mysql query variable
$list_page_relations = mysql_query($query_page_relations) or die(mysql_error()); //execute query
$relations = mysql_fetch_assoc($list_page_relations);//gets info in array

$query_user_progress = "Select progress_page from User_Progress where progress_user='$user_id' and progress_module='$module'";
$list_user_progress = mysql_query($query_user_progress) or die(mysql_error()); //execute query
$progress = mysql_fetch_assoc($list_user_progress);//gets info in array
$progress = explode(", ", $progress['progress_page']);
?>

<?
do { 

	
	if (strlen($pages['page_name'])>20 && strlen($pages['page_name'])>0){$page_name = substr($pages['page_name'],0,17)." . . ." ;}
	else {$page_name=$pages['page_name'];}

	if ($pages['page_type']=="Story") {$type_class="story";}
	if ($pages['page_type']=="Teaching") {$type_class="teaching";}
	if ($pages['page_type']=="Appendix") {$type_class="appendix";}

	if (in_array($pages['id'], $progress)){?>
 		<div class="page <? echo $type_class; ?>" title="<? echo $pages['page_name'];?>" style="top:<? echo $pages['page_top']; ?>px;left:<? echo $pages['page_left']; ?>px" id="<? echo $pages['id']; ?>">
			<? echo $page_name; ?>
		</div>
	
	
	<? }
	else {
	$query_child_search = "Select * from Page_Relations where page_child='".$pages['id']."'";
	$list_child_search = mysql_query($query_child_search) or die(mysql_error()); //execute query
	$child_search = mysql_fetch_assoc($list_child_search);//gets info in array
	
	do {
		if (in_array($child_search['page_parent'], $progress)) {
		?>
		<div class="page inactive" title="<? echo $pages['page_name'];?>" style="top:<? echo $pages['page_top']; ?>px;left:<? echo $pages['page_left']; ?>px" id="<? echo $pages['id']; ?>">
			<? echo "?"; ?>
		</div>

		<?
		break;
		}
	
	} while ($pages = mysql_fetch_assoc($list_child_search));
	}
} while ($pages = mysql_fetch_assoc($list_pages));

for ($i=1;$i<10000000;$i++) {}
do { ?>

<div class="line" id="line<? echo $relations['page_relation_id']; ?>">
	<div title="<? echo $relations['page_stem']." ".$relations['page_link']." ".$relations['page_punctuation']; ?>" id="arrow<? echo $relations['page_relation_id']; ?>" class="arrow">
	</div>
</div>

<script>
	line(<? echo $relations['page_parent'].", ".$relations['page_child'].", ".$relations['page_relation_id']; ?>);

</script>

<? } while ($relations = mysql_fetch_assoc($list_page_relations));
?>
<div id="youarehere">You are<br/>here.</div>
<script>
$(".page").click(function(){
	_gaq.push(['_trackEvent', 'Map Click', this.id, this.id+' on the map was clicked.']); //GA tracking
	if ($(this).hasClass('inactive')) {alert("You have not visited this page yet.");}
	else {window.location = "index.php?page_id="+this.id;}
});

loc = $("#<? echo $_SESSION['current_page']; ?>").position();
tophere = loc.top-30;
lefthere = loc.left+175;

$("#youarehere").css({"top":tophere,"left":lefthere});
top1 = (loc.top+25-window.innerHeight/2)+"px";
left = (loc.left+100-window.innerWidth/2)+"px";

$("#<? echo $_SESSION['current_page']; ?>").addClass('current');
$("#viewport").scrollTo({top:top1, left:left}, 800);
/* google_analytics(); */

</script>

