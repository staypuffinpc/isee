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
$story = $_GET['story'];
if (isset($_GET['left'])) {$left = $_GET['left'];} else {$left = 0;}
if (isset($_GET['top'])) {$top = $_GET['top'];} else {$top = 0;}


if ($story == NULL) {$story=$_SESSION['story'];}
else {$_SESSION['story'] = $story;}
include_once("../db.php");



?>
<html>
<head>
<title>Worksheet Editor: <? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />


<link href="worksheet.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="worksheet.js"></script>



<script type="text/javascript">
<? if ($story == NULL) {?>
window.location = "../dashboard/";
<?
}
?>
$(document).ready(function(){

});

</script>
</head>
<body>
<div id="header">Worksheet Editor: <? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?>
<a id="home" href="../index.php"></a>
<div id="greeting"><? echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div>


<div id="viewport">
<div class="content">
<div id="toolbar">
<a class='btn newItem' id='multiple_choice'>New Multiple Choice Item</a>
<a class='btn newItem' id='true_false'>New True/False Item</a>
<a class='btn newItem' id='fill_in_the_blank'>New Fill in the Blank Item</a>
<a class='btn newItem' id='short_answer'>New Short Answer Item</a>
</div>
<ul id="item-list"></ul>
</div>
</div>

</script>
<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

</body>
</html>