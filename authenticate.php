<?php
$updown="up"; //set to up if up, message if down

if ($updown != "up") { echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=../down.php?message=".$updown."'>";}

if(!isset($_SESSION)){session_start();}
if(!isset($_SESSION['user_id']))
{
    //Destroy anything they have in their old session.
    session_destroy();
    //If they do not have an active session we redirect them to the login page
    echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=../login.php'>";
    //Kill current page since the user needs to login first
    exit();
}
else{
}

?>