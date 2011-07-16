<?php
// include_once('../../../../connectFiles/connectProject301.php');
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$user_id = $_SESSION['user_id'];
$page_id = $_SESSION['current_page'];

//query to get journal text
$query_record_check = "Select * from Journal where journal_user  = '".$user_id."' and journal_page = '".$page_id."'"; //mysql query variable
$list_record_check = mysql_query($query_record_check) or die(mysql_error()); //execute query
$record_check = mysql_fetch_assoc($list_record_check);//gets info in array

do { // this checks to see if there is journal goals
	if($record_check['journal_text'] == NULL){$journal = "Enter Text Here";}
	else {$journal=$record_check['journal_text'];}
} while ($record_check = mysql_fetch_assoc($list_record_check));



?>
<form>
	<input type="hidden" name="update" value="1" />
	<input type="hidden" name="page_id" value="<? echo $page_id; ?>" />
	<textarea cols="22" rows="24" name="textarea" id="textarea" style="font-size:16px;"><? echo $journal; ?></textarea>
	<br />
	<input id="submit" type="button" name="submit" value="Record Entry" onClick="write_to_journal();" />
	<div id="write-status"></div>
</form>
