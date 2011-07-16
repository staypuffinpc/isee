<?php
# Logging in with Google accounts requires setting special identity, so this example shows how to do it.
require 'openid.php';
try {
    $openid = new LightOpenID;
    $openid->required = array('contact/email','namePerson','media/image/default');
	
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://me.yahoo.com/';
            header('Location: ' . $openid->authUrl());
        }

    } elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()){
            $userAttributes = $openid->getAttributes();
            $user_image = $userAttributes['media/image/default'];

            $email = $userAttributes['contact/email'];
            $user_profile = $openid->identity;
         	$user_name = $userAttributes['namePerson'];
         	$provider = "yahoo";
       		include_once('../../../../connectFiles/connectProject301.php');
			$link=connect(); //call function from external file to connect to database


			$query = "Select * From Users Where user_email='$email' and provider='yahoo'";
			$list = mysql_query($query) or die(mysql_error()); //execute query
			$user = mysql_fetch_assoc($list);//gets info in array

if ($user['user_id'] == NULL) { // this is to replace the previous gigya login
	
	$message = $user_name.", your user information has been added to the system.";
	$query = "INSERT INTO Users (user_id, user_name, user_email, user_profile, UID, provider, created, role) VALUES (null,'$user_name','$email','$user_profile','$UID','yahoo',NOW(), 'Student')";
	$list = mysql_query($query) or die(mysql_error()); //execute query
	
	$query = "Select * From Users Where user_email='$email' and provider='yahoo'";
	$list = mysql_query($query) or die(mysql_error()); //execute query
	$user = mysql_fetch_assoc($list);//gets info in array
}

else {

$query = "Update Users Set user_profile='$user_profile', last_access=NOW(), user_image='$user_image' where user_email='$email' and provider='yahoo'";
$list = mysql_query($query) or die(mysql_error()); //execute query
$message = "Welcome back, ".$user['user_name'].".";
setcookie("user",$user['user_name'], time()+3600, "/",".byuipt.net");

}



if(!isset($_SESSION)){session_start();}
$_SESSION['user_id'] = $user_id = $user['user_id'];
$_SESSION['user_name'] = $user['user_name'];
if ($user['admin'] == 1) {$_SESSION['admin'] = "yes";}
include_once('dashboard.php');
         }
        else{
            echo "user has not logged in";
        }
        //echo 'User ' . ( ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}




