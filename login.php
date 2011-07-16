<?
include_once('../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database

$query = "Select * from Users"; //mysql query variable
$list = mysql_query($query) or die(mysql_error()); //execute query

?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0; maximum-scale=1.0; user-scalable=0; width=device-width;">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>IP&T 301 Simulation Website</title>
<link href="styles/style.css" rel="stylesheet" type="text/css" />
<link href="styles/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$('html').keyup(function(e) {
		if (e.keyCode == '112') {
			$("#admin").fadeIn();
			$("#password").focus();
		}
		
	});

});
</script>
</head>
<BODY>
<div id="main">
<div id="header">IP&T 301 Simulation Website</div>
<div id="viewport">


<div id="login-Icons">
<a href="dashboard/google.php?login"><img class="icons" src="img/google.jpg" /><p>Login with Google</p></a>
<a href="dashboard/yahoo.php?login"><img class="icons" src="img/yahoo.png" /><p>Login with Yahoo</p></a>
<a href="dashboard/facebook.php?login"><img class="icons" src="img/facebook.png" /><p>Login with Facebook</p></a>


</div> <!-- end loginIcons -->
</div> <!-- end main --> 

</div> <!-- end view port -->

<div id="admin">
	<form method="post" action="dashboard/admin.php">
	<label>User</label>
	<select name="user_id">
	<? while ($results = mysql_fetch_assoc($list)) { 
	
		echo "<option value='".$results['user_id']."'>".$results['user_name']."</option>\n";
	} ?>
		</select>
		<label>Password</label>
		<input type="password" id="password" name="password" />
	
	
	
	</form>


</div>
</BODY>

</HTML>