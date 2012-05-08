<?
/* This action clears the progress for the current user on the current story. */

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
$s = $_SESSION['story'];
$u = $_SESSION['user_id'];
$query_progressClear = "DELETE from User_Progress where progress_story='$s' and progress_user='$u'"; //mysql query variable
$list_progressClear = mysql_query($query_progressClear) or die(mysql_error()); //execute query

echo "progress cleared.<br />"
?>