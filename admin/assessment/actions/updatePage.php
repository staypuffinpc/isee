<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$page = $_POST['page'];
$id = $_POST['id'];

$query = "Update Assessment set assessment_page = '$page' where assessment_id='$id'";
$run = mysql_query($query) or die(mysql_error());
echo "updated";
?>
