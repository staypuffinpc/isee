<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$field = $_POST['field'];
$text = $_POST['text'];
$id = $_POST['id'];

$query = "Update Assessment set assessment_$field='$text' where assessment_id='$id'";
$run = mysql_query($query) or die(mysql_error());

echo "Updated to $text.";