<?
$query = "Select * From Modules JOIN Users on Modules.module_creator = Users.user_id";
$list_modules = mysql_query($query) or die(mysql_error()); //execute query

$query_user = "Select * From Users where user_id=$user_id"; //mysql query variable
$list_user = mysql_query($query_user) or die(mysql_error()); //execute query
$user = mysql_fetch_assoc($list_user);//gets info in array




?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0; maximum-scale=1.0; user-scalable=0; width=device-width;">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>IP&T 301 Simulator</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<link href="dashboard.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="dashboard.js"></script>

<script type="text/javascript">
$(document).ready(function() {
<? 

if ($user['role'] !== "Teacher") 
	{ 
	echo <<<EOF
		$("#create-new-class").hide();
		update_classes_height();	
		update_stories_height();
EOF;
}
	

?>

});




</script>

</head>

<body>
<div id="main">
<div id="header">IP&T 301 Simulation Website
	<a class="btn" id="logoutFromMenu">Logout</a>
</div>
	
		<div id="left-column" class="column">
			<div id="profile" class="panel">
				<h1>Profile</h1>
				<div class="content">
					<? 
					echo "<img width='48px' src='".$user['user_image']."' />";
					echo "<h3>".$user['user_name']."</h3>"; 
					echo "<h4>".$user['role']."</h4>";
					?>
				</div>
			</div> <!-- end profile div -->
			
			<div id="updates" class="panel">
				<h1>Updates</h1>
				<div class="content">	
					<? include_once('changelog.html'); ?>
				</div>
			</div> <!-- end updates div -->
		</div>	<!-- end left column div -->
		<div id="center-column" class="column">
			<div id="classes" class="panel">
				<h1>Classes</h1>
				<div class="content">
				<? include("ajax/class-list.php"); ?>
				</div>
			</div> <!-- end classes panel -->
			<div id="class-actions" class="panel">
				<div class="content">
					<a id="enroll-in-new-class" class="dbutton">Enroll in New Class</a>
					<a id="create-new-class" class="dbutton">Create New Class</a>
				</div>
				
			</div>
		
		</div> <!-- end center column -->
		<div id="right-column" class="column">
			<div id="stories" class="panel">
				<h1>Public Stories</h1>
				<div id="search"><div id="search-text">Search</div><input type="text" value="Search functionality coming soon." id="search-box" onkeyup="lookup(this.value);" disabled/></div>
				<div class="content">
				<? include("ajax/module-list.php"); ?>


 				</div>
			</div> <!-- end stories pane -->
			

			
			<div id="story-actions" class="panel">
				<div class="content">
				<a id="new-story" class="dbutton">Write a New Story</a>
				</div>
			</div>
		</div> <!-- end right column -->
	
	</div> <!-- end main div -->
	<div id="fadebackground"></div>
	<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
	<div id="update"></div>

</body>
</html>