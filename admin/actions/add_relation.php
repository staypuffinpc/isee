<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
$child=$_POST['child'];
$parent = $_POST['parent'];
echo "Loaded.<br />";
if ($parent !== $child) {
$query="Insert into Page_Relations (page_relation_id, page_child, page_parent, page_module, page_stem, page_link, page_punctuation) Values (NULL, '$child','$parent','$module','Go to page','$child','.')";
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