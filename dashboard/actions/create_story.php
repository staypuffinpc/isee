<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home5/byuiptne/public_html/isee/authenticate.php");
	include_once("/home5/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story_name = $_POST['story_name'];
$story_topic = $_POST['story_topic'];

$query = "Insert into Stories (story_id, story_creator, story_created, story_name, story_topic, story_privacy, story_worksheet_count) Values (NULL, '$user_id',NOW(), '$story_name', '$story_topic', 'Public', '0')"; //mysql query variable


$list = mysql_query($query) or die(mysql_error()); //execute query
$story = mysql_insert_id();
$_SESSION['story'] = $story;

$query = "Insert into Pages (page_name, story, page_author, page_created, page_top, page_left) Values ('First Page', $story, $user_id, NOW(), '120', '210')";
$list = mysql_query($query) or die(mysql_error());
$page = mysql_insert_id();

$query = "Update Stories Set story_first_page = $page where story_id = $story";
$list = mysql_query($query) or die(mysql_error());

$query = "Insert into Author_Permissions (user_id, story_id) Values ('$user_id', '$story')";
$list = mysql_query($query) or die(mysql_error());

echo $story;

?>
