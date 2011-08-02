<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$embedded = $_POST['embedded'];
$available = $_POST['available'];

$assessment_id = $_POST['assessment_id'];
$assessment_text = $_POST['assessment_text'];
$assessment_page = $_POST['assessment_page'];
$assessment_answer = $_POST['assessment_answer'];
echo "$assessment_id <br />";
echo "$assessment_text <br />";
echo "$assessment_page <br />";
echo "$assessment_answer <br />";
echo $_POST["choice0"]."<br />";


$query = "Update Assessment set assessment_answer='$assessment_answer', assessment_page='$assessment_page', assessment_text='$assessment_text', available='$available', embedded='$embedded' where assessment_id='$assessment_id'";
$run = mysql_query($query) or die(mysql_error());
echo $query;
/* check for Multiple Choice and A */
if ($_POST["choice0"]) {
	$choice0 = $_POST['choice0'];
	$assessment_response =<<<EOF
<input type="radio" name="$assessment_id" value="0">$choice0</input><br />
EOF;

/* check for B */
if ($_POST["choice1"]) {
	$choice1 = $_POST['choice1'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="1">$choice1</input><br />
EOF;
}

/* check for C */
if ($_POST["choice2"]) {
	$choice2 = $_POST['choice2'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="2">$choice2</input><br />
EOF;
}

/* check for D */
if ($_POST["choice3"]) {
	$choice3 = $_POST['choice3'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="3">$choice3</input><br />
EOF;
}

/* check for E */
if ($_POST["choice4"]) {
	$choice4 = $_POST['choice4'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="4">$choice4</input><br />
EOF;
}

/* check for F */
if ($_POST["choice5"]) {
	$choice5 = $_POST['choice5'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="5">$choice5</input><br />
EOF;
}

/* check for G */
if ($_POST["choice6"]) {
	$choice6 = $_POST['choice6'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="6">$choice6</input><br />
EOF;
}

/* check for H */
if ($_POST["choice7"]) {
	$choice7 = $_POST['choice7'];
	$assessment_response =<<<EOF
$assessment_response
<input type="radio" name="$assessment_id" value="7">$choice7</input><br />
EOF;
}

$query = <<<EOF
Update Assessment set assessment_response='$assessment_response' where assessment_id='$assessment_id'
EOF;

$run = mysql_query($query) or die(mysql_error());

}


echo "Item updated.";