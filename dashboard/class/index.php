<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/isee/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$class_id = $_GET['class_id'];

$query = "Select * from Classes where class_id = '$class_id'";
$run = mysql_query($query) or die(mysql_error());
$class = mysql_fetch_assoc($run);

$query = "Select * from Class_Stories JOIN Stories on Stories.story_id = Class_Stories.story_id JOIN Users on Stories.story_creator = Users.user_id where class_id = '$class_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Select * from Class_Members Join Users on Class_Members.user_id = Users.user_id where class_id = '$class_id'";
$members = mysql_query($query) or die(mysql_error());


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0, maximum-scale=1.0, user-scalable=0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>Class Management : <? echo $class['class_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="class.css" rel="stylesheet" type="text/css" />
<link href="worksheet-data.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="class.js"></script>
</head>

<body>
<div id="header">Class Management : <? echo $class['class_name']; ?>
<div id="greeting"><? echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> <span class='name'> ".$_SESSION['user_name']."</span>"."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div><!--  end header div -->
<div id="viewport">
	<div class="content" id="page1">
	<div id='story-list'>
	<a class='dbutton' id='add-story'>Add More Stories</a>

	<?
	while ($stories = mysql_fetch_assoc($run)) {
		
		echo "<div class='story'>";
		echo "<a class='story choice' id='".$stories['story_id']."'>";
		echo "<img src=' ../../img/books.png' />";
		echo "<h5>".$stories['story_name']."</h5>";
		echo "<h6>".$stories['user_name']."</h6>";
		
		echo "</a></div>";
	}
	mysql_data_seek($run, 0);
	?>
	<pre>
	<?
	?>
	</pre>
	
	</div>
	<div id='user-data'>
	</div>
	</div>
	<div class="content" id="page2">
	<table>
		<tr>
			<td>Name</td>
			<? 
			while ($stories = mysql_fetch_assoc($run)) {
				echo "<td>".$stories['story_name']."<td>";
			}
			?>
			<td>Email</td>
		</tr>
	
	</table>
	
	<?
	
	while ($results = mysql_fetch_assoc($members)) {
		echo $results['user_name']."<br /";
	
	
	}
	
	
	?>
	
	</div>

</div>
<div id="footer">
	<ul>
	<li>Class Information</li>
	<li>Class Members</li>
	<li><a href='../index.php'>Main Menu</a></li>
	</ul>

</div>
	<div id="fadebackground"></div>
	<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

