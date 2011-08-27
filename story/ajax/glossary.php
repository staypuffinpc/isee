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
$story = $_SESSION['story'];

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
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
</table>
<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>
<p>The glossary contains a list of all of the key terms from throughout the story.  On instructional pages, key terms are the bolded words with a dotted underline.  You can click on that term for a quick definition.</p>
</div>

<script>	google_analytics();
</script>