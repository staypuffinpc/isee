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
$id = $_POST['id'];

$query = "Select page_name, page_content, page_references from Pages where id='$id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

echo "<h3>Page Content</h3><div id='theBorrowedContent'>".$results['page_content']."</div><h3>Page References</h3><div id='theBorrowedReferenced'>".$results['page_references']."</div>";


?>