<?php include('head.php'); ?>

<?php

if(isset($_GET["PaymentID"]))
	$PaymentID = trim($_GET["PaymentID"]);
elseif(isset($_POST["PaymentID"])) 
	$PaymentID = trim($_POST["PaymentID"]);
else {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Önce Ödeme Bilgisi seçmeniz gerekiyor.</p></div>';
	include('tail.php');
	exit;	
}

$conn = new mysqli("localhost:3306", "root", "", "DegerTarim");	
	
if($conn->connect_error)
   	die('<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>Bağlantı hatası: ' . $conn->connect_error . '<br />Tekrar deneyiniz.</p></div>');
	
$conn->query("SET NAMES 'utf8'");

$rslt = $conn->query("SELECT * FROM FarmerPayment WHERE PaymentID=" . $PaymentID);
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Ödeme Bilgisi bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Payment = $rslt->fetch_assoc();

$rslt = $conn->query("SELECT * FROM Farmer WHERE TCID = '" . $Payment["TCID"] . "'");
if($rslt->num_rows == 0) {
	echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Üretici bulunamadı.</p></div>';
	$conn->close();
	include('tail.php');
	exit;
}
$Farmer = $rslt->fetch_assoc();

if(isset($_POST["Save"])) {
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
		
		$sql = "UPDATE FarmerPayment SET Money = " . $Money . ", PaymentDate = '" . $PaymentDate . "', PaymentYear = '" . $PaymentYear . "' WHERE PaymentID = " . $PaymentID;
		$rslt = $conn->query($sql);
		
		if($rslt == 1) {
			echo '<div class="w3-panel w3-green w3-margin w3-animate-opacity"><h3>Tebrikler!</h3><p><b>' . $PaymentID . '</b> nolu ödeme başarıyla güncellendi.</p></div>';
			$rslt = $conn->query("SELECT * FROM FarmerPayment WHERE PaymentID=" . $PaymentID);
			if($rslt->num_rows == 0) {
				echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Dikkat!</h3><p>Ödeme Bilgisi bulunamadı.</p></div>';
				$conn->close();
				include('tail.php');
				exit;
			}
			$Payment = $rslt->fetch_assoc();
		}
		else
			echo '<div class="w3-panel w3-red w3-margin w3-animate-opacity"><h3>Hata!</h3><br /><p>İşlem Başarısız!<br />Lütfen daha sonra tekrar deneyiniz.</p></div>';
	}
}

$conn->close();

?>

<form action="#" method="post" class="w3-container w3-text-green">

<h3>Ödeme Bilgisi Güncelle</h3>

<div class="w3-row w3-section">
	<p>Ödeme Bilgisi No</p>
	<?php echo '<input class="w3-input w3-border" name="PaymentID" type="text" value="' . $PaymentID . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>TC Kimlik No</p>
	<?php echo '<input class="w3-input w3-border" type="text" value="' . $Farmer["TCID"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Üretici Adı ve Soyadı</p>
	<?php echo ' <input class="w3-input w3-border" type="text" value="' . $Farmer["FarmerName"] . ' ' . $Farmer["FarmerSurname"] . '" disabled />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Miktar (TL)</p>
	<?php echo '<input class="w3-input w3-border" value="' . $Payment["Money"] . '" name="Money" type="text" placeholder="00.00" />'; ?>
</div>

<div class="w3-row w3-section">
	<p>Tarih</p>
	<?php echo '<input class="w3-input w3-border" name="PaymentDate" type="date" value="' . $Payment["PaymentDate"] . '" />'; ?> 
</div>

<div class="w3-row w3-section">
	<p>Dönem</p>
	<?php echo '<input class="w3-input w3-border" name="PaymentYear" type="number" placeholder="Yıl" value="' . $Payment["PaymentYear"] . '" />'; ?>
</div>

<span onclick="document.getElementById('RemovePayment').style.display='block'" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin" >Ödeme Bilgisini Sil</span>

<div id="RemovePayment" class="w3-modal">
   <div class="w3-modal-content w3-card-4 w3-border w3-border-green">
     <div class="w3-container w3-light-gray">
	   <h3 class="w3-text-red w3-border-bottom">Dikkat!</h3>
       <span onclick="document.getElementById('RemovePayment').style.display='none'" class="w3-button w3-display-topright">&times;</span>
       <p>Ödeme Bilgisini silmek istediğinizden emin misiniz?<br />Sildiğiniz takdirde bu ödemeye bağlı bütün veriler tamamen silinecektir.</p>
       <?php echo '<a href="RemovePayment.php?PaymentID=' . $PaymentID . '" class="w3-btn w3-teal w3-round-xlarge w3-left w3-margin">Sil</a>' ?>
       <span onclick="document.getElementById('RemovePayment').style.display='none'" class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin">İptal</span>
    </div>
  </div>
</div>

<button class="w3-btn w3-teal w3-round-xlarge w3-right w3-margin" name="Save">Ödeme Bilgisini Güncelle</button>

</form>

<?php include('tail.php'); ?>