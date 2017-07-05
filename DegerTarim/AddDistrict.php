<?php include('head.php'); ?>

<?php
$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");
$sql = "SELECT * FROM City ORDER BY CityName ASC";
$Cities = $conn->query($sql);

if($Cities->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce İl eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

if(isset($_POST["Create"])) {
	if(empty($_POST["CityName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>İl seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["DistrictName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>İlçe Adı kısmı boş olamaz!</p></div>';	
		
	if(!empty($_POST["CityName"]) && !empty($_POST["DistrictName"])) {
		$CityName = $conn->real_escape_string($_POST["CityName"]);
		$DistrictName = $conn->real_escape_string(trim($_POST["DistrictName"]));
		
		$sql = "INSERT INTO District (DistrictName, CityName) VALUES('" . $DistrictName . "', '" . $CityName . "')";
		$rslt = $conn->query($sql);
		
		if($rslt == true) 
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $DistrictName . '</b> ilçesi başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();
?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>İlçe Ekle</h3>
 
<div class="w3-row w3-section">
	<p>İl Adı</p>
    <select class="w3-select w3-border" name="CityName">
    	<option value="" disabled selected>Lütfen bir il seçiniz</option>
        <?php
			while($row = $Cities->fetch_assoc()) 
				echo '<option value="' . $row["CityName"] . '">' . $row["CityName"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>İlçe Adı</p>
	<input class="w3-input w3-border" name="DistrictName" type="text" placeholder="İlçe Adı" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">İlçeyi Ekle</button>

</form>


<?php include('tail.php'); ?>