<!DOCTYPE html>
<html>
<head>
<style type="text/css">

#wrapper {
	background-color: #333333;
	right: 0px;
	left: 0px;
	bottom: 0px;
	top: 0px;
	position: absolute;
}

#scroller {
	background-color: #cccccc;
	right: 20px;
	left: 20px;
	bottom: 20px;
	top: 20px;
	position: absolute;
}

</style>
<title>
</title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="../../styles/story.css" rel="stylesheet" type="text/css" />
<link href="../../styles/stylist.css" rel="stylesheet" type="text/css" />
<!-- <link href="../../styles/touchscroll.css" rel="stylesheet" type="text/css" /> -->
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/story.js"></script>
<script type="text/javascript" src="../../js/jquery-scroll.js"></script>
<script type="text/javascript" src="../../js/iscroll.js"></script>

</head>
<body>
<div id="wrapper">
	<div id="scroller">
	<? include("map.php"); ?>
	
	</div>
</div>

<script> var myScroll = new iScroll('wrapper');</script>
</body>
</html>
