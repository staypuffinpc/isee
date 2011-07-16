<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$m = $_SESSION['module'];
$u = $_SESSION['user_id'];
$query_progressClear = "DELETE from User_Progress where progress_module='$m' and progress_user='$u'"; //mysql query variable
$list_progressClear = mysql_query($query_progressClear) or die(mysql_error()); //execute query


echo "progress cleared.<br />"
?>