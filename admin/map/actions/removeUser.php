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
$story = $_SESSION['story'];
$user_id = $_POST['user_id'];

$query = "DELETE FROM author_permissions WHERE user_id = '$user_id' and story_id = '$story'";
$run = mysql_query($query) or die(mysql_error());

echo "User Removed";

?>