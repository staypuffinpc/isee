<?php
/* Shows glossary Items */

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
$module = $_SESSION['module'];

$query_terms = "Select * from Terms Where module='$module' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query
$terms = mysql_fetch_assoc($list_terms);//gets info in array
?>
<h2>Glossary</h2>
<table class="glossary">
<?
do { ?>
	<tr>
	<td style="font-weight: bold;"><? echo $terms['term']; ?></td>
	<td><? echo $terms['definition']; ?></td>
	
	</tr>


<? } while ($terms = mysql_fetch_assoc($list_terms));


?>
</table><script>	google_analytics();
</script>