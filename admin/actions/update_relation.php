<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
include_once('../db.php');
$page_stem = $_POST['page_stem'];
$page_link = $_POST['page_link'];
$page_punctuation = $_POST['page_punctuation'];
$page_relation_id = $_POST['page_relation_id'];

$query_update = "Update Page_Relations Set
page_stem = '$page_stem',
page_link = '$page_link',
page_punctuation = '$page_punctuation'
Where page_relation_id='$page_relation_id'"; //mysql query variable
$list_update = mysql_query($query_update) or die(mysql_error()); //execute query




echo $page_relation_id." updated.<br />";

?>