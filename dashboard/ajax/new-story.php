<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>
<h2> New Story </h2>
<form>
<table>
<tr>
	<td width="150px" id="module_name_label">Name:</td>
	<td width="200px"><input id="module_name" name="module_name" type="text" width="400px" value="" /></td>
</tr>
<tr>
	<td id="topic">Topic:</td>
	<td><input id="module_topic" name="module_topic" type="text" cols="40" value=""/></td>
		
</tr>
</table>
<br />
</form>
<script>$("#module_name").focus();</script>
<a class="btn" onclick="create_story();">Create Story</a>
