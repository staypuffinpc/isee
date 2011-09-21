<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/isee/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];
$total = 0;
$correct = 0;

if(isset($_GET['answer'])){
	foreach($_GET['answer'] as $key=>$value) {
		$total++;
		$query = "Select item_type from Quiz_Items where item_id = '$key'";
		$run = mysql_query($query) or die(mysql_error());
		$results = mysql_fetch_assoc($run);
		$type = $results['item_type'];
		
		switch ($type) {
			case "Multiple Choice":
				$query = "Select * from Quiz_Items where item_id='$key' and item_answer='$value'";
				$run = mysql_query($query) or die(mysql_error());
				if (!mysql_num_rows($run)) {$answer = 0;} else {$answer=1; $correct++;}	
				break;
			case "Fill in the Blank":
				$value = trim($value); //removed excess spaces at beginning and ending
				$punctuation = array(".",",","!","?");
				$value = str_replace($punctuation,"", $value); 
				
				$query = "Select * from Quiz_Responses where item_id='$key' and item_response like '%$value%'";
				$run = mysql_query($query) or die(mysql_error());
				if (!mysql_num_rows($run)) {$answer = 0;} else {$answer=1; $correct++;}	
				break;
		}		
		
		$query = "Insert into User_Quiz (user_id, item_id, user_answer, story, user_correct) values('$user_id', '$key','$value', '$story','$answer')";
		$run = mysql_query($query) or die(mysql_error());
	}
$percentage = $correct/$total*100;
$query = "Insert into User_Scores (user_id, story_id, total, correct, percentage, date) values ('$user_id', '$story', '$total', '$correct', '$percentage', NOW())";
$run = mysql_query($query) or die(mysql_error());
}



$query = <<<EOF
	Select 
		s.story_id,
		s.story_name,
		s.story_topic,
		s.story_summary,
		q.total,
		q.correct,
		q.percentage 
	from 
		Stories s,
		User_Scores q
	where 
		s.story_id = q.story_id
		and
		s.story_id='$story'
		and
		q.user_id = '$user_id'
EOF;
$run = mysql_query($query) or die(mysql_error());
$story_info = mysql_fetch_assoc($run);

$query = "Select id, page_name from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());
while ($results = mysql_fetch_assoc($run)) {
	$page[$results['id']] = $results['page_name'];

}


$query = "Select * from User_Quiz Join Quiz_Items on User_Quiz.item_id = Quiz_Items.item_id where user_id='$user_id' and story='$story' order by id ASC";
$run = mysql_query($query) or die(mysql_error());




?>
<!DOCTYPE HTML>
<html>
<head>
<title>Quiz Results:<? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?></title>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />


<link href="quiz.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="../js/common.js"></script>

<script type="text/javascript">
$("document").ready(function(){
	
$("input").attr("disabled", true);
});

</script>
</head>
<body>
<div id="header">Quiz Results: <? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?>
<a id="home" href="index.php?page_id=<? echo $story_info['story_summary']; ?>"></a>
<div id="greeting"><? echo "<img src='".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div>
<div id="toolbar">
	<div id="scored">
		<? 
		echo $story_info['correct']."/".$story_info['total']." - ".$story_info['percentage']."%";
		?>
	</div>
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
	<div class="ce item_prompt {$items['item_id']}">$i. {$items['item_prompt']}
EOF;
	if ($items['user_correct'] == 1) {echo "<span class='correct'>Correct!</span>";}	
	else {echo "<span class='incorrect'>Incorrect!</span>";}
	echo "</div>";
	$type = $items['item_type'];
	$query = "Select * from Quiz_Responses where item_id='".$items['item_id']."'";
	$responses = mysql_query($query) or die(mysql_error());
	
	switch ($type) {
		case "Multiple Choice":
			while ($response = mysql_fetch_assoc($responses)) {
				echo <<<EOF
				<input type="radio" name="{$items['item_id']}" value="{$response['id']}"
EOF;
				if ($response['id'] == $items['user_answer']) {echo " checked ";}	
					echo "/> <div class='ce item_response ".$response['id'];	
				if($response['id'] == $items['item_answer']) {echo " correctChoice";}
					echo "'>".$response['item_response']."</div><br />";
			}
			break;
		case "Fill in the Blank":
			echo "Your Response: ".$items['user_answer']."<br />";
			$possibles = "Possible Responses: ";
			$i = 0;
			while ($response = mysql_fetch_assoc($responses)) {
				if ($i==0) {$possibles = $possibles.$response['item_response'];}
				else {$possibles = $possibles.", ".$response['item_response'];}
				$i++;
			}
			echo $possibles;
			break;
	
	
	}
		echo "<div class='explanation'>".$items['item_explanation']."</div>";
		if ($items['item_pages'] !== "") {
		echo "<div class='page-list'>";
			$c = stripos($items['item_pages'], ",");
			if ($c == NULL) {echo "Related Page: ";} else {echo "Related Pages: ";}
			$pages = explode(",", $items['item_pages']);
			foreach($pages as $key => $value) {
			echo "<a href='index.php?page_id=$value'>{$page[$value]}</a> ";
			}			
		
		
		echo "</div>";
		}
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