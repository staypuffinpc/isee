<?php
include_once('../../../connectFiles/connectProject301.php');
//include_once('../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
if(!isset($_SESSION)){session_start();}
if(!isset($_SESSION['user_id']))
{
    //Destroy anything they have in their old session.
    session_destroy();
    //If they do not have an active session we redirect them to the login page
    echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=login.php'>";
    //Kill current page since the user needs to login first
    exit();
}
else{
}
$user_id = $_SESSION['user_id'];

echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=dashboard/index.php'>";


?>