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
$enroll_code = $_POST['enroll_code'];

$query = "Select class_id from Classes where enroll_code = '$enroll_code'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$class_id = $results['class_id'];

if ($class_id == 0) {echo "<script>alert('That is not a valid Enroll Code.');</script>"; exit(); } 

else {
	$query = "Select * from Class_Members where class_id='$class_id' and user_id='$user_id'";
	$run = mysql_query($query) or die(mysql_error());
	$results = mysql_fetch_assoc($run);
		if ($results['id'] !== NULL) {echo "<script>alert('You are already enrolled in this class.');</script>"; exit();}
		else {
			$query = "Insert into Class_Members (class_id, user_id) values ('$class_id', '$user_id')";
			$run = mysql_query($query) or die(mysql_error());
		}
}
?>