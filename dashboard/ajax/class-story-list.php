<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/project/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/301/project/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$class_id = $_POST['id'];

$query = "Select * From Class_Modules JOIN Modules on Modules.module_id = Class_Modules.module_id JOIN Users on Modules.module_creator = Users.user_id where Class_Modules.class_id = '$class_id'";
$list_modules = mysql_query($query) or die(mysql_error()); //execute query


?>
<div class="story">
<a class='dbutton' id="showAll">Show all Stories</a>

</div>

<?

$class = array();
$query = "Select * from Class_Modules join Class_Members on Class_Modules.class_id = Class_Members.class_id where Class_Members.user_id = '$user_id'";
	$run = mysql_query($query) or die(mysql_error());
	while ($result = mysql_fetch_assoc($run)) {
		$class[] = $result['module_id'];
	}

while ($modules = mysql_fetch_assoc($list_modules)) { 
	$query = "Select * from Author_Permissions where user_id=$user_id and module_id=".$modules['module_id']; //mysql query variable
	$list_query = mysql_query($query) or die(mysql_error()); //execute query
	$results = mysql_fetch_assoc($list_query);//gets info in array

	if ($modules['module_privacy'] == "Public" || $modules['module_creator'] == $user_id || $role == "Admin" || $results['id'] || in_array($modules['module_id'], $class)) {
		

?> 
	
	<div class="story">
	<a class="choice module" href="../story/index.php?page_id=<? echo $modules['module_first_page'];?>&module=<? echo $modules['module_id']; ?>">
		<? 
		$query = "Select * from Author_Permissions where user_id=$user_id and module_id=".$modules['module_id']; //mysql query variable
			$list_query = mysql_query($query) or die(mysql_error()); //execute query
			$results = mysql_fetch_assoc($list_query);//gets info in array
		
		?><img class="book" src="../img/books.png" />
		<?
		
		echo "<h5>".$modules['module_name']."</h5>"; 
		echo "<h6>by ".$modules['user_name']."</h6>"; 
		
		
		
		
		?>
		
	</a>
	
	<?
		if ($role == "Admin" || $results['id']) {echo "<a href='../admin/index.php?module=".$modules['module_id']."' class='editLink'><img src='../img/edit.png' /></a>"; }
		if ($role == "Admin" || $modules['module_creator'] == $user_id) {echo "<a class='deleteLink' onclick='delete_story(".$modules['module_id'].");'><img src='../img/delete.png' /></a>";}
	?> </div> <?
	}
}
 

 
 
 ?>