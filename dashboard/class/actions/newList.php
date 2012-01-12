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
$class_id = $_POST['class_id'];


foreach($_POST['story'] as $key=>$value) {
	$value=$value+1;
	$query = "Select * from Class_Stories where story_id ='$key' and class_id = '$class_id'";
	$run = mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($run) < 1) {
		$query = "Insert into Class_Stories (class_id, story_id, story_order) values ($class_id, $key, $value)";
		$do_it = mysql_query($query) or die(mysql_error());
	}
	else {
		$query = "Update Class_Stories set story_order = '$value' where class_id='$class_id' and story_id = '$key'";
		$do_it = mysql_query($query) or die(mysql_error());
		
		
	}
	
}
