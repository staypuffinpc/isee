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

$query = "Select progress_page from User_Progress where progress_user ='$user_id' and progress_story='$story'";
$run = mysql_query($query) or die(mysql_error());
$progress = mysql_fetch_assoc($run);

$query = "Select page_content, id, page_name from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());



?>
<div class="page2-wrapper">
<a class="edit" href="../admin/terms/index.php">edit</a>
<h2>Glossary</h2>
<table class="glossary">
<?
while ($terms = mysql_fetch_assoc($list_terms)) { ?>
	<tr>
	<td class='term'><? echo $terms['term']; ?></td>
	<td><? echo $terms['definition']; ?><div class='page-list'><span class="page-list-count" id="<? echo $terms['term_id']; ?>"></span>
	<?
	$counter = 0;
	mysql_data_seek($run, 0);
	while ($results = mysql_fetch_assoc($run)) {
		$p = strpos($progress['progress_page'], $results['id']);
		if ($p === false) {}
		else {
		$pos = stripos($results['page_content'], $terms['term']);
		if ($pos === false) {}
		else {
			echo "<a href='index.php?page_id={$results['id']}'>{$results['page_name']}</a> ";
			$counter++;	
		}
		}	
	} 
	if ($counter == 1) {echo "<script>$('span#{$terms['term_id']}').text('Page: ');</script>";}
	if ($counter > 1) {echo "<script>$('span#{$terms['term_id']}').text('Pages: ');</script>";}

	?></div></td></tr>
<? } ?>
</table>
</div>
<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>
<p>The glossary contains a list of all of the key terms from throughout the story.  On instructional pages, key terms are the bolded words with a dotted underline.  You can click on that term for a quick definition.</p>
</div>

<script>
google_analytics();
formatGlossary();
</script>