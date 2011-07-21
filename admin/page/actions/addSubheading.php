<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$page_parent = $_SESSION['current_page'];
$text = $_POST['text'];

$text = "<h3>$text</h3>";


$query = "Insert into Page_Relations (page_child, page_parent, page_stem) values ('$page_parent','$page_parent','$text')";
$run = mysql_query($query) or die(mysql_error());
$lastItemID = mysql_insert_id();


echo "<li class='ui-state-default' id='item[$lastItemID]'>$text</li>"; 
?>