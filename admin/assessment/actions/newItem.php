<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$module=$_SESSION['module'];
$user_id=$_SESSION['user_id'];
$type=$_POST['type'];

switch ($type) {
	case "short_answer":
	$type = "Short Answer";
	break;
	case "multiple_choice":
	$type = "Multiple Choice";
	break;
	case "true_false":
	$type = "True or False";
	break;
	case "fill_in_the_blank";
	$type = "Fill in the Blank";
	break;
}

$query = <<<EOF
	Insert into Assessment (assessment_text, assessment_answer, assessment_module, assessment_order, assessment_type, created_by, created_on) values ("Insert question or statement here.","Insert your answer here", "$module", "0", "$type", "$user_id", NOW()) 
EOF;
$run = mysql_query($query) or die(mysql_error());
$lastItemID = mysql_insert_id();

switch ($type) {
	case "Short Answer":
	$query = <<<EOF
	Update Assessment set assessment_response = "<textarea name='$lastItemID'></textarea><br />" where assessment_id='$lastItemID'
EOF;
		break;
	case "Multiple Choice":
	$query = <<<EOF
	Update Assessment set assessment_response = "
	<input type='radio' name='$lastItemID' value='0'>Choice A<br>
	<input type='radio' name='$lastItemID' value='1'>Choice B<br>
	<input type='radio' name='$lastItemID' value='2'>Choice C<br>
	<input type='radio' name='$lastItemID' value='3'>Choice D<br>
	<input type='radio' name='$lastItemID' value='4'>Choice E<br>" where assessment_id='$lastItemID'
EOF;
		break;
	case "True or False":
	$query = <<<EOF
	Update Assessment set assessment_response = "
	<input type='radio' name='$lastItemID' value='0'>True<br>
	<input type='radio' name='$lastItemID' value='1'>False<br>" where assessment_id='$lastItemID'
EOF;
		break;
	case "Fill in the Blank";
	$query = <<<EOF
	Update Assessment set assessment_response = "<input type='text' name='lastItemID' /><br />" where assessment_id='$lastItemID'
EOF;
	break;
}

echo $query;
$run = mysql_query($query) or die(mysql_error());

include("assessment_counter.php");
echo "<script>$('#item-list').load('ajax/assessmentList.php');</script>";
?>