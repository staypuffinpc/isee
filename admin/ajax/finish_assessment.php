<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];

$assessment_id = $_POST['assessment_id'];
$assessment_answer = $_POST['assessment_answer'];
$assessment_page = $_POST['assessment_page'];
$available = $_POST['available'];
$embedded = $_POST['embedded'];

$query = "Update Assessment set assessment_answer='$assessment_answer', assessment_page='$assessment_page', available='$available', embedded='$embedded' where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());

?>