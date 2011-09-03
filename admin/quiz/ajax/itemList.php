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
$story = $_SESSION['story'];

$query = "Select  * from Quiz_Items where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());


while ($items = mysql_fetch_assoc($run)) {
	echo <<<EOF
	<li id="{$items['item_id']}">
	<div class="delete {$items['item_id']}" title="Click to delete this item">x</div>
	<p>Question Prompt ({$items['item_type']})</p>
	<div class="ce item_prompt {$items['item_id']}">{$items['item_prompt']}</div>
	<p>Responses <a class='btn {$items['item_id']} newResponse'>Add a new response</a></p>
	<div class="responseSection">	

EOF;

	$query = "Select * from Quiz_Responses where item_id='".$items['item_id']."'";
	$responses = mysql_query($query) or die(mysql_error());
	while ($response = mysql_fetch_assoc($responses)) {
/* 	if ($items['item_type') == "Multiple Choice") { */
	echo <<<EOF
	<div class="deleteResponse {$response['id']}" title="Click to delete this response.">x</div><input type="radio" name="{$items['item_id']}" value="{$response['id']}" 
EOF;
	if ($items['item_answer'] == $response['id']) {echo " checked ";}	

	echo <<<EOF
	/> <div class="ce item_response {$response['id']}">{$response['item_response']}</div><br />
EOF;
	/*
} //end multiple choice if
	if ($items['item_type'] == "Fill in the Blank"){
	
	} // end fill in the blank item type
*/
	} //end response while
	

	echo <<<EOF
	</div>
	<p>Answer Explanation</p>
	<div class="ce item_explanation {$items['item_id']}">{$items['item_explanation']}</div>	
	</li>
EOF;


}

?>