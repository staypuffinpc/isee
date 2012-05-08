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
$story = $_SESSION['story'];




$user_id = $_POST['searchForAuthor-id'];
$user_name = $_POST['searchForAuthor'];




$query = "select * from Author_Permissions where user_id = $user_id and story_id = $story";
$list = mysql_query($query) or die(mysql_error()); 
$results = mysql_fetch_assoc($list);//gets info in array
if (!$results['id']) {
	$query = "Insert into Author_Permissions (user_id, story_id) values ($user_id, $story)";
	$list = mysql_query($query) or die(mysql_error()); //execute query
	echo "Author ".$user_name." Added!";
}
?>