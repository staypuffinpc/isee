<?php
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');

$user_id=$_SESSION['user_id'];
$module = $_SESSION['module'];

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
	$("tr:odd").css("background-color" , "#CCCCCC");
	$("tr").click(function () {
		if (this.id) {
		$.ajax({
			type: "POST",
			url: "ajax/term_editor.php",
			data: "term_id="+this.id,
			success: function(phpfile){
				$("#tabular-data-info").html(phpfile);
				
			}
		});
		}
	});
	$("#new-term").click(function(){
	$("#tablular-data tr:last").after("<tr><td></td><td></td></tr>");


});

</script>
</div>