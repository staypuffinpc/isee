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
$page_parent = $_SESSION['current_page'];
$text = $_POST['text'];

$text = "<h4>$text</h4>";


$query = "Insert into Page_Relations (page_child, page_parent, page_stem) values ('$page_parent','$page_parent','$text')";
$run = mysql_query($query) or die(mysql_error());
$lastItemID = mysql_insert_id();


echo "<li class='ui-state-default' id='item[$lastItemID]'><a class='deleteLink' id='delete".$lastItemID."'>x</a>
	<span class='page_stem ".$lastItemID."' contenteditable>".$text." </span>
	<div class='page_ending'></div></li>"; 
?>