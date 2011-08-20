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
$page_id = $_SESSION['current_page'];
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];
$query = "Select * from Assessment where assessment_module='$module' and embedded='1' and assessment_page='$page_id'";
$run = mysql_query($query) or die(mysql_error());
echo "<h3>Quiz</h3>";

while ($results = mysql_fetch_assoc($run)) {
	echo "<h4>{$results['assessment_type']}</h4>";
	echo $results['assessment_text'];
	echo "<br />".$results['assessment_response'];
	$query = "SELECT * From User_Assessment where user_id = '".$user_id."' and assessment_id = '".$results['assessment_id']."'"; //mysql query variable
	$list = mysql_query($query) or die(mysql_error()); //execute query
	$answers = mysql_fetch_assoc($list);//gets info in array
	
if ($answers['user_answer'] !== NULL) {
	if ($results['assessment_type'] == "Multiple Choice" || $results['assessment_type'] == "True or False") {
		?>
		<script>$("input[name='<? echo $results['assessment_id'];?>']")[<? echo $answers['user_answer']; ?>].checked = true;</script>
		<?
	}
 	if ($results['assessment_type'] == "Fill in the Blank") {
 		?>
		<script>$("input[name='<? echo $results['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script>
		<?
 	}
	if ($results['assessment_type'] == "Short Answer") {
 		?>
		<script>$("textarea[name='<? echo $results['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script>
		<?
 	}
}
	
	
}
	
	
	?>
	
	