<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];




$user_id = $_POST['searchForAuthor-id'];
$user_name = $_POST['searchForAuthor'];




$query = "select * from Author_Permissions where user_id = $user_id and module_id = $module";
$list = mysql_query($query) or die(mysql_error()); 
$results = mysql_fetch_assoc($list);//gets info in array
if (!$results['id']) {
	$query = "Insert into Author_Permissions (user_id, module_id) values ($user_id, $module)";
	$list = mysql_query($query) or die(mysql_error()); //execute query
	echo "Author ".$user_name." Added!";
}
?>