<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$module = $_SESSION['module'];
include_once('../../db.php');
$page_id = $_POST['page_id'];
$page_name = $_POST['page_name'];
$page_content = $_POST['content'];
$page_references = $_POST['references'];
$page_summary = $_POST['page_summary'];
$page_navigation_text = $_POST['page_navigation_text'];
$page_type = $_POST['page_type'];


$user_id=$_SESSION['user_id'];

$update = "UPDATE Pages SET 
page_name = '$page_name', 
page_content = '$page_content', 
page_references = '$page_references', 
page_type = '$page_type', 
page_summary = '$page_summary',
page_navigation_text = '$page_navigation_text',
modified_by = '$user_id',
modified_date=NOW() 
WHERE id='".$page_id."'";
$result = mysql_query($update) or die(mysql_error());


echo "Last Saved:";
echo date("d/m/y : H:i:s", time());



?>