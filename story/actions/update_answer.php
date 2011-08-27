<?php
/* This action updates the answers on the worksheet when the user answers or changes an answer.  */
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
$story = $_GET['story'];

echo "Loaded";

$query_answer = "Select * from User_Worksheet Where user_id='".$user_id."' and worksheet_id='".$name."'"; //mysql query variable
$list_answer = mysql_query($query_answer) or die(mysql_error()); //execute query
$answer = mysql_fetch_assoc($list_answer);//gets info in array

if ($answer['user_id'] == NULL) {

$query_update_answer = "insert into User_Worksheet (id,user_id, worksheet_id, user_answer, story) values (null,'$user_id','$name','$value','$story')";
$list_update_answer = mysql_query($query_update_answer) or die(mysql_error()); //execute query
echo <<<EOF
<script>
count = $("#worksheet_count").html()-1;
$("#worksheet_count").html(count);
</script>
EOF;
echo "Answer Recorded";
}

else { 

$query_update_answer = "UPDATE User_Worksheet SET user_answer = '".$value."' WHERE user_id=".$user_id." and worksheet_id=".$name; //mysql query variable
$list_update_answer = mysql_query($query_update_answer) or die(mysql_error()); //execute query
echo "Answer Recorded";

}

?>
