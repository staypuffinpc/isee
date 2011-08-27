<?
/* this action clears the worksheet data for the current user. */

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
$m = $_SESSION['story'];
$u = $_SESSION['user_id'];
$query = "DELETE from User_Quiz where story='$m' and user_id='$u'"; //mysql query variable
$run = mysql_query($query) or die(mysql_error());

$query = "DELETE from User_Scores where story_id='$m' and user_id='$u'"; //mysql query variable
$run = mysql_query($query) or die(mysql_error());

echo "quiz cleared.<br />"
?>