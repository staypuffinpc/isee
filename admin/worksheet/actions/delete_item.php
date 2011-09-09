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
$worksheet_id = $_POST['worksheet_id'];
include_once('../../../authenticate.php');
$story = $_SESSION['story'];

$query = "Delete from Worksheet where worksheet_id='$worksheet_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Delete from User_Worksheet where worksheet_id='$worksheet_id'";
$run = mysql_query($query) or die(mysql_error());
echo "Item Deleted";

$query = "Select story_worksheet_count from Stories where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$new_count = $results['story_worksheet_count'] - 1;
if ($new_count<0) {$new_count = 0;}

$query = "Update Stories set story_worksheet_count='$new_count' where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());

?>