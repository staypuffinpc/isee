<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];

$query = "Select module_assessment_count from Modules where module_id='$module'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$assessment_order = $results['module_assessment_count']+1;

$query = "Update Modules set module_assessment_count='$assessment_order' where module_id='$module'";
$run = mysql_query($query) or die(mysql_error());

?>