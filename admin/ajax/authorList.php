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
include_once('../db.php');

$query = "select 
	ap.user_id,
	ap.story_id,
	u.user_id,
	u.user_name,
	u.user_email,
	u.user_image
	
from 
	Users u,
	Author_Permissions ap
where
 	ap.user_id = u.user_id
 	and
 	ap.story_id = $story
order by
	u.user_name asc"; //mysql query variable

$list = mysql_query($query) or die(mysql_error()); //execute query


?>
<li>Owner: <? echo $story_info['user_name']; ?> <img src="<? echo $story_info['user_image']; ?>" class='icon' style="position:absolute;top:5;right:5;width:30px;" /></li>
<?
while ($results = mysql_fetch_assoc($list)) {//gets info in array
	
	if ($results['user_name'] !== $story_info['user_name']) {echo "<li><img src='".$results['user_image']."' class='icon' />".$results['user_name']."</li>"; }
}
?>
<script>
	$("li:odd").css("background-color", "#e8e8e8");
	$("li:nth-child(1)").css({"background-color": "#8a8a8a", "color" : "white", "font-weight" : "bold"});
</script>