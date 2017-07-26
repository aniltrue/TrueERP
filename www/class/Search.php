<?php
// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], $PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}
?>

<div id="SearchPopup" class="w3-modal">
<div class="w3-modal-content w3-card-4 w3-border w3-border-green">
<div class="w3-container w3-light-gray w3-text-green">

<h3 class="w3-text-teal w3-border-bottom">Arama</h3>
<span onclick="CloseSearchPopup()" class="w3-button w3-display-topright w3-text-teal">&times;</span>

<form action="#" method="post">

<ul class="w3-ul">

<?php
// Get values and Draw
foreach ($InputObjects as $InputObject) {
	if (isset($_GET[$InputObject->ColumnName]) && !empty($_GET[$InputObject->ColumnName]))
		$InputObject = $conn->real_escape_string(trim($_GET[$InputObject->ColumnName]));
	elseif (isset($_POST[$InputObject->ColumnName]) && !empty($_POST[$InputObject->ColumnName]))
		$InputObject = $conn->real_escape_string(trim($_POST[$InputObject->ColumnName]));
	
	$InputObject->draw();
}
	
?>
	
</ul>

<button class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" name="Search" id="SearchBtn">Ara</button>

<span class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" id="ClosePopup" onclick="CloseSearchPopup()">İptal</span>

</form>
</div>
</div>
</div>

<span onclick="DisplaySearchPopup()" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Ara</span>
<span id="toExcel" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Excel</span>

<?php

// Check Search
if(!isset($_GET["Search"]) && !isset($_POST["Search"])) {
	$conn->close();
	include('tail.php');
	exit;
}

// Create SQL Query
$SQL = '';
foreach ($InputObjects as $InputObject) {
	if(empty($InputObject->Value))
		continue;

	if(empty($SQL))
		$SQL = $SQL . $InputObject->ColumnName . "='" . $InputObject->Value . "'";
	else
		$SQL = $SQL . " AND " . $InputObject->ColumnName . "='" . $InputObject->Value . "'";
}

if(!empty($SQL))
	$SearchSQL = $SearchSQL . ' WHERE ' . $SQL;

// Get results
$Rows = array();
$results = $conn->query($SearchSQL);
$i = 0;
while($row = $results->fetch_assoc()) 
	$Rows[$i] = $row;

// Write results
if(count($Rows) == 0) {
	echo '<p class="w3-center">Aradığınız kriterlerde sonuç bulunamadı.</p>';
	include('tail.php');
	exit;
}
echo '<p class="w3-center">Toplam ' . count($Rows) . ' sonuç bulundu.</p>';

// Draw tables
echo '<table class="w3-table-all" id="results">';

echo '<tr class="w3-teal">';
foreach($SearchObject as $SearchObjects) {
  if($SearchObject->IsExl)
    echo '<th><b>' . $SearchObject->Text . '</b></th>';
  else
    echo '<th class="noExl"><b>' . $SearchObject->Text . '</b></th>';
}
echo '</tr>';

foreach($Row as $Rows) {
 echo '<tr>';
 foreach($SearchObject as $SearchObjects) {
   if($SearchObject->IsExl)
    echo '<td>' . $SearchObject->Draw($Row) . '</td>';
   else
    echo '<td class="noExl">' . $SearchObject->Draw($Row) . '</td>';
 }
 echo '</tr>';
}

?>

<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script type="text/javascript">
$("#toExcel").click(function(){
	$("#results").table2excel({
   		exclude: ".noExl",
   		name: <?php echo '"' . $ObjectName . '"'; ?>,
   		filename: <?php echo '"' . $ObjectName . '"'; ?>
	});
});
	
function DisplaySearchPopup() {
	document.getElementById('SearchPopup').style.display='block';
}
function CloseSearchPopup() {
	document.getElementById('SearchPopup').style.display='none';
}
</script>

<?php include('tail.php'); ?>
