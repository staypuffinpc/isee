<?php
error_reporting(E_ALL);
$updown="up"; //set to up if up, message if down

if ($updown != "up") { echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=../down.php?message=".$updown."'>";}

if(!isset($_SESSION)){session_start();}
if(!isset($_SESSION['user_id']))
{ 
$whitelist = array('http://localhost','localhost', '127.0.0.1');

if(!in_array($_SERVER['HTTP_HOST'], $whitelist)){
    echo "<script>alert('".$SERVER['HTTP_HOST']."');</script>";
    
    // not valid

    //Destroy anything they have in their old session.
    session_destroy();
    //If they do not have an active session we redirect them to the login page
    echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=../login.php'>";
    //Kill current page since the user needs to login first
    exit();
}
$_SESSION['user_id'] = "1";
$user_id = $_SESSION['user_id'];
$_SESSION['user_name'] = "Admin Auto Login";
}
else{
}

?>