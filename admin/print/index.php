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
$story = $_GET['story'];

$query = "Select * from Stories where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());
$story = mysql_fetch_assoc($run);


?>
<!DOCTYPE html>
<html>
<head>

<title><? echo $story['story_name']; ?>
</title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="../../styles/stylist.css" rel="stylesheet" type="text/css" />

<link href="print-config.css" rel="stylesheet" type="text/css" />
<link href="print.css" rel="stylesheet" type="text/css" media="print"/>

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="print.js"></script>


</head>
<body>
<div id="header"><? echo $story['story_name']; ?>
<a id="home" href="../index.php"></a>
<div id="greeting"><? echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>
</div>
<div id="toolbar">
	<div class='title' id="page-order">Page Order</div>
	<a class='btn' id="print" HREF="javascript:window.print()">Print</a><a class='btn' id="save">Save</a>
	<a class='btn' id='load'>Load a previous version</a>
</div>
<ul id="item-list">
	
	<? include("ajax/item-list.php"); ?>
</ul>


<div id="content">
	<? include("ajax/print.php"); ?>
</div>
<div id="saves">

</div>
<div id="pageRightClick">
<a class="pageRightClickOption" id="removeMe">Remove me</a>
<a class="pageRightClickOption" id="editMe">Edit me</a>

</div>
<div id="update">
</div>
<div id="quick-instructions">
<p>Use the list above to arrange the order.</p>
<p>WARNING: Changing the order will erase all edits.</p>
<p>Drag Elements on the right to reorder paragraphs.</p>
<p>Right click for a context menu to delete and edit elements.</p>

</div>
</body>
</html>