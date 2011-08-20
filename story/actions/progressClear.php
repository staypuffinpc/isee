<?
/* This action clears the progress for the current user on the current module. */

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
$m = $_SESSION['module'];
$u = $_SESSION['user_id'];
$query_progressClear = "DELETE from User_Progress where progress_module='$m' and progress_user='$u'"; //mysql query variable
$list_progressClear = mysql_query($query_progressClear) or die(mysql_error()); //execute query

echo "progress cleared.<br />"
?>