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
$query = "Select * from Pages where story='$story' and page_type='Teaching' order by print_order ASC";
$run = mysql_query($query) or die(mysql_error());
while ($results = mysql_fetch_assoc($run)) {

echo "<li id='item[".$results['id']."]'>".$results['page_name']."</li>";

}


?>