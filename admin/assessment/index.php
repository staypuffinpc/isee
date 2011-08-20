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
$module = $_GET['module'];
if (isset($_GET['left'])) {$left = $_GET['left'];} else {$left = 0;}
if (isset($_GET['top'])) {$top = $_GET['top'];} else {$top = 0;}


if ($module == NULL) {$module=$_SESSION['module'];}
else {$_SESSION['module'] = $module;}
include_once("../db.php");



?>
<html>
<head>
<title>Quiz Editor: <? echo $module_info['module_topic']; ?>: <? echo $module_info['module_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />


<link href="assessment.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="assessment.js"></script>



<script type="text/javascript">
<? if ($module == NULL) {?>
window.location = "../dashboard/";
<?
}
?>
$(document).ready(function(){

});

</script>
</head>
<body>
<div id="header">Quiz Editor: <? echo $module_info['module_topic']; ?>: <? echo $module_info['module_name']; ?>
<a class="btn" id="logoutFromMenu">Logout</a>
<div id="greeting"><? echo "User: ".$_SESSION['user_name']; ?></div>

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
<div id="footer">

<ul>
	<li id="backToMap"><a href="../index.php"><img src="../../img/tree.png" /><br />Map</a></li>
	<li id="mainMenu" ><a href="../../index.php"><img src="../../img/exit.png" /><br />Main Menu</a></li>
	
</ul>

</div> <!-- end footer -->
</script>
<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
<div id="selector"></div>
<div id="pageRightClick">
	<a class="pageRightClickOption" id="editPage2">Edit Page</a>
	<a class="pageRightClickOption">Duplicate</a>
	<a class="pageRightClickOption">Delete</a>

</div>
<div id="update"></div>
</body>
</html>