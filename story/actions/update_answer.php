<?php
/* This action updates the answers on the assessment when the user answers or changes an answer.  */
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

$user_id = $_GET['user']; // current user id
$name = $_GET['name'];
$value = $_GET['value'];
$module = $_GET['module'];

echo "Loaded";

$query_answer = "Select * from User_Assessment Where user_id='".$user_id."' and assessment_id='".$name."'"; //mysql query variable
$list_answer = mysql_query($query_answer) or die(mysql_error()); //execute query
$answer = mysql_fetch_assoc($list_answer);//gets info in array

if ($answer['user_id'] == NULL) {

$query_update_answer = "insert into User_Assessment (id,user_id, assessment_id, user_answer, module) values (null,'$user_id','$name','$value','$module')";
$list_update_answer = mysql_query($query_update_answer) or die(mysql_error()); //execute query
echo <<<EOF
<script>
count = $("#assessment_count").html()-1;
$("#assessment_count").html(count);
</script>
EOF;
echo "Answer Recorded";
}

else { 

$query_update_answer = "UPDATE User_Assessment SET user_answer = '".$value."' WHERE user_id=".$user_id." and assessment_id=".$name; //mysql query variable
$list_update_answer = mysql_query($query_update_answer) or die(mysql_error()); //execute query
echo "Answer Recorded";

}

?>
