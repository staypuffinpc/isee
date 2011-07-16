<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];

include_once("../actions/assessment_counter.php");

$query = "Insert into Assessment (assessment_module, assessment_type, created_by, created_on, assessment_order) Values ('$module', 'Multiple Choice', '$user_id', NOW(), '$assessment_order')";
$list = mysql_query($query) or die(mysql_error());
$assessment_id = mysql_insert_id();





/*
$assessment_response = <<<EOF
nothing yet
EOF;

$query = "Update Assessment Set assessment_response='$assessment_response' where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());
*/



?>
<script>
var count = 1;
function add_response() {
	count++;
	if (count > 7) {alert("You can not have more than 8 responses.");}
	else {
		$("#responses").append("<label>Response "+(count+1)+"</label><textarea id='choice"+count+"' class='multiple_choice'></textarea>");
	}

}

</script>
<h3>Multiple Choice</h3>

<label>Type the stem of your multiple choice question here.</label><br /><br />
<input type="hidden" name="assessment_id" id="assessment_id" value="<? echo $assessment_id; ?>" />

<textarea name="stem" id="stem" class="textarea" style="height:100px"></textarea>
<div id="responses">
<label>Response 1</label>
<textarea id="choice0" class="multiple_choice"></textarea>

<br />
<label>Response 2</label>
<textarea id="choice1" class="multiple_choice"></textarea>
</div>
<br />
<a class="btn" onclick="add_response();">Add another Response</a>

