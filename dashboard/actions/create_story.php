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
$user_id = $_SESSION['user_id'];
$module_name = $_POST['module_name'];
$module_topic = $_POST['module_topic'];

$query = "Insert into Modules (module_id, module_creator, module_created, module_name, module_topic, module_privacy, module_assessment_count) Values (NULL, '$user_id',NOW(), '$module_name', '$module_topic', 'Public', '0')"; //mysql query variable


$list = mysql_query($query) or die(mysql_error()); //execute query
$module = mysql_insert_id();
$_SESSION['module'] = $module;

$query = "Insert into Pages (page_name, module, page_author, page_created, page_top, page_left) Values ('First Page', $module, $user_id, NOW(), '120', '210')";
$list = mysql_query($query) or die(mysql_error());
$page = mysql_insert_id();

$query = "Update Modules Set module_first_page = $page where module_id = $module";
$list = mysql_query($query) or die(mysql_error());

$query = "Insert into Author_Permissions (user_id, module_id) Values ('$user_id', '$module')";
$list = mysql_query($query) or die(mysql_error());



?>
