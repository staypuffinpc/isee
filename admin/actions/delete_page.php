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
$story = $_SESSION['story'];
include_once('../db.php');
$user_id=$_SESSION['user_id'];
$page_id = $_GET['page_id'];

$query = "DELETE from Pages where id='$page_id'";
$list = mysql_query($query) or die(mysql_error()); //execute query

$queryD = "Select * from Page_Relations where page_child='$page_id' OR page_parent='$page_id'";
$listD = mysql_query($queryD) or die(mysql_error()); //execute query
$D = mysql_fetch_assoc($listD);//gets info in array


$query1 = "DELETE from Page_Relations where page_child='$page_id' OR page_parent='$page_id'";
$list1 = mysql_query($query1) or die(mysql_error()); //execute query


?>
page deleted <br />
<?
do {
?>
<script>

$("#line<? echo $D['page_relation_id']; ?>").fadeOut();

</script>
<?




} while ($D = mysql_fetch_assoc($listD));
?>