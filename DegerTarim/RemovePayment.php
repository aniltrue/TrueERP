<?php include('head.php'); ?>

<?php
if(isset($_GET["PaymentID"]))
	$PaymentID = trim($_GET["PaymentID"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Ödeme Bilgisi seçmeniz gerekiyor.</p></div>';
	include('tail.php');
	exit;	
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$sql = "DELETE FROM FarmerPayment WHERE PaymentID = " . $PaymentID;
$rslt = $conn->query($sql);
$conn->close();

if($rslt > 0) 
	echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $PaymentID . '</b> nolu ödeme bilgisi başarıyla silindi.</p></div>';
else
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
?>

<?php include('tail.php'); ?>