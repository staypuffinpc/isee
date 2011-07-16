<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
$term_id = $_POST['term_id'];
include_once('../../authenticate.php');

$user_id=$_SESSION['user_id'];
$module = $_SESSION['module'];


$query_definition = "Select * from Terms Where term_id='$term_id'"; //mysql query variable
$list_definition = mysql_query($query_definition) or die(mysql_error()); //execute query
$definition = mysql_fetch_assoc($list_definition);//gets info in array

?>
<script type="text/javascript">
xinha_config  = null;
xinha_plugins = null;
xinha_editors = [$('textarea')[0].id];
xinha_init();
</script>
<div id="term">
<form id="edit_this_term" method="post">
	<input type="text" name="term" id="term" value="<? echo $definition['term']; ?>" /><br /><br />
	<textarea name="definition" id="definition"><? echo $definition['definition']; ?></textarea>
	<input type="hidden" name="term_id" id="term_id" value="<? echo $definition['term_id']; ?>" />
	<br />
	<a class="btn" id="term-change">Submit Changes</a>


</form>
<div id="charlimitinfo"></div>
<div id="update-status"></div>
</div>



