<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$user_id = $_SESSION['user_id'];
$class_name = $_POST['class_name'];
$enroll_code = $_POST['enroll_code'];
$stories = $_POST['stories'];

$query = "Insert into Classes (class_id, class_creator, class_created, class_name, enroll_code) Values (NULL, '$user_id',NOW(), '$class_name', '$enroll_code')"; //mysql query variable
$run = mysql_query($query) or die(mysql_error()); //execute query 
$lastItemID = mysql_insert_id();

foreach($_POST['stories'] as $key=>$value ) {
$query = "Insert into Class_Modules (class_id, module_id) Values ('$lastItemID', '$value')";
$run = mysql_query($query) or die(mysql_error());

}
?>
