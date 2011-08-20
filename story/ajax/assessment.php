<?php
/* This file displays the assessment in story mode. */


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
$module = $_SESSION['module'];

$query_assessment = "Select * from Assessment Where assessment_module='$module' order by assessment_order ASC"; //mysql query variable
$list_assessment = mysql_query($query_assessment) or die(mysql_error()); //execute query

$query = "Select progress_page from User_Progress where progress_user = '$user_id' and progress_module='$module'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$visited_pages = explode(",",$results['progress_page']);

?>
<script type="text/javascript">
/* this sets js variables from php variables */

user = <? echo $user_id; ?>;
module = <? echo $module; ?>;
 	google_analytics();

</script>


<div class="assessment-content">
<h2>Assessment</h2>
<table class="assessment">

<?
while ($assessment = mysql_fetch_assoc($list_assessment)) {
if ($assessment['embedded'] == 1 && !in_array($assessment['assessment_page'], $visited_pages)){
	echo "<tr></tr>";

}
else {
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

if (in_array($assessment['assessment_page'], $pages_visited)){echo "<img  id='".$assessment['assessment_id']."' class='answer-img opened' src='../img/open.png' width='64px'  />";}
else {echo "<img class='answer-img closed' id='".$assessment['assessment_id']."' src='../img/closed.png' width='64px' />";}			
//end icon printing
?></td>
</tr><?
}} while ($assessment = mysql_fetch_assoc($list_assessment));
?>


</table>
</div>
<script>
$(".closed").click(function(){alert("You have not visited the page containing the answer to this question yet.")});
$(".opened").click(function(){
	id = this.id;
	$.ajax({
		type: "POST",
		url: "ajax/answer.php",
		data: "id="+id,
		success: function(phpfile){
			$("#popup-content").html(phpfile);
			$("#popup").css({
				width: "600px",
				height: "300px",
				"left" : "50%",
				"margin-left" : "-300px",
				"top" : "50%",
				"margin-top" : "-150px"
			
			
			});
			$("#popup, #fadebackground").show();
		}
		});

});
</script>