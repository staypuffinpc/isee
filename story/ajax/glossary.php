<?php
/* Shows glossary Items */

/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/isee/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/isee/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query

$query = "Select page_content, id, page_name from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());


?>
<h2>Glossary</h2>
<table class="glossary">
<?
while ($terms = mysql_fetch_assoc($list_terms)) { ?>
	<tr>
	<td class='term'><? echo $terms['term']; ?></td>
	<td><? echo $terms['definition']; ?>
	<?
	mysql_data_seek($run, 0);
	while ($results = mysql_fetch_assoc($run)) {
		$pos = strpos($results['page_content'], $terms['term']);
		if ($pos === false) {}
		else {
			echo "<a href='index.php?page_id={$results['id']}'>{$results['page_name']}</a> ";
		}
	} ?>
	</td></tr>
<? } ?>
</table>
<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>
<p>The glossary contains a list of all of the key terms from throughout the story.  On instructional pages, key terms are the bolded words with a dotted underline.  You can click on that term for a quick definition.</p>
</div>

<script>
google_analytics();
formatGlossary();
</script>