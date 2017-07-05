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
<h3>Ürün Bul</h3>

<?php echo '<input name="SearchKey" class="w3-input w3-border w3-left" type="search" placeholder="Arama" value="' . $SearchKey . '"/>'; ?>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Ara</button>
<span id="toExcel" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">Excel</span>

</form>

<?php
if(!isset($_GET["SearchKey"])) {
	$conn->close();
	include('tail.php');
	exit;
}

$sql = "SELECT * FROM (Product natural join (Village natural join District)) natural join Farmer ORDER BY FarmerName, FarmerSurname ASC";
$rslt = $conn->query($sql);
$conn->close();

if($rslt->num_rows == 0) {
	echo '<p class="w3-center w3-text-red">Kayıtlı ürün bulunamadı.</p>';
	include('tail.php');
	exit;
}

$Rows = Search($SearchKey, $rslt);

if(count($Rows) == 0) {
	echo '<p class="w3-center">Aradığınız kriterlerde sonuç bulunamadı.</p>';
	include('tail.php');
	exit;
}

echo '<p class="w3-center">Toplam ' . count($Rows) . ' sonuç bulundu.</p>';
?>

<table class="w3-table-all" id="results">
<tr class="w3-teal">
  <th>Ürün No</th>
  <th>Üretici Adı</th>
  <th>Üretici Soyadı</th>
  <th>İl</th>
  <th>İlçe</th>
  <th>Köy</th>
  <th>Ürün Tipi</th>
  <th>Dekar</th>
  <th>Ada No/Parsel No</th>
  <th class="noExl">Analiz Ekle</th>
  <th class="noExl">Ürün Güncelle</th>
</tr>

<?php
foreach($Rows as $row) {
	$ModalName = "'ShowPlaceList" . $row["ProductID"] . "'";
	echo '<tr>';
	echo '<td>' . $row["ProductID"] . '</td>';
	echo '<td>' . $row["FarmerName"] . '</td>';	
	echo '<td>' . $row["FarmerSurname"] . '</td>';	
	echo '<td>' . $row["CityName"] . '</td>';
	echo '<td>' . $row["DistrictName"] . '</td>';
	echo '<td>' . $row["VillageName"] . '</td>';	
	echo '<td>' . $row["ProductTypeName"] . '</td>';	
	echo '<td>' . $row["Size"] . '</td>';
	echo '<td class="noExl"><span onclick="document.getElementById(' . $ModalName . ').style.display=' . "'block'" . '" class="w3-btn w3-teal w3-round-xlarge" >Göster</span>
<div id="ShowPlaceList' . $row["ProductID"] . '" class="w3-modal">
   <div class="w3-modal-content w3-card-4 w3-border w3-border-green">
     <div class="w3-container w3-light-gray">
	   <h3 class="w3-text-teal w3-border-bottom">' . $row["FarmerName"] . ' ' . $row["FarmerSurname"] . ' üreticisinin Ada No/Parsel No bilgileri</h3>
       <span onclick="document.getElementById(' . $ModalName . ').style.display=' . "'none'" . '" class="w3-button w3-display-topright">&times;</span>
       <p>' . $row["PlaceList"] . '</p>
    </div>
  </div>
</div></td>';
	echo '<td style="display:none">' . $row["PlaceList"] . '</td>';
	echo '<td class="noExl"><a class="w3-btn w3-teal w3-round-xlarge" href="AddAnalysis.php?ProductID=' . $row["ProductID"] . '">Analiz Ekle</a></td>';	
	echo '<td class="noExl"><a class="w3-btn w3-teal w3-round-xlarge" href="UpdateProduct.php?ProductID=' . $row["ProductID"] . '">Güncelle</a></td>';	
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
    		name: "Ürünler",
    		filename: "Ürünler"
		});
	});
</script>

<?php include('tail.php'); ?>