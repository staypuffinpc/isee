<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/project/authenticate.php");
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/public_html/301/project/authenticate.php");
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story_id = $_SESSION['story'];
$query = "Select * from Stories where story_id='$story_id'";
$run = mysql_query($query) or die(mysql_error());
$story_info = mysql_fetch_assoc($run);








?>
<!DOCTYPE HTML>
<html>
<head>
<title>Quiz Editor: <? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />


<link href="quiz.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="quiz.js"></script>

</head>
<body>
<div id="header">Quiz Editor: <? echo $story_info['story_topic']; ?>: <? echo $story_info['story_name']; ?>
<a id="home" href="../index.php"></a>
<a class="btn" id="logoutFromMenu">Logout</a>
<div id="greeting"><img src="../<? echo $_SESSION['user_image']; ?>" /><? echo $_SESSION['user_name']; ?></div>

</div>
<div id="toolbar">
<a class="btn" id="newItem">Add New Item</a>
</div>

<div id="viewport">
<div class="content">

<ul id="item-list"></ul>
</div>
</div>

</script>
<div id="ajax">Processing<img src="../../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

<div id="update"></div>
</body>



</html>