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
/* this is the end of the includes. */ //authenticates

$user_id = $_SESSION['user_id'];//gets user info
$story = $_SESSION['story'];
$term = $_POST['term'];
$definition = $_POST['definition'];
$term_id = $_POST['term_id'];



$update = <<<EOF
	UPDATE 
		Terms 
	SET 
		term = "$term", 
		definition ="$definition",
		story = $story,
		term_modified_by = $user_id,
		term_modified_on = NOW()
		WHERE term_id=$term_id
EOF;


$result = mysql_query($update) or die(mysql_error());

echo "Last Saved: <br />";
echo date("m/d/y @ H:i:s", time());
?>