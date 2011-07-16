<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php'); //authenticates

$user_id = $_SESSION['user_id'];//gets user info
$module = $_SESSION['module'];
$term = $_POST['term'];
$definition = $_POST['definition'];
$term_id = $_POST['term_id'];



$update = <<<EOF
	UPDATE 
		Terms 
	SET 
		term = "$term", 
		definition ="$definition",
		module = $module,
		term_modified_by = $user_id,
		term_modified_on = NOW()
		WHERE term_id=$term_id
EOF;


$result = mysql_query($update) or die(mysql_error());

echo "Last Saved: <br />";
echo date("m/d/y @ H:i:s", time());
?>