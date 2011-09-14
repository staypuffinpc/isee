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
$user_id = $_SESSION['user_id'];

if (isset($_GET['left'])) {$left = $_GET['left'];} else {$left = 0;}
if (isset($_GET['top'])) {$top = $_GET['top'];} else {$top = 0;}


if (!isset($_GET['story'])) {$story=$_SESSION['story'];}
else {
$story = $_GET['story'];

$_SESSION['story'] = $story;}
include_once("db.php");

if (isset($_GET['x'])) {$x = $_GET['x'];}
else {$x = 1;}
$magT = 100/(2*$x);
$magL = 100/$x;
$pw = $magL*2;
$ph = $magT;
$f = 16/$x;
$img_size = 20/$x;
$arrow_size = 30/$x;
$arrow_location = -14/$x;
$relate_right = 52/$x;
$edit_page_right = 28/$x;
$delete_right = 3/$x;
$grid_size = 210/$x;

$_SESSION['magT'] = $magT;
$_SESSION['magL'] = $magL;


?>
<html>
<head>
<title><? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?></title>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />

<link href="admin.css" rel="stylesheet" type="text/css" />
<link href="terms-wizard.css" rel="stylesheet" type="text/css" />
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>	



<script type="text/javascript">
    _editor_url  = "../xinha/";  // (preferably absolute) URL (including trailing slash) where Xinha is installed
    _editor_lang = "en";      // And the language we need to use in the editor.
    _editor_skin = "blue-metallic";   // If you want use a skin, add the name (of the folder) here
  </script>
  <script type="text/javascript" src="../xinha/XinhaCore.js"></script>
  <script type="text/javascript" src="../xinha/my_config_term.js"></script>
  
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="../js/common.js"></script>

<script type="text/javascript" src="../js/jquery.client.js"></script>
<script type="text/javascript" src="../js/jquery-scroll.js"></script>

<script type="text/javascript" src="admin.js"></script>



<script type="text/javascript">
<? 
$h = 0;
$w = 0;
if ($story == NULL) {?>
window.location = "../dashboard/";
<?
}
?>
$(document).ready(function(){
window.scroll(<? echo $left; ?>, <? echo $top; ?>);
});

</script>
</head>
<body id="mainbody">
<div id="top-stuff">
<div id="header"><? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?>
<a id="home" href='../dashboard/index.php'></a>
<div id="greeting"><? echo "<img src='".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div>

<div id="toolbar">
<a class="btn" id="edit">Edit Story Info</a>
<a class="btn" id="permissions">Permissions</a>
<a class="btn" id="worksheet" href="worksheet/index.php?story=<? echo $story; ?>">Edit Worksheet</a>
<a class="btn" id="quiz" href="quiz/index.php?story=<? echo $story; ?>">Edit Quiz</a>
<a class="btn" id="terms" href="terms/index.php">Edit Terms</a>
<a class="btn" id="print" href="print/index.php?story=<? echo $story; ?>">Print Manager</a>
<a class="btn" id="new_page">Add New Page</a>
</div>
</div>
<?

while ($pages = mysql_fetch_assoc($list_pages)) { 
if (strlen($pages['page_name'])>20 && strlen($pages['page_name'])>0){$page_name = substr($pages['page_name'],0,17)." . . ." ;}
else {$page_name=$pages['page_name'];}
if ($pages['page_type']=="Story") {$type_class="story";}
if ($pages['page_type']=="Teaching") {$type_class="teaching";}
if ($pages['page_type']=="Appendix") {$type_class="appendix";}
if ($pages['page_type']==NULL) {$type_class="blank";}
?> 
<div class="page <? echo $type_class; ?>" title="<? echo $pages['page_name'];?>" style="top:<? echo $pages['page_top']/$x; ?>;left:<? echo $pages['page_left']/$x; ?>;" id="<? echo $pages['id']; ?>">
	<? echo $page_name; ?>
	<div title="View this page in the story." class="goto-page"><a href="../story/index.php?page_id=<? echo $pages['id'];?>&story=<? echo $story; ?>"><img src="../img/external.png" /></a></div>
	<div class="edit-page" id="edit<? echo $pages['id'];?>" title="Edit"><!-- <img src="../img/edit.png" /> --></div>
	<div class="delete" id="delete<? echo $pages['id'];?>" title="Delete"></div>
	<div class="relate"   id="relate<? echo $pages['id'];?>" title="Add New Connection"></div>
	<?
	if ($pages['id'] == $story_info['story_first_page']) {echo "<div id='start' class='start-finish-summary' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Start</div>";}
	if ($pages['id'] == $story_info['story_summary']) {echo "<div id='summary' class='start-finish-summary' title='Click twice. On the Second click keep the mouse key down and drag to a new page.'>Summary</div>";}
	if ($pages['finish_page'] == "true") {echo "<div class='start-finish-summary finish'>Finish</div>";}
	?>
</div>

<?
	if($pages['page_top'] > $h) {$h = $pages['page_top'];}
	if($pages['page_left'] > $w) {$w = $pages['page_left'];}
	

} /* end while */

while ($relations = mysql_fetch_assoc($list_page_relations)) { ?>

<div class="line" id="line<? echo $relations['page_relation_id']; ?>"><div title="<? echo $relations['page_stem']." ".$relations['page_link'].$relations['page_punctuation']; ?>" id="arrow<? echo $relations['page_relation_id']; ?>" class="arrow"></div>

</div>
<script>
	line(<? echo $relations['page_parent'].", ".$relations['page_child'].", ".$relations['page_relation_id'].", ".$magT.", ".$magL; ?>);

</script>

<? } /* end while */
?>

<!-- <div id="newpage" class="page" style="top:40;left:450;z-index=99">New Page</div> -->
<div id="update"></div>
<div id="fadebackground"></div>

<?
	$h=$h+50;
	$w=$w+200;

?>

<div id="mapgrid"></div>
<script>
$("#mapgrid").css({
	"width" : <? echo $w/$x; ?>,
	"height" : <? echo $h/$x; ?>,
});

$("body").css({
	"background-size" : "<? echo $grid_size; ?>px"
});

console.log("width:<? echo $w; ?>px;height=<? echo $h; ?>px");


$(".page").css({
	"width"	: <? echo $pw; ?>,
	"height": <? echo $ph; ?>,
	"font-size" : "<? echo $f; ?>px"
});

$(".relate, .edit-page, .delete").css({
	"background-size": "<? echo $img_size; ?>px",
	"width": "<? echo $img_size; ?>px",
	"height": "<? echo $img_size; ?>px",
});


$(".relate").css({
	"right" : "<? echo $relate_right; ?>px"
});

$(".delete").css({
	"right" : "<? echo $delete_right; ?>px"
});


$(".edit-page").css({
	"right" : "<? echo $edit_page_right; ?>px"
});

$(".arrow").css({
	"background-size": "<? echo $arrow_size; ?>px",
	"left" : "<? echo $arrow_location; ?>px",
});

	


</script>
<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
<div id="selector"></div>
<div id="pageRightClick">
	<a class="pageRightClickOption" id="editPage">Edit Page</a>
	<a class="pageRightClickOption" id="duplicate">Duplicate</a>
	<a class="pageRightClickOption" id="delete">Delete</a>
	<a class="pageRightClickOption" id="toggleFinish">Toggle Finish Page</a>

</div>

</body>
</html>