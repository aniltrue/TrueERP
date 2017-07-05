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
$sql = "SELECT * FROM Grup ORDER BY GrupName ASC";
$Grups = $conn->query($sql);

if($Grups->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Grup eklemeniz gerekiyor.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}

$rslt = $conn->query("SELECT * FROM Farmer WHERE TCID='" . $TCID . "'");
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Üretici bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Farmer = $rslt->fetch_assoc();

if(isset($_POST["Save"])) {
	if(empty($_POST["FarmerName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üretici Adı kısmı boş olamaz!</p></div>';	
		
	if(empty($_POST["FarmerSurname"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Üretici Soyadı kısmı boş olamaz!</p></div>';	
	
	if(empty($_POST["GrupName"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Grup seçmeniz gerekiyor!</p></div>';
		
	if(empty($_POST["Phone"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Telefon kısmı boş olamaz!</p></div>';	
		
	if(!empty($_POST["FarmerName"]) && !empty($_POST["FarmerSurname"]) && !empty($_POST["GrupName"]) && !empty($_POST["Phone"])) {
		$FarmerName = $conn->real_escape_string($_POST["FarmerName"]);
		$FarmerSurname = $conn->real_escape_string($_POST["FarmerSurname"]);
		$GrupName = $conn->real_escape_string($_POST["GrupName"]);
		$Phone = $conn->real_escape_string($_POST["Phone"]);
		
		$sql = "UPDATE Farmer SET FarmerName = '" . $FarmerName . "', FarmerSurname = '" . $FarmerSurname . "', GrupName = '" . $GrupName . "', Phone = '" . $Phone . "' WHERE TCID = '" . $TCID . "'";
		$rslt = $conn->query($sql);
		
		if($rslt == 1) {
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $TCID . '</b> nolu üretici başarıyla güncellendi.</p></div>';
			$rslt = $conn->query("SELECT * FROM Farmer WHERE TCID='" . $TCID . "'");
			if($rslt->num_rows == 0) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Üretici bulunamadı.</p></div>';
				$conn->close();
				include('tail.php');
				exit;
			}
			$Farmer = $rslt->fetch_assoc();
		}
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Üreticiyi Güncelle</h3>
 
<div class="w3-row w3-section">
	<p>TC Kimlik No</p>
	<?php echo '<input class="w3-input w3-border" name="TCID" value="' . $TCID . '" type="text" disabled />' ?>
</div>

<div class="w3-row w3-section">
	<p>Ad</p>
	<?php echo '<input class="w3-input w3-border" name="FarmerName" value="' . $Farmer["FarmerName"] . '" type="text" placeholder="Ad" />' ?>
</div>

<div class="w3-row w3-section">
	<p>Soyad</p>
	<?php echo '<input class="w3-input w3-border" name="FarmerSurname" value="' . $Farmer["FarmerSurname"] . '" type="text" placeholder="Soyad" />' ?>
</div>

<div class="w3-row w3-section">
	<p>Grup</p>
	<select class="w3-select w3-border" name="GrupName">
        <?php
			while($row = $Grups->fetch_assoc()) {
				if($row["GrupName"] == $Farmer["GrupName"])
					echo '<option value="' . $row["GrupName"] . '" selected>' . $row["GrupName"] . '</option>';
				else
					echo '<option value="' . $row["GrupName"] . '">' . $row["GrupName"] . '</option>';
			}
		?>
    </select>
</div>

<div class="w3-row w3-section">
	<p>Telefon</p>
	<?php echo '<input class="w3-input w3-border" name="Phone" value="' . $Farmer["Phone"] . '" type="text" placeholder="5001234567" />' ?>
</div>

<div class="w3-row w3-section">
	<p>Kayıt Tarihi</p>
	<?php echo '<input class="w3-input w3-border" value="' . $Farmer["StartDate"] . '" type="text" disabled />' ?>
</div>

<span onclick="document.getElementById('RemoveFarmer').style.display='block'" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Üreticiyi Sil</span>

<div id="RemoveFarmer" class="w3-modal">
   <div class="w3-modal-content w3-card-4 w3-border w3-border-green">
     <div class="w3-container w3-light-gray">
	   <h3 class="w3-text-red w3-border-bottom">Dikkat!</h3>
       <span onclick="document.getElementById('RemoveFarmer').style.display='none'" class="w3-button w3-display-topright">&times;</span>
       <p>Üreticiyi silmek istediğinizden emin misiniz?<br />Sildiğiniz takdirde bu üreticiye bağlı bütün veriler tamamen silinecektir.</p>
       <?php echo '<a href="RemoveFarmer.php?TCID=' . $TCID . '" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin">Sil</a>' ?>
       <span onclick="document.getElementById('RemoveFarmer').style.display='none'" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">İptal</span>
    </div>
  </div>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Üreticiyi Güncelle</button>

</form>

<?php include('tail.php'); ?>