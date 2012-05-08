<?

/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home5/byuiptne/public_html/isee/authenticate.php");
	include_once("/home5/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
?>
<h2>Enroll in a Class</h2>
<p>Please enter your enroll code. This should have been provided by your teacher.</p>
<input class='inputClass' id='enroll_code' name='enroll_code' type='text' />
<br />
<a class='btn' id='enroll'>Enroll</a>
<script>$('#enroll_code').focus();	</script>
