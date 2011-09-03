<?php
/* This file displays the worksheet in story mode. */


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
$story = $_SESSION['story'];

$query_worksheet = "Select * from Worksheet Where worksheet_story='$story' order by worksheet_order ASC"; //mysql query variable
$list_worksheet = mysql_query($query_worksheet) or die(mysql_error()); //execute query

$query = "Select progress_page from User_Progress where progress_user = '$user_id' and progress_story='$story'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

$visited_pages = explode(",",$results['progress_page']);

?>
<script type="text/javascript">
/* this sets js variables from php variables */

user = <? echo $user_id; ?>;
story = <? echo $story; ?>;
 	google_analytics();

</script>


<div class="worksheet">
<h2>Worksheet</h2>
<table class="worksheet">

<?
while ($worksheet = mysql_fetch_assoc($list_worksheet)) {
if ($worksheet['embedded'] == 1 && !in_array($worksheet['worksheet_page'], $visited_pages)){
	echo "<tr class='sorry'>
	<td colspan='2'>
	You have not unlocked question ".$worksheet['worksheet_order'].".
	<td>
	</tr>";

}
else {
?>
<tr>
<td><? echo "<strong>".$worksheet['worksheet_type']."</strong><br />".$worksheet['worksheet_order'].". ".$worksheet['worksheet_text']."<br /><br />".$worksheet['worksheet_response']."";?></td>
<td>
<?
$query_lock = "SELECT * FROM User_Progress where progress_user = '".$user_id."' and progress_story='$story'"; //mysql query variable
$list_lock = mysql_query($query_lock) or die(mysql_error()); //execute query
$lock = mysql_fetch_assoc($list_lock);//gets info in array
$pages_visited = explode(", ", $lock['progress_page']);
$query_answer = "SELECT * From User_Worksheet where user_id = '".$user_id."' and worksheet_id = '".$worksheet['worksheet_id']."'"; //mysql query variable
	$list_answer = mysql_query($query_answer) or die(mysql_error()); //execute query
	$answer = mysql_fetch_assoc($list_answer);//gets info in array
	
if ($answer['user_answer'] !== NULL) {
	if ($worksheet['worksheet_type'] == "Multiple Choice" || $worksheet['worksheet_type'] == "True or False") {
		?>
		<script>$(".worksheet input[name='<? echo $worksheet['worksheet_id'];?>']")[<? echo $answer['user_answer']; ?>].checked = true;</script>
		<?
	}
	if ($worksheet['worksheet_type'] == "Fill in the Blank") {
 		?>
		<script>$(".worksheet input[name='<? echo $worksheet['worksheet_id'];?>']").val("<? echo $answer['user_answer']; ?>");</script>
		<?
 	}
	if ($worksheet['worksheet_type'] == "Short Answer") {
 		?>
		<script>$("textarea[name='<? echo $worksheet['worksheet_id'];?>']").val("<? echo $answer['user_answer']; ?>");</script>
		<?
 	}
}

// prints the correct lock icon

if (in_array($worksheet['worksheet_page'], $pages_visited)){echo "<img  id='".$worksheet['worksheet_id']."' class='answer-img opened' src='../img/open.png' width='64px'  />";}
else {echo "<img class='answer-img closed' id='".$worksheet['worksheet_id']."' src='../img/closed.png' width='64px' />";}			
//end icon printing
?></td>
</tr><?
}} while ($worksheet = mysql_fetch_assoc($list_worksheet));
?>

<tr><td><a class='btn submit'>Submit Answers</a></td></tr>
</table>
</div>
<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>
<p>This worksheet is like a worksheet that you need to complete by reading through the story.  You may answer the questions at any time.  You can unlock the correct answer by visiting the instructional page containing the answer to each question.  Click on the open treasure chest icon to find an explanation of the correct answer.</p>
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