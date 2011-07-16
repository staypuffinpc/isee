<?php
// include_once('../../../../connectFiles/connectProject301.php');
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$user_id = $_SESSION['user_id'];
$page_id = $_POST['page_id'];
$text = $_POST['entry'];
/* include_once("db.php"); */

$query_record_check = "Select * from Journal where journal_user  = '".$user_id."' and journal_page = '".$page_id."'"; //mysql query variable
$list_record_check = mysql_query($query_record_check) or die(mysql_error()); //execute query
$record_check = mysql_fetch_assoc($list_record_check);//gets info in array

date_default_timezone_set('America/Denver');


if ($record_check['journal_user'] == NULL)
	{
	$query_record_entry = "insert into Journal (id,journal_user,journal_page, journal_text) values (null,'$user_id','$page_id','$text')"; //mysql query variable
	$list_record_entry = mysql_query($query_record_entry) or die(mysql_error()); //execute query
	echo "Recorded: ".date('l jS \of F Y h:i:s A');
	}
else 
	{
	$query_record_entry = "UPDATE Journal SET journal_text='".$text."' WHERE id='".$record_check['id']."'"; //mysql query variable
	$list_record_entry = mysql_query($query_record_entry) or die(mysql_error()); //execute query
		echo "Last Saved: ".date('l jS \of F Y h:i:s A');

	}
?>