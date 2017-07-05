<?php include('head.php'); ?>

<?php
$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");
$sql = "SELECT * FROM District ORDER BY CityName, DistrictName ASC";
$Districts = $conn->query($sql);

if($Districts->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce İlçe eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

if(isset($_POST["Create"])) {
	if(empty($_POST["DistrictID"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>İlçe seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["VillageName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Köy Adı kısmı boş olamaz!</p></div>';	
		
	if(!empty($_POST["VillageName"]) && !empty($_POST["DistrictID"])) {
		$VillageName = $conn->real_escape_string(trim($_POST["VillageName"]));
		$DistrictID = $_POST["DistrictID"];
		
		$sql = "INSERT INTO Village (DistrictID, VillageName) VALUES(" . $DistrictID . ", '" . $VillageName . "')";
		$rslt = $conn->query($sql);
		
		if($rslt == true) 
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $VillageName . '</b> köyü başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();
?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Köy Ekle</h3>
 
<div class="w3-row w3-section">
	<p>İlçe Adı</p>
    <select class="w3-select w3-border" name="DistrictID">
    	<option value="" disabled selected>Lütfen bir ilçe seçiniz</option>
        <?php
			while($row = $Districts->fetch_assoc()) 
				echo '<option value="' . $row["DistrictID"] . '">' . $row["CityName"] . ' - ' . $row["DistrictName"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Köy Adı</p>
	<input class="w3-input w3-border" name="VillageName" type="text" placeholder="Köy Adı" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Köyü Ekle</button>

</form>


<?php include('tail.php'); ?>