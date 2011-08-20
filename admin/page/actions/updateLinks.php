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
$page_parent = $_SESSION['current_page'];
$id = $_POST['id'];
$theClass = $_POST['class'];
$text = $_POST['text'];


$query = "Update Page_Relations set $theClass='$text' where page_relation_id='$id'";
$run = mysql_query($query) or die(mysql_error());

echo "$id updated"; 
?>