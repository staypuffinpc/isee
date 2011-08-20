<?php
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

$user_id=$_SESSION['user_id'];
$module = $_SESSION['module'];

if (isset($_GET['term'])) {$new_term = $_GET['term'];}
$query_term = "Select * from Terms Where module = '$module' ORDER BY term ASC"; //mysql query variable
$list_term = mysql_query($query_term) or die(mysql_error()); //execute query
$term = mysql_fetch_assoc($list_term);//gets info in array

?>
<h2>Glossary</h2>
<a class="btn" id="new-term">Add New Term</a>
<div id="tabular-data-table">
<table id="tabular-data">
	<tr>
		<td width = "20%" class="header">Term</td>
		<td width = "80%" class="header">Explanation</td>
	</tr>
	
	<?
	while ($term = mysql_fetch_assoc($list_term)) {
	echo <<<EOF
	<tr class="clickable-item" id="{$term['term_id']}">
		<td><span class="{$term['term_id']}">{$term['term']}</span></td>
		<td><span class="{$term['term_id']}D">{$term['definition']}</span></td>
	</tr>
EOF;
}?>

</table>
</div>
<div id="tabular-data-info">Click on a row to edit the content.</div>
<script>
$("document").ready(function(){
	$("tr:odd").css("background-color" , "#CCCCCC");
	<? echo "openInTermEditor($new_term);";?>
});
</script>
</div>