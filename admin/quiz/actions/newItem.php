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
switch ($_POST['type']) {
	case "mc":
	$item_type = "Multiple Choice";
	$item_prompt = "Type the prompt here. Add choices by clicking on the \"Add New Response\" button.";
	break;
	case "fb":
	$item_type = "Fill in the Blank";
	$item_prompt = "Type the prompt here. Add a set of underscores for the location of the missing word. <br />Example: What\'s up _______?<br />Click on the \"Add New Response\" button to add possible correct answers.";	
	break;
}

$story = $_SESSION['story'];
$user_id = $_SESSION['user_id'];

$query = "Insert into Quiz_Items (story_id, item_prompt, item_type, created_by, created_on) values ('$story', '$item_prompt', '$item_type', '$user_id', NOW())";
$run = mysql_query($query) or die(mysql_error());

echo "Item Added."



?>