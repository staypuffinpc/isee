<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
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