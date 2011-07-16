<?
$message = $_GET['message'];

?>

<!DOCTYPE >
<html>
<head>
<style type="text/css">

#fullscreen {
	background-color: #333333;
	text-align: center;
	right: 0px;
	left: 0px;
	bottom: 0px;
	top: 0px;
	position: absolute;
}

#message {
	margin: 250px;
	color: white;
	display: inline-block;
}

</style>
<title>Under Maintenance</title></head>
<body>
<div id="fullscreen">
	<div id="message">
	<? echo $message; ?>
	
	</div>

</div>
</body>
</html>