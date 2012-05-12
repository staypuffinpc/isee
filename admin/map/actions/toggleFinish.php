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
$page_id = $_POST['id'];

$query = "Select finish_page from Pages where id='$page_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

if ($results['finish_page'] == "true") {$value = "false";} else {$value = "true";}
/* if ($results['finish_page'] == "false") {$value = "true";} */
$query = "Update Pages set finish_page='".$value."' where id='$page_id'";
$run = mysql_query($query) or die(mysql_error());

?>