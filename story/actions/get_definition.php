<? 
/* This action gets the definition of a selected key term. */

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
$term = $_GET['term'];

$query_definition = "Select * from Terms Where term like '%$term%'"; //mysql query variable
$list_definition = mysql_query($query_definition) or die(mysql_error()); //execute query
$definition = mysql_fetch_assoc($list_definition);//gets info in array

echo $definition['definition']; ?>
