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
$story = $_SESSION['story'];
$child=$_POST['child'];
$parent = $_POST['parent'];
echo "Loaded.<br />";
if ($parent !== $child) {
$query="Insert into Page_Relations (page_relation_id, page_child, page_parent, page_story, page_stem, page_link, page_punctuation) Values (NULL, '$child','$parent','$story','Go to page','$child','.')";
$list_query = mysql_query($query) or die(mysql_error()); //execute query
$lastItemID = mysql_insert_id();



$query_newrelation = "Select * from Page_Relations where page_relation_id='$lastItemID'"; //mysql query variable
$list_newrelation = mysql_query($query_newrelation) or die(mysql_error()); //execute query
$newrelation = mysql_fetch_assoc($list_newrelation);//gets info in array

$line = "<div class='line' id='line".$newrelation['page_relation_id']."'><div title='".$newrelation['page_stem']." ".$newrelation['page_link'].$newrelation['page_punctuation']."' id='arrow".$newrelation['page_relation_id']."' class='arrow'></div></div>";
$line_draw = $newrelation['page_parent'].", ".$newrelation['page_child'].", ".$newrelation['page_relation_id'];


?>
<!DOCTYPE >
<html>
<head>




</head>
<body>
<P>Relation added</P>
<script>
$("#mainbody").append("<? echo $line; ?>");
line(<? echo $line_draw ?>);

</script>

</body>
</html>
<? } 
else {echo "<p>Not Added</p>";}




?>