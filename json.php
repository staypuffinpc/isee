<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$query = "select id, page_name from Pages"; //mysql query variable

$run = mysql_query($query) or die(mysql_error()); //execute query

while($results = mysql_fetch_assoc($run)) {

	$r[] = $results;


}


$json = json_encode($r);

echo $json;








?>