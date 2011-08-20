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
$module = $_SESSION['module'];

include_once('../db.php');

?>

<h2>Module Information Editor</h2>
<form>
<table>
<tr>
	<td width="150px" id="module_name_label">Name:</td>
	<td width="200px"><input id="module_name" name="module_name" type="text" width="400px" value="<? echo $module_info['module_name'];?>" /></td>
</tr>
<tr>
	<td>Topic:</td>
	<td><input id="module_topic" name="module_topic" type="text" cols="40" value="<? echo $module_info['module_topic']; ?>"/></td>
		
</tr>

<tr>
	<td>First Page:</td>
	<td><select id="module_first_page" name="module_first_page">
		<? do {
		if ($pages['id'] !== $module_info['module_first_page']) {echo "<option value=".$pages['id'].">".$pages['page_name']."</option>";}
		else {echo "<option value=".$pages['id']." selected>".$pages['page_name']."</option>";}
		} while ($pages = mysql_fetch_assoc($list_pages));
	?>
	</select><? mysql_data_seek($list_pages, 0); ?></td>
</tr>
<tr>
	<td>Summary Page:</td>
	<td><select id="module_summary" name="module_summary">
		<? while ($pages = mysql_fetch_assoc($list_pages)) {
		if ($pages['id'] !== $module_info['module_summary']) {echo "<option value=".$pages['id'].">".$pages['page_name']."</option>";}
		else {echo "<option value=".$pages['id']." selected>".$pages['page_name']."</option>";}
		} 
	?>
	</select></td>
</tr>
<tr>
	<td>
	<label>Private</label>
	<input type="radio" name="privacy" value="Private" <? if ($module_info['module_privacy'] == "Private") {echo 'checked';} ?> />
	</td>
	<td>
	<label>Public</label>
	<input type="radio" name="privacy" value="Public" <? if ($module_info['module_privacy'] == "Public") {echo 'checked';} ?>/>
	</td>
</tr>
</table>
</form>

<a class="btn" id="update_module" onClick="update_module();">Update module</a>
