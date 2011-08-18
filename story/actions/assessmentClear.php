<?
/* this action clears the assessment data for the current user. */

include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$m = $_SESSION['module'];
$u = $_SESSION['user_id'];
$query_progressClear = "DELETE from User_Assessment where module='$m' and user_id='$u'"; //mysql query variable
$list_progressClear = mysql_query($query_progressClear) or die(mysql_error()); //execute query
echo "assessment cleared.<br />"
?>