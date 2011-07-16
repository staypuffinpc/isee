<?
include_once('../../../../../connectFiles/connectProject301.php');
$link=connect(); //call function from external file to connect to database
include_once('../../authenticate.php');
$module = $_SESSION['module'];

$query = "Select * from Assessment where assessment_module='$module' order by assessment_order ASC";
$run = mysql_query($query) or die(mysql_error());

?>
	<ul id="item-list">
		<?
		while ($results = mysql_fetch_assoc($run)) {
			echo <<<EOF
				<li id='item[{$results['assessment_id']}]' class='ui-state-default' title='{$results['assessment_text']}'>
					<div title='Remove this item' class='minus' id='delete{$results['assessment_id']}'></div>
					<div class='number'>{$results['assessment_order']}. </div>{$results['assessment_type']}
					<div class='editItem' id='edit{$results['assessment_id']}'><img src='../img/edit.png' /><div>
				</li>
EOF;
		} 
		?>
	</ul>
<script>
	function updateOrder() {
		$("ul#item-list li").each(function(){
			data = data+"&"+this.id+"="+$(this).index();
				
		});
		$('li > div.number').each(function(i) {
			var $this = $(this); 
   			$this.text(i+1+". ");
		});

		$.ajax({
			type: "POST",
			url: "actions/update_order.php",
			data: data,
			success: function(phpfile){
			$("#update").append(phpfile);}
		});	
}

var data = "action=sorting";		
$("#item-list").sortable({
placeholder: 'ui-state-highlight',
	stop: function() {
		updateOrder();
	}
});

$(".minus").click(function(){
	var answer = confirm("This action cannot be undone. Are you sure you want to delete this item?");
	if (answer) {
	id = this.id.substr(6)
	$(this).parent().slideToggle(1000, function(){
		$(this).remove();
		$.ajax({
			type: "POST",
			url: "actions/remove_item.php",
			data: "id="+id,
			success: function(phpfile){
			$("#update").append(phpfile);}
		});
		updateOrder();
	});
	}
});



</script>