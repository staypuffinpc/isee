<?
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
$story = $_SESSION['story'];
include_once('../db.php');


?>
<h2>Permissions</h2>

<div class="list" id="authorList">
	<? include("authorList.php"); ?>
</div>
<br />
<?
$query = "Select * from Users"; //mysql query variable
$list = mysql_query($query) or die(mysql_error()); //execute query
$values = "[";
while ($results =mysql_fetch_assoc($list)) {

$values=$values."{value: '".$results['user_id']."',
			label: '".$results['user_name']."',
			icon: '".$results['user_image']."'},";

}

$values=$values."]";



?>
<script>

	$(function() {
		var values = <? echo $values; ?>;

		$( "#searchForAuthor" ).autocomplete({
			minLength: 0,
			source: values,
			focus: function( event, ui ) {
				$( "#searchForAuthor" ).val( ui.item.label );
				return false;
			},
			select: function( event, ui ) {
				$("#searchForAuthor").val( ui.item.label );
				$("#searchForAuthor-id").val( ui.item.value );
				selectedValues = $("#searchForAuthorForm").serialize();
				$.ajax({
						type: "POST",
							url: "actions/add_author.php",
							data: selectedValues,
							success: function(phpfile){
							$("#update").append(phpfile);}
						});
				$("#authorList").load("ajax/authorList.php");
				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a><img class='icon' src='" +item.icon + "' />" + item.label + "<br></a>" )
				.appendTo( ul );
		};
	});


</script>

<h4>Add Another Author</h4>

<form id="searchForAuthorForm">
	<div class="ui-widget">
	<input type="text" name="searchForAuthor" id="searchForAuthor" value="" />
	<input type="hidden" name="searchForAuthor-id" id="searchForAuthor-id" value="" />
	</div>
</form>

