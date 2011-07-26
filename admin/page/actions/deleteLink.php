<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$page_parent = $_SESSION['current_page'];
$id = $_POST['id'];

$query = "DELETE FROM Page_Relations WHERE page_relation_id = '$id'";
$run = mysql_query($query) or die(mysql_error());

echo $id." is deleted.";
?>