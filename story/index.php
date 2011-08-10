<?php
// include_once('../../../../connectFiles/connectProject301.php');
include_once('../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../authenticate.php');
$user_id = $_SESSION['user_id'];

if (!isset($_GET['module'])) {$module=$_SESSION['module'];}
else {$module = $_GET['module'];$_SESSION['module']=$module; }

if(!isset($_GET['page_id'])) {echo "<script>window.location = '../index.php'</script>";}//gets page id
else {$page_id = $_GET['page_id'];}
$_SESSION['current_page'] = $page_id;


include_once("db.php");
include_once("user_db.php");
//this get journal info
$query_record_check = "Select * from Journal where journal_user  = '".$user_id."' and journal_page = '".$page_id."'"; //mysql query variable
$list_record_check = mysql_query($query_record_check) or die(mysql_error()); //execute query
$record_check = mysql_fetch_assoc($list_record_check);//gets info in array

do { // this checks to see if there is journal goals
	if($record_check['journal_text'] == NULL){$journal = "Enter Text Here";}
	else {$journal=$record_check['journal_text'];}
} while ($record_check = mysql_fetch_assoc($list_record_check));
session_write_close();
//end journal info getting
$query = "Select * from Assessment where assessment_module='$module' and embedded='1' and assessment_page='$page_id'";
$run = mysql_query($query) or die(mysql_error());

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0; maximum-scale=1.0; user-scalable=0; width=device-width;">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title><? echo $page['module_name'].": ".$page['page_name']; // Gets Content ?> </title>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<link href="story.css" rel="stylesheet" type="text/css" />
<link href="../styles/stylist.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="story.js"></script>
<script type="text/javascript" src="../js/jquery-scroll.js"></script>
<script type="text/javascript" src="../js/scroll.js"></script>


<script type="text/javascript">
$(document).ready(function(){
user = <? echo $user_id; ?>;
module = <? echo $module; ?>;
var page = <? echo $page_id; ?>;
<? if ($instructions) {echo "instructions();";}?>
<? if ($current_assessment > 0) {echo "assessment_announce(".$current_assessment.");"; }
if ($author) {echo "$('#edit-page, #view-map').show();";}
if ($summary) { ?>
$("#summary-button").show().click(function(){
		window.location="index.php?page_id=<? echo $page['module_summary']; ?>";
});
<? } ?>
$("#edit-page").click(function(){
	window.location = "../admin/page/page.php?page_id="+<? echo $page_id; ?>+"&module="+<? echo $module; ?>;
	
	
	});
	
$('html').keyup(function(event) {
		if (event.target.nodeName == "TEXTAREA" || event.target.nodeName == "INPUT") {return false;} 	
		if (event.keyCode == '69')
		{
		window.location = "../admin/page/page.php?page_id="+<? echo $page_id; ?>+"&module="+<? echo $module; ?>;
		}
	});
	$("#view-map").click(function () {
		window.location="../admin/index.php?module="+<? echo $module; ?>;
	});
});
</script>
</head>
<body>
<!-- <div id="main"> -->
<div id="header"><? echo $page['module_name'].": ".$page['page_name']; // Gets Content ?> </div>
<div id="journal"><h1>Journal</h1>
	<form>
	<input type="hidden" name="update" value="1" />
	<input type="hidden" name="page_id" value="<? echo $page_id; ?>" />
	<textarea name="entry" id="entry"><? echo $journal; ?></textarea>
	<br />
	<a id="submit" class="btn" name="submit"  onClick="write_to_journal();">Record Entry</a>
	<div id="write-status"></div>
	</form>
</div>
<div id="viewport">

<div class="content" id="page1">
<div id="page-content">
		<? echo $page['page_content']; // Gets Content 
		if ($page['page_summary'] == 2) { include("ajax/summary.php");}?>
	<hr>
	<div id="assessment">
	<h3>Assessment</h3>
	<? 
	while ($results = mysql_fetch_assoc($run)) {
	echo "<div class='assessment_item'>";
	echo "<div class='get_options'></div>";
	echo "<h4>{$results['assessment_type']}</h4>";
	echo "<div class='options'></div>";
	echo $results['assessment_text'];
	echo "<br />".$results['assessment_response'];
	$query = "SELECT * From User_Assessment where user_id = '".$user_id."' and assessment_id = '".$results['assessment_id']."'"; //mysql query variable
	$list = mysql_query($query) or die(mysql_error()); //execute query
	$answers = mysql_fetch_assoc($list);//gets info in array
	
if ($answers['user_answer'] !== NULL) {
	if ($results['assessment_type'] == "Multiple Choice" || $results['assessment_type'] == "True or False") {
		?>
		<script>$(".assessment_item input[name='<? echo $results['assessment_id'];?>']")[<? echo $answers['user_answer']; ?>].checked = true;</script>
		<?
	}
 	if ($results['assessment_type'] == "Fill in the Blank") {
 		?>
		<script>$(".assessment_item input[name='<? echo $results['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script>
		<?
 	}
	if ($results['assessment_type'] == "Short Answer") {
 		?>
		<script>$(".assessment_item textarea[name='<? echo $results['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script>
		<?
 	}
}
	
	
	echo "</div>";
	}
	
	
	?>
	
	
	
	</div>
	<div id="navigation">
		<h3><? echo $page['page_navigation_text']; ?></h3>
		<? 
	do { //generate choice
		if ($results_nav['id'] !== NULL) {
			echo "<p>".$results_nav['page_stem']." "; ?>	
				<a id="navigation <? echo $results_nav['id'];?>"  class="tracker" href="index.php?page_id=<? echo $results_nav['id'];?>&module=<? echo $module; ?>"><? //makes page link 
		echo $results_nav['page_link']."</a>".$results_nav['page_punctuation'];?>
		
		
		</p> <? 
				
		} // end Null If
	}while ($results_nav = mysql_fetch_assoc($list_nav));		
	
	
	
	//end generate buttons
	?>
</div> <!-- end navigation div -->

<? 
$length = strlen($page['page_references']);

if ($length>1) { echo "<hr><h3>References</h3>";
echo $page['page_references']; }?>

</div> <!-- end page content div -->


</div> <!-- end page1 div -->
<div class="content" id="page2"></div>
</div>
<div id="footer">
<a class="btn" id="edit-page">Edit Page</a>
<a class="btn" id="view-map">View Story Map</a>
<a class="btn" id="summary-button">Go to Summary</a>

	<ul>
		<li id="glossary"><div><img src="../img/glossary.png" /></div>Glossary</li>
		<li id="comments"><div><img src="../img/chat.png" /></div>Comments</li>
<!-- 		<li id="journal"><div><img src="images/journal.png" /></div>Journal</li> -->
		<li id="assessment"><div><img src="../img/bar-chart.png" /></div>Assessment</li>
		<li id="map"><div><img src="../img/tree.png" /></div>Progress Map</li>
		
	</ul>
	<div id="assessment_count"><? echo $assessment_count; ?></div>

</div>

<a class="btn" id="back-button">Go Back</a>
<a class="btn" id="options-button"><img height="12px" style="float:left;" src="../img/configuration.png" />Options</a>
<a class="btn" id="journal-button">Show Journal</a>

<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>
<div id="fadebackground"></div>
<div id="update"></div>

<div id="user" class="popup"><div class="close-icon"></div>
	<a id="viewinstructions" class="button blockButton">View Instructions</a>
<div class="explanation">Clicking on this button will clear your history for this story.</div>
	<a id="progressClear" class="button blockButton">Clear Progress</a>
<div class="explanation">Clicking on this button will clear your assessment for this story.</div>
	<a id="assessmentClear" class="button blockButton">Clear Assessment</a>
<div class="explanation">Clicking on this button will take you to the Main Menu.</div>
	<a id="mainMenu" class="button blockButton">Main Menu</a>
<div class="explanation"></div>
	<a id="logout" class="button blockButton">Logout</a>

</div> <!-- end user div -->
<div id="definition" class="popup"><div class="close-icon"></div>
	<div id="definition-content">
	Definition goes here.
	</div>

</div>
</div>

<div id="assessment_announce_window">
	<? if ($current_assessment == 1) {echo "You have unlocked 1 answer on the quiz.";}
		else {echo "You have unlocked ".$current_assessment." answers on the quiz.";}
	?>
	<img src="../img/unlocked.png" width="64px" />
	


</div>
<div id="popup" class="popup"><div class="close-icon"></div>
<div id="popup-content">

<h2>Simulation Instructions</h2>
<div id="instructions">
<h4>Overview</h4>
<p>The purpose of this simulation is to help you not only learn the principles of <? echo $page['module_topic'];?>, but see them in action.  Our hope is that by situating them in a story, they will be more memorable and easier to apply as you enter your chosen profession.</p>
<p>The simulation will lead you through the instruction and the story simultaneously.  Story pages present you with an actual context to apply the topics covered in this chapter.  On these pages, you’re given choices of what action you would like to take.  At times, you’ll “step out” of the story and be presented with an instructional page.  Instructional pages are presented “just in time,” to teach you a concept at the moment (or right before) you’ll see that concept play out in the story.</p>
<h4>Glossary</h4>
<p>The glossary contains a list of all of the key terms from throughout the story.  On instructional pages, key terms are the bolded words with a dotted underline.  You can click on that term for a quick definition.</p>
<h4>Assessment</h4>
<p>This assessment is like a worksheet that you need to complete by reading through the story.  You may answer the questions at any time.  You can unlock the correct answer by visiting the instructional page containing the answer to each question.  Click on the open treasure chest icon to find an explanation of the correct answer.</p>
<h4>Progress Map</h4>
<p>This map shows where you’ve been in the story so far.  Green pages contain story-related content, blue pages contain instructional content, and gray pages are ones you have not yet visited but have seen a link to at some point in the story.  The map will grow as you explore the story.  You can click on any page you’ve already visited to go directly to that part of the story.
(HINT: once you “solve” the story, the entire map will be unlocked and you can visit any page directly from the map.)</p>
<h4>Appendices</h4>
<p>These appendices include additional tools to help you learn the material.  Once you have “unlocked” an appendix in the story, it is available at any time throughout the rest of the simulation.</p>
<h4>Comments</h4>
<p>Join the discussion!  Use the comments bar to read and react to other students’ thoughts on behaviorism.</p>
</div>

</div> <!-- end popup-content -->
</div>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23109189-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>