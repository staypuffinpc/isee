<?php 
	function connect() {
		$user="benmcmur_301";
		$host="box680.bluehost.com";
		$password="Pr0j3ct301";
		$database="benmcmur_project301";
		mysql_connect($host,$user,$password);
		$link = mysql_connect($host,$user,$password)
       		 or die("Could not connect" . mysql_error());
		mysql_select_db($database);
		return $link;
	}
?>