<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];
include_once('../db.php');

$query = "select 
	ap.user_id,
	ap.module_id,
	u.user_id,
	u.user_name,
	u.user_email,
	u.user_image
	
from 
	Users u,
	Author_Permissions ap
where
 	ap.user_id = u.user_id
 	and
 	ap.module_id = $module
order by
	u.user_name asc"; //mysql query variable

$list = mysql_query($query) or die(mysql_error()); //execute query


?>
<li>Owner: <? echo $module_info['user_name']; ?> <img src="<? echo $module_info['user_image']; ?>" style="position:absolute;top:0;right:0;width:30px;" /></li>
<?
while ($results = mysql_fetch_assoc($list)) {//gets info in array
	
	if ($results['user_name'] !== $module_info['user_name']) {echo "<li><img src='".$results['user_image']."' class='icon' />".$results['user_name']."</li>"; }
}
?>