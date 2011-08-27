<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/project/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/301/project/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$class_name = $_POST['class_name'];
$enroll_code = $_POST['enroll_code'];
$stories = $_POST['stories'];

$query = "Insert into Classes (class_id, class_creator, class_created, class_name, enroll_code) Values (NULL, '$user_id',NOW(), '$class_name', '$enroll_code')"; //mysql query variable
$run = mysql_query($query) or die(mysql_error()); //execute query 
$lastItemID = mysql_insert_id();

foreach($_POST['stories'] as $key=>$value ) {
$query = "Insert into Class_Stories (class_id, story_id) Values ('$lastItemID', '$value')";
$run = mysql_query($query) or die(mysql_error());

}
?>
