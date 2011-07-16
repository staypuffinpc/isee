<?
$query_module = "Select * from Modules Join Users on Users.user_id = Modules.module_creator where module_id=$module "; //mysql query variable
$list_module = mysql_query($query_module) or die(mysql_error()); //execute query
$module_info = mysql_fetch_assoc($list_module);//gets info in array

$query_pages = "Select * from Pages where module=$module AND page_top is not null ORDER by page_name ASC"; //mysql query variable
$list_pages = mysql_query($query_pages) or die(mysql_error()); //execute query
$pages = mysql_fetch_assoc($list_pages);//gets info in array

$query_new_pages = "Select * from Pages where module=$module AND page_top is null ORDER by page_name ASC"; //mysql query variable
$list_new_pages = mysql_query($query_new_pages) or die(mysql_error()); //execute query
$new_pages = mysql_fetch_assoc($list_new_pages);//gets info in array

$query_page_relations = "Select * from Page_Relations where page_module=$module"; //mysql query variable
$list_page_relations = mysql_query($query_page_relations) or die(mysql_error()); //execute query
$relations = mysql_fetch_assoc($list_page_relations);//gets info in array
?>