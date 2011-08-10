<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$page_id = $_SESSION['current_page'];
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];
$query = "Select * from Assessment where assessment_module='$module' and embedded='1' and assessment_page='$page_id'";
$run = mysql_query($query) or die(mysql_error());
echo "<h3>Assessment</h3>";

while ($results = mysql_fetch_assoc($run)) {
	echo "<div class='assessment_item'>";
	echo "<div class='get_options'></div>";
	echo "<h4>{$results['assessment_type']}</h4>";
	echo "<div class='options'></div>";
	echo $results['assessment_text'];
	echo "<br />".$results['assessment_response'];
	$query = "SELECT * From User_Assessment where user_id = '".$user_id."' and assessment_id = '".$results['assessment_id']."'"; //mysql query variable
	$list = mysql_query($query) or die(mysql_error()); //execute query
	$answers = mysql_fetch_assoc($list);//gets info in array
	
if ($answers['user_answer'] !== NULL) {
	if ($results['assessment_type'] == "Multiple Choice" || $results['assessment_type'] == "True or False") {
		?>
		<script>$(".assessment_item input[name='<? echo $results['assessment_id'];?>']")[<? echo $answers['user_answer']; ?>].checked = true;</script>
		<?
	}
 	if ($results['assessment_type'] == "Fill in the Blank") {
 		?>
		<script>$(".assessment_item input[name='<? echo $results['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script>
		<?
 	}
	if ($results['assessment_type'] == "Short Answer") {
 		?>
		<script>$(".assessment_item textarea[name='<? echo $results['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script>
		<?
 	}
}
	
	
	echo "</div>";
}
	
	
	?>
	
	