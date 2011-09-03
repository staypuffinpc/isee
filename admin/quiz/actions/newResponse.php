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
$item_id = $_POST['item_id'];
$item_response = "new choice";
$query = "Insert into Quiz_Responses (item_id, item_response) values ('$item_id', '$item_response')";
$run = mysql_query($query) or die(mysql_error());
$lastItemId = mysql_insert_id();

$query = "Select item_type from Quiz_Items where item_id='$item_id'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

switch ($results['item_type']) {
	case "Multiple Choice":
		echo <<<EOF
			<script>
			$("li#$item_id div.responseSection").append('<div class="deleteResponse $lastItemId" title="Click to delete this response.">x</div><input type="radio" name="$item_id" value="$lastItemId" /> <div class="ce item_response $lastItemId">$item_response</div><br />');
			$(".ce").attr("contenteditable", true);
			</script>
EOF;
	break;
	case "Fill in the Blank":
		echo <<<EOF
			<script>
			$("li#$item_id div.responseSection").append('<div class="deleteResponse $lastItemId" title="Click to delete this response.">x</div><div class="ce item_response $lastItemId">$item_response</div><br />');
			$(".ce").attr("contenteditable", true);
			</script>
EOF;
	
	
	
	break;


}	
		
		
		?>
		