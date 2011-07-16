<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
$module=$_POST['story'];

?>
<h2>Module Delete</h2> <?
echo "<div id='deleting-module'>";

$query = "DELETE from Pages where module='$module'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Module Pages deleted.<br />";
$query = "DELETE from Page_Relations where page_module='$module'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Module Pages Relations deleted.<br />";
$query = "DELETE from Assessment where assessment_module='$module'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Module Assessment questions deleted.<br />";
$query = "DELETE from User_Assessment where module='$module'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Module Assessment Answers deleted.<br />";
$query = "DELETE from User_Progress where progress_module='$module'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Module User Progress deleted.<br />";
$query = "DELETE from Modules where module_id='$module'";
$list = mysql_query($query) or die(mysql_error()); //execute query
echo "Module Information deleted.<br />";
?>
</div>

