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
$item_id = $_POST['item_id'];
$story = $_SESSION['story'];

$query = "Delete from Quiz_Items where item_id = '$item_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Delete from Quiz_Responses where item_id='$item_id'";
$run = mysql_query($query) or die(mysql_error());

echo "Item Deleted!";


?>