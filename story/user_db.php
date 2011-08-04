<?
//query to get progress
$progress_get = "Select * from User_Progress where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
$progress_get_list = mysql_query($progress_get) or die(mysql_error()); //execute query
$progress = mysql_fetch_assoc($progress_get_list);

// adds to progress stack
if ($progress['progress_page'] == NULL) {
$instructions = true;
$query_progress_update = "insert into User_Progress (id,progress_user,progress_page, progress_module) values (null,'$user_id','$page_id','$module')"; //mysql query variable
$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
}
else {
$new_page = $progress['progress_page'].", ".$page_id;
$query_progress_update = "Update User_Progress set progress_page='$new_page' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
$instructions = false;
}

//adds to story stack
if ($page['page_type'] == "Story") {
	if ($progress['progress_story'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_story='$page_id' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_story'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_story='$new_page' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}

//adds to appendix stack
if ($page['page_type'] == "Appendix") {
	if ($progress['progress_appendix'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_appendix='$page_id' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_appendix'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_appendix='$new_page' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}

//adds to teaching stack
if ($page['page_type'] == "Teaching") {
	if ($progress['progress_teaching'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_teaching='$page_id' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_teaching'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_teaching='$new_page' where progress_user='$user_id' and progress_module='$module'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}

//look for summary
$visited_pages = explode(", ", $progress['progress_page']);
if (in_array($page['module_summary'], $visited_pages)){$summary=true;}else {$summary = false;}
$n = count($visited_pages)-1;

do {
	if ($visited_pages[$n]!==$page_id){
		$page_type_search = "Select * from Pages where id='$visited_pages[$n]'";
		$list_page_type = mysql_query($page_type_search) or die(mysql_error());
		$results = mysql_fetch_assoc($list_page_type);
			if($results['page_type'] == "Story" || $results['page_type'] == "Teaching") {$back_id=$visited_pages[$n];$back_name=$results['page_name'];break;}
			else {$n=$n-1;}
		}
	else {$n=$n-1;}
} while ($n>0);

/* Find out how many questions have yet to be answered */
$query_assessment = "Select id from User_Assessment where user_id='$user_id' and module='$module'"; //mysql query variable
$list_assessment = mysql_query($query_assessment) or die(mysql_error()); //execute query
$assessment = mysql_fetch_assoc($list_assessment);//gets info in array
$assessment_done = mysql_num_rows($list_assessment); //gets number of links


$query_assessment = "Select assessment_id from Assessment where assessment_module='$module'";
$list_assessment = mysql_query($query_assessment) or die(mysql_error()); //execute query
$assessment = mysql_fetch_assoc($list_assessment);//gets info in array
$assessment_count = mysql_num_rows($list_assessment);


$assessment_count = $assessment_count - $assessment_done;

if (in_array($page_id, $visited_pages)){$current_assessment=0;}
else {
	$query_current_assessment = "Select * from Assessment where assessment_page='$page_id'"; //mysql query variable
	$list_current_assessment = mysql_query($query_current_assessment) or die(mysql_error()); //execute query
	$current_assessment = mysql_num_rows($list_current_assessment); //gets number of links
}

$query="Select * from Author_Permissions where user_id = '$user_id' and module_id = '$module'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

if ($results['id'] == NULL) {$author = false;} else {$author = true;}

?>