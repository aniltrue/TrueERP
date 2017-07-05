<?php include('head.php'); ?>

<?php

if(isset($_GET["ProductID"]))
	$ProductID = trim($_GET["ProductID"]);
elseif(isset($_POST["ProductID"])) 
	$ProductID = trim($_POST["ProductID"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Ürün seçmeniz gerekiyor.</p></div>';
	include('tail.php');
	exit;	
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");
$sql = "SELECT * FROM ProductType ORDER BY ProductTypeName ASC";
$ProductTypes = $conn->query($sql);

if($ProductTypes->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Ürün Tipi eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

$rslt = $conn->query("SELECT * FROM Product natural join Farmer WHERE ProductID='" . $ProductID . "'");
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Ürün bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Product = $rslt->fetch_assoc();

$Villages = $conn->query("SELECT * FROM Village natural join District ORDER BY CityName, DistrictName, VillageName ASC");
if($Villages->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Köy eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

if(isset($_POST["Save"])) {
	if(empty($_POST["ProductTypeName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ürün Tipi seçmeniz gerekiyor!</p></div>';	
		
	if(empty($_POST["VillageID"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Köy seçmeniz gerekiyor!</p></div>';	
	
	if(empty($_POST["Size"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Dekar kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["PlaceList"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ada No/Parsel No kısmı boş olamaz!</p></div>';	
		
	if(!empty($_POST["ProductTypeName"]) && !empty($_POST["VillageID"]) && !empty($_POST["Size"]) && !empty($_POST["PlaceList"])) {
		$ProductTypeName = $conn->real_escape_string($_POST["ProductTypeName"]);
		$VillageID = $conn->real_escape_string($_POST["VillageID"]);
		$Size = $conn->real_escape_string($_POST["Size"]);
		$PlaceList = $conn->real_escape_string($_POST["PlaceList"]);
		
		$sql = "UPDATE Product SET ProductTypeName = '" . $ProductTypeName . "', VillageID = " . $VillageID . ", Size = " . $Size . ", PlaceList = '" . $PlaceList . "' WHERE ProductID = " . $ProductID;
		$rslt = $conn->query($sql);
		
		if($rslt == 1) {
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $ProductID . '</b> nolu ürün başarıyla güncellendi.</p></div>';
			$rslt = $conn->query("SELECT * FROM Product natural join Farmer WHERE ProductID='" . $ProductID . "'");
			if($rslt->num_rows == 0) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Ürün bulunamadı.</p></div>';
				$conn->close();
				include('tail.php');
				exit;
			}
			$Product = $rslt->fetch_assoc();
		}
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
			
	}
}

$conn->close();

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Ürünü Güncelle</h3>
 
<div class="w3-row w3-section">
	<p>Ürün No</p>
	<?php echo '<input class="w3-input w3-border" name="ProductID" value="' . $ProductID . '" type="text" disabled />' ?>
</div>

<div class="w3-row w3-section">
	<p>TC Kimlik No</p>
	<?php echo '<input class="w3-input w3-border" value="' . $Product["TCID"] . '" type="text" disabled />' ?>
</div>

<div class="w3-row w3-section">
	<p>Üretici Adı ve Soyadı</p>
	<?php echo ' <input class="w3-input w3-border" type="text" value="' . $Product["FarmerName"] . ' ' . $Product["FarmerSurname"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Ürün Tipi</p>
	<select class="w3-select w3-border" name="ProductTypeName">
        <?php
			while($row = $ProductTypes->fetch_assoc()) {
				if($row["ProductTypeName"] == $Product["ProductTypeName"])
					echo '<option value="' . $row["ProductTypeName"] . '" selected>' . $row["ProductTypeName"] . '</option>';
				else
					echo '<option value="' . $row["ProductTypeName"] . '">' . $row["ProductTypeName"] . '</option>';
			}
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Köy</p>
	<select class="w3-select w3-border" name="VillageID">
        <?php
			while($row = $Villages->fetch_assoc()) {
				if($row["VillageID"] == $Product["VillageID"])
					echo '<option value="' . $row["VillageID"] . '" selected>' . $row["CityName"] . ' - ' . $row["DistrictName"] . ' - ' . $row["VillageName"] . '</option>';
				else
					echo '<option value="' . $row["VillageID"] . '">' . $row["CityName"] . ' - ' . $row["DistrictName"] . ' - ' . $row["VillageName"] . '</option>';
			}
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Dekar</p>
	<?php echo '<input class="w3-input w3-border" name="Size" type="text" placeholder="00.00" value="' . $Product["Size"] . '" />' ?>
</div>

<div class="w3-row w3-section">
	<p>Ada No/Parsel No</p>
	<?php echo '<input class="w3-input w3-border" name="PlaceList" type="text" placeholder="Ada/Parsel, Ada/Parsel" value="' . $Product["PlaceList"] . '" />' ?>
</div>

<span onclick="document.getElementById('RemoveProduct').style.display='block'" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Ürünü Sil</span>

<div id="RemoveProduct" class="w3-modal">
   <div class="w3-modal-content w3-card-4 w3-border w3-border-green">
     <div class="w3-container w3-light-gray">
	   <h3 class="w3-text-red w3-border-bottom">Dikkat!</h3>
       <span onclick="document.getElementById('RemoveProduct').style.display='none'" class="w3-button w3-display-topright">&times;</span>
       <p>Ürünü silmek istediğinizden emin misiniz?<br />Sildiğiniz takdirde bu ürüne bağlı bütün veriler tamamen silinecektir.</p>
       <?php echo '<a href="RemoveProduct.php?ProductID=' . $ProductID . '" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin">Sil</a>' ?>
       <span onclick="document.getElementById('RemoveProduct').style.display='none'" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">İptal</span>
    </div>
  </div>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Ürünü Güncelle</button>

</form>

<?php include('tail.php'); ?>