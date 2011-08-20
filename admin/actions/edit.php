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
include_once('../db.php');
$module_name = $_POST['module_name'];
$module_topic = $_POST['module_topic'];
$module_first_page = $_POST['module_first_page'];
$module_summary = $_POST['module_summary'];
$module_privacy = $_POST['privacy'];

$query_update = "Update Modules Set
module_name = '$module_name',
module_topic = '$module_topic',
module_first_page = '$module_first_page',
module_summary = '$module_summary',
module_privacy = '$module_privacy'
Where module_id='$module'"; //mysql query variable
$list_update = mysql_query($query_update) or die(mysql_error()); //execute query




echo $module_name." updated.<br />";

?>