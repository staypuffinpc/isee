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
$module = $_SESSION['module'];
?>

<h2>Assessment Editor</h2>

<a class="btn" id="newItem">Add a new item</a>
<a class="btn" id="backAssessment">Go Back</a>
<a class="btn" id="tostep3">Continue</a>
<a class="btn" id="addItem">Finish</a>
<a class="btn" id="saveItem">Save Item</a>



<div id="assessment-shutters">
	<div id="assessment-window">
	<div class="pane" id="assessmentList">
		<?
		include_once("assessmentList.php");
		?>
	
	</div>
	
	<div class="pane" id="step1">
		<label>Which type of assessment item would you like to create?</label>
		<br />
		<br />
		<div id="assessment-options">
			<a class="btn blockButton" id="trueOrFalse">True or False</a>
			<br />
			<a class="btn blockButton" id="multipleChoice">Multiple Choice</a>
			<br />
			<a class="btn blockButton" id="fillInTheBlank">Fill in the Blank</a>
			<br />
			<a class="btn blockButton" id="shortAnswer">Short Answer</a>
		</div>
	</div> <!-- end step 1 -->
	<div class="pane" id="step2"></div> <!-- end step 2 -->
	<div class="pane" id="step3"></div> <!-- end step 3 -->
	<div class="pane" id="step4"></div> <!-- end step 4 -->
	
	</div> <!-- end assessment window -->
</div> <!-- end assessment shutter -->