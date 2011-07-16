<?
//gets user information
$query_user = "Select * from Users where user_id='$user_id'"; //mysql query variable
$list_user = mysql_query($query_user) or die(mysql_error()); //execute query
$user = mysql_fetch_assoc($list_user);//gets info in array

//get current_page data JOIN Modules on Pages.module = Modules.module_name
$query_page = "SELECT * FROM Pages 
JOIN Modules on Pages.module = Modules.module_id
WHERE Pages.id=".$page_id.""; //mysql query variable
$list_page = mysql_query($query_page) or die(mysql_error()); //execute query
$page = mysql_fetch_assoc($list_page);//gets info in array
//end get current_page data

if ($page['page_type'] == "Story") {$back_to_class = $page_id;}; //gets go back to classroom link

//gets all navigation buttons JOIN Pages ON Page_Relations.page = Pages.id 
$query_nav = "SELECT * FROM Page_Relations 
JOIN Pages on Page_Relations.page_child = Pages.id
WHERE page_parent = '".$page['id']."' ORDER BY page_order ASC"; //mysql query variable
$list_nav = mysql_query($query_nav) or die(mysql_error()); //execute query
$results_nav = mysql_fetch_assoc($list_nav);//gets info in array
//end get navigation buttons


?>