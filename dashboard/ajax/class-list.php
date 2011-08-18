<?
include_once('../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../authenticate.php');
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$query = "Select * from Classes where class_creator='$user_id'";
$run = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {

echo "<a class='module'>".$results['class_name']."</a>";
}
?>