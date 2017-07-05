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

$rslt = $conn->query("SELECT * FROM Farmer WHERE TCID = '" . $TCID . "'");
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Üretici bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Farmer = $rslt->fetch_assoc();

if(isset($_POST["Create"])) {
	if(empty($_POST["Money"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Miktar (TL) kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["PaymentDate"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Tarih kısmı boş olamaz!</p></div>';
		
	if(empty($_POST["PaymentYear"]))
		echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><br /><p>Dönem kısmı boş olamaz!</p></div>';
		
	if(!empty($_POST["Money"]) && !empty($_POST["PaymentDate"]) && !empty($_POST["PaymentYear"])) {
		$Money = $conn->real_escape_string($_POST["Money"]);
		$PaymentDate = $conn->real_escape_string($_POST["PaymentDate"]);
		$PaymentYear = $conn->real_escape_string($_POST["PaymentYear"]);
		
		$sql = "INSERT INTO FarmerPayment (TCID, Money, PaymentDate, PaymentYear) VALUES ('" . $TCID . "', " . $Money . ", '" . $PaymentDate . "', '" . $PaymentYear . "')";
		$rslt = $conn->query($sql);
		
		if($rslt == true)
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p>Ödeme Bilgisi başarıyla eklendi.</p></div>';
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();

?>

<form action="#" method="post" class="w3-container w3-text-green">
<h3>Ödeme Bilgisi Ekle</h3>

<div class="w3-row w3-section">
	<p>TC Kimlik No</p>
	<?php echo '<input class="w3-input w3-border" name="TCID" type="text" value="' . $TCID . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Üretici Adı ve Soyadı</p>
	<?php echo ' <input class="w3-input w3-border" type="text" value="' . $Farmer["FarmerName"] . ' ' . $Farmer["FarmerSurname"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Miktar (TL)</p>
	<input class="w3-input w3-border" name="Money" type="text" placeholder="00.00" />
</div>

<div class="w3-row w3-section">
	<p>Tarih</p>
	<?php 
	$now = new DateTime('now');
	echo '<input class="w3-input w3-border" name="PaymentDate" type="date" value="' . $now->format("Y-m-d") . '" />'; 
	?>
</div>

<div class="w3-row w3-section">
	<p>Dönem</p>
	<?php
    echo '<input class="w3-input w3-border" name="PaymentYear" type="number" placeholder="Yıl" value="' . $now->format("Y") . '" />';
	?>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Create">Ödeme Bilgisini Ekle</button>

</form>

<?php include('tail.php'); ?>