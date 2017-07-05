<?php include('head.php'); ?>

<?php
if(isset($_GET["TCID"]))
	$TCID = trim($_GET["TCID"]);
elseif(isset($_POST["TCID"])) 
	$TCID = trim($_POST["TCID"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Üretici seçmeniz gerekiyor.</p></div>';
	include('tail.php');
	exit;	
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$ProductTypes = $conn->query("SELECT * FROM ProductType ORDER BY ProductTypeName ASC");
if($ProductTypes->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Ürün Tipi eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

$Villages = $conn->query("SELECT * FROM Village natural join District ORDER BY CityName, DistrictName, VillageName ASC");
if($Villages->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Köy eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

$rslt = $conn->query("SELECT * FROM Farmer WHERE TCID = '" . $TCID . "'");
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Üretici bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Farmer = $rslt->fetch_assoc();

if(isset($_POST["Create"])) {
	if(empty($_POST["ProductTypeName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ürün Tipi kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["VillageID"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Köy kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["Size"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Dekar kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["PlaceList"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Ada No/Parsel No kısmı boş olamaz!</p></div>';
		
	if(!empty($_POST["ProductTypeName"]) && !empty($_POST["VillageID"]) && !empty($_POST["Size"]) && !empty($_POST["PlaceList"])) {
		$ProductTypeName = $conn->real_escape_string($_POST["ProductTypeName"]);
		$VillageID = $conn->real_escape_string($_POST["VillageID"]);
		$Size = $conn->real_escape_string($_POST["Size"]);
		$PlaceList = $conn->real_escape_string($_POST["PlaceList"]);	
		
		$sql = "INSERT INTO Product (TCID, ProductTypeName, VillageID, Size, PlaceList) VALUES ('" . $TCID . "', '" . $ProductTypeName . "', " . $VillageID . ", " . $Size . ", '" . $PlaceList . "')";
		$rslt = $conn->query($sql);
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $TCID . '</b> nolu üreticinin <b>' . $ProductTypeName . '</b> ürünü başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();
?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Ürün Ekle</h3>

<div class="w3-row w3-section">
	<p>TC Kimlik No</p>
	<?php echo '<input class="w3-input w3-border" name="TCID" type="text" value="' . $TCID . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Üretici Adı ve Soyadı</p>
	<?php echo ' <input class="w3-input w3-border" type="text" value="' . $Farmer["FarmerName"] . ' ' . $Farmer["FarmerSurname"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Ürün Tipi</p>
	<select class="w3-select w3-border" name="ProductTypeName">
    	<option value="" disabled selected>Lütfen bir ürün tipi seçiniz</option>
        <?php
			while($row = $ProductTypes->fetch_assoc()) 
				echo '<option value="' . $row["ProductTypeName"] . '">' . $row["ProductTypeName"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Köy</p>
	<select class="w3-select w3-border" name="VillageID">
    	<option value="" disabled selected>Lütfen bir köy seçiniz</option>
        <?php
			while($row = $Villages->fetch_assoc()) 
				echo '<option value="' . $row["VillageID"] . '">' . $row["CityName"] . ' - ' . $row["DistrictName"] . ' - ' . $row["VillageName"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Dekar</p>
	<input class="w3-input w3-border" name="Size" type="text" placeholder="00.00" />
</div>

<div class="w3-row w3-section">
	<p>Ada No/Parsel No</p>
	<input class="w3-input w3-border" name="PlaceList" type="text" placeholder="Ada/Parsel, Ada/Parsel" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Ürünü Ekle</button>

</form>

<?php include('tail.php'); ?>