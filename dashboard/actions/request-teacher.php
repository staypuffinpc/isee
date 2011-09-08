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

$query = "Select * from Users where user_id='$user_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);


$email = "benmcmurry@gmail.com";
$message = $results['user_name']." is requesting to be a teacher. id: ".$results['user_id'];
$subject = "Teacher Request";
mail($email, $subject, $message);
echo $email;

?>