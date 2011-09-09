<?
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
$story_id = $_SESSION['story'];

$query = "Select * from Pages where story='$story_id' and page_type='Teaching' order by print_order ASC";
$run = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {
echo "<div class='page-name'>".$results['page_name']."</div>";

$content = str_replace("/isee/images/", "http://ipt.byu.edu/isee/images/", $results['page_content']);

echo $content;
	
echo "<div class='page-break'> </div>";
}
echo "<h2>References</h2>";
mysql_data_seek($run, 0);
while ($results = mysql_fetch_assoc($run)) {
echo $results['page_references'];
}

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query
$terms = mysql_fetch_assoc($list_terms);//gets info in array
?>
<h2>Glossary</h2>
<table class="glossary">
<?
do { ?>
	<tr>
	<td class="term"><? echo $terms['term']; ?></td>
	<td><? echo $terms['definition']; ?></td>
	
	</tr>


<? } while ($terms = mysql_fetch_assoc($list_terms));


?>
</table>
