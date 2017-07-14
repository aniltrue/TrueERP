<?php
// Check Roles
if(!CheckPageRoles($conn, $userInfo[2], $PageName)) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Bu Sayfaya Yetkiniz Yok!</h3><br /><p>Anasayfaya dönmek için <a href="main.php" class="w3-hover-gray">BURAYA</a> tıklayınız.</p></div>';
	include('tail.php');
	exit;
}

// Search box
$SearchKey = "";
if(isset($_GET["SearchKey"])) 
	$SearchKey = trim($_GET["SearchKey"]);

echo '<form action="#" method="get" class="w3-container w3-text-green">'
echo '<h3>$ObjectName Bul</h3>'
echo '<input name="SearchKey" class="w3-input w3-border" type="search" placeholder="Arama" value="' . $SearchKey . '"/>';

?>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Ara</button>
<span id="toExcel" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Excel</span>
</form>

<?php

// Check Search
if(!isset($_GET["SearchKey"])) {
	$conn->close();
	include('tail.php');
	exit;
}

// Get Rows
$Rows = array();
$Keys = explode(" ", $SearchKey);

$i = 0;
$rslt1 = $conn->query($SearchSQL);
while($row = $rslt1->fetch_assoc()) {
	if(empty($SearchKey)) {
		$Rows[$i] = $row;
		$i++;
		continue;
	}
	
	$Text = "";
	foreach($row as $r) {
		$Text = $Text . " " . $r;
	}
	
	$Text = trim($Text);
	$IsValid = true;

	foreach($Keys as $Key) {
		if(!strpos($Text, $Key)) {
			$IsValid = false;
			break;	
		}
	}

	if($IsValid) {
		$Rows[$i] = $row;
		$i++;
	}
}

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
</script>

<?php include('tail.php'); ?>
