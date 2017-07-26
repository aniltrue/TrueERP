function ToExcel(){
	$("#results").table2excel({
   		exclude: ".noExl",
   		name: <?php echo '"' . $ObjectName . '"'; ?>,
   		filename: <?php echo '"' . $ObjectName . '"'; ?>
	});
}
function DisplaySearchPopup() {
	document.getElementById('SearchPopup').style.display='block';
}
function CloseSearchPopup() {
	document.getElementById('SearchPopup').style.display='none';
}
