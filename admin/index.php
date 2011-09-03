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
$user_id = $_SESSION['user_id'];

if (isset($_GET['left'])) {$left = $_GET['left'];} else {$left = 0;}
if (isset($_GET['top'])) {$top = $_GET['top'];} else {$top = 0;}


if (!isset($_GET['story'])) {$story=$_SESSION['story'];}
else {
$story = $_GET['story'];

$_SESSION['story'] = $story;}
include_once("db.php");



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
var lowest = 0; var rightest = 0;
<? if ($story == NULL) {?>
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
<div id="header"><? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?>
<a id="home" href='../dashboard/index.php'></a>
<div id="greeting"><? echo "<img src='".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div>

<div id="toolbar">
<a class="btn" id="edit">Edit Story Info</a>
<a class="btn" id="permissions">Permissions</a>
<a class="btn" id="worksheet" href="worksheet/index.php?story=<? echo $story; ?>">Edit Worksheet</a>
<a class="btn" id="quiz" href="quiz/index.php?story=<? echo $story; ?>">Edit Quiz</a>
<a class="btn" id="terms">Edit Terms</a>
<a class="btn" id="print" href="print/index.php?story=<? echo $story; ?>">Print Manager</a>
<a class="btn" id="new_page">Add New Page</a>
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
<div class="page <? echo $type_class; ?>" title="<? echo $pages['page_name'];?>" style="top:<? echo $pages['page_top']; ?>;left:<? echo $pages['page_left']; ?>" id="<? echo $pages['id']; ?>">
	<? echo $page_name; ?>
	<div title="View this page in the story." class="goto-page"><a href="../story/index.php?page_id=<? echo $pages['id'];?>&story=<? echo $story; ?>"><img src="../img/external.png" /></a></div>
	<div class="edit-page" id="edit<? echo $pages['id'];?>" title="Edit"><img src="../img/edit.png" /></div>
	<div class="delete" id="delete<? echo $pages['id'];?>" title="Delete"></div>
	<div class="relate"   id="relate<? echo $pages['id'];?>" title="Add New Connection"></div>
	<?
	if ($pages['id'] == $story_info['story_first_page']) {echo "<div id='start' class='start-finish'>Start</div>";}
	if ($pages['id'] == $story_info['story_summary']) {echo "<div id='finish' class='start-finish'>Finish</div>";}
	?>
</div>
<script> 
	if (<? echo $pages['page_top']; ?> > lowest) {lowest = <? echo $pages['page_top']; ?>;} 
	if (<? echo $pages['page_left']; ?> > rightest) {rightest = <? echo $pages['page_left']; ?>;} 
	
	
	</script>
	

<? } /* end while */
?>

<?
while ($relations = mysql_fetch_assoc($list_page_relations)) { ?>

<div class="line" id="line<? echo $relations['page_relation_id']; ?>"><div title="<? echo $relations['page_stem']." ".$relations['page_link'].$relations['page_punctuation']; ?>" id="arrow<? echo $relations['page_relation_id']; ?>" class="arrow"></div>

</div>
<script>
	line(<? echo $relations['page_parent'].", ".$relations['page_child'].", ".$relations['page_relation_id']; ?>);

</script>

<? } /* end while */
?>

<!-- <div id="newpage" class="page" style="top:40;left:450;z-index=99">New Page</div> -->
<div id="update"></div>
<div id="fadebackground"></div>
<div id="mapgrid"></div>
<script>



</script>
<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
<div id="selector"></div>
<div id="pageRightClick">
	<a class="pageRightClickOption" id="editPage2">Edit Page</a>
	<a class="pageRightClickOption">Duplicate</a>
	<a class="pageRightClickOption">Delete</a>

</div>
</body>
</html>