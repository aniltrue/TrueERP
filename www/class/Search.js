function ToExcel(){
	$("#results").table2excel({
   		exclude: ".noExl",
   		name: document.getElementById('ObjectName').textContent,
   		filename: document.getElementById('ObjectName').textContent
	});
}

function DisplaySearchPopup() {
	document.getElementById('SearchPopup').style.display='block';
}

function CloseSearchPopup() {
	document.getElementById('SearchPopup').style.display='none';
}

function PopWindow(url, title) {
	var width = 1024;
	var height = 768;
	var leftPosition, topPosition;
	leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
	topPosition = (window.screen.height / 2) - ((height / 2) + 50);
	
	window.open(url, title, "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,location=no,directories=no");
}
