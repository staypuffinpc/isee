<?php
include_once('../../../../../connectFiles/connectProject301.php');//database connection info
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php'); //authenticates
$user_id = $_SESSION['user_id'];//gets user info
if(isset($_GET['left'])) {$left = $_GET['left'];}else {$left = 1;}
if(isset($_GET['top'])) {$top = $_GET['top'];}else {$top = 1;}
$page_id = $_GET['page_id']; if ($page_id<1){echo "<script>window.location = '../index.php'</script>";}//gets page id
$_SESSION['current_page'] = $page_id;//sets session

include_once("../../story/db.php");//gets mysql common calls
$module=$page['module'];//gets module
$_SESSION['module']=$module; // sets session module


$query = "Select * from Assessment where assessment_module='$module' and embedded='1'";
$run = mysql_query($query) or die(mysql_error());


?>

<!DOCTYPE >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0; maximum-scale=1.0; user-scalable=0; width=device-width;">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<script type="text/javascript">
    _editor_url  = "../../xinha/";  // (preferably absolute) URL (including trailing slash) where Xinha is installed
    _editor_lang = "en";      // And the language we need to use in the editor.
/*     _editor_skin = "blue-look";   // If you want use a skin, add the name (of the folder) here */
</script>
<script type="text/javascript" src="../../xinha/XinhaCore.js"></script>
<script type="text/javascript" src="../../xinha/my_config.js"></script>

<title></title>

<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="page.css" rel="stylesheet" type="text/css" />

<link href="../../styles/image-creator.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="page.js"></script>

<script type="text/javascript">

<? if ($module == NULL) {?>
window.location = "../../index.php";
<?
}
?>


</script>

</head>
<body>
<form>
<div id="header">
	<input type="hidden" id="page_id" name="page_id" value="<? echo $page_id ?>" />
	<div class="inline"><? echo $page['module_name']; ?></div> : <input class="inline" type="text" name="page_name" id="page_name" value="<? echo $page['page_name'];?>" />  
</div>
<div id="viewport">
<div class="content" id="page1">
<textarea name="content" id="content">
		<? echo $page['page_content']; // Gets Content ?>
</textarea>
<div id="hiddenDiv"><? echo $page['page_content']; // Gets Content ?></div>

	<div id="assessment">
	<h3>Assessment</h3>
	<? 
	while ($results = mysql_fetch_assoc($run)) {
	echo "<div class='assessment_item'>";
	echo "<div class='get_options'></div>";
	echo "<h4>{$results['assessment_type']}</h4>";
	echo "<div class='options'></div>";
	echo "<p><span class='label'>Stem: </span>{$results['assessment_text']}</p>";
	echo "<p><span class='label'>Response: </span><br />{$results['assessment_response']}</p>";
	echo "<p><span class='label'>Answer: </span>{$results['assessment_answer']}</p>";
	
	
	
	echo "</div>";
	}
	
	
	?>
	<a id="assessmentEditor" class="dbutton">Assessment Editor</a>
	</div>
	<div id="navigation">
	<h3>Navigation</h3>
		<input size="80" name="page_navigation_text" id="page_navigation_text" value="<? echo $page['page_navigation_text']; ?>" />
		<ul id="navigation_choices">
		<? 
	do { //generate choice
		if ($results_nav['id'] !== NULL) {
			echo "<li class='ui-state-default' id='item[".$results_nav['page_relation_id']."]'>
				<a class='deleteLink' id='delete".$results_nav['page_relation_id']."'></a>
				<span class='page_stem ".$results_nav['page_relation_id']."'>".$results_nav['page_stem']." </span>	
				<span class='page_link ".$results_nav['page_relation_id']."'>".$results_nav['page_link']."</span>
				<span class='page_punctuation ".$results_nav['page_relation_id']."'>".$results_nav['page_punctuation']."</span></li>";
				
		} // end Null If
	}while ($results_nav = mysql_fetch_assoc($list_nav));		
		 
	
	
	//end generate buttons
	?>
	</ul>
	<a class="btn" id="addSubheading">Add a Navigation Subheading</a>
</div> <!-- end navigation div -->

<? 

echo "<hr><h3>References</h3>";
echo "<textarea name='references' id='references'>".$page['page_references']."</textarea>";
?>
</div>
<div id="borrowedContentPane"><? include('ajax/contentBorrower.php'); ?>
</div>
</div>
<div id="menu">
	<h1>Menu</h1>
	<h2>Page Options</h2>
	<select name="page_type" id="page_type">
	<option value="" <? if ($page['page_type'] == NULL) {echo " selected";} ?>><--Page Type--></option>
	<option value="Story" <? if ($page['page_type'] == "Story") {echo " selected";} ?>>Story</option>
	<option value="Teaching" <? if ($page['page_type'] == "Teaching") {echo " selected";} ?>>Teaching</option>
	<option value="Appendix" <? if ($page['page_type'] == "Appendix") {echo " selected";} ?>>Appendix</option>
	</select>

	<select name="page_summary">
	<option value=""<? if ($page['page_summary'] == NULL) {echo " selected";}?>><--Summary Status--></option>
	<option value="0"<? if ($page['page_summary'] == 0) {echo " selected";}?>>Do Not Include in the Summary</option>
	<option value="1"<? if ($page['page_summary'] == 1) {echo " selected";}?>>Include in the Summary</option>
	<option value="2"<? if ($page['page_summary'] == 2) {echo " selected";}?>>This Page is a Summary Page</option>
	</select>
	<h2>Tools</h2>
	<a class="dbutton" id="imageCreator">Image Creator</a>
	
</div>
<div id="footer">

<ul>
	<li id="save" onClick="update_page();"><img src="../../img/save.png" /><br />Save</li>
	<li id="save-return" onClick="update_exit(<? echo $left; ?>, <? echo $top; ?>);"><img src="../../img/saveMap.png" /><br />Save (Map)</li>
	<li id="view" onClick="view(<? echo $page_id; ?>);"><img src="../../img/saveStory.png" /><br />Save (Story)</li>
	<li id="return" href="../index.php"><img src="../../img/exit.png" /><br />Exit</li>
	
</ul>

</div> <!-- end footer -->
<a id="menuToggle" class="footerToggle">Hide Menu</a>
<a id="borrowToggle" class="footerToggle">View Content Borrower</a>
<div id="update"></div>
<div id="status"></div>
<div id="ajax">Processing<img src="images/ajax-loader.gif" /></div>
<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
<div id="fadebackground"></div>
</form>

</body>
</html>