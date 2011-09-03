<?
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$requestingURL = $_SERVER['SERVER_NAME'];
if ($requestingURL == 'localhost') {
	include_once("/Users/Ben/Sites/connectFiles/connectProject301.php");
	}
else {
	include_once("/home4/byuiptne/connectFiles/connectProject301.php");
	
	}
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$query = "Select * from Users"; //mysql query variable
$list = mysql_query($query) or die(mysql_error()); //execute query

function using_ie() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $ub = False; 
    if(preg_match('/MSIE/i',$u_agent)) 
    { 
        $ub = True; 
    } 
    
    return $ub; 
} 

function ie_box() {
    if (using_ie()) {
        ?>
            <div id="box">
        	<h1>Please use a different Web Browser</h1>
           <p>This website does not work properly on Internet Explorer. Please use Firefox, Safari, or Chrome. Follow the links below to download one of them if you do not have them on your computer.</p>
           <div id="images">
           <a href='http://www.mozilla.org/firefox?WT.mc_id=aff_en08&WT.mc_ev=click'><img class='logo' src='http://www.mozilla.org/contribute/buttons/120x240arrow_b.png' alt='Firefox Download Button' border='0' /></a>
       <a href="http://www.apple.com/safari/download/" id="download-safari"> 
					<img class='logo' src="http://images.apple.com/safari/images/button_downloadsafari_20110620.png" width="324" height="119" alt="Safari 5.1 Free download. Mac + PC" /> 
				</a> 
				
				<a id="logo" href="http://www.google.com/chrome"><img class="logo" src="http://www.benmcmurry.com/junk/chrome.png" alt="Google Chrome"></a>
        </div>
        </div>
        </html>
        <?php
    exit;
    }
}


?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0, maximum-scale=1.0, user-scalable=0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>Interactive Story-based Educational Environment</title>
<!-- <link href="styles/style.css" rel="stylesheet" type="text/css" /> -->
<link href="styles/login.css" rel="stylesheet" type="text/css" />
<link href="editor.css" rel="stylesheet" type="text/css" />


<link href='http://fonts.googleapis.com/css?family=Antic|Fanwood+Text|Voltaire|Alice|Merriweather|Playfair+Display|Varela|Josefin+Slab|Federo|Artifika|Copse|Philosopher|Goudy+Bookletter+1911|Tinos|Brawler|Kreon|Neuton|Vollkorn|Quattrocento|Gentium+Basic|Special+Elite' rel='stylesheet' type='text/css'>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>	



<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="editor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	$('html').keyup(function(e) {
		if (e.keyCode == '112') {
			$("#admin").fadeIn();
			$("#password").focus();
		}
		
	});

});
</script>
</head>
<body>
<?


ie_box();
?>

<div id="splash">
<img id="teacher-splash" src="img/teacher-splash.png" />
<div id="title">ISEE</div>
<div id="login-Icons">
<div id="login">login with</div>
<a href="dashboard/google.php?login"><img class="icons" src="img/google.png" /></a>
<a href="dashboard/yahoo.php?login"><img class="icons" src="img/yahoo.png" /></a>
<a href="dashboard/facebook.php?login"><img class="icons" src="img/facebook.png" /></a>


</div> <!-- end loginIcons -->
</div> <!-- end splash --> 
<div id="title2">Interactive Story-Based Educational Environment</div>
<!-- editor elements -->
<?
$options = <<<EOF
<option style="font-family:'Celtic Hand'" value="Celtic Hand">Celtic Hand</option>

<option style="font-family:'Antic'" value="Antic">Antic</option>
<option style="font-family:'Fanwood Text'" value="Fanwood Text">Fanwood Text</option>
<option style="font-family:'Voltaire'" value="Voltaire">Voltaire</option>
<option style="font-family:'Alice'" value="Alice">Alice</option>
<option style="font-family:'Merriweather'" value="Merriweather">Merriweather</option>
<option style="font-family:'Playfair Display'" value="Playfair Display">Playfair Display</option>
<option style="font-family:'Varela'" value="Varela">Varela</option>
<option style="font-family:'Josefin Slab'" value="Josefin Slab" selected>Josefin Slab</option>
<option style="font-family:'Federo'" value="Federo">Federo</option>
<option style="font-family:'Artifika'" value="Artifika">Artifika</option>
<option style="font-family:'Copse'" value="Copse">Copse</option>
<option style="font-family:'Philosopher'" value="Philosopher">Philosopher</option>
<option style="font-family:'Goudy Bookletter 1911'" value="Goudy Bookletter 1911">Goudy Bookletter 1911</option>
<option style="font-family:'Tinos'" value="Tinos">Tinos</option>
<option style="font-family:'Brawler'" value="Brawler">Brawler</option>
<option style="font-family:'Kreon'" value="Kreon">Kreon</option>
<option style="font-family:'Neuton'" value="Neuton">Neuton</option>
<option style="font-family:'Vollkorn'" value="Vollkorn">Vollkorn</option>
<option style="font-family:'Quattrocento'" value="Quattrocento">Quattrocento</option>
<option style="font-family:'Gentium Basic'" value="Gentium Basic">Gentium Basic</option>
<option style="font-family:'Special Elite'" value="Special Elite">Special Elite</option>

EOF;

?>
<div id="editor">
	<h5>Top Title</h5>
	<label>Font Name</label>
	<select name='title-font' id='title-font'>
		<? echo $options; ?>
	</select>
	<br />
	<label>Font Size: <input style="width:50px" type="text" name='title-size' id='title-size' /></label>
	<br />
	<label>Font Color: <input style="width:50px" type="text" id="title-color" value="000000" /></label>
	<div id="red-title"></div>
	<div id="green-title"></div>
	<div id="blue-title"></div>

	<h5>Login</h5>
	<label>Font Name</label>
	<select name='login-font' id='login-font'>
		<? echo $options; ?>
	</select>
	<br />
	<label>Font Size: <input style="width:50px" style="width:50px" type="text" name='login-size' id='login-size' /></label>
	<br />
	<label>Font Color: <input style="width:50px" type="text" id="login-color" value="000000" /></label>

	<div id="red-login"></div>
	<div id="green-login"></div>
	<div id="blue-login"></div>

	<h5>Bottom Title</h5>
	<label>Font Name</label>
	<select name='title2-font' id='title2-font'>
		<? echo $options; ?>
	</select>
	<br />
	<label>Font Size: <input style="width:50px" type="text" name='title2-size' id='title2-size' /></label>
	<br />
	<label>Font Color: <input style="width:50px" type="text" id="title2-color" value="000000" /></label>

		<div id="red-title2"></div>
	<div id="green-title2"></div>
	<div id="blue-title2"></div>
</div>

<div id="color">
	<div class="color-stuff">bottom color: <input style="width:50px" type="text" name="direct-code" id="direct-code" value="7FFF7F"/></div>
	<div id="red"></div>
	<div id="blue"></div>
	<div id="green"></div>
	
	<div class="color-stuff">bottom color</div>
	<table>
	<tr><td><input type="radio" name="top" value="white" checked>white</input></td>
	<td><input type="radio" name="top" value="black" >black</input></td></tr>
	<tr><td><input type="radio" name="top" value="light-grey" >light-grey</input></td>
	<td><input type="radio" name="top" value="dark-grey" >dark grey</input></td></tr>
	<tr><td><input type="radio" name="top" value="red" >red</input></td>
	<td><input type="radio" name="top" value="yellow" >yellow</input></td></tr>
	<tr><td><input type="radio" name="top" value="blue" >blue</input></td>
	<td><input type="radio" name="top" value="green" >green</input></td></tr>
	</table>
	<input type="radio" name="top" value="none">none</input>
	<div class="color-stuff">From left to right:
	<ul>
	<li>Bottom color height: <input style="width:30px" id="height-value" value="20"></li>
	<li>border-radius: <input style="width:30px" id="radius-value" value="8px"></li>
	<li>shadow size: <input style="width:30px" id="shadow-value" value="10px"></li>
	</ul></div>
	<div id="height"></div>
	<div id="radius"></div>
	<div id="shadow"></div>
</div>
<!-- editor elements -->
<div id="admin">
	<form method="post" action="dashboard/admin.php">
	<label>User</label>
	<select name="user_id">
	<? while ($results = mysql_fetch_assoc($list)) { 
	
		echo "<option value='".$results['user_id']."'>".$results['user_name']."</option>\n";
	} ?>
		</select>
		<label>Password</label>
		<input type="password" id="password" name="password" />
	
	
	
	</form>


</div>
</BODY>

</HTML>