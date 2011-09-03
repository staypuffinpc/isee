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

$query = "Select * from Stories where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());
$story_info = mysql_fetch_assoc($run);

$query = "Select  * from Quiz_Items where story_id='$story' order by RAND()";
$run = mysql_query($query) or die(mysql_error());






?>
<!DOCTYPE HTML>
<html>
<head>
<title>Quiz:<? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?></title>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />


<link href="quiz.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="../js/common.js"></script>

<script type="text/javascript">
$("document").ready(function(){
	
	<?
	$query="Select * from User_Scores where user_id='$user_id' and story_id='$story'";
	$scored = mysql_query($query) or die(mysql_error());
	
	if (mysql_num_rows($scored)>0){echo "window.location='quizResults.php';";}
	?>
	
	
	$("#score").click(function(){
		l = items.length;
		for (j=1; j<l; j++){
			value = $("input[name=answer["+items[j]+"]]:checked").val();
			if (value == null) {alert("You have not completed the test. Please answer question "+j+"."); return;}
		}
		var answer = confirm("Are you sure you want to score your quiz?");
		if (answer) {
		values = $("form").serialize();
		window.location = "quizResults.php?"+values;
		
		}
	});



});

var items = Array();
</script>
</head>
<body>
<div id="header">Quiz: <? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?>
<a id="home" href="index.php?page_id=<? echo $story_info['story_summary']; ?>"></a>
<div id="greeting"><? echo "<img src='".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div>
<div id="toolbar">
	<a class="btn" id="score">Score and Submit</a>
</div>

<div id="viewport">
<div class="content">
<form id="quiz">
<ul id="item-list">
<?
$i=1;
while ($items = mysql_fetch_assoc($run)) {
	echo <<<EOF
	<li id="{$items['item_id']}">
	<div class="ce item_prompt {$items['item_id']}">$i. {$items['item_prompt']}</div>
	<script>items[$i] = {$items['item_id']};</script>
	
EOF;

	switch ($items['item_type']) {
		case "Multiple Choice":
			$query = "Select * from Quiz_Responses where item_id='".$items['item_id']."' order by RAND()";
			$responses = mysql_query($query) or die(mysql_error());
			while ($response = mysql_fetch_assoc($responses)) {
			echo <<<EOF
				<input type="radio" name="answer[{$items['item_id']}]" value="{$response['id']}" class="required"/> <div class="ce item_response {$response['id']}">{$response['item_response']}</div><br />
EOF;
			} //end while
			break;
		case "Fill in the Blank":
			echo <<<EOF
				<input type="text" name="answer[{$items['item_id']}]" value="" class="required"/><br />
EOF;
			break;
	
	
	} //end switch
	
	

	echo "</li>\n";
	$i++;
}

?>


</ul>
</form>
</div>
</div>

</script>
<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

<div id="update"></div>
</body>



</html>