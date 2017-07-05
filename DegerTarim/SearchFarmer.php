<?php 
include('head.php');
include('search.php');
?>

<?php
$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$SearchKey = "";

if(isset($_GET["SearchKey"])) {
	$SearchKey = trim($_GET["SearchKey"]);
}
?>

<form action="#" method="get" class="w3-container w3-text-green">
<h3>Üretici Bul</h3>

<?php echo '<input name="SearchKey" class="w3-input w3-border" type="search" placeholder="Arama" value="' . $SearchKey . '"/>'; ?>


<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Ara</button>
<span id="toExcel" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Excel</span>

</form>

<?php
if(!isset($_GET["SearchKey"])) {
	$conn->close();
	include('tail.php');
	exit;
}

$sql = "SELECT * FROM Farmer ORDER BY FarmerName, FarmerSurname ASC";
$rslt = $conn->query($sql);

if($rslt->num_rows == 0) {
	echo '<p class="w3-center w3-text-red">Kayıtlı üretici bulunamadı.</p>';
	$conn->close();
	include('tail.php');
	exit;
}

$Rows = SearchFarmer($SearchKey, $rslt, $conn);
$conn->close();

if(count($Rows) == 0) {
	echo '<p class="w3-center">Aradığınız kriterlerde sonuç bulunamadı.</p>';
	include('tail.php');
	exit;
}

echo '<p class="w3-center">Toplam ' . count($Rows) . ' sonuç bulundu.</p>';
?>

<table class="w3-table-all" id="results">
<tr class="w3-teal">
  <th>TC Kimlik No</th>
  <th>Üretici Adı</th>
  <th>Üretici Soyadı</th>
  <th>Grup Adı</th>
  <th>Telefon</th>
  <th>Kayıt Tarihi</th>
  <th class="noExl">Ürün Ekleme</th>
  <th class="noExl">Üreticiyi Güncelle</th>
  <th class="noExl">Ödeme Bilgisi Ekleme</th>
</tr>

<?php
foreach($Rows as $row) {
	echo '<tr>';
	echo '<td>' . $row["TCID"] . '</td>';
	echo '<td>' . $row["FarmerName"] . '</td>';	
	echo '<td>' . $row["FarmerSurname"] . '</td>';	
	echo '<td>' . $row["GrupName"] . '</td>';	
	echo '<td>' . $row["Phone"] . '</td>';	
	echo '<td>' . $row["StartDate"] . '</td>';
	echo '<td class="noExl"><a class="w3-btn w3-teal w3-round-xlarge" href="AddProduct.php?TCID=' . $row["TCID"] . '">Ürün ekle</a></td>';
	echo '<td class="noExl"><a class="w3-btn w3-teal w3-round-xlarge" href="UpdateFarmer.php?TCID=' . $row["TCID"] . '">Güncelle</a></td>';
	echo '<td class="noExl"><a class="w3-btn w3-teal w3-round-xlarge" href="AddPayment.php?TCID=' . $row["TCID"] . '">Ödeme bilgisi ekle</a></td>';	
	echo '</tr>';
}

?>

</table>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

<script type="text/javascript">
	$("#toExcel").click(function(){
		$("#results").table2excel({
    		exclude: ".noExl",
    		name: "Üreticiler",
    		filename: "Üreticiler"
		});
	});
</script>

<?php include('tail.php'); ?>