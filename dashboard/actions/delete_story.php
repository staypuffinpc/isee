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
$story=$_POST['story'];

?>
<h2>Story Delete</h2> <?
echo "<div id='deleting-story'>";

$query = "DELETE from Pages where story='$story'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Story Pages deleted.<br />";
$query = "DELETE from Page_Relations where page_story='$story'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Story Pages Relations deleted.<br />";
$query = "DELETE from Worksheet where worksheet_story='$story'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Story Worksheet questions deleted.<br />";
$query = "DELETE from User_Worksheet where story='$story'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Story Worksheet Answers deleted.<br />";
$query = "DELETE from User_Progress where progress_story='$story'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Story User Progress deleted.<br />";
$query = "DELETE from Stories where story_id='$story'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Story Information deleted.<br />";
?>
</div>

