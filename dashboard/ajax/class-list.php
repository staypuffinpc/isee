<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home5/byuiptne/public_html/isee/authenticate.php");
	include_once("/home5/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

$query = "Select * from Classes Join Users on Users.user_id = Classes.class_creator where class_creator='$user_id'";
$run = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {

echo "<div class='story'><a class='classLink choice' id='".$results['class_id']."'>";

echo "<img class='icon' src='../img/chalkboard.png' />";
echo "<h5>".$results['class_name']."</h5>";
echo "<h6>".$results['user_name']."</h6>";
echo "<a href='class/index.php?class_id=".$results['class_id']."' class='editLink'><img src='../img/configuration.png' /></a>"; 
echo "</a></div>";
}

$query = "Select * from Class_Members JOIN Classes on Classes.class_id = Class_Members.class_id where Class_Members.user_id = '$user_id'";
$run = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {
echo "<div class='story'><a class='classLink choice' id='".$results['class_id']."'>";

echo "<img class='icon' src='../img/chalkboard.png' />";
echo "<h5>".$results['class_name']."</h5>";
echo "</a></div>";



}

?>