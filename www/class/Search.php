<?php
// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], $PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="' . $WorkPlace . 'main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

echo '<label id="ObjectName" style="display:none">' . $ObjectName . '</label>';
?>

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script language="javascript">
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

</script>

<div id="SearchPopup" class="w3-modal">
<div class="w3-modal-content w3-card-4 w3-border w3-border-green">
<div class="w3-container w3-light-gray w3-text-green">

<h3 class="w3-text-teal w3-border-bottom">Arama</h3>
<span onclick="CloseSearchPopup()" class="w3-button w3-display-topright w3-text-teal">&times;</span>

<form action="#" method="post">

<ul class="w3-ul">

<?php
// Get values and Draw and Create SQL Query
$SQL = '';
foreach ($InputObjects as $InputObject) {
	if (isset($_GET[$InputObject->ColumnName]) && $_GET[$InputObject->ColumnName] != '')
		$InputObject->Value = $conn->real_escape_string(trim($_GET[$InputObject->ColumnName]));
	elseif (isset($_POST[$InputObject->ColumnName]) && $_POST[$InputObject->ColumnName] != '')
		$InputObject->Value = $conn->real_escape_string(trim($_POST[$InputObject->ColumnName]));
	
	$InputObject->draw();
	
	if($InputObject->Value === '')
		continue;
	
	if($InputObject->Value === '-')
		$InputObject->Value = '';
		
	$Operator = ' = ';
	if(strpos($InputObject->Value, '%') != false)
		$Operator = ' LIKE ';
		
	if(!empty($SQL))
		$SQL = $SQL . " AND ";
	
	if(empty($InputObject->TableName))
		$SQL = $SQL . $InputObject->ColumnName . $Operator . "'" . $InputObject->Value . "'";
	else
		$SQL = $SQL . $InputObject->TableName . '.' . $InputObject->ColumnName . $Operator . "'" . $InputObject->Value . "'";
}
	
?>
	
</ul>

<button class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" name="Search" id="SearchBtn">Ara</button>

<span class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" id="ClosePopup" onclick="CloseSearchPopup()">İptal</span>

</form>
</div>
</div>
</div>

<span onclick="DisplaySearchPopup();" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Ara</span>

<?php

// Check Search
if(!isset($_GET["Search"]) && !isset($_POST["Search"])) {
	echo '<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" disabled>Excel</span>';
	include('tail.php');
	exit;
} else
	echo '<span onclick="ToExcel()" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Excel</span>';

if(!empty($SQL))
	$SearchSQL = $SearchSQL . ' WHERE ' . $SQL;

// Get results
$Rows = array();
$results = $conn->query($SearchSQL . ' ' . $OrderSQL);
$i = 0;
while($row = $results->fetch_assoc()) {
	$Rows[$i] = $row;
	$i++;
}

// Write results
if(count($Rows) == 0) {
	echo '<p class="w3-center">Aradığınız kriterlerde sonuç bulunamadı.</p>';
	include('tail.php');
	exit;
}
echo '<p class="w3-center">Toplam <b>' . count($Rows) . '</b> sonuç bulundu.</p>';

// Draw tables
echo '<table class="w3-table-all" id="results">';

echo '<tr class="w3-teal">';
foreach($SearchObjects as $SearchObject) {
  if($SearchObject->IsExl)
    echo '<th><b>' . $SearchObject->Text . '</b></th>';
  else
    echo '<th class="noExl"><b>' . $SearchObject->Text . '</b></th>';
}
echo '</tr>';

foreach($Rows as $Row) {
 echo '<tr>';
 foreach($SearchObjects as $SearchObject) {
   if($SearchObject->IsExl)
    echo '<td>' . $SearchObject->Draw($Row) . '</td>';
   else
    echo '<td class="noExl">' . $SearchObject->Draw($Row) . '</td>';
 }
 echo '</tr>';
}

?>

<?php include('tail.php'); ?>
