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
$assessment_id = $_POST['assessment_id'];
include_once('../../../authenticate.php');
$module = $_SESSION['module'];

$query = "Delete from Assessment where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Delete from User_Assessment where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());
echo "Item Deleted";

$query = "Select module_assessment_count from Modules where module_id='$module'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$new_count = $results['module_assessment_count'] - 1;
if ($new_count<0) {$new_count = 0;}

$query = "Update Modules set module_assessment_count='$new_count' where module_id='$module'";
$run = mysql_query($query) or die(mysql_error());

?>