<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');

foreach($_POST['item'] as $key=>$value) {
	$value=$value+1;
	$query = "Update Assessment set assessment_order='$value' where assessment_id='$key'";
	$run = mysql_query($query) or die(mysql_error());
	echo "$key updated to $value.<br />";
	
}


?>