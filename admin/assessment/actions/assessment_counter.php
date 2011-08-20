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

$query = "Select module_assessment_count from Modules where module_id='$module'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$assessment_order = $results['module_assessment_count']+1;

$query = "Update Modules set module_assessment_count='$assessment_order' where module_id='$module'";
$run = mysql_query($query) or die(mysql_error());

?>