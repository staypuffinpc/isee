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
$user_id = $_SESSION['user_id'];
$module = $_SESSION['module'];



$query_assessment = "select 
	u.user_name,
	ua.user_id,
	a.assessment_id,
	a.assessment_type,
	ua.user_answer,
	a.assessment_order,
	a.assessment_text,
	a.assessment_response 
from 
	User_Assessment ua,
	Users u,
	Assessment a
where
 	ua.user_id = u.user_id
 	and
 	ua.assessment_id = a.assessment_id
order by
	ua.assessment_id asc,
	ua.user_id asc"; //mysql query variable
$list_assessment = mysql_query($query_assessment) or die(mysql_error()); //execute query
$assessment = mysql_fetch_assoc($list_assessment);//gets info in array

$query_assessment_order = "select * from Assessment where assessment_module = '$module' order by assessment_order asc";
$list_assessment_order = mysql_query($query_assessment_order) or die(mysql_error()); //execute query
$assessment_order = mysql_fetch_assoc($list_assessment_order);//gets info in array
$assessment_count = mysql_num_rows($list_assessment_order); //gets number of links

$answers = array();
$users = array();
$usercount = 0;

do {
	if(in_array($assessment['user_id'], $users)){} else {$users[] = $assessment['user_id']; $usercount++;}
	$answers[$assessment['user_id']][$assessment['assessment_order']."t"] = $assessment['assessment_type'];
	echo <<<EOF
		<div id = "assessment_text{$assessment['assessment_order']}" class="assessment-text">
		{$assessment['assessment_order']}. {$assessment['assessment_text']} <br /> {$assessment['assessment_response']}
		</div>
EOF;

	 
	$answers[$assessment['user_id']][0] = $assessment['user_name'];
	$answers[$assessment['user_id']][$assessment['assessment_order']] = $assessment['user_answer'];
} while ($assessment = mysql_fetch_assoc($list_assessment));

?>

<h2>Assessment Data</h2>
<div id="tabular-data-table">
<table id="tabular-data">
<tr>
<td class='header' width="200px">Name</td>
<?
do {
	echo "<td class='header width-setter ".$assessment_order['assessment_order']."' id='".$assessment_order['assessment_order']."'>".$assessment_order['assessment_order']."</td>";
	}
while ($assessment_order = mysql_fetch_assoc($list_assessment_order));

?>


</tr>

<?




for ($i=0; $i<$usercount; $i++) {
	echo "<tr>";
	for ($j=0; $j<=$assessment_count; $j++) {
		if ($j == 0) {	echo "<td>".$answers[$users[$i]][$j]."</td>"; }
		
		else {
		switch ($answers[$users[$i]][$j."t"]) {
			case NULL:
				echo "<td></td>";
				break;
			case "Multiple Choice":
				echo "<td style='text-align:center;'>";
				switch ($answers[$users[$i]][$j]) {
					case 0:
						echo "A";
						break;
					case 1:
						echo "B";
						break;
					case 2:
						echo "C";
						break;
					case 3:
						echo "D";
						break;
					case 4:
						echo "E";
						break;
					case 5:
						echo "F";
						break;
					case 6:
						echo "G";
						break;
					case 7:
						echo "H";
						break;
					case 8:
						echo "I";
						break;
					case 9:
						echo "J";
						break;
					case 10:
						echo "K";
						break;
					case 11:
						echo "L";
						break;
				} //end switch
				echo "</td>";
			break;
			case "True or False":
				echo "<td style='text-align:center;'>";
				if ($answers[$users[$i]][$j] == 0) {echo "T";}
				if ($answers[$users[$i]][$j] == 1) {echo "F";}
				echo "</td>";
				break;
			case "Short Answer":
				echo "<td title='".$answers[$users[$i]][$j]."'  style='text-align:center;'>?</td>";	
				break;
			case "Fill in the Blank":
				echo "<td title='".$answers[$users[$i]][$j]."'  style='text-align:center;'>?</td>";	
				break;
		} //end switch
		} //end else
		} //end for
	echo "</tr>";
} //end for


?></table>
</div>
<div id="tabular-data-info">
	<div id="inner">
	Click on a Question Number at the top to see the question text.
	</div>
</div>
<script>
	$("tr:odd").css("background-color", "#CCCCCC");
	child = 0;
	$("td").click(function(){
		$("tr:odd td:nth-child("+child+")").css("background-color","#CCCCCC");
		$("tr:even td:nth-child("+child+")").css("background-color","#FFFFFF");

		$("tr:odd").css("background-color", "#CCCCCC");
		$("tr:even").css("background-color", "#FFFFFF");
		child = $(this).index()+1;
		target = child-1;
		$("tr td:nth-child("+child+")").css("background-color","#FFFFCC");
		$("#inner").html($("#assessment_text"+target).html());
	});
</script>
