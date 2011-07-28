<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$page_parent = $_SESSION['current_page'];
$id = $_POST['id'];
$theClass = $_POST['class'];
$text = $_POST['text'];


$query = "Update Page_Relations set $theClass='$text' where page_relation_id='$id'";
$run = mysql_query($query) or die(mysql_error());

echo "$id updated"; 
?>