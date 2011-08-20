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
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];

$query = "Insert Into Terms (term, definition, module, term_author, term_created) Values (' New Term', 'No definition provided', '$module', '$user_id', NOW())";
$run = mysql_query($query) or die(mysql_error());
$lastItemID = mysql_insert_id();
echo $lastItemID;

?>	