<?php include('head.php'); ?>

<?php

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");
$sql = "SELECT * FROM Grup ORDER BY GrupName ASC";
$Grups = $conn->query($sql);

if($Grups->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Grup eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

if(isset($_POST["Create"])) {
	if(empty($_POST["TCID"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>TC Kimlik No kısmı boş olamaz!</p></div>';	
		
	if(empty($_POST["FarmerName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üretici Adı kısmı boş olamaz!</p></div>';	
		
	if(empty($_POST["FarmerSurname"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üretici Soyadı kısmı boş olamaz!</p></div>';	
	
	if(empty($_POST["GrupName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Grup seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["Phone"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Telefon kısmı boş olamaz!</p></div>';	
		
	if(!empty($_POST["TCID"]) && !empty($_POST["FarmerName"]) && !empty($_POST["FarmerSurname"]) && !empty($_POST["GrupName"]) && !empty($_POST["Phone"])) {
		$TCID = $conn->real_escape_string($_POST["TCID"]);
		$FarmerName = $conn->real_escape_string($_POST["FarmerName"]);
		$FarmerSurname = $conn->real_escape_string($_POST["FarmerSurname"]);
		$GrupName = $conn->real_escape_string($_POST["GrupName"]);
		$Phone = $conn->real_escape_string($_POST["Phone"]);
		
		$sql = "INSERT INTO Farmer (TCID, FarmerName, FarmerSurname, GrupName, Phone, StartDate) VALUES('" . $TCID . "', '" . $FarmerName . "', '" . $FarmerSurname . "', '" . $GrupName . "', '" . $Phone . "', now())";
		$rslt = $conn->query($sql);
		
		if($rslt == true) 
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $TCID . '</b> nolu üretici başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Üretici Ekle</h3>
 
<div class="w3-row w3-section">
	<p>TC Kimlik No</p>
	<input class="w3-input w3-border" name="TCID" type="text" placeholder="TC No" />
</div>

<div class="w3-row w3-section">
	<p>Ad</p>
	<input class="w3-input w3-border" name="FarmerName" type="text" placeholder="Ad" />
</div>

<div class="w3-row w3-section">
	<p>Soyad</p>
	<input class="w3-input w3-border" name="FarmerSurname" type="text" placeholder="Soyad" />
</div>

<div class="w3-row w3-section">
	<p>Grup</p>
	<select class="w3-select w3-border" name="GrupName">
    	<option value="" disabled selected>Lütfen bir grup seçiniz</option>
        <?php
			while($row = $Grups->fetch_assoc()) 
				echo '<option value="' . $row["GrupName"] . '">' . $row["GrupName"] . '</option>';
			
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Telefon</p>
	<input class="w3-input w3-border" name="Phone" type="text" placeholder="5001234567" />
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Üreticiyi Ekle</button>

</form>

<?php include('tail.php'); ?>