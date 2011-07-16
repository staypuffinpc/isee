<? 
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
$term = $_GET['term'];

$query_definition = "Select * from Terms Where term like '%$term%'"; //mysql query variable
$list_definition = mysql_query($query_definition) or die(mysql_error()); //execute query
$definition = mysql_fetch_assoc($list_definition);//gets info in array

echo $definition['definition']; ?>
