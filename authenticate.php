<?php
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
        <html>
<head>
<style type="text/css">

.iebox {
	height: 400px;
	width: 600px;
	padding: 10px;
	margin-right: auto;
	margin-left: auto;
	margin-top: 100px;
	color: black;
	background-color: white;
	font-size: 18px;
	font-family: "Lucida Grande", Verdana, Arial, sans-serif;
	-webkit-border-radius: 8px;
	-moz-border-radius: 8px 8px 8px 8px;
	border-radius: 8px;
}

body {
	background-color: #333333;

}

a {
	float: left;

}

#images {
	width: 450px;
	margin-right: auto;
	margin-left: auto;
	text-align: center;
}

h1 {
	text-align: center;
	font-size: 32px;
	margin-bottom: 10px;
	margin-top: 0px;
}

</style>
</head>
        <div class="iebox">
        	<h1>Please use a different Web Browser</h1>
           <p>This website does not work properly on Internet Explorer. Please use Firefox, Safari, or Chrome. Follow the links below to download one of them if you do not have them on your computer.</p>
           <div id="images">
           <a href='http://www.mozilla.org/firefox?WT.mc_id=aff_en08&WT.mc_ev=click'><img src='http://www.mozilla.org/contribute/buttons/120x240arrow_b.png' alt='Firefox Download Button' border='0' /></a>
       <a href="http://www.apple.com/safari/download/" id="download-safari"> 
					<img src="http://images.apple.com/safari/images/button_downloadsafari_20110620.png" width="324" height="119" alt="Safari 5.1 Free download. Mac + PC" /> 
				</a> 
				
				<a id="logo" href="http://www.google.com/chrome"><img class="logo" src="http://www.benmcmurry.com/junk/chrome.png" alt="Google Chrome"></a>
        </div>
        </div>
        </html>
        <?php
    exit;
    }
}

ie_box();

error_reporting(E_ALL);
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
$user_id = $_SESSION['user_id'];
}

?>