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

$user="project301";
		$host="127.0.0.1";
		$password="Pr0j3ct301";
		$database="project301";
		$dbname   = "DATABASENAME";
$dumpfile = $dbname . "_" . date("Y-m-d_H-i-s") . ".sql";


passthru("/usr/bin/mysqldump --opt --host=$host --user=$user --password=$password $dbname > $dumpfile");

echo "$dumpfile "; passthru("tail -1 $dumpfile");

echo $user;
?>