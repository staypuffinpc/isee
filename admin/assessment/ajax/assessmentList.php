<?
include_once('../../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../../authenticate.php');
$user_id = $_SESSION['user_id'];
$module = $_SESSION['module'];
$query = "Select * from Assessment where assessment_module='$module' order by assessment_order ASC";
$run = mysql_query($query) or die(mysql_error());

$query = "Select page_name, id from Pages where module='$module' and page_type='Teaching'";
$pages = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {
		if (strlen($results['assessment_text']) > 88) {
			$text = substr($results['assessment_text'], 0, 87)." . . .";
		} else $text = $results['assessment_text'];
		echo <<<EOF
			<li id='item[{$results['assessment_id']}]' class='ui-state-default'>
			<div class='number'>{$results['assessment_order']}. </div><div class='type'>{$results['assessment_type']}</div><div class="embeddedNote" 
EOF;
		if($results['embedded'] == 1) {echo "style='padding:1px'>embedded";} else {echo ">";}
		
		echo <<<EOF
		</div><div class="textShort"> - $text</div>
		<div class="item-info"><div class="label">Text: </div><div class="ce text {$results['assessment_id']}" contenteditable>{$results['assessment_text']}</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Response: </div><br />		
EOF;
		switch ($results['assessment_type']) {
			case "Short Answer":
				echo "<div><textarea disabled='disabled' ></textarea>";
				break;
			case "Fill in the Blank":
				echo "<div><input type='text' disabled='disabled' />";
				break;
			case "True or False":
				echo "<div><input type='radio' disabled='disabled'>True<br>
				<input type='radio' disabled='disabled'>False<br>";
				break;
			case "Multiple Choice":
				echo "<div class='theresponse {$results['assessment_id']}'>";
				echo $results['assessment_response'];
				echo "<script>$('.response').attr('contenteditable', true);</script>";		
		}
		
		
		
		echo <<<EOF
		</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Answer: </div><div class="ce answer {$results['assessment_id']}" contenteditable>{$results['assessment_answer']}</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Page: </div><select class="{$results['assessment_id']}"><option>None Selected</option>
EOF;
		while ($resultsPages = mysql_fetch_array($pages)) {
			echo "<option value='".$resultsPages['id']."'";
		if ($resultsPages['id'] == $results['assessment_page']) {echo " selected ";}
		echo ">".$resultsPages['page_name']."</option>";
		}
		echo "</select></div>";
		echo <<<EOF
		<div class="item-info"><div class="label">Embedded: </div><div class='embeddedContainer'>
		<input class='{$results['assessment_id']}' type='checkbox'
EOF;
		if ($results['embedded'] == 1) {echo " checked ";}
		echo "/></div></div>";		
		echo <<<EOF
			<div title='Remove this item' class='delete' id='delete{$results['assessment_id']}'>x</div></li>
EOF;
			
		mysql_data_seek($pages, 0);	
} 
?>
