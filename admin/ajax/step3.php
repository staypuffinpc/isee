<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$user_id = $_SESSION['module'];

$stem = $_POST['stem'];
$assessment_id = $_POST['assessment_id'];
/* check for Multiple Choice and A */
if ($_POST["choice0"]) {
	$choice0 = $_POST['choice0'];
	$assessment_response =<<<EOF
<input type="radio" name="$assessment_id" value="0">A. $choice0</input><br />
EOF;

/* check for B */
if ($_POST["choice1"]) {
	$choice1 = $_POST['choice1'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="1">B. $choice1</input><br />
EOF;
}

/* check for C */
if ($_POST["choice2"]) {
	$choice2 = $_POST['choice2'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="2">C. $choice2</input><br />
EOF;
}

/* check for D */
if ($_POST["choice3"]) {
	$choice3 = $_POST['choice3'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="3">D. $choice3</input><br />
EOF;
}

/* check for E */
if ($_POST["choice4"]) {
	$choice4 = $_POST['choice4'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="4">E. $choice4</input><br />
EOF;
}

/* check for F */
if ($_POST["choice5"]) {
	$choice5 = $_POST['choice5'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="5">F. $choice5</input><br />
EOF;
}

/* check for G */
if ($_POST["choice6"]) {
	$choice6 = $_POST['choice6'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="6">G. $choice6</input><br />
EOF;
}

/* check for H */
if ($_POST["choice7"]) {
	$choice7 = $_POST['choice7'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="7">H. $choice7</input><br />
EOF;
}

$query = <<<EOF
Update Assessment set assessment_response='$assessment_response' where assessment_id='$assessment_id'
EOF;

$run = mysql_query($query) or die(mysql_error());

}

$query = "Select p.page_name, p.id from Pages p where module='$module'";
$pages = mysql_query($query) or die(mysql_error());



$query = "Update Assessment set assessment_text='$stem' where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Select * from Assessment where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

?>
<script>


</script>
<input type="hidden" name="assessment_id" id="assessment_id" value="<? echo $assessment_id; ?>" />
<div id="assessmentPreview">
	<h4>Assessment Preview</h4>
	<?
	echo $results['assessment_text']."<br />";
	
	switch ($results['assessment_type']) {
		case "Short Answer":
			echo "<br /><textarea disabled></textarea>";
			break;
		case "Fill in the Blank":
			echo "<br /><input type='text' disabled/>";
			break;
		case "Multiple Choice":
			echo $results['assessment_response']."<br />";
			break;
		case "True or False":
			echo "<input type='radio' disabled>True </input><br />";
			echo "<input type='radio' disabled>False </input><br />";
			break;
	}
	
	
	?>
</div>
<div id="assessmentAnswer">
	<h4>Assessment Answer</h4>
	<textarea name="assessment_answer" id="assessment_answer"></textarea>
</div>
<div id="answerAvailability">
	<h4>Answer Availability</h4>
	<select name="assessment_page" id="assessment_page">
	<?
	while ($results = mysql_fetch_assoc($pages)) {
		
		echo "<option value='".$results['id']."'>".$results['page_name']."</option>";
			
	}
	?>	
	</select><br />
	<input type="checkbox" name="embedded" id="embedded" /> Embedded in Page<br />
	<input type="checkbox" name="available" id="available" /> Viewable without visiting Page<br />
</div>