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


$query = "DELETE from Page_Relations where page_relation_id='$page_relation_id'";
$list = mysql_query($query) or die(mysql_error()); //execute query

echo $page_relation_id." deleted.<br />";

echo "<script> $('#line".$page_relation_id."').hide();</script>";

?>
