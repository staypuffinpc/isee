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
include_once('../../db.php');
$story_name = $_POST['story_name'];
$story_topic = $_POST['story_topic'];
$story_first_page = $_POST['story_first_page'];
$story_summary = $_POST['story_summary'];
$story_privacy = $_POST['privacy'];

$query_update = "Update Stories Set
story_name = '$story_name',
story_topic = '$story_topic',
story_first_page = '$story_first_page',
story_summary = '$story_summary',
story_privacy = '$story_privacy'
Where story_id='$story'"; //mysql query variable
$list_update = mysql_query($query_update) or die(mysql_error()); //execute query




echo $story_name." updated.<br />";

?>