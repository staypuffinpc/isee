<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$id = $_POST['id'];

$query = "Select assessment_answer from Assessment where assessment_id='$id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

echo "<p>".$results['assessment_answer']."</p>";



?>