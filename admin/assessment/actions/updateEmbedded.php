<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$id = $_POST['id'];
$embedded = $_POST['embedded'];


$query = "Update Assessment set embedded='$embedded' where assessment_id='$id'";
$run = mysql_query($query) or die(mysql_error());
echo "Updated";
?>
