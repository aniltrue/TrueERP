<?php

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

if(!isset($_GET["SearchKey"])) {
	$conn->close();
	include('tail.php');
	exit;
}

$Rows = search($conn, $SearchSQL, $SpecialSQL);

if(count($Rows) == 0) {
	echo '<p class="w3-center">Aradığınız kriterlerde sonuç bulunamadı.</p>';
	include('tail.php');
	exit;
}
echo '<p class="w3-center">Toplam ' . count($Rows) . ' sonuç bulundu.</p>';

echo '<table class="w3-table-all" id="results">';

echo '<tr class="w3-teal">';
foreach($TableHeader as $TableHeaders) {
  if($TableHeader->IsExl)
    echo '<th><b>' . $TableHeader->Text . '</b></th>';
  else
    echo '<th class="noExl"><b>' . $TableHeader->Text . '</b></th>';
}
echo '</tr>';

foreach($Row as $Rows) {
 echo '<tr>';
 foreach($SearchObject as $SearchObjects) {
   if($TableHeader->IsExl)
    echo '<th>' . $TableHeader->Draw() . '</th>';
   else
    echo '<th class="noExl">' . $TableHeader->Draw() . '</th>';
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
