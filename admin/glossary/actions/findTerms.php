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
$story = $_SESSION['story'];

$query = "Select page_content from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());


echo "<div id='alltext' style='display:none'>";
while ($results = mysql_fetch_assoc($run)) {
	echo $results['page_content'];

}



echo "</div>";
?>
<script>

$(".keyterm").each(function(){
	term = $(this).text();
	$.ajax({
		type: "POST",
		url: "actions/addTerm.php",
		data: "keyterm="+$(this).text(),
		success: function(a){$("#update").append(a);}
	});
});
</script>
