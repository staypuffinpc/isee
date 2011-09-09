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
$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];

$query = "Select story_worksheet_count from Stories where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$worksheet_order = $results['story_worksheet_count']+1;

$query = "Update Stories set story_worksheet_count='$worksheet_order' where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());

?>