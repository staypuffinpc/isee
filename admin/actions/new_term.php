<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];

$query = "Insert Into Terms (term, definition, module, term_author, term_created) Values (' New Term', 'No definition provided', '$module', '$user_id', NOW())";
$run = mysql_query($query) or die(mysql_error());
?>	