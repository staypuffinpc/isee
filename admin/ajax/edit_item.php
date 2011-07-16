<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];


$assessment_id = $_POST['id'];

$query = "Select * from Assessment where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Select p.page_name, p.id from Pages p where module='$module'";
$pages = mysql_query($query) or die(mysql_error());


$results = mysql_fetch_assoc($run);

?>

<script>


</script>

<h5>Item Stem</h5>
<textarea name="stemEdit" id="stemEdit" class='edit'><? echo $results['assessment_text']; ?></textarea>
<div id="responses">
<?
if ($results['assessment_type'] == "Multiple Choice") {
	$new_response = str_replace("<input type=\"radio\" ","Response <br/><textarea class='multiple_choice' ",$results['assessment_response']);
	$new_response = str_replace("</input>","</textarea>",$new_response);
	$new_response = str_replace("value=\"","id=\"choice",$new_response);

	echo $new_response;
}


?>
</div>
<h5>Item Answer</h5>
<textarea name="assessment_answerEdit" id="assessment_answerEdit" class='edit'><? echo $results['assessment_answer']; ?></textarea>
<input type="hidden" name="assessment_idEdit" id="assessment_idEdit" value="<? echo $assessment_id; ?>" />
<!-- <input type="hidden" name="assessment_responseEdit" id="assessment_responseEdit" /> -->

<h5>Answer Availability</h5>
	<select name="assessment_pageEdit" id="assessment_pageEdit">
	<?
	while ($results = mysql_fetch_assoc($pages)) {
		
		echo "<option value='".$results['id']."'>".$results['page_name']."</option>";
			
	}
	?>	
	</select>
<br />
<br />

<div id="saveItemStatus"></div>

