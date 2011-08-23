<?php
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

$user_id = $_SESSION['user_id'];

/* Gets and/or Sets the current module */
if (!isset($_GET['module'])) {$module=$_SESSION['module'];}
else {$module = $_GET['module'];$_SESSION['module']=$module; }

/* checks to make sure there is a page to display */
if(!isset($_GET['page_id'])) {echo "<script>window.location = '../index.php'</script>";}//gets page id
else {$page_id = $_GET['page_id'];}
$_SESSION['current_page'] = $page_id; // puts page in a session variable

include_once("db.php"); // most of the db calls needed for this page
session_write_close();
$query = "Select * from Assessment where assessment_module='$module' and embedded='1' and assessment_page='$page_id' order by assessment_order ASC";
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
<script type="text/javascript" src="../js/scroll.js"></script> <!-- makes things scroll on idevices -->


<script type="text/javascript">
$(document).ready(function(){
	user = <? echo $user_id; ?>; // sends php variable to js
	module = <? echo $module; ?>;  // sends php variable to js
	var page = <? echo $page_id; ?>;
	<? if (!mysql_num_rows($run)) {?>
		$("#assessment").hide();
	
	<? }
	$length = strlen($page['page_references']);
	if ($length<1) {echo "$('#references').hide();";} 
	if ($user['instructionsShowing'] == "false") {echo "$('.page-instructions').hide();";}
	
	if ($current_assessment > 0) {echo "assessment_announce(".$current_assessment.");"; }
	if ($author) {echo "$('#edit-page, #view-map').show();";} // adds authoring buttons if the user is an author
	if ($summary) { ?> //shows summary button if it is available to the user
		$("#summary-button").show().click(function(){window.location="index.php?page_id=<? echo $page['module_summary']; ?>";});
	<? } ?>
	//the edit button if the person is an author
	$("#edit-page").click(function(){
		window.location = "../admin/page/page.php?page_id="+<? echo $page_id; ?>+"&module="+<? echo $module; ?>;
	}); 
	// event listeners for keyboar keys to avoid navigation and recording issues	
	$('html').keyup(function(event) {
		if (event.target.nodeName == "TEXTAREA" || event.target.nodeName == "INPUT") {return false;} 	
		if (event.keyCode == '69'){window.location = "../admin/page/page.php?page_id="+<? echo $page_id; ?>+"&module="+<? echo $module; ?>;}
	});
	//the map button if the person is an author
	$("#view-map").click(function () {
		window.location="../admin/index.php?module="+<? echo $module; ?>;
	});
});
<? if ($user['instructionsShowing'] == "false") {echo "var instructionsShowing = false;";} else { echo "var instructionsShowing = true;";} ?>

</script>
</head>
<body>
<div id="header"><? echo $page['module_name'].": ".$page['page_name']; // Gets Content ?> 
<a id="home" href="../dashboard/index.php"></a>
<div id="instructionsToggle" class="
	<? 
	if ($user['instructionsShowing'] == "false") {echo 'notShowingInstructions';}
	else {echo 'showingInstructions';}
	?>

">?</div>
<div id="greeting"><? echo "<img src='".$_SESSION['user_image']."'/> ".$_SESSION['user_name']; ?></div>
<a id="logoutFromMenu" class="btn" href="../logout.php">Logout</a>

</div>
<div id="viewport"> <!-- the viewport makes ipad functionality work -->
	<div class="content" id="page1">
<!-- 		<div id="page-content"> -->
			<? echo $page['page_content']; // Gets Content 
			if ($page['page_summary'] == 2) { include("ajax/summary.php");}?>

		<div id="assessment" class="assessment-content">
		<div id="check">check your understanding</div>
		<? 
		while ($Aresults = mysql_fetch_assoc($run)) {
			echo "<h4>{$Aresults['assessment_type']}</h4>";
			echo $Aresults['assessment_text'];
			echo "<br />".$Aresults['assessment_response'];
			$query = "SELECT * From User_Assessment where user_id = '".$user_id."' and assessment_id = '".$Aresults['assessment_id']."'"; //mysql query variable
			$list = mysql_query($query) or die(mysql_error()); //execute query
			$answers = mysql_fetch_assoc($list);//gets info in array
	
			if ($answers['user_answer'] !== NULL) {
				if ($Aresults['assessment_type'] == "Multiple Choice" || $Aresults['assessment_type'] == "True or False") {
					?><script>$("input[name='<? echo $Aresults['assessment_id'];?>']")[<? echo $answers['user_answer']; ?>].checked = true;</script><? }
			 	if ($Aresults['assessment_type'] == "Fill in the Blank") {
			 		?><script>$("input[name='<? echo $Aresults['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script><? }
				if ($Aresults['assessment_type'] == "Short Answer") {
			 		?><script>$("textarea[name='<? echo $Aresults['assessment_id'];?>']").val("<? echo $answers['user_answer']; ?>");</script><? }
			}
			
		}?>
		</div>
		
<!-- 		Displays navigation choices -->
		<div id="navigation">
			<div id="decision-time">decision time</div>
			<h3><? echo $page['page_navigation_text']; ?></h3>
			<? 
			while ($results_nav = mysql_fetch_assoc($list_nav)) { //generate choice
					echo "<p>".$results_nav['page_stem']." "; ?>	
					<a id="navigation <? echo $results_nav['id'];?>"  class="tracker" href="index.php?page_id=<? echo $results_nav['id'];?>&module=<? echo $module; ?>"><? //makes page link 
					echo $results_nav['page_link']."</a>".$results_nav['page_punctuation'];?>
					</p> <? 
			}		
			//end generate buttons
			?>
		</div> <!-- end navigation div -->

<div id="references">
	<div id="references-title">references</div>
	<? echo $page['page_references']; ?>
</div>

<!-- </div> <!-- end page content div --> 

<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>

<p>The purpose of this simulation is to help you not only learn the principles of <? echo $page['module_topic'];?>, but see them in action.  Our hope is that by situating them in a story, they will be more memorable and easier to apply as you enter your chosen profession.</p>
<p>The simulation will lead you through the instruction and the story simultaneously.  Story pages present you with an actual context to apply the topics covered in this chapter.  On these pages, you’re given choices of what action you would like to take.  At times, you’ll “step out” of the story and be presented with an instructional page.  Instructional pages are presented “just in time,” to teach you a concept at the moment (or right before) you’ll see that concept play out in the story.</p>



</div>

</div> <!-- end page1 div -->
<div class="content" id="page2"></div>
</div>


<div id="footer">

<a class="btn" id="edit-page">edit page</a>
<a class="btn" id="view-map">view story map</a>
<a class="btn" id="summary-button">Go to Summary</a>

	<ul>
		<li id="story"><div><img src="../img/glossary.png" /></div><p>Story</p></li>
		<li id="glossary"><div><img src="../img/glossary.png" /></div><p>Glossary</p></li>
<!-- 		<li id="comments"><div><img src="../img/chat.png" /></div>Comments</li> -->
<!-- 		<li id="journal"><div><img src="images/journal.png" /></div>Journal</li> -->
		<li id="assessment"><div><img src="../img/bar-chart.png" /></div><p>Quiz</p><div id="assessment_count"><? echo $assessment_count; ?></div></li>
		<li id="map"><div><img src="../img/tree.png" /></div><p>Progress Map</p></li>
		
	</ul>
	

</div>


<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>
<div id="fadebackground"></div>
<div id="update"></div>

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
	<img src="../img/open.png" width="64px" />
</div>


<div id="popup" class="popup"><div class="close-icon"></div>
<div id="popup-content"></div> <!-- end popup-content -->
</div> <!-- end popup -->
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