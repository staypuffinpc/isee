<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home5/byuiptne/public_html/isee/authenticate.php");
	include_once("/home5/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'];
$value = $_POST['value'];

$query = "Update Quiz_Items set item_answer='$value', modified_by='$user_id', modified_on=NOW() where item_id='$item_id'";
$run = mysql_query($query) or die(mysql_error());

echo "Answer Updated!";


?>