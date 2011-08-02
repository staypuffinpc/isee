<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
$assessment_id = $_POST['id'];
include_once('../../authenticate.php');
$module = $_SESSION['module'];

$query = "Delete from Assessment where assessment_id='$assessment_id'";
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