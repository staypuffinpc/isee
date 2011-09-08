<?
/* Show summary info when available */

$user_id = $_SESSION['user_id']; //gets user id

$query_summary = "Select * from Pages where page_summary='1' and story = ".$_SESSION['story']." order by page_name ASC"; //mysql query variable
$list_summary = mysql_query($query_summary) or die(mysql_error()); //execute query
$summary = mysql_fetch_assoc($list_summary);//gets info in array
?>
<p>This Index will allow you to navigate through the simulation to discover other parts of the simulation that you missed. Click on a concept to learn more about it in the simulation.</p>
<p>Before you go, check to make sure you learned what you needed to in this simulation. Click the Worksheet Button to check your understanding of the principles of Behaviorism.</p>
<?
do {
echo "<p><a id='summary".$summary['id']."' class='tracker' href=index.php?page_id=".$summary['id'].">".$summary['page_name']."</a></p><br />";
} while ($summary = mysql_fetch_assoc($list_summary));



?>
<script>	google_analytics();
</script>
