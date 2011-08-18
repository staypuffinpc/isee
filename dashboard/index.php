<?php
include("../authenticate.php");

include_once('../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
$user_id = $_SESSION['user_id'];
include_once('dashboard.php');

?>