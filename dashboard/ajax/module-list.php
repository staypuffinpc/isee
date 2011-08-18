<?
include_once('../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../authenticate.php');
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$query = "Select * From Modules JOIN Users on Modules.module_creator = Users.user_id";
$list_modules = mysql_query($query) or die(mysql_error()); //execute query


while ($modules = mysql_fetch_assoc($list_modules)) { 
	$query = "Select * from Author_Permissions where user_id=$user_id and module_id=".$modules['module_id']; //mysql query variable
	$list_query = mysql_query($query) or die(mysql_error()); //execute query
	$results = mysql_fetch_assoc($list_query);//gets info in array

	if ($modules['module_privacy'] == "Public" || $modules['module_creator'] == $user['user_id'] || $user['role'] == "Admin" || $results['id']) {
		

?> 
	
	<div class="story">
	<a class="module" href="../story/index.php?page_id=<? echo $modules['module_first_page'];?>&module=<? echo $modules['module_id']; ?>">
		<? 
		$query = "Select * from Author_Permissions where user_id=$user_id and module_id=".$modules['module_id']; //mysql query variable
			$list_query = mysql_query($query) or die(mysql_error()); //execute query
			$results = mysql_fetch_assoc($list_query);//gets info in array
		
		if ($modules['module_privacy'] == "Private") {echo "<img class='lock' src='../img/unlocked.png' />";} ?><img class="book" src="../img/books.png" />
		<?
		
		echo "<h5>".$modules['module_name']."</h5>"; 
		echo "<h6>by ".$modules['user_name']."</h6>"; 
		
		
		
		
		?>
		
	</a>
	
	<?
		if ($user['role'] == "Admin" || $results['id']) {echo "<a href='../admin/index.php?module=".$modules['module_id']."' class='editLink'><img src='../img/edit.png' /></a>"; }
		if ($user['role'] == "Admin" || $modules['module_creator'] == $user['user_id']) {echo "<a class='deleteLink' onclick='delete_story(".$modules['module_id'].");'><img src='../img/delete.png' /></a>";}
	?> </div> <?
	}
}
 

 
 
 ?>