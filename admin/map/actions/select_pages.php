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

$top = $_POST['top'];
$left = $_POST['left'];
$width = $_POST['width'];
$height = $_POST['height'];

$height = $top + $height;
$width = $left + $width;



/* and page_left >= $left and page_left <= $width */
$query = "Select * from Pages where page_top >= $top and page_top < $height and page_left >= $left and page_left < $width and story=$story";
$results = mysql_query($query) or die(mysql_error()); //execute query

while ($pages = mysql_fetch_assoc($results)) {

echo <<<EOF

	<script>
		$("#{$pages['id']}").addClass("selected");	</script>


EOF;


echo "Name: ".$pages['page_name']."<br />";
} 
echo "---<br />";


?>