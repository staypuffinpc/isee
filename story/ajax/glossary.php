<?php
/* Shows glossary Items */

include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$user_id = $_SESSION['user_id'];
$module = $_SESSION['module'];

$query_terms = "Select * from Terms Where module='$module' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query
$terms = mysql_fetch_assoc($list_terms);//gets info in array
?>
<h2>Glossary</h2>
<p>The glossary contains a list of all of the key terms from throughout the story.  On instructional pages, key terms are the bolded words with a dotted underline.  You can click on that term for a quick definition.</p>
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