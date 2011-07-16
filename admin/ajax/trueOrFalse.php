<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$user_id = $_SESSION['user_id'];

include_once("../actions/assessment_counter.php");

$query = "Insert into Assessment (assessment_module, assessment_type, assessment_order, created_by, created_on) Values ('$module', 'True or False', '$assessment_order', '$user_id', NOW())";
$list = mysql_query($query) or die(mysql_error());
$assessment_id = mysql_insert_id();

$assessment_response = <<<EOF
<input type="radio" name="$assessment_id" value="0" >True </input><br />
<input type="radio" name="$assessment_id" value="1" >False </input><br />
EOF;

$query = "Update Assessment Set assessment_response='$assessment_response' where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());



?>

<h3>True or False</h3>

<label>Type the stem of your True or False question here.</label><br /><br />
<input type="hidden" name="assessment_id" id="assessment_id" value="<? echo $assessment_id; ?>" />

<textarea name="stem" id="stem" class="textarea"></textarea>

