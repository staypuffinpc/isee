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
$page_parent = $_SESSION['current_page'];
$id = $_POST['id'];
$theClass = $_POST['class'];
$text = $_POST['text'];

$search = array("\"","'");
$replace =array("&quot;","&apos;");
$text = str_replace($search, $replace, $text);

$query = "Update Page_Relations set $theClass='$text' where page_relation_id='$id'";
$run = mysql_query($query) or die(mysql_error());

echo "$id updated"; 
?>