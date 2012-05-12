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
include_once('../../db.php');

$page_id  = $_POST['page_id'];

$query = "Select story_id, story_name, story_first_page from Stories";
$run = mysql_query($query) or die(mysql_error());


?>


<h2>Link to Another Story</h2>
<form>
<p>Edit Navigation Text</p>
<input type="hidden" name="parent" value="<? echo $page_id; ?>" />
<input size="40" type="text" name="page_stem" id="page_stem" value="Continue to the next" />
<input size="40" type="text" name="page_link" id="page_link" value="story" />
<input size="1" type="text" name="page_punctuation" id="page_punctuation" value="." />
<p>Select Target Story</p>
<select id="child" name="child">
<?
while ($results = mysql_fetch_assoc($run)) {
	echo "<option value='{$results['story_first_page']}'>{$results['story_name']}</option>";
}
?>
</select>
</form>
<br />
<a class="btn" id="update_relation" onClick="addLinkToStory();">Save</a>
<a class="btn" id="delete_relation" onClick="">cancel</a>