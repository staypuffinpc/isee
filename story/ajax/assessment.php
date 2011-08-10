<?php
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$user_id = $_SESSION['user_id'];
$module = $_SESSION['module'];


$query_assessment = "Select * from Assessment Where assessment_module='$module'"; //mysql query variable
$list_assessment = mysql_query($query_assessment) or die(mysql_error()); //execute query

?>


<script type="text/javascript">
user = <? echo $user_id; ?>;
module = <? echo $module; ?>;
 	google_analytics();

</script>


<div class="assessment-content">
<table class="assessment">
<tr><td colspan="2">Instructions: The Column on the left has questions you can answer. When you reach a certain point in the story, the answers will be unlocked. Click on the unlocked icons to check your answer.<br />
</td></tr>
<?
while ($assessment = mysql_fetch_assoc($list_assessment)) {
?>
<tr>
<td><? echo "<strong>".$assessment['assessment_type']."</strong><br />".$assessment['assessment_order'].". ".$assessment['assessment_text']."<br /><br />".$assessment['assessment_response']."<br />";?></td>
<td>
<?
$query_lock = "SELECT * FROM User_Progress where progress_user = '".$user_id."' and progress_module='$module'"; //mysql query variable
$list_lock = mysql_query($query_lock) or die(mysql_error()); //execute query
$lock = mysql_fetch_assoc($list_lock);//gets info in array
$pages_visited = explode(", ", $lock['progress_page']);
$query_answer = "SELECT * From User_Assessment where user_id = '".$user_id."' and assessment_id = '".$assessment['assessment_id']."'"; //mysql query variable
	$list_answer = mysql_query($query_answer) or die(mysql_error()); //execute query
	$answer = mysql_fetch_assoc($list_answer);//gets info in array
	
if ($answer['user_answer'] !== NULL) {
	if ($assessment['assessment_type'] == "Multiple Choice" || $assessment['assessment_type'] == "True or False") {
		?>
		<script>$(".assessment input[name='<? echo $assessment['assessment_id'];?>']")[<? echo $answer['user_answer']; ?>].checked = true;</script>
		<?
	}
	if ($assessment['assessment_type'] == "Fill in the Blank") {
 		?>
		<script>$(".assessment input[name='<? echo $assessment['assessment_id'];?>']").val("<? echo $answer['user_answer']; ?>");</script>
		<?
 	}
	if ($assessment['assessment_type'] == "Short Answer") {
 		?>
		<script>$("textarea[name='<? echo $assessment['assessment_id'];?>']").val("<? echo $answer['user_answer']; ?>");</script>
		<?
 	}
}

// prints the correct lock icon

if (in_array($assessment['assessment_page'], $pages_visited)){echo "<img  id='".$assessment['assessment_answer']."' class='answer-img' src='../img/unlocked.png' width='64px'  />";}
else {echo "<img class='answer-img' id='You have not unlocked the answer to question ".$assessment['assessment_id']." yet.' src='../img/locked.png' width='64px' />";}			
	
	
	
	

//end icon printing





?></td>
</tr><?
} while ($assessment = mysql_fetch_assoc($list_assessment));
?>


</table>
</div>
<script>
$(".answer-img").click(function(){alert(this.id);});
</script>