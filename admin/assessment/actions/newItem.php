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
$module=$_SESSION['module'];
$user_id=$_SESSION['user_id'];
$type=$_POST['type'];
$embedded = $_POST['embedded'];
if ($embedded == 1) {$assessment_page = $_SESSION['current_page'];} else {$assessment_page = 000;}

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
	Insert into Assessment (assessment_text, assessment_answer, assessment_module, assessment_order, assessment_type, created_by, created_on, embedded, assessment_page) values ("Insert question or statement here.","Insert your answer here", "$module", "0", "$type", "$user_id", NOW(), "$embedded", "$assessment_page") 
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
	Update Assessment set assessment_response = "<input type='radio' name='$lastItemID' value='0'><div class='ce response $lastItemID'>Choice A</div><br>
	<input type='radio' name='$lastItemID' value='1'><div class='ce response $lastItemID'>Choice B</div><br />
	<input type='radio' name='$lastItemID' value='2'><div class='ce response $lastItemID'>Choice C</div><br />
	<input type='radio' name='$lastItemID' value='3'><div class='ce response $lastItemID'>Choice D</div><br />
	<input type='radio' name='$lastItemID' value='4'><div class='ce response $lastItemID'>Choice E</div><br />" where assessment_id='$lastItemID'
EOF;
		break;
	case "True or False":
	$query = <<<EOF
	Update Assessment set assessment_response = "<input type='radio' name='$lastItemID' value='0'>True<br>
	<input type='radio' name='$lastItemID' value='1'>False<br>" where assessment_id='$lastItemID'
EOF;
		break;
	case "Fill in the Blank";
	$query = <<<EOF
	Update Assessment set assessment_response = "<input type='text' name='$lastItemID' /><br />" where assessment_id='$lastItemID'
EOF;
	break;
}

echo $query;
$run = mysql_query($query) or die(mysql_error());

include("assessment_counter.php");
echo "<script>$('#item-list').load('ajax/assessmentList.php');</script>";
?>
