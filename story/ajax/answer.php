<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/isee/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$id = $_POST['id'];

$query = "Select worksheet_answer from Worksheet where worksheet_id='$id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

echo "<p>".$results['worksheet_answer']."</p>";



?>