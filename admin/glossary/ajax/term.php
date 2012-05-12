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
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query

$query = "Select page_content, id, page_name from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());

if (isset($_GET['term'])) {$new_term = $_GET['term'];}


?>


<h2>Glossary</h2>
<table class="glossary">
<?
while ($terms = mysql_fetch_assoc($list_terms)) { ?>
	<tr class="clickable-item" id="<? echo $terms['term_id']; ?>">
	<td><img class="deleteTerm <? echo $terms['term_id']; ?>" src="../../img/minus.png" /></td>
	<td class='term'><span class="<? echo $terms['term_id']; ?>"><? echo $terms['term']; ?></span></td>
	<td><span class="<? echo $terms['term_id'];?>D"><? echo $terms['definition']; ?></span><div class='page-list'><span class="page-list-count" id="<? echo $terms['term_id']; ?>P"></span>
	<?
	$counter = 0;
	mysql_data_seek($run, 0);
	while ($results = mysql_fetch_assoc($run)) {
				$pos = stripos($results['page_content'], $terms['term']);
		if ($pos === false) {}
		else {
			echo "<a href='index.php?page_id={$results['id']}'>{$results['page_name']}</a> ";
			$counter++;	
		}
		
	} 
	if ($counter == 1) {echo "<script> document.getElementById('{$terms['term_id']}P').innerHTML = 'Page: ';</script>";}
	if ($counter > 1) {echo "<script> document.getElementById('{$terms['term_id']}P').innerHTML = 'Pages: ';</script>";}

	?></div></td></tr>
<? } ?>
</table>
<div id="term-editor">Click on a row to edit the content.</div>
<script>
<? if (isset($new_term)) {echo "openInTermEditor($new_term);";} ?>
formatGlossary();
markRed();
</script>